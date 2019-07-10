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

class Biller_model extends CI_Model
{
    var $table = "biller";

    public function __construct ()
    {
        parent::__construct ();
    }

    public function getAll ()
    {
        $this->db->select("*, CONCAT(address, ' ', address2, ' ',city, ' ', state, ' ', postal_code, ' ', country) as fulladdress");
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
        $this->db->select("*, CONCAT(address, ' ', address2, ' ',city, ' ', state, ' ', postal_code, ' ', country) as fulladdress");
        $q = $this->db->get_where ( $this->table , array ( 'id' => $id ) , 1 );
        if ( $q->num_rows () > 0 ) {
            return $q->row ();
        }
        return false;
    }

    public function getByColumn ($column , $value)
    {
        $this->db->select("*, CONCAT(address, ' ', address2, ' ',city, ' ', state, ' ', postal_code, ' ', country) as fulladdress");
        $q = $this->db->get_where ( $this->table , array ( $column => $value ) );
        if ( $q->num_rows () > 0 ) {
            return $q->result ();
        }
        return false;
    }

    public function create_account ($biller = array (), $biller_id = false)
    {
        $username = str_replace(' ', '', strtolower($biller["fullname"]));
        $password = substr( md5(rand()), 0, 12);
        $email = $biller["email"];
        $name = explode(" ", $biller["fullname"]);
        $additional_data = array(
            'first_name' => $name[0],
            'last_name'  => isset($name[1])?$name[1]:"",
            'company'    => isset($biller["company"])?$biller["company"]:"",
            'phone'      => isset($biller["phone"])?$biller["phone"]:"",
        );
        $group = $this->db->get_where('groups',array('name' => 'customer'),1)->row();
        $groups = array($group->id);
        $user_id = $this->ion_auth->register($username, $password, $email, $additional_data, $groups, true);
        if( $biller_id ){
            $this->db->where ( 'id' , $biller_id )->update ( $this->table , array("user_id"=>$user_id) );
        }
        return $user_id;
    }

    public function add ($data = array ())
    {
        if( CREATE_BILLER_ACCOUNTS ){
            $data['user_id'] = $this->create_account($data);
        }
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
        if( $this->db->select("id")->where_in('bill_to_id', $id)->count_all_results('invoices') > 0 ){
            return false;
        }
        if( CREATE_BILLER_ACCOUNTS ){
            foreach ($id as $biller_id) {
                $biller = $this->getByID($biller_id);
                $this->ion_auth->delete_user($biller->user_id);
            }
        }
        if ( $this->db->where_in ( 'id' , $id )->delete ( $this->table ) ) {
            return true;
        }
        return false;
    }

    public function suggestions($term){
        if( strlen($term) >= SUGGESTION_LENGTH ){
            $this->db->where("(fullname = '$term' OR fullname LIKE '%$term%')", false, false);
            $this->db->or_where("(company = '$term' OR company LIKE '%$term%')", false, false);
        }elseif( strlen($term) < SUGGESTION_LENGTH && strlen($term) > 0 ){
            $this->db->where('fullname', $term);
            $this->db->or_where('company', $term);
        }
        $q = $this->db->select("biller.*,IF(company='',fullname, CONCAT(company,' (',fullname,')')) as label", false)
                      ->from($this->table)
                      ->limit(SUGGESTION_MAX)
                      ->get();

        if( $q->num_rows() > 0 ){
            $result = $q->result();
            return $result;
        }
        return array();
    }

}

/* End of file biller_model.php */
/* Location: ./application/models/biller_model.php */
