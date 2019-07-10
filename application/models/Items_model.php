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

class Items_model extends CI_Model
{
    var $table = "items";

    public function __construct ()
    {
        parent::__construct ();
    }

    public function getAll ()
    {
        $this->db->select("*");
        $q = $this->db->get ( $this->table );
        if ( $q->num_rows () > 0 ) {
            return $q->result_array ();
        }
        return array ();
    }

    public function getItemPrices ($id)
    {
        $q = $this->db->get_where ( "items_prices" , array ( "item_id" => $id ) );
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
        $this->db->select("*");
        $q = $this->db->get_where ( $this->table , array ( 'id' => $id ) , 1 );
        if ( $q->num_rows () > 0 ) {
            return $q->row ();
        }
        return false;
    }

    public function getByColumn ($column , $value)
    {
        $this->db->select("*");
        $q = $this->db->get_where ( $this->table , array ( $column => $value ) );
        if ( $q->num_rows () > 0 ) {
            return $q->result ();
        }
        return false;
    }

    public function add ($data = array (), $prices = array())
    {
        if ( $this->db->insert ( $this->table , $data ) ) {
            $id = $this->db->insert_id ();
            foreach ($prices as $key => $value) {
                $prices[$key]['item_id'] = $id;
            }
            $this->db->insert_batch("items_prices", $prices);

            return $id;
        }
        return false;
    }

    public function update ($id , $data = array (), $prices = array())
    {
        if ( $this->db->where ( 'id' , $id )->update ( $this->table , $data ) ) {
            $this->db->where("item_id", $id)->delete("items_prices");
            foreach ($prices as $key => $value) {
                $prices[$key]['item_id'] = $id;
            }
            $this->db->insert_batch("items_prices", $prices);
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

    public function get_category ($id)
    {
        $q = $this->db->get_where ( 'items_categories' , array ( 'id' => $id ) , 1 );
        if ( $q->num_rows () > 0 ) {
            return $q->row ();
        }
        return false;
    }

    public function getAllcategories ()
    {
        $q = $this->db->get ( 'items_categories' );
        if ( $q->num_rows () > 0 ) {
            return $q->result_array ();
        }
        return array ();
    }

    public function create_category ($data = array ())
    {
        if( isset($data['is_default']) ){
            $this->db->set ( 'is_default' , '0' )->update ( 'items_categories' );
        }
        if ( $this->db->insert ( 'items_categories' , $data ) ) {
            $id = $this->db->insert_id ();
            return $id;
        }
        return false;
    }

    public function update_category ($id , $data = array ())
    {
        if( isset($data['is_default']) ){
            $this->db->set ( 'is_default' , '0' )->update ( 'items_categories' );
        }
        if ( $this->db->where ( 'id' , $id )->update ( 'items_categories' , $data ) ) {
            return $id;
        }
        return false;
    }

    public function delete_category ($id)
    {
        if ( $this->db->where ( 'id' , $id )->delete ( 'items_categories' ) ) {
            return true;
        }
        return false;
    }

    public function suggestions($term, $currency){
        if( strlen($term) >= SUGGESTION_LENGTH ){
            $this->db->where('name', $term)->or_where('name LIKE', '%'.$term.'%')->or_where('description LIKE', '%'.$term.'%');
        }elseif( strlen($term) < SUGGESTION_LENGTH && strlen($term) > 0 ){
            $this->db->where('name', $term);
        }
        $q = $this->db->select($this->table.'.*, items_prices.price as price,name label', false)//
                      ->from($this->table)
                      ->join('items_prices', "items_prices.item_id=items.id AND items_prices.currency='$currency'", 'left')
                      ->group_by('items.id')
                      ->limit(SUGGESTION_MAX)
                      ->get();
        if( $q->num_rows() > 0 ){
            $result = $q->result();
            return $result;
        }
        return array();
    }

}

/* End of file items_model.php */
/* Location: ./application/models/items_model.php */
