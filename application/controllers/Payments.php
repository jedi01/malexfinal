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

class Payments extends MY_Controller
{
    /**
     * Payments constructor.
     */
    public function __construct ()
    {
        parent::__construct ();
        // Load Payments Model
        $this->load->model ( 'payments_model' );
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
        $ignored_methods = array("validate_payment", "cancel_payment");
        if ( !$this->ion_auth->logged_in () && !in_array($this->router->fetch_method(), $ignored_methods) ) {
            if ($this->input->is_ajax_request()) {
                $next_link = urlencode("/payments");
                $result = array("status"=>"redirect", "message"=>site_url("auth/login?next=$next_link"));
                die(json_encode($result));
            }else{
                $next_link = urlencode(substr("$_SERVER[REQUEST_URI]", stripos("$_SERVER[REQUEST_URI]", "index.php")+9));
                redirect("auth/login?next=$next_link");
            }
        }
    }

    public function index ($invoice = false)
    {
        if($this->input->get('invoice')){ $invoice = $this->input->get('invoice'); }
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $data['invoice']          = $invoice;
        $meta['page_title']       = lang('payments');
        $data['page_title']       = lang('payments');
        $data['page_subheading']  = lang('payments_subheading');
        if( $invoice ){
            $invoice_obj = $this->invoices_model->getInvoice($invoice);
            if( !$invoice_obj ){
                $this->session->set_flashdata('message', lang("access_denied"));
                redirect("/payments", 'refresh');
            }
            $meta['breadcrumbs'] = array(
                array(
                    "link" => site_url("/invoices/"),
                    "label" => lang("invoices"),
                ),
                array(
                    "link" => site_url("/invoices/open/".$invoice_obj->id),
                    "label" => lang("invoice_no")." ".sprintf("%05s", $invoice_obj->count),
                ),
            );
        }

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'payments/payments' , $data );
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
        if ( $this->input->post('invoice') )
        {
            $this->datatables->where("invoice_id", $this->input->post('invoice'));
        }
        if( defined("BILLER_ID") ){
            $this->datatables->where("invoices.bill_to_id", BILLER_ID);
        }
        if( $this->input->post('biller_id') ){
            $this->datatables->where("invoices.bill_to_id", $this->input->post('biller_id'));
        }
        $this->datatables
        ->setsColumns("id,number,invoice,fullname,p_date,amount,method,status,details,invoice_id,bill_to_id,currency")
        ->select("payments.id as id,number,invoices.reference as invoice,IF(biller.company='',biller.fullname, biller.company) as fullname,payments.date as p_date,amount,method,payments.status as status,details,invoice_id,invoices.bill_to_id as bill_to_id,invoices.currency as currency", false)
        ->join("invoices", "invoices.id=payments.invoice_id", "left")
        ->join("biller", "invoices.bill_to_id=biller.id", "left")
        ->from("payments");
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
        if( !$id ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $invoice = $this->invoices_model->getInvoice($id);
        $invoice_biller = $this->biller_model->getByID($invoice->bill_to_id);
        $this->form_validation->set_rules('payment[number]',  "lang:payment_number", 'required|is_unique[payments.number]|xss_clean');
        $this->form_validation->set_rules('payment[amount]',  "lang:amount",         'required|xss_clean');
        $this->form_validation->set_rules('payment[date]',    "lang:date",           'required|xss_clean');
        $this->form_validation->set_rules('payment[method]',  "lang:payment_method", 'required|xss_clean');
        $this->form_validation->set_rules('payment[details]', "lang:details",        'xss_clean');

        if( $this->input->post("payment[method]") == "stripe" ){
            $this->form_validation->set_rules('cc[firstname]', "lang:credit_card_firstName", 'required|xss_clean');
            $this->form_validation->set_rules('cc[lastname]', "lang:credit_card_lastName", 'required|xss_clean');
            $this->form_validation->set_rules('cc[number]', "lang:credit_card_number", 'required|xss_clean');
            $this->form_validation->set_rules('cc[expiryMonth]', "lang:credit_card_expiryMonth", 'required|xss_clean');
            $this->form_validation->set_rules('cc[expiryYear]', "lang:credit_card_expiryYear", 'required|xss_clean');
            $this->form_validation->set_rules('cc[cvv]', "lang:credit_card_cvv", 'required|xss_clean');
        }

        if ($this->form_validation->run() == true)
        {
            $payment_data         = $this->input->post("payment");
            $payment_data['date'] = date_JS_MYSQL($payment_data['date']);
            if( PAYMENTS_ONLINE && $this->payments_model->isOnline($payment_data['method']) ){
                if( $payment_data['method'] == "stripe" ){
                    $payment_data['credit_card'] = json_encode($this->input->post("cc"));
                }
                $payment_data['token'] = substr( md5(rand()), 0, 14);
                $payment_data['status'] = "panding";
            }
            if( defined("BILLER_ID") ){
                $payment_data['status'] = "panding";
            }
        }
        if ( $this->form_validation->run() == true && $payment_id = $this->payments_model->create($payment_data))
        {
            if( $this->input->post("create_receipt") ){
                $this->load->model('receipts_model');
                $receipt_data = $payment_data;
                unset($receipt_data['status']);
                $receipt_data['number'] = $this->receipts_model->next();
                $receipt_data['biller_id'] = $invoice_biller->id;
                $this->receipts_model->create($receipt_data);
                // update settings next count
                $this->settings_model->updateSettingsItem("receipt_next", $receipt_data['number']+1);
            }

            $this->sis_logger->write('invoices', 'make_payment', $invoice->id, "Payment of ".$payment_data['amount']." ".$invoice->currency." received from ".$invoice_biller->fullname." via ".$payment_data['method']);

            $this->invoices_model->update_amount_due($payment_data['invoice_id']);
            if( PAYMENTS_ONLINE && $this->payments_model->isOnline($payment_data['method']) ){
                if( $this->paid_online($payment_id, true) ){
                    $data = array("status" => "redirect", "message" => site_url("/payments/paid_online/".$payment_id));
                    $this->output->set_content_type('application/json')->set_output(json_encode($data));
                    return false;
                }
            }else{
                $data = array("status" => "success", "message" => lang("payments_create_success"));
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }
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
                $data['next_number']     = $this->payments_model->next();
                $data['page_title']      = lang('payments_create');
                $data['page_subheading'] = lang('payments_create_subheading');
                $this->load->view ( 'payments/payments_create' , $data );
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
        $payment = $this->payments_model->get($id);
        $invoice = $this->invoices_model->getInvoice($payment->invoice_id);
        $invoice_biller = $this->biller_model->getByID($invoice->bill_to_id);

        $this->form_validation->set_rules('payment[number]',  "lang:payment_number", 'required|xss_clean');
        $this->form_validation->set_rules('payment[amount]',  "lang:amount",         'required|xss_clean');
        $this->form_validation->set_rules('payment[date]',    "lang:date",           'required|xss_clean');
        $this->form_validation->set_rules('payment[method]',  "lang:payment_method", 'required|xss_clean');
        $this->form_validation->set_rules('payment[details]', "lang:details",        'xss_clean');

        if( $this->input->post("payment[method]") == "stripe" ){
            $this->form_validation->set_rules('cc[firstname]', "lang:credit_card_firstName", 'required|xss_clean');
            $this->form_validation->set_rules('cc[lastname]', "lang:credit_card_lastName", 'required|xss_clean');
            $this->form_validation->set_rules('cc[number]', "lang:credit_card_number", 'required|xss_clean');
            $this->form_validation->set_rules('cc[expiryMonth]', "lang:credit_card_expiryMonth", 'required|xss_clean');
            $this->form_validation->set_rules('cc[expiryYear]', "lang:credit_card_expiryYear", 'required|xss_clean');
            $this->form_validation->set_rules('cc[cvv]', "lang:credit_card_cvv", 'required|xss_clean');
        }

        if( $this->input->post('payment[number]') ){
            if( $this->input->post('payment[number]') != $payment->number ){
                $this->form_validation->set_rules('payment[number]', "lang:payment_number", 'is_unique[payments.number]');
            }
        }

        if ($this->form_validation->run() == true)
        {
            $payment_data         = $this->input->post("payment");
            $payment_data['date'] = date_JS_MYSQL($payment_data['date']);
            if( PAYMENTS_ONLINE && $this->payments_model->isOnline($payment_data['method']) ){
                if( $payment_data['method'] == "stripe" ){
                    $payment_data['credit_card'] = json_encode($this->input->post("cc"));
                }
                $payment_data['token'] = substr( md5(rand()), 0, 14);
                $payment_data['status'] = "panding";
            }
        }
        if ( $this->form_validation->run() == true && $this->payments_model->update($id, $payment_data))
        {
            if( $this->input->post("create_receipt") ){
                $this->load->model('receipts_model');
                $receipt_data = $payment_data;
                unset($receipt_data['status']);
                $receipt_data['number'] = $this->receipts_model->next();
                $receipt_data['biller_id'] = $invoice_biller->id;
                $receipt_data['invoice_id'] = $invoice->id;
                $this->receipts_model->create($receipt_data);
                // update settings next count
                $this->settings_model->updateSettingsItem("receipt_next", $receipt_data['number']+1);
            }

            $this->sis_logger->write('invoices', 'update_payment', $invoice->id, "Payment of ".$payment->amount." ".$invoice->currency." is updated to ".$payment_data['amount']." ".$invoice->currency." received from ".$invoice_biller->fullname." via ".$payment_data['method']);

            $this->invoices_model->update_amount_due($payment->invoice_id);
            if( PAYMENTS_ONLINE && $this->payments_model->isOnline($payment_data['method']) ){
                if( $this->paid_online($id, true, false) ){
                    $data = array("status" => "redirect", "message" => site_url("/payments/paid_online/".$id));
                    $this->output->set_content_type('application/json')->set_output(json_encode($data));
                    return false;
                }
            }else{
                $data = array("status" => "success", "message" => lang("payments_edit_success"));
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }
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

                $data['payment']         = $payment;
                $data['invoice']         = $invoice;
                $data['page_title']      = lang('payments_edit');
                $data['page_subheading'] = lang('payments_edit_subheading');
                $this->load->view ( 'payments/payments_edit' , $data );
            }
        }
    }

    public function set_status()
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        if ( $this->ion_auth->in_group(array("customer", "supplier")) || !$this->input->is_ajax_request() || !$this->input->get('id') )
        {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $id = $this->input->get('id');
        $payment = $this->payments_model->get($id);

        $this->form_validation->set_rules('status', "lang:status", 'required|xss_clean');

        if ($this->form_validation->run() == true)
        {
            $status = $this->input->post("status");
            $id     = $this->input->post('id');
        }
        if ( $this->form_validation->run() == true && $this->payments_model->setStatus($id, $status))
        {
            $this->invoices_model->update_amount_due($payment->invoice_id);
            $data = array("status" => "success", "message" => lang("payments_edit_success"));
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
                $data['payment']         = $payment;
                $data['page_title']      = lang('set_status');
                $data['page_subheading'] = lang('set_status_payment_subheading');
                $this->load->view ( 'payments/payments_status' , $data );
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
        foreach ($id as $payment_id) {
            $payment = $this->payments_model->get($payment_id);
            $invoice = $this->invoices_model->getInvoice($payment->invoice_id);
            $invoice_biller = $this->biller_model->getByID($invoice->bill_to_id);
            if ( $this->payments_model->delete($payment_id) )
            {
                $this->sis_logger->write('invoices', 'delete_payment', $invoice->id, "Payment of ".$payment->amount." ".$invoice->currency." received from ".$invoice_biller->fullname." via ".$payment->method." is deleted");
                $this->invoices_model->update_amount_due($payment->invoice_id);
            }
        }
        $result = array("status"=>"success", "message"=>lang("payments_deleted"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
        return true;
    }

    public function details($id = FALSE)
    {
        if($this->input->get('id')) { $id = $this->input->get('id'); }
        if( !$id || !$this->input->is_ajax_request() ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
        $payment = $this->payments_model->get($id);
        if( !$payment ){
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect('/', 'refresh');
        }
        $invoice                  = $this->invoices_model->getInvoice($payment->invoice_id);
        if ( defined("BILLER_ID") && BILLER_ID != $invoice->bill_to_id ){
            return show_error(lang("access_denied"));
        }
        $invoice_biller           = $this->biller_model->getByID($invoice->bill_to_id);
        $data['payment']          = $payment;
        $data['invoice']          = $invoice;
        $data['invoice_biller']   = $invoice_biller;
        $data['invoice_currency'] = CURRENCY_FORMAT==1?$invoice->currency:$this->settings_model->getFormattedCurrencies($invoice->currency)->symbol_native;
        $data['page_title']       = lang("payment_details");

        $this->load->view ( 'payments/payments_details' , $data );
    }

    public function paid_online ($id = false, $check = FALSE, $delete_on_error = TRUE)
    {
        if( $id == FALSE || !PAYMENTS_ONLINE ){
            if( $check ){
                $result = array("status"=>"error", "message"=>lang("access_denied"));
                $this->output->set_content_type('application/json')->set_output(json_encode($result));
                return false;
            }else{
                $this->session->set_flashdata('message', lang("access_denied"));
                redirect('/payments', 'refresh');
                return false;
            }
        }
        $config = $this->settings_model->PO_settings;
        $this->load->library('Payments_online');
        $payment = $this->payments_model->get($id);
        $result = $this->payments_online->make_payment($payment, $config, $check, $delete_on_error);
        if( $check ){
            return $result;
        }else{
            if( $result ){
                redirect('/payments/validate_payment/'.$payment->token."/", 'refresh');
            }else{
                redirect('/payments/index/'.$payment->invoice_id, 'refresh');
            }
        }
    }

    public function validate_payment ($token = FALSE)
    {
        if($this->input->get('p_token')) { $token = $this->input->get('p_token'); }
        if( $token == FALSE ){
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect('/payments', 'refresh');
            return false;
        }
        $payment = $this->payments_model->getByToken($token);
        if( $payment ){
            $status = "released";
            if( defined("BILLER_ID") ){
                $status = "panding";
            }
            if ( $this->payments_model->setStatus($payment->id, $status) ){
                $this->invoices_model->update_amount_due($payment->invoice_id);
                $this->session->set_flashdata('success_message', lang("payment_released"));
            }
        }
        redirect('/payments', 'refresh');
        return true;
    }

    public function cancel_payment ($token = FALSE)
    {
        if($this->input->get('p_token')) { $token = $this->input->get('p_token'); }
        if( $token == FALSE ){
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect('/payments', 'refresh');
            return false;
        }
        $payment = $this->payments_model->getByToken($token);
        if( $payment ){
            if ( $this->payments_model->setStatus($payment->id, "canceled") ){
                $this->invoices_model->update_amount_due($payment->invoice_id);
                $this->session->set_flashdata('message', lang("payment_canceled"));
            }
        }
        redirect('/payments', 'refresh');
        return true;
    }

    public function approve($id = false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        if ( $this->input->get('id') ){$id = $this->input->get('id');}
        if (!$id || !$this->input->is_ajax_request() || $this->ion_auth->in_group(array("customer", "supplier"))) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $payment = $this->payments_model->get($id);
        $status = "released";
        if ( $this->payments_model->setStatus($id, $status))
        {
            $this->invoices_model->update_amount_due($payment->invoice_id);
            $data = array("status" => "success", "message" => lang("payment_released"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

    public function reject($id = false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        if ( $this->input->get('id') ){$id = $this->input->get('id');}
        if (!$id || !$this->input->is_ajax_request() || $this->ion_auth->in_group(array("customer", "supplier"))) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $payment = $this->payments_model->get($id);
        $status = "canceled";
        if ( $this->payments_model->setStatus($id, $status))
        {
            $this->invoices_model->update_amount_due($payment->invoice_id);
            $data = array("status" => "success", "message" => lang("payment_canceled"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

}
