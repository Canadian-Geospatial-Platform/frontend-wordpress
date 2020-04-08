<?php


namespace MoOauthClient\Free;

use MoOauthClient\App;
class AppSettings
{
    private $app_config;
    public function __construct()
    {
        $this->app_config = array("\x63\154\x69\x65\x6e\164\137\151\144", "\143\154\151\145\156\164\x5f\163\x65\143\x72\x65\x74", "\x73\143\157\160\x65", "\x72\145\144\151\162\x65\x63\x74\137\x75\162\151", "\x61\160\160\137\164\171\160\145", "\x61\x75\x74\x68\x6f\x72\151\172\x65\165\x72\154", "\x61\x63\143\145\x73\163\x74\x6f\x6b\145\x6e\x75\x72\154", "\162\145\x73\x6f\x75\162\x63\x65\157\x77\156\145\x72\x64\x65\164\141\151\154\163\x75\162\x6c", "\147\x72\157\x75\160\x64\x65\164\x61\151\154\163\x75\x72\154", "\x6a\x77\153\x73\x5f\x75\x72\x69", "\x64\x69\x73\160\154\141\x79\x61\160\x70\156\x61\155\145", "\141\x70\160\111\x64");
    }
    public function save_app_settings()
    {
        global $xW;
        if (!(isset($_POST["\x6d\157\137\x6f\x61\165\x74\x68\137\x61\x64\144\137\x61\160\160\x5f\x6e\x6f\x6e\x63\145"]) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST["\x6d\157\137\157\141\x75\164\x68\137\141\x64\144\137\141\x70\x70\137\156\157\x6e\143\145"])), "\x6d\157\137\157\x61\x75\164\150\x5f\x61\144\x64\137\x61\x70\160") && isset($_POST[\MoOAuthConstants::OPTION]) && "\155\157\137\x6f\141\165\164\150\137\141\144\x64\137\x61\160\x70" === $_POST[\MoOAuthConstants::OPTION])) {
            goto Kt;
        }
        if (!($xW->mo_oauth_check_empty_or_null($_POST["\155\157\x5f\x6f\141\x75\164\150\x5f\143\x6c\x69\145\x6e\164\137\x69\144"]) || $xW->mo_oauth_check_empty_or_null($_POST["\155\157\137\157\141\x75\x74\150\137\143\x6c\x69\x65\x6e\x74\x5f\163\x65\143\162\145\x74"]))) {
            goto Oc;
        }
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\120\x6c\x65\x61\163\145\x20\x65\156\164\x65\x72\40\166\x61\x6c\151\144\40\x43\x6c\151\145\x6e\164\40\x49\x44\x20\x61\x6e\144\40\x43\154\151\x65\156\x74\x20\123\145\x63\x72\145\x74\56");
        $xW->mo_oauth_show_error_message();
        return;
        Oc:
        $Sm = isset($_POST["\155\157\137\x6f\x61\x75\x74\x68\x5f\x63\165\163\164\x6f\155\x5f\x61\160\160\137\156\141\x6d\145"]) ? sanitize_text_field(wp_unslash($_POST["\x6d\157\x5f\x6f\x61\x75\x74\x68\137\143\165\x73\164\157\x6d\137\x61\160\160\x5f\156\141\x6d\145"])) : false;
        $k0 = $xW->get_app_by_name($Sm);
        $k0 = false !== $k0 ? $k0->get_app_config() : array();
        $QY = false !== $k0;
        $rj = $xW->get_app_list();
        if (!(!$QY && is_array($rj) && count($rj) > 0 && !$xW->check_versi(3))) {
            goto wW;
        }
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\131\157\165\x20\143\x61\156\40\x6f\x6e\x6c\171\40\x61\144\144\x20\61\40\141\x70\160\x6c\x69\x63\141\164\151\x6f\x6e\40\167\x69\x74\x68\40\x66\x72\x65\145\40\x76\x65\x72\163\151\x6f\x6e\56\40\125\160\x67\x72\141\144\x65\x20\x74\x6f\40\145\156\164\x65\162\160\162\x69\x73\145\x20\166\145\162\163\x69\157\156\x20\x69\146\40\x79\157\165\40\167\x61\156\164\40\x74\157\x20\x61\x64\144\40\x6d\x6f\162\145\40\x61\160\x70\x6c\151\143\141\x74\x69\157\156\x73\56");
        $xW->mo_oauth_show_error_message();
        return;
        wW:
        $k0 = !is_array($k0) || empty($k0) ? array() : $k0;
        $k0 = $this->change_app_settings($_POST, $k0);
        $rj[$Sm] = new App($k0);
        $rj[$Sm]->set_app_name($Sm);
        $xW->mo_oauth_client_update_option("\155\157\x5f\x6f\141\x75\164\150\137\141\160\x70\x73\x5f\154\x69\163\164", $rj);
        wp_redirect("\141\144\155\151\x6e\x2e\160\x68\160\x3f\160\141\x67\x65\x3d\155\157\x5f\157\141\x75\164\150\137\163\145\164\x74\x69\156\x67\x73\46\164\x61\x62\75\143\157\x6e\146\151\147\46\141\x63\164\x69\x6f\x6e\75\165\160\144\x61\164\145\x26\x61\x70\x70\x3d" . urlencode($Sm));
        Kt:
        if (!(isset($_POST["\155\x6f\x5f\x6f\x61\165\164\150\x5f\x61\x74\x74\x72\x69\x62\x75\164\145\x5f\x6d\141\x70\160\151\156\x67\137\156\157\156\x63\145"]) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST["\155\157\137\157\x61\165\164\150\137\x61\x74\x74\x72\x69\142\x75\x74\145\137\x6d\141\x70\160\151\x6e\147\x5f\156\x6f\156\x63\145"])), "\x6d\x6f\x5f\157\141\x75\x74\x68\137\141\164\164\x72\151\x62\x75\164\x65\137\x6d\141\160\x70\x69\x6e\x67") && isset($_POST[\MoOAuthConstants::OPTION]) && "\x6d\157\137\x6f\141\x75\x74\150\137\x61\x74\164\162\x69\142\x75\x74\145\x5f\x6d\x61\160\160\x69\156\x67" === $_POST[\MoOAuthConstants::OPTION])) {
            goto S8;
        }
        global $xW;
        $Sm = sanitize_text_field(wp_unslash(isset($_POST[\MoOAuthConstants::POST_APP_NAME]) ? $_POST[\MoOAuthConstants::POST_APP_NAME] : ''));
        $eL = $xW->get_app_by_name($Sm);
        $mh = $eL->get_app_config();
        $mh = $this->change_attribute_mapping($_POST, $mh);
        $Nr = $xW->set_app_by_name($Sm, $mh);
        if (!$Nr) {
            goto IL;
        }
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\x59\x6f\x75\x72\x20\163\145\x74\x74\x69\x6e\147\163\x20\141\x72\x65\x20\163\141\x76\145\144\40\163\165\143\143\x65\163\x73\x66\165\x6c\154\171\x2e");
        $xW->mo_oauth_show_success_message();
        goto eC;
        IL:
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\x54\150\x65\x72\x65\40\167\x61\163\40\x61\156\x20\145\x72\x72\157\162\40\163\141\x76\151\x6e\147\x20\163\x65\164\164\151\156\x67\163\x2e");
        $xW->mo_oauth_show_error_message();
        eC:
        wp_safe_redirect("\141\144\x6d\x69\156\56\160\150\160\77\x70\x61\147\x65\75\x6d\x6f\137\x6f\141\165\x74\x68\x5f\163\145\164\x74\x69\156\147\x73\46\x74\141\x62\x3d\143\157\156\x66\151\147\x26\x61\x63\x74\151\157\x6e\75\x75\160\144\x61\164\145\46\x61\160\x70\75" . rawurlencode($Sm));
        S8:
        do_action("\x6d\157\137\x6f\141\x75\164\150\x5f\143\154\x69\x65\156\x74\137\163\x61\x76\145\x5f\x61\x70\x70\137\x73\x65\164\164\x69\x6e\x67\x73\x5f\x69\156\164\145\x72\156\141\x6c");
    }
    public function change_app_settings($post, $k0)
    {
        global $xW;
        $Sm = sanitize_text_field(wp_unslash(isset($post[\MoOAuthConstants::POST_APP_NAME]) ? $post[\MoOAuthConstants::POST_APP_NAME] : ''));
        $k0["\x73\143\x6f\x70\145"] = sanitize_text_field(wp_unslash(isset($post["\155\157\137\x6f\x61\165\x74\150\x5f\x73\x63\157\160\x65"]) ? $post["\155\x6f\137\157\x61\165\x74\x68\x5f\163\143\157\x70\x65"] : ''));
        $k0["\x63\x6c\151\x65\156\164\137\151\x64"] = sanitize_text_field(wp_unslash(isset($post["\x6d\157\x5f\157\x61\165\164\150\x5f\x63\x6c\x69\x65\x6e\x74\137\x69\x64"]) ? $post["\x6d\x6f\137\157\141\165\164\150\x5f\143\154\x69\145\156\x74\x5f\151\144"] : ''));
        $k0["\143\154\x69\145\156\164\x5f\163\145\x63\x72\145\164"] = sanitize_text_field(wp_unslash(isset($post["\155\x6f\x5f\157\141\165\x74\150\x5f\143\154\x69\x65\x6e\x74\137\163\145\x63\x72\x65\164"]) ? $post["\155\157\137\x6f\x61\165\x74\x68\137\x63\x6c\x69\x65\156\x74\137\x73\x65\143\x72\x65\164"] : ''));
        $k0["\x73\x65\x6e\144\x5f\150\x65\141\x64\x65\x72\163"] = isset($post["\x6d\x6f\x5f\x6f\141\x75\x74\150\x5f\x61\165\164\150\x6f\162\x69\x7a\141\x74\x69\x6f\156\x5f\150\145\x61\144\145\x72"]) ? (int) filter_var($post["\x6d\157\x5f\x6f\x61\x75\x74\150\x5f\x61\x75\164\150\x6f\162\151\x7a\141\x74\x69\157\x6e\137\150\145\x61\x64\x65\x72"], FILTER_SANITIZE_NUMBER_INT) : 0;
        $k0["\163\145\156\x64\x5f\x62\x6f\144\x79"] = isset($post["\155\x6f\x5f\157\141\x75\x74\x68\x5f\x62\157\x64\x79"]) ? (int) filter_var($post["\x6d\x6f\x5f\x6f\x61\165\x74\x68\137\142\x6f\x64\x79"], FILTER_SANITIZE_NUMBER_INT) : 0;
        $k0["\163\150\x6f\x77\x5f\157\156\137\154\157\x67\151\x6e\137\x70\x61\x67\x65"] = isset($post["\155\x6f\x5f\157\x61\165\164\x68\137\x73\x68\157\167\x5f\157\156\x5f\154\x6f\x67\x69\156\x5f\x70\141\147\x65"]) ? (int) filter_var($post["\x6d\x6f\x5f\x6f\x61\x75\164\150\137\163\x68\x6f\167\137\157\156\137\154\x6f\x67\151\x6e\137\160\141\x67\145"], FILTER_SANITIZE_NUMBER_INT) : 0;
        $k0["\x61\160\x70\x49\144"] = $Sm;
        $k0["\x72\x65\144\x69\x72\x65\x63\x74\x5f\x75\x72\x69"] = site_url();
        $xW->mo_oauth_client_update_option("\155\157\x5f\157\x61\x75\x74\150\137\x63\x6c\151\x65\x6e\x74\x5f\x64\151\163\141\142\154\x65\x5f\x61\165\164\150\x6f\162\x69\172\x61\164\x69\x6f\x6e\137\x68\145\x61\144\145\162", isset($post["\x64\x69\163\141\x62\x6c\145\x5f\x61\165\x74\150\x6f\x72\x69\172\x61\x74\151\x6f\x6e\137\150\145\141\144\x65\x72"]) ? boolval($post["\x64\x69\163\141\x62\x6c\145\137\x61\165\164\150\157\162\151\x7a\x61\164\x69\x6f\156\x5f\150\145\141\144\145\x72"]) : false);
        if ("\145\x76\x65\x6f\156\154\x69\x6e\x65" === $Sm) {
            goto wF;
        }
        $VQ = stripslashes($post["\x6d\x6f\137\x6f\141\165\x74\x68\137\141\x75\164\150\x6f\162\x69\x7a\x65\165\162\x6c"]);
        $ZP = stripslashes($post["\155\x6f\137\157\141\165\x74\x68\137\141\x63\x63\145\x73\x73\164\x6f\x6b\x65\156\x75\162\x6c"]);
        $Sm = stripslashes($post["\155\157\137\157\141\x75\x74\x68\137\143\x75\163\x74\x6f\155\137\141\x70\x70\x5f\x6e\141\x6d\x65"]);
        goto OE;
        wF:
        $xW->mo_oauth_client_update_option("\x6d\x6f\x5f\157\x61\x75\x74\x68\137\145\166\x65\x6f\156\x6c\151\x6e\145\137\x65\x6e\x61\142\154\x65", 1);
        $xW->mo_oauth_client_update_option("\x6d\157\137\157\x61\165\x74\150\x5f\x65\x76\x65\157\x6e\154\151\x6e\145\137\x63\154\x69\x65\x6e\x74\x5f\x69\x64", $J6);
        $xW->mo_oauth_client_update_option("\x6d\157\x5f\157\141\x75\164\x68\x5f\x65\166\x65\157\x6e\154\x69\x6e\x65\137\143\154\151\145\156\164\x5f\163\x65\143\x72\145\x74", $Jx);
        if (!($xW->mo_oauth_client_get_option("\x6d\157\137\x6f\141\x75\x74\150\137\145\x76\x65\157\x6e\154\x69\x6e\145\x5f\143\154\151\145\156\x74\x5f\151\x64") && $xW->mo_oauth_client_get_option("\x6d\x6f\137\157\141\x75\x74\x68\137\x65\x76\145\157\156\x6c\151\x6e\x65\137\x63\x6c\x69\145\x6e\x74\137\163\x65\143\162\x65\164"))) {
            goto sK;
        }
        $RA = new Customer();
        $wP = $RA->add_oauth_application("\145\x76\145\x6f\x6e\x6c\151\x6e\x65", "\x45\126\105\x20\x4f\x6e\154\151\x6e\145\40\117\101\165\x74\x68");
        if ("\x41\160\160\154\151\143\x61\x74\151\x6f\x6e\x20\103\162\145\141\164\x65\x64" === $wP) {
            goto MW;
        }
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, $wP);
        $this->mo_oauth_show_error_message();
        goto tz;
        MW:
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\131\157\x75\x72\40\163\x65\164\x74\151\156\x67\x73\x20\167\x65\x72\x65\x20\163\141\x76\x65\x64\56\40\107\x6f\40\x74\x6f\x20\101\144\166\141\x6e\143\145\144\40\105\126\105\x20\117\156\154\151\x6e\x65\40\x53\x65\164\x74\151\x6e\x67\x73\40\146\x6f\162\x20\x63\x6f\x6e\146\x69\147\165\x72\x69\x6e\147\40\x72\x65\x73\x74\x72\x69\x63\164\151\157\x6e\x73\40\x6f\156\40\x75\x73\145\162\40\163\x69\x67\x6e\40\151\x6e\x2e");
        $this->mo_oauth_show_success_message();
        tz:
        sK:
        $VQ = '';
        $ZP = '';
        $oj = '';
        OE:
        $k0["\141\165\x74\x68\x6f\162\151\172\x65\x75\x72\154"] = $VQ;
        $k0["\141\143\x63\x65\x73\163\x74\157\153\x65\156\165\162\154"] = $ZP;
        $k0["\141\x70\x70\x5f\164\171\x70\145"] = isset($post["\155\157\137\157\141\165\164\x68\137\x61\x70\x70\137\x74\x79\160\145"]) ? stripslashes($post["\x6d\x6f\x5f\157\141\x75\x74\150\x5f\141\x70\x70\137\164\171\x70\145"]) : stripslashes("\157\141\165\164\150");
        if (!($k0["\141\x70\x70\x5f\x74\171\160\x65"] == "\x6f\141\165\x74\150" || isset($post["\x6d\157\x5f\157\x61\x75\164\150\137\162\x65\x73\x6f\x75\162\143\145\x6f\x77\156\x65\162\x64\x65\164\x61\x69\154\x73\x75\162\x6c"]) && '' !== $post["\155\157\x5f\157\x61\x75\x74\150\137\x72\x65\x73\x6f\x75\x72\143\145\x6f\x77\156\145\162\x64\145\164\141\151\154\x73\x75\162\x6c"])) {
            goto g9;
        }
        $oj = stripslashes($post["\155\x6f\137\157\x61\x75\164\x68\137\x72\x65\163\157\165\x72\x63\x65\x6f\x77\x6e\x65\162\x64\145\164\141\x69\x6c\163\165\x72\x6c"]);
        if (!('' !== $oj)) {
            goto N2;
        }
        $k0["\x72\145\x73\157\165\x72\143\x65\x6f\167\156\x65\x72\144\x65\164\x61\151\x6c\x73\165\162\154"] = $oj;
        N2:
        g9:
        return $k0;
    }
    public function change_attribute_mapping($post, $k0)
    {
        $eA = stripslashes($post["\x6d\x6f\137\x6f\x61\x75\164\x68\x5f\x75\x73\145\162\x6e\141\155\145\137\x61\x74\x74\162"]);
        $k0["\165\163\145\x72\x6e\141\x6d\145\137\x61\164\164\162"] = $eA;
        return $k0;
    }
}
