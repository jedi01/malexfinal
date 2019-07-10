<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct ()
    {
        parent::__construct ();
        // Load Recurring Model
        $this->load->model ( 'rinvoices_model' );
        // Load Invoices Model
        $this->load->model ( 'invoices_model' );
        // Load Billers Model
        $this->load->model ( 'biller_model' );
        // Load Calendar Model
        $this->load->model ( 'calendar_model' );

        if( !defined("CRON_JOB_ACTIVATED") || !CRON_JOB_ACTIVATED ){
            $file = "config.php";
            $cfgData = file_get_contents($file);
            $cfgData = str_replace("?>", "define('CRON_JOB_ACTIVATED', true);\n?>", $cfgData);
            file_put_contents($file, $cfgData);
        }
    }

    public function synchronize() {
        // recurring invoices
        $rinvoices = $this->rinvoices_model->getTodayRecurringInvoices();
        foreach ($rinvoices as $rinvoice) {
            $this->rinvoices_model->next($rinvoice->id);
        }
        $rinvoices = $this->rinvoices_model->getPassedRecurringInvoices();
        foreach ($rinvoices as $rinvoice) {
            $this->rinvoices_model->skip_next($rinvoice->id);
        }

        // overdue invoices
        if( ENABLE_OVERDUE_REMINDER ){
            // Overdue After
            $days = $this->settings_model->SYS_Settings->overdue_first_time;
            $invoices = $this->invoices_model->getInvoicesOverdueBy($days);
            $already_sended = $this->loadData();
            foreach ($invoices as $key => $invoice) {
                if( array_search($invoice->id, $already_sended['Overdue_by']) === false ){
                    $this->invoices_model->sendInvoiceReminder($invoice->id);
                    $already_sended['Overdue_by'][] = $invoice->id;
                }
            }
            // Remind Every
            $days = $this->settings_model->SYS_Settings->overdue_every;
            $invoices = $this->invoices_model->getInvoicesOverdueEvery($days);
            foreach ($invoices as $key => $invoice) {
                if( array_search($invoice->id, $already_sended['Overdue_every']) === false ){
                    $this->invoices_model->sendInvoiceReminder($invoice->id);
                    $already_sended['Overdue_every'][] = $invoice->id;
                }
            }
            $this->saveData($already_sended);
        }

        // load Calendar events
        if( $this->settings_model->SYS_Settings->reminder_enable ){
            $this->calendar_model->send_reminders();
        }
    }

    private function saveData($data = false){
        if( !$data ) return false;
        $content = json_encode($data);
        $file_path = realpath("")."\storage\cron.json";
        $fp = fopen($file_path,"w");
        fwrite($fp,$content);
        fclose($fp);
    }

    private function loadData(){
        $file_path = realpath("")."\storage\cron.json";
        if( file_exists($file_path) ){
            $handle = fopen($file_path, 'r');
            $content = fread($handle,filesize($file_path));
            $data = json_decode($content);
            if( $data->date != date("Y-m-d") ){
                $data = array("date"=>date("Y-m-d"),"Overdue_by"=>array(),"Overdue_every"=>array());
            }else{
                $data = array("date"=>$data->date,"Overdue_by"=>$data->Overdue_by,"Overdue_every"=>$data->Overdue_every);
            }
        }else{
            $data = array("date"=>date("Y-m-d"),"Overdue_by"=>array(),"Overdue_every"=>array());
        }
        return $data;
    }
}

/* End of file Cron.php */
/* Location: ./application/controllers/Cron.php */
