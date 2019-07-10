<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar_model extends CI_Model {
    var $table = "calendar";

    public function __construct ()
    {
        parent::__construct ();
    }

    public function getByID ($id)
    {
        $q = $this->db->get_where ( $this->table , array ( 'id' => $id ) , 1 );
        if ( $q->num_rows () > 0 ) {
            return $q->row ();
        }
        return false;
    }

    public function add ($data = array ())
    {
        if ( $this->db->insert ( $this->table , $data ) ) {
            $id = $this->db->insert_id ();
            return $id;
        }
        return false;
    }

    public function update ($id , $data = array ())
    {
        if ( $this->db->where ( 'id' , $id )->update ( $this->table , $data ) ) {
            return $id;
        }
        return false;
    }

    public function delete ($id)
    {
        if ( $this->db->where ( 'id' , $id )->delete ( $this->table ) ) {
            return true;
        }
        return false;
    }

    public function moveshow ($id , $day)
    {
        $this->db->set ( 'start_date' , 'DATE_ADD(start_date, INTERVAL ' . $day . ' DAY)' , false );
        $this->db->where ( 'id' , $id );
        if ( $this->db->update ( $this->table ) ) {
            return $id;
        }
        return false;
    }

    public function events_feed ($start_timestamp , $end_timestamp)
    {
        define ( "DAY_VALUE" , 3600 * 24 );
        define ( "WEEK_VALUE" , 3600 * 24 * 7 );
        $q = $this->db->select ("*")
            ->from ( $this->table )
            ->where ( "(start_date >= '$start_timestamp' AND start_date < '$end_timestamp')", "", false )
            ->or_where ( "(start_date < '$end_timestamp' AND end_date is NULL AND repeat_type<>'-1')", "", false)
            ->or_where ( "(start_date < '$end_timestamp' AND end_date >= '$start_timestamp' AND repeat_type<>'-1')", "", false)
            ->order_by ( 'start_date' )
            ->get ();
        if ( $q->num_rows () > 0 ) {
            $rows = $q->result ();
            $result = array ();
            foreach ( $rows as $key => $row ) {
                if( $row->repeat_type == -1 ){
                    $show = array (
                        "id" => intval ( $row->id ) ,
                        "title" => $row->name ,
                        "start" => $row->start_date ,
                        "repeat_type" => $row->repeat_type ,
                        "editable" => true ,
                    );
                    $result[] = $show;

                } elseif ( $row->repeat_type == 2 ) { // monthly
                    if ( $row->end_date == null ) {
                        $e = min(strtotime($end_timestamp), strtotime ( $start_timestamp . "+2 months" ));
                    } else {
                        $e = min(strtotime($end_timestamp), strtotime ( $row->end_date ));
                    }
                    $check_date = max(strtotime($start_timestamp), strtotime($row->start_date));
                    while ($check_date <= $e) {
                        if ( date ( "d" , $check_date ) == date ( "d" , strtotime ( $row->start_date ) ) ) {
                            $show_start = date ( 'Y-m-d' , $check_date );
                            $result[] = array (
                                "id" => intval ( $row->id ) ,
                                "title" => $row->name ,
                                "start" => $show_start ,
                                "repeat_type" => $row->repeat_type ,
                                "editable" => true ,
                            );
                        }
                        $check_date = strtotime(date("Y-m-d", $check_date)." +1 day");
                    }
                } elseif ( $row->repeat_type == 6 ) { // yearly
                    if ( $row->end_date == null ) {
                        $e = min(strtotime($end_timestamp), strtotime ( $start_timestamp . "+2 years" ));
                    } else {
                        $e = min(strtotime($end_timestamp), strtotime ( $row->end_date ));
                    }
                    $check_date = max(strtotime($start_timestamp), strtotime($row->start_date));
                    while ($check_date <= $e) {
                        if ( date ( "m-d" , $check_date ) == date ( "m-d" , strtotime ( $row->start_date ) ) ) {
                            $show_start = date ( 'Y-m-d' , $check_date );
                            $result[] = array (
                                "id" => intval ( $row->id ) ,
                                "title" => $row->name ,
                                "start" => $show_start ,
                                "repeat_type" => $row->repeat_type ,
                                "editable" => true ,
                            );
                        }
                        $check_date = strtotime(date("Y-m-d", $check_date)." +1 day");
                    }
                }else{ // weekly
                    $repeat_days = explode ( "," , $row->repeat_days );
                    $onetime = true;
                    $s = strtotime ( $row->start_date );
                    if ( $row->end_date == null ) {
                        $e = strtotime ( $start_timestamp . "+2 months" );
                        $onetime = false;
                    } else {
                        $e = strtotime ( $row->end_date );
                    }
                    $check_date = $s;
                    switch ($row->repeat_type) {
                        case 0: $m = 7; break;
                        case 1: $m = 14; break;
                        case 4: $m = 21; break;
                        case 5: $m = 28; break;
                    }
                    while ($check_date <= $e) {
                        $d = (($check_date - $s) / DAY_VALUE) % $m;
                        $add = true;
                        if ( $d >= 7 ) {
                            $add = false;
                        }
                        if ( $add && in_array ( date ( "w" , $check_date ) , $repeat_days ) ) {
                            $show_start = date ( 'Y-m-d' , $check_date  );
                            $result[] = array (
                                "id" => intval ( $row->id ) ,
                                "title" => $row->name ,
                                "start" => $show_start ,
                                "repeat_type" => $row->repeat_type ,
                                "editable" => true ,
                            );
                        }
                        $check_date = strtotime(date("Y-m-d", $check_date)." +1 day");
                    }
                }
            }
            return $result;
        }
        return array ();
    }

    public function send_reminders(){
        $date = date("Y-m-d");
        $where_clause =
            "(`start_date`='$date' AND `repeat_type`='-1' AND (`last_send`<>'$date' OR `last_send` is NULL))". // no repeat

            "OR (`start_date`<='$date' AND `repeat_type`='2' AND DAY(`start_date`)='".date("d", strtotime($date))."' AND (`end_date` is NULL OR `end_date` >= '$date') AND (`last_send`<>'$date' OR `last_send` is NULL))". // monthly

            "OR (`start_date`<='$date' AND `repeat_type`='6' AND DAY(`start_date`)='".date("d", strtotime($date))."' AND MONTH(`start_date`)='".date("m", strtotime($date))."' AND (`end_date` is NULL OR `end_date` >= '$date') AND (`last_send`<>'$date' OR `last_send` is NULL))". // yearly

            "OR (`start_date`<='$date' AND `repeat_type`<>'-1' AND `repeat_type`<>'2' AND `repeat_type`<>'6' AND FIND_IN_SET('".date("w", strtotime($date))."',`repeat_days`) AND (`end_date` is NULL OR `end_date` >= '$date') AND (`last_send`<>'$date' OR `last_send` is NULL))". // weekly
        "";

        $q = $this->db->select ("*")
            ->from ( $this->table )
            ->where ( $where_clause )
            ->order_by ( 'start_date' )
            ->get ();

        if ( $q->num_rows () > 0 ) {
            $rows = $q->result ();
            $this->output->set_content_type('application/json')->set_output(json_encode($rows));
            foreach ($rows as $row) {
                $this->load->library(array('email'));
                $email_config = objectToArray($this->settings_model->email_Settings);
                $data['email_content'] = $row->additional_content;
                $message = $this->load->view("email/standard.tpl.php", $data, true);
                $this->email->initialize($email_config);
                $this->email->clear();
                $this->email->from(COMPANY_EMAIL, COMPANY_NAME);
                $this->email->to($row->emails);
                $this->email->subject($row->subject);
                $this->email->message($message);
                if( !empty(trim($row->attachments)) ){
                    $this->load->model('files_model');
                    $files = $this->files_model->getByID(json_decode($row->attachments));
                    foreach ($files as $file) {
                        $this->email->attach(realpath($file->realpath));
                    }
                }
                $this->email->send();
                $this->db->set('last_send',$date)->where('id',$row->id)->update($this->table);
            }
        }
    }

}

/* End of file Calendar_model.php */
/* Location: ./application/models/Calendar_model.php */
