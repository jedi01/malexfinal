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

class Invoices extends MY_Controller
{
    /**
     * Invoices constructor.
     */
    public function __construct ()
    {
        parent::__construct ();
        // Load Invoices Model
        $this->load->model ( 'invoices_model' );
        // Load Billers Model
        $this->load->model ( 'biller_model' );
        // Load Payments Model
        $this->load->model ( 'payments_model' );
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
                $next_link = urlencode("/invoices");
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
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('invoices');
        $data['page_title']       = lang('invoices');
        $data['page_subheading']  = lang('invoices_subheading');
        $data['is_partial']       = false;

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'invoices/invoices' , $data );
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
            $this->datatables->where("invoices.bill_to_id", BILLER_ID);
            $this->datatables->where("invoices.status <>", "draft");
        }
        if( $this->input->post('biller_id') ){
            $this->datatables->where("invoices.bill_to_id", $this->input->post('biller_id'));
        }
        if( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() ){
            $this->datatables->where("invoices.user_id", USER_ID);
        }
        if( $this->input->post('currency') ){
            $this->datatables->where("invoices.currency", $this->input->post('currency'));
        }
        $this->datatables
        ->setsColumns("id,reference,title,description,date,date_due,fullname,status,gl_status,payment_date,total,total_tax,total_discount,shipping,total_due,recurring_id,currency,bill_to_id")
        ->select("invoices.id as id, invoices.reference as reference,title,invoices.description as description, invoices.date as date, invoices.date_due as date_due, IF(biller.company='',biller.fullname, biller.company) as fullname, IF((invoices.status='unpaid' OR invoices.status='partial') AND invoices.date_due<'".date("Y-m-d")."', 'overdue', invoices.status) as status, gl_status,payment_date, invoices.total as total, bill_to_id, total_tax, total_discount, shipping, total_due, recurring_id, currency", false)
        ->join("biller", "invoices.bill_to_id=biller.id")
        ->from("invoices");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }

    function validate_items($str)
    {
        return intval($str) > 0;
    }

    function paid_amount($paid_amount)
    {
        $total = $this->input->post('invoice[total]');
        if( floatval($paid_amount) < floatval($total) ) {
            return true;
        }else{
            $msg = str_replace("{param}", lang("total"), lang("form_validation_less_than"));
            $this->form_validation->set_message('paid_amount', $msg);
            return false;
        }
    }

    public function create()
    {
        if ( $this->ion_auth->in_group(array("customer", "supplier")) )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/invoices", 'refresh');
        }
        $this->form_validation->set_message('validate_items', lang("no_invoice_items"));

        $this->form_validation->set_rules('invoice[title]',     "lang:title",         'required|max_length[25]|xss_clean');
        $this->form_validation->set_rules('invoice[description]',"lang:description",  'xss_clean');
        $this->form_validation->set_rules('invoice[status]',    "lang:status",        'required|xss_clean');
        $this->form_validation->set_rules('invoice[reference]', "lang:reference",     'required|is_unique[invoices.reference]|xss_clean');
        $this->form_validation->set_rules('invoice[date]',      "lang:date",          'required|xss_clean');
        $this->form_validation->set_rules('invoice[date_due]',  "lang:date_due",      'xss_clean');
        $this->form_validation->set_rules('invoice[bill_to_id]',"lang:customer",      'required|xss_clean');
        $this->form_validation->set_rules('items_count',        "lang:invoice_items", 'required|callback_validate_items|xss_clean');

        if( $this->input->post("invoice[status]") && $this->input->post("invoice[status]") == "partial" ){
            $this->form_validation->set_rules('paid_amount',"lang:paid_amount",'required|is_natural_no_zero|callback_paid_amount|xss_clean');
        }

        if ($this->form_validation->run() == true)
        {
            $data             = $this->input->post("invoice");
            $data['date']     = date_JS_MYSQL($data['date']);
            if( isset($data['date_due']) && $data['date_due'] != "" ){
                $data['date_due'] = date_JS_MYSQL($data['date_due']);
            }else{
                $data['date_due'] = NULL;
            }
            if( $data['count'] == "0" ){
                $next_reference    = $this->invoices_model->next_reference();
                $data['reference'] = $next_reference["reference"];
                $data['count']     = $next_reference["next_count"];
            }
            $data['double_currency']  = $this->input->post('invoice[double_currency]')?true:false;
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
        }
        if ( $this->form_validation->run() == true && $invoice_id = $this->invoices_model->create($data, $items, $taxes))
        {
            // update settings next count
            $this->settings_model->updateSettingsItem("invoice_next", $data['count']+1);

            // created from estimate
            if(isset($data['estimate_id'])){
                $this->load->model ( 'estimates_model' );
                $this->estimates_model->setStatus(array($data['estimate_id']), "invoiced");
                $estimate = $this->estimates_model->getEstimate($data['estimate_id']);
                $this->sis_logger->write('invoices', 'create', $invoice_id, "invoice is created from estimate #".$estimate->reference);
                $this->sis_logger->write('estimates', 'update', $data['estimate_id'], "estimate is converted to invoice #".$data['reference']);
            }else{
                $this->sis_logger->write('invoices', 'create', $invoice_id, "invoice is created");
            }

            // create payment if status is paid or partial
            if( $data['status'] == "paid" || $data['status'] == "partial" ){
                $amount = floatval($data['total'])-floatval($data['total_due']);
                $payment = array(
                    "invoice_id" => $invoice_id,
                    "number"     => $this->payments_model->next(),
                    "date"       => $data['date'],
                    "amount"     => $amount,
                    "method"     => "cash",
                );
                $payment_id  = $this->payments_model->create($payment);
                $biller_name = $this->input->post("biller");
                $this->invoices_model->update_amount_due($invoice_id);
                $this->sis_logger->write('invoices', 'make_payment', $invoice_id, "Payment of ".$amount." ".$data['currency']." received from ".$biller_name." via cash");
            }
            $this->session->set_flashdata('success_message', lang("invoice_add_success"));
            redirect("/invoices/open/".$invoice_id, 'refresh');
        }
        else
        {
            $estimate_id = $this->input->get('estimate_id')?$this->input->get('estimate_id'):false;
            if($estimate_id){
                $this->load->model ( 'estimates_model' );
                $estimate                 = $this->estimates_model->getEstimate($estimate_id);
                $estimate_items           = $this->estimates_model->getEstimateItems($estimate_id);
                $estimate_taxes           = $this->estimates_model->getEstimateTaxes($estimate_id);
                $estimate_biller          = $this->biller_model->getByID($estimate->bill_to_id);
                $data['estimate']         = $estimate;
                $data['estimate_items']   = $estimate_items;
                $data['estimate_taxes']   = $estimate_taxes;
                $data['estimate_biller']  = $estimate_biller;
            }

            $next_reference           = $this->invoices_model->next_reference();
            $data['next_reference']   = $next_reference["reference"];
            $data['next_count']       = $next_reference["next_count"];
            $data['currencies']       = $this->settings_model->getFormattedCurrencies();
            $data['tax_rates']        = $this->settings_model->getAllTaxRates();
            $data['form_action']      = 'invoices/create';
            $data['message']          = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            $data['error_fields']     = $this->form_validation->error_array();
            $meta['page_title']       = lang('create_invoice');
            $data['page_title']       = lang('create_invoice');
            $data['page_subheading']  = lang('create_invoice_subheading');
            $this->load->view ( 'templates/head' , $meta );
            $this->load->view ( 'templates/header' );
            $this->load->view ( 'invoices/invoices_create' , $data );
            $this->load->view ( 'templates/footer' , $meta );
        }
    }

    public function edit()
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        if ( $this->ion_auth->in_group(array("customer", "supplier")) )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/invoices", 'refresh');
        }
        if ( !$this->input->get('id') )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/invoices", 'refresh');
        }
        $id = $this->input->get('id');
        $invoice = $this->invoices_model->getInvoice($id);
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $invoice->user_id != USER_ID )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/invoices", 'refresh');
        }

        $this->form_validation->set_message('validate_items', lang("no_invoice_items"));
        $this->form_validation->set_rules('invoice[title]',      "lang:title",         'required|max_length[25]|xss_clean');
        $this->form_validation->set_rules('invoice[description]',"lang:description",   'xss_clean');
        $this->form_validation->set_rules('invoice[status]',     "lang:status",        'required|xss_clean');
        $this->form_validation->set_rules('invoice[reference]',  "lang:reference",     'required|xss_clean');
        $this->form_validation->set_rules('invoice[date]',       "lang:date",          'required|xss_clean');
        $this->form_validation->set_rules('invoice[date_due]',   "lang:date_due",      'xss_clean');
        $this->form_validation->set_rules('invoice[bill_to_id]', "lang:customer",      'required|xss_clean');
        $this->form_validation->set_rules('items_count',         "lang:invoice_items", 'required|callback_validate_items|xss_clean');

        if( $this->input->post('invoice[reference]') ){
            if( $this->input->post('invoice[reference]') != $invoice->reference ){
                $this->form_validation->set_rules('invoice[reference]', "lang:reference", 'is_unique[invoices.reference]');
            }
        }

        if ($this->form_validation->run() == true)
        {
            $data             = $this->input->post("invoice");
            $data['date']     = date_JS_MYSQL($data['date']);
            if( isset($data['date_due']) && $data['date_due'] != "" ){
                $data['date_due'] = date_JS_MYSQL($data['date_due']);
            }else{
                $data['date_due'] = NULL;
            }
            if( $data['count'] == "0" ){
                $next_reference    = $this->invoices_model->next_reference($invoice->count);
                $data['reference'] = $next_reference["reference"];
                $data['count']     = $next_reference["next_count"];
            }
            $data['double_currency']  = $this->input->post('invoice[double_currency]')?true:false;
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
        }
        if ( $this->form_validation->run() == true && $invoice_id = $this->invoices_model->update($id, $data, $items, $taxes))
        {
            $this->sis_logger->write('invoices', 'update', $invoice_id, "invoice is updated");
            $this->session->set_flashdata('success_message', lang("invoice_edit_success"));
            redirect("/invoices/open/".$id, 'refresh');
        }
        else
        {
            $invoice_items           = $this->invoices_model->getInvoiceItems($id);
            $invoice_taxes           = $this->invoices_model->getInvoiceTaxes($id);
            $invoice_biller          = $this->biller_model->getByID($invoice->bill_to_id);
            $data['invoice']         = $invoice;
            $data['invoice_items']   = $invoice_items;
            $data['invoice_taxes']   = $invoice_taxes;
            $data['invoice_biller']  = $invoice_biller;
            $data['currencies']      = $this->settings_model->getFormattedCurrencies();
            $data['tax_rates']       = $this->settings_model->getAllTaxRates();
            $data['form_action']     = 'invoices/edit?id='.$invoice->id;
            $data['message']         = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            $data['error_fields']    = $this->form_validation->error_array();
            $meta['page_title']      = lang('edit_invoice');
            $data['page_title']      = lang('edit_invoice');
            $data['page_subheading'] = lang('edit_invoice_subheading');

            $meta['breadcrumbs'][] = array(
                "link" => site_url("/invoices/"),
                "label" => lang("invoices"),
            );
            $meta['breadcrumbs'][] = array(
                "link" => site_url("/invoices/open/".$invoice->id),
                "label" => lang("invoice_no")." ".sprintf("%05s", $invoice->count),
            );
            $meta['breadcrumb_first'] = array(
                "class_label" => $this->router->default_controller,
            );

            $this->load->view ( 'templates/head' , $meta );
            $this->load->view ( 'templates/header' );
            $this->load->view ( 'invoices/invoices_edit' , $data );
            $this->load->view ( 'templates/footer' , $meta );
        }
    }

    public function open($id = false)
    {
        if( $this->input->get('id') ){ $id = $this->input->get('id');}
        if ( !$id || !($invoice = $this->invoices_model->getInvoice($id)) )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/invoices", 'refresh');
        }
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $invoice->user_id != USER_ID )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/invoices", 'refresh');
        }

        $invoice_items           = $this->invoices_model->getInvoiceItems($id);
        $invoice_taxes           = $this->invoices_model->getInvoiceTaxes($id);
        $invoice_biller          = $this->biller_model->getByID($invoice->bill_to_id);
        $invoice->no             = sprintf("%05s", $invoice->count);
        $data['invoice']         = $invoice;
        $data['invoice_items']   = $invoice_items;
        $data['invoice_taxes']   = $invoice_taxes;
        $data['invoice_biller']  = $invoice_biller;
        $data['currencies']      = $this->settings_model->getFormattedCurrencies();
        $data['tax_rates']       = $this->settings_model->getAllTaxRates();
        $data['message']         = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
        $meta['page_title']      = lang("invoice_no")." ".$invoice->no;
        $data['page_title']      = $invoice->title;
        $data['page_subheading'] = $invoice->reference;

        /* PREVIEW START */
        $Page_content = array();
        $data['invoice_currency']             = CURRENCY_FORMAT==1?$invoice->currency:$this->settings_model->getFormattedCurrencies($invoice->currency)->symbol_native;
        $Page_content[] = $this->load->view ( 'invoices/invoices_view', $data , true );
        if( $this->settings_model->SYS_Settings->note_terms_on_page && ($invoice->terms != "" || $invoice->note != "") ){
            $Page_content[] = $this->load->view ( 'invoices/terms_page' , $data , true );
        }
        if( $this->settings_model->SYS_Settings->show_payments_page && $this->invoices_model->getPaymentsTotal($id) > 0 ){
            $data['payments']     = $this->payments_model->getPaymentsByInvoice($id);
            $Page_content[] = $this->load->view ( 'invoices/invoices_payments_view' , $data , true );
        }
        $data_print_page['show_btn_config']   = false;
        $data_print_page['is_preview']        = true;
        $data_print_page['show_center_title'] = true;
        $data_print_page['page_title']        = $invoice->title;
        $data_print_page['meta_title']        = lang("invoice_no")." ".$invoice->no;
        $data_print_page['Page_content']      = $Page_content;
        $preview = $this->load->view ( 'templates/printing_template' , $data_print_page, true );
        /* PREVIEW END */
        $data['preview']         = $preview;
        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'invoices/invoices_preview' , $data );
        $this->load->view ( 'templates/footer' , $meta );
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
        if ( $this->invoices_model->delete($id) )
        {
            $this->sis_logger->write('invoices', 'delete', $id, "invoice is deleted");
            $result = array("status"=>"success", "message"=>lang("invoice_deleted"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("cant_delete_invoice"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function set_status()
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
        $invoice = $this->invoices_model->getInvoice($id);

        $this->form_validation->set_rules('status', "lang:status", 'required|xss_clean');

        if ($this->form_validation->run() == true)
        {
            $status = $this->input->post("status");
            $id     = $this->input->post('id');
            $gl_status = $this->input->post("gl_status");
        }
        if ( $this->form_validation->run() == true && $this->invoices_model->setStatus($id, $status,$gl_status))
        {
            $this->sis_logger->write('invoices', 'update', $id, "invoice status is updated from '".$invoice->status."' to '".$status."'");
            $data = array("status" => "success", "message" => lang("invoice_edit_success"));
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
                $data['invoice']         = $invoice;
                $data['page_title']      = lang('set_status');
                $data['page_subheading'] = lang('set_status_subheading');
                $this->load->view ( 'invoices/invoices_status' , $data );
            }
        }
    }


    public function duplicate()
    {
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( $this->ion_auth->in_group(array("customer", "supplier")) )
        {
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
        $id             = $this->input->get('id');
        $invoice        = $this->invoices_model->getInvoice($id);
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $invoice->user_id != USER_ID ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        if ( $invoice == false )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/invoices", 'refresh');
        }
        $invoice              = objectToArray($invoice);
        $old_reference        = $invoice["reference"];
        $next_reference       = $this->invoices_model->next_reference();
        $invoice['reference'] = $next_reference["reference"];
        $invoice['count']     = $next_reference["next_count"];
        $invoice_items        = $this->invoices_model->getInvoiceItems($id);
        $invoice_taxes        = $this->invoices_model->getInvoiceTaxes($id);
        unset($invoice['id']);
        foreach ($invoice_items as $key => $item) {
            unset($invoice_items[$key]['id']);
            unset($invoice_items[$key]['invoice_id']);
        }
        foreach ($invoice_taxes as $key => $item) {
            unset($invoice_taxes[$key]['id']);
            unset($invoice_taxes[$key]['invoice_id']);
        }

        if ( $invoice_id = $this->invoices_model->create($invoice, $invoice_items, $invoice_taxes) )
        {
             $this->settings_model->updateSettingsItem("invoice_next", $invoice['count']+1);

             
            $this->sis_logger->write('invoices', 'clone', $invoice_id, "invoice is duplicated from invoice #".$old_reference);
            $result = array("status"=>"success", "message"=>lang("invoice_duplicate_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        else
        {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function view($id = NULL, $isPDF = false)
    {
        if($this->input->get('id')) { $id = $this->input->get('id'); }
        if($id) { $id = explode(",", $id); }
        if( !$id ){
            show_error(lang("access_denied"));
        }
        $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

        $Page_content = array();
        foreach ($id as $invoice_id) {
            // invoice view
            $invoice                  = $this->invoices_model->getInvoice($invoice_id);
            if ( defined("BILLER_ID") && BILLER_ID != $invoice->bill_to_id ){
                return show_error(lang("access_denied"));
            }
            $invoice_items            = $this->invoices_model->getInvoiceItems($invoice_id);
            $invoice_taxes            = $this->invoices_model->getInvoiceTaxes($invoice_id);
            $invoice_biller           = $this->biller_model->getByID($invoice->bill_to_id);
            $data['invoice']          = $invoice;
            $data['invoice_items']    = $invoice_items;
            $data['invoice_taxes']    = $invoice_taxes;
            $data['invoice_biller']   = $invoice_biller;
            $data['invoice_currency'] = CURRENCY_FORMAT==1?$invoice->currency:$this->settings_model->getFormattedCurrencies($invoice->currency)->symbol_native;
            $invoice->no              = sprintf("%05s", $invoice->count);
            $data['page_title']       = $invoice->title;
            $Page_content[] = $this->load->view ( 'invoices/invoices_view' , $data , true );

            if( $this->settings_model->SYS_Settings->note_terms_on_page && ($invoice->terms != "" || $invoice->note != "") ){
                $Page_content[] = $this->load->view ( 'invoices/terms_page' , $data , true );
            }
            if( $this->settings_model->SYS_Settings->show_payments_page && $this->invoices_model->getPaymentsTotal($invoice_id) > 0 ){
                $data['payments']     = $this->payments_model->getPaymentsByInvoice($invoice_id);
                $Page_content[] = $this->load->view ( 'invoices/invoices_payments_view' , $data , true );
            }
        }
        if( count($id) == 1 ){
            $page_title = lang("invoice_no")." ".sprintf("%06s", $invoice->no );
        }else{
            $page_title = lang("invoices");
        }

        // PRINT TEMPLATE
        $data_print_page['show_center_title'] = true;
        $data_print_page['page_title'] = $invoice->title;
        $data_print_page['meta_title'] = $page_title;
        $data_print_page['Page_content'] = $Page_content;
        if( $isPDF ){
            $data_print_page['isPDF']         = true;
            return array(
                "filename" => $page_title,
                "html"     => $this->load->view ( 'templates/printing_template' , $data_print_page, true )
            );
        }
        $this->load->view ( 'templates/printing_template' , $data_print_page );
    }

    public function preview()
    {
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $invoice                  = arrayToObject($this->input->post("invoice"));
        $invoice->date            = date_JS_MYSQL($invoice->date);
        if( isset($invoice->date_due) && $invoice->date_due != "" ){
            $invoice->date_due        = date_JS_MYSQL($invoice->date_due);
        }
        if( !isset($invoice->double_currency) ){
            $invoice->double_currency = false;
        }
        $invoice_items            = $this->input->post("invoice_item");
        $invoice_taxes            = $this->input->post("invoice_taxes");
        $invoice_biller           = $this->biller_model->getByID($invoice->bill_to_id);
        $data['invoice']          = $invoice;
        $data['invoice_items']    = $invoice_items;
        $data['invoice_taxes']    = $invoice_taxes;
        $data['invoice_biller']   = $invoice_biller;
        $invoice->no              = sprintf("%05s", $invoice->count);
        $data['invoice_currency'] = CURRENCY_FORMAT==1?$invoice->currency:$this->settings_model->getFormattedCurrencies($invoice->currency)->symbol_native;
        $data['page_title']       = $invoice->title;
        $Page_content = $this->load->view ( 'invoices/invoices_view', $data , true );

        // PRINT TEMPLATE
        $data_print_page['show_btn_config'] = false;
        $data_print_page['is_preview'] = true;
        $data_print_page['show_center_title'] = true;
        $data_print_page['page_title'] = $invoice->title;
        $data_print_page['meta_title'] = lang("invoice_no")." ".$invoice->no;
        $data_print_page['Page_content'] = $Page_content;
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

        $template = $this->settings_model->getEmailTemplate("send_invoices_to_customer.tpl", LANGUAGE);
        $company  = $this->settings_model->getSettings("COMPANY");
        $invoice  = $this->invoices_model->getInvoice($id);
        $biller   = $this->biller_model->getByID($invoice->bill_to_id);

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
                $emails                  = $this->invoices_model->getInvoicesEmails($id);
                $data['id']              = $id;
                $data['emails_list']     = $emails;
                $data['page_title']      = lang('send_email');
                $data['email_type']      = lang('invoice');
                $data['email_subject']   = parse_object_sis($template->subject, $company, $invoice, $biller);
                $data['email_content']   = parse_object_sis($template->content, $company, $invoice, $biller);
                $data['email_cc']        = COMPANY_EMAIL;
                $data['form_action']     = "invoices/email?id=".$id;
                $this->load->view ( 'global/email' , $data );
            }
        }
    }

    public function get_next_reference(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $c = $this->input->get('c')?$this->input->get('c'):FALSE;
        $t = $this->input->get('t')?$this->input->get('t'):REFERENCE_TYPE;
        $p = $this->input->get('p')?$this->input->get('p'):INVOICE_PREFIX;
        $y = $this->input->get('y')?$this->input->get('y'):FALSE;
        $this->output->set_content_type('application/json')->set_output( json_encode($this->invoices_model->next_reference($c, $t, $p, $y)));
    }

    public function activities()
    {
        if( !$this->ion_auth->is_admin() || !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( !$this->input->get('id') )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/invoices", 'refresh');
        }
        $id                      = $this->input->get('id');
        $data['invoice']         = $this->invoices_model->getInvoice($id);
        $data['page_title']      = lang("invoices_activities");
        $data['activities']      = $this->sis_logger->getLogs("invoices", $id);

        $this->load->view ( 'invoices/invoices_activities' , $data );
    }

    public function suggestions(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $term = $this->input->get('term')?$this->input->get('term'):"";
        $items = $this->invoices_model->suggestions($term);
        $this->output->set_content_type('application/json')->set_output(json_encode($items));
    }
}
