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

class MY_Loader extends CI_Loader {
    public $version = "1.9.2";
    public $javascript_files = array();
    public $css_files = array();

    public function __construct() {
        parent::__construct();
    }

    /** Load a javascript **/
    public function enqueue_script($path, $type = "DEFAULT") {
        $file = $this->config->base_url($path);
        if( !in_array($type, $this->javascript_files) || !in_array($file, $this->javascript_files[$type]) ){
            $this->javascript_files[$type][] = $file;
        }
        return $this;
    }

    public function javascript($type = "DEFAULT"){
        $_javascripts = "<!-- JAVASCRIPT FILES -->\n";
        foreach ($this->javascript_files[$type] as $file) {
            $_javascripts .= "<script type=\"text/javascript\" src=\"".$file."?v=".$this->version."\"></script>\n";
        }
        $_javascripts .= "<!-- JAVASCRIPT FILES END -->\n";
        return $_javascripts;
    }

    /** Load a style sheet **/
    public function enqueue_style($path, $type = "DEFAULT") {
        $file = $this->config->base_url($path);
        if( !in_array($type, $this->css_files) || !in_array($file, $this->css_files[$type]) ){
            $this->css_files[$type][] = $file;
        }
        return $this;
    }

    public function css($type = "DEFAULT"){
        $_stylesheets = "<!-- CSS FILES -->\n";
        foreach ($this->css_files[$type] as $file) {
            $_stylesheets .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$file."?v=".$this->version."\">\n";
        }
        $_stylesheets .= "<!-- CSS FILES END -->\n";
        return $_stylesheets;
    }
}

/* End of file MY_Loader.php */
/* Location: ./application/core/MY_Loader.php */
