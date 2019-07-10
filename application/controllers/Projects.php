<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends MY_Controller {
    /**
     * Projects constructor.
     */
    public function __construct ()
    {
        parent::__construct ();
        // Load Projects Model
        $this->load->model ( 'projects_model' );
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
                $next_link = urlencode("/projects");
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
        $meta['page_title']       = lang('projects');
        $data['page_title']       = lang('projects');
        $data['page_subheading']  = lang('projects_subheading');

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'projects/projects' , $data );
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
        if( defined("BILLER_ID") ){
            $this->datatables->where("projects.biller_id", BILLER_ID);
        }
        if( $this->input->post('biller_id') ){
            $this->datatables->where("projects.biller_id", $this->input->post('biller_id'));
        }
        if( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() ){
            $this->datatables->where("projects.user_id", USER_ID);
        }
        $this->datatables
        ->setsColumns("checkbox,id,name,date,date_due,fullname,billing_type,status,members,biller_id,currency")
        ->select("projects.id as checkbox,projects.id as id,name,date,date_due,IF(biller.company='',biller.fullname, biller.company) as fullname,billing_type,status,members,biller_id,currency", false)
        ->join("biller", "projects.biller_id=biller.id")
        ->from("projects");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }

    public function create()
    {
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->form_validation->set_rules('project[name]',        "lang:project_name",     'required|xss_clean');
        $this->form_validation->set_rules('project[biller_id]',   "lang:customer",         'required|xss_clean');
        $this->form_validation->set_rules('project[billing_type]',"lang:project_type",     'required|xss_clean');
        $this->form_validation->set_rules('project[status]',      "lang:status",           'required|xss_clean');
        $this->form_validation->set_rules('project[date]',        "lang:date",             'required|xss_clean');
        $this->form_validation->set_rules('project[date_due]',    "lang:date_due",         'xss_clean');
        $this->form_validation->set_rules('project[estimated_hours]',"lang:estimated_hours",'required|xss_clean');
        $this->form_validation->set_rules('project[rate]',        "lang:rate",             'xss_clean');
        $this->form_validation->set_rules('project[description]', "lang:description",      'xss_clean');
        $this->form_validation->set_rules('project[members][]',   "lang:members",          'required|xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data = $this->input->post("project");
            $data['date']     = date_JS_MYSQL($data['date']);
            if( isset($data['date_due']) && $data['date_due'] != "" ){
                $data['date_due'] = date_JS_MYSQL($data['date_due']);
            }else{
                $data['date_due'] = NULL;
            }
            $data['members']  = json_encode($data['members']);
            $data['user_id']  = USER_ID;
        }
        if ( $this->form_validation->run() == true && $this->projects_model->add($data))
        {
            $data = array("status" => "success","message" => lang("project_add_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array("status"=>"error","message"=>(validation_errors()?validation_errors():$this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array());
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                $data['page_title']       = lang('create_project');
                $data['page_subheading']  = lang('create_project_subheading');
                $this->load->view ( 'projects/create' , $data );
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
        if ( !$id || !($project = $this->projects_model->getByID($id)) || !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $project->user_id != USER_ID ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->form_validation->set_rules('project[name]',        "lang:project_name",     'required|xss_clean');
        $this->form_validation->set_rules('project[biller_id]',   "lang:customer",         'required|xss_clean');
        $this->form_validation->set_rules('project[billing_type]',"lang:project_type",     'required|xss_clean');
        $this->form_validation->set_rules('project[status]',      "lang:status",           'required|xss_clean');
        $this->form_validation->set_rules('project[date]',        "lang:date",             'required|xss_clean');
        $this->form_validation->set_rules('project[date_due]',    "lang:date_due",         'xss_clean');
        $this->form_validation->set_rules('project[estimated_hours]',"lang:estimated_hours",'required|xss_clean');
        $this->form_validation->set_rules('project[rate]',        "lang:rate",             'xss_clean');
        $this->form_validation->set_rules('project[description]', "lang:description",      'xss_clean');
        $this->form_validation->set_rules('project[members][]',   "lang:members",          'required|xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data = $this->input->post("project");
            $data['date']     = date_JS_MYSQL($data['date']);
            if( isset($data['date_due']) && $data['date_due'] != "" ){
                $data['date_due'] = date_JS_MYSQL($data['date_due']);
            }else{
                $data['date_due'] = NULL;
            }
            $data['members']  = json_encode($data['members']);
            $data['user_id']  = USER_ID;
            $id = $this->input->post('id');
        }
        if ( $this->form_validation->run() == true && $this->projects_model->update($id, $data))
        {
            $data = array("status" => "success", "message" => lang("project_edit_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array("status"=>"error","message"=>(validation_errors()?validation_errors():$this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array());
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                $data['page_title']      = lang('edit_project');
                $data['page_subheading'] = lang('edit_project_subheading');
                $data['project']         = $project;
                $data['biller']          = $this->biller_model->getByID($project->biller_id);
                $this->load->view ( 'projects/edit' , $data );
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
        if( $id ){ $id = array($id); }
        if( $this->input->get('id') ){ $id = array($this->input->get('id')); }
        if( $this->input->post('id') ){ $id = $this->input->post('id'); }
        if ( !$id || !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        if ( $this->projects_model->delete($id) )
        {
            $result = array("status"=>"success", "message"=>lang("project_deleted"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("cant_delete_project"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }


    public function open($id = false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        if( $this->input->get('id') ){ $id = $this->input->get('id'); }
        if ( !$id || !($project = $this->projects_model->getByID($id)) ) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $project->user_id != USER_ID ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        $biller                  = $this->biller_model->getByID($project->biller_id);
        $data['countTasks']      = $this->projects_model->countTasks($project->id);
        $data['countComTasks']   = $this->projects_model->countTasks($project->id, "complete");
        $data['days']            = floor((time() - strtotime($project->date)) /3600/24);
        $data['alldays']         = floor((strtotime($project->date_due) - strtotime($project->date)) /3600/24);
        if( $data['countTasks'] > 0 ){
            $project->progress = floor($data['countComTasks']*100/$data['countTasks']);
        }
        $data['overviewTasks']   = $this->projects_model->overviewTasks($project->id);
        $data['project']         = $project;
        $data['biller']          = $biller;

        $data['message']         = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
        $meta['page_title']      = $project->name;
        $data['page_title']      = lang("project");
        $data['page_subheading'] = lang("project_name").": ".$project->name;

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'projects/preview' , $data );
        $this->load->view ( 'templates/footer' , $meta );
    }

    // TASKS
    public function getTasksData($project_id = false){
        if (!$this->input->is_ajax_request() || !$project_id) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->load->library('datatables');
        $this->datatables
        ->setsColumns("subject,date,date_due,priority,hour_rate,description,attachments,status,id")
        ->select("subject,date,date_due,priority,hour_rate,description,attachments,status,id", false)
        ->where("projects_tasks.project_id", $project_id)
        ->from("projects_tasks");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }

    public function create_task($project_id = false)
    {
        if (!$this->input->is_ajax_request() || !$project_id) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->form_validation->set_rules('task[subject]',     "lang:subject",     'required|xss_clean');
        $this->form_validation->set_rules('task[priority]',    "lang:priority",    'required|xss_clean');
        $this->form_validation->set_rules('task[status]',      "lang:status",      'required|xss_clean');
        $this->form_validation->set_rules('task[hour_rate]',   "lang:hour_rate",   'required|xss_clean');
        $this->form_validation->set_rules('task[date]',        "lang:date",        'required|xss_clean');
        $this->form_validation->set_rules('task[date_due]',    "lang:date_due",    'xss_clean');
        $this->form_validation->set_rules('task[description]', "lang:description", 'xss_clean');
        $this->form_validation->set_rules('task[attachments]', "lang:attachments", 'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data = $this->input->post("task");
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
        if ( $this->form_validation->run() == true && $this->projects_model->addTask($data))
        {
            $data = array("status" => "success","message" => lang("task_add_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array("status"=>"error","message"=>(validation_errors()?validation_errors():$this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array());
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                $data['project_id'] = $project_id;
                $data['page_title'] = lang('create_task');
                $this->load->view ( 'projects/create_task' , $data );
            }
        }
    }

    public function edit_task($id = false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if( $this->input->get('id') ){ $id = $this->input->get('id'); }
        if ( !$id || !($task = $this->projects_model->getTaskByID($id)) || !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->form_validation->set_rules('task[subject]',     "lang:subject",     'required|xss_clean');
        $this->form_validation->set_rules('task[priority]',    "lang:priority",    'required|xss_clean');
        $this->form_validation->set_rules('task[status]',      "lang:status",      'required|xss_clean');
        $this->form_validation->set_rules('task[hour_rate]',   "lang:hour_rate",   'required|xss_clean');
        $this->form_validation->set_rules('task[date]',        "lang:date",        'required|xss_clean');
        $this->form_validation->set_rules('task[date_due]',    "lang:date_due",    'xss_clean');
        $this->form_validation->set_rules('task[description]', "lang:description", 'xss_clean');
        $this->form_validation->set_rules('task[attachments]', "lang:attachments", 'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data = $this->input->post("task");
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
        if ( $this->form_validation->run() == true && $this->projects_model->updateTask($id, $data))
        {
            $data = array("status" => "success", "message" => lang("task_edit_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array("status"=>"error","message"=>(validation_errors()?validation_errors():$this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array());
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                if( trim($task->attachments) != "" ){
                    $this->load->model('files_model');
                    $data['attached_files']  = $this->files_model->getByID(json_decode($task->attachments));
                }
                $data['page_title'] = lang('edit_task');
                $data['task']       = $task;
                $this->load->view ( 'projects/edit_task' , $data );
            }
        }
    }

    public function delete_task($id = false)
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
        if ( $this->projects_model->deleteTask($id) )
        {
            $result = array("status"=>"success", "message"=>lang("task_delete_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
    }

    public function complete_task($id = false)
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
        if ( $this->projects_model->completeTask($id) )
        {
            $result = array("status"=>"success", "message"=>lang("task_complete_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
    }

    public function download_attachment_task($id = false){
        if( $this->input->get('id') ){$id = $this->input->get('id');}
        if ( !$id || !($task = $this->projects_model->getTaskByID($id)) ) {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/projects", 'refresh');
        }
        if( trim($task->attachments) != "" ){
            $this->load->model('files_model');
            $files = $this->files_model->getByID(json_decode($task->attachments));
            foreach ($files as $file) {
                $links[] = $file->link;
            }
            redirect('/files/download/'.implode(",", $links),'refresh');
        }else{
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/projects", 'refresh');
        }
    }


}

/* End of file Projects.php */
/* Location: ./application/controllers/Projects.php */
