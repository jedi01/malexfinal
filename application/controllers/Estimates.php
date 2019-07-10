<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Name:         Smart Estimate System
 * Version :     1.0
 * Author:       Zitouni Bessem
 * Requirements: PHP5 or above
 *
 */

class Estimates extends MY_Controller
{
    /**
     * Estimates constructor.
     */
    public function __construct ()
    {
        parent::__construct ();
        // Load Estimates Model
        $this->load->model ( 'estimates_model' );
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
        if ( !$this->ion_auth->logged_in () ) {
            if ($this->input->is_ajax_request()) {
                $next_link = urlencode("/estimates");
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
        $meta['page_title']       = lang('estimates');
        $data['page_title']       = lang('estimates');
        $data['page_subheading']  = lang('estimates_subheading');

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'estimates/estimates' , $data );
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
        if( defined("BILLER_ID") ){
            $this->datatables->where("estimates.bill_to_id", BILLER_ID);
            $this->datatables->where("estimates.status IN", "('sent', 'accepted', 'invoiced', 'canceled')", false);
        }
        if( $this->input->post('biller_id') ){
            $this->datatables->where("estimates.bill_to_id", $this->input->post('biller_id'));
        }
        if( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() ){
            $this->datatables->where("estimates.user_id", USER_ID);
        }
        $this->datatables
        ->setsColumns("id,reference,title,date,date_due,fullname,status,total,total_tax,total_discount,shipping,description,currency")
        ->select("estimates.id as id, estimates.reference as reference,title, estimates.date as date, estimates.date_due as date_due, IF(biller.company='',biller.fullname, biller.company) as fullname, status, estimates.total as total, bill_to_id, total_tax, total_discount, shipping, estimates.description as description,currency", false)
        ->join("biller", "estimates.bill_to_id=biller.id")
        ->from("estimates");
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
            redirect("/estimates", 'refresh');
        }
        $this->form_validation->set_message('validate_items', lang("no_estimate_items"));
        $this->form_validation->set_rules('estimate[title]',      "lang:title",         'required|max_length[25]|xss_clean');
        $this->form_validation->set_rules('estimate[description]',"lang:description",   'xss_clean');
        $this->form_validation->set_rules('estimate[reference]', "lang:reference",     'required|is_unique[estimates.reference]|xss_clean');
        $this->form_validation->set_rules('estimate[date]',      "lang:date",          'required|xss_clean');
        $this->form_validation->set_rules('estimate[date_due]',  "lang:date_due",      'xss_clean');
        $this->form_validation->set_rules('estimate[bill_to_id]',"lang:customer",      'required|xss_clean');
        $this->form_validation->set_rules('items_count',        "lang:estimate_items", 'required|callback_validate_items|xss_clean');
        if ($this->form_validation->run() == true)
        {
            $data             = $this->input->post("estimate");
            $data['date']     = date_JS_MYSQL($data['date']);
            if( isset($data['date_due']) && $data['date_due'] != "" ){
                $data['date_due'] = date_JS_MYSQL($data['date_due']);
            }else{
                $data['date_due'] = NULL;
            }
            if( $data['count'] == "0" ){
                $next_reference = $this->estimates_model->next_reference();
                $data['reference']   = $next_reference["reference"];
                $data['count']       = $next_reference["next_count"];
            }
            $data['user_id']  = USER_ID;
            $items            = $this->input->post("estimate_item");
            $taxes            = $this->input->post("estimate_taxes");

            $data['status']   = "draft";
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
        if ( $this->form_validation->run() == true && $estimate_id=$this->estimates_model->create($data, $items, $taxes))
        {
            // update settings next count
            $this->settings_model->updateSettingsItem("estimate_next", $data['count']+1);
            $this->sis_logger->write('estimates', 'create', $estimate_id, "estimate is created");
            $this->session->set_flashdata('success_message', lang("estimate_add_success"));
            redirect("/estimates/open/".$estimate_id, 'refresh');
        }
        else
        {
            $next_reference           = $this->estimates_model->next_reference();
            $data['next_reference']   = $next_reference["reference"];
            $data['next_count']       = $next_reference["next_count"];
            $data['currencies']       = $this->settings_model->getFormattedCurrencies();
            $data['tax_rates']       = $this->settings_model->getAllTaxRates();
            $data['message']          = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            $data['error_fields']     = $this->form_validation->error_array();
            $meta['page_title']       = lang('create_estimate');
            $data['page_title']       = lang('create_estimate');
            $data['page_subheading']  = lang('create_estimate_subheading');

            $this->load->view ( 'templates/head' , $meta );
            $this->load->view ( 'templates/header' );
            $this->load->view ( 'estimates/estimates_create' , $data );
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
            redirect("/estimates", 'refresh');
        }
        if ( !$this->input->get('id') )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/estimates", 'refresh');
        }
        $id = $this->input->get('id');
        $estimate = $this->estimates_model->getEstimate($id);
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $estimate->user_id != USER_ID )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/estimates", 'refresh');
        }

        $this->form_validation->set_message('validate_items', lang("no_estimate_items"));
        $this->form_validation->set_rules('estimate[title]',       "lang:title",         'required|max_length[25]|xss_clean');
        $this->form_validation->set_rules('estimate[description]', "lang:description",   'xss_clean');
        $this->form_validation->set_rules('estimate[reference]',  "lang:reference",     'required|xss_clean');
        $this->form_validation->set_rules('estimate[date]',       "lang:date",          'required|xss_clean');
        $this->form_validation->set_rules('estimate[date_due]',   "lang:date_due",      'xss_clean');
        $this->form_validation->set_rules('estimate[bill_to_id]', "lang:customer",      'required|xss_clean');
        $this->form_validation->set_rules('items_count',         "lang:estimate_items", 'required|callback_validate_items|xss_clean');

        if( $this->input->post('estimate[reference]') ){
            if( $this->input->post('estimate[reference]') != $estimate->reference ){
                $this->form_validation->set_rules('estimate[reference]', "lang:reference", 'is_unique[estimates.reference]');
            }
        }

        if ($this->form_validation->run() == true)
        {
            $data             = $this->input->post("estimate");
            $data['date']     = date_JS_MYSQL($data['date']);
            if( isset($data['date_due']) && $data['date_due'] != "" ){
                $data['date_due'] = date_JS_MYSQL($data['date_due']);
            }else{
                $data['date_due'] = NULL;
            }
            if( $data['count'] == "0" ){
                $next_reference = $this->estimates_model->next_reference($estimate->count);
                $data['reference']   = $next_reference["reference"];
                $data['count']       = $next_reference["next_count"];
            }
            $items            = $this->input->post("estimate_item");
            $taxes            = $this->input->post("estimate_taxes");
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
        if ( $this->form_validation->run() == true && $this->estimates_model->update($id, $data, $items, $taxes))
        {
            $this->sis_logger->write('estimates', 'update', $id, "estimate is updated");
            $this->session->set_flashdata('success_message', lang("estimate_edit_success"));
            redirect("/estimates/open/".$id, 'refresh');
        }
        else
        {
            $estimate_items           = $this->estimates_model->getEstimateItems($id);
            $estimate_taxes           = $this->estimates_model->getEstimateTaxes($id);
            $estimate_biller          = $this->biller_model->getByID($estimate->bill_to_id);
            $data['estimate']         = $estimate;
            $data['estimate_items']   = $estimate_items;
            $data['estimate_taxes']   = $estimate_taxes;
            $data['estimate_biller']  = $estimate_biller;
            $data['currencies']      = $this->settings_model->getFormattedCurrencies();
            $data['tax_rates']       = $this->settings_model->getAllTaxRates();
            $data['message']         = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            $data['error_fields']     = $this->form_validation->error_array();
            $meta['page_title']      = lang('edit_estimate');
            $data['page_title']      = lang('edit_estimate');
            $data['page_subheading'] = lang('edit_estimate_subheading');

            $this->load->view ( 'templates/head' , $meta );
            $this->load->view ( 'templates/header' );
            $this->load->view ( 'estimates/estimates_edit' , $data );
            $this->load->view ( 'templates/footer' , $meta );
        }
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
        if ( $this->estimates_model->delete($id) )
        {
            $this->sis_logger->write('estimates', 'delete', $id, "estimate is deleted");
            $result = array("status"=>"success", "message"=>lang("estimate_deleted"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("cant_delete_estimate"));
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
        $estimate = $this->estimates_model->getEstimate($id);

        $this->form_validation->set_rules('status', "lang:status", 'required|xss_clean');

        if ($this->form_validation->run() == true)
        {
            $status = $this->input->post("status");
            $id     = $this->input->post('id');
        }
        if ( $this->form_validation->run() == true && $this->estimates_model->setStatus($id, $status))
        {
            $this->sis_logger->write('estimates', 'update', $id, "estimate status is updated from '".$estimate->status."' to '".$status."'");
            $data = array("status" => "success", "message" => lang("estimate_edit_success"));
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
                $data['estimate']         = $estimate;
                $data['page_title']      = lang('set_status');
                $data['page_subheading'] = lang('set_status_subheading');
                $this->load->view ( 'estimates/estimates_status' , $data );
            }
        }
    }

    public function open($id = false)
    {
        if( $this->input->get('id') ){ $id = $this->input->get('id');}
        if ( !$id || !($estimate = $this->estimates_model->getEstimate($id)) )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/estimates", 'refresh');
        }
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $estimate->user_id != USER_ID )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/estimates", 'refresh');
        }

        $estimate_items          = $this->estimates_model->getEstimateItems($id);
        $estimate_taxes          = $this->estimates_model->getEstimateTaxes($id);
        $estimate_biller         = $this->biller_model->getByID($estimate->bill_to_id);
        $data['estimate']        = $estimate;
        $data['estimate_items']  = $estimate_items;
        $data['estimate_taxes']  = $estimate_taxes;
        $data['estimate_biller'] = $estimate_biller;
        if( $estimate->status == "invoiced" ){
            $data['invoice_id']      = $this->estimates_model->getInvoiceID($id);
        }
        $data['currencies']      = $this->settings_model->getFormattedCurrencies();
        $data['tax_rates']       = $this->settings_model->getAllTaxRates();
        $estimate->no            = sprintf("%05s", $estimate->count);
        $data['message']         = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
        $meta['page_title']      = lang("estimate_no")." ".$estimate->no;
        $data['page_title']      = $estimate->title;
        $data['page_subheading'] = $estimate->reference;

        /* PREVIEW START */
        $data['estimate_currency']             = CURRENCY_FORMAT==1?$estimate->currency:$this->settings_model->getFormattedCurrencies($estimate->currency)->symbol_native;
        $Page_content = $this->load->view ( 'estimates/estimates_view', $data , true );
        $data_print_page['show_btn_config']   = false;
        $data_print_page['is_preview']        = true;
        $data_print_page['show_center_title'] = true;
        $data_print_page['page_title']        = $estimate->title;
        $data_print_page['meta_title']        = lang("estimate_no")." ".$estimate->no;
        $data_print_page['Page_content']      = $Page_content;
        $preview = $this->load->view ( 'templates/printing_template' , $data_print_page, true );
        /* PREVIEW END */
        $data['preview'] = $preview;

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'estimates/estimates_preview' , $data );
        $this->load->view ( 'templates/footer' , $meta );
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
        $estimate        = $this->estimates_model->getEstimate($id);
        if ( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() && $estimate->user_id != USER_ID ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        if ( $estimate == false )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/estimates", 'refresh');
        }
        $estimate              = objectToArray($estimate);
        $old_reference         = $estimate["reference"];
        $next_reference        = $this->estimates_model->next_reference();
        $estimate['reference'] = $next_reference["reference"];
        $estimate['count']     = $next_reference["next_count"];
        $estimate_items        = $this->estimates_model->getEstimateItems($id);
        $estimate_taxes        = $this->estimates_model->getEstimateTaxes($id);
        unset($estimate['id']);
        foreach ($estimate_items as $key => $item) {
            unset($estimate_items[$key]['id']);
            unset($estimate_items[$key]['estimate_id']);
        }
        foreach ($estimate_taxes as $key => $item) {
            unset($estimate_taxes[$key]['id']);
            unset($estimate_taxes[$key]['estimate_id']);
        }

        if ( $estimate_id = $this->estimates_model->create($estimate, $estimate_items, $estimate_taxes) )
        {
            $this->sis_logger->write('estimates', 'clone', $estimate_id, "estimate is duplicated from estimate #".$old_reference);
            $result = array("status"=>"success", "message"=>lang("estimate_duplicate_success"));
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
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect('/', 'refresh');
        }
        $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

        $Page_content = array();
        foreach ($id as $estimate_id) {
            $estimate                  = $this->estimates_model->getEstimate($estimate_id);
            if ( defined("BILLER_ID") && BILLER_ID != $estimate->bill_to_id ){
                return show_error(lang("access_denied"));
            }
            $estimate_items            = $this->estimates_model->getEstimateItems($estimate_id);
            $estimate_taxes            = $this->estimates_model->getEstimateTaxes($estimate_id);
            $estimate_biller           = $this->biller_model->getByID($estimate->bill_to_id);
            $data['estimate']          = $estimate;
            $data['estimate_items']    = $estimate_items;
            $data['estimate_taxes']    = $estimate_taxes;
            $data['estimate_biller']   = $estimate_biller;
            $data['estimate_currency'] = CURRENCY_FORMAT==1?$estimate->currency:$this->settings_model->getFormattedCurrencies($estimate->currency)->symbol_native;
            $estimate->no              = sprintf("%05s", $estimate->count);
            $data['page_title']       = $estimate->title;
            $Page_content[] = $this->load->view ( 'estimates/estimates_view' , $data , true );
        }
        if( count($id) == 1 ){
            $page_title = lang("estimate_no")." ".sprintf("%06s", $estimate->no );
        }else{
            $page_title = lang("estimates");
        }

        // PRINT TEMPLATE
        $data_print_page['show_center_title'] = true;
        $data_print_page['page_title'] = $estimate->title;
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
        $estimate                  = arrayToObject($this->input->post("estimate"));
        $estimate->date            = date_JS_MYSQL($estimate->date);
        if( isset($estimate->date_due) && $estimate->date_due != "" ){
            $estimate->date_due        = date_JS_MYSQL($estimate->date_due);
        }
        $estimate_items            = $this->input->post("estimate_item");
        $estimate_taxes            = $this->input->post("estimate_taxes");
        $estimate_biller           = $this->biller_model->getByID($estimate->bill_to_id);
        $data['estimate']          = $estimate;
        $data['estimate_items']    = $estimate_items;
        $data['estimate_taxes']    = $estimate_taxes;
        $data['estimate_biller']   = $estimate_biller;
        $estimate->no              = sprintf("%05s", $estimate->count);
        $data['estimate_currency'] = CURRENCY_FORMAT==1?$estimate->currency:$this->settings_model->getFormattedCurrencies($estimate->currency)->symbol_native;
        $data['page_title']       = $estimate->title;
        $Page_content = $this->load->view ( 'estimates/estimates_view', $data , true );

        // PRINT TEMPLATE
        $data_print_page['show_btn_config'] = false;
        $data_print_page['is_preview'] = true;
        $data_print_page['show_center_title'] = true;
        $data_print_page['page_title'] = $estimate->title;
        $data_print_page['meta_title'] = lang("estimate_no")." ".$estimate->no;
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

        $template = $this->settings_model->getEmailTemplate("send_estimates_to_customer.tpl", LANGUAGE);
        $company  = $this->settings_model->getSettings("COMPANY");
        $estimate = $this->estimates_model->getEstimate($id);
        $biller   = $this->biller_model->getByID($estimate->bill_to_id);

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
                $emails                  = $this->estimates_model->getEstimatesEmails($id);
                $data['id']              = $id;
                $data['emails_list']     = $emails;
                $data['page_title']      = lang('send_email');
                $data['email_type']      = lang('estimate');
                $data['email_subject']   = parse_object_sis($template->subject, $company, false, $biller, false, false, $estimate);
                $data['email_content']   = parse_object_sis($template->content, $company, false, $biller, false, false, $estimate);
                $data['email_cc']        = COMPANY_EMAIL;
                $data['form_action']     = "estimates/email?id=".$id;
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
        $p = $this->input->get('p')?$this->input->get('p'):ESTIMATE_PREFIX;
        $y = $this->input->get('y')?$this->input->get('y'):FALSE;
        $this->output->set_content_type('application/json')->set_output( json_encode($this->estimates_model->next_reference($c, $t, $p, $y)));
    }

    public function activities()
    {
        if ( !$this->ion_auth->is_admin() ||  !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( !$this->input->get('id') )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/estimates", 'refresh');
        }
        $id                      = $this->input->get('id');
        $data['estimate']        = $this->estimates_model->getEstimate($id);
        $data['page_title']      = lang("estimates_activities");
        $data['activities']      = $this->sis_logger->getLogs("estimates", $id);

        $this->load->view ( 'estimates/estimates_activities' , $data );
    }

    public function approve($id = false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        if ( $this->input->get('id') ){$id = $this->input->get('id');}
        if (!$id || !$this->input->is_ajax_request() || !$this->ion_auth->in_group(array("customer", "supplier"))) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $status = "accepted";
        if ( $this->estimates_model->setStatus($id, $status))
        {
            $this->sis_logger->write('estimates', 'update', $id, "estimate status is approved");
            $data = array("status" => "success", "message" => lang("estimate_edit_success"));
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
        if (!$id || !$this->input->is_ajax_request() || !$this->ion_auth->in_group(array("customer", "supplier"))) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $status = "canceled";
        if ( $this->estimates_model->setStatus($id, $status))
        {
            $this->sis_logger->write('estimates', 'update', $id, "estimate status is approved");
            $data = array("status" => "success", "message" => lang("estimate_edit_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }
}
