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

if( !function_exists("formatMoney") ){
    function formatMoney($number, $currency = false, $fractional=TRUE) {
        if ($fractional) {
            $number = sprintf('%.'.DECIMAL_PLACE.'f', $number);
        }
        if( ROUND_NUMBER != 0 ){
            $number = ceil($number / ROUND_NUMBER) * ROUND_NUMBER;
        }
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1;&;$2', $number);
            if ($replaced != $number) {
                $number = $replaced;
            } else {
                break;
            }
        }
        if( NUMBER_FORMAT == '1' ){
            $x = ","; $y = ".";
        }else if( NUMBER_FORMAT == '2' ){
            $x = "."; $y = ",";
        }else if( NUMBER_FORMAT == '3' ){
            $x = " "; $y = ",";
        }else if( NUMBER_FORMAT == '4' ){
            $x = " "; $y = ".";
        }else if( NUMBER_FORMAT == '5' ){
            $x = "'"; $y = ",";
        }else if( NUMBER_FORMAT == '6' ){
            $x = "'"; $y = ".";
        }else if( NUMBER_FORMAT == '7' ){
            $x = ""; $y = ".";
        }else if( NUMBER_FORMAT == '8' ){
            $x = ""; $y = ",";
        }
        $number = str_replace(".", $y, $number);
        $number = str_replace(";&;", $x, $number);
        if( $currency == false ){
          return $number;
        }else{
            if( CURRENCY_PLACE == "left" ){
                return $currency.' '.$number;
            }else{
                return $number.' '.$currency;
            }
        }
    }
}
if( !function_exists("formatFloat") ){
    function formatFloat($number, $fixed=NULL) {
        $fixed = $fixed==NULL?DECIMAL_PLACE:$fixed;
        if( $number == NULL){
            return 0;
        }
        $x = floatval($number);
        if( round($x) == $x ){
            return round($x);
        }
        $number = sprintf('%.'.$fixed.'f', $number);
        return $number;
    }
}

if( !function_exists("objectToArray") ){
    function objectToArray($d) {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            return array_map(__FUNCTION__, $d);
        }
        else {
            return $d;
        }
    }
}

if( !function_exists("arrayToObject") ){
    function arrayToObject($d) {
        if (is_array($d)) {
            return (object) array_map(__FUNCTION__, $d);
        }
        else {
            return $d;
        }
    }
}


if( !function_exists("convert_number_to_words") ){
    function convert_number_to_words($number){
        $hyphen      = '-';

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return lang("nbr_negative"). " " . convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = lang("nbr_".$number);
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                if( lang("nbr_inversed") ){
                    $string = "";
                    if ($units) {
                        $string .= lang("nbr_".$units)." ".lang("nbr_conjunction")." ";
                    }
                    $string .= lang("nbr_".$tens);
                }else{
                    $string = lang("nbr_".$tens);
                    if ($units) {
                        $string .= $hyphen . lang("nbr_".$units);
                    }
                }
                break;
            case $number < 1000:
                $hundreds  = ((int) ($number / 100))*100;
                $remainder = $number % 100;
                $string = lang("nbr_".intval($hundreds));
                if ($remainder) {
                    $string .= " ".lang("nbr_conjunction")." " . convert_number_to_words($remainder);
                }
                break;
            case $number < 10000:
                $thousands  = $number / 1000;
                $remainder = $number % 1000;
                if( intval($thousands) > 1 ){
                    $string = lang("nbr_".intval($thousands)) . ' ' . lang("nbr_1000");
                }else{
                    $string = lang("nbr_1000");
                }
                if ($remainder) {
                    $string .= " ".lang("nbr_conjunction")." " . convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = convert_number_to_words($numBaseUnits) . ' ' . lang("nbr_".$baseUnit);
                if ($remainder) {
                    $string .= $remainder < 100 ? " ".lang("nbr_conjunction")." " : " ".lang("nbr_separator")." ";
                    $string .= convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= " ".lang("nbr_decimal");
            while( strlen($fraction) >= 1 && substr($fraction, 0, 1) == "0" ){
                $string .= " ".convert_number_to_words(substr($fraction, 0, 1));
                $fraction = substr($fraction, 1);
            }
            if( strlen($fraction) >= 1 ){
                $string .= " ".convert_number_to_words($fraction);
            }
        }

        return $string;
    }
}

if( !function_exists("removeThe") ){
    function removeThe($phrase){
        $the = ""; $spacer = "";
        if( LANGUAGE == 'english' ){
            $the = "the";
            $spacer = " ";
        }elseif( LANGUAGE == 'arabic' ){
            $the = "ال";
        }
        $result = array();
        foreach (explode(" ", $phrase) as $word) {
            if( $word == $the ){
                continue;
            }
            if( substr($word, 0, strlen($the)) == $the ){
                $word = str_replace($the, '', $word);
            }
            $result[] = $word;
        }
        return implode(" ", $result);
    }
}

if( !function_exists("getDates") ){
    function getDates($start_date, $end_date){
        $diff = abs(strtotime($end_date) - strtotime($start_date));
        $years = floor($diff / (365*60*60*24));
        $months = floor($diff / (30*60*60*24));
        $weeks = floor($diff / (7*60*60*24))+1;
        $days = floor($diff / (60*60*24))+1;
        $hours = floor($diff / (60*60))+1;
        $minutes = floor($diff / (60))+1;

        if( $days > 365 ){ // by years
            $dates = array();
            for ($i=0; $i < $years; $i++) {
                $date_obj = new stdClass();
                $date_obj->start = date('Y-m-d 00:00:00', strtotime($start_date." +".$i." year"));
                $date_obj->end = date('Y-m-d 23:59:59', strtotime($start_date." +".($i+1)." year -1 day"));
                $dates_view[] = date('Y', strtotime($start_date." +".$i." year"));
                $dates[] = $date_obj;
            }
            $js_format = "YYYY";
        }
        else if( $days > 110 ){ // by month
            $dates = array();
            for ($i=0; $i < $months; $i++) {
                $date_obj = new stdClass();
                $date_obj->start = date('Y-m-d 00:00:00', strtotime($start_date." +".$i." month"));
                $date_obj->end = date('Y-m-d 23:59:59', strtotime($start_date." +".($i+1)." month -1 day"));
                //$dates_view[] = date('F', strtotime($start_date." +".$i." month"));
                $dates_view[] = date('F', strtotime($start_date." +".$i." month"));
                $dates[] = $date_obj;
            }
            $js_format = "MMMM";
        }
        else if( $days > 31 ){ // by week
            $dates = array();
            for ($i=0; $i < $weeks; $i++) {
                $date_obj = new stdClass();
                $date_obj->start = date('Y-m-d 00:00:00', strtotime($start_date." +".$i." week"));
                $date_obj->end = date('Y-m-d 23:59:59', strtotime($start_date." +".($i+1)." week -1 day"));
                //$dates_view[] = date('[d/m/Y', strtotime($start_date." +".$i." week"))." - ".date('d/m/Y]', strtotime($start_date." +".($i+1)." week -1 day"));
                $dates_view[] = date('F d, Y', strtotime($start_date." +".$i." week"));
                $dates[] = $date_obj;
            }
            $js_format = "MMM DD, YYYY";
        }
        else if( $days > 3 ){ // by days
            $dates = array();
            for ($i=0; $i < $days; $i++) {
                $date_obj = new stdClass();
                $date_obj->start = date('Y-m-d 00:00:00', strtotime($start_date." +".$i." day"));
                $date_obj->end = date('Y-m-d 23:59:59', strtotime($start_date." +".$i." day"));
                $dates_view[] = date('F d', strtotime($start_date." +".$i." day"));
                $dates[] = $date_obj;
            }
            $js_format = "MMM DD";
        }
        else if( $hours > 16 ){
            $dates = array();
            $j = $days*2;
            for ($i=0; $i < 24*$days; $i+= $j) {
                $date_obj = new stdClass();
                $date_obj->start = date('Y-m-d H:i:s', strtotime($start_date." +".$i." hour"));
                $date_obj->end = date('Y-m-d H:i:s', strtotime($start_date." +".($i+$j)." hour"));
                $dates_view[] = date('l H:i', strtotime($start_date." +".$i." hour"));
                $dates[] = $date_obj;
            }
            $js_format = "dddd HH:mm";
        }
        else if( $hours > 4 ){ // by hours
            $dates = array();
            for ($i=0; $i < $hours; $i++) {
                $date_obj = new stdClass();
                $date_obj->start = date('Y-m-d H:i:s', strtotime($start_date." +".$i." hour"));
                $date_obj->end = date('Y-m-d H:i:s', strtotime($start_date." +".($i+1)." hour"));
                $dates_view[] = date('l H:i', strtotime($start_date." +".$i." hour"));
                $dates[] = $date_obj;
            }
            $js_format = "dddd HH:mm";
        }
        else{ // by minutes
            $dates = array();
            $j = $hours*5;
            for ($i=0; $i < $minutes; $i+= $j) {
                $date_obj = new stdClass();
                $date_obj->start = date('Y-m-d H:i:s', strtotime($start_date." +".$i." minute"));
                $date_obj->end = date('Y-m-d H:i:s', strtotime($start_date." +".($i+$j)." minute"));
                $dates_view[] = date('l H:i', strtotime($start_date." +".$i." minute"));
                $dates[] = $date_obj;
            }
            $js_format = "dddd HH:mm";
        }
        $result = new stdClass();
        $result->dates = $dates;
        $result->dates_view = $dates_view;
        $result->js_format = $js_format;
        return $result;
    }
}



if ( ! function_exists('get_filenames_by_extension'))
{
    function get_filenames_by_extension($source_dir,  $extensions, $include_path = FALSE, $_recursion = FALSE)
    {
        static $_filedata = array();

        if ($fp = @opendir($source_dir))
        {
            // reset the array and make sure $source_dir has a trailing slash on the initial call
            if ($_recursion === FALSE)
            {
                $_filedata = array();
                $source_dir = rtrim(realpath($source_dir), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
            }

            while (FALSE !== ($file = readdir($fp)))
            {
                if (@is_dir($source_dir.$file) && strncmp($file, '.', 1) !== 0)
                {
                    get_filenames_by_extension($source_dir.$file.DIRECTORY_SEPARATOR, $extensions, $include_path, TRUE);
                }
                elseif (strncmp($file, '.', 1) !== 0)
                {
                    if(in_array(pathinfo($file, PATHINFO_EXTENSION), $extensions))
                    {
                        $_filedata[] = ($include_path == TRUE) ? $source_dir.$file : $file;
                    }
                }
            }
            return $_filedata;
        }
        else
        {
            return FALSE;
        }
    }
}


if ( ! function_exists('parse_object_sis'))
{
    function parse_object_sis($text,  $company = false, $invoice = false, $customer = false, $contract = false, $user = false, $estimate = false)
    {
        if( $company ){
            $text = parse_company($text, $company);
        }
        if( $invoice ){
            $text = parse_invoice($text, $invoice);
        }
        if( $customer ){
            $text = parse_customer($text, $customer);
        }
        if( $contract ){
            $text = parse_contract($text, $contract);
        }
        if( $user ){
            $text = parse_user($text, $user);
        }
        if( $estimate ){
            $text = parse_estimate($text, $estimate);
        }
        return $text;
    }
}

if ( ! function_exists('parse_company'))
{
    function parse_company($text,  $company)
    {
        $columns_strs = array(
            "{{company_name}}"        => "name",
            "{{company_address}}"     => "address",
            "{{company_city}}"        => "city",
            "{{company_state}}"       => "state",
            "{{company_postal_code}}" => "postal_code",
            "{{company_country}}"     => "country",
            "{{company_phone}}"       => "phone",
            "{{company_email}}"       => "email"
        );
        $data_array = (array)$company;
        foreach ($columns_strs as $column => $value) {
          if($data_array[$value] == false){
            $text = str_replace($column, "", $text);
          }else{
            $text = str_replace($column, $data_array[$value], $text);
          }
        }
        return $text;
    }
}

if ( ! function_exists('parse_invoice'))
{
    function parse_invoice($text,  $invoice)
    {
        $columns_strs = array(
            "{{invoice_reference}}"      => "reference",
            "{{invoice_date}}"           => "date",
            "{{invoice_date_due}}"       => "date_due",
            "{{invoice_status}}"         => "status",
            "{{invoice_total}}"          => "total",
            "{{invoice_total_payments}}" => "total",
            "{{invoice_total_due}}"      => "total_due",
            "{{invoice_link}}"           => "id",
            "{{invoice_overdue_days}}"   => "date",
        );
        $data_array = (array)$invoice;
        foreach ($columns_strs as $column => $value) {
          if($data_array[$value] == false){
            $text = str_replace($column, "", $text);
          }else{
            if( $column == "{{invoice_total}}" ){
                $text = str_replace($column, formatMoney($data_array["total"], $data_array['currency']), $text);
            }else if( $column == "{{invoice_total_payments}}" ){
                $text = str_replace($column, formatMoney($data_array["total"]-$data_array["total_due"], $data_array['currency']), $text);
            }else if( $column == "{{invoice_total_due}}" ){
                $text = str_replace($column, formatMoney($data_array["total_due"], $data_array['currency']), $text);
            }else if( $column == "{{invoice_link}}" ){
                $text = str_replace($column, site_url("/invoices/open/".$data_array["id"]), $text);
            }else if( $column == "{{invoice_date}}" ){
                $text = str_replace($column, date_MYSQL_PHP($data_array['date']), $text);
            }else if( $column == "{{invoice_date_due}}" ){
                $text = str_replace($column, date_MYSQL_PHP($data_array['date_due']), $text);
            }else if( $column == "{{invoice_overdue_days}}" ){
                if( $data_array["date_due"] != NULL ){
                    $text = str_replace($column, floor(strtotime(date("Y-m-d"))-strtotime($data_array["date_due"]))/3600/24, $text);
                }else{
                    $text = str_replace($column, "0", $text);
                }
            }else{
                $text = str_replace($column, $data_array[$value], $text);
            }
          }
        }
        return $text;
    }
}

if ( ! function_exists('parse_customer'))
{
    function parse_customer($text,  $customer)
    {
        $columns_strs = array(
            "{{customer_company}}"    => "company",
            "{{customer_fullname}}"   => "fullname",
            "{{customer_phone}}"      => "phone",
            "{{customer_email}}"      => "email",
            "{{customer_address}}"    => "address",
            "{{customer_vat_number}}" => "vat_number",
            "{{customer_website}}"    => "website",
        );
        $data_array = (array)$customer;
        foreach ($columns_strs as $column => $value) {
          if($data_array[$value] == false){
            $text = str_replace($column, "", $text);
          }else{
            $text = str_replace($column, $data_array[$value], $text);
          }
        }
        return $text;
    }
}

if ( ! function_exists('parse_user'))
{
    function parse_user($text,  $user)
    {
        $columns_strs = array(
            "{{user_username}}"                => "username",
            "{{user_email}}"                   => "email",
            "{{user_activation_code}}"         => "activation_code",
            "{{user_forgotten_password_code}}" => "forgotten_password_code",
            "{{user_first_name}}"              => "first_name",
            "{{user_last_name}}"               => "last_name",
            "{{user_phone}}"                   => "phone",
            "{{user_company}}"                 => "company",
        );
        $data_array = (array)$user;
        foreach ($columns_strs as $column => $value) {
          if($data_array[$value] == false){
            $text = str_replace($column, "", $text);
          }else{
            if( $column == "{{user_forgotten_password_code}}" ){
                $text = str_replace($column, site_url('auth/reset_password/'. $data_array["forgotten_password_code"]), $text);
            }else if( $column == "{{user_activation_code}}" ){
                $text = str_replace($column, site_url('auth/activate/'. $data_array["id"] .'/'. $data_array["activation_code"]), $text);
            }else{
                $text = str_replace($column, $data_array[$value], $text);
            }
          }
        }
        return $text;
    }
}

if ( ! function_exists('parse_contract'))
{
    function parse_contract($text,  $contract)
    {
        $columns_strs = array(
            "{{contract_subject}}"     => "subject",
            "{{contract_date}}"        => "date",
            "{{contract_date_due}}"    => "date_due",
            "{{contract_type}}"        => "type",
            "{{contract_description}}" => "description",
            "{{contract_reference}}"   => "reference",
            "{{contract_amount}}"      => "amount",
        );
        $data_array = (array)$contract;
        foreach ($columns_strs as $column => $value) {
          if($data_array[$value] == false){
            $text = str_replace($column, "", $text);
          }else{
            if( $column == "{{contract_amount}}" ){
                $text = str_replace($column, formatMoney($data_array["amount"], CURRENCY_PREFIX), $text);
            }else{
                $text = str_replace($column, $data_array[$value], $text);
            }
          }
        }
        return $text;
    }
}

if ( ! function_exists('parse_estimate'))
{
    function parse_estimate($text,  $estimate)
    {
        $columns_strs = array(
            "{{estimate_reference}}"      => "reference",
            "{{estimate_date}}"           => "date",
            "{{estimate_date_due}}"       => "date_due",
            "{{estimate_status}}"         => "status",
            "{{estimate_total}}"          => "total",
            "{{estimate_link}}"           => "id",
        );
        $data_array = (array)$estimate;
        foreach ($columns_strs as $column => $value) {
          if($data_array[$value] == false){
            $text = str_replace($column, "", $text);
          }else{
            if( $column == "{{estimate_total}}" ){
                $text = str_replace($column, formatMoney($data_array["total"], $data_array['currency']), $text);
            }else if( $column == "{{estimate_link}}" ){
                $text = str_replace($column, site_url("/estimates/open/".$data_array["id"]), $text);
            }else if( $column == "{{estimate_date}}" ){
                $text = str_replace($column, date_MYSQL_PHP($data_array['date']), $text);
            }else if( $column == "{{estimate_date_due}}" ){
                $text = str_replace($column, date_MYSQL_PHP($data_array['date_due']), $text);
            }else{
                $text = str_replace($column, $data_array[$value], $text);
            }
          }
        }
        return $text;
    }
}


if ( ! function_exists('parse_text_sis'))
{
    function parse_text_sis($text,  $search, $replace_with)
    {
        return str_replace($search, $replace_with, $text);
    }
}



if ( ! function_exists('progress_text'))
{
    function progress_text($percent, $max = 100)
    {
        if( $percent < ($max/4)*1 ){
            return "danger";
        }
        elseif( $percent < ($max/4)*2 ){
            return "warning";
        }
        elseif( $percent < ($max/4)*3 ){
            return "info";
        }
        else{
            return "success";
        }
    }
}
