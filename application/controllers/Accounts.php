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


class Accounts extends MY_Controller {
    /**
     * Accounts constructor.
     */
    public function __construct ()
    {
        parent::__construct ();
        // Load Account Model
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


    public function index ()
    {
        if ( !$this->ion_auth->logged_in () ) {
            $next_link = urlencode(substr("$_SERVER[REQUEST_URI]", stripos("$_SERVER[REQUEST_URI]", "index.php")+9));
            if ($this->input->is_ajax_request()) {
                $result = array("status"=>"redirect", "message"=>"auth/login?next=$next_link");
                $this->output->set_content_type('application/json')->set_output(json_encode($result));
                return false;
            }else{
                redirect("auth/login?next=$next_link");
            }
        }
        elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
        {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }
        else
        {
            // set the flash data error message if there is one

            $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $data['success_message']  = $this->session->flashdata('success_message');
            $meta['page_title']       = lang('items');
            $data['page_title']       = lang('chart_of_accounts');
            $data['page_subheading']  = lang('items_subheading');
             $meta['breadcrum_false'] = true;


            $this->load->view ( 'templates/head' , $meta );
            $this->load->view ( 'templates/header' );
            $this->load->view ( 'accounts/index' , $data );
            $this->load->view ( 'templates/footer' , $meta );
        }
    } 


    public function getData(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->load->library('datatables');
        
        $this->datatables
        ->setsColumns("account_number,description,status,id")
        ->select("account_number,status,description,id", false)
        ->from("accounts");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }



    public function create ()
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
        $this->data['title'] = lang('edit_user_heading');

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
        {
            redirect('auth', 'refresh');
        }


        $this->form_validation->set_rules('account_number',          "lang:account_number",          'required|xss_clean');
        $this->form_validation->set_rules('description',   "lang:description",   'xss_clean');
        $this->form_validation->set_rules('status',   "lang:status",   'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data_account = array("account_number"=>$this->input->post('account_number'),"description"=>$this->input->post('description'),"status"=>$this->input->post('status'));
           
           
        }
        if ( $this->form_validation->run() == true && $this->account_model->add($data_account))
        {


            $data = array(
                "status" => "success",
                "message" => lang("create_account_success")
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        if( !$this->form_validation->run() && !validation_errors() && !$this->ion_auth->errors() ){
            // display the edit user form
            $this->data['csrf'] = $this->_get_csrf_nonce();
            // pass the user to the view
           
           
            $this->data['account_number'] = array(
                'name'  => 'account_number',
                'id'    => 'account_number',
                'type'  => 'number',
                'class' => 'form-control',
                'autocomplete' => 'off'
            );
            $this->data['description'] = array(
                'name'  => 'description',
                'id'    => 'description',
                'type'  => 'text',
                'class' => 'form-control',
                'autocomplete' => 'off'
            );
            
            
            $this->_render_page('accounts/create', $this->data);
        }
    
    }



    public function edit($id)
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
        $this->data['title'] = lang('edit_user_heading');

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
        {
            redirect('auth', 'refresh');
        }

        $account = $this->account_model->getByID($id);


        $this->form_validation->set_rules('account_number',          "lang:account_number",          'required|xss_clean');
        $this->form_validation->set_rules('description',   "lang:description",   'xss_clean');
        $this->form_validation->set_rules('status',   "lang:status",   'xss_clean');


         if ($this->form_validation->run() == true)
        {
            $data_account = array("account_number"=>$this->input->post('account_number'),"description"=>$this->input->post('description'),"status"=>$this->input->post('status'));
           
           
        }
        if ( $this->form_validation->run() == true && $this->account_model->update($id, $data_account))
        {


            $data = array(
                "status" => "success",
                "message" => lang("edit_account_success")
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        if( !$this->form_validation->run() && !validation_errors() && !$this->ion_auth->errors() ){
            // display the edit user form
            $this->data['csrf'] = $this->_get_csrf_nonce();

           
            $this->data['account_number'] = array(
                'name'  => 'account_number',
                'id'    => 'account_number',
                'type'  => 'number',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('account_number', $account->account_number),
                'autocomplete' => 'off'
            );
            $this->data['description'] = array(
                'name'  => 'description',
                'id'    => 'description',
                'type'  => 'text',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('description', $account->description),
                'autocomplete' => 'off'
            );

            
            $this->data['account'] = $account;
            $this->_render_page('accounts/edit', $this->data);
        }
    }


    public function deactivate($id)
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
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }

        $update_data = array("status"=> 0);
        $this->account_model->update($id, $update_data);
        $data = array(
                "status" => "success",
                "message" => lang("inactivate_account_success")
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }


    public function activate($id)
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
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }



        $update_data = array("status"=> 1);
        $this->account_model->update($id, $update_data);
        $data = array(
                "status" => "success",
                "message" => lang("activate_account_success")
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }


    public function delete($id)
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
        if ( $this->account_model->delete($id) )
        {
            $result = array("status"=>"success", "message"=>lang("account_deleted"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("cant_delete_account"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key   = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    public function _valid_csrf_nonce()
    {
        return TRUE;
    }

    public function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
    {
        $this->viewdata = (empty($data)) ? $this->data: $data;
        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);
        if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
    }


    public function getAccount()
    {
        
        $account =  $this->account_model->getByColumn ("account_number" , $_POST['account']);
        echo json_encode($account[0]);
        exit();

    }





   


}
