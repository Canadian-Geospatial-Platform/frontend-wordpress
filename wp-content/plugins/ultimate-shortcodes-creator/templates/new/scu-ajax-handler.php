<?php
/***************************************************************************
* Author:		
* Description:	
* Return:		json html
****************************************************************************/
	
if(!defined('ABSPATH')) {
	die('Please don\'t access this file directly.');
}

// Check if the call is from the right place
if ( ! wp_verify_nonce(  $_POST['security'], 'scu-ajax-nonce' ) ) {
	die ( 'Busted!' );
}
header( "Content-Type: application/json" );
echo json_encode('ok');
wp_die(); // this is required to terminate immediately and return a proper response

?>