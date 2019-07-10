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

class Expenses extends MY_Controller
{
    /**
     * Expenses constructor.
     */
    public function __construct ()
    {
        parent::__construct ();
        // Load Expenses Model
        $this->load->model ( 'expenses_model' );
        // Load Suppliers Model
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
                $next_link = urlencode("/expenses");
                $result = array("status"=>"redirect", "message"=>site_url("auth/login?next=$next_link"));
                die(json_encode($result));
            }else{
                $next_link = urlencode(substr("$_SERVER[REQUEST_URI]", stripos("$_SERVER[REQUEST_URI]", "index.php")+9));
                redirect("auth/login?next=$next_link");
            }
        }
        if( $this->ion_auth->in_group(array("customer", "supplier")) ){
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/", 'refresh');
        }
    }

    public function index ($supplier_id=FALSE)
    {
        if($this->input->get('supplier_id')){ $supplier_id = $this->input->get('supplier_id'); }
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['supplier_id']      = $supplier_id;
        $meta['page_title']       = lang('expenses');
        $data['page_title']       = lang('expenses');
        $data['page_subheading']  = lang('expenses_subheading');

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'expenses/content' , $data );
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
        if( $this->input->post("supplier_id") ){
            $this->datatables->where("suppliers.id", $this->input->post("supplier_id"));
        }
        if( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() ){
            $this->datatables->where("expenses.user_id", USER_ID);
        }
        $this->datatables
        ->setsColumns("id,number,reference,fullname,category,date,date_due,status,amount,tax_total,total,payment_date,supplier_id,attachments,currency,total_due")
        ->select("expenses.id as id,expenses.number as number, reference, IF(suppliers.company='',suppliers.fullname, suppliers.company) as fullname, category, date, date_due, IF(expenses.status='unpaid' AND expenses.date_due<'".date("Y-m-d")."', 'overdue', expenses.status) as status, amount, tax_total, total, payment_date, supplier_id, attachments,currency,total_due", false)
        ->join("suppliers", "suppliers.id=expenses.supplier_id", "left")
        ->from("expenses");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }

    public function create($supplier_id=FALSE)
    {
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if($this->input->get('supplier_id')){ $supplier_id = $this->input->get('supplier_id'); }
        $this->form_validation->set_rules('expense[number]',         "lang:expense_number", 'required|is_unique[expenses.number]|xss_clean');
        $this->form_validation->set_rules('expense[reference]',      "lang:reference",      'xss_clean');
        $this->form_validation->set_rules('expense[category]',       "lang:category",       'required|xss_clean');
        $this->form_validation->set_rules('expense[date]',           "lang:date",           'required|xss_clean');
        $this->form_validation->set_rules('expense[date_due]',       "lang:date_due",       'xss_clean');
        $this->form_validation->set_rules('expense[amount]',         "lang:amount",         'required|greater_than[0]|xss_clean');
        $this->form_validation->set_rules('expense[tax_total]',      "lang:tax_total",      'xss_clean');
        $this->form_validation->set_rules('expense[total]',          "lang:total",          'xss_clean');
        $this->form_validation->set_rules('expense[payment_method]', "lang:payment_method", 'xss_clean');
        $this->form_validation->set_rules('expense[payment_date]',   "lang:payment_date",   'xss_clean');
        $this->form_validation->set_rules('expense[attachments]',    "lang:attachments",    'xss_clean');
        $this->form_validation->set_rules('expense[supplier_id]',    "lang:supplier",       'xss_clean');
        $this->form_validation->set_rules('expense[details]',        "lang:details",        'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data         = $this->input->post("expense");
            $data['date'] = date_JS_MYSQL($data['date']);
            if( isset($data['date_due']) && $data['date_due'] != "" ){
                $data['date_due'] = date_JS_MYSQL($data['date_due']);
            }else{
                $data['date_due'] = NULL;
            }
            if( isset($data['attachments']) && $data['attachments'] != "" ){
                $data['attachments'] = json_encode($data['attachments']);
            }
            $data['user_id']  = USER_ID;
            if( !$data['supplier_id'] || $data['supplier_id']=="0" ){
                unset($data['supplier_id']);
            }

            if( $data["status"] == "paid" ){
                if( isset($data['payment_date']) && $data['payment_date'] != "" ){
                    $data['payment_date'] = date_JS_MYSQL($data['payment_date']);
                }else{
                    $data['payment_date'] = date("Y-m-d");
                }
            }else{
                $data['payment_date'] = NULL;
            }
            if( $data["status"] == "unpaid" ){
                $data['payment_method'] = "";
            }
        }
        if ( $this->form_validation->run() == true && ($expense_id=$this->expenses_model->create($data)))
        {
            // create payment if status is paid or partial
            if( $data['status'] == "paid" || $data['status'] == "partial" ){
                $amount = floatval($data['total'])-floatval($data['total_due']);
                $payment = array(
                    "expense_id" => $expense_id,
                    "number"     => $this->expenses_model->next_payment(),
                    "date"       => $data['date'],
                    "amount"     => $amount,
                    "method"     => $data['payment_method'],
                    "status"     => "released",
                );
                $payment_id  = $this->expenses_model->add_payment($payment);
                $this->expenses_model->update_amount_due($expense_id);
            }
            // update settings next count
            $this->settings_model->updateSettingsItem("expense_next", $data['number']+1);
            $data = array("status" => "success", "message" => lang("expenses_create_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array("status"=>"error","message"=>(validation_errors()?validation_errors():$this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array());
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                if( $supplier_id ){
                    $supplier            = $this->suppliers_model->getByID($supplier_id);
                    $data['supplier']    = $supplier;
                }
                $data['tax_rates']       = $this->settings_model->getAllTaxRates();
                $data['categories']      = $this->expenses_model->getAllcategories();
                $data['next_number']     = $this->expenses_model->next();
                $data['page_title']      = lang('expenses_create');
                $data['page_subheading'] = lang('expenses_create_subheading');
                $this->load->view ( 'expenses/create' , $data );
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
        if($this->input->get('id')){ $id = $this->input->get('id'); }
        if( !$id || !$this->input->is_ajax_request() ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $expense = $this->expenses_model->get($id);
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $expense->user_id != USER_ID ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->form_validation->set_rules('expense[number]',         "lang:expense_number", 'required|xss_clean');
        $this->form_validation->set_rules('expense[reference]',      "lang:reference",      'xss_clean');
        $this->form_validation->set_rules('expense[category]',       "lang:category",       'required|xss_clean');
        $this->form_validation->set_rules('expense[date]',           "lang:date",           'required|xss_clean');
        $this->form_validation->set_rules('expense[date_due]',       "lang:date_due",       'xss_clean');
        $this->form_validation->set_rules('expense[amount]',         "lang:amount",         'required|greater_than[0]|xss_clean');
        $this->form_validation->set_rules('expense[tax_total]',      "lang:tax_total",      'xss_clean');
        $this->form_validation->set_rules('expense[total]',          "lang:total",          'xss_clean');
        $this->form_validation->set_rules('expense[payment_method]', "lang:payment_method", 'xss_clean');
        $this->form_validation->set_rules('expense[payment_date]',   "lang:payment_date",   'xss_clean');
        $this->form_validation->set_rules('expense[attachments]',    "lang:attachments",    'xss_clean');
        $this->form_validation->set_rules('expense[supplier_id]',    "lang:supplier",       'xss_clean');
        $this->form_validation->set_rules('expense[details]',        "lang:details",        'xss_clean');

        if( $this->input->post('expense[number]') ){
            if( $this->input->post('expense[number]') != $expense->number ){
                $this->form_validation->set_rules('expense[number]', "lang:receipt_number", 'is_unique[expenses.number]');
            }
        }

        if ($this->form_validation->run() == true)
        {
            $data         = $this->input->post("expense");
            $data['date'] = date_JS_MYSQL($data['date']);
            if( isset($data['date_due']) && $data['date_due'] != "" ){
                $data['date_due'] = date_JS_MYSQL($data['date_due']);
            }else{
                $data['date_due'] = NULL;
            }
            if( isset($data['attachments']) && $data['attachments'] != "" ){
                $data['attachments'] = json_encode($data['attachments']);
            }
            $data['status'] = $data['payment_method']==""?"unpaid":"paid";
            if( !$data['supplier_id'] || $data['supplier_id']=="0" ){
                unset($data['supplier_id']);
            }

            if( $data["status"] == "paid" ){
                if( isset($data['payment_date']) && $data['payment_date'] != "" ){
                    $data['payment_date'] = date_JS_MYSQL($data['payment_date']);
                }else{
                    $data['payment_date'] = date("Y-m-d");
                }
            }else{
                $data['payment_date'] = NULL;
            }
            if( $data["status"] == "unpaid" ){
                $data['payment_method'] = "";
            }
        }
        if ( $this->form_validation->run() == true && $this->expenses_model->update($id, $data))
        {
            $this->expenses_model->update_amount_due($id);
            $data = array("status" => "success", "message" => lang("expenses_edit_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array("status"=>"error","message"=>(validation_errors()?validation_errors():$this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array());
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{

                $data['expense']         = $expense;
                if( $expense->supplier_id != null ){
                    $supplier                = $this->suppliers_model->getByID($expense->supplier_id);
                    $data['supplier']        = $supplier;
                }
                if( trim($expense->attachments) != "" ){
                    $this->load->model('files_model');
                    $data['attached_files']  = $this->files_model->getByID(json_decode($expense->attachments));
                }
                $data['tax_rates']       = $this->settings_model->getAllTaxRates();
                $data['categories']      = $this->expenses_model->getAllcategories();
                $data['page_title']      = lang('expenses_edit');
                $data['page_subheading'] = lang('expenses_edit_subheading');
                $this->load->view ( 'expenses/edit' , $data );
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
        if( !$id || !$this->input->is_ajax_request() ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        foreach ($id as $expense_id) {
            $this->expenses_model->delete($expense_id);
        }
        $result = array("status"=>"success", "message"=>lang("expenses_deleted"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
        return true;
    }

    public function view($id = false)
    {
        if( $this->input->get('id') ){$id = $this->input->get('id');}
        if ( !$id || !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $expense = $this->expenses_model->get($id);
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $expense->user_id != USER_ID ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $data['page_title']         = lang('details_expense');
        $data['expense']            = $expense;
        if( $expense->supplier_id != null ){
            $supplier               = $this->suppliers_model->getByID($expense->supplier_id);
            $data['supplier']       = $supplier;
        }
        if( trim($expense->attachments) != "" ){
            $this->load->model('files_model');
            $data['attached_files'] = $this->files_model->getByID(json_decode($expense->attachments));
        }
        $data['currency']           = CURRENCY_FORMAT==1?$expense->currency:$this->settings_model->getFormattedCurrencies($expense->currency)->symbol_native;

        $this->load->view ( 'expenses/details' , $data );
    }

    // Categories
    public function categories ()
    {
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('expenses_categories');
        $data['page_title']       = lang('expenses_categories');
        $data['page_subheading']  = lang('expenses_subheading');

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'expenses/categories' , $data );
        $this->load->view ( 'templates/footer' , $meta );
    }

    public function getDataCategories(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->load->library('datatables');
        $this->datatables
        ->setsColumns("id,type,label,is_default")
        ->select("id,type,label,is_default", true)
        ->from("expenses_categories");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }

    public function create_category()
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
        $this->form_validation->set_rules('category[type]',       "lang:expenses_category_type",    'required|xss_clean');
        $this->form_validation->set_rules('category[label]',      "lang:expenses_category_label",   'required|xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data = $this->input->post("category");
        }
        if ( $this->form_validation->run() == true && $this->expenses_model->create_category($data))
        {
            $data = array("status" => "success","message" => lang("expenses_category_added"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array("status"=>"error","message"=>(validation_errors()?validation_errors():$this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array());
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                $data['page_title'] = lang('expenses_category_create');
                $this->load->view ( 'expenses/categories_create' , $data );
            }
        }
    }

    public function update_category($id = false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if( $this->input->get("id") ){ $id= $this->input->get("id");}
        if ( !$id || !$this->input->is_ajax_request() )
        {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $category = $this->expenses_model->get_category($id);

        $this->form_validation->set_rules('category[type]',       "lang:expenses_category_type",    'required|xss_clean');
        $this->form_validation->set_rules('category[label]',      "lang:expenses_category_label",   'required|xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data_tax_rate = $this->input->post("category");
        }
        if ( $this->form_validation->run() == true && $this->expenses_model->update_category($id, $data_tax_rate))
        {
            $data = array("status" => "success","message" => lang("expenses_category_updated"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array("status"=>"error","message"=>(validation_errors()?validation_errors():$this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array());
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                $data['page_title'] = lang('expenses_category_update');
                $data['category']   = $category;
                $this->load->view ( 'expenses/categories_update' , $data );
            }
        }
    }

    public function delete_category($id = false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if($this->input->get('id')) { $id = array($this->input->get('id')); }
        if($this->input->post('id')) { $id = $this->input->post('id'); }
        if( !$id || !$this->input->is_ajax_request() ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        if ( $this->expenses_model->delete_category($id) )
        {
            $result = array("status"=>"success", "message"=>lang("expenses_category_deleted"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("access_denied"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function download_attachment($id = false){
        if( $this->input->get('id') ){$id = $this->input->get('id');}
        if ( !$id || !($expense = $this->expenses_model->get($id)) ) {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/expenses", 'refresh');
        }
        if( trim($expense->attachments) != "" ){
            $this->load->model('files_model');
            $files = $this->files_model->getByID(json_decode($expense->attachments));
            foreach ($files as $file) {
                $links[] = $file->link;
            }
            redirect('/files/download/'.implode(",", $links),'refresh');
        }else{
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/expenses", 'refresh');
        }
    }





    public function payments ($expense_id = false)
    {
        if($this->input->get('expense_id')){ $expense_id = $this->input->get('expense_id'); }
        if( !$this->expenses_model->get($expense_id) ){
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/expenses", 'refresh');
        }
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $data['expense']          = $expense_id;
        $meta['page_title']       = lang('payments');
        $data['page_title']       = lang('payments');
        $data['page_subheading']  = lang('payments_subheading');
        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'expenses/payments' , $data );
        $this->load->view ( 'templates/footer' , $meta );
    }

    public function getPaymentsData(){
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
        if ( $this->input->post('expense_id') )
        {
            $this->datatables->where("expense_id", $this->input->post('expense_id'));
        }
        if( $this->input->post('supplier_id') ){
            $this->datatables->where("expenses.supplier_id", $this->input->post('supplier_id'));
        }
        $this->datatables
        ->setsColumns("id,number,expense_ref,fullname,p_date,amount,method,status,details,expense_id,supplier_id,currency")
        ->select("expenses_payments.id as id,expenses_payments.number,expenses.number as expense_ref,IF(suppliers.company='',suppliers.fullname, suppliers.company) as fullname,expenses_payments.date as p_date,expenses_payments.amount,method,expenses_payments.status as status,expenses_payments.details,expense_id,expenses.supplier_id as supplier_id,expenses.currency as currency", false)
        ->join("expenses", "expenses.id=expenses_payments.expense_id", "left")
        ->join("suppliers", "expenses.supplier_id=suppliers.id", "left")
        ->from("expenses_payments");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }

    public function add_payment($id=FALSE)
    {
        if($this->input->get('id')){ $id = $this->input->get('id'); }
        if( !$id || !($expense = $this->expenses_model->get($id)) || !$this->input->is_ajax_request() ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->form_validation->set_rules('payment[number]',  "lang:payment_number", 'required|is_unique[expenses_payments.number]|xss_clean');
        $this->form_validation->set_rules('payment[amount]',  "lang:amount",         'required|xss_clean');
        $this->form_validation->set_rules('payment[date]',    "lang:date",           'required|xss_clean');
        $this->form_validation->set_rules('payment[method]',  "lang:payment_method", 'required|xss_clean');
        $this->form_validation->set_rules('payment[details]', "lang:details",        'xss_clean');
        if ($this->form_validation->run() == true)
        {
            $payment_data         = $this->input->post("payment");
            $payment_data['date'] = date_JS_MYSQL($payment_data['date']);
        }
        if ( $this->form_validation->run() == true && $payment_id = $this->expenses_model->add_payment($payment_data))
        {
            $this->expenses_model->update_amount_due($payment_data['expense_id']);
            $data = array("status" => "success", "message" => lang("payments_create_success"));
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
                $data['expense']         = $expense;
                $data['next_number']     = $this->expenses_model->next_payment();
                $data['page_title']      = lang('payments_create');
                $data['page_subheading'] = lang('payments_create_subheading');
                $this->load->view ( 'expenses/payments_create' , $data );
            }
        }
    }

    public function edit_payment($id=FALSE)
    {
        if( VERSION == "DEMO" ){
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if($this->input->get('id')){ $id = $this->input->get('id'); }
        if( !$id || !($payment = $this->expenses_model->get_payment($id)) || !$this->input->is_ajax_request() ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $expense = $this->expenses_model->get($payment->expense_id);
        $this->form_validation->set_rules('payment[number]',  "lang:payment_number", 'required|xss_clean');
        $this->form_validation->set_rules('payment[amount]',  "lang:amount",         'required|xss_clean');
        $this->form_validation->set_rules('payment[date]',    "lang:date",           'required|xss_clean');
        $this->form_validation->set_rules('payment[method]',  "lang:payment_method", 'required|xss_clean');
        $this->form_validation->set_rules('payment[details]', "lang:details",        'xss_clean');
        if( $this->input->post('payment[number]') ){
            if( $this->input->post('payment[number]') != $payment->number ){
                $this->form_validation->set_rules('payment[number]', "lang:payment_number", 'is_unique[expenses_payments.number]');
            }
        }
        if ($this->form_validation->run() == true)
        {
            $payment_data         = $this->input->post("payment");
            $payment_data['date'] = date_JS_MYSQL($payment_data['date']);
        }
        if ( $this->form_validation->run() == true && $this->expenses_model->edit_payment($id, $payment_data))
        {
            $this->expenses_model->update_amount_due($payment->expense_id);
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
                $data['expense']         = $expense;
                $data['page_title']      = lang('payments_edit');
                $data['page_subheading'] = lang('payments_edit_subheading');
                $this->load->view ( 'expenses/payments_edit' , $data );
            }
        }
    }

    public function delete_payment()
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if($this->input->get('id')) { $id = array($this->input->get('id')); }
        if($this->input->post('id')) { $id = $this->input->post('id'); }
        if( !isset($id) || !$id || !$this->input->is_ajax_request() ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        foreach ($id as $payment_id) {
            $payment = $this->expenses_model->get_payment($payment_id);
            if ( $this->expenses_model->delete_payment($payment_id) )
            {
                $this->expenses_model->update_amount_due($payment->expense_id);
            }
        }
        $result = array("status"=>"success", "message"=>lang("payments_deleted"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
        return true;
    }

    public function details_payment($id = FALSE)
    {
        if($this->input->get('id')) { $id = $this->input->get('id'); }
        if( !$id || !($payment = $this->expenses_model->get_payment($id)) || !$this->input->is_ajax_request() ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
        $expense            = $this->expenses_model->get($payment->expense_id);
        $supplier           = $this->suppliers_model->getByID($expense->supplier_id);
        $data['payment']    = $payment;
        $data['expense']    = $expense;
        $data['supplier']   = $supplier;
        $data['currency']   = CURRENCY_FORMAT==1?$expense->currency:$this->settings_model->getFormattedCurrencies($expense->currency)->symbol_native;
        $data['page_title'] = lang("payment_details");

        $this->load->view ( 'expenses/payments_details' , $data );
    }
}
