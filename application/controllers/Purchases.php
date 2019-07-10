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


class Purchases extends MY_Controller {
    /**
     * Purchase constructor.
     */
    public function __construct ()
    {
        parent::__construct ();
        // Load Purchase Model
        $this->load->model('Purchase_model',"purchase");
        // Load Supplier Model
        $this->load->model ( 'suppliers_model' );
        // Load Purchase Payments Model
        $this->load->model( 'Purchase_payment_model',"purchase_payment" );
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


    public function index()
    {
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('purchase_order');
        $data['page_title']       = lang('purchase_order');
        $data['page_subheading']  = lang('invoices_subheading');
        $data['is_partial']       = false;
        $meta['breadcrum_false'] = true;

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'purchases/index' , $data );
        $this->load->view ( 'templates/footer' , $meta );
    }


    public function getData()
    {
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

         if( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() ){
            $this->datatables->where("purchase.user_id", USER_ID);
        }
        if( $this->input->post('currency') ){
            $this->datatables->where("purchase.currency", $this->input->post('currency'));
        }
        
        $this->datatables
        ->setsColumns("id,reference,title,date,date_due,fullname,status,total_due,currency,supplier_id")
        ->select("purchase.id as id, purchase.reference as purchase,title, purchase.date as date, purchase.date_due as date_due, IF(suppliers.company='',suppliers.fullname, suppliers.company) as fullname, IF((purchase.status='unpaid' OR purchase.status='partial') AND purchase.date_due<'".date("Y-m-d")."', 'overdue', purchase.status) as status, purchase.total_due as total, currency", false)
        ->join("suppliers", "purchase.supplier_id=suppliers.id")
        ->from("purchase");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }


    public function create()
    {
        if ( $this->ion_auth->in_group(array("customer", "supplier")) )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/purchases", 'refresh');
        }

        $this->form_validation->set_message('validate_items', lang("no_purchase_items"));
        $this->form_validation->set_rules('purchase[title]',     "lang:title",         'required|max_length[25]|xss_clean');
        $this->form_validation->set_rules('purchase[status]',    "lang:status",        'required|xss_clean');
        $this->form_validation->set_rules('purchase[reference]', "lang:reference",     'required|is_unique[purchase.reference]|xss_clean');
        $this->form_validation->set_rules('purchase[date]',      "lang:date",          'required|xss_clean');
        $this->form_validation->set_rules('purchase[date_due]',  "lang:date_due",      'xss_clean');
        $this->form_validation->set_rules('purchase[supplier_id]',"lang:customer",      'required|xss_clean');


        if ($this->form_validation->run() == true)
        {
            $data  = $this->input->post('purchase');
            $data['date']     = date_JS_MYSQL($data['date']);
            if( isset($data['date_due']) && $data['date_due'] != "" ){
                $data['date_due'] = date_JS_MYSQL($data['date_due']);
            }else{
                $data['date_due'] = NULL;
            }
            if( $data['count'] == "0" ){
                $next_reference    = $this->purchase->next_reference();
                $data['reference'] = $next_reference["reference"];
                $data['count']     = $next_reference["next_count"];
            }
            $data['user_id']  = USER_ID;
            $items = $this->input->post("purchase_item");
          
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


        if ( $this->form_validation->run() == true && $purchase_id = $this->purchase->create($data, $items))
        {
            // update settings next count
            $this->settings_model->updateSettingsItem("next_purchase_order", $data['count']+1);

            $this->sis_logger->write('purchase', 'create', $purchase_id, "purchase is created");
           
            //create payment if status is paid or partial
            if( $data['status'] == "paid" || $data['status'] == "partial" ){
                $amount = floatval($data['total'])-floatval($data['total_due']);
                $payment = array(
                    "purchase_id" => $purchase_id,
                    "number"     => $this->purchase_payment->next(),
                    "date"       => $data['date'],
                    "amount"     => $amount,
                    "method"     => "cash",
                );
                $payment_id  = $this->purchase_payment->create($payment);
                $supplier = $this->input->post("supplier_id");
                $this->sis_logger->write('purchase', 'make_payment', $purchase_id, "Payment of ".$amount." ".$data['currency']." received from ".$supplier." via cash");
            }
            $this->session->set_flashdata('success_message', lang("purchase_add_success"));
            redirect("/purchases/open/".$purchase_id, 'refresh');

        }
        else
        {
            $next_reference           = $this->purchase->next_reference();
            $data['next_reference']   = $next_reference["reference"];
            $data['next_count']       = $next_reference["next_count"];
            $data['currencies']       = $this->settings_model->getFormattedCurrencies();
            $data['form_action']      = 'purchases/create';
            $data['message']          = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            $data['error_fields']     = $this->form_validation->error_array();
            $meta['page_title']       = lang('create_purchase_order');
            $data['page_title']       = lang('create_purchase_order');
            $data['page_subheading']  = lang('create_purchase_subheading');
            $this->load->view ( 'templates/head' , $meta );
            $this->load->view ( 'templates/header' );
            $this->load->view ( 'purchases/create' , $data );
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
            redirect("/purchases", 'refresh');
        }
        if ( !$this->input->get('id') )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/purchases", 'refresh');
        }
        $id = $this->input->get('id');
        $purchase = $this->purchase->getPurchase($id);
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $purchase->user_id != USER_ID )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/purchases", 'refresh');
        }

        $this->form_validation->set_message('validate_items', lang("no_purchase_items"));
        $this->form_validation->set_rules('purchase[title]',     "lang:title",         'required|max_length[25]|xss_clean');
        $this->form_validation->set_rules('purchase[status]',    "lang:status",        'required|xss_clean');
        $this->form_validation->set_rules('purchase[date]',      "lang:date",          'required|xss_clean');
        $this->form_validation->set_rules('purchase[date_due]',  "lang:date_due",      'xss_clean');
        $this->form_validation->set_rules('purchase[supplier_id]',"lang:customer",      'required|xss_clean');

        if( $this->input->post('purchase[reference]') ){
            if( $this->input->post('purchase[reference]') != $purchase->reference ){
                // $this->form_validation->set_rules('purchase[reference]', "lang:reference", 'is_unique[purchases.reference]');
            }
        }

        if ($this->form_validation->run() == true)
        {
            $data             = $this->input->post("purchase");

            $data['date']     = date_JS_MYSQL($data['date']);
            if( isset($data['date_due']) && $data['date_due'] != "" ){
                $data['date_due'] = date_JS_MYSQL($data['date_due']);
            }else{
                $data['date_due'] = NULL;
            }
            if( $data['count'] == "0" ){
                $next_reference    = $this->purchase->next_reference($purchase->count);
                $data['reference'] = $next_reference["reference"];
                $data['count']     = $next_reference["next_count"];
            }
            $items            = $this->input->post("purchase_item");
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
        
        if ( $this->form_validation->run() == true && $purchase_id = $this->purchase->update($id, $data, $items))
        {
            $this->sis_logger->write('purchase', 'update', $purchase_id, "purchase is updated");
            $this->session->set_flashdata('success_message', lang("purchase_edit_success"));
            redirect("/purchases/open/".$id, 'refresh');
        }
        else
        {
            $purchase_items           = $this->purchase->getPurchaseItems($id);
            $purchase_supplier          = $this->suppliers_model->getByID($purchase->supplier_id);
            $data['purchase']         = $purchase;
            $data['purchase_items']   = $purchase_items;
            $data['purchase_supplier']  = $purchase_supplier;
            $data['currencies']      = $this->settings_model->getFormattedCurrencies();
            $data['form_action']     = 'purchases/edit?id='.$purchase->id;
            $data['message']         = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            $data['error_fields']    = $this->form_validation->error_array();
            $meta['page_title']      = lang('edit_purchase');
            $data['page_title']      = lang('edit_purchase');
            $data['page_subheading'] = lang('edit_purchase_subheading');

            $meta['breadcrumbs'][] = array(
                "link" => site_url("/purchases/"),
                "label" => lang("purchases"),
            );
            $meta['breadcrumbs'][] = array(
                "link" => site_url("/purchases/open/".$purchase->id),
                "label" => lang("purchase_no")." ".sprintf("%05s", $purchase->count),
            );
            $meta['breadcrumb_first'] = array(
                "class_label" => $this->router->default_controller,
            );

            $this->load->view ( 'templates/head' , $meta );
            $this->load->view ( 'templates/header' );
            $this->load->view ( 'purchases/edit' , $data );
            $this->load->view ( 'templates/footer' , $meta );
        }
    }

    public function open($id = false)
    {
        if( $this->input->get('id') ){ $id = $this->input->get('id');}
        if ( !$id || !($purchase = $this->purchase->getPurchase($id)) )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/purchases", 'refresh');
        }
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $purchase->user_id != USER_ID )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/purchases", 'refresh');
        }

        $purchase_items           = $this->purchase->getPurchaseItems($id);
        $purchase_supplier        = $this->suppliers_model->getByID($purchase->supplier_id);
        $purchase->no             = sprintf("%05s", $purchase->count);
        $data['purchase']         = $purchase;
        $data['purchase_items']   = $purchase_items;
        $data['purchase_supplier']  = $purchase_supplier;
        $data['currencies']      = $this->settings_model->getFormattedCurrencies();
        $data['message']         = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
        $meta['page_title']      = lang("purchase_no")." ".$purchase->no;
        $data['page_title']      = lang("purchase_order");
        $data['page_subheading'] = $purchase->reference;

        /* PREVIEW START */
        $Page_content = array();
        $data['purchase_currency']  = CURRENCY_FORMAT==1?$purchase->currency:$this->settings_model->getFormattedCurrencies($purchase->currency)->symbol_native;
        $Page_content[] = $this->load->view ( 'purchases/purchase_view', $data , true );
        
        $data_print_page['show_btn_config']   = false;
        $data_print_page['is_preview']        = true;
        $data_print_page['show_center_title'] = true;
        $data_print_page['page_title']        = lang("purchase_order");
        $data_print_page['meta_title']        = lang("purchase_no")." ".$purchase->no;
        $data_print_page['Page_content']      = $Page_content;
        $data_print_page['template_name'] = "PURCHASE";
        $preview = $this->load->view ( 'templates/printing_template' , $data_print_page, true );
        /* PREVIEW END */
        $data['preview']         = $preview;
        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'purchases/purchase_preview' , $data );
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
        if ( $this->purchase->delete($id) )
        {
            $this->sis_logger->write('purchase', 'delete', $id, "purchase is deleted");
            $result = array("status"=>"success", "message"=>lang("purchase_deleted"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("cant_delete_purchase"));
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
        $purchase = $this->purchase->getPurchase($id);

        $this->form_validation->set_rules('status', "lang:status", 'required|xss_clean');

        if ($this->form_validation->run() == true)
        {
            $status = $this->input->post("status");
            $id     = $this->input->post('id');
        }
        if ( $this->form_validation->run() == true && $this->purchase->setStatus($id, $status))
        {
            $this->sis_logger->write('purchases', 'update', $id, "purchase status is updated from '".$purchase->status."' to '".$status."'");
            $data = array("status" => "success", "message" => lang("purchase_edit_success"));
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
                $data['purchase']         = $purchase;
                $data['page_title']      = lang('set_status');
                $data['page_subheading'] = lang('set_status_subheading_purchase');
                $this->load->view ( 'purchases/purchases_status' , $data );
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
        $p = $this->input->get('p')?$this->input->get('p'):PURCHASE_PREFIX;
        $y = $this->input->get('y')?$this->input->get('y'):FALSE;
        $this->output->set_content_type('application/json')->set_output( json_encode($this->purchase->next_reference($c, $t, $p, $y)));
    }



    public function preview()
    {
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $purchase                  = arrayToObject($this->input->post("purchase"));
        $purchase->date            = date_JS_MYSQL($purchase->date);
        if( isset($purchase->date_due) && $purchase->date_due != "" ){
            $purchase->date_due        = date_JS_MYSQL($purchase->date_due);
        }
       
        $purchase_items           = $this->input->post("purchase_item");
        $purchase_supplier          = $this->suppliers_model->getByID($purchase->supplier_id);
        $data['purchase']          = $purchase;
        $data['purchase_items']   = $purchase_items;
        $data['purchase_supplier']  = $purchase_supplier;
        $purchase->no              = sprintf("%05s", $purchase->count);
        $data['purchase_currency'] = CURRENCY_FORMAT==1?$purchase->currency:$this->settings_model->getFormattedCurrencies($purchase->currency)->symbol_native;
        $data['page_title']       = lang("purchase_order");
        $Page_content = $this->load->view ( 'purchases/purchase_view', $data , true );

        // PRINT TEMPLATE
        $data_print_page['show_btn_config'] = false;
        $data_print_page['is_preview'] = true;
        $data_print_page['show_center_title'] = true;
        $data_print_page['page_title'] = lang("purchase_order");
        $data_print_page['meta_title'] = lang("purchase_no")." ".$purchase->no;
        $data_print_page['Page_content'] = $Page_content;
        $data_print_page['template_name'] = "PURCHASE";
        $this->load->view ( 'templates/printing_template' , $data_print_page );
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
        $purchase        = $this->purchase->getPurchase($id);
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $purchase->user_id != USER_ID ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        if ( $purchase == false )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/purchases", 'refresh');
        }
        $purchase              = objectToArray($purchase);
        $old_reference        = $purchase["reference"];
        $next_reference       = $this->purchase->next_reference();
        $purchase['reference'] = $next_reference["reference"];
        $purchase['count']     = $next_reference["next_count"];
        $purchase_items        = $this->purchase->getPurchaseItems($id);
        unset($purchase['id']);
        foreach ($purchase_items as $key => $item) {
            unset($purchase_items[$key]['id']);
            unset($purchase_items[$key]['purchase_id']);
        }
        

        if ( $purchase_id = $this->purchase->create($purchase, $purchase_items) )
        {
             $this->settings_model->updateSettingsItem("next_purchase_order", $purchase['count']+1);
             
            $this->sis_logger->write('purchase', 'clone', $purchase_id, "purchase is duplicated from purchase #".$old_reference);
            $result = array("status"=>"success", "message"=>lang("purchase_duplicate_success"));
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
        foreach ($id as $purchase_id) {
            // purchase view
            $purchase                  = $this->purchase->getPurchase($purchase_id);
            if ( defined("SUPPLIER_ID") && SUPPLIER_ID != $purchase->supplier_id ){
                return show_error(lang("access_denied"));
            }
            $purchase_items            = $this->purchase->getPurchaseItems($purchase_id);
            $purchase_supplier           = $this->suppliers_model->getByID($purchase->supplier_id);
            $data['purchase']          = $purchase;
            $data['purchase_items']    = $purchase_items;
            $data['purchase_supplier']   = $purchase_supplier;
            $data['purchase_currency'] = CURRENCY_FORMAT==1?$purchase->currency:$this->settings_model->getFormattedCurrencies($purchase->currency)->symbol_native;
            $purchase->no              = sprintf("%05s", $purchase->count);
            $data['page_title']       = $purchase->title;
            $Page_content[] = $this->load->view ( 'purchases/purchase_view' , $data , true );

            if( $this->settings_model->SYS_Settings->show_payments_page && $this->purchase->getPaymentsTotal($purchase_id) > 0 ){
                $data['payments']     = $this->purchase_payment->getPaymentsByPurchase($purchase_id);
                $Page_content[] = $this->load->view ( 'purchases/purchase_payment_view' , $data , true );
            }
        }
        if( count($id) == 1 ){
            $page_title = lang("purchase_no")." ".sprintf("%06s", $purchase->no );
        }else{
            $page_title = lang("purchases");
        }

        // PRINT TEMPLATE
        $data_print_page['show_center_title'] = true;
        $data_print_page['page_title'] = $purchase->title;
        $data_print_page['meta_title'] = $page_title;
        $data_print_page['Page_content'] = $Page_content;
        $data_print_page['template_name'] = "PURCHASE";
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

        $template = $this->settings_model->getEmailTemplate("send_purchase_order_to_customer.tpl", LANGUAGE);
        $company  = $this->settings_model->getSettings("COMPANY");
        $purchase  = $this->purchase->getPurchase($id);
        $supplier   = $this->suppliers_model->getByID($purchase->supplier_id);

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
            
                $emails                  = $this->purchase->getPurchaseEmails($id);
                $data['id']              = $id;
                $data['emails_list']     = $emails;
                $data['page_title']      = lang('send_email');
                $data['email_type']      = lang('purchase_order');
                $data['email_subject']   = parse_object_sis($template->subject, $company, $purchase, $supplier);
                $data['email_content']   = parse_object_sis($template->content, $company, $purchase, $supplier);
                $data['email_cc']        = COMPANY_EMAIL;
                $data['form_action']     = "purchases/email?id=".$id;
                $this->load->view ( 'global/email' , $data );
            }
        }
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
            redirect("/purchase", 'refresh');
        }
        $id                      = $this->input->get('id');
        $data['purchase']         = $this->purchase->getPurchase($id);
        $data['page_title']      = lang("purchase_activities");
        $data['activities']      = $this->sis_logger->getLogs("purchase", $id);

        $this->load->view ( 'purchases/purchases_activities' , $data );
    }


}

?>