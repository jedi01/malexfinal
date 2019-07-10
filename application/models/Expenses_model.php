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

class Expenses_model extends CI_Model
{
    var $table = "expenses";

    public function __construct ()
    {
        parent::__construct ();
        $this->load->helper('app');
    }

    public function get ($id){
        $q = $this->db->where('id', $id)->limit(1)->get($this->table);
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        }
        return false;
    }

    public function create ($data)
    {
        if ( $this->db->insert ( $this->table , $data ) ) {
            $id = $this->db->insert_id ();
            return $id;
        }
        return false;
    }

    public function update ($id , $data = array ())
    {
        if ( $this->db->where( 'id' , $id )->update( $this->table , $data ) ) {
            return $id;
        }
        return false;
    }

    public function delete ($id)
    {
        if ( $this->db->where ( 'id' , $id )->delete( $this->table ) ) {
            return true;
        }
        return false;
    }

    public function next ()
    {
        $next_count = $this->settings_model->SYS_Settings->expense_next;
        return sprintf("%06s", $next_count);
    }

    public function setStatus ($id , $status)
    {
        if ( $this->db->where ( 'id' , $id )->update ( $this->table , array("status" => $status) ) ) {
            return $id;
        }
        return false;
    }


    // Expeneses Categories

    public function get_category ($id)
    {
        $q = $this->db->get_where ( 'expenses_categories' , array ( 'id' => $id ) , 1 );
        if ( $q->num_rows () > 0 ) {
            return $q->row ();
        }
        return false;
    }

    public function getAllcategories ()
    {
        $q = $this->db->get ( 'expenses_categories' );
        if ( $q->num_rows () > 0 ) {
            return $q->result_array ();
        }
        return array ();
    }

    public function create_category ($data = array ())
    {
        if( isset($data['is_default']) ){
            $this->db->set ( 'is_default' , '0' )->update ( 'expenses_categories' );
        }
        if ( $this->db->insert ( 'expenses_categories' , $data ) ) {
            $id = $this->db->insert_id ();
            return $id;
        }
        return false;
    }

    public function update_category ($id , $data = array ())
    {
        if( isset($data['is_default']) ){
            $this->db->set ( 'is_default' , '0' )->update ( 'expenses_categories' );
        }else{
            $old = $this->get_category($id);
            if( $old->is_default ){
                $this->db->limit(1)->set ( 'is_default' , '1' )->update ( 'expenses_categories' );
                $data['is_default'] = false;
            }
        }
        if ( $this->db->where ( 'id' , $id )->update ( 'expenses_categories' , $data ) ) {
            return $id;
        }
        return false;
    }

    public function delete_category ($id_list)
    {
        foreach ($id_list as $id) {
            $old = $this->get_category($id);
            if( $old->is_default ){
                $this->db->limit(1)->set ( 'is_default' , '1' )->update ( 'expenses_categories' );
            }
            $this->db->where ( 'id' , $id )->delete ( 'expenses_categories' );
        }
        return true;
    }


    // Payments

    public function getPaymentsTotal($expense_id){
        $q = $this->db->select('COALESCE(SUM(amount),0) as total')
                    ->where('expense_id', $expense_id)
                    ->where("status", "released")
                    ->get("expenses_payments");
        if( $q->num_rows() > 0 )
        {
            return $q->row()->total;
        }
        return 0;
    }

    public function update_amount_due ($expense_id)
    {
        $payments = $this->getPaymentsTotal($expense_id);
        $expense = $this->get($expense_id);
        $total_due = $expense->total - $payments;
        if( $total_due <= 0 ){
            $status = "paid";
            if( $expense->payment_date == NULL ){
                $payment_date = date("Y-m-d");
            }else{
                $payment_date = $expense->payment_date;
            }
        }else{
            $payment_date = NULL;
            if( $payments > 0 ){
                $status = "partial";
            }else{
                $status = "unpaid";
            }
        }
        $this->db->set("total_due", $total_due)
                 ->set("status", $status)
                 ->set("payment_date", $payment_date)
                 ->where('id', $expense_id);
        if( $this->db->update("expenses") ){
            return true;
        }
        return false;
    }



    public function get_payment($payment_id){
        $q = $this->db->where('id', $payment_id)->limit(1)->get("expenses_payments");
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        }
        return array();
    }

    public function getPaymentsByExpense($expense_id){
        $q = $this->db->where('expense_id', $expense_id)
                    ->get("expenses_payments");
        if( $q->num_rows() > 0 )
        {
            return $q->result_array();
        }
        return array();
    }

    public function add_payment($data)
    {
        if ( $this->db->insert("expenses_payments", $data ) ) {
            $id = $this->db->insert_id ();
            return $id;
        }
        return false;
    }

    public function edit_payment($payment_id , $data = array ())
    {
        if ( $this->db->where( 'id' , $payment_id )->update("expenses_payments", $data ) ) {
            return $payment_id;
        }
        return false;
    }

    public function delete_payment($payment_id)
    {
        if ( $this->db->where('id',$payment_id)->delete("expenses_payments") ) {
            return true;
        }
        return false;
    }

    public function next_payment()
    {
        $this->db->select('max(number) as number')->limit(1);
        $q = $this->db->get("expenses_payments");
        if( $q->num_rows() > 0 )
        {
            $row = $q->row();
            $next_count = $row->number + 1;
        }else{
            $next_count = 1;
        }
        return sprintf("%06s", $next_count);
    }

}

/* End of file expenses_model.php */
/* Location: ./application/models/expenses_model.php */
