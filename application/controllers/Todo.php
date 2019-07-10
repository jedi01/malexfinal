<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo extends MY_Controller {
    /**
     * Todo constructor.
     */
    public function __construct ()
    {
        parent::__construct ();
        // Load Todo Model
        $this->load->model ( 'todo_model' );
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
                $next_link = urlencode("/todo");
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
        $meta['page_title']       = lang('todo_list');
        $data['page_title']       = lang('todo_list');

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'todo/todo' , $data );
        $this->load->view ( 'templates/footer' , $meta );
    }

    public function getData(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->load->library('datatables');
        if ( $this->input->post('f') && $this->input->post('v') )
        {
            $v = $this->input->post('v');
            if( strpos($v, "~") === false ){
                $this->datatables->setFilter($this->input->post('f'), "=".$this->input->post('v'));
            }else{
                $this->datatables->setFilter($this->input->post('f'), $this->input->post('v'));
            }
        }
        $this->datatables
        ->setsColumns("subject,date,date_due,priority,description,attachments,status,id,complete")
        ->select("id,subject,date,date_due,priority,IF(date>'".date("Y-m-d")."', 'panding', IF(date_due<'".date("Y-m-d")."', 'expired', 'active')) as status,description,attachments,complete", false)
        ->where("todo.user_id", USER_ID)
        ->from("todo");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }

    public function create()
    {
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->form_validation->set_rules('todo[subject]',     "lang:subject",     'required|xss_clean');
        $this->form_validation->set_rules('todo[priority]',    "lang:priority",    'required|xss_clean');
        $this->form_validation->set_rules('todo[date]',        "lang:date",        'required|xss_clean');
        $this->form_validation->set_rules('todo[date_due]',    "lang:date_due",    'xss_clean');
        $this->form_validation->set_rules('todo[description]', "lang:description", 'xss_clean');
        $this->form_validation->set_rules('todo[attachments]', "lang:attachments", 'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data = $this->input->post("todo");
            $data['date']     = date_JS_MYSQL($data['date']);
            if( isset($data['date_due']) && $data['date_due'] != "" ){
                $data['date_due'] = date_JS_MYSQL($data['date_due']);
            }else{
                $data['date_due'] = NULL;
            }
            if( isset($data['attachments']) && $data['attachments'] != "" ){
                $data['attachments'] = json_encode($data['attachments']);
            }
            $data['user_id'] = USER_ID;
        }
        if ( $this->form_validation->run() == true && $this->todo_model->add($data))
        {
            $data = array("status" => "success","message" => lang("todo_add_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array("status"=>"error","message"=>(validation_errors()?validation_errors():$this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array());
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                $data['page_title']       = lang('create_todo');
                $this->load->view ( 'todo/create' , $data );
            }
        }
    }


    public function edit($id = false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if( $this->input->get('id') ){ $id = $this->input->get('id'); }
        if ( !$id || !($todo = $this->todo_model->getByID($id)) || !$this->input->is_ajax_request() || $todo->user_id != USER_ID) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->form_validation->set_rules('todo[subject]',     "lang:subject",     'required|xss_clean');
        $this->form_validation->set_rules('todo[priority]',    "lang:priority",    'required|xss_clean');
        $this->form_validation->set_rules('todo[date]',        "lang:date",        'required|xss_clean');
        $this->form_validation->set_rules('todo[date_due]',    "lang:date_due",    'xss_clean');
        $this->form_validation->set_rules('todo[description]', "lang:description", 'xss_clean');
        $this->form_validation->set_rules('todo[attachments]', "lang:attachments", 'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data = $this->input->post("todo");
            $data['date']     = date_JS_MYSQL($data['date']);
            if( isset($data['date_due']) && $data['date_due'] != "" ){
                $data['date_due'] = date_JS_MYSQL($data['date_due']);
            }else{
                $data['date_due'] = NULL;
            }
            if( isset($data['attachments']) && $data['attachments'] != "" ){
                $data['attachments'] = json_encode($data['attachments']);
            }
            $id = $this->input->post('id');
        }
        if ( $this->form_validation->run() == true && $this->todo_model->update($id, $data))
        {
            $data = array("status" => "success", "message" => lang("todo_edit_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array("status"=>"error","message"=>(validation_errors()?validation_errors():$this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array());
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                if( trim($todo->attachments) != "" ){
                    $this->load->model('files_model');
                    $data['attached_files']  = $this->files_model->getByID(json_decode($todo->attachments));
                }
                $data['page_title']      = lang('edit_todo');
                $data['todo']            = $todo;
                $this->load->view ( 'todo/edit' , $data );
            }
        }
    }

    public function delete($id = false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if( $this->input->get('id') ){ $id = $this->input->get('id'); }
        if ( !$id || !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( $this->todo_model->delete($id) )
        {
            $result = array("status"=>"success", "message"=>lang("todo_delete_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
    }

    public function complete($id = false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if( $this->input->get('id') ){ $id = $this->input->get('id'); }
        if ( !$id || !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( $this->todo_model->complete($id) )
        {
            $result = array("status"=>"success", "message"=>lang("todo_complete_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
    }

    public function download_attachment($id = false){
        if( $this->input->get('id') ){$id = $this->input->get('id');}
        if ( !$id || !($todo = $this->todo_model->getByID($id)) ) {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/todo", 'refresh');
        }
        if( trim($todo->attachments) != "" ){
            $this->load->model('files_model');
            $files = $this->files_model->getByID(json_decode($todo->attachments));
            foreach ($files as $file) {
                $links[] = $file->link;
            }
            redirect('/files/download/'.implode(",", $links),'refresh');
        }else{
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/todo", 'refresh');
        }
    }
}

/* End of file todo.php */
/* Location: ./application/controllers/todo.php */
