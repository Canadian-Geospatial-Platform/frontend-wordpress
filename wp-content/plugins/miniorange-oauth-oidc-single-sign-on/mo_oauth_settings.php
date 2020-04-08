<?php
/**
 * Plugin Name: OAuth Single Sign On - SSO (OAuth client)
 * Plugin URI: http://miniorange.com
 * Description: This plugin enables login to your WordPress site using OAuth apps like Google, Facebook, EVE Online and other.
 * Version: 38.0.0
 * Author: miniOrange
 * Author URI: https://www.miniorange.com
 * License URI: http://miniorange.com/usecases/miniOrange_User_Agreement.pdf
 */


require "\x5f\x61\165\x74\157\154\157\141\144\x2e\x70\150\x70";
require_once "\x6d\x6f\55\157\141\x75\164\x68\x2d\143\x6c\151\x65\x6e\x74\55\x70\154\165\x67\151\x6e\x2d\x76\145\162\x73\151\x6f\x6e\55\165\x70\144\x61\164\x65\x2e\x70\x68\160";
use MoOauthClient\Base\BaseStructure;
use MoOauthClient\MOUtils;
use MoOauthClient\Base\InstanceHelper;
use MoOauthClient\MoOauthClientWidget;
use MoOauthClient\Free\MOCVisualTour;
global $xW;
$Bk = new InstanceHelper();
$kY = new BaseStructure();
$xW = $Bk->get_utils_instance();
$Tq = $Bk->get_settings_instance();
$Br = $Bk->get_login_handler_instance();
function register_mo_oauth_widget()
{
    register_widget("\134\x4d\x6f\x4f\x61\165\164\x68\x43\154\x69\145\156\164\134\115\157\117\141\165\164\150\x43\154\x69\145\x6e\164\x57\x69\x64\x67\x65\x74");
}
function mo_oauth_shortcode_login($iM)
{
    global $xW;
    $Ck = new MoOauthClientWidget();
    if ($xW->check_versi(3) && $xW->mo_oauth_client_get_option("\x6d\157\137\157\141\x75\164\x68\x5f\x61\x63\x74\151\x76\x61\x74\145\x5f\x73\151\x6e\x67\154\145\x5f\x6c\157\147\151\156\x5f\146\154\x6f\167")) {
        goto npZ;
    }
    return $iM ? $Ck->mo_oauth_login_form($xz = true, $PT = $iM[0]) : $Ck->mo_oauth_login_form(false);
    goto M30;
    npZ:
    return $Ck->mo_activate_single_login_flow_form();
    M30:
}
add_action("\x77\151\144\147\145\164\x73\x5f\x69\156\151\x74", "\162\x65\147\x69\x73\x74\x65\x72\x5f\155\157\x5f\x6f\141\165\x74\150\137\x77\x69\144\x67\145\x74");
add_shortcode("\155\x6f\x5f\157\141\x75\x74\150\137\154\157\147\151\x6e", "\x6d\157\x5f\x6f\141\165\164\x68\137\163\x68\x6f\x72\x74\x63\157\144\x65\x5f\154\157\147\151\156");
function miniorange_oauth_visual_tour()
{
    $TU = new MOCVisualTour();
}
if (!($xW->get_versi() === 0)) {
    goto DBX;
}
add_action("\x61\x64\x6d\x69\156\x5f\151\x6e\x69\x74", "\x6d\x69\156\x69\157\x72\141\x6e\x67\145\x5f\x6f\x61\x75\164\150\x5f\166\151\x73\x75\x61\x6c\x5f\164\157\x75\x72");
DBX:
function mo_oauth_deactivate()
{
    global $xW;
    do_action("\x6d\157\137\x63\154\x65\141\162\x5f\x70\x6c\x75\147\137\x63\x61\143\x68\x65");
    $xW->deactivate_plugin();
}
register_deactivation_hook(__FILE__, "\x6d\x6f\x5f\x6f\x61\x75\x74\150\x5f\144\145\141\143\164\151\x76\141\x74\x65");
