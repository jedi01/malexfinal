<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function pdf_create($html, $filename='', $stream=TRUE)
{
    require_once("dompdf/autoload.inc.php");
    $ci =& get_instance();
    $isArabic = LANGUAGE == "arabic";
    $font = $ci->settings_model->INV_Settings->invoice_font;

    $pdfcss = file_get_contents(realpath('assets/css/pdf.css'));
    $rtlcss = file_get_contents(realpath('assets/css/rtl.css'));

    $html='<!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style type="text/css">'.$pdfcss.'</style>
        '.(lang("IS_RTL")?'<style type="text/css">'.$rtlcss.'</style>':'').'
        <style type="text/css">
        * {font-family: "DejaVu Sans",'.$font.' !important; }
        </style>
    </head>
    <body>'.$html.'</body>
    <html>';

    $dompdf = new Dompdf\Dompdf();
    $dompdf->setIsArabic($isArabic);
    $dompdf->set_option('isPhpEnabled', true);
    $dompdf->set_option('isHtml5ParserEnabled', true);
    $dompdf->load_html($html, 'UTF-8');
    $dompdf->render();

    /*
    echo ($html); die();
    header("content-type: pdf"); echo $dompdf->output(); die();
    */

    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        return $dompdf->output();
    }
}
?>
