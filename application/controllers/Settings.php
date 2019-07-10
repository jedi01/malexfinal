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

class Settings extends MY_Controller
{
    /**
     * Settings constructor.
     */
    public function __construct ()
    {
        parent::__construct ();
        // Load Form Validation Library
        $this->load->library ( 'form_validation' );
        // Load Ion Auth Library
        $this->load->library ( 'ion_auth' );
        // Load Encryption Library
        $this->load->library('encryption');

        $this->load->model( 'account_model' );

        $this->load->model( "uom_model" );


        $this->load->model ( "initial_balance_model" );

        // Check user is logged in ?
        $ignored_methods = array("change_language", "jsConstant");
        if ( !$this->ion_auth->logged_in () && !in_array($this->router->fetch_method(), $ignored_methods) ) {
            if ($this->input->is_ajax_request()) {
                $next_link = urlencode("/settings");
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
        if ( !$this->ion_auth->in_group('admin') )
        {
            return show_error('You must be an administrator to view this page.');
        }
        // invoice
        $data['invoice_settings'] = $this->settings_model->getSettings("INVOICE");
        // general
        $data['general']          = $this->settings_model->getSettings("SYSTEM");
        // company
        $data['company']          = $this->settings_model->getSettings("COMPANY");
        // purchase
        $data['purchase_settings'] = $this->settings_model->getSettings("PURCHASE");

        $data['config']           = $this->input->get('config')?$this->input->get('config'):"settings_general";
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('system_setting');
        $data['page_title']       = lang('system_setting');
        $data['page_subheading']  = lang('system_setting_subheading');

        // echo "<pre>";
        // print_r($data);
        // exit();

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'settings/settings' , $data );
        $this->load->view ( 'templates/footer' , $meta );
    }

    function media_upload()
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        $folder = ($this->input->get('folder')?$this->input->get('folder'):"storage");
        $upload_folder = "$folder/";
        if(isset($_FILES['userfile'])){
            $this->load->library('upload');
            $config['upload_path'] = $upload_folder;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '512';
            $config['max_width'] = '800';
            $config['max_height'] = '800';
            $config['overwrite'] = FALSE;
            $this->upload->initialize($config);
            if( ! $this->upload->do_upload()){

                $error = $this->upload->display_errors();
                $error = array('type' => "ERROR", 'msg' => $error);
                $this->output->set_output( json_encode($error) );
                return;
            }
            $photo = $upload_folder.$this->upload->file_name;
            $array = array('type' => "SUCCESS", 'msg' => $photo);
            $this->output->set_output( stripslashes(json_encode($array)) );
            return;
        } else {
            $error = array('type' => "ERROR", 'msg' => 'No file selected to upload!');
            $this->output->set_output( json_encode($error) );
            return;
        }
    }


    function update_settings_general()
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        $this->form_validation->set_message('is_natural_no_zero', lang('no_zero_required'));

        $this->form_validation->set_rules('language',         'lang:language',        'trim|required|xss_clean');
        $this->form_validation->set_rules('date_format',      'lang:date_format',     'trim|required|xss_clean');
        $this->form_validation->set_rules('number_format',    'lang:number_format',   'trim|required|xss_clean');
        $this->form_validation->set_rules('currency_format',  'lang:currency_format', 'trim|required|xss_clean');
        $this->form_validation->set_rules('decimal_place',    'lang:decimal_place',   'trim|required|xss_clean');
        $this->form_validation->set_rules('default_currency', 'lang:currency_code',   'trim|required|max_length[5]|xss_clean');
        $this->form_validation->set_rules('prefix_invoice',   'lang:prefix_invoice',  'trim|required|xss_clean');


        if ($this->form_validation->run() == true)
        {
            $data = array(
                'language'           => $this->input->post('language'),
                'dateformat'         => $this->input->post('date_format'),
                'number_format'      => $this->input->post('number_format'),
                'round_number'       => $this->input->post('round_number'),
                'currency_format'    => $this->input->post('currency_format'),
                'currency_place'     => $this->input->post('currency_place'),
                'decimal_place'      => $this->input->post('decimal_place'),
                'enable_register'    => $this->input->post('enable_register'),
                'default_group'      => $this->input->post('default_group'),
                //'biller_type'        => $this->input->post('biller_type'),
                'default_currency'   => $this->input->post('default_currency'),
                'reference_type'     => $this->input->post('reference_type'),
                'prefix_invoice'     => $this->input->post('prefix_invoice'),
                'estimate_prefix'    => $this->input->post('estimate_prefix'),
                'receipt_prefix'     => $this->input->post('receipt_prefix'),
                'expense_prefix'     => $this->input->post('expense_prefix'),
                'invoice_next'       => $this->input->post('invoice_next'),
                'estimate_next'      => $this->input->post('estimate_next'),
                'receipt_next'       => $this->input->post('receipt_next'),
                'contract_next'      => $this->input->post('contract_next'),
                'expense_next'       => $this->input->post('expense_next'),
                'shipping'           => $this->input->post('shipping'),
                'item_tax'           => $this->input->post('item_tax'),
                'item_discount'      => $this->input->post('item_discount'),
                "default_status"     => $this->input->post('default_status'),
                'default_country'    => $this->input->post('default_country'),
                "show_status"        => $this->input->post('show_status'),
                "show_total_due"     => $this->input->post('show_total_due'),
                "show_payments_page" => $this->input->post('show_payments_page'),
                "customer_cf1"       => $this->input->post('customer_cf1'),
                "customer_cf2"       => $this->input->post('customer_cf2'),
                "customer_cf3"       => $this->input->post('customer_cf3'),
                "customer_cf4"       => $this->input->post('customer_cf4'),
                "supplier_cf1"       => $this->input->post('supplier_cf1'),
                "supplier_cf2"       => $this->input->post('supplier_cf2'),
                "supplier_cf3"       => $this->input->post('supplier_cf3'),
                "supplier_cf4"       => $this->input->post('supplier_cf4'),
                "item_cf1"           => $this->input->post('item_cf1'),
                "item_cf2"           => $this->input->post('item_cf2'),
                "item_cf3"           => $this->input->post('item_cf3'),
                "item_cf4"           => $this->input->post('item_cf4'),
                "invoice_cf1"        => $this->input->post('invoice_cf1'),
                "invoice_cf2"        => $this->input->post('invoice_cf2'),
                "invoice_cf3"        => $this->input->post('invoice_cf3'),
                "invoice_cf4"        => $this->input->post('invoice_cf4'),
                "default_note"       => $this->input->post('default_note'),
                "default_terms"      => $this->input->post('default_terms'),
                "note_terms_on_page" => $this->input->post('note_terms_on_page'),
                "enable_terms"       => $this->input->post('enable_terms'),
                "enable_contracts"   => $this->input->post('enable_contracts'),
                "df_contract_desc"   => $this->input->post('df_contract_desc'),
                "contract_prefix"    => $this->input->post('contract_prefix'),
                "enable_recurring"   => $this->input->post('enable_recurring'),
                "enable_overdue_reminder" => $this->input->post('enable_overdue_reminder'),
                "overdue_first_time" => $this->input->post('overdue_first_time'),
                "overdue_every"      => $this->input->post('overdue_every'),
                "amount_in_words"    => $this->input->post('amount_in_words'),
                "description_inline" => $this->input->post('description_inline'),
                "chat_enable"        => $this->input->post('chat_enable'),
                "chat_support_label" => $this->input->post('chat_support_label'),
                "chat_support_id"    => $this->input->post('chat_support_id'),
                "reminder_enable"    => $this->input->post('reminder_enable'),
                "reminder_subject"   => $this->input->post('reminder_subject'),
                "reminder_content"   => $this->input->post('reminder_content'),
                "user_all_privileges"=> $this->input->post('user_all_privileges'),
                "cus_payment_methods"=> $this->input->post('cus_payment_methods'),
                "tax_conditional"    => $this->input->post('tax_conditional'),
                "default_due_date"   => $this->input->post('default_due_date'),
                "exchange_api_key"   => $this->input->post('exchange_api_key'),
                );
            $data = array(
                'configuration' => json_encode($data)
            );
            if( $this->input->post("reset_all_references") == "1" ){
                $this->load->model('invoices_model');
                $this->load->model('estimates_model');
                $this->load->model('contracts_model');
                $reference_type = $this->input->post('reference_type');
                $prefix_invoice = $this->input->post('prefix_invoice');
                $estimate_prefix = $this->input->post('estimate_prefix');
                $contract_prefix = $this->input->post('contract_prefix');
                $this->invoices_model->reset_all_invoices_references($reference_type, $prefix_invoice);
                $this->estimates_model->reset_all_estimates_references($reference_type, $estimate_prefix);
                $this->contracts_model->reset_all_contracts_references($reference_type, $contract_prefix);
            }
        }

        if ( $this->form_validation->run() == true && $this->settings_model->updateSettings("SYSTEM", $data))
        {
            $this->session->set_flashdata('success_message', lang('settings_general_updated'));
        }else{
            $this->session->set_flashdata('message', validation_errors());
        }
        redirect("/settings?config=settings_general", 'refresh');
    }


    function update_settings_company($id = NULL)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        $this->form_validation->set_rules('name',           "lang:name",           'required|xss_clean');
        $this->form_validation->set_rules('email',          "lang:email_address",  'required|valid_email');
        $this->form_validation->set_rules('address',        "lang:address",        'required|xss_clean');
        $this->form_validation->set_rules('city',           "lang:city",           'required|xss_clean');
        $this->form_validation->set_rules('state',          "lang:state",          'required|xss_clean');
        $this->form_validation->set_rules('postal_code',    "lang:postal_code",    'required|xss_clean');
        $this->form_validation->set_rules('country',        "lang:country",        'required|xss_clean');
        $this->form_validation->set_rules('phone',          "lang:phone",          'required|xss_clean|min_length[9]');
        $this->form_validation->set_rules('logo',           "lang:logo",           'xss_clean');

        $this->form_validation->set_rules('cfl1',           "lang:cfl1",           'xss_clean');
        $this->form_validation->set_rules('cfv1',           "lang:cfv1",           'xss_clean');
        $this->form_validation->set_rules('cfl2',           "lang:cfl2",           'xss_clean');
        $this->form_validation->set_rules('cfv2',           "lang:cfv2",           'xss_clean');
        $this->form_validation->set_rules('cfl3',           "lang:cfl3",           'xss_clean');
        $this->form_validation->set_rules('cfv3',           "lang:cfv3",           'xss_clean');
        $this->form_validation->set_rules('cfl4',           "lang:cfl4",           'xss_clean');
        $this->form_validation->set_rules('cfv4',           "lang:cfv4",           'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data = array(
                'name'        => $this->input->post('name'),
                'address'     => $this->input->post('address'),
                'city'        => $this->input->post('city'),
                'state'       => $this->input->post('state'),
                'postal_code' => $this->input->post('postal_code'),
                'country'     => $this->input->post('country'),
                'phone'       => $this->input->post('phone'),
                'email'       => $this->input->post('email'),
                'logo'        => $this->input->post('logo'),
                'cfl1'        => $this->input->post('cfl1'),
                'cfv1'        => $this->input->post('cfv1'),
                'cfl2'        => $this->input->post('cfl2'),
                'cfv2'        => $this->input->post('cfv2'),
                'cfl3'        => $this->input->post('cfl3'),
                'cfv3'        => $this->input->post('cfv3'),
                'cfl4'        => $this->input->post('cfl4'),
                'cfv4'        => $this->input->post('cfv4'),
                );
            $data = array(
                'configuration' => json_encode($data)
            );
        }

        if ( $this->form_validation->run() == true && $this->settings_model->updateSettings("COMPANY", $data))
        {
            $this->session->set_flashdata('success_message', lang('settings_company_updated'));
        }else{
            $this->session->set_flashdata('message', validation_errors());
        }
        redirect("/settings?config=settings_company");
    }


    function update_settings_email($id = NULL)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }

        $this->form_validation->set_rules('email[protocol]',    "lang:protocol",    'required|xss_clean');
        if( $this->input->post('email[protocol]') && $this->input->post('email[protocol]') == "smtp" ){
            $this->form_validation->set_rules('email[smtp_host]',   "lang:smtp_host",   'required|xss_clean');
            $this->form_validation->set_rules('email[smtp_port]',   "lang:smtp_port",   'required|xss_clean');
            $this->form_validation->set_rules('email[smtp_user]',   "lang:smtp_user",   'required|xss_clean');
            $this->form_validation->set_rules('email[smtp_pass]',   "lang:smtp_pass",   'required|xss_clean');
        }
        $this->form_validation->set_rules('email[mailpath]',    "lang:mailpath",    'xss_clean');
        $this->form_validation->set_rules('email[smtp_crypto]', "lang:smtp_crypto", 'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data = $this->input->post('email');
            $data = array(
                'configuration' => json_encode($data)
            );
        }

        if ( $this->form_validation->run() == true && $this->settings_model->updateSettings("EMAIL", $data))
        {
            $this->session->set_flashdata('success_message', lang('settings_email_updated'));
        }else{
            $this->session->set_flashdata('message', validation_errors());
        }
        redirect("/settings?config=settings_email");
    }


    function update_settings_files($id = NULL)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }

        $this->form_validation->set_rules('files[enable]',             "lang:enable",             'xss_clean');
        $this->form_validation->set_rules('files[user_disc_space]',    "lang:user_disc_space",    'required|xss_clean');
        $this->form_validation->set_rules('files[max_upload_size]',    "lang:max_upload_size",    'required|xss_clean');
        $this->form_validation->set_rules('files[max_simult_uploads]', "lang:max_simult_uploads", 'required|xss_clean');
        $this->form_validation->set_rules('files[white_list]',         "lang:white_list",         'required|xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data = $this->input->post('files');
            $data = array(
                'configuration' => json_encode($data)
            );
        }

        if ( $this->form_validation->run() == true && $this->settings_model->updateSettings("FILES", $data))
        {
            $this->session->set_flashdata('success_message', lang('settings_files_updated'));
        }else{
            $this->session->set_flashdata('message', validation_errors());
        }
        redirect("/settings?config=settings_files");
    }


    function save_payments_online($id = NULL)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        // general
        $this->form_validation->set_rules('po[enable]', "lang:payments_online_enable", 'xss_clean');
        $this->form_validation->set_rules('po[biller_accounts]', "lang:biller_accounts", 'xss_clean');
        // paypal
        $this->form_validation->set_rules('po[paypal][enable]',    "lang:enable",    'xss_clean');
        $this->form_validation->set_rules('po[paypal][username]',  "lang:username",  'xss_clean');
        $this->form_validation->set_rules('po[paypal][password]',  "lang:password",  'xss_clean');
        $this->form_validation->set_rules('po[paypal][signature]', "lang:signature", 'xss_clean');
        $this->form_validation->set_rules('po[paypal][sandbox]',   "lang:sandbox",   'xss_clean');
        // stripe
        $this->form_validation->set_rules('po[stripe][enable]',  "lang:enable",  'xss_clean');
        $this->form_validation->set_rules('po[stripe][api_key]', "lang:api_key", 'xss_clean');
        // 2checkout
        $this->form_validation->set_rules('po[twocheckout][enable]',         "lang:enable",         'xss_clean');
        $this->form_validation->set_rules('po[twocheckout][account_number]', "lang:account_number", 'xss_clean');
        $this->form_validation->set_rules('po[twocheckout][secretWord]',     "lang:secretWord",     'xss_clean');
        $this->form_validation->set_rules('po[twocheckout][test_mode]',      "lang:signature",      'xss_clean');
        // MobilPay
        $this->form_validation->set_rules('po[mobilpay][enable]',      "lang:enable",      'xss_clean');
        $this->form_validation->set_rules('po[mobilpay][merchant_id]', "lang:merchant_id", 'xss_clean');
        $this->form_validation->set_rules('po[mobilpay][public_key]',  "lang:public_key",  'xss_clean');
        $this->form_validation->set_rules('po[mobilpay][test_mode]',   "lang:signature",   'xss_clean');

        if ($this->form_validation->run() == true)
        {

            $data = array(
                "enable"          => $this->input->post("po[enable]"),
                "biller_accounts" => $this->input->post("po[biller_accounts]"),
                "paypal" => array(
                    "enable"    => $this->input->post("po[paypal][enable]"),
                    "username"  => $this->encryption->encrypt($this->input->post("po[paypal][username]")),
                    "password"  => $this->encryption->encrypt($this->input->post("po[paypal][password]")),
                    "signature" => $this->encryption->encrypt($this->input->post("po[paypal][signature]")),
                    "sandbox"   => $this->input->post("po[paypal][sandbox]"),
                ),
                "stripe" => array(
                    "enable"  => $this->input->post("po[stripe][enable]"),
                    "api_key" => $this->encryption->encrypt($this->input->post("po[stripe][api_key]")),
                ),
                "twocheckout" => array(
                    "enable"         => $this->input->post("po[twocheckout][enable]"),
                    "account_number" => $this->encryption->encrypt($this->input->post("po[twocheckout][account_number]")),
                    "secretWord"     => $this->encryption->encrypt($this->input->post("po[twocheckout][secretWord]")),
                    "test_mode"      => $this->input->post("po[twocheckout][test_mode]"),
                ),
                "mobilpay" => array(
                    "enable"         => $this->input->post("po[mobilpay][enable]"),
                    "merchant_id"    => $this->encryption->encrypt($this->input->post("po[mobilpay][merchant_id]")),
                    "public_key"     => $this->encryption->encrypt($this->input->post("po[mobilpay][public_key]")),
                    "test_mode"      => $this->input->post("po[mobilpay][test_mode]"),
                ),
            );
            $data = array(
                'configuration' => json_encode($data)
            );
        }

        if ( $this->form_validation->run() == true && $this->settings_model->updateSettings("PAYMENTS", $data))
        {
            $this->session->set_flashdata('success_message', lang('settings_po_updated'));
        }else{
            $this->session->set_flashdata('message', validation_errors());
        }
        redirect("/settings?config=payments_online");
    }

    function customize_template($template = false){
        if( VERSION == "DEMO" ){
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        $this->form_validation->set_rules('template', "lang:template", 'xss_clean');
        if ($this->form_validation->run() == true)
        {
            $template = $this->input->post("template");
            $data = array(
                'configuration' => json_encode(arrayToObject($template))
            );

            $template_folder = "assets/templates/InvoiceTemplates/".$template['name']."/";
            if( !file_exists("assets/templates") ){
                mkdir("assets/templates", true);
            }
            if( !file_exists($template_folder) ){
                mkdir($template_folder, true);
            }
            chmod("$template_folder", 0755);

            // save thumbnail
            if( $this->input->post("image_blob") ){
                $my_blob = $this->input->post("image_blob");
                $my_blob = substr($my_blob, strlen("data:image/jpeg;base64,"));
                $my_blob = base64_decode($my_blob);
                file_put_contents(realpath($template_folder)."/preview.jpg", $my_blob);
            }
            // save to file
            file_put_contents(realpath($template_folder)."/template.json", json_encode(arrayToObject($template)));
        }
        if ( $this->form_validation->run() == true && $this->settings_model->updateSettings("INVOICE", $data))
        {
            $this->session->set_flashdata('success_message', lang("invoice_template_updated"));
            redirect("/settings?config=settings_template", 'refresh');
        }
        else
        {
            if( $template ){
                $template =  str_replace("%20"," ",$template);
                $link = "assets/templates/InvoiceTemplates/".$template."/";
                $template_settings = file_get_contents(realpath($link)."/template.json");
                $data['invoice_settings'] = json_decode($template_settings);
            }else{
                $data['create_new']       = true;
                $data['invoice_settings'] = arrayToObject($this->settings_model->DEFAULT_SETTINGS["INVOICE"]);
            }
            $data['controller']       = NULL;
            $data['method']           = NULL;
            $data['params']           = NULL;
            $data['message']          = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            $data['success_message']  = $this->session->flashdata('success_message');
            $data['error_fields']     = $this->form_validation->error_array();
            $meta['page_title']       = lang('customize_template');
            $data['page_title']       = lang('customize_template');

            $this->load->view ( 'templates/head' , $meta );
            $this->load->view ( 'templates/header' );
            $this->load->view ( 'settings/settings_customize_template' , $data );
            $this->load->view ( 'templates/footer' , $meta );
        }
    }


    function customize_purchase_template($template = false){
        if( VERSION == "DEMO" ){
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        $this->form_validation->set_rules('template', "lang:template", 'xss_clean');
        if ($this->form_validation->run() == true)
        {
            $template = $this->input->post("template");
         
            $data = array(
                'configuration' => json_encode(arrayToObject($template))
            );

            $template_folder = "assets/templates/PurchaseTemplates/".$template['name']."/";
            if( !file_exists("assets/templates") ){
                mkdir("assets/templates", true);
            }
            if( !file_exists($template_folder) ){
                mkdir($template_folder, true);
            }
            chmod("$template_folder", 0755);

            // save thumbnail
            if( $this->input->post("image_blob") ){
                $my_blob = $this->input->post("image_blob");
                $my_blob = substr($my_blob, strlen("data:image/jpeg;base64,"));
                $my_blob = base64_decode($my_blob);
                file_put_contents(realpath($template_folder)."/preview.jpg", $my_blob);
            }
            // save to file
            file_put_contents(realpath($template_folder)."/template.json", json_encode(arrayToObject($template)));
        }
        if ( $this->form_validation->run() == true && $this->settings_model->updateSettings("PURCHASE", $data))
        {
            $this->session->set_flashdata('success_message', lang("purchase_template_updated"));
            redirect("/settings?config=settings_template", 'refresh');
        }
        else
        {
            if( $template ){
            
                $template =  str_replace("%20"," ",$template);
       
                $link = "assets/templates/PurchaseTemplates/".$template."/";
                $template_settings = file_get_contents(realpath($link)."/template.json");
                $data['purchase_settings'] = json_decode($template_settings);
            }else{
                $data['create_new']       = true;
                $data['purchase_settings'] = arrayToObject($this->settings_model->DEFAULT_SETTINGS["PURCHASE"]);
            }
            $data['controller']       = NULL;
            $data['method']           = NULL;
            $data['params']           = NULL;
            $data['message']          = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            $data['success_message']  = $this->session->flashdata('success_message');
            $data['error_fields']     = $this->form_validation->error_array();
            $meta['page_title']       = lang('customize_template');
            $data['page_title']       = lang('customize_template');

            $this->load->view ( 'templates/head' , $meta );
            $this->load->view ( 'templates/header' );
            $this->load->view ( 'settings/settings_customize_purchase_template' , $data );
            $this->load->view ( 'templates/footer' , $meta );
        }
    }

    public function select_template($template = false){
        if( $template ){
             $template =  str_replace("%20"," ",$template);
            $link = "assets/templates/InvoiceTemplates/".$template."/template.json";
            $template_data = file_get_contents(realpath($link));
            $data = array(
                'configuration' => $template_data
            );
            if ( $this->settings_model->updateSettings("INVOICE", $data))
            {
                $this->session->set_flashdata('success_message', lang("invoice_template_updated"));
            }
            redirect("/settings?config=settings_template", 'refresh');
        }
    }

    public function select_purchase_template($template = false){
        if( $template ){
             $template =  str_replace("%20"," ",$template);
            $link = "assets/templates/PurchaseTemplates/".$template."/template.json";
            $template_data = file_get_contents(realpath($link));
            $data = array(
                'configuration' => $template_data
            );
            if ( $this->settings_model->updateSettings("PURCHASE", $data))
            {
                $this->session->set_flashdata('success_message', lang("purchase_template_updated"));
            }
            redirect("/settings?config=settings_template", 'refresh');
        }
    }


    function save_invoice_template(){
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        $invoice_settings = new stdClass();
        // style
        $invoice_settings->primary_color = $this->input->post('primary_color')?$this->input->post('primary_color'):false;
        $invoice_settings->second_color = $this->input->post('second_color')?$this->input->post('second_color'):false;
        $invoice_settings->invoice_font = $this->input->post('invoice_font')?$this->input->post('invoice_font'):false;
        $invoice_settings->invoice_default_layout = $this->input->post('invoice_default_layout')?$this->input->post('invoice_default_layout'):false;
        $invoice_settings->invoice_default_size = $this->input->post('invoice_default_size')?$this->input->post('invoice_default_size'):false;

        // header
        $invoice_settings->header_model = $this->input->post('radio_model')?$this->input->post('radio_model'):false;
        $invoice_settings->header_bg_color = $this->input->post('header_bg_color')?$this->input->post('header_bg_color'):false;
        $invoice_settings->header_txt_color = $this->input->post('header_txt_color')?$this->input->post('header_txt_color'):false;
        $invoice_settings->header_text = $this->ion_auth->clear_tags($this->input->post('header_text')?$this->input->post('header_text'):false);
        $invoice_settings->show_header = $this->input->post('show_header_hidden2')?$this->input->post('show_header_hidden2'):"2";

        // footer
        $invoice_settings->show_footer = $this->input->post('show_footer')?$this->input->post('show_footer'):"2";
        $invoice_settings->footer_bg_color = $this->input->post('footer_bg_color')?$this->input->post('footer_bg_color'):false;
        $invoice_settings->footer_txt_color = $this->input->post('footer_txt_color')?$this->input->post('footer_txt_color'):false;
        $invoice_settings->footer_text = $this->ion_auth->clear_tags($this->input->post('footer_text')?$this->input->post('footer_text'):false);

        // settings
        $invoice_settings->table_border = $this->input->post('table_border')?$this->input->post('table_border'):"2";
        $invoice_settings->table_strip = $this->input->post('table_strip')?$this->input->post('table_strip'):"2";
        $invoice_settings->auto_print = $this->input->post('auto_print')?$this->input->post('auto_print'):"2";
        // Signature
        $invoice_settings->show_signature = $this->input->post('show_signature')?$this->input->post('show_signature'):"2";
        $invoice_settings->signature_txt = $this->input->post('signature_txt')?$this->input->post('signature_txt'):"";

        // parmas
        $refresh = base64_decode($this->input->post('refresh')?$this->input->post('refresh'):"index.php/settings?config=settings_invoice");
        $controller = $this->input->post('controller')?$this->input->post('controller'):NULL;
        $method = $this->input->post('method')?$this->input->post('method'):NULL;
        $param = $this->input->post('param')?$this->input->post('param'):NULL;
        $using_for = $this->input->post('using_for')?$this->input->post('using_for'):false;
        $id_setting = $this->input->post('id_setting')?$this->input->post('id_setting'):false;

        if( $using_for == "default" ){
            $controller =NULL;
            $method = NULL;
            $param = NULL;
        }
        else if( $using_for == "all" ){
            $param = NULL;
        }

        $data = array(
            'configuration' => json_encode($invoice_settings)
        );

        $this->settings_model->updateSettings("INVOICE", $data);

        $this->session->set_flashdata('success_message', lang("invoice_template_updated"));
        redirect($refresh, 'refresh');
    }

    function delete_invoice_template(){
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        // parmas
        $refresh = base64_decode($this->input->post('refresh')?$this->input->post('refresh'):"index.php/settings?config=settings_invoice");
        $id_setting = $this->input->post('id_setting')?$this->input->post('id_setting'):false;
        $this->settings_model->deleteInvoiceConfiguration($id_setting);
        $this->session->set_flashdata('success_message', lang("invoice_template_deleted"));
        redirect($refresh, 'refresh');
    }

    public function invoice_template()
    {
        if( $this->input->post('template[content]') ){
            $Page_content = $this->input->post('template[content]');
        }else{
            $Page_content = false;
        }
        $data['show_center_title'] = true;
        $data['page_title'] = lang('invoice');
        if( $Page_content ){
            $data['Page_content'] = $Page_content;
        }
        $data['show_btn_config'] = false;
        $data['is_preview'] = true;

        $this->load->view ( 'templates/printing_template' , $data );
    }


    public function purchase_template()
    {
        if( $this->input->post('template[content]') ){
            $Page_content = $this->input->post('template[content]');
        }else{
            $Page_content = false;
        }
        $data['show_center_title'] = true;
        $data['page_title'] = lang('purchase_order');
        if( $Page_content ){
            $data['Page_content'] = $Page_content;
        }
        $data['show_btn_config'] = false;
        $data['is_preview'] = true;

        $this->load->view ( 'templates/printing_template' , $data );
    }



    public function change_language ()
    {
        if($this->input->get('lang')){
            $lang = $this->input->get('lang');
        }
        $folder = 'application/language/';
        $languagefiles = scandir($folder);
        if(in_array($lang, $languagefiles)){
            $this->settings_model->setLanguage($lang);
            $this->session->set_flashdata('success_message', lang('language_is_changed'));
        }
        redirect($_SERVER["HTTP_REFERER"]);
    }

    public function jsConstant($show_in = "head")
    {
        $data["show_in"] = $show_in;
        $this->output->set_content_type('application/javascript');
        $this->load->view ('templates/jsConstant', $data);
    }


    public function getBackups(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->load->library('datatables');
        $aaData = $this->settings_model->getDatabaseBackups();
        $relevances = array();
        foreach ($aaData as $v){
            $relevances[] = "SELECT '{$v['name']}' as `name`, '{$v['date']}' as `date`";
        }
        $table = implode(' UNION ', $relevances);

        if( !empty($relevances) ){
            $table = implode(' UNION ', $relevances);
        }else{
            $table = "SELECT '0' AS `name` , '0' AS `date`";
            $this->datatables->where('name', 1);
        }
        $this->datatables
        ->setsColumns("id,name,date")
        ->select("date as id,name,date", false)
        ->from("($table) as backups");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }

    public function create_backup()
    {
        if ( !$this->ion_auth->in_group('admin') )
        {
            return show_error('You must be an administrator to view this page.');
        }
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        $this->load->dbutil();
        $prefs = array(
            'format'             => 'zip',
            'filename'           => 'db_backup.sql',
            );
        $backup = $this->dbutil->backup($prefs);
        $db_name = 'backup_'. date("YmdHis") .'.zip';
        $save = $this->settings_model->Backup_dir.$db_name;
        $this->load->helper('file');
        write_file($save, $backup);
        $this->load->helper('download');
        force_download($db_name, $backup);
    }

    public function restore_backup()
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( !$this->ion_auth->in_group('admin') )
        {
            $result = array("status"=>"error", "message"=>"You must be an administrator to view this page.");
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $date = $this->input->get('date')?$this->input->get('date'):false;
        if( $date ){
            $date = DateTime::createFromFormat(PHP_DATE.' H:i:s', $date);
            $date = $date->format('YmdHis');
            $path = $this->settings_model->Backup_dir.'backup_'.$date.'.zip';
            if( file_exists($path) ){
                $this->load->library('unzip');
                $this->unzip->extract($path, $this->settings_model->Backup_dir);
                $file = $this->settings_model->Backup_dir.'db_backup.sql';
                if( $this->settings_model->restore_backup($file) ){
                    $this->session->set_flashdata('success_message', lang('restore_backup_success'));
                    $result = array("status"=>"redirect", "message"=>site_url("settings?config=settings_db"));
                    $this->output->set_content_type('application/json')->set_output(json_encode($result));
                }else{
                    $result = array("status"=>"error", "message"=>lang("restore_backup_failed"));
                    $this->output->set_content_type('application/json')->set_output(json_encode($result));
                }
                unlink($file);
                return false;
            }
        }
        $result = array("status"=>"error", "message"=>lang("access_denied"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
        return false;
    }

    public function delete_backup()
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( !$this->ion_auth->in_group('admin') )
        {
            $result = array("status"=>"error", "message"=>"You must be an administrator to view this page.");
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if($this->input->get('date')) { $id = array($this->input->get('date')); }
        if($this->input->post('id')) { $id = $this->input->post('id'); }
        foreach ($id as $date) {
            $date = DateTime::createFromFormat(PHP_DATE.' H:i:s', $date);
            $date = $date->format('YmdHis');
            $path = $this->settings_model->Backup_dir.'backup_'.$date.'.zip';
            if( file_exists($path) ){
                unlink($path);
            }
        }
        $result = array("status"=>"success", "message"=>lang("backup_deleted"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
        return false;
    }

    public function download_backup()
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect('settings?config=settings_db', 'refresh');
            return false;
        }
        if ( !$this->ion_auth->in_group('admin') )
        {
            $this->session->set_flashdata('message', "You must be an administrator to view this page.");
            redirect('settings?config=settings_db', 'refresh');
            return false;
        }
        $date = $this->input->get('date')?$this->input->get('date'):false;
        if( $date ){
            $date = DateTime::createFromFormat(PHP_DATE.' H:i:s', $date);
            $date = $date->format('YmdHis');
            $path = $this->settings_model->Backup_dir.'backup_'.$date.'.zip';
            if( file_exists($path) ){
                $this->load->helper('download');
                force_download($path, NULL);
                return;
            }
        }
        $this->session->set_flashdata('message', lang("access_denied"));
        redirect('settings?config=settings_db', 'refresh');
    }

    public function getTaxRates(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->load->library('datatables');
        $this->datatables
        ->setsColumns("id,label,value,type,is_default,can_delete")
        ->select("id,label,value,type,is_default,can_delete", true)
        ->from("tax_rates");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }

    public function getAllTaxRates(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $result = $this->settings_model->getAllTaxRates();
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function create_tax_rate()
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
        $this->form_validation->set_rules('tax_rate[label]',      "lang:tax_rate_label",   'required|xss_clean');
        $this->form_validation->set_rules('tax_rate[value]',      "lang:tax_rate_value",   'required|xss_clean');
        $this->form_validation->set_rules('tax_rate[type]',       "lang:tax_rate_type",    'required|xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data_tax_rate = $this->input->post("tax_rate");
        }
        if ( $this->form_validation->run() == true && $this->settings_model->create_tax_rate($data_tax_rate))
        {
            $data = array("status" => "success","message" => lang("tax_rate_added"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array(
                    "status" => "error",
                    "message" => (validation_errors() ? validation_errors() : $this->session->flashdata('message'))
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                $data['yes_no']     = $this->settings_model->getYesNoArray();
                $data['page_title'] = lang('tax_rate_new');
                $this->load->view ( 'settings/settings_taxes_create' , $data );
            }
        }
    }

    public function update_tax_rate()
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
        $tax_rate = $this->settings_model->get_tax_rate($id);

        $this->form_validation->set_rules('tax_rate[label]',      "lang:tax_rate_label",   'required|xss_clean');
        $this->form_validation->set_rules('tax_rate[value]',      "lang:tax_rate_value",   'required|xss_clean');
        $this->form_validation->set_rules('tax_rate[type]',       "lang:tax_rate_type",    'required|xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data_tax_rate = $this->input->post("tax_rate");
            $id = $this->input->post('id');
        }
        if ( $this->form_validation->run() == true && $this->settings_model->update_tax_rate($id, $data_tax_rate))
        {
            $data = array("status" => "success","message" => lang("tax_rate_updated"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array(
                    "status" => "error",
                    "message" => (validation_errors() ? validation_errors() : $this->session->flashdata('message'))
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                $data['yes_no']     = $this->settings_model->getYesNoArray();
                $data['page_title'] = lang('tax_rate_update');
                $data['tax_rate']   = $tax_rate;
                $this->load->view ( 'settings/settings_taxes_update' , $data );
            }
        }
    }

    public function delete_tax_rate()
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
        if($this->input->get('id')) { $id = $this->input->get('id'); }
        if( !isset($id) || $id == false ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        if ( $this->settings_model->delete_tax_rate($id) )
        {
            $result = array("status"=>"success", "message"=>lang("tax_rate_deleted"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("access_denied"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }




    // email templates
    public function update_email_template($template_name = false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if( $this->input->get('template_name') ){ $template_name = $this->input->get('template_name'); }
        if (!$this->input->is_ajax_request() || !$template_name) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        $languages = $this->settings_model->getAvailableLanguages();
        $templates = $this->settings_model->getEmailTemplate($template_name);

        foreach ($languages as $language => $label) {
            $this->form_validation->set_rules("email_template[$language][subject]", "lang:subject", 'xss_clean');
            $this->form_validation->set_rules("email_template[$language][content]", "lang:content", 'xss_clean');
        }

        if ($this->form_validation->run() == true)
        {
            $data_email_template = $this->input->post("email_template");
        }
        if ( $this->form_validation->run() == true && $this->settings_model->updateEmailTemplate($template_name, $data_email_template))
        {
            $data = array("status" => "success","message" => lang("email_template_updated"));
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
            if( validation_errors() || $this->ion_auth->errors() ){
                $data = array(
                    "status" => "error",
                    "message" => (validation_errors() ? validation_errors() : $this->session->flashdata('message')),
                    "error_fields" => $this->form_validation->error_array()
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }else{
                $data['template_name']  = $template_name;
                $data['languages']      = $languages;
                $data['page_title']     = lang('update_email_template');
                $data['email_templates']= $templates;
                $this->load->view ( 'settings/email_template' , $data );
            }
        }
    }


    //charts of account

    public function getChartsData()
    {
       
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->load->library('datatables');
        
        $this->datatables
        ->setsColumns("account_number,description,status,id")
        ->select("account_number,status,description,id", false)
        ->from("accounts");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }


    //get initial_balance 
    public function getBalanceData()
    {
       
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->load->library('datatables');
        
        $this->datatables
        ->setsColumns("account_number,description,dtp_amount,crd_amount,id")
        ->select("account_number,description,dtp_amount,crd_amount,id", false)
        ->from("initial_balance");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }


      //get uom 
    public function getuom()
    {
       
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->load->library('datatables');
        
        $this->datatables
        ->setsColumns("unit_of_measurement,description,status,id")
        ->select("unit_of_measurement,description,status,id", false)
        ->from("uom");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }


    public function create_chart_of_account ()
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
        $this->data['title'] = lang('edit_user_heading');

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
        {
            redirect('auth', 'refresh');
        }


        $this->form_validation->set_rules('account_number',          "lang:account_number",          'required|xss_clean');
        $this->form_validation->set_rules('description',   "lang:description",   'xss_clean');
        $this->form_validation->set_rules('status',   "lang:status",   'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data_account = array("account_number"=>$this->input->post('account_number'),"description"=>$this->input->post('description'),"status"=>$this->input->post('status'));
           
           
        }
        if ( $this->form_validation->run() == true && $this->account_model->add($data_account))
        {


            $this->data = array(
                "status" => "success",
                "message" => lang("create_account_success")
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($this->data));


        }

        if( !$this->form_validation->run() && !validation_errors() && !$this->ion_auth->errors() ){
            // display the edit user form
            $this->data['csrf'] = $this->_get_csrf_nonce();
            // pass the user to the view
           
           
           
            
            
            $this->_render_page('settings/create_chart_of_account', $this->data);
        }
    
    }

    public function create_balance ()
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
        $this->data['title'] = lang('edit_user_heading');

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
        {
            redirect('auth', 'refresh');
        }

        $this->form_validation->set_rules('account_number',          "lang:account_number",          'required|xss_clean');
        $this->form_validation->set_rules('description',   "lang:description",   'xss_clean');
        $this->form_validation->set_rules('dtp_amount',   "lang:debit_amount",   'xss_clean');
        $this->form_validation->set_rules('crd_amount',   "lang:credit_amount",   'xss_clean');

        if ($this->form_validation->run() == true)
        {
             $balance = array("account_number"=>$this->input->post('account_number'),"description"=>$this->input->post('description'),"dtp_amount"=>$this->input->post('dtp_amount'),"crd_amount"=>$this->input->post('crd_amount'));

           
           
        }
        if ( $this->form_validation->run() == true && $this->initial_balance_model->add($balance))
        {


            $this->data = array(
                "status" => "success",
                "message" => lang("balance_add_success")
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($this->data));


        }

        if( !$this->form_validation->run() && !validation_errors() && !$this->ion_auth->errors() ){
            // display the edit user form
            $this->data['csrf'] = $this->_get_csrf_nonce();
            // pass the user to the view
            
            $this->data['page_title'] = lang("initial_balance");
            $this->data['accounts'] = $this->account_model->getAll(); 
            $this->_render_page('settings/settings_create_balance', $this->data);
        }
    
    }

    public function create_uom()
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
        $this->data['title'] = lang('edit_user_heading');

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
        {
            redirect('auth', 'refresh');
        }

        $this->form_validation->set_rules('unit_of_measurement', "lang:unit_of_measurement", 'required|xss_clean');
        $this->form_validation->set_rules('description',   "lang:description",   'xss_clean');
        $this->form_validation->set_rules('status',   "lang:debit_amount",   'xss_clean');
        if ($this->form_validation->run() == true)
        {
             $uom = array("unit_of_measurement"=>$this->input->post('unit_of_measurement'),"description"=>$this->input->post('description'),"status"=>$this->input->post('status'));

           
           
        }
        if ( $this->form_validation->run() == true && $this->uom_model->add($uom))
        {


            $this->data = array(
                "status" => "success",
                "message" => lang("uom_add_success")
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($this->data));


        }

        if( !$this->form_validation->run() && !validation_errors() && !$this->ion_auth->errors() ){
            // display the edit user form
            $this->data['csrf'] = $this->_get_csrf_nonce();
            // pass the user to the view
            
            $this->data['page_title'] = lang("unit_of_measurement");
            $this->data['accounts'] = $this->account_model->getAll(); 
            $this->_render_page('settings/settings_create_uom', $this->data);
        }
    
    }

    public function edit_balance($id)
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
        $this->data['title'] = lang('edit_user_heading');

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
        {
            redirect('auth', 'refresh');
        }

        $balance = $this->initial_balance_model->getByID($id);


        $this->form_validation->set_rules('account_number',          "lang:account_number",          'required|xss_clean');
        $this->form_validation->set_rules('description',   "lang:description",   'xss_clean');
        $this->form_validation->set_rules('dtp_amount',   "lang:debit_amount",   'xss_clean');
        $this->form_validation->set_rules('crd_amount',   "lang:credit_amount",   'xss_clean');



         if ($this->form_validation->run() == true)
        {
            $balance = array("account_number"=>$this->input->post('account_number'),"description"=>$this->input->post('description'),"dtp_amount"=>$this->input->post('dtp_amount'),"crd_amount"=>$this->input->post('crd_amount'));
           
           
        }
        if ( $this->form_validation->run() == true && $this->initial_balance_model->update($id, $balance))
        {


            $data = array(
                "status" => "success",
                "message" => lang("balance_edit_success")
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        if( !$this->form_validation->run() && !validation_errors() && !$this->ion_auth->errors() ){
            // display the edit user form
            $this->data['csrf'] = $this->_get_csrf_nonce();

            $this->data['page_title'] = lang("edit_initial_balance");
            $this->data['balance'] = $balance;
            $this->data['accounts'] = $this->account_model->getAll(); 
            $this->_render_page('settings/settings_edit_balance', $this->data);
        }
    }

 public function edit_uom($id)
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
        $this->data['title'] = lang('edit_user_heading');

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
        {
            redirect('auth', 'refresh');
        }

        $uom = $this->uom_model->getByID($id);


         $this->form_validation->set_rules('unit_of_measurement', "lang:unit_of_measurement", 'required|xss_clean');
        $this->form_validation->set_rules('description',   "lang:description",   'xss_clean');
        $this->form_validation->set_rules('status',   "lang:debit_amount",   'xss_clean');




         if ($this->form_validation->run() == true)
        {
            $uom = array("unit_of_measurement"=>$this->input->post('unit_of_measurement'),"description"=>$this->input->post('description'),"status"=>$this->input->post('status'));
           
           
        }
        if ( $this->form_validation->run() == true && $this->uom_model->update($id, $uom))
        {


            $data = array(
                "status" => "success",
                "message" => lang("uom_edit_success")
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        if( !$this->form_validation->run() && !validation_errors() && !$this->ion_auth->errors() ){
            // display the edit user form
            $this->data['csrf'] = $this->_get_csrf_nonce();

            $this->data['page_title'] = lang("edit_unit_of_measurement");
            $this->data['uom'] = $uom;
            $this->data['accounts'] = $this->account_model->getAll(); 
            $this->_render_page('settings/settings_edit_uom', $this->data);
        }
    }


    public function edit_chart_of_account($id)
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
        $this->data['title'] = lang('edit_user_heading');

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
        {
            redirect('auth', 'refresh');
        }

        $account = $this->account_model->getByID($id);


        $this->form_validation->set_rules('account_number',          "lang:account_number",          'required|xss_clean');
        $this->form_validation->set_rules('description',   "lang:description",   'xss_clean');
        $this->form_validation->set_rules('status',   "lang:status",   'xss_clean');


         if ($this->form_validation->run() == true)
        {
            $data_account = array("account_number"=>$this->input->post('account_number'),"description"=>$this->input->post('description'),"status"=>$this->input->post('status'));
           
           
        }
        if ( $this->form_validation->run() == true && $this->account_model->update($id, $data_account))
        {


            $data = array(
                "status" => "success",
                "message" => lang("edit_account_success")
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        if( !$this->form_validation->run() && !validation_errors() && !$this->ion_auth->errors() ){
            // display the edit user form
            $this->data['csrf'] = $this->_get_csrf_nonce();

           
            $this->data['account_number'] = array(
                'name'  => 'account_number',
                'id'    => 'account_number',
                'type'  => 'number',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('account_number', $account->account_number),
                'autocomplete' => 'off'
            );
            $this->data['description'] = array(
                'name'  => 'description',
                'id'    => 'description',
                'type'  => 'text',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('description', $account->description),
                'autocomplete' => 'off'
            );

            
            $this->data['account'] = $account;
            $this->_render_page('settings/edit_chart_of_account', $this->data);
        }
    }

    public function view_balance()
    {
         if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( !$this->input->get('id') )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect("/settings", 'refresh');
        }
        $id                      = $this->input->get('id');
        $data['page_title']      = lang('initial_balance');
        $data['balance']            = $this->initial_balance_model->getByID($id);

        $this->load->view ( 'settings/settings_view_balance' , $data );
    }

    public function delete_balance()
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
        if ( $this->initial_balance_model->delete($id) )
        {
            $result = array("status"=>"success", "message"=>lang("balance_deleted"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("cant_delete_item"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }


     public function delete_uom()
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
        if ( $this->uom_model->delete($id) )
        {
            $result = array("status"=>"success", "message"=>lang("uom_delete_success"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("cant_delete_item"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }


    public function deactivate_chart_of_account($id)
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
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }

        $update_data = array("status"=> 0);
        $this->account_model->update($id, $update_data);
        $data = array(
                "status" => "success",
                "message" => lang("inactivate_account_success")
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }


    public function activate_chart_of_account($id)
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
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }



        $update_data = array("status"=> 1);
        $this->account_model->update($id, $update_data);
        $data = array(
                "status" => "success",
                "message" => lang("activate_account_success")
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }


    public function delete_chart_of_account($id)
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
        if ( $this->account_model->delete($id) )
        {
            $result = array("status"=>"success", "message"=>lang("account_deleted"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("cant_delete_account"));
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
