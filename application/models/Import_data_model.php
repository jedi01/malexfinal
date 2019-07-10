<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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


class Import_data_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function insert_data($table, $data){
		if( $table == 'biller' ){
			return $this->insert_billers($table, $data);
		}
		else if( $table == 'suppliers' ){
			return $this->insert_suppliers($table, $data);
		}
		else if( $table == 'expenses_categories' ){
			return $this->insert_expenses_categories($table, $data);
		}
		else if( $table == 'tax_rates' ){
			return $this->insert_tax_rates($table, $data);
		}
		else if( $table == 'items' ){
			return $this->insert_items($table, $data);
		}
		else if( $table == 'items_categories' ){
			return $this->insert_items_categories($table, $data);
		}
		return false;
	}

	public function insert_billers($table, $data){
		if( $this->db->insert_batch($table, $data) ){
			return true;
		}
		return false;
	}

	public function insert_suppliers($table, $data){
		if( $this->db->insert_batch($table, $data) ){
			return true;
		}
		return false;
	}

	public function insert_expenses_categories($table, $data){
		if( $this->db->insert_batch($table, $data) ){
			return true;
		}
		return false;
	}

	public function insert_items($table, $data){
		if( $this->db->insert_batch($table, $data) ){
			return true;
		}
		return false;
	}

	public function insert_items_categories($table, $data){
		if( $this->db->insert_batch($table, $data) ){
			return true;
		}
		return false;
	}

	public function insert_tax_rates($table, $data){
		if( $this->db->insert_batch($table, $data) ){
			return true;
		}
		return false;
	}
}
