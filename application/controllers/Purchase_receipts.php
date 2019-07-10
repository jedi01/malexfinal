<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Smart purchase System
 *
 * A simple and powerful web app based on PHP CodeIgniter framework manage purchases.
 *
 * @package Smart purchase System
 * @author  Bessem Zitouni (bessemzitouni@gmail.com)
 * @copyright   Copyright (c) 2017
 * @since   Version 1.6.0
 * @filesource
 */

class Purchase_receipts extends MY_Controller
{
    /**
     * Receipts constructor.
     */
    public function __construct ()
    {
        parent::__construct ();
        // Load Purchase Receipts Model
        $this->load->model ( 'receipts_purchase_model' );
        // Load purchases Model
        $this->load->model('Purchase_model',"purchase");
        // Load Billers Model
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
                $next_link = urlencode("/purchase_receipts");
                $result = array("status"=>"redirect", "message"=>site_url("auth/login?next=$next_link"));
                die(json_encode($result));
            }else{
                $next_link = urlencode(substr("$_SERVER[REQUEST_URI]", stripos("$_SERVER[REQUEST_URI]", "index.php")+9));
                redirect("auth/login?next=$next_link");
            }
        }
    }

    public function index ($purchase = false)
    {
        if($this->input->get('purchase')){ $purchase = $this->input->get('purchase'); }
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $data['purchase']          = $purchase;
        $meta['page_title']       = lang('receipts');
        $data['page_title']       = lang('receipts');
        $data['page_subheading']  = lang('payments_subheading');
        if( $purchase ){
            $purchase_obj = $this->purchase->getPurchase($purchase);
            if( !$purchase_obj ){
                $this->session->set_flashdata('message', lang("access_denied"));
                redirect("/purchase_receipts", 'refresh');
            }
            $meta['breadcrumbs'] = array(
                array(
                    "link" => site_url("/purchases/"),
                    "label" => lang("purchases"),
                ),
                array(
                    "link" => site_url("/purchases/open/".$purchase_obj->id),
                    "label" => lang("purchase_no")." ".sprintf("%05s", $purchase_obj->count),
                ),
            );
        }

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'purchase_receipts/receipts' , $data );
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
            $this->datatables->setFilter($this->input->post('f'), "=".$this->input->post('v'));
        }
        if ( $this->input->post('purchase') )
        {
            $this->datatables->where("purchase_id", $this->input->post('purchase'));
        }
        if( defined("BILLER_ID") ){
            $this->datatables->where("suppliers.id", BILLER_ID);
        }
        if( $this->input->post('biller_id') ){
            $this->datatables->where("receipts_purchase.supplier_id", $this->input->post('biller_id'));
        }
        $this->datatables
        ->setsColumns("id,number,purchase,fullname,p_date,amount,method,details,purchase,supplier_id,currency")
        ->select("receipts_purchase.id as id,receipts_purchase.number as number,purchase.reference as purchase,IF(suppliers.company='',suppliers.fullname, suppliers.company) as fullname,receipts_purchase.date as p_date,receipts_purchase.amount as amount,method,details,receipts_purchase.supplier_id as supplier_id,purchase.currency as currency", false)
        ->join("purchase", "purchase.id=receipts_purchase.purchase_id", "left")
        ->join("suppliers", "suppliers.id=receipts_purchase.supplier_id", "left")
        ->from("receipts_purchase");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }

    public function create($id=FALSE)
    {
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if($this->input->get('id')){ $id = $this->input->get('id'); }
        $this->form_validation->set_rules('receipt[number]',  "lang:receipt_no",     'required|is_unique[receipts.number]|xss_clean');
        $this->form_validation->set_rules('receipt[amount]',  "lang:amount",         'required|greater_than[0]|xss_clean');
        $this->form_validation->set_rules('receipt[date]',    "lang:date",           'required|xss_clean');
        $this->form_validation->set_rules('receipt[method]',  "lang:payment_method", 'required|xss_clean');
        $this->form_validation->set_rules('receipt[purchase_id]',  "lang:purchase",    'required|xss_clean');
        $this->form_validation->set_rules('receipt[supplier_id]',  "lang:customer",    'required|xss_clean');
        $this->form_validation->set_rules('receipt[details]', "lang:details",        'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $receipt_data         = $this->input->post("receipt");
            $receipt_data['date'] = date_JS_MYSQL($receipt_data['date']);

            $purchase = $this->purchase->getPurchase($receipt_data["purchase_id"]);
            $purchase_supplier = $this->suppliers_model->getByID($receipt_data["supplier_id"]);
        }
        if ( $this->form_validation->run() == true && $this->receipts_purchase_model->create($receipt_data))
        {
            // update settings next count
            $this->settings_model->updateSettingsItem("purchase_receipt_next", $receipt_data['number']+1);
            $this->sis_logger->write('purchase', 'create_receipt', $purchase->id, "Receipt of ".$receipt_data['amount']." ".$purchase->currency." received from ".$purchase_supplier->fullname." via ".$receipt_data['method']);

            $data = array("status" => "success", "message" => lang("receipts_create_success"));
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
                if( $id ){
                    $purchase = $this->purchase->getPurchase($id);
                    $purchase_supplier = $this->suppliers_model->getByID($purchase->supplier_id);
                    $data['purchase']         = $purchase;
                    $data['supplier']          = $purchase_supplier;
                }
                $data['next_number']     = $this->receipts_purchase_model->next();
                $data['page_title']      = lang('receipts_create');
                $data['page_subheading'] = lang('receipts_create_subheading');
                $this->load->view ( 'purchase_receipts/receipts_create' , $data );
            }
        }
    }

    public function edit($id=FALSE)
    {
        if( VERSION == "DEMO" ){
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if($this->input->get('id')){ $id = $this->input->get('id'); }
        if( !$id ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $receipt = $this->receipts_purchase_model->get($id);
        $purchase = $this->purchase->getPurchase($receipt->purchase_id);
        $purchase_supplier = $this->suppliers_model->getByID($receipt->supplier_id);

        $this->form_validation->set_rules('receipt[number]',  "lang:receipt_no",     'required|xss_clean');
        $this->form_validation->set_rules('receipt[amount]',  "lang:amount",         'required|greater_than[0]|xss_clean');
        $this->form_validation->set_rules('receipt[date]',    "lang:date",           'required|xss_clean');
        $this->form_validation->set_rules('receipt[method]',  "lang:payment_method", 'required|xss_clean');
        $this->form_validation->set_rules('receipt[purchase_id]',  "lang:purchase",    'required|xss_clean');
        $this->form_validation->set_rules('receipt[supplier_id]',  "lang:customer",    'required|xss_clean');
        $this->form_validation->set_rules('receipt[details]', "lang:details",        'xss_clean');

        if( $this->input->post('receipt[number]') ){
            if( $this->input->post('receipt[number]') != $receipt->number ){
                $this->form_validation->set_rules('receipt[number]', "lang:receipt_no", 'is_unique[receipts.number]');
            }
        }

        if ($this->form_validation->run() == true)
        {
            $receipt_data         = $this->input->post("receipt");
            $receipt_data['date'] = date_JS_MYSQL($receipt_data['date']);

            $purchase = $this->purchase->getPurchase($receipt_data["purchase_id"]);
            $purchase_supplier = $this->suppliers_model->getByID($receipt_data["supplier_id"]);

        }
        if ( $this->form_validation->run() == true && $this->receipts_purchase_model->update($id, $receipt_data))
        {
            $this->sis_logger->write('purchase', 'update_receipt', $purchase->id, "Receipt of ".$receipt->amount." ".$purchase->currency." is updated to ".$receipt_data['amount']." ".$purchase->currency." received from ".$purchase_supplier->fullname." via ".$receipt_data['method']);

            $data = array("status" => "success", "message" => lang("receipts_edit_success"));
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

                $data['receipt']         = $receipt;
                $data['purchase']         = $purchase;
                $data['supplier']          = $purchase_supplier;
                $data['page_title']      = lang('receipts_edit');
                $data['page_subheading'] = lang('receipts_edit_subheading');
                $this->load->view ( 'purchase_receipts/receipts_edit' , $data );
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
        if($this->input->get('id')) { $id = array($this->input->get('id')); }
        if($this->input->post('id')) { $id = $this->input->post('id'); }
        if( !isset($id) || $id == false || !$this->input->is_ajax_request() ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        foreach ($id as $receipt_id) {
            $receipt = $this->receipts_purchase_model->get($receipt_id);
            $purchase = $this->purchase->getPurchase($receipt->purchase_id);
            $supplier  = $this->suppliers_model->getByID($receipt->supplier_id);
            if ( $this->receipts_purchase_model->delete($receipt_id) )
            {
                $this->sis_logger->write('purchase', 'delete_receipt', $purchase->id, "Receipt of ".$receipt->amount." ".$purchase->currency." received from ".$supplier->fullname." via ".$receipt->method." is deleted");
            }
        }
        $result = array("status"=>"success", "message"=>lang("receipts_deleted"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
        return true;
    }

    public function view($id = FALSE, $isPDF = false)
    {
        if($this->input->get('id')) { $id = $this->input->get('id'); }
        if($id) { $id = explode(",", $id); }
        if( !$id ){
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect('/', 'refresh');
        }
        $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
        $Page_content = array();
        foreach ($id as $receipt_id) {
            $receipt = $this->receipts_purchase_model->get($receipt_id);
            $purchase = $this->purchase->getPurchase($receipt->purchase_id);
            $supplier  = $this->suppliers_model->getByID($receipt->supplier_id);
            if( !$receipt ){
                $this->session->set_flashdata('message', lang("access_denied"));
                redirect('/', 'refresh');
            }
            if ( defined("BILLER_ID") && BILLER_ID != $supplier->id ){
                return show_error(lang("access_denied"));
            }
            if( count($id) == 1 ){
                $receipt_title = lang("receipt_no")." ".sprintf("%06s", $receipt->number);
            }else{
                $receipt_title = lang("receipts");
            }
            $data['receipt']          = $receipt;
            $data['purchase']          = $purchase;
            $data['supplier']           = $supplier;
            $data['purchase_currency'] = CURRENCY_FORMAT==1?$purchase->currency:$this->settings_model->getFormattedCurrencies($purchase->currency)->symbol_native;
            $data['page_title']       = lang("receipt");
            $Page_content[] = $this->load->view ( 'purchase_receipts/receipts_view' , $data , true );
        }

        // PRINT TEMPLATE
        $data_print_page['show_center_title'] = false;
        //$data_print_page['enable_header']     = false;
        $data_print_page['enable_footer']     = false;
        $data_print_page['enable_bordered']   = false;
        $data_print_page['enable_strip']      = false;
        $data_print_page['Page_size']         = "landscape";
        $data_print_page['Page_resolution']   = 'A5';
        $data_print_page['page_title']        = lang("receipt");
        $data_print_page['meta_title']        = $receipt_title ;
        $data_print_page['Page_content']      = $Page_content;
        $data_print_page['template_name'] = "PURCHASE";
        if( $isPDF ){
            $data_print_page['isPDF']         = true;
            return array(
                "filename" => $receipt_title,
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

        $template = $this->settings_model->getEmailTemplate("send_receipts_to_customer.tpl", LANGUAGE);
        $company  = $this->settings_model->getSettings("COMPANY");
        $receipt  = $this->receipts_purchase_model->get($id);
        $supplier   = $this->suppliers_model->getByID($receipt->supplier_id);

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
                $emails                  = $this->receipts_purchase_model->getReceiptsEmails($id);
                $data['id']              = $id;
                $data['emails_list']     = $emails;
                $data['page_title']      = lang('send_email');
                $data['email_type']      = lang('receipt');
                $data['email_subject']   = parse_object_sis($template->subject, $company, false, $biller, false, $receipt);
                $data['email_content']   = parse_object_sis($template->content, $company, false, $biller, false, $receipt);
                $data['email_cc']        = COMPANY_EMAIL;
                $data['form_action']     = "receipts/email?id=".$id;
                $this->load->view ( 'global/email' , $data );
            }
        }
    }

}
