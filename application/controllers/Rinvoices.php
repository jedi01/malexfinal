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

class Rinvoices extends MY_Controller
{
    /**
     * Recurring constructor.
     */
    public function __construct ()
    {
        parent::__construct ();
        log_message('INFO','Controller Recurring Invoices Initialized');
        // Load Recurring Model
        $this->load->model ( 'rinvoices_model' );
        // Load Invoices Model
        $this->load->model ( 'invoices_model' );
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
        $ignored_methods = array("cron");
        if ( !$this->ion_auth->logged_in () && !in_array($this->router->fetch_method(), $ignored_methods) ) {
            if ($this->input->is_ajax_request()) {
                $next_link = urlencode("/rinvoices");
                $result = array("status"=>"redirect", "message"=>site_url("auth/login?next=$next_link"));
                die(json_encode($result));
            }else{
                $next_link = urlencode(substr("$_SERVER[REQUEST_URI]", stripos("$_SERVER[REQUEST_URI]", "index.php")+9));
                redirect("auth/login?next=$next_link");
            }
        }
        if( !ENABLE_RECURRING ){
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/", 'refresh');
        }
        if ( $this->ion_auth->in_group(array("customer", "supplier")) )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/", 'refresh');
        }
    }

    public function index ()
    {
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('rinvoices');
        $data['page_title']       = lang('rinvoices');
        $data['page_subheading']  = lang('rinvoices_subheading');

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'rinvoices/rinvoices' , $data );
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
        if( $this->input->post('biller_id') ){
            $this->datatables->where("recurring_invoices.bill_to_id", $this->input->post('biller_id'));
        }
        if( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() ){
            $this->datatables->where("recurring_invoices.user_id", USER_ID);
        }
        $this->datatables
        ->setsColumns("id,name,fullname,date,frequency,status,amount,number,occurence,count_items")
        ->select("recurring_invoices.id as id, IF(biller.company='',biller.fullname, biller.company) as fullname,recurring_invoices.date as date,status,amount,bill_to_id,number,occurence,name,frequency,next_date, count(recurring_invoices_items.id) as count_items", false)
        ->join("biller", "recurring_invoices.bill_to_id=biller.id", "LEFT")
        ->join("recurring_invoices_items", "(recurring_invoices.id=recurring_invoices_items.recurring_id) AND (recurring_invoices_items.invoice_id IS NOT NULL)", "LEFT")
        ->from("recurring_invoices")
        ->group_by("recurring_invoices.id");
        $this->datatables->generate();
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }

    function validate_items($str)
    {
        return intval($str) > 0;
    }

    public function create()
    {
        if ( $this->ion_auth->in_group(array("customer", "supplier")) )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/rinvoices", 'refresh');
        }
        $this->form_validation->set_message('validate_items', lang("no_invoice_items"));
        $this->form_validation->set_rules('recurring[name]',    "lang:package_name",  'required|xss_clean');
        $this->form_validation->set_rules('invoice[title]',     "lang:title",         'required|xss_clean');
        $this->form_validation->set_rules('invoice[status]',    "lang:status",        'required|xss_clean');
        $this->form_validation->set_rules('invoice[reference]', "lang:reference",     'required|xss_clean');
        $this->form_validation->set_rules('invoice[date]',      "lang:date",          'required|xss_clean');
        $this->form_validation->set_rules('invoice[date_due]',  "lang:date_due",      'xss_clean');
        $this->form_validation->set_rules('invoice[bill_to_id]',"lang:customer",      'required|xss_clean');
        $this->form_validation->set_rules('items_count',        "lang:invoice_items", 'required|callback_validate_items|xss_clean');
        if ($this->form_validation->run() == true)
        {
            $data             = $this->input->post("invoice");
            $data['date']     = date_JS_MYSQL($data['date']);
            if( isset($data['date_due']) && $data['date_due'] != "" ){
                $data['date_due'] = date_JS_MYSQL($data['date_due']);
            }else{
                $data['date_due'] = NULL;
            }
            $data['user_id']  = USER_ID;
            $items            = $this->input->post("invoice_item");
            $taxes            = $this->input->post("invoice_taxes");

            // create new items
            $this->load->model('items_model');
            foreach ($items as $key => $item) {
                if( $item["item_id"] == "0" || $item["item_id"] == "undefined" ){
                    $prices = array();
                    $prices[$key] = array(
                        "price" => $item["unit_price"],
                        "currency" => $data["currency"]
                    );
                    unset($item["item_id"]);
                    unset($item["unit_price"]);
                    unset($item["quantity"]);
                    unset($item["total"]);
                    $items[$key]["item_id"] = $this->items_model->add($item, $prices);
                }
            }

            $recurring_data           = $this->input->post("recurring");
            $recurring_data['date']   = $data['date'];
            if( strtotime($data['date']) <= strtotime(date("Y-m-d")) ){
                $recurring_data['next_date'] = $data['date'];
            }else{
                $recurring_data['next_date'] = date("Y-m-d", strtotime($data['date']." +".$recurring_data['number']));
            }
            $recurring_data['next_date'] = $data['date'];
            $recurring_data['status'] = "panding";
            $recurring_data['bill_to_id'] = $data['bill_to_id'];
            $recurring_data['amount'] = $data['total'];
            $recurring_data["data"]   = json_encode(array("invoice" => $data,"items" => $items,"taxes" => $taxes));
        }
        if ( $this->form_validation->run() == true && $invoice_id = $this->rinvoices_model->create($recurring_data))
        {
            $this->sis_logger->write('recurring', 'create', $invoice_id, "Recurring invoice is created");
            $this->session->set_flashdata('success_message', lang("rinvoice_add_success"));
            redirect("/rinvoices/open/".$invoice_id, 'refresh');
        }
        else
        {
            $next_reference           = $this->invoices_model->next_reference();
            $data['next_reference']   = $next_reference["reference"];
            $data['next_count']       = $next_reference["next_count"];
            $data['currencies']       = $this->settings_model->getFormattedCurrencies();
            $data['tax_rates']        = $this->settings_model->getAllTaxRates();
            $data['form_action']      = 'rinvoices/create';
            $data['message']          = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            $data['error_fields']     = $this->form_validation->error_array();
            $meta['page_title']       = lang('create_rinvoice');
            $data['page_title']       = lang('create_rinvoice');
            $data['page_subheading']  = lang('create_rinvoice_subheading');
            $data['is_recurring']     = true;

            $this->load->view ( 'templates/head' , $meta );
            $this->load->view ( 'templates/header' );
            $this->load->view ( 'invoices/invoices_create' , $data );
            $this->load->view ( 'templates/footer' , $meta );
        }
    }

    public function edit($id = false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        if ( $this->ion_auth->in_group(array("customer", "supplier")) )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/rinvoices", 'refresh');
        }
        if ( $this->input->get('id') ){ $id = $this->input->get('id'); }
        if ( !$id || !($rinvoice = $this->rinvoices_model->getByID($id)) )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/rinvoices", 'refresh');
        }
        if ( $rinvoice->status == "canceled" )
        {
            $this->session->set_flashdata('message', lang("rinvoice_is_canceled"));
            redirect("/rinvoices", 'refresh');
        }
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $rinvoice->user_id != USER_ID ){
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/rinvoices", 'refresh');
        }
        $rdata   = json_decode($rinvoice->data);

        $this->form_validation->set_message('validate_items', lang("no_invoice_items"));
        $this->form_validation->set_rules('recurring[name]',     "lang:package_name",  'required|xss_clean');
        $this->form_validation->set_rules('invoice[title]',      "lang:title",         'required|xss_clean');
        $this->form_validation->set_rules('invoice[status]',     "lang:status",        'required|xss_clean');
        $this->form_validation->set_rules('invoice[reference]',  "lang:reference",     'required|xss_clean');
        $this->form_validation->set_rules('invoice[date]',       "lang:date",          'required|xss_clean');
        $this->form_validation->set_rules('invoice[date_due]',   "lang:date_due",      'xss_clean');
        $this->form_validation->set_rules('invoice[bill_to_id]', "lang:customer",      'required|xss_clean');
        $this->form_validation->set_rules('items_count',         "lang:invoice_items", 'required|callback_validate_items|xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data             = $this->input->post("invoice");
            $data['date']     = date_JS_MYSQL($data['date']);
            if( isset($data['date_due']) && $data['date_due'] != "" ){
                $data['date_due'] = date_JS_MYSQL($data['date_due']);
            }else{
                $data['date_due'] = NULL;
            }
            $items            = $this->input->post("invoice_item");
            $taxes            = $this->input->post("invoice_taxes");
            $id               = $this->input->post('id');

            // create new items
            $this->load->model('items_model');
            foreach ($items as $key => $item) {
                if( $item["item_id"] == "0" || $item["item_id"] == "undefined" ){
                    $prices = array();
                    $prices[$key] = array(
                        "price" => $item["unit_price"],
                        "currency" => $data["currency"]
                    );
                    unset($item["item_id"]);
                    unset($item["unit_price"]);
                    unset($item["quantity"]);
                    unset($item["total"]);
                    $items[$key]["item_id"] = $this->items_model->add($item, $prices);
                }
            }

            $recurring_data           = $this->input->post("recurring");
            $recurring_data['date']   = $data['date'];
            if( $data['date'] == date("Y-m-d") ){
                $recurring_data['next_date'] = $data['date'];
            }elseif( strtotime($data['date']) > strtotime(date("Y-m-d")) ){
                $recurring_data['next_date'] = $data['date'];
            }else{
                $recurring_data['next_date'] = date("Y-m-d", strtotime($data['date']." +".$recurring_data['number']));
            }
            $recurring_data['next_date'] = $data['date'];
            $recurring_data['bill_to_id'] = $data['bill_to_id'];
            $recurring_data['amount'] = $data['total'];
            $recurring_data["data"]   = json_encode(array("invoice" => $data,"items" => $items,"taxes" => $taxes));
        }
        if ( $this->form_validation->run() == true && $invoice_id = $this->rinvoices_model->update($id, $recurring_data))
        {

            $this->sis_logger->write('recurring', 'update', $invoice_id, "Recurring invoice is updated");
            $this->session->set_flashdata('success_message', lang("rinvoice_edit_success"));
            redirect("/rinvoices/open/".$id, 'refresh');
        }
        else
        {
            $invoice                 = $rdata->invoice;
            $invoice->id             = $rinvoice->id;
            $invoice_items           = objectToArray($rdata->items);
            $invoice_taxes           = objectToArray($rdata->taxes);
            $invoice_biller          = $this->biller_model->getByID($invoice->bill_to_id);
            $data['rinvoice']        = $rinvoice;
            $data['invoice']         = $invoice;
            $data['invoice_items']   = $invoice_items;
            $data['invoice_taxes']   = $invoice_taxes;
            $data['invoice_biller']  = $invoice_biller;
            $data['currencies']      = $this->settings_model->getFormattedCurrencies();
            $data['tax_rates']       = $this->settings_model->getAllTaxRates();
            $data['form_action']     = 'rinvoices/edit?id='.$rinvoice->id;
            $data['message']         = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            $data['error_fields']     = $this->form_validation->error_array();
            $meta['page_title']      = lang('edit_rinvoice');
            $data['page_title']      = lang('edit_rinvoice');
            $data['page_subheading'] = lang('edit_rinvoice_subheading');
            $data['is_recurring']    = true;

            $this->load->view ( 'templates/head' , $meta );
            $this->load->view ( 'templates/header' );
            $this->load->view ( 'invoices/invoices_edit' , $data );
            $this->load->view ( 'templates/footer' , $meta );
        }
    }


    public function open($id = false)
    {
        if( $this->input->get('id') ){ $id = $this->input->get('id');}
        if ( !$id || !($rinvoice = $this->rinvoices_model->getByID($id)) )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/rinvoices", 'refresh');
        }
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $rinvoice->user_id != USER_ID ){
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/rinvoices", 'refresh');
        }

        $rdata                   = json_decode($rinvoice->data);
        $invoice                 = $rdata->invoice;
        $invoice_items           = $rdata->items;
        $invoice_taxes           = $rdata->taxes;
        $invoice_biller          = $this->biller_model->getByID($invoice->bill_to_id);
        $invoice->no             = sprintf("%05s", $invoice->count);
        $data['rinvoice']        = $rinvoice;
        $data['invoice']         = $invoice;
        $data['invoice_items']   = $invoice_items;
        $data['invoice_taxes']   = $invoice_taxes;
        $data['invoice_biller']  = $invoice_biller;
        $meta['page_title']      = $rinvoice->name;
        $data['page_title']      = lang("rinvoice");
        $data['page_subheading'] = $rinvoice->name;

        /* PREVIEW START */
        $Page_content = array();
        $data['invoice_currency']             = CURRENCY_FORMAT==1?$invoice->currency:$this->settings_model->getFormattedCurrencies($invoice->currency)->symbol_native;
        $Page_content                         = $this->load->view ( 'invoices/invoices_view', $data , true );
        $data_print_page['show_btn_config']   = false;
        $data_print_page['is_preview']        = true;
        $data_print_page['show_center_title'] = true;
        $data_print_page['page_title']        = $invoice->title;
        $data_print_page['meta_title']        = lang("invoice_no")." ".$invoice->no;
        $data_print_page['Page_content']      = $Page_content;
        $preview = $this->load->view ( 'templates/printing_template' , $data_print_page, true );
        /* PREVIEW END */
        $data['message']         = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
        $data['preview']         = $preview;
        $data['items']           = $this->rinvoices_model->getItemsDetails($id, 6);


        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'rinvoices/rinvoices_preview' , $data );
        $this->load->view ( 'templates/footer' , $meta );
    }

    public function delete($id =false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if($id) { $id = array($id); }
        if($this->input->get('id')) { $id = array($this->input->get('id')); }
        if($this->input->post('id')) { $id = $this->input->post('id'); }
        if(  $id == false || !$this->input->is_ajax_request() ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( $this->rinvoices_model->delete($id) )
        {
            $this->sis_logger->write('recurring', 'delete', $id, "Recurring invoice is deleted");
            $result = array("status"=>"success", "message"=>lang("rinvoice_deleted"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("cant_delete_rinvoice"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function duplicate($id = false)
    {
        if($this->input->get('id')) { $id = $this->input->get('id'); }
        if(  !$id || !$this->input->is_ajax_request() || !($rinvoice = $this->rinvoices_model->getByID($id)) ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $rinvoice->user_id != USER_ID ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $old_name              = $rinvoice->name;
        $rinvoice              = objectToArray($rinvoice);
        $rinvoice['name']      = "Copy - ".$old_name;
        $rinvoice['date']      = date("Y-m-d");
        $rinvoice['next_date'] = date("Y-m-d");
        $rinvoice['status']    = "panding";
        unset($rinvoice['id']);

        if ( $rinvoice_id = $this->rinvoices_model->create($rinvoice) )
        {
            $this->sis_logger->write('recurring', 'clone', $rinvoice_id, "Recurring invoice is duplicated from Recurring invoice #".$old_name);
            $result = array("status"=>"success", "message"=>lang("rinvoice_duplicate_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }else{
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function activities($id = false)
    {
        if($this->input->get('id')) { $id = $this->input->get('id'); }
        if( !$id || !$this->ion_auth->is_admin() || !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $data['page_title']      = lang("rinvoices_activities");
        $data['activities']      = $this->sis_logger->getLogs("recurring", $id);

        $this->load->view ( 'rinvoices/rinvoices_activities' , $data );
    }

    public function profile($action = false, $id =false)
    {
        if($id) { $id = array($id); }
        if($this->input->get('id')) { $id = array($this->input->get('id')); }
        if($this->input->post('id')) { $id = $this->input->post('id'); }
        if(  !$action || !$id || !$this->input->is_ajax_request() ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        foreach ($id as $recurring_id) {
            $rinvoice = $this->rinvoices_model->getByID($recurring_id);
            if( $action == 'start' ){
                $this->sis_logger->write('recurring', 'start', $recurring_id, "Recurring invoice is started");
                $this->rinvoices_model->start($recurring_id);
            }
            elseif( $action == 'cancel' ){
                $this->sis_logger->write('recurring', 'cancel', $recurring_id, "Recurring invoice is canceled");
                $this->rinvoices_model->cancel($recurring_id);
            }
            elseif( $action == 'skip' ){
                $this->sis_logger->write('recurring', 'skip', $recurring_id, "Recurring invoice is skipped date ".date_MYSQL_PHP($rinvoice->next_date));
                $this->rinvoices_model->skip_next($recurring_id);
            }
        }

        if( $action == 'start' ){
            $result = array("status"=>"success", "message"=>lang("rinvoice_started"));
        }
        elseif( $action == 'cancel' ){
            $result = array("status"=>"success", "message"=>lang("rinvoice_canceled"));
        }
        elseif( $action == 'skip' ){
            $result = array("status"=>"success", "message"=>lang("rinvoice_skipped"));
        }else{
            $result = array("status"=>"error", "message"=>lang("access_denied"));
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
        return true;
    }
}
