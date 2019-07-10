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


class Billers extends MY_Controller {
    /**
     * Billers constructor.
     */
    public function __construct ()
    {
        parent::__construct ();
        // Load Billers Model
        $this->load->model ( 'biller_model' );
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
                $next_link = urlencode("/billers");
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
        $meta['page_title']       = lang('customers');
        $data['page_title']       = lang('customers');
        $data['page_subheading']  = lang('customers_subheading');

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'billers/billers' , $data );
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
        ->setsColumns("checkbox,id,company,fullname,phone,email,address,website,vat_number,custom_field1,custom_field2,custom_field3,custom_field4,user_id")
        ->select("id as checkbox,id,company,fullname,phone,email,CONCAT(address, ' ',address2, ' ', city, ' ', state, ' ', postal_code, ' ', country) as address,website,vat_number,custom_field1,custom_field2,custom_field3,custom_field4,user_id", false)
        ->from("biller");
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
        $this->form_validation->set_rules('biller[fullname]',    "lang:contact_name",    'required|is_unique[biller.fullname]|xss_clean');
        $this->form_validation->set_rules('biller[company]',     "lang:company",     'xss_clean');
        $this->form_validation->set_rules('biller[phone]',       "lang:phone",       'xss_clean');
        $this->form_validation->set_rules('biller[email]',       "lang:email",       'required|valid_email|is_unique[users.email]|xss_clean');
        $this->form_validation->set_rules('biller[country]',     "lang:country",     'xss_clean');
        $this->form_validation->set_rules('biller[state]',       "lang:state",       'xss_clean');
        $this->form_validation->set_rules('biller[city]',        "lang:city",        'xss_clean');
        $this->form_validation->set_rules('biller[postal_code]', "lang:postal_code", 'xss_clean');
        $this->form_validation->set_rules('biller[address]',     "lang:address",     'xss_clean');
        $this->form_validation->set_rules('biller[address2]',    "lang:address2",    'xss_clean');
        $this->form_validation->set_rules('biller[vat_number]',  "lang:vat_number",  'xss_clean');
        $this->form_validation->set_rules('biller[website]',     "lang:website",     'valid_url|xss_clean');

        $cf = $this->settings_model->SYS_Settings;
        $this->form_validation->set_rules('biller[custom_field1]',  "lang:".$cf->customer_cf1,  'xss_clean');
        $this->form_validation->set_rules('biller[custom_field2]',  "lang:".$cf->customer_cf2,  'xss_clean');
        $this->form_validation->set_rules('biller[custom_field3]',  "lang:".$cf->customer_cf3,  'xss_clean');
        $this->form_validation->set_rules('biller[custom_field4]',  "lang:".$cf->customer_cf4,  'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data_biller = $this->input->post("biller");
            if( !empty($data_biller["phone"]) ){
                $data_biller["phone"] = $this->input->post("phone_code")." ".$data_biller["phone"];
            }
        }
        if ( $this->form_validation->run() == true && $this->biller_model->add($data_biller))
        {
            $data = array(
                "status" => "success",
                "message" => lang("customer_add_success")
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
                $data['page_title']       = lang('create_customer');
                $data['page_subheading']  = lang('create_customer_subheading');

                $this->load->view ( 'billers/biller_create' , $data );
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
        $biller = $this->biller_model->getByID($id);

        $this->form_validation->set_rules('biller[fullname]',    "lang:contact_name", 'required|xss_clean');
        $this->form_validation->set_rules('biller[company]',     "lang:company",     'xss_clean');
        $this->form_validation->set_rules('biller[phone]',       "lang:phone",       'xss_clean');
        $this->form_validation->set_rules('biller[email]',       "lang:email",       'required|valid_email|xss_clean');
        $this->form_validation->set_rules('biller[country]',     "lang:country",     'xss_clean');
        $this->form_validation->set_rules('biller[state]',       "lang:state",       'xss_clean');
        $this->form_validation->set_rules('biller[city]',        "lang:city",        'xss_clean');
        $this->form_validation->set_rules('biller[postal_code]', "lang:postal_code", 'xss_clean');
        $this->form_validation->set_rules('biller[address]',     "lang:address",     'xss_clean');
        $this->form_validation->set_rules('biller[address2]',    "lang:address2",    'xss_clean');
        $this->form_validation->set_rules('biller[vat_number]',  "lang:vat_number",  'xss_clean');
        $this->form_validation->set_rules('biller[website]',     "lang:website",     'valid_url|xss_clean');

        $cf = $this->settings_model->SYS_Settings;
        $this->form_validation->set_rules('biller[custom_field1]',  "lang:".$cf->customer_cf1,  'xss_clean');
        $this->form_validation->set_rules('biller[custom_field2]',  "lang:".$cf->customer_cf2,  'xss_clean');
        $this->form_validation->set_rules('biller[custom_field3]',  "lang:".$cf->customer_cf3,  'xss_clean');
        $this->form_validation->set_rules('biller[custom_field4]',  "lang:".$cf->customer_cf4,  'xss_clean');

        if( $this->input->post('biller[fullname]') ){
            if( $this->input->post('biller[fullname]') != $biller->fullname ){
                $this->form_validation->set_rules('biller[fullname]', "lang:contact_name", 'is_unique[biller.fullname]');
            }
        }
        if( $this->input->post('biller[email]') ){
            if( $this->input->post('biller[email]') != $biller->email ){
                $this->form_validation->set_rules('biller[email]', "lang:email", 'is_unique[users.email]');
            }
        }

        if ($this->form_validation->run() == true)
        {
            $data_biller = $this->input->post("biller");
            if( !empty($data_biller["phone"]) ){
                $data_biller["phone"] = $this->input->post("phone_code")." ".$data_biller["phone"];
            }
            $id = $this->input->post('id');
        }
        if ( $this->form_validation->run() == true && $this->biller_model->update($id, $data_biller))
        {
            $data = array(
                "status" => "success",
                "message" => lang("customer_edit_success")
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
                $data['page_title']      = lang('edit_customer');
                $data['page_subheading'] = lang('edit_customer_subheading');
                $data['biller']          = $biller;

                $this->load->view ( 'billers/biller_edit' , $data );
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
        if($this->input->get('id')) { $id = array($this->input->get('id')); }
        if($this->input->post('id')) { $id = $this->input->post('id'); }
        if( !isset($id) || $id == false ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        if ( $this->biller_model->delete($id) )
        {
            $result = array("status"=>"success", "message"=>lang("customer_deleted"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("cant_delete_customer"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function view($id = false)
    {
        if( $this->input->get('id') ){$id = $this->input->get('id');}
        if ( !$id || !$this->input->is_ajax_request() || !($biller = $this->biller_model->getByID($id))) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if( $biller->user_id != NULL ){
            $user = $this->ion_auth->user($biller->user_id)->row();
        }else{
            $user = false;
        }
        $data['user']            = $user;
        $data['biller']          = $biller;
        $data['page_title']      = lang('details_customer');
        $this->load->view ( 'billers/biller_details' , $data );
    }

    public function profile($id = false)
    {
        if( $this->input->get('id') ){$id = $this->input->get('id');}
        if ( !$id || !($biller = $this->biller_model->getByID($id)) )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/billers", 'refresh');
        }
        if( $biller->user_id != NULL ){
            $user = $this->ion_auth->user($biller->user_id)->row();
        }else{
            $user = false;
        }
        $data['biller']           = $biller;
        $data['user']             = $user;
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $data['page_title']       = lang('profile_customer');
        $meta['page_title']       = lang('profile_customer');

        $meta['breadcrumb_first'] = array(
            "class_label" => "customers",
        );

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'billers/biller_profile' , $data );
        $this->load->view ( 'templates/footer' , $meta );
    }

    public function create_account($id = false)
    {
        if( $this->input->get('id') ){$id = $this->input->get('id');}
        if ( !$id || !($biller = $this->biller_model->getByID($id)) )
        {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if( $biller->user_id != NULL ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }else{
            $biller_data = objectToArray($biller);
            $this->biller_model->create_account($biller_data, $biller->id);
            $result = array("status"=>"success", "message"=>lang("account_created"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function send_reminder($id = false)
    {
        if( $this->input->get('id') ){$id = $this->input->get('id');}
        if ( !$id || !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->load->model('invoices_model');
        $res = $this->invoices_model->sendBillerReminder($id);
        if( $res === true ){
            $result = array("status"=>"success", "message"=>lang("email_successful"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }elseif( $res != false ){
            $result = array("status"=>"error", "message"=>$res);
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $result = array("status"=>"error", "message"=>lang("email_unsuccessful"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function suggestions(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $term = $this->input->get('term')?$this->input->get('term'):"";
        $items = $this->biller_model->suggestions($term);
        $this->output->set_content_type('application/json')->set_output(json_encode($items));
    }

}

/* End of file Billers.php */
/* Location: ./application/controllers/Billers.php */
