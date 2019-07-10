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

class Home extends MY_Controller
{
    /**
    * Home constructor.
    */
    public function __construct ()
    {
        parent::__construct ();
        // Load Home Model
        $this->load->model ( 'home_model' );
        // Load Reports Model
        $this->load->model ( 'reports_model' );
        // Load Helper Language
        $this->load->helper('language');
        // Load Helper Date Format
        $this->load->helper('date_format');
        // Check user is logged in ?
        if ( !$this->ion_auth->logged_in() ) {
            if ($this->input->is_ajax_request()) {
                $result = array("status"=>"redirect", "message"=>site_url("auth/login"));
                die(json_encode($result));
            }else{
                redirect("auth/login");
            }
        }
    }

    public function index()
    {
        $data['currencies']       = $this->reports_model->getUsedCurrencies();
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('dashboard');
        $data['page_title']       = lang('dashboard');

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view('home' , $data);
        $this->load->view ( 'templates/footer' , $meta );
    }

    public function getDashboardData(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $start_date        = $this->input->post("start");
        $end_date          = $this->input->post("end");
        $currency          = $this->input->post("currency");

        $data['invoices']         = $this->home_model->last_invoices($currency);
        $data['overview_chart']   = $this->home_model->overview_chart($start_date, $end_date, $currency);

        // THIS YEAR
        $last_year = $this->home_model->get_invoices_count_total(strtotime(date("Y-01-01")." -1 year"), strtotime(date("Y-12-31")." -1 year"), false, false, $currency);
        $this_year  = $this->home_model->get_invoices_count_total(date("Y-01-01"), date("Y-12-31"), false, false, $currency);
        if( $this_year["total"] == 0 && $last_year["total"] == 0 ){
            $this_year['percent'] = 0;
        }elseif( $this_year["total"] == 0 ){
            $this_year['percent'] = -100;
        }else{
            $this_year['percent'] = min(100,($this_year["total"] - $last_year["total"])*100 /$this_year["total"]) ;
        }
        if( $this_year['percent'] < 100 ){
            $this_year['percent'] = max(-100, $this_year['percent']);
        }
        $this_year['arrow'] = ($this_year['percent'] >= 0)?'up':'down';
        $data['this_year']        = $this_year;

        // THIS MONTH
        $date_month_end           = date('Y-m-d', strtotime(date("Y-m-01")."-1 day"));
        $date_month_start         = date('Y-m-d', strtotime(date("Y-m-01")."-1 month"));
        $last_month               = $this->home_model->get_invoices_count_total($date_month_start, $date_month_end, false, false, $currency);
        $date_month_end           = date('Y-m-d', strtotime(date("Y-m-01")." +1 month -1 day"));
        $this_month               = $this->home_model->get_invoices_count_total(date("Y-m-01"), $date_month_end, false, false, $currency);
        if( $this_month["total"] == 0 && $last_month["total"] == 0 ){
            $this_month['percent'] = 0;
        }elseif( $this_month["total"] == 0 ){
            $this_month['percent'] = -100;
        }else{
            $this_month['percent'] = min(100,($this_month["total"] - $last_month["total"])*100 /$this_month["total"]) ;
        }
        if( $this_month['percent'] < 100 ){
            $this_month['percent'] = max(-100, $this_month['percent']);
        }
        $this_month['arrow'] = ($this_month['percent'] >= 0)?'up':'down';
        $data['this_month']       = $this_month;


        // TODAY
        $yesterday                = date('Y-m-d', strtotime(date("Y-m-d")."-1 day"));
        $yesterday                = $this->home_model->get_invoices_count_total($yesterday, $yesterday, false, false, $currency);
        $today                    = $this->home_model->get_invoices_count_total(date("Y-m-d"), date("Y-m-d"), false, false, $currency);
        if( $today["total"] == 0 && $yesterday["total"] == 0 ){
            $today['percent'] = 0;
        }elseif( $today["total"] == 0 ){
            $today['percent'] = -100;
        }else{
            $today['percent'] = min(100,($today["total"] - $yesterday["total"])*100 /$today["total"] );
        }
        if( $today['percent'] < 100 ){
            $today['percent'] = max(-100, $today['percent']);
        }
        $today['arrow'] = ($today['percent'] >= 0)?'up':'down';
        $data['today']            = $today;


        $overdue_where = array(
            "(status"=>"'overdue' OR ((`status`='unpaid' OR `status`='partial') AND `date_due`<'".date("Y-m-d")."') )"
        );
        $data['overdue']          = $this->home_model->get_invoices_count_total(false, false, $overdue_where, false, $currency);

        $unpaid_where = array(
            "(status"=>"'unpaid' AND (`date_due`>='".date("Y-m-d")."' OR `date_due` IS NULL))",
        );
        $data['unpaid']           = $this->home_model->get_invoices_count_total(false, false, $unpaid_where, false, $currency);

        $data['paid']             = $this->home_model->get_invoices_count_total(false, false, array("status"=>"paid"), true, $currency);

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function getReportRangeChart(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $start_date        = $this->input->post("start");
        $end_date          = $this->input->post("end");
        $currency          = $this->input->post("currency");
        $invoices          = $this->home_model->invoices_per_date($start_date, $end_date, $currency);
        $dates_obj         = getDates($start_date, $end_date);
        $status_list       = $this->settings_model->getInvoiceStatus();
        $values            = array();
        $dates             = $dates_obj->dates;
        $Colors1           = ['#B08110','#41af67','#2176B0','#C33E5A','#0c0c0c','#a2a2a2','#4d9ca0'];
        $Colors2           = ['rgba(255, 206, 86,0.2)', 'rgba(77, 189, 116,0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(31, 31, 31,0.2)', 'rgba(180, 180, 180,0.2)', 'rgba(94, 200, 206,0.2)' ];
        $series            = array();
        $index             = 0;
        foreach ($status_list as $status => $status_label) {
            $data = array();
            foreach ($invoices as $invoice) {
                if( $status == $invoice->status ){
                    $data[] = $invoice;
                }
            }
            $series[] = array(
                "label" => $status_label,
                "data" => $data,
                "borderColor" => $Colors1[$index],
                "backgroundColor" => $Colors2[$index++]
                );
        }
        foreach ($series as $key => $serie) {
            $data = array();
            foreach ($dates as $date) {
                $total = 0;
                foreach ($serie['data'] as $invoice) {
                    if( strtotime($invoice->date) >= strtotime($date->start) && strtotime($invoice->date) <= strtotime($date->end) ){
                        $total += floatval($invoice->total);
                    }
                }
                $data[] = $total;
            }
            $series[$key]['data'] = $data;
        }

        $result['dates']   = $dates_obj;
        $result['values']  = $series;
        $this->output->set_content_type('application/json')->set_output( json_encode($result));
    }

    /* EXCHANGE */
    public function exchange(){
        if ( !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $data['page_title']      = lang("exchange");
        $data['page_subheading'] = lang("exchange_subheading");
        $this->load->view('global/exchange' , $data);
    }

    /* CHAT */
    public function getMessage_count(){
        if ( !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $counter = $this->home_model->count_all_message_not_read();
        $this->output->set_content_type('application/json')->set_output(json_encode($counter));
    }

    public function getConversation_with_user()
    {
        if ( !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $user_id = $this->input->post('user_id');
        $page = $this->input->post('page');
        $my_user_id = USER_ID;
        $array = $this->home_model->getConversation($my_user_id, $user_id, $page);
        $smileys_path = site_url("assets/media/chat-smileys/");
        $this->load->helper('smiley');
        foreach ($array as $key => $value) {
            $array[$key]['content'] = parse_smileys($value['content'], $smileys_path);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($array));
    }

    public function delete_conversation()
    {
        if ( !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $user_id = $this->input->post('user_id');
        $my_user_id = USER_ID;
        $array = $this->home_model->deleteConversation($my_user_id, $user_id);
        $this->output->set_content_type('application/json')->set_output(json_encode($array));
    }

    public function send_message()
    {
        if ( !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $content = $this->input->post('content');
        $to = $this->input->post('to');
        $from = USER_ID;
        $array = $this->home_model->send_message($from, $to, $content);
    }

    public function getUsersOnline()
    {
        if ( !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if( !$this->ion_auth->is_admin() ){
            $array = $this->home_model->getUsersOnline($this->settings_model->SYS_Settings->chat_support_id);
        }else{
            $array = $this->home_model->getUsersOnline();
        }
        $smileys_path = site_url("assets/media/chat-smileys/");
        $this->load->helper('smiley');
        foreach ($array as $key => $value) {
            $array[$key]['last_message'] = parse_smileys($value['last_message'], $smileys_path);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($array));
    }

    /*
     * NOTIFICATIONS
     */
    public function getNotifications()
    {
        if ( !$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if( $this->ion_auth->is_admin() ){
            $result = $this->home_model->getNotifications(true);
        }elseif( $this->ion_auth->in_group(array("customer", "supplier")) ){
            $result = $this->home_model->getNotifications(false,true);
        }else{
            $result = $this->home_model->getNotifications();
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
}
