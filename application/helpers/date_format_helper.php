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
if ( ! function_exists('datetotime')){
	function datetotime ($date, $format = 'd-m-Y') {
	    if ($format == 'M d Y') list($month, $day, $year) = explode(' ', $date);
	    if ($format == 'm-d-Y') list($month, $day, $year) = explode('-', $date);
	    if ($format == 'm/d/Y') list($month, $day, $year) = explode('/', $date);

	    if ($format == 'd-m-Y') list($day, $month, $year) = explode('-', $date);
	    if ($format == 'd/m/Y') list($day, $month, $year) = explode('/', $date);
	    if ($format == 'd.m.Y') list($day, $month, $year) = explode('.', $date);
	    if ($format == 'd M Y') list($day, $month, $year) = explode(' ', $date);

	    if ($format == 'Y M d') list($year, $month, $day) = explode(' ', $date);

	    if( intval($month) == FALSE ){
	    	$month = date("m", strtotime($month));
	    }
	    return mktime(0, 0, 0, $month, $day, $year);
	}
}

if ( ! function_exists('date_JS_MYSQL'))
{
	function date_JS_MYSQL($date, $JS_FORMAT = JS_DATE ){
		return date("Y-m-d", datetotime($date, PHP_DATE));
	}
}

if ( ! function_exists('date_MYSQL_JS'))
{
	function date_MYSQL_JS($date, $JS_FORMAT = JS_DATE ){
		return date(PHP_DATE, strtotime($date));
	}
}

if ( ! function_exists('date_JS_PHP'))
{
	function date_JS_PHP($date, $JS_FORMAT = JS_DATE ){
		return date(PHP_DATE, datetotime($date, PHP_DATE));
	}
}

if ( ! function_exists('date_PHP_JS'))
{
	function date_PHP_JS($date, $JS_FORMAT = JS_DATE ){
		return $date;
	}
}

if ( ! function_exists('date_PHP_MYSQL'))
{
	function date_PHP_MYSQL($date, $PHP_FORMAT = PHP_DATE ){
		return date("Y-m-d", datetotime($date, PHP_DATE));
	}
}

if ( ! function_exists('date_MYSQL_PHP'))
{
	function date_MYSQL_PHP($date, $PHP_FORMAT = PHP_DATE ){
		return date(PHP_DATE, strtotime($date));
	}
}
