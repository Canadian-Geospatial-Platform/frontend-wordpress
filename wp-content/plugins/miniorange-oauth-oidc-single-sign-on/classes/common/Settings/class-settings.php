<?php


namespace MoOauthClient;

use MoOauthClient\mc_utils;
use MoOauthClient\Customer;
use MoOauthClient\Config;
class Settings
{
    public $config;
    public $util;
    public function __construct()
    {
        global $xW;
        $this->util = $xW;
        add_action("\x61\144\x6d\151\x6e\137\151\156\x69\x74", array($this, "\x6d\151\156\151\157\x72\141\156\x67\x65\137\157\141\x75\x74\150\x5f\x73\x61\x76\x65\137\163\145\164\x74\x69\156\147\x73"));
        add_shortcode("\x6d\x6f\137\157\141\x75\164\x68\137\154\157\147\x69\156", array($this, "\155\157\137\157\141\165\x74\x68\137\163\150\x6f\162\164\x63\x6f\144\x65\x5f\x6c\x6f\147\151\156"));
        $this->util->mo_oauth_client_update_option("\155\157\x5f\x6f\x61\165\164\150\137\154\157\147\151\156\137\x69\143\157\156\x5f\163\160\141\x63\x65", "\65");
        $this->util->mo_oauth_client_update_option("\155\157\137\x6f\141\165\x74\x68\137\154\157\x67\x69\156\x5f\x69\x63\157\156\137\x63\165\x73\x74\157\155\137\x77\x69\x64\x74\x68", "\x33\62\65\56\64\63");
        $this->util->mo_oauth_client_update_option("\155\157\137\x6f\141\165\164\x68\137\x6c\157\x67\x69\156\x5f\x69\x63\x6f\156\x5f\x63\165\x73\x74\157\155\x5f\150\x65\151\147\150\164", "\x39\56\x36\x33");
        $this->util->mo_oauth_client_update_option("\155\x6f\x5f\157\x61\x75\164\150\x5f\154\157\x67\151\156\137\x69\143\157\x6e\137\143\x75\163\x74\157\155\137\163\151\172\145", "\x33\65");
        $this->util->mo_oauth_client_update_option("\x6d\157\137\157\x61\x75\x74\x68\137\x6c\157\147\151\x6e\137\x69\x63\x6f\x6e\137\143\165\x73\x74\x6f\x6d\137\x63\157\154\x6f\162", "\x32\x42\x34\61\106\106");
        $this->util->mo_oauth_client_update_option("\x6d\x6f\137\157\x61\165\164\150\137\x6c\157\147\x69\156\137\x69\x63\x6f\156\137\x63\165\163\164\x6f\155\x5f\142\157\165\x6e\144\141\162\x79", "\x34");
        $this->config = $this->util->get_plugin_config();
    }
    public function miniorange_oauth_save_settings()
    {
        global $xW;
        if (!(isset($_POST["\x63\x68\141\156\x67\x65\x5f\x6d\151\x6e\x69\x6f\x72\141\x6e\x67\x65\x5f\156\x6f\x6e\143\x65"]) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST["\x63\150\x61\156\147\x65\137\x6d\x69\x6e\151\157\x72\x61\x6e\x67\145\x5f\x6e\x6f\156\143\x65"])), "\143\x68\141\156\147\145\137\155\151\x6e\151\x6f\162\141\x6e\147\x65") && isset($_POST[\MoOAuthConstants::OPTION]) && "\143\x68\x61\x6e\147\145\x5f\x6d\151\156\x69\x6f\162\x61\156\x67\145" === $_POST[\MoOAuthConstants::OPTION])) {
            goto kn;
        }
        mo_oauth_deactivate();
        return;
        kn:
        if (!(isset($_POST["\x6d\x6f\137\157\x61\165\x74\x68\137\162\145\x67\151\x73\164\145\x72\x5f\x63\x75\x73\x74\x6f\x6d\x65\x72\x5f\156\157\156\143\145"]) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST["\x6d\157\137\x6f\x61\165\164\150\x5f\162\x65\x67\x69\163\x74\x65\x72\x5f\x63\165\163\x74\x6f\x6d\x65\162\x5f\x6e\x6f\x6e\x63\145"])), "\155\x6f\137\x6f\141\165\x74\150\x5f\x72\x65\x67\x69\163\164\145\162\x5f\143\165\163\x74\x6f\x6d\x65\162") && isset($_POST[\MoOAuthConstants::OPTION]) && "\155\x6f\137\x6f\x61\x75\x74\x68\137\162\145\x67\x69\163\164\x65\x72\137\x63\x75\x73\x74\157\155\x65\162" === $_POST[\MoOAuthConstants::OPTION])) {
            goto q8;
        }
        $xv = '';
        $Fs = '';
        $Wd = '';
        $NW = '';
        $gp = '';
        $W0 = '';
        $Cy = '';
        if (!($this->util->mo_oauth_check_empty_or_null($_POST["\145\155\141\x69\x6c"]) || $this->util->mo_oauth_check_empty_or_null($_POST["\160\141\163\x73\x77\157\162\x64"]) || $this->util->mo_oauth_check_empty_or_null($_POST["\143\x6f\x6e\146\x69\x72\x6d\120\141\163\163\x77\157\162\x64"]))) {
            goto k2;
        }
        $this->util->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\x41\154\x6c\40\x74\150\x65\40\146\151\x65\154\144\x73\x20\141\162\145\x20\x72\145\x71\x75\x69\x72\x65\144\x2e\40\x50\x6c\145\141\x73\x65\40\145\156\x74\x65\x72\x20\x76\x61\154\x69\144\x20\145\156\x74\162\151\x65\x73\x2e");
        $this->util->mo_oauth_show_error_message();
        return;
        k2:
        if (strlen($_POST["\x70\x61\x73\x73\167\x6f\162\144"]) < 8 || strlen($_POST["\143\157\156\x66\x69\162\155\120\141\163\x73\167\x6f\x72\144"]) < 8) {
            goto a2;
        }
        $xv = sanitize_email($_POST["\145\x6d\x61\151\x6c"]);
        $Fs = stripslashes($_POST["\x70\150\x6f\x6e\145"]);
        $Wd = stripslashes($_POST["\x70\x61\x73\x73\167\157\162\x64"]);
        $NW = stripslashes($_POST["\146\x6e\141\x6d\x65"]);
        $gp = stripslashes($_POST["\x6c\156\x61\x6d\x65"]);
        $W0 = stripslashes($_POST["\x63\x6f\155\160\141\156\x79"]);
        $Cy = stripslashes($_POST["\x63\157\x6e\x66\x69\162\155\x50\141\163\163\x77\x6f\162\x64"]);
        goto y_;
        a2:
        $this->util->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\x43\150\157\157\163\x65\40\141\x20\160\141\163\x73\167\x6f\x72\144\x20\167\151\164\x68\x20\x6d\x69\x6e\151\155\165\x6d\40\154\145\x6e\x67\164\150\40\x38\56");
        $this->util->mo_oauth_show_error_message();
        return;
        y_:
        $this->util->mo_oauth_client_update_option("\x6d\x6f\137\157\x61\165\164\150\137\141\144\155\151\x6e\137\145\155\x61\x69\154", $xv);
        $this->util->mo_oauth_client_update_option("\x6d\157\x5f\x6f\x61\165\164\150\137\x61\x64\x6d\151\156\x5f\160\150\157\x6e\x65", $Fs);
        $this->util->mo_oauth_client_update_option("\x6d\x6f\x5f\157\141\165\x74\x68\x5f\141\x64\155\151\156\137\x66\156\141\x6d\x65", $NW);
        $this->util->mo_oauth_client_update_option("\155\x6f\137\x6f\x61\x75\x74\x68\x5f\141\x64\x6d\151\x6e\x5f\154\x6e\141\x6d\x65", $gp);
        $this->util->mo_oauth_client_update_option("\x6d\x6f\x5f\x6f\x61\165\164\x68\x5f\141\144\x6d\151\x6e\137\x63\x6f\x6d\160\141\x6e\x79", $W0);
        if (!($this->util->mo_oauth_is_curl_installed() === 0)) {
            goto AD;
        }
        return $this->util->mo_oauth_show_curl_error();
        AD:
        if (strcmp($Wd, $Cy) === 0) {
            goto CP;
        }
        $this->util->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\120\x61\163\163\167\x6f\162\144\x73\40\144\157\40\x6e\157\164\x20\155\x61\164\x63\150\x2e");
        $this->util->mo_oauth_client_delete_option("\166\x65\x72\151\x66\x79\x5f\x63\x75\163\164\x6f\x6d\145\x72");
        $this->util->mo_oauth_show_error_message();
        goto iI;
        CP:
        $this->util->mo_oauth_client_update_option("\x70\x61\x73\x73\x77\x6f\x72\144", $Wd);
        $RA = new Customer();
        $xv = $this->util->mo_oauth_client_get_option("\x6d\x6f\x5f\x6f\x61\165\x74\x68\x5f\x61\144\x6d\x69\156\137\x65\155\141\x69\154");
        $PI = json_decode($RA->check_customer(), true);
        if (strcasecmp($PI["\x73\164\x61\164\x75\163"], "\103\125\123\124\x4f\x4d\x45\x52\x5f\116\x4f\x54\x5f\106\117\125\x4e\104") === 0) {
            goto A0;
        }
        $this->mo_oauth_get_current_customer();
        goto Mw;
        A0:
        $this->create_customer();
        Mw:
        iI:
        q8:
        if (!(isset($_POST["\x6d\x6f\137\157\x61\x75\x74\x68\137\166\x65\162\151\x66\171\x5f\x63\x75\163\164\x6f\155\145\162\137\156\x6f\156\143\145"]) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST["\155\x6f\137\x6f\141\165\x74\150\137\x76\x65\x72\x69\146\x79\x5f\143\165\163\x74\x6f\155\x65\x72\x5f\x6e\157\x6e\143\x65"])), "\x6d\x6f\137\157\x61\x75\164\x68\x5f\x76\145\162\151\146\171\137\143\165\x73\x74\157\x6d\145\x72") && isset($_POST[\MoOAuthConstants::OPTION]) && "\155\x6f\137\x6f\x61\x75\x74\x68\x5f\x76\145\162\x69\x66\x79\x5f\143\x75\x73\164\x6f\155\x65\162" === $_POST[\MoOAuthConstants::OPTION])) {
            goto vv;
        }
        if (!($this->util->mo_oauth_is_curl_installed() === 0)) {
            goto V9;
        }
        return $this->util->mo_oauth_show_curl_error();
        V9:
        $xv = isset($_POST["\x65\x6d\x61\x69\x6c"]) ? sanitize_email(wp_unslash($_POST["\145\155\141\x69\x6c"])) : '';
        $Wd = isset($_POST["\160\141\x73\x73\167\x6f\162\144"]) ? sanitize_text_field(wp_unslash($_POST["\160\x61\163\x73\167\157\x72\144"])) : '';
        if (!($this->util->mo_oauth_check_empty_or_null($xv) || $this->util->mo_oauth_check_empty_or_null($Wd))) {
            goto Bj;
        }
        $this->util->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\101\154\154\40\x74\150\x65\40\x66\x69\x65\x6c\x64\x73\40\141\x72\x65\40\x72\145\x71\165\151\162\x65\144\56\x20\x50\154\145\x61\x73\145\x20\145\x6e\164\145\162\x20\166\141\154\151\144\x20\145\156\x74\162\x69\x65\163\x2e");
        $this->util->mo_oauth_show_error_message();
        return;
        Bj:
        $this->util->mo_oauth_client_update_option("\x6d\157\137\157\x61\x75\164\x68\137\141\x64\x6d\151\156\137\x65\x6d\141\x69\x6c", $xv);
        $this->util->mo_oauth_client_update_option("\160\141\x73\163\167\x6f\162\144", $Wd);
        $RA = new Customer();
        $PI = $RA->get_customer_key();
        $mH = json_decode($PI, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            goto kp;
        }
        $this->util->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\111\x6e\x76\141\x6c\x69\144\40\x75\163\x65\x72\x6e\x61\155\x65\40\157\162\40\x70\141\163\163\x77\157\162\144\x2e\x20\120\x6c\145\141\x73\x65\x20\x74\162\x79\40\x61\147\141\151\156\x2e");
        $this->util->mo_oauth_show_error_message();
        goto xM;
        kp:
        $this->util->mo_oauth_client_update_option("\155\x6f\137\x6f\x61\x75\164\150\137\x61\x64\155\151\x6e\137\x63\x75\163\x74\x6f\x6d\x65\x72\137\x6b\145\171", $mH["\x69\144"]);
        $this->util->mo_oauth_client_update_option("\155\157\x5f\x6f\141\165\164\150\137\141\x64\155\x69\x6e\137\141\x70\151\137\x6b\145\171", $mH["\141\x70\x69\113\145\171"]);
        $this->util->mo_oauth_client_update_option("\143\165\x73\x74\157\155\145\162\137\x74\x6f\153\145\156", $mH["\x74\x6f\153\x65\x6e"]);
        if (!isset($L5["\x70\x68\157\x6e\145"])) {
            goto Ri;
        }
        $this->util->mo_oauth_client_update_option("\x6d\157\x5f\x6f\141\165\164\x68\137\141\144\155\151\156\137\160\x68\157\156\x65", $mH["\160\150\157\x6e\145"]);
        Ri:
        $this->util->mo_oauth_client_delete_option("\x70\141\x73\x73\167\x6f\x72\144");
        $this->util->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\103\x75\163\164\157\155\x65\162\40\x72\x65\164\x72\151\145\166\145\x64\40\163\165\143\143\145\x73\x73\x66\x75\x6c\154\x79");
        $this->util->mo_oauth_client_delete_option("\x76\x65\162\x69\x66\171\x5f\143\165\x73\164\x6f\x6d\x65\162");
        $this->util->mo_oauth_show_success_message();
        xM:
        vv:
        if (!(isset($_POST["\155\157\x5f\x6f\141\x75\x74\x68\137\x63\150\141\156\x67\145\x5f\x65\155\x61\x69\x6c\137\156\x6f\x6e\143\x65"]) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST["\155\157\x5f\x6f\x61\x75\164\150\x5f\143\150\141\156\147\x65\x5f\x65\x6d\x61\x69\154\x5f\156\x6f\156\x63\x65"])), "\x6d\157\x5f\x6f\141\x75\164\x68\x5f\143\x68\x61\x6e\147\145\x5f\x65\x6d\141\x69\x6c") && isset($_POST[\MoOAuthConstants::OPTION]) && "\x6d\157\x5f\x6f\x61\165\164\150\137\143\150\x61\156\147\x65\137\x65\155\x61\x69\154" === $_POST[\MoOAuthConstants::OPTION])) {
            goto aT;
        }
        $this->util->mo_oauth_client_update_option("\x76\x65\162\151\x66\171\137\143\165\163\164\x6f\155\145\x72", '');
        $this->util->mo_oauth_client_update_option("\155\157\137\x6f\141\165\164\x68\x5f\x72\145\147\151\x73\164\x72\141\164\x69\x6f\x6e\x5f\163\164\x61\x74\x75\x73", '');
        $this->util->mo_oauth_client_update_option("\x6e\x65\167\137\x72\x65\147\151\163\x74\162\x61\164\x69\157\156", "\x74\162\165\x65");
        aT:
        if (!(isset($_POST["\x6d\157\137\x6f\x61\x75\164\x68\137\143\x6f\156\164\x61\143\x74\137\165\x73\137\x71\165\145\162\171\137\x6f\x70\x74\151\157\x6e\x5f\156\x6f\x6e\x63\145"]) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST["\155\x6f\137\x6f\141\x75\164\150\x5f\143\x6f\x6e\164\x61\x63\x74\x5f\x75\x73\137\x71\165\x65\162\171\x5f\x6f\x70\164\151\x6f\x6e\x5f\x6e\157\156\143\x65"])), "\x6d\x6f\137\x6f\141\x75\x74\150\137\x63\157\x6e\164\x61\143\164\x5f\165\x73\x5f\161\165\x65\162\x79\x5f\157\x70\164\x69\x6f\x6e") && isset($_POST[\MoOAuthConstants::OPTION]) && "\155\157\x5f\157\x61\165\x74\150\x5f\143\157\x6e\x74\141\x63\x74\137\165\163\x5f\161\165\x65\x72\x79\x5f\157\x70\164\151\157\x6e" === $_POST[\MoOAuthConstants::OPTION])) {
            goto h3;
        }
        if (!($this->util->mo_oauth_is_curl_installed() === 0)) {
            goto Gr;
        }
        return $this->util->mo_oauth_show_curl_error();
        Gr:
        $xv = isset($_POST["\x6d\x6f\x5f\157\x61\165\164\150\x5f\143\x6f\x6e\x74\x61\143\x74\137\x75\x73\137\x65\155\x61\151\x6c"]) ? sanitize_text_field(wp_unslash($_POST["\155\157\x5f\x6f\141\165\164\x68\x5f\x63\x6f\156\x74\x61\143\164\x5f\x75\x73\x5f\145\x6d\141\x69\154"])) : '';
        $Fs = isset($_POST["\155\157\x5f\x6f\141\165\164\150\x5f\143\157\x6e\x74\x61\x63\164\137\x75\163\x5f\x70\x68\157\156\x65"]) ? sanitize_text_field(wp_unslash($_POST["\x6d\x6f\137\x6f\x61\165\x74\150\x5f\143\x6f\x6e\x74\x61\x63\x74\x5f\165\163\137\160\x68\157\156\x65"])) : '';
        $LD = isset($_POST["\x6d\x6f\137\157\x61\165\x74\150\137\x63\x6f\x6e\164\x61\x63\164\x5f\x75\163\x5f\161\165\145\x72\171"]) ? sanitize_text_field(wp_unslash($_POST["\x6d\x6f\x5f\157\141\165\164\150\137\143\x6f\156\x74\x61\143\164\x5f\x75\x73\137\x71\165\145\162\x79"])) : '';
        $ir = isset($_POST["\155\157\x5f\x6f\x61\165\x74\x68\x5f\x73\x65\x6e\x64\x5f\160\x6c\165\147\151\156\137\x63\157\x6e\x66\x69\x67"]);
        $RA = new Customer();
        if ($this->util->mo_oauth_check_empty_or_null($xv) || $this->util->mo_oauth_check_empty_or_null($LD)) {
            goto U1;
        }
        $To = $RA->submit_contact_us($xv, $Fs, $LD, $ir);
        if (false === $To) {
            goto me;
        }
        $this->util->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\124\150\x61\156\x6b\x73\40\x66\157\162\40\147\145\164\164\x69\x6e\x67\40\151\156\x20\164\x6f\x75\143\150\41\40\x57\x65\x20\x73\x68\141\x6c\x6c\40\147\145\164\x20\142\141\143\153\x20\164\x6f\40\171\157\165\40\x73\150\157\162\164\x6c\x79\x2e");
        $this->util->mo_oauth_show_success_message();
        goto Ni;
        me:
        $this->util->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\x59\x6f\x75\162\x20\161\165\x65\162\x79\x20\143\x6f\165\x6c\x64\x20\156\157\164\40\x62\145\x20\163\x75\x62\x6d\151\164\164\x65\144\x2e\40\x50\154\x65\141\x73\x65\40\164\162\171\40\141\x67\141\x69\156\56");
        $this->util->mo_oauth_show_error_message();
        Ni:
        goto bP;
        U1:
        $this->util->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\x50\x6c\145\x61\163\145\40\146\x69\154\154\x20\x75\x70\40\105\x6d\141\x69\x6c\x20\141\x6e\x64\x20\121\165\x65\162\x79\40\146\151\x65\x6c\144\163\40\164\x6f\40\x73\165\142\x6d\x69\x74\x20\x79\x6f\165\x72\x20\x71\x75\x65\x72\171\x2e");
        $this->util->mo_oauth_show_error_message();
        bP:
        h3:
        do_action("\x64\x6f\137\x6d\141\x69\x6e\x5f\163\145\x74\164\x69\x6e\147\x73\x5f\151\x6e\x74\145\x72\156\141\154", $_POST);
    }
    public function mo_oauth_get_current_customer()
    {
        $RA = new Customer();
        $PI = $RA->get_customer_key();
        $mH = json_decode($PI, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            goto cd;
        }
        $this->util->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\x59\x6f\165\x20\x61\x6c\162\x65\141\144\171\40\150\141\x76\x65\x20\x61\156\40\141\143\143\157\165\156\164\x20\167\151\x74\x68\40\155\151\x6e\151\x4f\x72\x61\156\x67\145\x2e\x20\x50\154\x65\141\163\x65\x20\145\x6e\x74\145\x72\40\141\x20\x76\x61\x6c\x69\144\x20\x70\141\163\x73\167\x6f\162\144\56");
        $this->util->mo_oauth_client_update_option("\166\x65\162\151\146\171\x5f\143\x75\163\x74\157\x6d\145\x72", "\164\162\x75\145");
        $this->util->mo_oauth_show_error_message();
        goto pE;
        cd:
        $this->util->mo_oauth_client_update_option("\155\157\x5f\157\x61\165\164\150\x5f\x61\144\x6d\151\x6e\x5f\x63\x75\x73\x74\157\155\145\x72\x5f\153\145\x79", $mH["\x69\x64"]);
        $this->util->mo_oauth_client_update_option("\x6d\157\137\x6f\x61\165\164\150\137\141\144\x6d\151\x6e\x5f\x61\x70\x69\x5f\153\145\171", $mH["\x61\160\x69\113\145\x79"]);
        $this->util->mo_oauth_client_update_option("\x63\x75\163\164\x6f\x6d\145\x72\x5f\164\x6f\x6b\x65\156", $mH["\x74\x6f\153\145\156"]);
        $this->util->mo_oauth_client_update_option("\x70\x61\163\x73\167\157\x72\144", '');
        $this->util->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\x43\165\163\164\157\155\145\162\x20\x72\x65\x74\162\151\x65\166\145\144\x20\163\165\x63\143\x65\163\163\x66\165\154\x6c\x79");
        $this->util->mo_oauth_client_delete_option("\166\x65\x72\x69\146\171\137\143\x75\163\x74\x6f\x6d\145\x72");
        $this->util->mo_oauth_client_delete_option("\156\x65\167\137\x72\x65\x67\x69\163\164\162\141\x74\151\157\156");
        $this->util->mo_oauth_show_success_message();
        pE:
    }
    public function create_customer()
    {
        global $xW;
        $RA = new Customer();
        $mH = json_decode($RA->create_customer(), true);
        if (strcasecmp($mH["\x73\x74\x61\164\x75\163"], "\103\125\123\x54\x4f\x4d\105\122\x5f\125\x53\105\122\x4e\101\115\x45\137\101\114\122\x45\101\x44\131\x5f\x45\130\x49\123\x54\x53") === 0) {
            goto x2;
        }
        if (strcasecmp($mH["\163\x74\141\x74\x75\163"], "\x53\x55\103\103\x45\123\123") === 0) {
            goto lI;
        }
        goto N3;
        x2:
        $this->mo_oauth_get_current_customer();
        $this->util->mo_oauth_client_delete_option("\x6d\x6f\137\x6f\x61\165\164\150\137\156\145\167\137\143\165\x73\x74\x6f\x6d\x65\x72");
        goto N3;
        lI:
        $this->util->mo_oauth_client_update_option("\155\x6f\137\x6f\x61\165\164\150\137\141\144\x6d\151\156\x5f\143\x75\163\164\x6f\155\x65\x72\137\x6b\x65\x79", $mH["\151\144"]);
        $this->util->mo_oauth_client_update_option("\155\x6f\137\157\141\x75\x74\x68\x5f\x61\x64\155\x69\x6e\x5f\141\x70\151\137\x6b\145\x79", $mH["\x61\x70\x69\113\x65\171"]);
        $this->util->mo_oauth_client_update_option("\143\x75\163\164\x6f\x6d\145\162\x5f\164\x6f\153\x65\x6e", $mH["\x74\157\153\x65\156"]);
        $this->util->mo_oauth_client_update_option("\x70\x61\x73\x73\167\x6f\162\x64", '');
        $this->util->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\x52\x65\147\x69\163\x74\145\x72\145\x64\40\163\165\x63\143\145\163\163\x66\165\154\154\x79\56");
        $this->util->mo_oauth_client_update_option("\155\x6f\x5f\157\141\165\x74\150\137\162\x65\x67\151\x73\164\x72\x61\164\x69\157\156\137\163\x74\141\x74\165\163", "\x4d\x4f\x5f\x4f\x41\x55\x54\110\137\x52\105\x47\x49\x53\124\122\x41\x54\111\117\x4e\x5f\x43\x4f\x4d\120\114\105\x54\105");
        $this->util->mo_oauth_client_update_option("\155\x6f\137\x6f\141\x75\x74\x68\137\x6e\145\167\137\x63\165\163\164\157\155\145\162", 1);
        $this->util->mo_oauth_client_delete_option("\x76\x65\x72\x69\x66\x79\137\x63\x75\x73\x74\x6f\155\145\x72");
        $this->util->mo_oauth_client_delete_option("\x6e\145\167\137\x72\x65\x67\x69\163\164\162\141\164\x69\x6f\156");
        $this->util->mo_oauth_show_success_message();
        N3:
    }
}
