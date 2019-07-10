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

class Contracts_model extends CI_Model
{
    var $table = "contracts";

    public function __construct ()
    {
        parent::__construct ();
    }

    public function getAll ()
    {
        $q = $this->db->get ( $this->table );
        if ( $q->num_rows () > 0 ) {
            return $q->result_array ();
        }
        return array ();
    }

    public function count ()
    {
        return $this->db->count_all ( $this->table );
    }

    public function getByID ($id)
    {
        $q = $this->db->get_where ( $this->table , array ( 'id' => $id ) , 1 );
        if ( $q->num_rows () > 0 ) {
            return $q->row ();
        }
        return false;
    }

    public function getByColumn ($column , $value)
    {
        $q = $this->db->get_where ( $this->table , array ( $column => $value ) );
        if ( $q->num_rows () > 0 ) {
            return $q->result ();
        }
        return false;
    }

    public function add ($data = array ())
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
            return true;
        }
        return false;
    }

    public function getContractsEmails ($id_list = array())
    {
        $q = $this->db
                ->select("email")
                ->join("biller", "biller.id=contracts.biller_id", "left")
                ->where_in("contracts.id", $id_list)
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

    public function suggestions_type($term){
        if( strlen($term) >= SUGGESTION_LENGTH ){
            $this->db->where('type', $term)->or_where('type LIKE', '%'.$term.'%');
        }elseif( strlen($term) < SUGGESTION_LENGTH && strlen($term) > 0 ){
            $this->db->where('type', $term);
        }
        $q = $this->db->select('type as label')
                      ->from($this->table)
                      ->limit(SUGGESTION_MAX)
                      ->group_by("type")
                      ->get();

        if( $q->num_rows() > 0 ){
            $result = $q->result();
            return $result;
        }
        return array();
    }

    public function next_reference($next_count=false, $type=REFERENCE_TYPE, $prefix=CONTRACT_PREFIX, $year=false)
    {
        $year = ( $year == false ) ? date("y") : $year;
        if( $next_count == false ){
            $next_count = $this->settings_model->SYS_Settings->contract_next;
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

    public function reset_all_contracts_references($type, $prefix)
    {
        $contracts = $this->getAll();
        $data = array();
        foreach ($contracts as $contract) {
            $reference = $this->next_reference($contract["count"], $type, $prefix, date("y", strtotime($contract["date"])));
            $data[] = array(
                "id" => $contract["id"],
                "reference" => $reference['reference']
            );
        }
        if( count($data) > 0 ){
            $this->db->update_batch( $this->table, $data, 'id');
        }
    }

}

/* End of file contracts_model.php */
/* Location: ./application/models/contracts_model.php */
