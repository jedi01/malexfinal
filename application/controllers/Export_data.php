<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export_data extends MY_Controller {

    /**
     * Export Data constructor.
     */
    function __construct()
    {
        parent::__construct ();
        // Load Form Validation Library
        $this->load->library ( 'form_validation' );
        // Load Ion Auth Library
        $this->load->library ( 'ion_auth' );
        // Load Helper Language
        $this->load->helper('language');
        // Check user is logged in ?
        if ( !$this->ion_auth->logged_in () ) {
            if ($this->input->is_ajax_request()) {
                $result = array("status"=>"redirect", "message"=>site_url("auth/login"));
                die(json_encode($result));
            }else{
                redirect("auth/login");
            }
        }
    }

    public function csv()
    {
        $header = $this->input->post("header");
        $data = $this->input->post("data");
        $title = $this->input->post("title");
        $delimiter = ",";
        $file_content = "";
        if( $header ){
            $file_content .= implode($delimiter, $header)."\r\n";
        }
        if( $data ){
            foreach ($data as $line) {
                $file_content .= implode($delimiter, $line)."\r\n";
            }
        }
        if( !$title ){
            $title = "CSV file";
        }
        $this->load->helper('download');
        force_download($title." ".date("Y-m-d").".csv", $file_content, true);
    }

    public function text()
    {
        $header = $this->input->post("header");
        $data = $this->input->post("data");
        $title = $this->input->post("title");
        $delimiter = "\t";
        $file_content = "";
        if( $header ){
            $file_content .= implode($delimiter, $header)."\r\n";
        }
        if( $data ){
            foreach ($data as $line) {
                $file_content .= implode($delimiter, $line)."\r\n";
            }
        }
        if( !$title ){
            $title = "Text file";
        }
        $this->load->helper('download');
        force_download($title." ".date("Y-m-d").".txt", $file_content, true);
    }

    public function xls()
    {
        $header = $this->input->post("header");
        $data = $this->input->post("data");
        $title = $this->input->post("title");
        $delimiter = "\t";
        $file_content = "";
        if( $header ){
            $file_content .= implode($delimiter, $header)."\r\n";
        }
        if( $data ){
            foreach ($data as $line) {
                $file_content .= implode($delimiter, $line)."\r\n";
            }
        }
        if( !$title ){
            $title = "Excel file";
        }
        $this->load->helper('download');
        force_download($title." ".date("Y-m-d").".xls", $file_content, true);
    }

    public function pdf()
    {
        $header = $this->input->post("header");
        $data = $this->input->post("data");
        $title = $this->input->post("title");
        $html = "<center><table class=\"table table_invoice table_invoice-bordered table_invoice-striped\">";
        if( $header ){
            $html .= "<thead><tr>";
            foreach ($header as $key => $value) {
                $html .= "<th>".$value."</th>";
            }
            $html .= "</tr></thead>\r\n";
        }
        if( $data ){
            foreach ($data as $line) {
                $html .= "<tr>";
                foreach ($line as $key => $value) {
                    $html .= "<td>".$value."</td>";
                }
                $html .= "</tr>\r\n";
            }
        }
        $html .= "</table></center>";
        if( !$title ){
            $title = "PDF file";
        }
        $title = $title." ".date("Y-m-d");
        $this->load->helper(array('dompdf', 'file'));
        $pdf_file = pdf_create($html, $title, true);
        $this->load->helper('download');
        force_download($title.".pdf", $pdf_file, true);
    }

}

/* End of file Export_data.php */
/* Location: ./application/controllers/Export_data.php */
