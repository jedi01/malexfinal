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

class Settings_model extends CI_Model
{
    var $table = "settings";
    public $SYS_Settings      = false;
    public $INV_Settings      = false;
    public $PO_Settings      = false;
    public $email_Settings    = false;
    public $PO_settings       = false;
    public $CURRENCIES        = false;
    public $COUNTRIES         = false;
    public $FILES_settings    = false;
    public $DEFAULT_SETTINGS = array(
        "SYSTEM" => array(
            "language" => "english",
            "timezone" => "Africa/Algiers",
            "dateformat" => 4,
            "number_format" => 3,
            "round_number" => 0,
            "currency_format" => 2,
            "currency_place" => "right",
            "decimal_place" => 2,
            "enable_register" => 1,
            "default_group" => "Members",
            "default_currency" => "USD",
            "reference_type" => 1,
            "prefix_invoice" => "INV-",
            "estimate_prefix" =>"EST-",
            "receipt_prefix" => "RCPT-",
            "contract_prefix" => "CONT-",
            "expense_prefix" => "EXP-",
            "invoice_next" => 1,
            "estimate_next" => 1,
            "receipt_next" => 1,
            "contract_next" => 1,
            "expense_next" => 1,
            "shipping" => 1,
            "item_tax" => 1,
            "item_discount" => 1,
            "item_tax_label" => "lang:tax",
            "default_status" => "draft",
            "default_country" => "US",
            "default_due_date" => null,
            "show_status" => "",
            "show_total_due" => "",
            "show_payments_page" => "",
            "customer_cf1" => "",
            "customer_cf2" => "",
            "customer_cf3" => "",
            "customer_cf4" => "",
            "supplier_cf1" => "",
            "supplier_cf2" => "",
            "supplier_cf3" => "",
            "supplier_cf4" => "",
            "item_cf1" => "",
            "item_cf2" => "",
            "item_cf3" => "",
            "item_cf4" => "",
            "invoice_cf1" => "",
            "invoice_cf2" => "",
            "invoice_cf3" => "",
            "invoice_cf4" => "",
            "default_note" => "",
            "default_terms" => "",
            "note_terms_on_page" => "",
            "enable_terms" => "",
            "enable_recurring" => "1",
            "enable_contracts" => "1",
            "df_contract_desc" => "",
            "enable_overdue_reminder" => "",
            "overdue_first_time" => "",
            "overdue_every" => "",
            "amount_in_words" => "",
            "description_inline" => 1,
            "chat_enable" => "",
            "chat_support_label" => "Support",
            "chat_support_id" => 1,
            "reminder_enable" => "",
            "reminder_subject" => "Smart Invoice System - Reminder",
            "reminder_content" => "",
            "user_all_privileges" => 1,
            "cus_payment_methods" => 1,
            "tax_conditional" => array(
                "enable" => 1,
                "tax_rate_id" => 1,
                "condition" => "<",
                "amount" => 0,
            ),

            "exchange_api_key" => "",
            "purchase_receipt_next" => 1,
            "purchase_order_prefix" =>"PO-",
            "next_purchase_order" => 1,
        ),
        "INVOICE" => array(
            "name"                   => "Default",
            "primary_color"          => "#009be1",
            "invoice_font"           => "Arial, Helvetica, sans-serif",
            "invoice_default_layout" => "portrait",
            "invoice_default_size"   => "A4",
            "header_model"           => "model1",
            "header_bg_color"        => "#ffffff",
            "header_txt_color"       => "#000000",
            "header_text"            => "<h4>[company_name]</h4><p>[company_address], [company_city], [company_postal_code] [company_state], [company_country] <br><b>Phone:</b> [company_phone] <b><br>Email: </b>[company_email]</p>",
            "show_header"            => 1,
            "show_footer"            => 1,
            "footer_bg_color"        => "#ffffff",
            "footer_txt_color"       => "#2e2e2e",
            "footer_text"            => "[company_name] &copy; 2017",
            "table_border"           => 1,
            "table_strip"            => 1,
            "auto_print"             => 2,
            "show_signature"         => 1,
            "signature_txt"          => "signature & stamp",
            "margin"                 => "0.5cm 0.5cm 0.5cm 0.5cm",
            "background_image"       => "",
            "background_color"       => "#ffffff",
            "background_position"    => "center center",
            "background_repeat"      => "no-repeat",
            "background_fit"         => "initial",
            "background_opacity"     => "0.4",
            "text_color"             => "#2e2e2e",
            "logo_size"              => "100%",
            "logo_monocolor"         => 0,
            "logo_greyscale"         => 0,
            "table_line_th_bg"       => "#009be1",
            "table_line_th_color"    => "#ffffff",
            "table_line_th_height"   => "24",
            "table_line_td_height"   => "23",
            "font_size"              => "12px",
            "page_number"            => 1,
            "signature_stamp"        => "",
            "title_position"         => "center",
        ),
        "PURCHASE" => array(
            "name"                   => "Grayscale",
            "primary_color"          => "#009be1",
            "purchase_font"           => "Arial, Helvetica, sans-serif",
            "purchase_default_layout" => "portrait",
            "purchase_default_size"   => "A4",
            "header_model"           => "model1",
            "header_bg_color"        => "#ffffff",
            "header_txt_color"       => "#000000",
            "header_text"            => "<h4>[company_name]</h4><p>[company_address], [company_city], [company_postal_code] [company_state], [company_country] <br><b>Phone:</b> [company_phone] <b><br>Email: </b>[company_email]</p>",
            "show_header"            => 1,
            "show_footer"            => 1,
            "footer_bg_color"        => "#ffffff",
            "footer_txt_color"       => "#2e2e2e",
            "footer_text"            => "[company_name] &copy; 2017",
            "table_border"           => 1,
            "table_strip"            => 1,
            "auto_print"             => 2,
            "show_signature"         => 1,
            "signature_txt"          => "signature & stamp",
            "margin"                 => "0.5cm 0.5cm 0.5cm 0.5cm",
            "background_image"       => "",
            "background_color"       => "#ffffff",
            "background_position"    => "center center",
            "background_repeat"      => "no-repeat",
            "background_fit"         => "initial",
            "background_opacity"     => "0.4",
            "text_color"             => "#2e2e2e",
            "logo_size"              => "100%",
            "logo_monocolor"         => 0,
            "logo_greyscale"         => 0,
            "table_line_th_bg"       => "#009be1",
            "table_line_th_color"    => "#ffffff",
            "table_line_th_height"   => "24",
            "table_line_td_height"   => "23",
            "font_size"              => "12px",
            "page_number"            => 1,
            "signature_stamp"        => "",
            "title_position"         => "center",
        ),
        "COMPANY" => array(
            "name"        => "Accounting Software",
            "address"     => "Buzau, Romania",
            "city"        => "Buzau",
            "state"       => "Buzau",
            "postal_code" => "120258",
            "country"     => "Romania",
            "phone"       => "011 40 999999999",
            "email"       => "malexandrescu@outlook.com",
            "logo"        => "storage/invoice_logo.png",
            "cfl1"        => "",
            "cfv1"        => "",
            "cfl2"        => "",
            "cfv2"        => "",
            "cfl3"        => "",
            "cfv3"        => "",
            "cfl4"        => "",
            "cfv4"        => "",
        ),
        "EMAIL" => array(
            'protocol'     => 'mail',
            'mailtype'     => 'html',
            'smtp_host'    => '',
            'smtp_port'    => 25,
            'smtp_user'    => '',
            'smtp_pass'    => '',
            'smtp_timeout' => 30,
            'charset'      => 'utf-8',
            'newline'      => '\r\n',
            'mailpath'     => '',
            'smtp_crypto'  => ''
        ),
        "PAYMENTS"  => array(
            "enable"           => 0,
            "biller_accounts"  => 0,
            "paypal" => array(
                "enable"    => 0,
                "username"  => "",
                "password"  => "",
                "signature" => "",
                "sandbox"   => 0,
            ),
            "stripe" => array(
                "enable"  => 0,
                "api_key" => "",
            ),
            "twocheckout" => array(
                "enable"         => 0,
                "account_number" => "",
                "secretWord"     => "",
                "test_mode"      => 0,
            ),
            "mobilpay" => array(
                "enable"         => 0,
                "merchant_id"    => "",
                "public_key"     => "",
                "test_mode"      => 0,
            ),
            "skrill" => array(
                "enable"         => 0,
                "email"          => "",
                "secretWord"     => "",
                "test_mode"      => 0,
            ),
        ),
        "FILES"  => array(
            "enable"              => 0,
            "user_disc_space"     => 100,  // 100 MB, Disk space for users
            "max_upload_size"     => 20,   // 20 MB, Maximum File Size
            "max_simult_uploads"  => 10,   // 10 files, Maximum simultaneous uploads.
            "white_list"          => "mp4,mp3,avi,zip,rar,jpg,jpeg,tif,png,gif,bmp,mp3,pdf,txt,doc,docx,xls,xlsx,csv,ppt,pptx",
        )
    );
    public $Backup_dir = 'backups/';

    public function __construct ()
    {
        parent::__construct ();
        $this->load->helper('app');
        $this->SYS_Settings   = $this->getSettings ("SYSTEM");
        $this->INV_Settings   = $this->getSettings ("INVOICE");
        $this->PO_Settings   = $this->getSettings ("PURCHASE");
        $this->COM_Settings   = $this->getSettings ("COMPANY");
        $this->email_Settings = $this->getSettings ("EMAIL");
        $this->PO_settings    = $this->getSettings ("PAYMENTS");
        $this->FILES_settings = $this->getSettings ("FILES");

        /*
        |--------------------------------------------------------------------------
        | SMART INVOICE SYSTEM CONSTANTS
        |--------------------------------------------------------------------------
        |
        */
        /* SYSTEM CONSTANTS */
        define("APP_NAME", "SIS");
        define("APP_DESCRIPTION", "SMART INVOICE SYSTEM");
        $this->setLanguage();
        $currencies = $this->getAllCurrencies();
        define("REFERENCE_TYPE", $this->SYS_Settings->reference_type);
        define("INVOICE_PREFIX", $this->SYS_Settings->prefix_invoice);
        define("PURCHASE_PREFIX", $this->SYS_Settings->purchase_order_prefix);
        define("ESTIMATE_PREFIX", $this->SYS_Settings->estimate_prefix);
        define("RECEIPT_PREFIX", $this->SYS_Settings->receipt_prefix);
        define("CONTRACT_PREFIX", $this->SYS_Settings->contract_prefix);
        define("EXPENSE_PREFIX", $this->SYS_Settings->expense_prefix);


        define("SHIPPING", $this->SYS_Settings->shipping==0);
        define("ITEM_TAX", $this->SYS_Settings->item_tax);
        define("ITEM_DISCOUNT", $this->SYS_Settings->item_discount);
        $date_format = $this->getDateFormats($this->SYS_Settings->dateformat);
        define("JS_DATE", $date_format["js"]);
        define("PHP_DATE", $date_format["php"]);
        if( LANGUAGE != "english" && strpos($date_format["mask"], "aaa") !== false ){
            define("MASK_DATE", "");
        }else{
            define("MASK_DATE", $date_format["mask"]);
        }
        define("DATEPICKER_FORMAT", $date_format["datepicker"]);
        define("NUMBER_FORMAT", $this->SYS_Settings->number_format);
        define("ROUND_NUMBER", $this->SYS_Settings->round_number);
        define("CURRENCY_FORMAT", $this->SYS_Settings->currency_format);
        define("CURRENCY_PLACE", $this->SYS_Settings->currency_place);
        define("DECIMAL_PLACE", $this->SYS_Settings->decimal_place);
        define("CURRENCY_PREFIX", $this->SYS_Settings->default_currency);
        define("CURRENCY_SYMBOL", CURRENCY_FORMAT==1?CURRENCY_PREFIX:$currencies[CURRENCY_PREFIX]->symbol_native);
        define('SUGGESTION_LENGTH', 0);
        define('SUGGESTION_MAX', 5);
        define('WINDDOW_NAME', APP_NAME);
        define('WINDDOW_CONFIGURATION','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1350,height=660');
        define("DEFAULT_STATUS", $this->SYS_Settings->default_status);
        define("USER_ALL_PRIVILEGES", $this->SYS_Settings->user_all_privileges);
        define("CUS_PAYMENT_METHODS", $this->SYS_Settings->cus_payment_methods);

        define("DEFAULT_COUNTRY", $this->getFormattedCountries($this->SYS_Settings->default_country));
        define("DEFAULT_PHONE_CODE", $this->getFormattedPhones($this->SYS_Settings->default_country)->phone);


        define("EXCHANGE_API_KEY", $this->SYS_Settings->exchange_api_key);

        define("REGISTER", $this->SYS_Settings->enable_register == "0");
        define("DEFAULT_GROUP", $this->SYS_Settings->default_group);

        /* COMPANY CONSTANTS */
        define("COMPANY_NAME"       , $this->COM_Settings->name);
        define("COMPANY_PHONE"      , $this->COM_Settings->phone);
        define("COMPANY_EMAIL"      , $this->COM_Settings->email);
        define("COMPANY_LOGO"       , $this->COM_Settings->logo);
        define("COMPANY_COUNTRY"    , $this->COM_Settings->country);
        define("COMPANY_STATE"      , $this->COM_Settings->state);
        define("COMPANY_CITY"       , $this->COM_Settings->city);
        define("COMPANY_POSTAL_CODE", $this->COM_Settings->postal_code);
        define("COMPANY_ADDRESS"    , $this->COM_Settings->address);

        /* ACCOUNT CONSTANTS */
        if ($this->ion_auth->logged_in()) {
            $user = $this->ion_auth->user()->row();
            $groups = $this->ion_auth->get_users_groups($user->id);
            if( empty($user->first_name) && empty($user->last_name) ){
                define("USER_NAME", $user->username);
            }else{
                define("FIRST_NAME", $user->first_name);
                define("USER_NAME", $user->first_name." ".$user->last_name);
            }
            define("USER_ID", $user->id);
            if( $this->ion_auth->in_group(array("customer", "supplier")) ){
                $biller_id = $this->getBillerId(USER_ID);
                define("BILLER_ID", $biller_id);
            }
        }


        // Payments online & biller account
        $po_requirements = true;// isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && function_exists('curl_version');
        define("PAYMENTS_ONLINE_REQUIREMENTS", $po_requirements);
        define("PAYMENTS_ONLINE", $this->PO_settings->enable);
        define("CREATE_BILLER_ACCOUNTS", $this->PO_settings->biller_accounts);

        // Cron Job is activated ?
        if( !defined("CRON_JOB_ACTIVATED") )
            define("CRON_JOB_ACTIVATED", false);

        // Recurring invoices
        define("ENABLE_RECURRING", $this->SYS_Settings->enable_recurring && CRON_JOB_ACTIVATED);

        // Contracts
        define("ENABLE_CONTRACTS", $this->SYS_Settings->enable_contracts);

        // Overdue Reminder
        define("ENABLE_OVERDUE_REMINDER", $this->SYS_Settings->enable_overdue_reminder);

        // ALERT TO REMOVE INSTALLER FILE (EXECUTER)
        if( is_file("install.php") ){
            $this->session->set_flashdata('message', lang("remove_install_file"));
        }
        // ALERT TO REMOVE INSTALLER FILE (EXECUTER)
        if( is_file("update.php") ){
            //$this->session->set_flashdata('message', lang("remove_update_file"));
        }
    }

    public function setLanguage ($language = false)
    {
        $session = $this->session->all_userdata();
        if ( !$language && !isset($session['lang']) ){
            $language = $this->SYS_Settings->language;
            $this->session->set_userdata(['lang' => $language]);
        }else{
            if( $language != false ){
                $this->session->set_userdata(['lang' => $language]);
            }else{
                $language = $session["lang"];
            }
        }
        if( !defined("LANGUAGE") ) define("LANGUAGE", $language);
        $this->config->set_item('language', LANGUAGE);
        $this->lang->load ( "sis" , LANGUAGE );
        //setlocale(LC_ALL, lang("local_date"));
        if( !defined("LANG") ){
            define("LANG", lang("lang"));
            $lang = explode("-", lang("lang"));
            define("MIN_LANG", $lang[0]);
        }

    }

    public function getDateFormats($id = false)
    {
        $array = array(
            array("id"=>1, "label"=>date("m-d-Y"), "js"=>"MM-DD-YYYY", "php"=>"m-d-Y", "sql"=>"%m-%d-%Y", "mask"=>"99-99-9999", "datepicker"=>"mm-dd-yyyy"),
            array("id"=>2, "label"=>date("m/d/Y"), "js"=>"MM/DD/YYYY", "php"=>"m/d/Y", "sql"=>"%m/%d/%Y", "mask"=>"99/99/9999", "datepicker"=>"mm/dd/yyyy"),
            array("id"=>3, "label"=>date("d-m-Y"), "js"=>"DD-MM-YYYY", "php"=>"d-m-Y", "sql"=>"%d-%m-%Y", "mask"=>"99-99-9999", "datepicker"=>"dd-mm-yyyy"),
            array("id"=>4, "label"=>date("d/m/Y"), "js"=>"DD/MM/YYYY", "php"=>"d/m/Y", "sql"=>"%d/%m/%Y", "mask"=>"99/99/9999", "datepicker"=>"dd/mm/yyyy"),
            array("id"=>5, "label"=>date("M d Y"), "js"=>"MMM DD YYYY", "php"=>"M d Y", "sql"=>"%b %d %Y", "mask"=>"aaa 99 9999", "datepicker"=>"M dd yyyy"),
            array("id"=>6, "label"=>date("Y M d"), "js"=>"YYYY MMM DD", "php"=>"Y M d", "sql"=>"%Y %b %d", "mask"=>"9999 aaa 99", "datepicker"=>"yyyy M dd"),
            array("id"=>7, "label"=>date("d M Y"), "js"=>"DD MMM YYYY", "php"=>"d M Y", "sql"=>"%d %b %Y", "mask"=>"99 aaa 9999", "datepicker"=>"dd M yyyy"),
            array("id"=>8, "label"=>date("d.m.Y"), "js"=>"DD.MM.YYYY", "php"=>"d.m.Y", "sql"=>"%d.%m.%Y", "mask"=>"99.99.9999", "datepicker"=>"dd.mm.yyyy"),
        );
        if( $id != false ){
            foreach ($array as $value) {
                if( $value["id"] == $id )
                    return $value;
            }
        }
        return arrayToObject($array);
    }

    public function getInvoiceStatus($id = false)
    {
        if( defined("BILLER_ID") ){
            $array = array(
                "unpaid"    => lang("unpaid"),
                "paid"      => lang("paid"),
                "partial"   => lang("partial"),
                "overdue"   => lang("overdue"),
                "canceled"  => lang("canceled"),
                "panding"   => lang("panding"),
            );
        }else{
            $array = array(
                "unpaid"    => lang("unpaid"),
                "paid"      => lang("paid"),
                "partial"   => lang("partial"),
                "overdue"   => lang("overdue"),
                "canceled"  => lang("canceled"),
                "draft"     => lang("draft"),
                "panding"   => lang("panding"),
            );
        }
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }


    public function getStatus($id = false)
    {
    
        $array = array(
            "unpaid"    => lang("unpaid"),
            "paid"      => lang("paid"),
            "partial"   => lang("partial"),
            "overdue"   => lang("overdue"),
            "canceled"  => lang("canceled"),
            "draft"     => lang("draft"),
            "panding"   => lang("panding"),
        );
        
        return $array;
    }


    public function getGLstatusInvoice($id = false)
    {
    
        $array = array(
            "not_posted"   => lang("not_posted"),
            "posted"  => lang("posted"),
        );
        
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getGLstatus($id = false)
    {
    
        $array = array(
            "open"   => lang("open"),
            "posted"  => lang("posted"),
        );
        
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }
    public function getDueDates($id = false)
    {
        $array = array(
            "null" => lang("due_receipt"),
            "7"    => lang("after_7_days"),
            "15"   => lang("after_15_days"),
            "30"   => lang("after_30_days"),
            "45"   => lang("after_45_days"),
            "60"   => lang("after_60_days"),
            "-1"   => lang("custom"),
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getEstimateStatus($id = false)
    {
        if( defined("BILLER_ID") ){
            $array = array(
                "sent"     => lang("sent"),
                "accepted" => lang("accepted"),
                "invoiced" => lang("invoiced"),
                "canceled" => lang("canceled"),
            );
        }else{
            $array = array(
                "draft"    => lang("draft"),
                "sent"     => lang("sent"),
                "accepted" => lang("accepted"),
                "invoiced" => lang("invoiced"),
                "canceled" => lang("canceled"),
            );
        }
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getPaymentStatus($id = false)
    {
        $array = array(
            "released" => lang("released"),
            "panding"  => lang("panding"),
            "canceled" => lang("canceled"),
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getRecurringStatus($id = false)
    {
        $array = array(
            "active"   => lang("active"),
            "panding"  => lang("panding"),
            "canceled" => lang("canceled"),
            "finished" => lang("finished"),
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getContractStatus($id = false)
    {
        $array = array(
            "panding"  => lang("panding"),
            "active"   => lang("active"),
            "expired"  => lang("expired"),
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getProjectStatus($id = false)
    {
        $array = array(
            "not_started" => lang("not_started"),
            "in_progress" => lang("in_progress"),
            "on_hold"     => lang("on_hold"),
            "canceled"    => lang("canceled"),
            "finished"    => lang("finished"),
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getProjectBillingTypes($id = false)
    {
        $array = array(
            "fixed_rate"    => lang("fixed_rate"),
            "project_hours" => lang("project_hours"),
            "task_hours"    => lang("task_hours"),
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getProjectTaskStatus($id = false)
    {
        $array = array(
            "not_started" => lang("not_started"),
            "in_progress" => lang("in_progress"),
            "testing"     => lang("testing"),
            "panding"     => lang("panding"),
            "complete"    => lang("complete"),
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getPaperLayouts($id = false)
    {
        $array = array(
            "portrait" => "Portrait",
            "landscape" => "Landscape",
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getPaperSizes($id = false)
    {
        $array = array(
            "A4"     => "A4 [210mm × 297mm]",
            "A5"     => "A5 [148mm × 210mm]",
            "Letter" => "US Letter [216mm × 279mm]",
            "Legal"  => "US Legal [216mm × 356mm]",
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getPaymentsMethods($id = false, $online = true, $offline = true)
    {
        if( $offline ){
            $array = array(
                "cash"          => lang("cash"),
                "check"         => lang("check"),
                "bank_transfer" => lang("bank_transfer"),
                "other"         => lang("other"),
            );
        }else{
            $array = array();
        }
        if( PAYMENTS_ONLINE && $online ){
            if( $this->PO_settings->paypal->enable ){
                $array['paypal'] = lang("paypal");
            }
            if( $this->PO_settings->stripe->enable ){
                $array['stripe'] = lang("stripe");
            }
            if( $this->PO_settings->twocheckout->enable ){
                $array['twocheckout'] = lang("twocheckout");
            }
            if( $this->PO_settings->mobilpay->enable ){
                $array['mobilpay'] = lang("mobilpay");
            }
        }

        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getAvailableLanguages($id = false)
    {
        $array = array(
            'english'  => 'English',
            'french'   => 'Français <small class="text-muted" dir="ltr"> (French)</small>',
            'spanish'  => 'Español <small class="text-muted" dir="ltr"> (Spanish)</small>',
            'turkish'  => 'Türk <small class="text-muted" dir="ltr"> (Turkish)</small>',
            'russian'  => 'Pусский <small class="text-muted" dir="ltr"> (Russian)</small>',
            'romanian' => 'Romana <small class="text-muted" dir="ltr"> (Romanian)</small>',
            'german'   => 'Deutsche <small class="text-muted" dir="ltr"> (German)</small>',
            'italian'  => 'Italiano <small class="text-muted" dir="ltr"> (Italian)</small>',
            'arabic'   => 'العربية <small class="text-muted" dir="ltr"> (Arabic)</small>',
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getTaxesSettings($id = false)
    {
        $array = array(
            0 => lang("disabled"),
            1 => lang("apply_to_subtotal"),
            2 => lang("apply_to_line")
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getCurrencyPlaces($id = false)
    {
        $array = array(
            "left" => '$ 10.000',
            "right" => '10.000 $',
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getReferenceTypes($id = false)
    {
        $array = array(
            0 => 'MANUAL [A99991]',
            1 => 'DIGITAL [000001]',
            2 => 'PREFIX + DIGITAL [INV-000001]',
            3 => 'DIGITAL + PREFIX [000001-INV]',
            4 => 'PREFIX + YEAR + DIGITAL [INV-170001]',
            5 => 'RANDOM [51X63A]',
            6 => 'PREFIX + RANDOM [INV-51X63A]'
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getFormattedCurrencies($id = false)
    {
        $currencies = $this->getAllCurrencies();
        $array = array();
        foreach($currencies as $currency){
            if( LANGUAGE == "french" ){
                $currency_name = $currency->name_fr;
            }else if( LANGUAGE == "arabic" ){
                $currency_name = $currency->name_ar;
            }else{
                $currency_name = $currency->name_en;
            }
            $cr_obj = new stdClass();
            $cr_obj->value = $currency->code;
            $cr_obj->label = $currency->code." - ".$currency_name." (".$currency->symbol_native.")";
            $cr_obj->symbol_native = $currency->symbol_native;
            $cr_obj->name = $currency_name;
            $array[$currency->code] = $cr_obj;
        }
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getAllCurrencies(){
        if( $this->CURRENCIES == false ){
            $json_file  = APPPATH.'../assets/json/currencies.json';
            $file       = file_get_contents($json_file);
            $this->CURRENCIES = (array)json_decode($file);
        }
        return $this->CURRENCIES;
    }

    public function getFormattedCountries($id = false)
    {
        $this->lang->load ( "countries" , LANGUAGE );
        $countries = $this->getAllCountries();
        $array = array();
        foreach($countries as $country){
            $array[$country->code] = lang("country_".$country->code);
        }
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getFormattedPhones($id = false)
    {
        $this->lang->load ( "countries" , LANGUAGE );
        $countries = $this->getAllCountries();
        $array = array();
        foreach($countries as $country){
            $cr_obj = new stdClass();
            $cr_obj->code  = $country->code;
            $cr_obj->label = lang("country_".$country->code)." (".$country->dial_code.")";
            $cr_obj->phone = $country->dial_code;
            $array[$country->code] = $cr_obj;
        }
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getAllCountries(){
        if( $this->COUNTRIES == false ){
            $json_file  = APPPATH.'../assets/json/countries.json';
            $file       = file_get_contents($json_file);
            $this->COUNTRIES = (array)json_decode($file);
        }
        return $this->COUNTRIES;
    }

    public function getNumbersFormats($id = false)
    {
        $array = array(
            '1' => '123,456.00',
            '2' => '123.456,00',
            '3' => '123 456,00',
            '4' => '123 456.00',
            '5' => '123\'456,00',
            '6' => '123\'456.00',
            '7' => '123456.00',
            '8' => '123456,00',
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getRoundNumbers($id = false)
    {
        $array = array(
            '0'    => lang("disabled"),
            '1'    => '1 (1.73 &rArr; 2)',
            '10'   => '10 (17.35 &rArr; 20)',
            '100'  => '100 (173.50 &rArr; 200)',
            '1000' => '1000 (1735.00 &rArr; 2000)',
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getCurrenciesFormats($id = false)
    {
        $array = array(
            '1' => 'ISO Code (e.g. USD)',
            '2' => 'Symbol (e.g. $)',
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getDecimalPlaces($id = false)
    {
        $array = array(
            '0' => '0 (1)',
            '1' => '1 (1.0)',
            '2' => '2 (1.00)',
            '3' => '3 (1.000)',
            '4' => '4 (1.0000)',
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getUserGroups($id = false)
    {
        $array = array (
            'admin' => lang('role_admin'),
            'Members' => lang('role_members'),
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getYesNoArray($id = false)
    {
        $array = array (
            0 => lang("yes"),
            1 => lang("no")
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getRecurringFrequencies($id = false)
    {
        $array = array(
            "daily"   => lang("daily"),
            "weekly"  => lang("weekly"),
            "monthly" => lang("monthly"),
            "yearly"  => lang("yearly"),
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }

    public function getRecurringEvery($fr = false,$id = false)
    {
        $frequencies = array("daily", "weekly", "monthly", "yearly");
        $events = array("day", "week", "month", "year");
        $array = array();
        foreach ($frequencies as $key => $frequency) {
            $array[$frequency] = array();
            for ($i=1; $i < 7; $i++) {
                if( $i == 1 ){
                    $array[$frequency][$i." ".$events[$key]] = lang($events[$key]);
                }else{
                    $array[$frequency][$i." ".$events[$key]] = $i." ".lang($events[$key]."s");
                }
            }
        }
        if( $fr != false && $id != false ){
            return $array[$fr][$id];
        }
        return $array;
    }

    public function getPriorities($id = false)
    {
        $array = array(
            1 => lang("low"),
            2 => lang("medium"),
            3 => lang("high"),
        );
        if( $id != false ){
            return $array[$id];
        }
        return $array;
    }


    public function getSettings ($type =  "SYSTEM")
    {
        $settings = array();
        $DB_SETTINGS = array();
        $q = $this->db->where("type", $type)->get ( $this->table );
        if ( $q->num_rows () > 0 ) {
            $DB_SETTINGS = objectToArray(json_decode($q->row()->configuration));
        }
        
        $DF_SETTINGS = $this->DEFAULT_SETTINGS[$type];
    
        $array = array_merge($DF_SETTINGS, $DB_SETTINGS);

        return arrayToObject(array_merge($DF_SETTINGS, $DB_SETTINGS));
    }

    public function updateSettingsItem($item_label, $item_value, $type = "SYSTEM")
    {
        $configuration = $this->getSettings($type);
        $configuration = objectToArray($configuration);
        $configuration[$item_label] = $item_value;
        $data = array(
            'configuration' => json_encode($configuration)
        );
        return $this->updateSettings($type, $data);
    }

    public function updateSettings($type = "SYSTEM", $data = array())
    {
        $q = $this->db->where("type", $type)->get ( $this->table );
        if ( $q->num_rows () > 0 ) {
            if ( $this->db->where("type", $type)->update ( $this->table , $data ) ) {
                return true;
            }
        }else{
            $data["type"] = $type;
            if ( $this->db->insert ( $this->table , $data ) ) {
                return true;
            }
        }
        return false;
    }

    public function getDatabaseBackups()
    {
        $this->load->helper('file');
        $extensions = array('zip');
        if( !is_dir($this->Backup_dir) ){
            mkdir($this->Backup_dir);
            chmod($this->Backup_dir, 0755);
        }
        $filenames = get_filenames_by_extension($this->Backup_dir, $extensions);
        foreach ($filenames as $k => $filename) {
            $dateString    = substr($filename, 7, 14);
            $myDateTime    = DateTime::createFromFormat('YmdHis', $dateString);
            $newDateString = $myDateTime->format(PHP_DATE.' H:i:s');
            $filenames[$k] = array(
                "date" => $newDateString,
                "name" => $filename
            );
        }
        return $filenames;
    }

    public function restore_backup($file = false){
        $query = utf8_decode  (read_file($file));
        // GET ALL FORGEIN KEYS
        $this->db->select("CONSTRAINT_NAME, TABLE_NAME")
                ->from("INFORMATION_SCHEMA.KEY_COLUMN_USAGE")
                ->where("REFERENCED_TABLE_SCHEMA", CONFIG_MYSQL_DB);
        $q = $this->db->get ();
        if ( $q->num_rows () > 0 ) {
            $foreign_keys = $q->result();
            foreach ($foreign_keys as $foreign) {
                $query = "ALTER TABLE `".$foreign->TABLE_NAME."` DROP FOREIGN KEY `".$foreign->CONSTRAINT_NAME."`;\n".$query;
            }
        }
        $query_array = explode(";\n", $query);
        $query_array_add = array();
        foreach($query_array as $i => $qr){
            if( strlen(trim($qr)) > 0 && stripos($qr, "CONSTRAINT") !== false ){
                $start = stripos($qr, "CONSTRAINT");
                $end = strpos($qr, "\n)", $start);
                $contraint = substr($qr, $start, $end-$start);
                $qr_withou_contraint = substr($qr, 0, $start-4).substr($qr, $end);
                $start = stripos($qr, "`")+1;
                $end = strpos($qr, "`", $start);
                $table_name = substr($qr, $start, $end-$start);
                $contraints = explode(",\n", $contraint);
                foreach ($contraints as $j => $con) {
                    $query_array_add[] = "ALTER TABLE `$table_name` ADD ".trim($con).";";
                }
                $query_array[$i] = $qr_withou_contraint;
            }
        }
        $query_array = array_merge($query_array, $query_array_add);
        $error = false;
        foreach($query_array as $qr){
            if( strlen(trim($qr)) > 0 ){
                if( !$this->db->query($qr) ){
                    $error = true;
                }
            }
        }
        return !$error;
    }

    public function get_tax_rate ($id)
    {
        $q = $this->db->get_where ( 'tax_rates' , array ( 'id' => $id ) , 1 );
        if ( $q->num_rows () > 0 ) {
            return $q->row ();
        }
        return false;
    }

    public function getAllTaxRates ()
    {
        $q = $this->db->get ( 'tax_rates' );
        if ( $q->num_rows () > 0 ) {
            return $q->result_array ();
        }
        return array ();
    }

    public function create_tax_rate ($data = array ())
    {
        if( isset($data['is_default']) ){
            $this->db->set ( 'is_default' , '0' )->update ( 'tax_rates' );
        }
        if ( $this->db->insert ( 'tax_rates' , $data ) ) {
            $id = $this->db->insert_id ();
            return $id;
        }
        return false;
    }

    public function update_tax_rate ($id , $data = array ())
    {
        if( isset($data['is_default']) ){
            $this->db->set ( 'is_default' , '0' )->update ( 'tax_rates' );
        }else{
            $old = $this->get_tax_rate($id);
            if( $old->is_default ){
                $this->db->where ( 'id' , '1')->set ( 'is_default' , '1' )->update ( 'tax_rates' );
                $data['is_default'] = false;
            }
        }
        if ( $this->db->where ( 'id' , $id )->update ( 'tax_rates' , $data ) ) {
            return $id;
        }
        return false;
    }

    public function delete_tax_rate ($id)
    {
        $old = $this->get_tax_rate($id);
        if( $old->is_default == '1' ){
            $this->db->where ( 'id' , '1')->set ( 'is_default' , '1' )->update ( 'tax_rates' );
        }
        if ( $this->db->where ( 'id' , $id )->delete ( 'tax_rates' ) ) {
            return true;
        }
        return false;
    }

    public function getBillerId ($user_id){
        $this->db->select("id");
        $q = $this->db->get_where ( "biller" , array ( 'user_id' => $user_id ) , 1 );
        if ( $q->num_rows () > 0 ) {
            return $q->row ()->id;
        }
        return false;
    }

    // email templates
    public function getEmailTemplate ($template_name, $language = false)
    {
        if( $language ){
            $this->db->where("language", $language)->limit(1);
        }
        $q = $this->db->where("name", $template_name)->get('email_templates');
        if ( $q->num_rows () > 0 ) {
            if( $language ){
                return $q->row();
            }
            return $q->result_array();
        }else{
            if( $language ){
                return $this->getEmailTemplate($template_name, "english");
            }
        }
        return false;
    }

    public function updateEmailTemplate ($template_name , $data = array ())
    {
        foreach ($data as $key => $value) {
            $this->db
                ->where('name', $template_name)
                ->where('language', $key)
                ->update('email_templates', $value);
        }
        return true;
    }

}

/* End of file settings_model.php */
/* Location: ./application/models/settings_model.php */
