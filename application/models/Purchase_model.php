<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Smart Invoice System
 *
 * A simple and powerful web app based on PHP CodeIgniter framework manage invoices.
 *
 * @package Smart Invoice System
 * @author  Bessem Zitouni (bessemzitouni@gmail.com)
 * @copyright   Copyright (c) 2017
 * @since   Version 1.6.0
 * @filesource
 */

class Purchase_model extends CI_Model
{
    var $table = "purchase";
    var $table_items = "purchase_items";
  

    public function __construct ()
    {
        parent::__construct ();
        $this->load->helper('app');
    }


    public function next_reference($next_count=false, $type=REFERENCE_TYPE, $prefix=PURCHASE_PREFIX, $year=false)
    {
        $year = ( $year == false ) ? date("y") : $year;
        if( $next_count == false ){
            $next_count = $this->settings_model->SYS_Settings->next_purchase_order;
        }
        switch ($type) {
            case 0: $reference = ""; break;
            case 1: $reference = sprintf("%06s", $next_count); break;
            case 2: $reference = $prefix.sprintf("%06s", $next_count); break;
            case 3: $reference = sprintf("%06s", $next_count).$prefix; break;
            case 4: $reference = $prefix.$year.sprintf("%04s", $next_count); break;
            case 5: $reference = strtoupper(substr( md5(rand()), 0, 6)); break;
            case 6: $reference = $prefix.strtoupper(substr( md5(rand()), 0, 6)); break;
        }
        return array("reference"=>$reference, "next_count"=>$next_count);
    }

    public function getPurchaseItems($id){
        $q = $this->db->where('purchase_id', $id)
                    ->get($this->table_items);
        if( $q->num_rows() > 0 )
        {
            return $q->result_array();
        }
        return array();
    }


    public function getPurchase($id){
        $q = $this->db->where('id', $id)
                    ->limit(1)
                    ->get($this->table);
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        }
        return array();
    }


    public function create ($data = array (), $items = array())
    {
        if ( $this->db->insert ( $this->table , $data ) ) {
            $id = $this->db->insert_id ();
            // $this->update_amount_due ($id);
            foreach ($items as $key => $value) {
                $items[$key]['purchase_id'] = $id;
            }
            $this->db->insert_batch($this->table_items, $items);

            return $id;
        }
        return false;
    }

    public function update ($id , $data = array (), $items = array())
    {
        if ( $this->db->where ( 'id' , $id )->update ( $this->table , $data ) ) {

            $this->db->where('purchase_id', $id)->delete($this->table_items);
            $this->update_amount_due ($id);
            foreach ($items as $key => $value) {
                $items[$key]['purchase_id'] = $id;
            }
            if( $this->db->insert_batch($this->table_items, $items) ){
                return $id;
            }
            $this->db->where('id', $id)->delete($table);
        }
        
        return false;
    }

    public function delete ($id)
    {
        if ( $this->db->where_in ( 'id' , $id )->delete ( $this->table ) ) {
            $this->db->where_in('purchase_id', $id)->delete($this->table_items);
            return true;
        }
        return false;
    }

    public function setStatus ($id , $status)
    {
        if ( $this->db->where ( 'id' , $id )->update ( $this->table , array("status" => $status) ) ) {
            return $id;
        }
        return false;
    }

    public function getPurchaseEmails ($id_list = array())
    {
        $q = $this->db
                ->select("email")
                ->join("suppliers", "suppliers.id=purchase.supplier_id", "left")
                ->where_in("purchase.id", $id_list)
                ->group_by("email")
                ->get ( $this->table );
        if ( $q->num_rows () > 0 ) {
            $result = array();
            foreach ($q->result() as $key => $value) {
                $result[] = $value->email;
            }
            return $result;
        }
        return array();
    }

    /* PAYMENTS */
    public function getPaymentsTotal($id){
        $q = $this->db->select('COALESCE(SUM(amount),0) as total')
                    ->where('purchase_id', $id)
                    ->where("status", "released")
                    ->get("purchase_payment");
        if( $q->num_rows() > 0 )
        {
            return $q->row()->total;
        }
        return 0;
    }

    public function update_amount_due ($id)
    {
        $payments = $this->getPaymentsTotal($id);
        $purchase = $this->getPurchase($id);
        $total_due = $purchase->total - $payments;

        if( $total_due <= 0 ){
            $status = "paid";
            $payment_date = date("Y-m-d");
        }else{
            $payment_date = NULL;
            if( $payments > 0 ){
                $status = "partial";
            }
            else if( $purchase->status=="draft" || $purchase->status=="canceled" ){
                $status = $purchase->status;
            }
            else{
                $status = "unpaid";
            }
        }
        $this->db->set("total_due", $total_due)
                 ->set("status", $status)
                 ->set("payment_date", $payment_date)
                 ->where ( 'id' , $id );
        if( $this->db->update($this->table) ){
            return true;
        }
        return false;
    }


    public function suggestions($term){
        if( strlen($term) >= SUGGESTION_LENGTH ){
            $this->db->where('reference', $term)->or_where('reference LIKE', '%'.$term.'%');
        }elseif( strlen($term) < SUGGESTION_LENGTH && strlen($term) > 0 ){
            $this->db->where('reference', $term);
        }
        $q = $this->db->select($this->table.'.*,reference label', false)//
                      ->from($this->table)
                      ->limit(SUGGESTION_MAX)
                      ->get();

        if( $q->num_rows() > 0 ){
            $result = $q->result();
            foreach ($result as $key => $value) {
                $value->biller = $this->getInvoiceBiller($value->bill_to_id);
            }
            return $result;
        }
        return array();
    }

    public function email_reminder($id){
        $this->load->library(array('email'));

        $email_config = objectToArray($this->settings_model->email_Settings);
        $emails       = $this->getInvoicesEmails(array($id));

        $template = $this->settings_model->getEmailTemplate("send_rinvoices_to_customer.tpl", LANGUAGE);
        $company  = $this->settings_model->getSettings("COMPANY");
        $invoice  = $this->invoices_model->getInvoice($id);
        $biller   = $this->biller_model->getByID($invoice->bill_to_id);

        $data['email_content'] = parse_object_sis($template->content, $company, $invoice, $biller);
        $data['show_automatic'] = true;
        $message = $this->load->view("email/standard.tpl.php", $data, true);

        $this->email->initialize($email_config);
        $this->email->clear();
        $this->email->from(COMPANY_EMAIL, COMPANY_NAME);
        $this->email->to($emails);
        $this->email->subject(parse_object_sis($template->subject, $company, $invoice, $biller));
        $this->email->message($message);

        if ( $this->email->send() )
        {
            $this->sis_logger->write('invoices', 'email', $id, "An email is sent to ".implode(",", $emails).".");
            return true;
        }
        return false;
    }

    public function getInvoicesByStatus ($biller_id = false, $status = false, $invoice_id = false)
    {
        $from = "(SELECT invoices.*, IF((invoices.status='unpaid' OR invoices.status='partial') AND invoices.date_due<'".date("Y-m-d")."', 'overdue', invoices.status) as inv_status FROM invoices) as tabla";
        $this->db->select("*");
        if( $status != false ){
            if( is_array($status) ){
                $this->db->where_in("inv_status", $status);
            }else{
                $this->db->where("inv_status", $status);
            }
        }
        if( $invoice_id != false ){
            if( is_array($invoice_id) ){
                $this->db->where_in("id", $invoice_id);
            }else{
                $this->db->where("id", $invoice_id);
            }
        }
        if( $biller_id != false ){
            $this->db->where("bill_to_id", $biller_id);
        }
        $this->db->from( $from , false);
        $q = $this->db->get ();
        if ( $q->num_rows () > 0 ) {
            return $q->result_array();
        }
        return array();
    }

    public function getInvoicesOverdueBy ($days = 0)
    {
        $from = "(SELECT invoices.*, IF((invoices.status='unpaid' OR invoices.status='partial') AND invoices.date_due<'".date("Y-m-d")."', 'overdue', invoices.status) as inv_status FROM invoices) as tabla";
        $this->db->select("*");
        $this->db->where("inv_status", "overdue");
        $this->db->where("DATE_ADD(`date_due` , INTERVAL $days DAY) = ", date("Y-m-d"));
        $this->db->from( $from , false);
        $q = $this->db->get ();
        if ( $q->num_rows () > 0 ) {
            return $q->result();
        }
        return array();
    }

    public function getInvoicesOverdueEvery ($days = 0)
    {
        $from = "(SELECT invoices.*, IF((invoices.status='unpaid' OR invoices.status='partial') AND invoices.date_due<'".date("Y-m-d")."', 'overdue', invoices.status) as inv_status, datediff('".date("Y-m-d")."',`date_due`) as `days` FROM invoices) as tabla";
        $this->db->select("*");
        $this->db->where("inv_status", "overdue");
        $this->db->where("MOD(days,'$days') = ", 0);
        $this->db->from( $from , false);
        $q = $this->db->get ();
        if ( $q->num_rows () > 0 ) {
            return $q->result();
        }
        return array();
    }

    public function sendBillerReminder($biller_id){
        $this->load->library(array('email'));

        $biller       = $this->biller_model->getByID($biller_id);
        $invoices     = $this->getInvoicesByStatus($biller_id, array("partial", "unpaid", "overdue"));
        $total_unpaid = 0;
        $currency     = CURRENCY_FORMAT==1?CURRENCY_PREFIX:CURRENCY_SYMBOL;

        $invoices_count = count($invoices);
        $table =  "<table width='100%'>";
        $table .= "<tr align='left'><th>".lang("reference")."</th><th>".lang("date")."</th><th>".lang("total")."</th><th>".lang("paid")."</th><th>".lang("total_due")."</th></tr>";
        foreach ($invoices as $key => $invoice) {
            $table .= "<tr><td>$invoice[reference]</td><td>$invoice[date]</td><td>".formatMoney($invoice[total], $currency)."</td><td>".formatMoney($invoice["total"]-$invoice["total_due"], $currency)."</td><td>".formatMoney($invoice[total_due], $currency)."</td></tr>";
            $total_unpaid += $invoice["total_due"];
        }
        $table .= "<tr><th colspan='4' align='right'>".lang("total_due")."</th><th>".formatMoney($total_unpaid, $currency)."</th></tr>";
        $table .= "</table>";

        if( $total_unpaid == 0 ){
            return lang("no_unpaid_invoies");
        }

        $template = $this->settings_model->getEmailTemplate("send_customer_reminder.tpl", LANGUAGE);
        $company  = $this->settings_model->getSettings("COMPANY");
        $biller   = $this->biller_model->getByID($biller_id);

        $content  = parse_object_sis($template->content, $company, false, $biller);
        $content  = parse_text_sis($content, "{{count_invoices}}", $invoices_count);
        $content  = parse_text_sis($content, "{{invoices_table}}", $table);

        $email_config = objectToArray($this->settings_model->email_Settings);
        $emails       = array($biller->email);

        $data['email_content'] = $content;
        $data['show_automatic'] = true;
        $message      = $this->load->view("email/standard.tpl.php", $data, true);
        $this->email->initialize($email_config);
        $this->email->clear();
        $this->email->from(COMPANY_EMAIL, COMPANY_NAME);
        $this->email->to($emails);
        $this->email->subject(parse_object_sis($template->subject, $company, false, $biller));
        $this->email->message($message);

        if ( $this->email->send() )
        {
            return true;
        }
        return false;
    }

    public function sendInvoiceReminder($invoice_id){
        $this->load->library(array('email'));

        $invoices = $this->getInvoicesByStatus(false, false, $invoice_id);
        if( count($invoices) == 0 ){
            return;
        }else{
            $invoice = $invoices[0];
        }
        if( $invoice['inv_status'] != "overdue" ){
            return;
        }
        $biller   = $this->biller_model->getByID($invoice['bill_to_id']);
        $template = $this->settings_model->getEmailTemplate("send_overdue_reminder.tpl", LANGUAGE);
        $company  = $this->settings_model->getSettings("COMPANY");

        $email_config = objectToArray($this->settings_model->email_Settings);
        $emails       = array($biller->email);

        $data['email_content'] = parse_object_sis($template->content, $company, $invoice, $biller);
        $data['show_automatic'] = true;
        $message = $this->load->view("email/standard.tpl.php", $data, true);

        $this->email->initialize($email_config);
        $this->email->clear();
        $this->email->from(COMPANY_EMAIL, COMPANY_NAME);
        $this->email->to($emails);
        $this->email->subject(parse_object_sis($template->subject, $company, $invoice, $biller));
        $this->email->message($message);

        if ( $this->email->send() )
        {
            return true;
        }
        return false;
    }



}

/* End of file invoices_model.php */
/* Location: ./application/models/invoices_model.php */
