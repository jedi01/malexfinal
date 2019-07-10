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

class Reports_model extends CI_Model
{

    public function __construct ()
    {
        parent::__construct ();
        $this->load->helper('app');
    }

    public function getIncome ($start_date = FALSE, $end_date = FALSE, $currency = FALSE)
    {
        if( $start_date != FALSE ){
            $this->db->where('invoices.date >= ', $start_date);
        }
        if( $end_date != FALSE ){
            $this->db->where('invoices.date <= ', $end_date);
        }
        if( $currency != FALSE ){
            $this->db->where('invoices.currency', $currency);
        }
        $where = "WHERE (status='paid' OR status='partial') ";
        $q = $this->db
            ->select ( "date, sum(total-total_due) amount, currency" )
            ->from("(SELECT date, total, total_due, currency FROM invoices $where) invoices")
            ->group_by("date")
            ->get();
        if ( $q->num_rows () > 0 ) {
            return $q->result();
        }
        return array();
    }

    public function getExpenses ($start_date = FALSE, $end_date = FALSE, $currency = FALSE)
    {
        if( $start_date != FALSE ){
            $this->db->where('expenses.date >= ', $start_date);
        }
        if( $end_date != FALSE ){
            $this->db->where('expenses.date <= ', $end_date);
        }
        if( $currency != FALSE ){
            $this->db->where('expenses.currency', $currency);
        }
        $where = "WHERE status='paid' ";
        $q = $this->db
            ->select ( "date, sum(total) amount, currency" )
            ->from("(SELECT date, total, currency FROM expenses $where) expenses")
            ->group_by("date")
            ->get();
        if ( $q->num_rows () > 0 ) {
            return $q->result();
        }
        return array();
    }

    public function expenses_pie ($start_date = FALSE, $end_date = FALSE, $currency = FALSE)
    {
        if( $start_date != FALSE ){
            $this->db->where('expenses.date >= ', $start_date);
        }
        if( $end_date != FALSE ){
            $this->db->where('expenses.date <= ', $end_date);
        }
        if( $currency != FALSE ){
            $this->db->where('expenses.currency', $currency);
        }
        $labels = $data = array();
        $q = $this->db->select("type, SUM(total) as amount")
                      ->from("expenses")
                      ->join("expenses_categories", "expenses_categories.label=expenses.category", "left")
                      ->where("status", "paid")
                      ->group_by("type")
                      ->get ();
        if ( $q->num_rows () > 0 ) {
            $res = $q->result();
            $total = 0;
            foreach ($res as $item) {
                $labels [] = $item->type;
                $data [] = $item->amount;
                $total += $item->amount;
            }
            return array("data"=>$data, "labels"=>$labels, "total"=>$total);
        }
        return array("data"=>$data, "labels"=>$labels, "total"=>0);
    }

    public function outstanding_revenue_bars ($start_date = FALSE, $end_date = FALSE, $currency = FALSE)
    {
        if( $start_date != FALSE ){
            $this->db->where('invoices.date >= ', $start_date);
        }
        if( $end_date != FALSE ){
            $this->db->where('invoices.date <= ', $end_date);
        }
        if( $currency != FALSE ){
            $this->db->where('invoices.currency', $currency);
        }
        $data = array("overdue"=>0, "unpaid"=>0);
        $q = $this->db
            ->select ( "IF(status='partial', 'unpaid', status) as status, sum(total_due) amount, currency" )
            ->from("(SELECT IF((status='unpaid' OR status='partial') AND date_due<'".date("Y-m-d")."', 'overdue', status) as status, total_due, date, currency FROM invoices) invoices")
            ->where_in("status", array('unpaid', 'partial', 'overdue'))
            ->group_by("status")
            ->get();
        if ( $q->num_rows () > 0 ) {
            $res = $q->result();
            $total = 0;
            $max = 0;
            foreach ($res as $item) {
                $data [$item->status] = $item->amount;
                $max = max(floatval($item->amount), $max);
                $total += $item->amount;
            }
            return array("data"=>$data, "total"=>$total, "max"=>$max);
        }
        return array("data"=>$data, "total"=>0, "max"=>0);
    }

    public function getUsedCurrencies(){
        $where = "";
        if( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() ){
            $where = "WHERE user_id='".USER_ID."'";
        }
        $query = "SELECT `currency`
                FROM (
                    (SELECT `currency`, `user_id` FROM `invoices` GROUP BY `currency`, `user_id`) UNION
                    (SELECT `currency`, `user_id` FROM `estimates` GROUP BY `currency`, `user_id`) UNION
                    (SELECT `currency`, `user_id` FROM `expenses` GROUP BY `currency`, `user_id`)
                ) as tabla
                $where
                GROUP BY `currency`";

        $q = $this->db->query($query);
        $default_exist = false;
        $data = array();
        if ( $q->num_rows () > 0 ) {
            $res = $q->result();
            foreach ($res as $item) {
                $currency = $this->settings_model->getFormattedCurrencies($item->currency);
                $data [$item->currency] = $currency->label;
                if( $item->currency == CURRENCY_PREFIX ){
                    $default_exist = true;
                }
            }
        }
        if(!$default_exist){
            $currency = $this->settings_model->getFormattedCurrencies(CURRENCY_PREFIX);
            $data [CURRENCY_PREFIX] = $currency->label;
        }
        return $data;
    }

    public function getAccountsAging ($date = FALSE, $currency = FALSE, $biller_id = FALSE)
    {
        if( $date == FALSE ){
            $date = date("Y-m-d");
        }
        if( $currency != FALSE ){
            $this->db->where('invoices.currency', $currency);
        }
        if( $biller_id != FALSE ){
            $this->db->where('invoices.bill_to_id', $biller_id);
        }
        $q = $this->db
            ->select ( "biller.fullname, SUM(total_due) as amount, age, bill_to_id, reference, biller.company as company, biller.id as biller_id" )
            ->from("(SELECT date, date_due, total_due, currency, bill_to_id, status, DATEDIFF('".$date."',date) as age, reference FROM invoices) invoices")
            ->join("biller", "invoices.bill_to_id=biller.id")
            ->where("date < ", $date)
            ->where_in("status", array('unpaid', 'partial', 'overdue'))
            ->group_by("bill_to_id")
            ->get();

        if ( $q->num_rows () > 0 ) {
            $rows = $q->result();
            $result = array();
            foreach ($rows as $key => $row) {
                if( isset($result[$row->bill_to_id]) ){
                    $obj = $result[$row->bill_to_id];
                }else{
                    $obj = new StdClass();
                    $obj->fullname = $row->fullname;
                    $obj->biller_id = $row->biller_id;
                    $obj->company = $row->company;
                    $obj->age1 = 0;
                    $obj->age2 = 0;
                    $obj->age3 = 0;
                    $obj->age4 = 0;
                }

                if( $row->age <= 30 ){
                    $obj->age1 += $row->amount;
                }
                elseif( $row->age <= 60 ){
                    $obj->age2 += $row->amount;
                }
                elseif( $row->age <= 90 ){
                    $obj->age3 += $row->amount;
                }else{
                    $obj->age4 += $row->amount;
                }
                $obj->total = $obj->age1+$obj->age2+$obj->age3+$obj->age4;
                $result[$row->bill_to_id] = $obj;
            }
            return $result;
        }
        return array();
    }

    public function getRevenueCustomers ($start_date = FALSE, $end_date = FALSE, $currency = FALSE, $biller_id = FALSE)
    {
        if( $start_date != FALSE ){
            $this->db->where('invoices.date >= ', $start_date);
        }
        if( $end_date != FALSE ){
            $this->db->where('invoices.date <= ', $end_date);
        }
        if( $currency != FALSE ){
            $this->db->where('invoices.currency', $currency);
        }
        if( $biller_id != FALSE ){
            $this->db->where('invoices.bill_to_id', $biller_id);
        }
        $result = array();
        $q = $this->db
            ->select ( "sum(total-total_due) total, currency, fullname, company, biller.id as biller_id" )
            ->from("invoices")
            ->join("biller", "invoices.bill_to_id=biller.id")
            ->where("total <>", "total_due", false)
            ->group_by("bill_to_id")
            ->order_by("fullname")
            ->get();
        if ( $q->num_rows () > 0 ) {
            return $q->result();
        }
        return array();
    }

    public function getCostSuppliers ($start_date = FALSE, $end_date = FALSE, $currency = FALSE, $supplier_id = FALSE)
    {
        if( $start_date != FALSE ){
            $this->db->where('expenses.date >= ', $start_date);
        }
        if( $end_date != FALSE ){
            $this->db->where('expenses.date <= ', $end_date);
        }
        if( $currency != FALSE ){
            $this->db->where('expenses.currency', $currency);
        }
        if( $supplier_id != FALSE ){
            $this->db->where('expenses.supplier_id', $supplier_id);
        }
        $result = array();
        $q = $this->db
            ->select ( "sum(total-total_due) total, currency, fullname, company, suppliers.id as supplier_id" )
            ->from("expenses")
            ->join("suppliers", "expenses.supplier_id=suppliers.id")
            ->where("total <>", "total_due", false)
            ->group_by("supplier_id")
            ->order_by("fullname")
            ->get();
        if ( $q->num_rows () > 0 ) {
            return $q->result();
        }
        return array();
    }

    public function getInvoiceDetails ($start_date = FALSE, $end_date = FALSE, $currency = FALSE, $biller_id = FALSE)
    {
        if( $start_date != FALSE ){
            $this->db->where('invoices.date >= ', $start_date);
        }
        if( $end_date != FALSE ){
            $this->db->where('invoices.date <= ', $end_date);
        }
        if( $currency != FALSE ){
            $this->db->where('invoices.currency', $currency);
        }
        if( $biller_id != FALSE ){
            $this->db->where('invoices.bill_to_id', $biller_id);
        }

        $q = $this->db
            ->select ( "total_due, total, currency, fullname, reference, status, date, invoice_id, biller.company as company, biller.id as biller_id, payment_date" )
            ->from("(SELECT IF((status='unpaid' OR status='partial') AND date_due<'".date("Y-m-d")."', 'overdue', status) as status, total, total_due, date, reference, bill_to_id, currency, invoices.id as invoice_id, invoices.payment_date FROM invoices) invoices")
            ->join("biller", "invoices.bill_to_id=biller.id")
            ->get();
        if ( $q->num_rows () > 0 ) {
            return $q->result();
        }
        return array();
    }



    public function getPurchaseDetails ($start_date = FALSE, $end_date = FALSE, $currency = FALSE, $supplier_id = FALSE, $status = FALSE, $delivery_date = FALSE)
    {
        if( $start_date != FALSE ){
            $this->db->where('purchase.date >= ', $start_date);
        }
        if( $end_date != FALSE ){
            $this->db->where('purchase.date <= ', $end_date);
        }
        if( $currency != FALSE ){
            $this->db->where('purchase.currency', $currency);
        }
        if( $supplier_id != FALSE ){
            $this->db->where('purchase.supplier_id', $supplier_id);
        }

        if( $status != FALSE ){
            $this->db->where('purchase.status', $status);
        }

        if( $delivery_date != FALSE ){
            $this->db->where('purchase.date_due', $delivery_date);
        }

        $q = $this->db
            ->select ( "total_due, total, currency, fullname, reference, status, date, purchase_id, suppliers.company as company, suppliers.id as supplier_id, date_due" )
            ->from("(SELECT IF((status='unpaid' OR status='partial') AND date_due<'".date("Y-m-d")."', 'overdue', status) as status, total, total_due, date, reference, supplier_id, currency, purchase.id as purchase_id, purchase.date_due FROM purchase) purchase")
            ->join("suppliers", "purchase.supplier_id=suppliers.id")
            ->get();
        if ( $q->num_rows () > 0 ) {
            return $q->result();
        }
        return array();
    }

    public function getTaxSummary ($start_date = FALSE, $end_date = FALSE, $currency = FALSE, $biller_id = FALSE)
    {
        if( $start_date != FALSE ){
            $this->db->where('invoices.date >= ', $start_date);
        }
        if( $end_date != FALSE ){
            $this->db->where('invoices.date <= ', $end_date);
        }
        if( $currency != FALSE ){
            $this->db->where('invoices.currency', $currency);
        }
        if( $biller_id != FALSE ){
            $this->db->where('invoices.bill_to_id', $biller_id);
        }
        $result = array();
        $q = $this->db
            ->select ( "SUM(invoices.subtotal) as subtotal, currency, label, value, SUM(value) as sum_value, type" )
            ->from("invoices")
            ->join("invoices_taxes", "invoices.id=invoices_taxes.invoice_id")
            ->where("value <> ", 0)
            ->group_by("invoices_taxes.tax_rate_id")
            ->get();
        if ( $q->num_rows () > 0 ) {
            return $q->result();
        }
        return array();
    }
}

/* End of file reports_model.php */
/* Location: ./application/models/reports_model.php */
