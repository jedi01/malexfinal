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

class Receipts_model extends CI_Model
{
    var $table = "receipts";

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

    public function getReceiptsByInvoice($id){
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
        $next_count = $this->settings_model->SYS_Settings->receipt_next;
        return sprintf("%06s", $next_count);
    }

    public function getReceiptsEmails ($id_list = array())
    {
        $q = $this->db
                ->select("email")
                ->join("biller", "biller.id=receipts.biller_id", "left")
                ->where_in("receipts.id", $id_list)
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
        return in_array($method, array("paypal", "stripe", "twocheckout"));
    }

}

/* End of file receipts_model.php */
/* Location: ./application/models/receipts_model.php */
