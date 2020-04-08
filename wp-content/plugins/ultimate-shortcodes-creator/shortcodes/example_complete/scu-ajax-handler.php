<?php
/***************************************************************************
* Wordpress Core Loaded
* Author:		cmorillas1@gmail.com
* Description:	Compose json response with the requests
* Return:		json html
****************************************************************************/
	
if(!defined('ABSPATH')) {
	die('Please don\'t access this file directly.');
}

// Check if the call is from the right place
if ( ! wp_verify_nonce(  $_POST['security'], 'scu-ajax-nonce' ) ) {
	die ( 'Busted!' );
}


global	$wp_version;

$atts = (isset($_REQUEST["atts"])) ? $_REQUEST["atts"] : null;
$content = (($_REQUEST["content"]!=='')) ? $_REQUEST["content"] : null;
$myparam = (isset($_REQUEST["myparam"])) ? $_REQUEST["myparam"] : null;
$shortcode = $atts["name"];
$referer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : null;
$scu_referer = (isset($_SERVER['HTTP_SCU_REFERER'])) ? $_SERVER['HTTP_SCU_REFERER'] : null;

$response  = "WP Version: ".$wp_version;
$response .= "<br>Shortcode: ".$shortcode;
$response .= "<br>Content: ".json_encode($content);
$response .= "<br>Atts: ".json_encode($atts);
$response .= "<br>My Param: ".$myparam;
$response .= "<br>Header Referer: ".$referer;
$response .= "<br>Header SCU-Referer: ".$scu_referer;
$response .= "<p></p>";
 
header( "Content-Type: application/json" );
echo json_encode($response);
wp_die(); // this is required to terminate immediately and return a proper response

?>