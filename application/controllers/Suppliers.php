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


class Suppliers extends MY_Controller {
    /**
     * Suppliers constructor.
     */
    public function __construct ()
    {
        parent::__construct ();
        // Load Suppliers Model
        $this->load->model ( 'suppliers_model' );
        // Load Form Validation Library
        $this->load->library ( 'form_validation' );
        // Load Ion Auth Library
        $this->load->library ( 'ion_auth' );
        // Load Helper Language
        $this->load->helper('language');
        // Load Helper Date Format
        $this->load->helper('date_format');
        // Check user is logged in ?
        if ( !$this->ion_auth->logged_in () ) {
            if ($this->input->is_ajax_request()) {
                $next_link = urlencode("/suppliers");
                $result = array("status"=>"redirect", "message"=>site_url("auth/login?next=$next_link"));
                die(json_encode($result));
            }else{
                $next_link = urlencode(substr("$_SERVER[REQUEST_URI]", stripos("$_SERVER[REQUEST_URI]", "index.php")+9));
                redirect("auth/login?next=$next_link");
            }
        }
    }

    public function index()
    {
        if ( $this->ion_auth->in_group(array("customer", "supplier")) )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/", 'refresh');
        }
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('suppliers');
        $data['page_title']       = lang('suppliers');
        $data['page_subheading']  = lang('suppliers_subheading');

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'suppliers/content' , $data );
        $this->load->view ( 'templates/footer' , $meta );
    }

    public function getData(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->load->library('datatables');
        $this->datatables
        ->setsColumns("checkbox,id,company,fullname,phone,email,address,website,vat_number,custom_field1,custom_field2,custom_field3,custom_field4")
        ->select("id as checkbox,id,company,fullname,phone,email,CONCAT(address, ' ',address2, ' ', city, ' ', state, ' ', postal_code, ' ', country) as address,website,vat_number,custom_field1,custom_field2,custom_field3,custom_field4", false)
        ->from("suppliers");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }

    public function create()
    {
        if ( $this->ion_auth->in_group(array("customer", "supplier")) )
        {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->form_validation->set_rules('supplier[fullname]',    "lang:contact_name",    'required|is_unique[suppliers.fullname]|xss_clean');
        $this->form_validation->set_rules('supplier[company]',     "lang:company",     'xss_clean');
        $this->form_validation->set_rules('supplier[phone]',       "lang:phone",       'xss_clean');
        $this->form_validation->set_rules('supplier[email]',       "lang:email",       'valid_email|xss_clean');
        $this->form_validation->set_rules('supplier[country]',     "lang:country",     'xss_clean');
        $this->form_validation->set_rules('supplier[state]',       "lang:state",       'xss_clean');
        $this->form_validation->set_rules('supplier[city]',        "lang:city",        'xss_clean');
        $this->form_validation->set_rules('supplier[postal_code]', "lang:postal_code", 'xss_clean');
        $this->form_validation->set_rules('supplier[address]',     "lang:address",     'xss_clean');
        $this->form_validation->set_rules('supplier[address2]',    "lang:address2",    'xss_clean');
        $this->form_validation->set_rules('supplier[vat_number]',  "lang:vat_number",  'xss_clean');
        $this->form_validation->set_rules('supplier[website]',     "lang:website",     'valid_url|xss_clean');

        $cf = $this->settings_model->SYS_Settings;
        $this->form_validation->set_rules('supplier[custom_field1]',  "lang:".$cf->supplier_cf1,  'xss_clean');
        $this->form_validation->set_rules('supplier[custom_field2]',  "lang:".$cf->supplier_cf2,  'xss_clean');
        $this->form_validation->set_rules('supplier[custom_field3]',  "lang:".$cf->supplier_cf3,  'xss_clean');
        $this->form_validation->set_rules('supplier[custom_field4]',  "lang:".$cf->supplier_cf4,  'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data_supplier = $this->input->post("supplier");
            if( !empty($data_supplier["phone"]) ){
                $data_supplier["phone"] = $this->input->post("phone_code")." ".$data_supplier["phone"];
            }
        }
        if ( $this->form_validation->run() == true && $this->suppliers_model->add($data_supplier))
        {
            $data = array(
                "status" => "success",
                "message" => lang("supplier_add_success")
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array(
                    "status" => "error",
                    "message" => (validation_errors() ? validation_errors() : $this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array()
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                $data['page_title']       = lang('create_supplier');
                $data['page_subheading']  = lang('create_supplier_subheading');

                $this->load->view ( 'suppliers/create' , $data );
            }
        }
    }

    public function edit()
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( $this->ion_auth->in_group(array("customer", "supplier")) )
        {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( !$this->input->get('id') )
        {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $id = $this->input->get('id');
        $supplier = $this->suppliers_model->getByID($id);

        $this->form_validation->set_rules('supplier[fullname]',    "lang:contact_name", 'required|xss_clean');
        $this->form_validation->set_rules('supplier[company]',     "lang:company",     'xss_clean');
        $this->form_validation->set_rules('supplier[phone]',       "lang:phone",       'xss_clean');
        $this->form_validation->set_rules('supplier[email]',       "lang:email",       'valid_email|xss_clean');
        $this->form_validation->set_rules('supplier[country]',     "lang:country",     'xss_clean');
        $this->form_validation->set_rules('supplier[state]',       "lang:state",       'xss_clean');
        $this->form_validation->set_rules('supplier[city]',        "lang:city",        'xss_clean');
        $this->form_validation->set_rules('supplier[postal_code]', "lang:postal_code", 'xss_clean');
        $this->form_validation->set_rules('supplier[address]',     "lang:address",     'xss_clean');
        $this->form_validation->set_rules('supplier[address2]',    "lang:address2",    'xss_clean');
        $this->form_validation->set_rules('supplier[vat_number]',  "lang:vat_number",  'xss_clean');
        $this->form_validation->set_rules('supplier[website]',     "lang:website",     'valid_url|xss_clean');

        $cf = $this->settings_model->SYS_Settings;
        $this->form_validation->set_rules('supplier[custom_field1]',  "lang:".$cf->supplier_cf1,  'xss_clean');
        $this->form_validation->set_rules('supplier[custom_field2]',  "lang:".$cf->supplier_cf2,  'xss_clean');
        $this->form_validation->set_rules('supplier[custom_field3]',  "lang:".$cf->supplier_cf3,  'xss_clean');
        $this->form_validation->set_rules('supplier[custom_field4]',  "lang:".$cf->supplier_cf4,  'xss_clean');

        if( $this->input->post('supplier[fullname]') ){
            if( $this->input->post('supplier[fullname]') != $supplier->fullname ){
                $this->form_validation->set_rules('supplier[fullname]', "lang:contact_name", 'is_unique[suppliers.fullname]');
            }
        }

        if ($this->form_validation->run() == true)
        {
            $data_supplier = $this->input->post("supplier");
            if( !empty($data_supplier["phone"]) ){
                $data_supplier["phone"] = $this->input->post("phone_code")." ".$data_supplier["phone"];
            }
            $id = $this->input->post('id');
        }
        if ( $this->form_validation->run() == true && $this->suppliers_model->update($id, $data_supplier))
        {
            $data = array(
                "status" => "success",
                "message" => lang("supplier_edit_success")
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array(
                    "status" => "error",
                    "message" => (validation_errors() ? validation_errors() : $this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array()
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                $data['page_title']      = lang('edit_supplier');
                $data['page_subheading'] = lang('edit_supplier_subheading');
                $data['supplier']         = $supplier;

                $this->load->view ( 'suppliers/edit' , $data );
            }
        }
    }

    public function delete()
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( $this->ion_auth->in_group(array("customer", "supplier")) || !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if($this->input->get('id')) { $id = array($this->input->get('id')); }
        if($this->input->post('id')) { $id = $this->input->post('id'); }
        if( !isset($id) || $id == false ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        if ( $this->suppliers_model->delete($id) )
        {
            $result = array("status"=>"success", "message"=>lang("supplier_deleted"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("cant_delete_supplier"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function view($id = false)
    {
        if( $this->input->get('id') ){$id = $this->input->get('id');}
        if ( !$id || !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $data['page_title']      = lang('details_supplier');
        $data['supplier']          = $this->suppliers_model->getByID($id);

        $this->load->view ( 'suppliers/details' , $data );
    }

    public function suggestions(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $term = $this->input->get('term')?$this->input->get('term'):"";
        $items = $this->suppliers_model->suggestions($term);
        $this->output->set_content_type('application/json')->set_output(json_encode($items));
    }

}

/* End of file Billers.php */
/* Location: ./application/controllers/Billers.php */
