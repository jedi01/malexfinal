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


class Items extends MY_Controller {
    /**
     * Items constructor.
     */
    public function __construct ()
    {
        parent::__construct ();
        // Load Items Model
        $this->load->model ( 'items_model' );
        // Load Form Validation Library
        $this->load->library ( 'form_validation' );
        // Load Ion Auth Library
        $this->load->library ( 'ion_auth' );

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
        $meta['page_title']       = lang('items');
        $data['page_title']       = lang('items');
        $data['page_subheading']  = lang('items_subheading');

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'items/items' , $data );
        $this->load->view ( 'templates/footer' , $meta );
    }

    public function getData(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->load->library('datatables');
        $this->datatables
        ->setsColumns("checkbox,id,name,description,category,unit,prices,tax,discount,custom_field1,custom_field2,custom_field3,custom_field4,discount_type,tax_type,vat_rate")
        ->select("items.id as checkbox,items.id,items.name,description,GROUP_CONCAT(CONCAT(items_prices.price, '%', items_prices.currency) SEPARATOR ',') as prices,tax,tax_type,discount,discount_type,items_categories.name as category,unit,custom_field1,custom_field2,custom_field3,custom_field4,vat_rate", false)
        ->join("items_categories", "items_categories.id=items.category", "left")
        ->join("items_prices", "items_prices.item_id=items.id", "left")
        ->group_by("items.id")
        ->from("items");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }

    function validate_items($str)
    {
        return intval($str) > 0;
    }



    public function create()
    {
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->form_validation->set_message('validate_items', lang("no_item_prices"));
        $this->form_validation->set_rules('item[name]',          "lang:name",          'required|xss_clean');
        $this->form_validation->set_rules('item[description]',   "lang:description",   'xss_clean');
        $this->form_validation->set_rules('item[price]',         "lang:price",         'xss_clean');
        $this->form_validation->set_rules('item[tax]',           "lang:tax",           'xss_clean');
        $this->form_validation->set_rules('item[tax_type]',      "lang:tax_type",      'xss_clean');
        $this->form_validation->set_rules('item[discount]',      "lang:discount",      'xss_clean');
        $this->form_validation->set_rules('item[discount_type]', "lang:discount_type", 'xss_clean');
        $this->form_validation->set_rules('items_count',         "lang:prices",        'required|callback_validate_items|xss_clean');
        if( $this->input->post("prices") ){
            foreach ($this->input->post("prices") as $key => $value) {
                $this->form_validation->set_rules('prices['.$key.'][currency]', "lang:currency", 'required|xss_clean');
                $this->form_validation->set_rules('prices['.$key.'][price]', "lang:price", 'required|numeric|xss_clean');
            }
        }

        if ($this->form_validation->run() == true)
        {
            $data_item = $this->input->post("item");
            $prices = $this->input->post("prices");
            if( trim($data_item['category']) == "" ){
                $data_item['category'] = NULL;
            }
        }
        if ( $this->form_validation->run() == true && $this->items_model->add($data_item, $prices))
        {
            $data = array(
                "status" => "success",
                "message" => lang("item_add_success")
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array(
                    "status"  => "error",
                    "message" => (validation_errors() ? validation_errors() : $this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array()
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                $data['page_title']       = lang('create_item');
                $data['page_subheading']  = lang('create_item_subheading');
                $data['categories']       = $this->items_model->getAllcategories();
                $data['currencies']       = $this->settings_model->getFormattedCurrencies();
                $data['tax_rates'] = $this->settings_model->getAllTaxRates();

                $this->load->view ( 'items/items_create' , $data );
            }
        }
    }

    public function edit()
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
        if ( !$this->input->get('id') )
        {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $id = $this->input->get('id');
        $item = $this->items_model->getByID($id);
        $this->form_validation->set_message('validate_items', lang("no_item_prices"));
        $this->form_validation->set_rules('item[name]',          "lang:name",          'required|xss_clean');
        $this->form_validation->set_rules('item[description]',   "lang:description",   'xss_clean');
        $this->form_validation->set_rules('item[price]',         "lang:price",         'xss_clean');
        $this->form_validation->set_rules('item[tax]',           "lang:tax",           'xss_clean');
        $this->form_validation->set_rules('item[tax_type]',      "lang:tax_type",      'xss_clean');
        $this->form_validation->set_rules('item[discount]',      "lang:discount",      'xss_clean');
        $this->form_validation->set_rules('item[discount_type]', "lang:discount_type", 'xss_clean');
        $this->form_validation->set_rules('items_count',         "lang:prices",        'required|callback_validate_items|xss_clean');
        if( $this->input->post("prices") ){
            foreach ($this->input->post("prices") as $key => $value) {
                $this->form_validation->set_rules('prices['.$key.'][currency]', "lang:currency", 'required|xss_clean');
                $this->form_validation->set_rules('prices['.$key.'][price]', "lang:price", 'required|numeric|xss_clean');
            }
        }

        if ($this->form_validation->run() == true)
        {
            $data_item = $this->input->post("item");
            $prices = $this->input->post("prices");
            $id = $this->input->post('id');
            if( trim($data_item['category']) == "" ){
                $data_item['category'] = NULL;
            }
        }
        if ( $this->form_validation->run() == true && $this->items_model->update($id, $data_item, $prices))
        {
            $data = array(
                "status" => "success",
                "message" => lang("item_edit_success")
            );
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
                $data['page_title']      = lang('edit_item');
                $data['page_subheading'] = lang('edit_item_subheading');
                $data['item']            = $item;
                $data['categories']       = $this->items_model->getAllcategories();
                $data['currencies']       = $this->settings_model->getFormattedCurrencies();
                $data['item_prices']      = $this->items_model->getItemPrices($item->id);
                $data['tax_rates'] = $this->settings_model->getAllTaxRates();

                $this->load->view ( 'items/items_edit' , $data );
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
        if ( $this->items_model->delete($id) )
        {
            $result = array("status"=>"success", "message"=>lang("item_deleted"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("cant_delete_item"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function view()
    {
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( !$this->input->get('id') )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/items", 'refresh');
        }
        $id                      = $this->input->get('id');
        $data['page_title']      = lang('details_item');
        $data['item']            = $this->items_model->getByID($id);
        $data['item_prices']     = $this->items_model->getItemPrices($id);
        $data['category']        = $this->items_model->get_category($data['item']->category);

        $this->load->view ( 'items/items_details' , $data );
    }

    public function suggestions(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $term = $this->input->get('term')?$this->input->get('term'):"";
        $currency = $this->input->get('currency')?$this->input->get('currency'):CURRENCY_PREFIX;
        $items = $this->items_model->suggestions($term, $currency);
        $this->output->set_output( json_encode($items));
    }


    // Categories
    public function categories ()
    {
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('items_categories');
        $data['page_title']       = lang('items_categories');
        $data['page_subheading']  = lang('items_subheading');

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'items/categories' , $data );
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
        ->setsColumns("id,name,is_default")
        ->select("id,name,is_default", true)
        ->from("items_categories");
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
        $this->form_validation->set_rules('category[name]',       "lang:name",    'required|xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data = $this->input->post("category");
        }
        if ( $this->form_validation->run() == true && $this->items_model->create_category($data))
        {
            $data = array("status" => "success","message" => lang("category_added"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array("status"=>"error","message"=>(validation_errors()?validation_errors():$this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array());
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                $data['page_title'] = lang('category_create');
                $this->load->view ( 'items/categories_create' , $data );
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
        $category = $this->items_model->get_category($id);

        $this->form_validation->set_rules('category[name]',       "lang:name",    'required|xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data = $this->input->post("category");
            if( !isset($data['is_default']) ){
                $data['is_default'] = 0;
            }
        }
        if ( $this->form_validation->run() == true && $this->items_model->update_category($id, $data))
        {
            $data = array("status" => "success","message" => lang("category_updated"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array("status"=>"error","message"=>(validation_errors()?validation_errors():$this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array());
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                $data['page_title'] = lang('category_update');
                $data['category']   = $category;
                $this->load->view ( 'items/categories_update' , $data );
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
        if($this->input->get('id')) { $id = $this->input->get('id'); }
        if( !$id || !$this->input->is_ajax_request() ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        if ( $this->items_model->delete_category($id) )
        {
            $result = array("status"=>"success", "message"=>lang("category_deleted"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("access_denied"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key   = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    public function _valid_csrf_nonce()
    {
        return TRUE;
    }

    public function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
    {
        $this->viewdata = (empty($data)) ? $this->data: $data;
        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);
        if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
    }


}

/* End of file Items.php */
/* Location: ./application/controllers/Items.php */
