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

class Reports extends MY_Controller
{
    /**
    * Reports constructor.
    */
    public function __construct ()
    {
        parent::__construct ();
        // Load Reports Model
        $this->load->model ( 'reports_model' );
        // Load Helper Language
        $this->load->helper('language');
        // Load Helper Date Format
        $this->load->helper('date_format');
        // Check user is logged in ?
        if ( !$this->ion_auth->logged_in () ) {
            if ($this->input->is_ajax_request()) {
                $next_link = urlencode("/reports");
                $result = array("status"=>"redirect", "message"=>site_url("auth/login?next=$next_link"));
                die(json_encode($result));
            }else{
                $next_link = urlencode(substr("$_SERVER[REQUEST_URI]", stripos("$_SERVER[REQUEST_URI]", "index.php")+9));
                redirect("auth/login?next=$next_link");
            }
        }
        if( !$this->ion_auth->in_group(array("admin", "supperadmin")) ){
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/", 'refresh');
        }
    }

    public function index()
    {
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('reports');
        $data['page_title']       = lang('reports');
        $data['currencies']       = $this->reports_model->getUsedCurrencies();

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'reports/content' , $data);
        $this->load->view ( 'templates/footer' , $meta );
    }

    public function profit_loss()
    {
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('profit_loss');
        $data['page_title']       = lang('profit_loss');
        $data['page_subheading']  = lang('profit_loss_subheading');
        $data['currencies']       = $this->reports_model->getUsedCurrencies();

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'reports/profit_loss' , $data);
        $this->load->view ( 'templates/footer' , $meta );
    }

    public function getExpensesPie(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $start_date        = $this->input->post("start");
        $end_date          = $this->input->post("end");
        $currency          = $this->input->post("currency");
        $expenses          = $this->reports_model->expenses_pie($start_date, $end_date, $currency);
        $this->output->set_content_type('application/json')->set_output( json_encode($expenses));
    }

    public function getOutstandingRevenueBars(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $start_date        = $this->input->post("start");
        $end_date          = $this->input->post("end");
        $currency          = $this->input->post("currency");
        $revenues          = $this->reports_model->outstanding_revenue_bars($start_date, $end_date, $currency);
        $this->output->set_content_type('application/json')->set_output( json_encode($revenues));
    }

    public function getTotalProfit(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $start_date        = $this->input->post("start");
        $end_date          = $this->input->post("end");
        $currency          = $this->input->post("currency");
        $income            = $this->reports_model->getIncome($start_date, $end_date, $currency);
        $expenses          = $this->reports_model->getExpenses($start_date, $end_date, $currency);
        $dates_obj         = getDates($start_date, $end_date);
        $status_list       = $this->settings_model->getInvoiceStatus();
        $values            = array();
        $dates             = $dates_obj->dates;
        $series            = array();
        $total             = 0;

        $series = array($income,$expenses);
        foreach ($series as $key => $serie) {
            $data = array();
            foreach ($dates as $date) {
                $subtotal = 0;
                foreach ($serie as $item) {
                    if( strtotime($item->date) >= strtotime($date->start) && strtotime($item->date) <= strtotime($date->end) ){
                        $subtotal += floatval($item->amount);
                    }
                }
                $data[] = $subtotal;
            }
            $series[$key] = $data;
        }

        $details = array();
        $serie = array(
            "label"           => lang('profit'),
            "data"            => array(),
            "borderColor"     => '#41af67',
            "backgroundColor" => 'rgba(77, 189, 116,0.2)',
            "fill" => "origin",
        );
        $max = 0;
        $min = 0;
        foreach ($dates as $key => $date) {
            $serie['data'][$key] = floatval($series[0][$key])-floatval($series[1][$key]);
            $total += floatval($series[0][$key])-floatval($series[1][$key]);
            $details[$key] = array(
                "value" => floatval($series[0][$key])-floatval($series[1][$key]),
                "income" => floatval($series[0][$key]),
                "expenses" => floatval($series[1][$key])
            );

            $max = max(floatval($series[0][$key])-floatval($series[1][$key]), $max);
            $min = min(floatval($series[0][$key])-floatval($series[1][$key]), $min);
        }

        $result['dates']   = $dates_obj;
        $result['values']  = array($serie);
        $result['values_details']  = $details;
        $result['total']  = $total;
        $result['max']  = $max;
        $result['min']  = $min;


        $this->output->set_content_type('application/json')->set_output( json_encode($result));
    }

    public function accounts_aging(){
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('accounts_aging');
        $data['page_title']       = lang('accounts_aging');
        $data['page_subheading']  = lang('accounts_aging_subheading');
        $data['currencies']       = $this->reports_model->getUsedCurrencies();

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'reports/accounts_aging' , $data);
        $this->load->view ( 'templates/footer' , $meta );
    }

    public function getAccountsAging(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $date                   = $this->input->post("date");
        $currency               = $this->input->post("currency");
        $biller_id              = $this->input->post("biller_id");
        $aging_accounts         = $this->reports_model->getAccountsAging($date, $currency, $biller_id);
        $data['date']           = $date;
        $data['aging_accounts'] = $aging_accounts;
        $data['currency']       = CURRENCY_FORMAT==1?$currency:$this->settings_model->getFormattedCurrencies($currency)->symbol_native;
        $data['page_title']     = lang("accounts_aging")." <small>(".lang("as_of")." ".date_MYSQL_PHP($date).")</small>";
        $Page_content           = $this->load->view ( 'reports/accounts_aging_view', $data , true );

        // PRINT TEMPLATE
        $data_print_page['show_btn_config']   = false;
        $data_print_page['is_preview']        = true;
        $data_print_page['show_center_title'] = true;
        $data_print_page['enable_header']     = false;
        $data_print_page['enable_footer']     = false;
        $data_print_page['enable_signature']  = false;
        $data_print_page['page_title']        = $data['page_title'];
        $data_print_page['meta_title']        = $data['page_title'];
        $data_print_page['Page_content']      = $Page_content;
        $this->load->view ( 'templates/printing_template' , $data_print_page );
    }

    public function revenue_by_customer(){
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('revenue_by_customer');
        $data['page_title']       = lang('revenue_by_customer');
        $data['page_subheading']  = lang('revenue_cust_subheading');
        $data['ajax_data_url']    = site_url('/reports/getRevenueCustomers');
        $data['print_view']       = "revenue_by_customer";
        $data['currencies']       = $this->reports_model->getUsedCurrencies();

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'reports/revenue' , $data);
        $this->load->view ( 'templates/footer' , $meta );
    }

    public function getRevenueCustomers(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $start_date             = $this->input->post("start");
        $end_date               = $this->input->post("end");
        $currency               = $this->input->post("currency");
        $data['start_date']     = $start_date;
        $data['end_date']       = $end_date;
        $biller_id              = $this->input->post("biller_id");
        $data['revenues']       = $this->reports_model->getRevenueCustomers($start_date, $end_date, $currency, $biller_id);
        $data['currency']       = CURRENCY_FORMAT==1?$currency:$this->settings_model->getFormattedCurrencies($currency)->symbol_native;
        $data['page_title']     = lang("revenue_by_customer")." <small>(".lang("from")." ".date_MYSQL_PHP($start_date)." ".lang("to")." ".date_MYSQL_PHP($end_date).")</small>";
        $Page_content           = $this->load->view ( 'reports/revenue_by_customer', $data , true );

        // PRINT TEMPLATE
        $data_print_page['show_btn_config']   = false;
        $data_print_page['is_preview']        = true;
        $data_print_page['show_center_title'] = true;
        $data_print_page['enable_header']     = false;
        $data_print_page['enable_footer']     = false;
        $data_print_page['enable_signature']  = false;
        $data_print_page['page_title']        = $data['page_title'];
        $data_print_page['meta_title']        = $data['page_title'];
        $data_print_page['Page_content']      = $Page_content;
        $this->load->view ( 'templates/printing_template' , $data_print_page );
    }

    public function invoice_details(){
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('invoice_details');
        $data['page_title']       = lang('invoice_details');
        $data['page_subheading']  = lang('invoice_det_subheading');
        $data['ajax_data_url']    = site_url('/reports/getInvoiceDetails');
        $data['print_view']       = "invoice_details";
        $data['currencies']       = $this->reports_model->getUsedCurrencies();

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'reports/invoices' , $data);
        $this->load->view ( 'templates/footer' , $meta );
    }


    public function purchase_order_detail(){
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('purchase_detail');
        $data['page_title']       = lang('purchase_detail');
        $data['page_subheading']  = lang('invoice_det_subheading');
        $data['ajax_data_url']    = site_url('/reports/getPurchaseDetails');
        $data['print_view']       = "purchase_detail";
        $data['currencies']       = $this->reports_model->getUsedCurrencies();
        $data['purchase_status'] = $this->settings_model->getStatus();

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'reports/purchaseOrder' , $data);
        $this->load->view ( 'templates/footer' , $meta );
    }


    public function getPurchaseDetails(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $start_date             = $this->input->post("start");
        $end_date               = $this->input->post("end");
        $currency               = $this->input->post("currency");
        $supplier_id            = $this->input->post("supplier_id");
        $status                 = $this->input->post("status");
        $delivery_date          = $this->input->post("delivery_date");
        $date=date_create($delivery_date);
        $dvl_date = date_format($date,"Y-m-d");
        if(empty($delivery_date)){
            $dvl_date = FALSE;
        }
        $purchases               = $this->reports_model->getPurchaseDetails($start_date, $end_date, $currency, $supplier_id , $status ,$dvl_date);
        $total_invoiced = $total_due = 0;
        foreach ($purchases as $purchase) {
            $total_invoiced += $purchase->total;
            $total_due += $purchase->total_due;
        }
        $data['start_date']     = $start_date;
        $data['end_date']       = $end_date;
        $data['total_invoiced'] = $total_invoiced;
        $data['total_due']      = $total_due;
        $data['purchases']       = $purchases;
        $data['currency']       = CURRENCY_FORMAT==1?$currency:$this->settings_model->getFormattedCurrencies($currency)->symbol_native;
        $data['page_title']     = lang("purchase_detail")." <small>(".lang("from")." ".date_MYSQL_PHP($start_date)." ".lang("to")." ".date_MYSQL_PHP($end_date).")</small>";
        $Page_content           = $this->load->view ( 'reports/purchase_detail', $data , true );

        // PRINT TEMPLATE
        $data_print_page['show_btn_config']   = false;
        $data_print_page['is_preview']        = true;
        $data_print_page['show_center_title'] = true;
        $data_print_page['enable_header']     = false;
        $data_print_page['enable_footer']     = false;
        $data_print_page['enable_signature']  = false;
        $data_print_page['page_title']        = $data['page_title'];
        $data_print_page['meta_title']        = $data['page_title'];
        $data_print_page['Page_content']      = $Page_content;
        $this->load->view ( 'templates/printing_template' , $data_print_page );
    }

    public function getInvoiceDetails(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $start_date             = $this->input->post("start");
        $end_date               = $this->input->post("end");
        $currency               = $this->input->post("currency");
        $biller_id              = $this->input->post("biller_id");
        $invoices               = $this->reports_model->getInvoiceDetails($start_date, $end_date, $currency, $biller_id);
        $total_invoiced = $total_due = 0;
        foreach ($invoices as $invoice) {
            $total_invoiced += $invoice->total;
            $total_due += $invoice->total_due;
        }
        $data['start_date']     = $start_date;
        $data['end_date']       = $end_date;
        $data['total_invoiced'] = $total_invoiced;
        $data['total_due']      = $total_due;
        $data['invoices']       = $invoices;
        $data['currency']       = CURRENCY_FORMAT==1?$currency:$this->settings_model->getFormattedCurrencies($currency)->symbol_native;
        $data['page_title']     = lang("invoice_details")." <small>(".lang("from")." ".date_MYSQL_PHP($start_date)." ".lang("to")." ".date_MYSQL_PHP($end_date).")</small>";
        $Page_content           = $this->load->view ( 'reports/invoice_details', $data , true );

        // PRINT TEMPLATE
        $data_print_page['show_btn_config']   = false;
        $data_print_page['is_preview']        = true;
        $data_print_page['show_center_title'] = true;
        $data_print_page['enable_header']     = false;
        $data_print_page['enable_footer']     = false;
        $data_print_page['enable_signature']  = false;
        $data_print_page['page_title']        = $data['page_title'];
        $data_print_page['meta_title']        = $data['page_title'];
        $data_print_page['Page_content']      = $Page_content;
        $this->load->view ( 'templates/printing_template' , $data_print_page );
    }

    public function cost_per_supplier(){
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('cost_per_supplier');
        $data['page_title']       = lang('cost_per_supplier');
        $data['page_subheading']  = lang('cost_per_supplier_subheading');
        $data['ajax_data_url']    = site_url('/reports/getCostSuppliers');
        $data['filter_supplier']  = true;
        $data['print_view']       = "cost_per_supplier";
        $data['currencies']       = $this->reports_model->getUsedCurrencies();

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'reports/revenue' , $data);
        $this->load->view ( 'templates/footer' , $meta );
    }

    public function getCostSuppliers(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $start_date             = $this->input->post("start");
        $end_date               = $this->input->post("end");
        $currency               = $this->input->post("currency");
        $data['start_date']     = $start_date;
        $data['end_date']       = $end_date;
        $supplier_id              = $this->input->post("supplier_id");
        $data['revenues']       = $this->reports_model->getCostSuppliers($start_date, $end_date, $currency, $supplier_id);
        $data['currency']       = CURRENCY_FORMAT==1?$currency:$this->settings_model->getFormattedCurrencies($currency)->symbol_native;
        $data['page_title']     = lang("cost_per_supplier")." <small>(".lang("from")." ".date_MYSQL_PHP($start_date)." ".lang("to")." ".date_MYSQL_PHP($end_date).")</small>";
        $Page_content           = $this->load->view ( 'reports/cost_per_supplier', $data , true );

        // PRINT TEMPLATE
        $data_print_page['show_btn_config']   = false;
        $data_print_page['is_preview']        = true;
        $data_print_page['show_center_title'] = true;
        $data_print_page['enable_header']     = false;
        $data_print_page['enable_footer']     = false;
        $data_print_page['enable_signature']  = false;
        $data_print_page['page_title']        = $data['page_title'];
        $data_print_page['meta_title']        = $data['page_title'];
        $data_print_page['Page_content']      = $Page_content;
        $this->load->view ( 'templates/printing_template' , $data_print_page );
    }


    public function tax_summary(){
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('tax_summary');
        $data['page_title']       = lang('tax_summary');
        $data['page_subheading']  = lang('tax_summary_subheading');
        $data['ajax_data_url']    = site_url('/reports/getTaxSummary');
        $data['print_view']       = "tax_summary";
        $data['currencies']       = $this->reports_model->getUsedCurrencies();

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'reports/revenue' , $data);
        $this->load->view ( 'templates/footer' , $meta );
    }

    public function getTaxSummary(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $start_date             = $this->input->post("start");
        $end_date               = $this->input->post("end");
        $currency               = $this->input->post("currency");
        $data['start_date']     = $start_date;
        $data['end_date']       = $end_date;
        $biller_id              = $this->input->post("biller_id");
        $data['taxes']          = $this->reports_model->getTaxSummary($start_date, $end_date, $currency, $biller_id);
        $data['currency']       = CURRENCY_FORMAT==1?$currency:$this->settings_model->getFormattedCurrencies($currency)->symbol_native;
        $data['page_title']     = lang("tax_summary")." <small>(".lang("from")." ".date_MYSQL_PHP($start_date)." ".lang("to")." ".date_MYSQL_PHP($end_date).")</small>";
        $Page_content           = $this->load->view ( 'reports/tax_summary', $data , true );

        // PRINT TEMPLATE
        $data_print_page['show_btn_config']   = false;
        $data_print_page['is_preview']        = true;
        $data_print_page['show_center_title'] = true;
        $data_print_page['enable_header']     = false;
        $data_print_page['enable_footer']     = false;
        $data_print_page['enable_signature']  = false;
        $data_print_page['page_title']        = $data['page_title'];
        $data_print_page['meta_title']        = $data['page_title'];
        $data_print_page['Page_content']      = $Page_content;
        $this->load->view ( 'templates/printing_template' , $data_print_page );
    }

    public function print_report($view = false, $start_date = false, $end_date = false, $currency = false, $isPDF = false)
    {
        if( $this->input->get("view") ){     $view       = $this->input->get("view"); }
        if( $this->input->get("start") ){    $start_date = $this->input->get("start"); }
        if( $this->input->get("end") ){      $end_date   = $this->input->get("end"); }
        if( $this->input->get("currency") ){ $currency   = $this->input->get("currency"); }
        if( !$view || !$start_date || !$end_date || !$currency ){
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect('/', 'refresh');
        }
        $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

        $data['start_date']     = $start_date;
        $data['end_date']       = $end_date;
        if( $this->input->get('biller_id')){
            $biller_id = $this->input->get('biller_id');
        }else{
            $biller_id = false;
        }
        if( $this->input->get('supplier_id')){
            $supplier_id = $this->input->get('supplier_id');
        }else{
            $supplier_id = false;
        }
        $data['currency']       = CURRENCY_FORMAT==1?$currency:$this->settings_model->getFormattedCurrencies($currency)->symbol_native;

        if( $view == 'tax_summary' ){
            $data['page_title']     = lang("tax_summary")." <small>(".lang("from")." ".date_MYSQL_PHP($start_date)." ".lang("to")." ".date_MYSQL_PHP($end_date).")</small>";
            $data['taxes']          = $this->reports_model->getTaxSummary($start_date, $end_date, $currency, $biller_id);
            $Page_content           = $this->load->view ( 'reports/tax_summary', $data , true );
        }
        elseif( $view == 'invoice_details' ){
            $invoices               = $this->reports_model->getInvoiceDetails($start_date, $end_date, $currency, $biller_id, false);
            $total_invoiced = $total_due = 0;
            foreach ($invoices as $invoice) {
                $total_invoiced += $invoice->total;
                $total_due += $invoice->total_due;
            }
            $data['total_invoiced'] = $total_invoiced;
            $data['total_due']      = $total_due;
            $data['invoices']       = $invoices;
            $data['page_title']     = lang("invoice_details")." <small>(".lang("from")." ".date_MYSQL_PHP($start_date)." ".lang("to")." ".date_MYSQL_PHP($end_date).")</small>";
            $Page_content           = $this->load->view ( 'reports/invoice_details', $data , true );
        }
        elseif( $view == 'revenue_by_customer' ){
            $data['revenues']       = $this->reports_model->getRevenueCustomers($start_date, $end_date, $currency, $biller_id);
            $data['page_title']     = lang("revenue_by_customer")." <small>(".lang("from")." ".date_MYSQL_PHP($start_date)." ".lang("to")." ".date_MYSQL_PHP($end_date).")</small>";
            $Page_content           = $this->load->view ( 'reports/revenue_by_customer', $data , true );
        }
        elseif( $view == 'accounts_aging' ){
            $date                   = $start_date;
            $data['date']           = $date;
            $data['aging_accounts'] = $this->reports_model->getAccountsAging($date, $currency, $biller_id);
            $data['page_title']     = lang("accounts_aging")." <small>(".lang("as_of")." ".date_MYSQL_PHP($date).")</small>";
            $Page_content           = $this->load->view ( 'reports/accounts_aging_view', $data , true );
        }
        elseif( $view == 'cost_per_supplier' ){
            $data['revenues']       = $this->reports_model->getCostSuppliers($start_date, $end_date, $currency, $supplier_id);
            $data['page_title']     = lang("cost_per_supplier")." <small>(".lang("from")." ".date_MYSQL_PHP($start_date)." ".lang("to")." ".date_MYSQL_PHP($end_date).")</small>";
            $Page_content           = $this->load->view ( 'reports/cost_per_supplier', $data , true );
        }

        // PRINT TEMPLATE
        $data_print_page['show_center_title'] = true;
        $data_print_page['page_title']        = $data['page_title'];
        $data_print_page['meta_title']        = $data['page_title'];
        $data_print_page['enable_header']     = false;
        $data_print_page['enable_footer']     = false;
        $data_print_page['enable_signature']  = false;
        if( !$isPDF ){
            $data_print_page['default_auto_print']= true;
        }
        $data_print_page['Page_content']      = $Page_content;
        if( $isPDF ){
            $data_print_page['isPDF']         = true;
            return array(
                "filename" => $data['page_title'],
                "html"     => $this->load->view ( 'templates/printing_template' , $data_print_page, true )
            );
        }
        $this->load->view ( 'templates/printing_template' , $data_print_page );
    }

    public function pdf($view = false, $start_date = false, $end_date = false, $currency = false )
    {
        $view =  $this->print_report($view, $start_date, $end_date, $currency, true);
        $html = $view["html"];
        $filename = $view["filename"];

        $html = str_replace("row", "row-cols", $html);
        $html = str_replace("col-xs-", "col-", $html);
        $html = str_replace("<hr>", "<div class=\"hr\"></div>", $html);
        $this->load->helper(array('dompdf', 'file'));
        return pdf_create($html, $filename, true);
    }


}
