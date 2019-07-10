<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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


class Import_data extends MY_Controller {
	public $fields_list;

    /**
     * Import Data constructor.
     */
	function __construct()
	{
        parent::__construct ();
        // Load Import Data Model
        $this->load->model ( 'import_data_model' );
        // Load Form Validation Library
        $this->load->library ( 'form_validation' );
        // Load Ion Auth Library
        $this->load->library ( 'ion_auth' );
        // Load Helper Language
        $this->load->helper('language');
        // Check user is logged in ?
        if ( !$this->ion_auth->logged_in () ) {
            if ($this->input->is_ajax_request()) {
                $result = array("status"=>"redirect", "message"=>site_url("auth/login"));
                die(json_encode($result));
            }else{
                redirect("auth/login");
            }
        }

        $tax_rate_types = array(lang("percent"), lang("flat"));
		$this->fields_list = array(
            "billers"=>array(
                "sample" => array("John Doe", "(+1) 222 333 444", "johndoe@sis.com", "Somewhere in the World"),
                "title"  => "idata_customers",
                "table"  => "biller",
                "fields" => array(
                    //field db              lang var        required   type    unique   attrbutes
                    "fullname"    => array("fullname"      ,true ,     'text', true,   "max"=>"255"),
                    "phone"       => array("phone"         ,false ,    'text', false,  "max"=>"30"),
                    "email"       => array("email_address" ,false,     'text', false,  "max"=>"50"),
                    "city"        => array("city"          ,false,     'text', false),
                    "state"       => array("state"         ,false,     'text', false),
                    "postal_code" => array("postal_code"   ,false,     'text', false),
                    "country"     => array("country"       ,false,     'text', false),
                    "address"     => array("address"       ,false,     'text', false),
                    "vat_number"  => array("vat_number"    ,false,     'text', false),
                ),
            ),
            "suppliers"=>array(
                "sample" => array("John Doe", "(+1) 222 333 444", "johndoe@sis.com", "Somewhere in the World"),
                "title"  => "idata_suppliers",
                "table"  => "suppliers",
                "fields" => array(
                    //field db              lang var        required   type    unique   attrbutes
                    "fullname"    => array("fullname"      ,true ,     'text', true,   "max"=>"255"),
                    "phone"       => array("phone"         ,false ,    'text', false,  "max"=>"30"),
                    "email"       => array("email_address" ,false,     'text', false,  "max"=>"50"),
                    "city"        => array("city"          ,false,     'text', false),
                    "state"       => array("state"         ,false,     'text', false),
                    "postal_code" => array("postal_code"   ,false,     'text', false),
                    "country"     => array("country"       ,false,     'text', false),
                    "address"     => array("address"       ,false,     'text', false),
                    "vat_number"  => array("vat_number"    ,false,     'text', false),
                ),
            ),
            "expenses_categories"=>array(
                "sample" => array("Utilities", "Electricity"),
                "title"  => "idata_ex_cats",
                "table"  => "expenses_categories",
                "fields" => array(
                    //field db          lang var                  required   type    unique   attrbutes
                    "type" =>    array("expenses_category_type"  ,false,     'text', false),
                    "label"=>    array("expenses_category_label" ,false,     'text', false),
                ),
            ),
            "tax_rates"=>array(
                "sample" => array("VAT", "19", "%"),
                "title"  => "idata_tax_rates",
                "table"  => "tax_rates",
                "fields" => array(
                    //field db              lang var        required   type    unique   attrbutes
                    "label"      => array("tax_rate_label", true ,    'text',   false,  "max"=>"255"),
                    "value"      => array("tax_rate_value", true ,    'number', false,  "min"=>"0", "step"=>"any"),
                    "type"       => array("tax_rate_type" , true ,    'select', false,  "list"=>$tax_rate_types),
                ),
            ),
            "items"=>array(
                "sample" => array("SIS", "Smart Invoice System", "20", "17", "%", "0", "$"),
                "title"  => "idata_items",
                "table"  => "items",
                "fields" => array(
                    //field db              lang var          required   type    unique   attrbutes
                    "name"         => array("name",           true ,    'text',   false,  "max"=>"255"),
                    "description"  => array("description" ,   true ,    'text',   false,  "max"=>"255"),
                    "price"        => array("price",          true ,    'number', false,  "min"=>"0", "step"=>"any"),
                    "tax"          => array("tax",            true ,    'number', false,  "min"=>"0", "step"=>"any"),
                    "tax_type"     => array("tax_type",       true ,    'select', false,  "list"=>$tax_rate_types),
                    "discount"     => array("discount",       true ,    'number', false,  "min"=>"0", "step"=>"any"),
                    "discount_type"=> array("discount_type",  true ,    'select', false,  "list"=>$tax_rate_types),
                ),
            ),
            "items_categories"=>array(
                "sample" => array("Softwares"),
                "title"  => "idata_item_cats",
                "table"  => "items_categories",
                "fields" => array(
                    //field db          lang var    required   type    unique   attrbutes
                    "name" =>    array("name"       ,true,     'text', false),
                ),
            ),
		);
        $this->load->library('csvimport');
        if ( !$this->ion_auth->in_group('admin') )
        {
            return show_error('You must be an administrator to view this page.');
        }
	}

	public function index()
	{
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
		$data['page_title'] = lang('idata_title');
        $data['page_subheading']  = lang('idata_subheading');
        $this->load->view ( 'import_data/content' , $data );
	}

	public function upload_file()
	{
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
		$section = $this->input->post_get('section');
		$meta['page_title'] = lang($this->fields_list[$section]['title']);
		$data['page_title'] = lang($this->fields_list[$section]['title']);
        $data['page_subheading']  = lang('idata_upload_file_subheading');
		$data['fields'] = $this->fields_list[$section]['fields'];
		$data['section'] = $section;

        $this->load->view ( 'import_data/upload_file' , $data );
	}

    function upload()
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $folder = ($this->input->get('folder')?$this->input->get('folder'):"storage");
        $upload_folder = "$folder/";
        if(isset($_FILES['userfile'])){
            $this->load->library('upload');
            $config['upload_path'] = $upload_folder;
            $config['allowed_types'] = 'csv|xls|xlsx';
            $config['max_size'] = '1000';
            $config['overwrite'] = TRUE;
            $this->upload->initialize($config);
            if( ! $this->upload->do_upload()){
                $error = $this->upload->display_errors();
                $error = array('status' => "error", 'message' => $error);
                $this->output->set_content_type('application/json')->set_output( json_encode($error) );
                return;
            }
            $file = $upload_folder.$this->upload->file_name;
            $array = array('status' => "success", 'message' => $file);
            $this->output->set_content_type('application/json')->set_output( stripslashes(json_encode($array)) );
            return;
        } else {
            $error = array('status' => "error", 'message' => 'No file selected to upload!');
            $this->output->set_content_type('application/json')->set_output( json_encode($error) );
            return;
        }
    }

	public function match_fields()
	{
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
		$section = $this->input->get('section');
		$this->form_validation->set_rules('pathfile', lang("idata_file"), 'required|xss_clean');
		if ($this->form_validation->run() == true)
		{
			$csv_delimiter = $this->input->post('csv_delimiter');
			switch($csv_delimiter){
				case 'S': $delimiter = ";";break;
				case 'T': $delimiter = "\t";break;
				case 'C': default : $delimiter = ",";break;
			}

			$file_path = $this->input->post('pathfile');
			$data['file_path'] = base64_encode($file_path);
			$data['csv_delimiter'] = $csv_delimiter;

			$csv_array = $this->csvimport->get_array($file_path, $delimiter);
			if ($csv_array) {
				$data['column_headers'] = $this->csvimport->get_column_headers();
			} else {
				//redirect("module=importing_data&view=index", 'refresh');
	            $data = array(
	                "status" => "error",
	                "message" => "Error occured"
	            );
	            $this->output->set_content_type('application/json')->set_output(json_encode($data));
	            return;
			}
		}else{
            $data = array(
                "status" => "error",
                "message" => validation_errors()
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
		    return;
		}

		$meta['page_title'] = lang($this->fields_list[$section]['title']);
		$data['page_title'] = lang($this->fields_list[$section]['title']);
        $data['page_subheading']  = lang('idata_match_fields_subheading');
		$data['fields'] = $this->fields_list[$section]['fields'];
		$data['section'] = $section;
		$this->load->view('import_data/match_fields', $data);
	}

	public function confirm_data()
	{
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
		$section = $this->input->get('section');

		foreach ($this->fields_list[$section]['fields'] as $field_code => $field_info) {
			$required = ($field_info[1]?'required|xss_clean':'xss_clean');
			$this->form_validation->set_rules($field_code, lang($field_info[0]), $required);
		}
		if ($this->form_validation->run() == true)
		{
			$csv_delimiter = $this->input->post('csv_delimiter');
			switch($csv_delimiter){
				case 'S': $delimiter = ";";break;
				case 'T': $delimiter = "\t";break;
				case 'C': default : $delimiter = ",";break;
			}
			$file_path = $this->input->post('file_path');
			foreach ($this->fields_list[$section]['fields'] as $field_code => $field_info) {
				$f = $this->input->post($field_code);
				if( $f != "" ){
					$fields_relations[$field_code] = $f;
				}else{
					$fields_relations[$field_code] = NULL;
				}

			}

			$csv_array = $this->csvimport->get_array(base64_decode($file_path), $delimiter);
			foreach ($csv_array as $row) {
				$file_row = array();
				foreach ($fields_relations as $key => $value) {
					if( $value == NULL ){
						$file_row[$key] = false;
					}else{
						$file_row[$key] = $row[$value];
					}
				}
				$insert_data[] = $file_row;
			}
			$data['fields_relations'] = $fields_relations;
			$data['insert_data'] = $insert_data;
			$data['file_path'] = base64_decode($file_path);
			$data['csv_delimiter'] = $csv_delimiter;
		}else{
            $data = array(
                "status" => "error",
                "message" => validation_errors()
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
		    return;
		}
		$meta['page_title'] = lang($this->fields_list[$section]['title']);
		$data['page_title'] = lang($this->fields_list[$section]['title']);
        $data['page_subheading']  = lang('idata_confirm_data_subheading');
		$data['fields'] = $this->fields_list[$section]['fields'];
		$data['section'] = $section;

		$this->load->view('import_data/confirm_data', $data);
	}

	public function add_to_database()
	{
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
		$section = $this->input->get('section');

		foreach ($this->fields_list[$section]['fields'] as $field_code => $field_info) {
			$required = ($field_info[1]?'required|xss_clean':'xss_clean');
			$this->form_validation->set_rules($field_code."[]", lang($field_info[0]), $required);

			if( $field_info[3] ){
				$table = $this->fields_list[$section]['table'];
				$this->form_validation->set_rules($field_code."[]", lang($field_info[0]), "is_unique[$table.$field_code]");
			}
		}
		if ($this->form_validation->run() == true)
		{
			$file_path = $this->input->post('file_path');
			foreach ($this->fields_list[$section]['fields'] as $field_code => $field_info) {
				$f = $this->input->post($field_code."[]");
				$data_to_insert[$field_code] = $f;
			}
			if( isset($data_to_insert) ){
				$items = array();
				foreach ($data_to_insert as $key => $value) {
					if( count($value) > 0 ){
						foreach ($value as $k => $v) {
							$items[$k][$key] = $v;
						}
					}else{
			            $data = array(
			                "status" => "error",
			                "message" => lang("idata_no_data")
			            );
			            $this->output->set_content_type('application/json')->set_output(json_encode($data));
			            return;
					}
				}
				$table = $this->fields_list[$section]['table'];
				$data['items'] = $items;
			}else{
	            $data = array(
	                "status" => "error",
	                "message" => lang("idata_no_data")
	            );
	            $this->output->set_content_type('application/json')->set_output(json_encode($data));
	            return;
			}
		}
		if( $this->form_validation->run() == true && $this->import_data_model->insert_data($table, $items) ){
			$meta['page_title'] = lang($this->fields_list[$section]['title']);
			$data['page_title'] = lang($this->fields_list[$section]['title']);
	        $data['page_subheading']  = lang('idata_add_to_db_subheading');
			$data['fields'] = $this->fields_list[$section]['fields'];
			$data['section'] = $section;
			$this->load->view('import_data/add_to_database', $data);
		}else{
            $data = array(
                "status" => "error",
                "message" => validation_errors()?validation_errors():lang("idata_failed")
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	public function getSample($section = false)
	{
		if( $section == false ){
			return;
		}
		header('Content-type: text/csv');
		header('Content-Disposition: attachment; filename="sample.csv"');
		$data   = $this->fields_list[$section]['sample'];
		$fields = $this->fields_list[$section]['fields'];
		$header = array();
		foreach ($fields as $key => $value) {
			$header[] = $key;
		}
		$csv = implode(", ", $header)."\n".implode(", ", $data);
		echo $csv;
	}
}

/* End of file Import_data.php */
/* Location: ./application/controllers/Import_data.php */
