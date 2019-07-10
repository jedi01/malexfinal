<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Files_model extends CI_Model {
    var $table = "files";

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

    public function fullsize ()
    {
        $this->db->_reset_select();
        $q = $this->db->select_sum ("size")
                    ->from( $this->table )
                    ->where ("user_id", USER_ID)
                    ->get();
        if ( $q->num_rows () > 0 ) {
            return $q->row ()->size;
        }
        return 0;
    }

    public function getByID ($id)
    {
        if( is_array($id) ){
            $q = $this->db->where_in('id', $id)->get( $this->table );
            if ( $q->num_rows () > 0 ) {
                return $q->result ();
            }
        }else{
            $q = $this->db->get_where ( $this->table , array ( 'id' => $id ) , 1 );
            if ( $q->num_rows () > 0 ) {
                return $q->row ();
            }
        }
        return false;
    }

    public function getFiles ($id)
    {
        if( is_array($id) ){
            $q = $this->db->where_in('id', $id)->get( $this->table );
        }else{
            $q = $this->db->get_where ( $this->table , array ( 'id' => $id ) , 1 );
        }
        if ( $q->num_rows () > 0 ) {
            return $q->result ();
        }
        return array();
    }

    public function getFilesByLinks ($links)
    {
        if( is_array($links) ){
            $q = $this->db->where_in('link', $links)->get( $this->table );
        }else{
            $q = $this->db->get_where ( $this->table , array ( 'link' => $links ) , 1 );
        }
        if ( $q->num_rows () > 0 ) {
            return $q->result ();
        }
        return array();
    }

    public function getByColumn ($column , $value)
    {
        $q = $this->db->get_where ( $this->table , array ( $column => $value ) );
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

    public function delete ($id_list)
    {
        if ( $this->db->where_in ( 'id' , $id_list )->update ( $this->table , array("trash"=>1) ) ) {
            return true;
        }
        return false;
    }

    public function restore ($id_list)
    {
        if ( $this->db->where_in ( 'id' , $id_list )->update ( $this->table , array("trash"=>0) ) ) {
            return true;
        }
        return false;
    }

    public function delete_definitive ($id_list)
    {
        $files = array();
        foreach ($id_list as $id) {
            $file = $this->getByID($id);
            $files[] = $file;
            if( $file->type == "folder" ){
                $folder_files = $this->getFolderFiles($file->filename, $file->folder);
                $files = array_merge($files, $folder_files);
            }
        }
        foreach ($files as $key => $file) {
            $this->deleteFile($file);
        }
        return true;
    }

    public function deleteFile ($file)
    {
        if( $file->type != "folder" ){
            unlink($file->realpath);
            if( $file->thumb != NULL && !empty($file->thumb) ){
                $path = substr($file->realpath, 0, strrpos($file->realpath, "/"));
                unlink($path."/".$file->thumb);
            }
        }
        if( $this->db->where ( 'id' , $file->id )->delete ( $this->table ) ){
            return true;
        }
        return false;
    }

    public function getFolderFiles ($filename = false, $folder = false)
    {
        if( $folder == "" ){
            $this->db->where ("`folder` = '$filename'", "", false);
            $this->db->or_where ("`folder` LIKE '$filename/%'", "", false);
        }else{
            $this->db->where ("`folder` = '$folder/$filename'", "", false);
            $this->db->or_where ("`folder` LIKE '$folder/$filename/%'", "", false);
        }
        $q = $this->db//->where ("`folder` = '".$folder."' AND `user_id`='".USER_ID."'","", false)
                //->or_where ("`folder` LIKE '".$folder."/%' AND `user_id`='".USER_ID."'","", false)
                //->or_where ("`folder` LIKE '%/".$foldername."/%' AND `user_id`='".USER_ID."'","", false)
                ->where ("user_id", USER_ID)
                ->get( $this->table );

        if ( $q->num_rows () > 0 ) {
            return $q->result ();
        }
        return array();
    }

    public function getAllFolders ($filename = false, $folder = false)
    {
        if( $filename ){
            $this->db->where ("`filename` <> '$filename'", "", false);
            if( $folder == "" ){
                $this->db->where ("`folder` <> '$filename'", "", false);
                $this->db->where ("`folder` NOT LIKE '$filename/%'", "", false);
            }else{
                $this->db->where ("`folder` <> '$folder/$filename'", "", false);
                $this->db->where ("`folder` NOT LIKE '$folder/$filename/%'", "", false);
            }
        }
        $q = $this->db->select ("filename, folder")
                ->where ("user_id",USER_ID)
                ->where ("type",'folder')
                ->get( $this->table );

        $result = array(""=>"Root");
        if ( $q->num_rows () > 0 ) {
            foreach ($q->result () as $row) {
                if( empty($row->folder) ){
                    $result[$row->filename] = $row->filename;
                }else{
                    $result[$row->folder."/".$row->filename] = $row->folder."/".$row->filename;
                }
            }
        }
        return $result;
    }

    public function move ($id_list, $from, $to)
    {
        $files = array();
        foreach ($id_list as $id) {
            $file = $this->getByID($id);
            $files[] = $file;
            if( $file->type == "folder" ){
                $folder_files = $this->getFolderFiles($file->filename, $file->folder);
                $files = array_merge($files, $folder_files);
            }
        }
        foreach ($files as $key => $file) {
            $this->moveFile($file, $from, $to);
        }
        return true;
    }

    public function moveFile ($file, $from, $to)
    {
        if( $from == "" && $to == "" ){
            return true;
        }elseif( $from == "" && $file->folder == "" ){
            $file->folder = $to;
        }elseif( $from == "" ){
            $file->folder = $to."/".$file->folder;
        }else{
            $file->folder = str_replace($from, $to, $file->folder);
        }

        if( $this->db->where("id", $file->id)->set( 'folder' , $file->folder )->update( $this->table ) ){
            return true;
        }
        return false;
    }

    public function create_thumb($filename, $fullpath){
        // create thumbnail
        $source_path = $fullpath . $filename;
        $target_path = $fullpath;
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $source_path,
            'new_image' => $target_path,
            'maintain_ratio' => FALSE,
            'create_thumb' => TRUE,
            'thumb_marker' => '_thumb',
            'width' => 150,
            'height' => 150,
            'quality' => '100%'
        );
        $this->load->library('image_lib', $config_manip);
        if ( !$this->image_lib->resize() ) {
            echo $this->image_lib->display_errors();
            return false;
        }
        // clear //
        $this->image_lib->clear();
        return true;
    }
}

/* End of file Files_model.php */
/* Location: ./application/models/Files_model.php */
