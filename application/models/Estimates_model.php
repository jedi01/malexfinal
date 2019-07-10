<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Name:         Smart Estimate System
 * Version :     1.0
 * Author:       Zitouni Bessem
 * Requirements: PHP5 or above
 *
 */

class Estimates_model extends CI_Model
{
    var $table = "estimates";
    var $table_items = "estimates_items";
    var $table_taxes = "estimates_taxes";

    public function __construct ()
    {
        parent::__construct ();
        $this->load->helper('app');
    }

    public function getAllEstimates ()
    {
        $q = $this->db->get ( $this->table );
        if ( $q->num_rows () > 0 ) {
            return $q->result_array();
        }
        return array();
    }

    public function getEstimate($id){
        $q = $this->db->where('id', $id)
                    ->limit(1)
                    ->get($this->table);
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        }
        return array();
    }

    public function getEstimateItems($id){
        $q = $this->db->where('estimate_id', $id)
                    ->get($this->table_items);
        if( $q->num_rows() > 0 )
        {
            return $q->result_array();
        }
        return array();
    }

    public function getEstimateTaxes($id){
        $q = $this->db->where('estimate_id', $id)
                    ->get($this->table_taxes);
        if( $q->num_rows() > 0 )
        {
            return $q->result_array();
        }
        return array();
    }

    public function next_reference($next_count=false, $type=REFERENCE_TYPE, $prefix=ESTIMATE_PREFIX, $year=false)
    {
        $year = ( $year == false ) ? date("y") : $year;
        if( $next_count == false ){
            $next_count = $this->settings_model->SYS_Settings->estimate_next;
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

    public function reset_all_estimates_references($type, $prefix)
    {
        $estimates = $this->getAllEstimates();
        $data = array();
        foreach ($estimates as $estimate) {
            $reference = $this->next_reference($estimate["count"], $type, $prefix, date("y", strtotime($estimate["date"])));
            $data[] = array(
                "id" => $estimate["id"],
                "reference" => $reference['reference']
            );
            $this->sis_logger->write('estimates', 'update', $estimate["id"], "estimate reference is updated");
        }
        if( count($data) > 0 ){
            $this->db->update_batch( $this->table, $data, 'id');
        }
    }

    public function create ($data = array (), $items = array(), $taxes = array())
    {
        if ( $this->db->insert ( $this->table , $data ) ) {
            $id = $this->db->insert_id ();
            foreach ($items as $key => $value) {
                $items[$key]['estimate_id'] = $id;
            }
            $this->db->insert_batch($this->table_items, $items);

            if( count($taxes) > 0 ){
                foreach ($taxes as $key => $value) {
                    $taxes[$key]['estimate_id'] = $id;
                }
                $this->db->insert_batch($this->table_taxes, $taxes);
            }
            return $id;
        }
        return false;
    }

    public function update ($id , $data = array (), $items = array(), $taxes = array())
    {
        if ( $this->db->where ( 'id' , $id )->update ( $this->table , $data ) ) {
            $this->db->where('estimate_id', $id)->delete($this->table_items);
            $this->db->where('estimate_id', $id)->delete($this->table_taxes);
            foreach ($items as $key => $value) {
                $items[$key]['estimate_id'] = $id;
            }
            if( $this->db->insert_batch($this->table_items, $items) ){
                if( count($taxes) > 0 ){
                    foreach ($taxes as $key => $value) {
                        $taxes[$key]['estimate_id'] = $id;
                    }
                    $this->db->insert_batch($this->table_taxes, $taxes);
                }
                return $id;
            }
            $this->db->where('id', $id)->delete($table);
        }
        return false;
    }

    public function delete ($id = array())
    {
        if ( $this->db->where_in ( 'id' , $id )->delete ( $this->table ) ) {
            $this->db->where_in('estimate_id', $id)->delete($this->table_items);
            $this->db->where_in('estimate_id', $id)->delete($this->table_taxes);
            return true;
        }
        return false;
    }

    public function setStatus ($id_list = array() , $status)
    {
        if ( $this->db->where_in ( 'id' , $id_list )->update ( $this->table , array("status" => $status) ) ) {
            return $id_list;
        }
        return false;
    }

    public function getEstimatesEmails ($id_list = array())
    {
        $q = $this->db
                ->select("email")
                ->join("biller", "biller.id=estimates.bill_to_id", "left")
                ->where_in("estimates.id", $id_list)
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

    public function getInvoiceID($id){
        $q = $this->db->select("id")
                    ->where('estimate_id', $id)
                    ->limit(1)
                    ->get("invoices");
        if( $q->num_rows() > 0 )
        {
            return $q->row()->id;
        }
        return false;
    }

}

/* End of file estimates_model.php */
/* Location: ./application/models/estimates_model.php */
