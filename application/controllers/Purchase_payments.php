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

class Purchase_payments extends MY_Controller
{
    /**
     * Purchase_payment constructor.
     */

    public function __construct ()
    {
        parent::__construct ();
        // Load Purchase Payments Model
        $this->load->model ( 'purchase_payment_model' );
        // Load Purchase Model
        $this->load->model( 'Purchase_model',"purchase" );
        // Load Purchase Receipts
        $this->load->model( "Receipts_purchase_model" );
        // Load Supplier Model
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

    public function index ($purchase = false)
    {

        if($this->input->get('purchase')){ $purchase = $this->input->get('purchase'); }
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $data['purchase']          = $purchase;
        $meta['page_title']       = lang('payments');
        $data['page_title']       = lang('payments');
        $data['page_subheading']  = lang('payments_subheading');
        if( $purchase ){
            $purchase_obj = $this->purchase->getPurchase($purchase);
            if( !$purchase_obj ){
                $this->session->set_flashdata('message', lang("access_denied"));
                redirect("/purchase_payment", 'refresh');
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
        $this->load->view ( 'purchase_payments/payments' , $data );
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
            $this->datatables->where("purchase.supplier_id", BILLER_ID);
        }
        if( $this->input->post('biller_id') ){
            $this->datatables->where("purchase.supplier_id", $this->input->post('biller_id'));
        }
        $this->datatables
        ->setsColumns("id,number,purchase,fullname,p_date,amount,method,status,details,purchase_id,supplier_id,currency")
        ->select("purchase_payment.id as id,number,purchase.reference as purchase,IF(suppliers.company='',suppliers.fullname, suppliers.company) as fullname,purchase_payment.date as p_date,amount,method,purchase_payment.status as status,details,purchase_id,purchase.supplier_id as supplier_id,purchase.currency as currency", false)
        ->join("purchase", "purchase.id=purchase_payment.purchase_id", "left")
        ->join("suppliers", "purchase.supplier_id=suppliers.id", "left")
        ->from("purchase_payment");
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
        $purchase = $this->purchase->getPurchase($id);
        $purchase_biller = $this->suppliers_model->getByID($purchase->supplier_id);
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
            if( PAYMENTS_ONLINE && $this->purchase_payment_model->isOnline($payment_data['method']) ){
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
        if ( $this->form_validation->run() == true && $payment_id = $this->purchase_payment_model->create($payment_data))
        {
            if( $this->input->post("create_receipt") ){
                $this->load->model('receipts_model');
                $receipt_data = $payment_data;
                unset($receipt_data['status']);
                $receipt_data['number'] = $this->Receipts_purchase_model->next();
                $receipt_data['supplier_id'] = $purchase_biller->id;
                $this->Receipts_purchase_model->create($receipt_data);
                // update settings next count
                $this->settings_model->updateSettingsItem("purchase_receipt_next", $receipt_data['number']+1);
            }

            $this->sis_logger->write('Purchase', 'make_payment', $purchase->id, "Payment of ".$payment_data['amount']." ".$purchase->currency." received from ".$purchase_biller->fullname." via ".$payment_data['method']);

            $this->purchase->update_amount_due($payment_data['purchase_id']);
            if( PAYMENTS_ONLINE && $this->purchase_payment_model->isOnline($payment_data['method']) ){
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
                $data['purchase']         = $purchase;
                $data['next_number']     = $this->purchase_payment_model->next();
                $data['page_title']      = lang('payments_create');
                $data['page_subheading'] = lang('payments_create_subheading');
                $this->load->view ( 'purchase_payments/payments_create' , $data );
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
        $payment = $this->purchase_payment_model->get($id);
        $purchase = $this->purchase->getPurchase($payment->purchase_id);
        $purchase_supplier = $this->suppliers_model->getByID($purchase->supplier_id);

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
            if( PAYMENTS_ONLINE && $this->purchase_payment_model->isOnline($payment_data['method']) ){
                if( $payment_data['method'] == "stripe" ){
                    $payment_data['credit_card'] = json_encode($this->input->post("cc"));
                }
                $payment_data['token'] = substr( md5(rand()), 0, 14);
                $payment_data['status'] = "panding";
            }
        }
        if ( $this->form_validation->run() == true && $this->purchase_payment_model->update($id, $payment_data))
        {
            if( $this->input->post("create_receipt") ){
                $this->load->model('receipts_purchase_model');
                $receipt_data = $payment_data;
                unset($receipt_data['status']);
                $receipt_data['number'] = $this->receipts_purchase_model->next();
                $receipt_data['supplier_id'] = $purchase_supplier->id;
                $receipt_data['purchase_id'] = $purchase->id;
                $this->receipts_purchase_model->create($receipt_data);
                // update settings next count
                $this->settings_model->updateSettingsItem("purchase_receipt_next", $receipt_data['number']+1);
            }

            $this->sis_logger->write('purchase', 'update_payment', $purchase->id, "Payment of ".$payment->amount." ".$purchase->currency." is updated to ".$payment_data['amount']." ".$purchase->currency." received from ".$purchase_supplier->fullname." via ".$payment_data['method']);

            $this->purchase->update_amount_due($payment->purchase_id);
            if( PAYMENTS_ONLINE && $this->purchase_payment_model->isOnline($payment_data['method']) ){
                if( $this->paid_online($id, true, false) ){
                    $data = array("status" => "redirect", "message" => site_url("/purchase_payments/paid_online/".$id));
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
                $data['purchase']         = $purchase;
                $data['page_title']      = lang('payments_edit');
                $data['page_subheading'] = lang('payments_edit_subheading');
                $this->load->view ( 'purchase_payments/payments_edit' , $data );
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
        $payment = $this->purchase_payment_model->get($id);

        $this->form_validation->set_rules('status', "lang:status", 'required|xss_clean');

        if ($this->form_validation->run() == true)
        {
            $status = $this->input->post("status");
            $id     = $this->input->post('id');
        }
        if ( $this->form_validation->run() == true && $this->purchase_payment_model->setStatus($id, $status))
        {
            $this->purchase->update_amount_due($payment->purchase_id);
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
                $this->load->view ( 'purchase_payments/payments_status' , $data );
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
            $payment = $this->purchase_payment_model->get($payment_id);
            $purchase = $this->purchase->getPurchase($payment->purchase_id);
            $purchase_supplier = $this->suppliers_model->getByID($purchase->supplier_id);
            if ( $this->purchase_payment_model->delete($payment_id) )
            {
                $this->sis_logger->write('purchase', 'delete_payment', $purchase->id, "Payment of ".$payment->amount." ".$purchase->currency." received from ".$purchase_supplier->fullname." via ".$payment->method." is deleted");
                $this->purchase->update_amount_due($payment->purchase_id);
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
        $payment = $this->purchase_payment_model->get($id);
        if( !$payment ){
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect('/', 'refresh');
        }
        $purchase                  = $this->purchase->getPurchase($payment->purchase_id);
        if ( defined("BILLER_ID") && BILLER_ID != $purchase->supplier_id ){
            return show_error(lang("access_denied"));
        }
        $purchase_supplier         = $this->suppliers_model->getByID($purchase->supplier_id);
        $data['payment']          = $payment;
        $data['purchase']          = $purchase;
        $data['purchase_supplier']   = $purchase_supplier;
        $data['purchase_currency'] = CURRENCY_FORMAT==1?$purchase->currency:$this->settings_model->getFormattedCurrencies($purchase->currency)->symbol_native;
        $data['page_title']       = lang("payment_details");

        $this->load->view ( 'purchase_payments/payments_details' , $data );
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
                redirect('/purchase_payments', 'refresh');
                return false;
            }
        }
        $config = $this->settings_model->PO_settings;
        $this->load->library('Payments_online');
        $payment = $this->purchase_payment_model->get($id);
        $result = $this->payments_online->make_payment($payment, $config, $check, $delete_on_error);
        if( $check ){
            return $result;
        }else{
            if( $result ){
                redirect('/purchase_payments/validate_payment/'.$payment->token."/", 'refresh');
            }else{
                redirect('/purchase_payments/index/'.$payment->purchase_id, 'refresh');
            }
        }
    }

    public function validate_payment ($token = FALSE)
    {
        if($this->input->get('p_token')) { $token = $this->input->get('p_token'); }
        if( $token == FALSE ){
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect('/purchase_payments', 'refresh');
            return false;
        }
        $payment = $this->purchase_payment_model->getByToken($token);
        if( $payment ){
            $status = "released";
            if( defined("BILLER_ID") ){
                $status = "panding";
            }
            if ( $this->purchase_payment_model->setStatus($payment->id, $status) ){
                $this->purchase->update_amount_due($payment->purchase_id);
                $this->session->set_flashdata('success_message', lang("payment_released"));
            }
        }
        redirect('/purchase_payments', 'refresh');
        return true;
    }

    public function cancel_payment ($token = FALSE)
    {
        if($this->input->get('p_token')) { $token = $this->input->get('p_token'); }
        if( $token == FALSE ){
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect('/purchase_payments', 'refresh');
            return false;
        }
        $payment = $this->purchase_payment_model->getByToken($token);
        if( $payment ){
            if ( $this->purchase_payment_model->setStatus($payment->id, "canceled") ){
                $this->purchase->update_amount_due($payment->purchase_id);
                $this->session->set_flashdata('message', lang("payment_canceled"));
            }
        }
        redirect('/purchase_payments', 'refresh');
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
        $payment = $this->purchase_payment_model->get($id);
        $status = "released";
        if ( $this->purchase_payment_model->setStatus($id, $status))
        {
            $this->purchase->update_amount_due($payment->purchase_id);
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
        $payment = $this->purchase_payment_model->get($id);
        $status = "canceled";
        if ( $this->purchase_payment_model->setStatus($id, $status))
        {
            $this->purchase->update_amount_due($payment->purchase_id);
            $data = array("status" => "success", "message" => lang("payment_canceled"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

}
