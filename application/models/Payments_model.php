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

class Payments_model extends CI_Model
{
    var $table = "payments";

    public function __construct ()
    {
        parent::__construct ();
        $this->load->helper('app');
    }

    public function get ($id){
        $q = $this->db->where('id', $id)->limit(1)->get($this->table);
        if( $q->num_rows() > 0 )
        {
            $row = $q->row();
            if( $row->credit_card != NULL ){
                $row->credit_card = json_decode($row->credit_card);
            }
            return $row;
        }
        return array();
    }

    public function getPaymentsByInvoice($id){
        $q = $this->db->where('invoice_id', $id)
                    ->get($this->table);
        if( $q->num_rows() > 0 )
        {
            return $q->result_array();
        }
        return array();
    }

    public function getByToken ($token){
        $q = $this->db->where('token', $token)->limit(1)->get($this->table);
        if( $q->num_rows() > 0 )
        {
            $row = $q->row();
            if( $row->credit_card != NULL ){
                $row->credit_card = json_decode($row->credit_card);
            }
            return $row;
        }
        return array();
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
        $this->db->select('max(number) as number')->limit(1);
        $q = $this->db->get ($this->table);
        if( $q->num_rows() > 0 )
        {
            $row = $q->row();
            $next_count = $row->number + 1;
        }else{
            $next_count = 1;
        }
        return sprintf("%06s", $next_count);
    }

    public function getPaymentsEmails ($id_list = array())
    {
        $q = $this->db
                ->select("email")
                ->join("invoices", "invoices.id=payments.invoice_id", "left")
                ->join("biller", "biller.id=invoices.bill_to_id", "left")
                ->where_in("payments.id", $id_list)
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

    public function setStatus ($id , $status)
    {
        if ( $this->db->where ( 'id' , $id )->update ( $this->table , array("status" => $status) ) ) {
            return $id;
        }
        return false;
    }

    public function isOnline ($method)
    {
        return in_array($method, array("paypal", "stripe", "twocheckout", "mobilpay"));
    }

}

/* End of file payments_model.php */
/* Location: ./application/models/payments_model.php */
