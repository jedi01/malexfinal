<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends MY_Controller {
    /**
     * Files constructor.
     */
    public function __construct ()
    {
        parent::__construct ();
        // Load Files Model
        $this->load->model ( 'files_model' );
        // Load Helper Language
        $this->load->helper('language');
        // Load Helper Date Format
        $this->load->helper('date_format');
        // Check user is logged in ?
        $ignored_methods = array("get", "view", "thumbnail", "download", "share");
        if ( !$this->ion_auth->logged_in () && !in_array($this->router->fetch_method(), $ignored_methods) ) {
            if ($this->input->is_ajax_request()) {
                $next_link = urlencode("/files");
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
        $meta['page_title']       = lang('files');
        $data['page_title']       = lang('files');
        $data['page_subheading']  = lang('files_subheading');
        $data['files_settings']   = $this->settings_model->FILES_settings;
        $this->load->library('user_agent');
        if($this->agent->is_mobile()){
            $data['small_view']       = true;
        }else{
            $data['small_view']       = false;
        }
        $data['selectable']       = false;

        $this->load->view ( 'templates/head' , $meta );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'files/files' , $data );
        $this->load->view ( 'templates/footer' , $meta );
    }

    public function select()
    {
        $data['message']          = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['success_message']  = $this->session->flashdata('success_message');
        $meta['page_title']       = lang('files');
        $data['page_title']       = lang('files');
        $data['page_subheading']  = lang('files_subheading');
        $data['files_settings']   = $this->settings_model->FILES_settings;
        $data['selectable']       = true;
        $data['small_view']       = true;

        $this->load->view ( 'files/files' , $data );
    }

    public function getData(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->load->library('datatables');
        $settings = $this->settings_model->FILES_settings;
        $is_trash = false;
        if( isset($_POST['current_folder']) ){
            if( $_POST['current_folder'] == "THIS_IS_TRASH_FOLDER" ){
                $is_trash = true;
            }else{
                $this->datatables->where("folder", $this->input->post("current_folder"));
            }
        }
        $this->datatables->where("user_id", USER_ID);
        $this->datatables->where("trash", $is_trash);
        $this->datatables
            ->setsColumns("checkbox,id,filename,size,date_upload,folder,type,extension,link,thumb")
            ->select("id as checkbox,id,filename,size,date_upload,folder,type,extension,link,thumb", false)
            ->from("files");
        $res = $this->datatables->generate();
        $res = json_decode($res);
        if( $is_trash ){
            foreach ($res->data as $file) {
                $file->folder = "THIS_IS_TRASH_FOLDER";
            }
        }
        $res->fullsize = floatval($this->files_model->fullsize());
        $res->maxsize = ($settings->user_disc_space)*1024*1024;
        $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }

    function upload()
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $settings = $this->settings_model->FILES_settings;
        $folder = ($this->input->get('folder')?$this->input->get('folder'):"");
        $upload_folder = "storage/".USER_NAME."/";
        if( !is_dir($upload_folder) ){
            mkdir($upload_folder);
        }
        if(isset($_FILES['userfile'])){
            $this->load->library('upload');
            $config['upload_path'] = $upload_folder;
            $config['allowed_types'] = str_replace(",", "|", $settings->white_list);
            $config['max_size'] = $settings->max_upload_size*1024;
            $config['overwrite'] = FALSE;

            $disc_usage = ((($settings->user_disc_space)*1024) - floatval($this->files_model->fullsize()))*1024;
            $filesize = $_FILES['userfile']['size'];

            if( $filesize > $disc_usage ){
                $result = array("status"=>"error", "message"=>lang("no_more_space"));
                $this->output->set_content_type('application/json')->set_output(json_encode($result));
                return false;
            }

            $this->upload->initialize($config);
            if( ! $this->upload->do_upload()){
                $error = $this->upload->display_errors();
                $error = array('status' => "error", 'message' => $error);
                $this->output->set_content_type('application/json')->set_output( json_encode($error) );
                return;
            }else{
                $upload_data = $this->upload->data();
                $file = $upload_folder.$upload_data['file_name'];
                $thumb = "";
                if( $upload_data["is_image"] && $this->files_model->create_thumb($upload_data['file_name'], $upload_folder) ){
                    $thumb = $upload_data['raw_name']."_thumb".$upload_data['file_ext'];
                }
                $data = array(
                    'realpath'    => $upload_folder.$upload_data['file_name'],
                    'link'        => strtoupper(substr( md5(rand()), 0, 14)),
                    'filename'    => $upload_data['raw_name'],
                    'extension'   => $upload_data['file_ext'],
                    'folder'      => $folder,
                    'date_upload' => date("Y-m-d H:i:s"),
                    'thumb'       => $thumb,
                    'size'        => $upload_data['file_size'],
                    'type'        => $upload_data['file_type'],
                    'user_id'     => USER_ID,
                );

                if( $this->files_model->add($data) ){
                    $array = array('status' => "success", 'message' => $file);
                    $this->output->set_content_type('application/json')->set_output( stripslashes(json_encode($array)) );
                    return;
                }
            }
        } else {
            $error = array('status' => "error", 'message' => lang("no_file_selected"));
            $this->output->set_content_type('application/json')->set_output( json_encode($error) );
            return;
        }
    }

    public function delete()
    {
        if($this->input->get('id')) { $id = array($this->input->get('id')); }
        if($this->input->post('id')) { $id = $this->input->post('id'); }
        if( !isset($id) || $id == false || !$this->input->is_ajax_request() ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        if ( $this->files_model->delete($id) )
        {
            $result = array("status"=>"success", "message"=>lang("file_moved_trash"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
    }

    public function restore()
    {
        if($this->input->get('id')) { $id = array($this->input->get('id')); }
        if($this->input->post('id')) { $id = $this->input->post('id'); }
        if( !isset($id) || $id == false || !$this->input->is_ajax_request() ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        if ( $this->files_model->restore($id) )
        {
            $result = array("status"=>"success", "message"=>lang("file_restored"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
    }

    public function delete_definitive()
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if($this->input->get('id')) { $id = array($this->input->get('id')); }
        if($this->input->post('id')) { $id = $this->input->post('id'); }
        if( !isset($id) || $id == false || !$this->input->is_ajax_request() ){
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        if ( $this->files_model->delete_definitive($id) )
        {
            $result = array("status"=>"success", "message"=>lang("file_deleted"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return true;
        }
        $result = array("status"=>"error", "message"=>lang("cant_delete_file"));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }


    public function rename($link = false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        if($this->input->get('link')) { $link = $this->input->get('link'); }
        if ( !$this->input->is_ajax_request() || !$link )
        {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $file = $this->files_model->getByColumn("link", $link);
        $this->form_validation->set_rules('filename', "lang:filename", 'required|xss_clean');

        if ($this->form_validation->run() == true)
        {
            $data = array('filename' => $this->input->post("filename"));
            $id     = $this->input->post('id');
        }
        if ( $this->form_validation->run() == true && $this->files_model->update($id, $data))
        {
            $data = array("status" => "success", "message" => lang("file_rename_success"));
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
                $data['file']         = $file;
                $data['page_title']      = lang('file_rename');
                $this->load->view ( 'files/files_rename' , $data );
            }
        }
    }

    public function move_to()
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        $id_list = false;
        if($this->input->post('id')) { $id_list = $this->input->post('id'); }
        if($this->input->get('files')) { $id_list = explode(",", $this->input->get('files')); }
        if ( !$this->input->is_ajax_request() || !$id_list )
        {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $files = $this->files_model->getFiles($id_list);

        $this->form_validation->set_rules('to_folder', "lang:to_folder", 'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $to   = $this->input->post("to_folder");
            $from = $files[0]->folder;
            $id   = $this->input->post('id');
        }
        if ( $this->form_validation->run() == true && $this->files_model->move($id, $from, $to))
        {
            $data = array("status" => "success", "message" => lang("file_moved_success"));
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
                $data['files']       = $files;
                $data['id_list']     = $id_list;

                /*if( $file->type == 'folder' ){
                    $data['folders']    = $this->files_model->getAllFolders($file->filename, $file->folder);
                }else{
                    $data['folders']    = $this->files_model->getAllFolders();
                }*/
                $data['folders']    = $this->files_model->getAllFolders();
                $data['page_title'] = lang('file_move_to');
                $this->load->view ( 'files/files_move_to' , $data );
            }
        }
    }

    public function create_folder()
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        if ( !$this->input->is_ajax_request() )
        {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $folder_parent = $this->input->get("folder")?$this->input->get("folder"):"";
        $this->form_validation->set_rules('foldername', "lang:foldername", 'required|xss_clean');
        if ($this->form_validation->run() == true)
        {
            $data = array(
                'realpath'    => "",
                'link'        => strtoupper(substr( md5(rand()), 0, 14)),
                'filename'    => $this->input->post("foldername"),
                'extension'   => "",
                'folder'      => $this->input->post("folder"),
                'date_upload' => date("Y-m-d H:i:s"),
                'thumb'       => "",
                'size'        => 0,
                'type'        => "folder",
                'user_id'     => USER_ID,
            );
        }
        if ( $this->form_validation->run() == true && $this->files_model->add($data))
        {
            $data = array("status" => "success", "message" => lang("create_folder_success"));
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
                $data['folder']          = $folder_parent;
                $data['page_title']      = lang('create_folder');
                $this->load->view ( 'files/create_folder' , $data );
            }
        }
    }

    public function preview($link = false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        if($this->input->get('files')) { $link = $this->input->get('files'); }
        if ( !$this->input->is_ajax_request() || !$link )
        {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $link = explode(",", $link);
        $files = $this->files_model->getFilesByLinks($link);

        $this->load->helper('number');
        $fullsize = 0;
        foreach ($files as $file) {
            $file->size = byte_format($file->size*1024);
            $fullsize  += floatval($file->size);
        }

        $data['files_link'] = implode(",", $link);
        $data['fullsize']        = byte_format($fullsize*1024);
        $data['files']           = $files;
        $data['page_title']      = lang('files_view');
        $this->load->view ( 'files/files_view' , $data );

    }

    public function link($link = false)
    {
        if($this->input->get('link')) { $link = $this->input->get('link'); }
        if ( !$link )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect('/', 'refresh');
        }
        $file = $this->files_model->getByColumn("link", $link);

        $this->load->helper('number');
        $file->size = byte_format($file->size*1024);

        $data['file']         = $file;
        $data['page_title']      = lang('files_view');
        $this->load->view ( 'files/files_view' , $data );

    }

    public function thumbnail($link = false)
    {
        if($this->input->get('link')) { $link = $this->input->get('link'); }
        if ( !$link )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect('/', 'refresh');
        }
        $file = $this->files_model->getByColumn("link", $link);
        if( $file->thumb != NULL && !empty($file->thumb) ){
            $ssl_op=array("ssl"=>array("verify_peer"=>false,"verify_peer_name"=>false));
            $path = substr($file->realpath, 0, strrpos($file->realpath, "/"));
            //$path = realpath($path)."/".$file->thumb;
            $path = $path."/".$file->thumb;
            $content = file_get_contents($path, false, stream_context_create($ssl_op));
            $this->output->set_content_type($file->type)->set_output($content);
        }
    }

    public function get($link = false)
    {
        if($this->input->get('link')) { $link = $this->input->get('link'); }
        if ( !$link )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect('/', 'refresh');
        }
        $file = $this->files_model->getByColumn("link", $link);
        $path = $file->realpath;
        if( (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS'])) ){
            $ssl_op=array("ssl"=>array("verify_peer"=>false,"verify_peer_name"=>false));
            $content = file_get_contents($path, false, stream_context_create($ssl_op));
        }else{
            $content = file_get_contents($path);
        }
        $this->output->set_content_type($file->type)->set_output($content);
    }

    public function download($link = false)
    {
        if($this->input->get('files')) { $link = $this->input->get('files'); }
        if ( !$link )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect('/', 'refresh');
        }
        $link = explode(",", $link);
        $files = $this->files_model->getFilesByLinks($link);

        if( count($files) > 1 ){
            $this->load->library('zip');
            foreach ($files as $file) {
                $this->zip->read_file($file->realpath);
            }
            $title = count($files)." ".lang("files")."_".date("YmdHis");
            $this->zip->download($title.'.zip');

        }else{
            $path = $files[0]->realpath;
            $name = $files[0]->filename.$files[0]->extension;
            $data = file_get_contents($path);
            $this->load->helper('download');
            force_download($name, $data);
        }
    }


    public function share($link = false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $this->session->set_flashdata('message', lang("is_demo"));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        if($this->input->get('files')) { $link = $this->input->get('files'); }
        if ( !$this->input->is_ajax_request() || !$link )
        {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $link = explode(",", $link);
        $files = $this->files_model->getFilesByLinks($link);

        $data['files_link'] = implode(",", $link);
        $data['files']      = $files;
        $data['page_title'] = lang('files_share');
        $this->load->view ( 'files/files_share' , $data );
    }

    public function view($link = false)
    {
        if($this->input->get('files')) { $link = $this->input->get('files'); }
        if ( !$link )
        {
            $this->session->set_flashdata('message', lang("access_denied"));
            redirect('/', 'refresh');
        }
        $link = explode(",", $link);
        $files = $this->files_model->getFilesByLinks($link);

        $this->load->helper('number');
        $fullsize = 0;
        foreach ($files as $file) {
            $file->size = byte_format($file->size*1024);
            $fullsize  += floatval($file->size);
        }
        $data['files_link'] = implode(",", $link);
        $data['fullsize']   = byte_format($fullsize*1024);
        $data['files']      = $files;
        $data['page_title'] = (count($files)==1)?$files[0]->filename.$files[0]->extension:count($files)." ".lang("files");
        $this->load->view ( 'files/external_view' , $data );
        $this->load->view ( 'templates/footer' , $data );
    }

    public function email($link = false)
    {
        if($this->input->get('files')) { $link = $this->input->get('files'); }
        if ( !$this->input->is_ajax_request() || !$link )
        {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $link = explode(",", $link);
        $files = $this->files_model->getFilesByLinks($link);

        $this->form_validation->set_rules('emails', "lang:emails", 'required|valid_emails|xss_clean');
        $this->form_validation->set_rules('additional_content', "lang:additional_content", 'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $this->load->library(array('email'));
            $email_config = objectToArray($this->settings_model->email_Settings);
            $emails       = explode(",", $this->input->post('emails'));
            $template = $this->settings_model->getEmailTemplate("send_file.tpl", LANGUAGE);
            $company  = $this->settings_model->getSettings("COMPANY");
            $data['email_content']   = parse_object_sis($template->content, $company)."<br>".$this->input->post("additional_content");
            $message = $this->load->view("email/standard.tpl.php", $data, true);
            $this->email->initialize($email_config);
            $this->email->clear();
            $this->email->from(COMPANY_EMAIL, COMPANY_NAME);
            $this->email->to($emails);
            $this->email->subject(parse_object_sis($template->subject, $company));
            $this->email->message($message);
            if( is_array($files) ){
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
                $data['files']      = $files;
                $data['files_link'] = implode(",", $link);
                $data['page_title'] = lang('send_email');
                $this->load->view ( 'files/files_email' , $data );
            }
        }
    }
}

/* End of file Files.php */
/* Location: ./application/controllers/Files.php */
