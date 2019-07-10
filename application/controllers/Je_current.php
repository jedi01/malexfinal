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


class Je_current extends MY_Controller {
    /**
     * Je_current constructor.
     */
    public function __construct ()
    {
        parent::__construct ();
        // Load je_model Model
        $this->load->model('JE_Current_model',"journal_entry");

        $this->load->model( 'account_model' );
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
                $next_link = urlencode("/items");
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
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('journal_entry');
        $data['page_title']       = lang('journal_entry');
        $data['page_subheading']  = lang('items_subheading');
        $meta['breadcrum_false'] = true;

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'journal_entry/index' , $data );
        $this->load->view ( 'templates/footer' , $meta );
    }

    public function getData()
    {
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->load->library('datatables');
        $this->datatables
        ->setsColumns("checkbox,id,doc_name,journal_name,acc_debt,acc_crdt,amount,date,gl_status")
        ->select("doc_name,journal_name,acc_debt,acc_crdt,amount,id,date,gl_status", false)
        ->from("je_current");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }


    public function create()
    {
       
      if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }


        $this->form_validation->set_rules('doc_name',          "lang:doc_name",          'required|xss_clean');
        $this->form_validation->set_rules('date',   "lang:date",   'xss_clean');
        $this->form_validation->set_rules('journal_name',         "lang:journal_name",         'xss_clean');
        $this->form_validation->set_rules('explanations',           "lang:explanations",           'xss_clean');
        $this->form_validation->set_rules('acc_dpt',      "lang:acc_dpt",      'xss_clean');
        $this->form_validation->set_rules('acc_crdt',      "lang:acc_crdt",      'xss_clean');
        $this->form_validation->set_rules('amount', "lang:amount", 'xss_clean');
     if ($this->form_validation->run() == true)
        {
            $data_journal_entry = $this->input->post();
            unset($data_journal_entry['name'],$data_journal_entry['hash']);
           
        }
        if ( $this->form_validation->run() == true && $this->journal_entry->add($data_journal_entry))
        {


            $data = array(
                "status" => "success",
                "message" => lang("create_miscellaneous_success")
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

                $accounts = $this->account_model->getAll();
                $data['page_title']      = lang('create_miscellaneous');
                $data['page_subheading'] = lang('edit_item_subheading');
                $data['accounts']         = $accounts;

                $this->load->view ( 'journal_entry/create' , $data );
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
        $je_current = $this->journal_entry->getByID($id);
        $this->form_validation->set_rules('doc_name',          "lang:doc_name",          'required|xss_clean');
        $this->form_validation->set_rules('date',   "lang:date",   'xss_clean');
        $this->form_validation->set_rules('journal_name',         "lang:journal_name",         'xss_clean');
        $this->form_validation->set_rules('explanations',           "lang:explanations",           'xss_clean');
        $this->form_validation->set_rules('acc_dpt',      "lang:acc_dpt",      'xss_clean');
        $this->form_validation->set_rules('acc_crdt',      "lang:acc_crdt",      'xss_clean');
        $this->form_validation->set_rules('amount', "lang:amount", 'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data_journal_entry = $this->input->post();
            unset($data_journal_entry['name'],$data_journal_entry['hash']);
        }
        if ( $this->form_validation->run() == true && $this->journal_entry->update($id, $data_miscellaneous))
        {
            $data = array(
                "status" => "success",
                "message" => lang("edit_miscellaneous_success")
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
                $data['page_title']      = lang('edit_miscellaneous');
                $data['page_subheading'] = lang('edit_item_subheading');
                $data['je_current']            = $je_current;
                $accounts = $this->account_model->getAll();
                $data['accounts']         = $accounts;
                
                $this->load->view ( 'journal_entry/edit' , $data );
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
        if ( $this->journal_entry->delete($id) )
        {
            $result = array("status"=>"success", "message"=>lang("miscellaneous_deleted"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("cant_delete_miscellaneous"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }


}
