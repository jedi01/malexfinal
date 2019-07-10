<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contracts extends MY_Controller {
    /**
     * Contracts constructor.
     */
    public function __construct ()
    {
        parent::__construct ();
        // Load Contracts Model
        $this->load->model ( 'contracts_model' );
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
        if( !ENABLE_CONTRACTS ){
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/");
        }
        // Check user is logged in ?
        if ( !$this->ion_auth->logged_in () ) {
            if ($this->input->is_ajax_request()) {
                $next_link = urlencode("/contracts");
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
        $meta['page_title']       = lang('contracts');
        $data['page_title']       = lang('contracts');
        $data['page_subheading']  = lang('contracts_subheading');

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'contracts/contracts' , $data );
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
            $this->datatables->where("contracts.biller_id", BILLER_ID);
        }
        if( $this->input->post('biller_id') ){
            $this->datatables->where("contracts.biller_id", $this->input->post('biller_id'));
        }
        if( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() ){
            $this->datatables->where("contracts.user_id", USER_ID);
        }
        $this->datatables
        ->setsColumns("checkbox,id,reference,subject,fullname,biller_id,date,date_due,type,amount,status,attachments,currency")
        ->select("contracts.id as checkbox,contracts.id as id,reference,subject,IF(biller.company='',biller.fullname, biller.company) as fullname,biller_id,date,date_due,type,amount, IF(contracts.date>'".date("Y-m-d")."', 'panding', IF(contracts.date_due<'".date("Y-m-d")."', 'expired', 'active')) as status, attachments,currency", false)
        ->join("biller", "contracts.biller_id=biller.id")
        ->from("contracts");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }

    public function create()
    {
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->form_validation->set_rules('contract[subject]',     "lang:subject",     'required|xss_clean');
        $this->form_validation->set_rules('contract[amount]',      "lang:amount",      'required|xss_clean');
        $this->form_validation->set_rules('contract[biller_id]',   "lang:customer",   'required|xss_clean');
        $this->form_validation->set_rules('contract[type]',        "lang:contract_type", 'required|xss_clean');
        $this->form_validation->set_rules('contract[date]',        "lang:date",        'required|xss_clean');
        $this->form_validation->set_rules('contract[date_due]',    "lang:date_due",    'xss_clean');
        $this->form_validation->set_rules('contract[description]', "lang:description", 'xss_clean');
        $this->form_validation->set_rules('contract[attachments]', "lang:attachments", 'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data = $this->input->post("contract");
            $data['date']     = date_JS_MYSQL($data['date']);
            if( isset($data['date_due']) && $data['date_due'] != "" ){
                $data['date_due'] = date_JS_MYSQL($data['date_due']);
            }else{
                $data['date_due'] = NULL;
            }
            if( $data['count'] == "0" ){
                $next_reference    = $this->contracts_model->next_reference();
                $data['reference'] = $next_reference["reference"];
                $data['count']     = $next_reference["next_count"];
            }
            $data['user_id']  = USER_ID;
            if( isset($data['attachments']) && $data['attachments'] != "" ){
                $data['attachments'] = json_encode($data['attachments']);
            }
        }
        if ( $this->form_validation->run() == true && $this->contracts_model->add($data))
        {
            // update settings next count
            $this->settings_model->updateSettingsItem("contract_next", $data['count']+1);
            $data = array("status" => "success","message" => lang("contract_add_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array("status"=>"error","message"=>(validation_errors()?validation_errors():$this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array());
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                $next_reference           = $this->contracts_model->next_reference();
                $data['next_reference']   = $next_reference["reference"];
                $data['next_count']       = $next_reference["next_count"];
                $data['page_title']       = lang('create_contract');
                $data['page_subheading']  = lang('create_contract_subheading');
                $this->load->view ( 'contracts/create' , $data );
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
        if ( !$id || !($contract = $this->contracts_model->getByID($id)) || !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $contract->user_id != USER_ID ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        $this->form_validation->set_rules('contract[subject]',     "lang:subject",     'required|xss_clean');
        $this->form_validation->set_rules('contract[amount]',      "lang:amount",      'required|xss_clean');
        $this->form_validation->set_rules('contract[biller_id]',   "lang:customer",    'required|xss_clean');
        $this->form_validation->set_rules('contract[type]',        "lang:contract_type", 'required|xss_clean');
        $this->form_validation->set_rules('contract[date]',        "lang:date",        'required|xss_clean');
        $this->form_validation->set_rules('contract[date_due]',    "lang:date_due",    'xss_clean');
        $this->form_validation->set_rules('contract[description]', "lang:description", 'xss_clean');
        $this->form_validation->set_rules('contract[attachments]', "lang:attachments", 'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data = $this->input->post("contract");
            $data['date']     = date_JS_MYSQL($data['date']);
            if( isset($data['date_due']) && $data['date_due'] != "" ){
                $data['date_due'] = date_JS_MYSQL($data['date_due']);
            }else{
                $data['date_due'] = NULL;
            }
            if( $data['count'] == "0" ){
                $next_reference      = $this->contracts_model->next_reference($contract->count);
                $data['reference']   = $next_reference["reference"];
                $data['count']       = $next_reference["next_count"];
            }
            if( isset($data['attachments']) && $data['attachments'] != "" ){
                $data['attachments'] = json_encode($data['attachments']);
            }
            $id = $this->input->post('id');
        }
        if ( $this->form_validation->run() == true && $this->contracts_model->update($id, $data))
        {
            $data = array("status" => "success", "message" => lang("contract_edit_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array("status"=>"error","message"=>(validation_errors()?validation_errors():$this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array());
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                if( trim($contract->attachments) != "" ){
                    $this->load->model('files_model');
                    $data['attached_files']  = $this->files_model->getByID(json_decode($contract->attachments));
                }
                $data['page_title']      = lang('edit_contract');
                $data['page_subheading'] = lang('edit_contract_subheading');
                $data['contract']        = $contract;
                $data['biller']          = $this->biller_model->getByID($contract->biller_id);

                $this->load->view ( 'contracts/edit' , $data );
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

        if ( $this->contracts_model->delete($id) )
        {
            $result = array("status"=>"success", "message"=>lang("contract_deleted"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("cant_delete_contract"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }


    public function open($id = false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        if( $this->input->get('id') ){ $id = $this->input->get('id'); }
        if ( !$id || !($contract = $this->contracts_model->getByID($id)) ) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $contract->user_id != USER_ID ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        $biller                  = $this->biller_model->getByID($contract->biller_id);
        $data['contract']        = $contract;
        $data['biller']          = $biller;
        $data['message']         = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
        $meta['page_title']      = $contract->subject;
        $data['page_title']      = lang("contract");
        $data['page_subheading'] = $contract->subject;

        /* PREVIEW START */
        $Page_content = array();
        $Page_content[] = $this->load->view ( 'contracts/view', $data , true );
        $data_print_page['show_btn_config']   = false;
        $data_print_page['is_preview']        = true;
        $data_print_page['show_center_title'] = true;
        $data_print_page['enable_signature']  = true;
        $data_print_page['show_signature_2']  = true;
        $data_print_page['page_title']        = lang("contract");
        $data_print_page['meta_title']        = lang("contract");
        $data_print_page['Page_content']      = $Page_content;
        $preview = $this->load->view ( 'templates/printing_template' , $data_print_page, true );
        /* PREVIEW END */
        $data['preview']         = $preview;
        if( trim($contract->attachments) != "" ){
            $this->load->model('files_model');
            $data['attached_files']  = $this->files_model->getByID(json_decode($contract->attachments));
        }

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'contracts/preview' , $data );
        $this->load->view ( 'templates/footer' , $meta );
    }

    public function view($id = NULL, $isPDF = false)
    {
        if($this->input->get('id')) { $id = $this->input->get('id'); }
        if($id) { $id = explode(",", $id); }
        if( !$id ){
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect('/', 'refresh');
        }
        $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

        $Page_content = array();
        foreach ($id as $contract_id) {
            $contract                 = $this->contracts_model->getByID($contract_id);
            if ( defined("BILLER_ID") && BILLER_ID != $contract->biller_id ){
                return show_error(lang("access_denied"));
            }
            $biller                   = $this->biller_model->getByID($contract->biller_id);
            $data['contract']         = $contract;
            $data['biller']           = $biller;
            $data['page_title']       = lang("contract");
            $Page_content[] = $this->load->view ( 'contracts/view' , $data , true );
        }
        if( count($id) == 1 ){
            $page_title = $contract->subject;
        }else{
            $page_title = lang("contracts");
        }

        // PRINT TEMPLATE
        $data_print_page['show_center_title'] = true;
        $data_print_page['enable_signature']  = true;
        $data_print_page['show_signature_2']  = true;
        $data_print_page['page_title']        = lang("contract");
        $data_print_page['meta_title']        = lang("contract");
        $data_print_page['Page_content']      = $Page_content;
        if( $isPDF ){
            $data_print_page['isPDF']         = true;
            return array(
                "filename" => $page_title,
                "html"     => $this->load->view ( 'templates/printing_template' , $data_print_page, true )
            );
        }
        $this->load->view ( 'templates/printing_template' , $data_print_page );
    }

    public function pdf($id = NULL, $stream = TRUE)
    {
        $view =  $this->view($id, true);
        $html = $view["html"];
        $filename = $view["filename"];

        $html = str_replace("row", "row-cols", $html);
        $html = str_replace("col-xs-", "col-", $html);
        $html = str_replace("<hr>", "<div class=\"hr\"></div>", $html);
        $this->load->helper(array('dompdf', 'file'));

        if( $stream ){
            return pdf_create($html, $filename, $stream);
        }else{
            $pdf_link     = FCPATH.("storage/".$filename.".pdf");
            $pdf_file     = pdf_create($html, $filename, false);
            file_put_contents($pdf_link, $pdf_file);
            return $pdf_link;
        }
    }

    public function email($id = NULL, $email = NULL)
    {
        if($this->input->get('id')) { $id = $this->input->get('id'); }
        if( !$id || !$this->input->is_ajax_request() ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        $this->form_validation->set_rules('emails',             "lang:emails",             'required|valid_emails|xss_clean');
        $this->form_validation->set_rules('additional_content', "lang:additional_content", 'xss_clean');
        $this->form_validation->set_rules('subject',            "lang:email_subject",      'required|xss_clean');
        $this->form_validation->set_rules('cc',                 "lang:email_cc",           'xss_clean|valid_emails');
        $this->form_validation->set_rules('bcc',                "lang:email_bcc",          'xss_clean|valid_emails');

        $template = $this->settings_model->getEmailTemplate("send_contracts_to_customer.tpl", LANGUAGE);
        $company  = $this->settings_model->getSettings("COMPANY");
        $contract = $this->contracts_model->getByID($id);
        $biller   = $this->biller_model->getByID($contract->biller_id);

        if ($this->form_validation->run() == true)
        {
            $this->load->library(array('email'));

            $email_config = objectToArray($this->settings_model->email_Settings);
            $emails       = explode(",", $this->input->post('emails'));

            $data['email_content'] = $this->input->post('content');
            $message = $this->load->view("email/standard.tpl.php", $data, true);
            $this->email->initialize($email_config);
            $this->email->clear();
            $this->email->from(COMPANY_EMAIL, COMPANY_NAME);
            $this->email->to($emails);
            if( $this->input->post("cc") ){
                $this->email->cc($this->input->post("cc"));
            }
            if( $this->input->post("bcc") ){
                $this->email->bcc($this->input->post("bcc"));
            }
            $this->email->subject($this->input->post("subject"));
            $this->email->message($message);
            if( $this->input->post("attach_pdf") ){
                $pdf = $this->pdf($id, false);
                $this->email->attach($pdf);
            }
            if( $this->input->post("attached_file") ){
                $this->load->model('files_model');
                $files = $this->files_model->getByID($this->input->post("attached_file"));
                foreach ($files as $file) {
                    $this->email->attach(realpath($file->realpath));
                }
            }
        }

        if ( $this->form_validation->run() == true )
        {
            if ( $this->email->send() )
            {
                $result = array("status"=>"success", "message"=>lang("email_successful"));
                $this->output->set_content_type('application/json')->set_output(json_encode($result));
                return true;
            }
            $result = array("status"=>"error", "message"=>lang("email_unsuccessful"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }else{
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array(
                    "status" => "error",
                    "message" => (validation_errors() ? validation_errors() : $this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array()
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                $emails                  = $this->contracts_model->getContractsEmails($id);
                $data['id']              = $id;
                $data['emails_list']     = $emails;
                $data['page_title']      = lang('send_email');
                $data['email_type']      = lang('contract');
                $data['email_subject']   = parse_object_sis($template->subject, $company, false, $biller, $contract);
                $data['email_content']   = parse_object_sis($template->content, $company, false, $biller, $contract);
                $data['email_cc']        = COMPANY_EMAIL;
                $data['form_action']     = "contracts/email?id=".$id;
                $this->load->view ( 'global/email' , $data );
            }
        }
    }

    public function suggestions_type(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $term = $this->input->get('term')?$this->input->get('term'):"";
        $items = $this->contracts_model->suggestions_type($term);
        $this->output->set_content_type('application/json')->set_output(json_encode($items));
    }

    public function download_attachment($id = false){
        if( $this->input->get('id') ){$id = $this->input->get('id');}
        if ( !$id || !($contract = $this->contracts_model->getByID($id)) ) {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/contracts", 'refresh');
        }
        if( trim($contract->attachments) != "" ){
            $this->load->model('files_model');
            $files = $this->files_model->getByID(json_decode($contract->attachments));
            foreach ($files as $file) {
                $links[] = $file->link;
            }
            redirect('/files/download/'.implode(",", $links),'refresh');
        }else{
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/contracts", 'refresh');
        }
    }
}

/* End of file Contracts.php */
/* Location: ./application/controllers/Contracts.php */
