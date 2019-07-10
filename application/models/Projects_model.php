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

class Projects_model extends CI_Model
{
    var $table = "projects";

    public function __construct ()
    {
        parent::__construct ();
    }

    public function getAll ()
    {
        $q = $this->db->get ( $this->table );
        if ( $q->num_rows () > 0 ) {
            return $q->result_array ();
        }
        return array ();
    }

    public function count ()
    {
        return $this->db->count_all ( $this->table );
    }

    public function getByID ($id)
    {
        $q = $this->db->get_where ( $this->table , array ( 'id' => $id ) , 1 );
        if ( $q->num_rows () > 0 ) {
            return $q->row ();
        }
        return false;
    }

    public function getByColumn ($column , $value)
    {
        $q = $this->db->get_where ( $this->table , array ( $column => $value ) );
        if ( $q->num_rows () > 0 ) {
            return $q->result ();
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
        $this->db->where_in('project_id', $id)->delete("projects_tasks");
        if ( $this->db->where_in ( 'id' , $id )->delete ( $this->table ) ) {
            return true;
        }
        return false;
    }

    public function getProjectsEmails ($id_list = array())
    {
        $q = $this->db
                ->select("email")
                ->join("biller", "biller.id=projects.biller_id", "left")
                ->where_in("projects.id", $id_list)
                ->group_by("email")
                ->get ( $this->table );
        if ( $q->num_rows () > 0 ) {
            $result = array();
            foreach ($q->result() as $key => $value) {
                $result[] = $value->email;
            }
            return $result;
        }
        return array();
    }

    public function getAllMembers ()
    {
        $q = $this->db->select("users.*")
                ->join("users_groups", "users_groups.user_id=users.id")
                ->where("users_groups.group_id", "2")
                ->get("users");
        if ( $q->num_rows () > 0 ) {
            $res = array();
            foreach ($q->result() as $row) {
                if( $row->first_name != "" && $row->last_name != "" ){
                    $res[$row->id] = $row->first_name." ".$row->last_name;
                }else{
                    $res[$row->id] = $row->username;
                }
            }
            return $res;
        }
        return array ();
    }

    // Tasks
    public function getAllTasks ($project_id)
    {
        $q = $this->db->where('project_id', $project_id)->get("projects_tasks");
        if ( $q->num_rows () > 0 ) {
            return $q->result ();
        }
        return array ();
    }

    public function countTasks ($project_id, $status = false)
    {
        if( $status ){
            $this->db->where('status', $status);
        }
        $q = $this->db->where('project_id', $project_id)->get("projects_tasks");
        return $q->num_rows ();
    }

    public function overviewTasks ($project_id)
    {
        $q = $this->db
        ->select("status as label, count(id) as value")
        ->where('project_id', $project_id)
        ->group_by("status")
        ->get("projects_tasks");
        $status = $this->settings_model->getProjectTaskStatus();
        $data = array(); $labels = array();
        foreach ($status as $key => $value) {
            $data[] = 0;
            $labels[] = $value;
        }
        if ( $q->num_rows () > 0 ) {
            foreach ($q->result () as $row) {
                $data[array_search(lang($row->label), $labels)] = $row->value;
            }
            return array("labels"=>$labels, "data"=>$data);
        }
        return false;
    }

    public function getTaskByID ($id)
    {
        $q = $this->db->get_where("projects_tasks", array ( 'id' => $id ) , 1 );
        if ( $q->num_rows () > 0 ) {
            return $q->row ();
        }
        return false;
    }

    public function addTask ($data = array ())
    {
        if ( $this->db->insert ( "projects_tasks" , $data ) ) {
            $id = $this->db->insert_id ();
            return $id;
        }
        return false;
    }

    public function updateTask ($id , $data = array ())
    {
        if ( $this->db->where ( 'id' , $id )->update ( "projects_tasks" , $data ) ) {
            return $id;
        }
        return false;
    }

    public function deleteTask ($id)
    {
        if ( $this->db->where_in ( 'id' , $id )->delete ( "projects_tasks" ) ) {
            return true;
        }
        return false;
    }

    public function completeTask ($id)
    {
        if ( $this->db->where ( 'id' , $id )->update ( "projects_tasks" , array("status"=> "complete") ) ) {
            return $id;
        }
        return false;
    }

}

/* End of file projects_model.php */
/* Location: ./application/models/projects_model.php */
