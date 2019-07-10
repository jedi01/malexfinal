<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends MY_Controller
{
    /**
    * Calendar constructor.
    */
    public function __construct ()
    {
        parent::__construct ();
        // Load Calendar Model
        $this->load->model ( 'calendar_model' );
        // Load Helper Language
        $this->load->helper('language');
        // Load Helper Date Format
        $this->load->helper('date_format');
        // Check user is logged in ?
        if ( !$this->ion_auth->logged_in () ) {
            if ($this->input->is_ajax_request()) {
                $next_link = urlencode("/calendar");
                $result = array("status"=>"redirect", "message"=>site_url("auth/login?next=$next_link"));
                die(json_encode($result));
            }else{
                $next_link = urlencode(substr("$_SERVER[REQUEST_URI]", stripos("$_SERVER[REQUEST_URI]", "index.php")+9));
                redirect("auth/login?next=$next_link");
            }
        }
        if( !$this->settings_model->SYS_Settings->reminder_enable ){
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/", 'refresh');
        }
        if ( $this->ion_auth->in_group(array("customer", "supplier")) )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/", 'refresh');
        }
    }
    public function test()
    {
        $this->calendar_model->send_reminders();
    }

    public function index()
    {
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('calendar');
        $data['page_title']       = lang('calendar');
        $meta['page_subheading']  = lang('calendar_subheading');

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'calendar/calendar' , $data );
        $this->load->view ( 'templates/footer' , $meta );
    }

    function add ()
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
        $this->form_validation->set_rules('event[name]',               "lang:name",               'required|xss_clean');
        $this->form_validation->set_rules('event[start_date]',         "lang:start_date",         'required|xss_clean');

        $this->form_validation->set_rules('event[emails]',             "lang:emails",             'required|valid_emails|xss_clean');
        $this->form_validation->set_rules('event[additional_content]', "lang:additional_content", 'xss_clean');
        $this->form_validation->set_rules('event[subject]',            "lang:email_subject",      'required|xss_clean');
        $this->form_validation->set_rules('event[attachments]',        "lang:attachments",        'xss_clean');

        if ( $this->input->post ( "event[repeat_type]" ) != -1 && !isset( $_POST[ 'add_show_no_end' ] ) ) {
            $this->form_validation->set_rules ( 'event[end_date]' , "lang:end_date" , 'required|xss_clean' );
        }
        if ( in_array($this->input->post ( "event[repeat_type]" ), array(0,1,4,5)) ) {
            $this->form_validation->set_rules ( 'event[repeat_days][]' , "lang:repeat_days" , 'required|xss_clean' );
        }
        if ( $this->form_validation->run () == true ) {
            $data = $this->input->post("event");
            $data['start_date']     = date_JS_MYSQL($data['start_date']);
            if ( $data[ "repeat_type" ] == "-1" ) { // no repeat
                $data[ "repeat_days" ] = null;
                $data[ "no_end" ] = null;
                $data[ "end_date" ] = null;
            } elseif ( $data[ "repeat_type" ] == "2" || $data[ "repeat_type" ] == "6" ) { // monthly
                $data[ "repeat_days" ] = null;
                if ( !isset( $_POST[ 'add_show_no_end' ] ) ) {
                    $data[ "no_end" ] = false;
                    $data['end_date'] = date_JS_MYSQL($data['end_date']);
                } else {
                    $data[ "no_end" ] = true;
                    $data[ "end_date" ] = null;
                }
            } else { // week
                if ( $this->input->post ( "event[repeat_days]" ) ) {
                    $data[ "repeat_days" ] = implode ( "," , $this->input->post ( "event[repeat_days]" ) );
                } else {
                    $data[ "repeat_days" ] = null;
                }
                if ( !isset( $_POST[ 'add_show_no_end' ] ) ) {
                    $data[ "no_end" ] = false;
                    $data['end_date'] = date_JS_MYSQL($data['end_date']);
                } else {
                    $data[ "no_end" ] = true;
                    $data[ "end_date" ] = null;
                }
            }
            if( isset($data['attachments']) && $data['attachments'] != "" ){
                $data['attachments'] = json_encode($data['attachments']);
            }
        }
        if ( $this->form_validation->run () == true && $id = $this->calendar_model->add($data) ) {
            $data = array("status" => "success","message" => lang("reminder_add_success"));
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
                if( $this->input->get("name") ){
                    $data["name"] = $this->input->get("name");
                }
                if( $this->input->get("emails") ){
                    $data["emails_list"] = $this->input->get("emails");
                }
                if( $this->input->get("date") ){
                    $data["date"] = $this->input->get("date");
                }
                $data['page_title']       = lang('create_reminder');
                $data['page_subheading']  = lang('create_reminder_subheading');
                $this->load->view ( 'calendar/create' , $data );
            }
        }
    }

    public function edit ($id = false)
    {
        if ( $this->input->get ( 'id' ) ) {$id = $this->input->get ( 'id' );}
        if ( $this->ion_auth->in_group(array("customer", "supplier")) )
        {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( !$id || !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->form_validation->set_rules('event[name]',               "lang:name",               'required|xss_clean');
        $this->form_validation->set_rules('event[start_date]',         "lang:start_date",         'required|xss_clean');

        $this->form_validation->set_rules('event[emails]',             "lang:emails",             'required|valid_emails|xss_clean');
        $this->form_validation->set_rules('event[additional_content]', "lang:additional_content", 'xss_clean');
        $this->form_validation->set_rules('event[subject]',            "lang:email_subject",      'required|xss_clean');
        $this->form_validation->set_rules('event[attachments]',        "lang:attachments",        'xss_clean');

        if ( $this->input->post ( "event[repeat_type]" ) != -1 && !isset( $_POST[ 'add_show_no_end' ] ) ) {
            $this->form_validation->set_rules ( 'event[end_date]' , "lang:end_date" , 'required|xss_clean' );
        }
        if ( in_array($this->input->post ( "event[repeat_type]" ), array(0,1,4,5)) ) {
            $this->form_validation->set_rules ( 'event[repeat_days][]' , "lang:repeat_days" , 'required|xss_clean' );
        }
        if ( $this->form_validation->run () == true ) {
            $data = $this->input->post("event");
            $data['start_date']     = date_JS_MYSQL($data['start_date']);
            $data['additional_content'] = ($data['additional_content']);
            if ( $data[ "repeat_type" ] == "-1" ) { // no repeat
                $data[ "repeat_days" ] = null;
                $data[ "no_end" ] = null;
                $data[ "end_date" ] = null;
            } elseif ( $data[ "repeat_type" ] == "2" || $data[ "repeat_type" ] == "6" ) { // monthly
                $data[ "repeat_days" ] = null;
                if ( !isset( $_POST[ 'add_show_no_end' ] ) ) {
                    $data[ "no_end" ] = false;
                    $data['end_date'] = date_JS_MYSQL($data['end_date']);
                } else {
                    $data[ "no_end" ] = true;
                    $data[ "end_date" ] = null;
                }
            } else { // week
                if ( $this->input->post ( "event[repeat_days]" ) ) {
                    $data[ "repeat_days" ] = implode ( "," , $this->input->post ( "event[repeat_days]" ) );
                } else {
                    $data[ "repeat_days" ] = null;
                }
                if ( !isset( $_POST[ 'add_show_no_end' ] ) ) {
                    $data[ "no_end" ] = false;
                    $data['end_date'] = date_JS_MYSQL($data['end_date']);
                } else {
                    $data[ "no_end" ] = true;
                    $data[ "end_date" ] = null;
                }
            }
            if( isset($data['attachments']) && $data['attachments'] != "" ){
                $data['attachments'] = json_encode($data['attachments']);
            }
        }
        if ( $this->form_validation->run () == true && $this->calendar_model->update ( $id , $data) ) {
            $data = array("status" => "success","message" => lang("reminder_edit_success"));
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
                $calendar = $this->calendar_model->getByID ( $id );
                if( trim($calendar->attachments) != "" ){
                    $this->load->model('files_model');
                    $data['attached_files']  = $this->files_model->getByID(json_decode($calendar->attachments));
                }
                $data['calendar']         = $calendar;
                $data['page_title']       = lang('edit_reminder');
                $data['page_subheading']  = lang('edit_reminder_subheading');
                $this->load->view ( 'calendar/edit' , $data );
            }
        }
    }

    public function delete ($id = false)
    {
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( $this->input->post ( 'id' ) ) {
            $id = $this->input->post ( 'id' );
        }
        if ( $id && $this->calendar_model->delete ( $id ) ) {
            $data = array("status" => "success","message" => lang("reminder_delete_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function eventsfeed ()
    {
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $start = $this->input->post ( "start" );
        $end = $this->input->post ( "end" );
        if ( $start && $end ) {
            $result = $this->calendar_model->events_feed ( $start , $end ) ;
        } else {
            $result = array();
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function moveShow ()
    {
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $day = $this->input->post ( "day" );
        $id = $this->input->post ( "id" );

        $condition = isset( $_POST[ 'day' ] )
                    && isset( $_POST[ 'id' ] )
                    && is_int(intval($id))
                    && is_int(intval($day));

        if ( $condition && $this->calendar_model->moveshow ( $id , $day ) ) {
            //output to json format
            echo json_encode ( array ( "status" => "success" , "message" => $id ) );
        } else {
            //output to json format
            echo json_encode ( array ( "status" => "error" , "message" => "AJAX Error" ) );
        }
    }

}

/* End of file Calendar.php */
/* Location: ./application/controllers/Calendar.php */
