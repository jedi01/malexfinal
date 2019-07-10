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

class Sis_logger
{
    protected $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
    }

    public function getSystemUser(){
        $q = $this->ci->db->select("id")->limit(1)->get("users");
        if ( $q->num_rows () > 0 ) {
            return $q->row()->id;
        }
        return 1;
    }

    public function write($controller, $method, $param, $message){
        $user_id = defined("USER_ID")?USER_ID:$this->getSystemUser();
        $user_name = defined("USER_NAME")?USER_NAME:"SYSTEM";
        $data = array(
            "date"       => date("Y-m-d H:i:s"),
            "user_id"    => $user_id,
            "username"   => $user_name,
            "controller" => $controller,
            "method"     => $method,
            "param"      => $param,
            "content"    => $message,
        );
        if( is_array($param) ){
            $data_batch = array();
            foreach ($param as $param_row) {
                $data['param'] = $param_row;
                $data_batch[] = $data;
            }
            $this->ci->db->insert_batch("log", $data_batch);
        }else{
            $this->ci->db->insert("log", $data);
        }
    }

    public function getLogs ($controller, $param)
    {
        $result = array();
        $q = $this->ci->db
                    ->where('controller', $controller)
                    ->where('param', $param)
                    ->order_by('date', 'desc')
                    ->order_by('id', 'desc')
                    ->get ( "log" );
        if ( $q->num_rows () > 0 ) {
            $result = $q->result();
            foreach ($result as $key => $activity) {
                if( $activity->method == 'update' ){
                    $result[$key]->icon = 'pencil';
                    $result[$key]->bg = 'bg-success';
                }elseif( $activity->method == 'delete' ){
                    $result[$key]->icon = 'trash';
                    $result[$key]->bg = 'bg-danger';
                }elseif( $activity->method == 'create' ){
                    $result[$key]->icon = 'check';
                    $result[$key]->bg = 'bg-info';
                }elseif( $activity->method == 'email' ){
                    $result[$key]->icon = 'envelope';
                    $result[$key]->bg = 'bg-warning';
                }elseif( $activity->method == 'clone' ){
                    $result[$key]->icon = 'copy';
                    $result[$key]->bg = '';
                }elseif( $activity->method == 'make_payment' ){
                    $result[$key]->icon = 'money';
                    $result[$key]->bg = 'bg-info';
                }elseif( $activity->method == 'update_payment' ){
                    $result[$key]->icon = 'money';
                    $result[$key]->bg = 'bg-success';
                }elseif( $activity->method == 'delete_payment' ){
                    $result[$key]->icon = 'money';
                    $result[$key]->bg = 'bg-danger';
                }elseif( $activity->method == 'start' ){
                    $result[$key]->icon = 'play';
                    $result[$key]->bg = 'bg-success';
                }elseif( $activity->method == 'cancel' ){
                    $result[$key]->icon = 'times-circle';
                    $result[$key]->bg = '';
                }elseif( $activity->method == 'skip' ){
                    $result[$key]->icon = 'forward';
                    $result[$key]->bg = 'bg-warning';
                }else{
                    $result[$key]->icon = 'dot-circle-o';
                    $result[$key]->bg = '';
                }
            }
        }
        return $result;
    }
}

/* End of file Sis_logger.php */
/* Location: ./application/libraries/Sis_logger.php */
