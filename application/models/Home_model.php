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

class Home_model extends CI_Model
{

    public function __construct ()
    {
        parent::__construct ();
        $this->load->helper('app');
    }

    public function get_invoices_count_total ($start_date = FALSE, $end_date = FALSE, $term = FALSE, $slashes = TRUE, $currency = false)
    {
        if( $start_date != FALSE ){
            $this->db->where('invoices.date >= ', $start_date);
        }
        if( $end_date != FALSE ){
            $this->db->where('invoices.date <= ', $end_date);
        }
        if( $currency != FALSE ){
            $this->db->where('invoices.currency', $currency);
        }
        if( defined("BILLER_ID") ){
            $this->db->where("invoices.bill_to_id", BILLER_ID);
        }
        if( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() ){
            $this->db->where("invoices.user_id", USER_ID);
        }
        if( $term != FALSE ){
            foreach ($term as $key => $value) {
                $this->db->where($key, $value, $slashes);
            }
        }
        $q = $this->db->select("COUNT(invoices.id) as number, SUM(invoices.total) as total")
                      ->get ( "invoices" );
        if ( $q->num_rows () > 0 ) {
            $r = $q->row_array();
            if( $r['total'] == null ){
                $r['total'] = 0;
            }
            return $r;
        }
        return array("number"=>0, "total"=>0);
    }

    public function last_invoices ($currency = FALSE)
    {
        if( $currency != FALSE ){
            $this->db->where('invoices.currency', $currency);
        }
        if( defined("BILLER_ID") ){
            $this->db->where("invoices.bill_to_id", BILLER_ID);
        }
        if( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() ){
            $this->db->where("invoices.user_id", USER_ID);
        }
        $q = $this->db
            ->from ( "invoices" )
            ->limit(5)
            ->order_by("id", 'desc')
            ->get();
        if ( $q->num_rows () > 0 ) {
            return $q->result();
        }
        return array();
    }

    public function overview_chart ($start_date = FALSE, $end_date = FALSE, $currency = FALSE)
    {
        if( $start_date != FALSE ){
            $this->db->where('invoices.date >= ', $start_date);
        }
        if( $end_date != FALSE ){
            $this->db->where('invoices.date <= ', $end_date);
        }
        if( $currency != FALSE ){
            $this->db->where('invoices.currency', $currency);
        }
        $status = $this->settings_model->getInvoiceStatus();
        $where = "";
        if( defined("BILLER_ID") ){
            $where = "WHERE bill_to_id='".BILLER_ID."'";
        }
        if( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() ){
            if( empty($where) ){
                $where = "WHERE invoices.user_id='".USER_ID."'";
            }else{
                $where .= " AND invoices.user_id='".USER_ID."'";
            }
        }
        $labels = $data = array();
        $q = $this->db->select("status, COUNT(id) as number, currency, date")
                      ->from("(SELECT IF((invoices.status='unpaid' OR invoices.status='partial') AND invoices.date_due<'".date("Y-m-d")."', 'overdue', invoices.status) as status, id, invoices.currency, date FROM invoices $where) invoices")
                      ->group_by("status")
                      ->get ();
        if ( $q->num_rows () > 0 ) {
            $res = $q->result();
            foreach ($status as $key => $status) {
                $exist = false;
                foreach ($res as $value) {
                    if( $value->status == $key ){
                        $labels [] = $status;
                        $data [] = $value->number;
                        $exist = true;
                        break;
                    }
                }
                if( !$exist ){
                    $labels [] = $status;
                    $data [] = 0;
                }
            }
            return array("data"=>$data, "labels"=>$labels);
        }
        return array("data"=>$data, "labels"=>$labels);
    }

    public function invoices_per_date ($start_date = FALSE, $end_date = FALSE, $currency = FALSE)
    {
        if( $start_date != FALSE ){
            $this->db->where('invoices.date >= ', $start_date);
        }
        if( $end_date != FALSE ){
            $this->db->where('invoices.date <= ', $end_date);
        }
        if( $currency != FALSE ){
            $this->db->where('invoices.currency', $currency);
        }
        $where = "";
        if( defined("BILLER_ID") ){
            $where = "WHERE bill_to_id='".BILLER_ID."'";
        }
        if( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() ){
            if( empty($where) ){
                $where = "WHERE invoices.user_id='".USER_ID."'";
            }else{
                $where .= " AND invoices.user_id='".USER_ID."'";
            }
        }
        $q = $this->db
            ->select ( "date, sum(total) total, status, currency" )
            ->from("(SELECT date, total, IF((invoices.status='unpaid' OR invoices.status='partial') AND invoices.date_due<'".date("Y-m-d")."', 'overdue', invoices.status) as status, invoices.currency FROM invoices $where) invoices")
            ->group_by("date,status")
            ->get();
        if ( $q->num_rows () > 0 ) {
            return $q->result();
        }
        return array();
    }

    /* CHAT */
    public function count_all_message_not_read(){
        $q = $this->db
                ->select('count(chat_messages.id) as counter', FALSE)
                ->from('chat_messages')
                ->where('chat_messages.to', USER_ID )
                ->where('chat_messages.read', 0)
                ->get();
        if( $q->num_rows() > 0 ){
            return $q->row()->counter;
        }
        return 0;
    }

    public function getConversation($id_user1, $id_user2, $page = 0){
        $this->update_attempts();
        $page_limit = 10;
        $q = $this->db
                ->select('chat_messages.id as id, chat_messages.from as user_id, users.username as user_name, chat_messages.date_read as message_time, chat_messages.content as content', FALSE)
                ->from('chat_messages')
                ->join("users", "users.id=chat_messages.from ", "left")
                ->where('( chat_messages.from = \''.$id_user1.'\' AND chat_messages.to = \''.$id_user2.'\' )' )
                ->or_where('( chat_messages.to = \''.$id_user1.'\' AND chat_messages.from = \''.$id_user2.'\' )' )
                ->order_by('chat_messages.date','desc')
                ->limit($page_limit, $page*$page_limit)
                ->get();
        if( $q->num_rows() > 0 ){
            $messages = $q->result_array();
            $ids = array();
            foreach ($messages as $key => $value) {
                $ids[] = $value['id'];
                $messages[$key]['message_time'] = $this->getTime_ago($value['message_time']);
            }
            $this->read_message($ids);
            return $messages;
        }
        return array();
    }

    public function deleteConversation($id_user1, $id_user2){
        $this->update_attempts();
        $q = $this->db
                ->where('( chat_messages.from = \''.$id_user1.'\' AND chat_messages.to = \''.$id_user2.'\' )' )
                ->or_where('( chat_messages.to = \''.$id_user1.'\' AND chat_messages.from = \''.$id_user2.'\' )' )
                ->delete('chat_messages');
        if( $q ){
            return true;
        }
        return false;
    }

    public function read_message($ids)
    {
        $this->update_attempts();
        $update_data = array(
            'read' => 1,
            'date_read' =>  date('Y-m-d H:i:s')
            );
        $this->db->where_in('id', $ids)->where('read', 0)->where('to', USER_ID);
        if( $this->db->update('chat_messages', $update_data)){
            return TRUE;
        }
        return FALSE;
    }

    public function getConversationComplete($id_user1, $id_user2){
        $q = $this->db
                ->select('chat_messages.id as id, chat_messages.from as user_id, users.username as user_name, chat_messages.date_read as message_time, chat_messages.content as content', FALSE)
                ->from('chat_messages')
                ->join("users", "users.id=chat_messages.from ", "left")
                ->where('( chat_messages.from = \''.$id_user1.'\' AND chat_messages.to = \''.$id_user2.'\' )' )
                ->or_where('( chat_messages.to = \''.$id_user1.'\' AND chat_messages.from = \''.$id_user2.'\' )' )
                ->order_by('chat_messages.date','desc')
                ->get();

        if( $q->num_rows() > 0 ){
            $messages = $q->result_array();
            foreach ($messages as $key => $value) {
                $messages[$key]['message_time'] = $this->getTime_ago($value['message_time']);
            }
            return $messages;
        }
        return array();
    }

    public function send_message($from, $to, $content, $is_offline = false)
    {
        $this->update_attempts();
        $insert_data = array(
            'from' => $from,
            'to' => $to,
            'content' => $content,
            'offline' => $is_offline,
            'date' => date('Y-m-d H:i:s')
            );
        if( $this->db->insert('chat_messages', $insert_data)){
            return TRUE;
        }
        return FALSE;
    }

    public function getUsersOnline($id = false){
        $this->update_attempts();
        if( $id ){
            $this->db->where('users.id', $id);
        }
        $q = $this->db
                ->select('users.id as id, users.username as name, IF((UNIX_TIMESTAMP()-chat_attempts.time)<300, 1, 0) as online, group_id', FALSE)
                ->from('users')
                ->join("chat_attempts", "chat_attempts.user_id=users.id", "left")
                ->join("users_groups", "users.id=users_groups.user_id", "left")
                ->where('users.id <> ', USER_ID)
                ->order_by("users_groups.group_id")
                ->get();
        if( $q->num_rows() > 0 ){
            $users = $q->result_array();
            foreach ($users as $key => $user) {
                $getLastMessageFrom = $this->getLastMessageFrom($user['id']);
                $users[$key]["last_message"] = $getLastMessageFrom['last_message'];
                $users[$key]["last_message_old"] = $getLastMessageFrom['last_message_old'];
                $users[$key]["new_message_number"] =  $this->count_message_not_read($user['id']);
            }
            return $users;
        }
        return array();
    }

    public function count_message_not_read($id_user){
        $q = $this->db
                ->select('count(chat_messages.id) as compter', FALSE)
                ->from('chat_messages')
                ->where('( chat_messages.from = \''.$id_user.'\' AND chat_messages.to = \''.USER_ID.'\' )' )
                ->where('chat_messages.read', 0)
                ->order_by('chat_messages.date','desc')
                ->get();
        if( $q->num_rows() > 0 ){
            return $q->row()->compter;
        }
        return 0;
    }

    public function getLastMessageFrom($id_user){
        $q = $this->db
                ->select('chat_messages.date as last_message_old, chat_messages.content as last_message', FALSE)
                ->from('chat_messages')
                ->where('( chat_messages.from = \''.$id_user.'\' AND chat_messages.to = \''.USER_ID.'\' )' )
                ->order_by('chat_messages.date','desc')
                ->limit(1)
                ->get();
        if( $q->num_rows() > 0 ){
            $last_message = $q->row_array();
            $last_message['last_message_old'] = $this->getTime_ago($last_message['last_message_old'], 1);
            return $last_message;
        }
        return array(
            "last_message" => "",
            "last_message_old" => ""
            );
    }

    public function update_attempts(){
        $q = $this->db->where('user_id', USER_ID)->get('chat_attempts');
        if( $q->num_rows() > 0 ){
            $data = array('time' => time());
            $this->db->where('user_id', USER_ID);
            $this->db->update('chat_attempts', $data);
        }else{
            $data = array('time' => time(), 'user_id'=>USER_ID);
            $this->db->insert('chat_attempts', $data);
        }
    }

    public function getTime_ago($datetime, $cmlx = 2){
        if( $datetime == NULL ){
            return "Not read";
        }
        $now = time();
        $time = strtotime($datetime);
        $def = timespan($time, $now);

        $tbl = explode(', ', $def);
        if( $cmlx == 2 ){
            if( count($tbl) > 1 ){
                return $tbl[0].', '.$tbl[1];
            }else{
                return $tbl[0];
            }
        }else{
            return $tbl[0];
        }
    }

    /*
     * NOTIFICATIONS
     */
    public function getNotifications($is_admin = false, $is_customer = false){
        $notifications = array();
        if( $is_customer ){
            // estimates
            $q = $this->db->select('estimates.reference as ref, estimates.id as id', FALSE)
                    ->where('estimates.status', "sent")
                    ->where('estimates.bill_to_id', BILLER_ID)
                    ->get('estimates');
            if( $q->num_rows() > 0 ){
                $estimates = $q->result();
                foreach ($estimates as $key => $estimate) {
                    $notifications[] = array(
                        "label" => lang("estimate")." [".$estimate->ref."]",
                        "link"  => site_url("/estimates/open/".$estimate->id),
                    );
                }
            }
            // invoices
            $q = $this->db->select('reference as ref, id, inv_status', FALSE)
                    ->where('inv_status IN', "('unpaid', 'overdue')", false)
                    ->where('bill_to_id', BILLER_ID)
                    ->get("(SELECT invoices.*, IF((invoices.status='unpaid' OR invoices.status='partial') AND invoices.date_due<'".date("Y-m-d")."', 'overdue', invoices.status) as inv_status FROM invoices) as tabla");
            if( $q->num_rows() > 0 ){
                $invoices = $q->result();
                foreach ($invoices as $key => $invoice) {
                    $notifications[] = array(
                        "label" => lang("invoice")." [".$invoice->ref."] ".lang($invoice->inv_status),
                        "link"  => site_url("/invoices/open/".$invoice->id),
                    );
                }
            }
        }
        if( !$is_customer ){
            // invoices
            if( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() ){
                $this->db->where("user_id", USER_ID);
            }
            $q = $this->db->select('reference as ref, id, inv_status', FALSE)
                    ->where('inv_status', "overdue")
                    ->get("(SELECT invoices.*, IF((invoices.status='unpaid' OR invoices.status='partial') AND invoices.date_due<'".date("Y-m-d")."', 'overdue', invoices.status) as inv_status FROM invoices) as tabla");
            if( $q->num_rows() > 0 ){
                $invoices = $q->result();
                foreach ($invoices as $key => $invoice) {
                    $notifications[] = array(
                        "label" => lang("invoice")." [".$invoice->ref."] ".lang($invoice->inv_status),
                        "link"  => site_url("/invoices/open/".$invoice->id),
                    );
                }
            }
            //estimates
            if( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() ){
                $this->db->where("estimates.user_id", USER_ID);
            }
            $q = $this->db->select('estimates.reference as ref, estimates.id as id', FALSE)
                    ->where('estimates.status', "accepted")
                    ->get('estimates');
            if( $q->num_rows() > 0 ){
                $estimates = $q->result();
                foreach ($estimates as $key => $estimate) {
                    $notifications[] = array(
                        "label" => lang("estimate")." [".$estimate->ref."] ".lang("accepted"),
                        "link"  => site_url("/estimates/open/".$estimate->id),
                    );
                }
            }
            // payments
            if( !USER_ALL_PRIVILEGES && $this->ion_auth->is_member() ){
                $this->db->where("invoices.user_id", USER_ID);
            }
            $q = $this->db->select('payments.number, payments.amount, invoices.currency', FALSE)
                    ->where('payments.status', "panding")
                    ->join('invoices', "invoices.id=payments.invoice_id")
                    ->get('payments');
            if( $q->num_rows() > 0 ){
                $payments = $q->result();
                foreach ($payments as $key => $payment) {
                    $notifications[] = array(
                        "label" => lang("payment")." [".$payment->amount." ".$payment->currency."] ".lang("panding"),
                        "link"  => site_url("/payments?f=number&fv=".$payment->number),
                    );
                }
            }
            // projects list
            $q = $this->db->select('name, id')
                    ->where("user_id", USER_ID)
                    ->where("date_due <", date("Y-m-d"))
                    ->where("status <>", "finished")
                    ->get("projects");
            if( $q->num_rows() > 0 ){
                $projects = $q->result();
                foreach ($projects as $key => $project) {
                    $label = strlen($project->name)<18?$project->name:substr($project->name, 0,15)."...";
                    $notifications[] = array(
                        "label" => lang("project")." [".$label."] ".lang("overdue"),
                        "link"  => site_url("/projects/open/".$project->id),
                    );
                }
            }
            // projects tasks
            $q = $this->db->select('subject, id, project_id')
                    ->where("user_id", USER_ID)
                    ->where("date_due <", date("Y-m-d"))
                    ->where("status <>", "complete")
                    ->get("projects_tasks");
            if( $q->num_rows() > 0 ){
                $tasks = $q->result();
                foreach ($tasks as $key => $task) {
                    $label = strlen($task->subject)<18?$task->subject:substr($task->subject, 0,15)."...";
                    $notifications[] = array(
                        "label" => lang("task")." [".$label."] ".lang("overdue"),
                        "link"  => site_url("/projects/open/".$task->project_id),
                    );
                }
            }
        }
        // todo list
        $q = $this->db->select('subject, id')
                ->where("user_id", USER_ID)
                ->where("date_due <", date("Y-m-d"))
                ->where("complete", false)
                ->get("todo");
        if( $q->num_rows() > 0 ){
            $todo_list = $q->result();
            foreach ($todo_list as $key => $task) {
                $label = strlen($task->subject)<18?$task->subject:substr($task->subject, 0,15)."...";
                $notifications[] = array(
                    "label" => lang("todo_task")." [".$label."] ".lang("overdue"),
                    "link"  => site_url("/todo/index?f=subject&fv=".$task->subject),
                );
            }
        }

        return $notifications;
    }
}

/* End of file Home_model.php */
/* Location: ./application/models/Home_model.php */
