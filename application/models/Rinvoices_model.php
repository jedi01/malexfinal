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

class Rinvoices_model extends CI_Model
{
    var $table = "recurring_invoices";
    var $table_items = "recurring_invoices_items";

    public function __construct ()
    {
        parent::__construct ();
        log_message('INFO','Model Recurring Invoices Initialized');
        $this->load->helper('app');
    }

    public function getByID($id){
        $q = $this->db->where('id', $id)
                    ->limit(1)
                    ->get($this->table);
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        }
        return array();
    }

    public function getItems($id){
        $q = $this->db->where('recurring_id', $id)
                    ->get($this->table_items);
        if( $q->num_rows() > 0 )
        {
            return $q->result_array();
        }
        return array();
    }

    public function getTodayRecurringInvoices(){
        $q = $this->db->where('next_date', date("Y-m-d"))
                    ->where("status", "active")
                    ->get($this->table);
        if( $q->num_rows() > 0 )
        {
            return $q->result();
        }
        return array();
    }

    public function getPassedRecurringInvoices(){
        $q = $this->db->where('next_date <', date("Y-m-d"))
                    ->where("status", "active")
                    ->get($this->table);
        if( $q->num_rows() > 0 )
        {
            return $q->result();
        }
        return array();
    }

    public function getItemsDetails($id, $limit = false){
        if( $limit ){
            $this->db->limit($limit);
        }
        $q = $this->db->where('recurring_id', $id)
                    ->get($this->table_items);
        if( $q->num_rows() > 0 )
        {
            $rows = $q->result_array();
            foreach ($rows as $key => $row) {
                if( $row['invoice_id'] != NULL ){
                    $inv = $this->invoices_model->getInvoice($row['invoice_id']);
                    $rows[$key]['invoice'] = $inv;
                    $rows[$key]['invoice_items'] = $this->invoices_model->getInvoiceItems($inv->id);
                    $rows[$key]['invoice_taxes'] = $this->invoices_model->getInvoiceTaxes($inv->id);
                    $rows[$key]['invoice_biller'] = $this->biller_model->getByID($inv->bill_to_id);
                }
            }
            return $rows;
        }
        return array();
    }

    public function create ($data = array ())
    {
        if ( $this->db->insert ( $this->table , $data ) ) {
            $id = $this->db->insert_id ();
            return $id;
        }
        return false;
    }

    public function update ($id , $data = array ())
    {
        if ( $this->db->where ( 'id' , $id )->update ( $this->table , $data ) ) {
            return $id;
        }
        return false;
    }

    public function delete ($id)
    {
        if ( $this->db->where_in ( 'id' , $id )->delete ( $this->table ) ) {
            $this->db->where_in('recurring_id', $id)->delete($this->table_items);
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

    public function start ($id){
        $rinvoice = $this->getByID($id);
        // set Status as Active
        $this->setStatus($id, 'active');

        // create first item
        $item = array(
            "recurring_id" => $id,
            "date" => $rinvoice->next_date,
            "skip" => 0,
        );
        $this->create_item($item);
    }

    public function cancel ($id){
        // set Status as Canceled
        $recurring_data['status'] = "canceled";
        $recurring_data['next_date'] = NULL;
        $this->update($id, $recurring_data);

        // Set last item as skipped
        $last_item = $this->get_last_item($id);
        if( $last_item ){
            $this->update_item($last_item->id, array("skip"=>1));
        }
    }

    public function next ($id){
        // Recurring Invoice
        $rinvoice             = $this->getByID($id);
        $rdata                = json_decode($rinvoice->data);

        // Create Invoice
        $invoice              = objectToArray($rdata->invoice);
        $invoice['status']    = $rinvoice->type=="draft"?"draft":"unpaid";
        $invoice['date']      = date("Y-m-d");
        $invoice['recurring_id']= $id;
        $next_reference       = $this->invoices_model->next_reference();
        $invoice['reference'] = $next_reference["reference"];
        $invoice['count']     = $next_reference["next_count"];
        $invoice_items        = objectToArray($rdata->items);
        $invoice_taxes        = objectToArray($rdata->taxes);
        $invoice_id           = $this->invoices_model->create($invoice, $invoice_items, $invoice_taxes);
        $this->sis_logger->write('invoices', 'create', $invoice_id, "invoice is created from recurring Invoice #".$rinvoice->name);
        // Sent invoice email reminder
        if( $rinvoice->type == "sent" ){
            $this->invoices_model->email_reminder($invoice_id);
        }

        // set last item invoice_id
        $last_item = $this->get_last_item($id);
        if( $last_item ){
            $this->update_item($last_item->id, array("invoice_id"=>$invoice_id));
        }

        $create_next = true;
        // Update recurring invoice
        if( $rinvoice->occurence != 0 && $this->count_items($id) == $rinvoice->occurence ){
            $recurring_data['status'] = "finished";
            $recurring_data['next_date'] = NULL;
            $create_next = false;
        }else if( $rinvoice->occurence != 0 && ($this->count_items($id) + 1) == $rinvoice->occurence ){
            $recurring_data['status'] = "finished";
            $recurring_data['next_date'] = NULL;
        }else{
            $recurring_data['next_date'] = date("Y-m-d", strtotime($rinvoice->next_date." +".$rinvoice->number));
        }
        $this->update($id, $recurring_data);

        // create next item
        if( $create_next ){
            $item = array(
                "recurring_id" => $id,
                "date" => $recurring_data['next_date'],
                "skip" => 0,
            );
            $this->create_item($item);
        }
    }

    public function skip_next ($id){
        // Recurring Invoice
        $rinvoice = $this->getByID($id);

        // Set last item as skipped
        $last_item = $this->get_last_item($id);
        $this->update_item($last_item->id, array("skip"=>1));

        $create_next = true;
        // Update recurring invoice
        if( $rinvoice->occurence != 0 && $this->count_items($id) == $rinvoice->occurence ){
            $recurring_data['status'] = "finished";
            $recurring_data['next_date'] = NULL;
            $create_next = false;
        /*}else if( $rinvoice->occurence != 0 && ($this->count_items($id) + 1) == $rinvoice->occurence ){
            $recurring_data['status'] = "finished";
            $recurring_data['next_date'] = NULL;*/
        }else{
            $recurring_data['next_date'] = date("Y-m-d", strtotime($rinvoice->next_date." +".$rinvoice->number));
        }
        $this->update($id, $recurring_data);

        // create next item
        if( $create_next ){
            $item = array(
                "recurring_id" => $id,
                "date" => $recurring_data['next_date'],
                "skip" => 0,
            );
            $this->create_item($item);
        }
    }

    public function get_last_item($id){
        $q = $this->db->where('recurring_id', $id)
                    ->limit(1)
                    ->order_by("id", "desc")
                    ->get($this->table_items);
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        }
        return false;
    }

    public function count_items ($id)
    {
        return $this->db->select("id")->where('recurring_id', $id)->count_all_results ( $this->table_items );
    }

    public function create_item ($data = array ())
    {
        if ( $this->db->insert ( $this->table_items , $data ) ) {
            $id = $this->db->insert_id ();
            return $id;
        }
        return false;
    }

    public function update_item ($id , $data = array ())
    {
        if ( $this->db->where ( 'id' , $id )->update ( $this->table_items , $data ) ) {
            return $id;
        }
        return false;
    }

    public function toString($rinvoice){
        $text = " <b>".$this->settings_model->getRecurringEvery($rinvoice->frequency, $rinvoice->number)."</b> ";
        if( $rinvoice->frequency!="daily" ){
            $text .= lang("on")." ";
        }
        $text .= "<b>";
        if( $rinvoice->frequency=="weekly" ){
            $text .= date("l",strtotime($rinvoice->date));
        }elseif( $rinvoice->frequency=="monthly" ){
            $text .= date("d",strtotime($rinvoice->date));
        }elseif( $rinvoice->frequency=="yearly" ){
            $text .= date("d, F",strtotime($rinvoice->date));
        }
        $text .= "</b> ";
        if( $rinvoice->occurence == 0 ){
            $text .= lang("forever");
        }else if( $rinvoice->occurence == 1 ){
            $text .= lang("for")." <b>".lang("occurence_time")."</b>";
        }else{
            $text .= lang("for")." <b>".$rinvoice->occurence." ".lang("occurence_times")."</b>";
        }
        return $text;
    }
}

/* End of file recurring_model.php */
/* Location: ./application/models/recurring_model.php */
