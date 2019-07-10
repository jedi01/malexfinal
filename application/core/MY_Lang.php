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

class MY_Lang extends CI_Lang {

    public function __construct() {
        parent::__construct();
    }

    public function line($line, $log_errors = TRUE)
    {
        $value = isset($this->language[$line]) ? $this->language[$line] : NULL;

        // Because killer robots like unicorns!
        if ($value === NULL && $log_errors === TRUE)
        {
            log_message('error', 'Could not find the language line "'.$line.'"');
        }

        if( $value === NULL ){
            $value = $line;
            $value = "<lang>$line</lang>";
        }
        /*
        if( $value == FALSE){
            $this->add_to_file($line);
            $value = "<lang>$line</lang>";
        }*/
        return $value;
    }


    private function add_to_file($line){
        $filename = "lang.txt";
        $lines = array();
        if( file_exists($filename) ){
            $fp = file_get_contents($filename);
            if ($fp) {
                $lines = explode("\r\n", $fp);
            }
        }
        if( !in_array($line, $lines)){
            $fp = @fopen($filename, 'a');
            fwrite($fp, $line."\r\n");
        }
    }
}
?>
