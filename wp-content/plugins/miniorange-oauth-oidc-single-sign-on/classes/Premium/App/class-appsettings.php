<?php


namespace MoOauthClient\Premium;

use MoOauthClient\App;
use MoOauthClient\Standard\AppSettings as StandardAppSettings;
class AppSettings extends StandardAppSettings
{
    public function __construct()
    {
        parent::__construct();
        add_action("\155\x6f\x5f\157\141\165\164\x68\137\143\x6c\x69\145\156\x74\137\x73\141\166\x65\x5f\x61\160\160\137\x73\145\164\164\x69\x6e\147\163\x5f\151\x6e\x74\145\x72\156\x61\154", array($this, "\163\x61\x76\x65\137\x72\x6f\154\x65\137\x6d\x61\x70\x70\151\x6e\147"));
    }
    public function change_app_settings($post, $k0)
    {
        global $xW;
        $k0 = parent::change_app_settings($post, $k0);
        $k0["\x67\x72\x6f\165\160\144\145\164\141\x69\x6c\x73\x75\162\154"] = isset($post["\155\157\x5f\x6f\x61\x75\x74\x68\137\x67\162\157\x75\160\x64\x65\164\141\x69\154\163\165\x72\x6c"]) ? trim(stripslashes($post["\155\x6f\137\x6f\141\x75\x74\x68\137\147\x72\x6f\x75\160\x64\x65\164\141\151\x6c\163\x75\x72\154"])) : '';
        $k0["\x6a\x77\x6b\x73\x75\162\x6c"] = isset($post["\155\157\137\157\141\165\x74\x68\x5f\152\x77\x6b\163\165\162\x6c"]) ? trim(stripslashes($post["\155\157\137\157\141\x75\x74\x68\x5f\152\167\153\163\x75\162\154"])) : '';
        $k0["\x67\x72\141\x6e\x74\137\164\171\160\145"] = isset($post["\x67\162\x61\156\x74\x5f\164\171\160\x65"]) ? stripslashes($post["\x67\x72\x61\156\x74\137\x74\171\x70\145"]) : "\x41\x75\x74\150\157\162\x69\x7a\x61\164\x69\x6f\156\x20\103\157\x64\x65\40\107\x72\141\156\x74";
        if (isset($post["\x65\x6e\x61\142\154\x65\137\157\x61\165\164\150\x5f\x77\x70\137\x6c\x6f\147\151\156"]) && "\x6f\x6e" === $post["\x65\x6e\x61\x62\x6c\145\x5f\x6f\141\165\164\x68\137\167\x70\x5f\154\x6f\x67\151\156"]) {
            goto Pz;
        }
        $xW->mo_oauth_client_delete_option("\155\157\x5f\x6f\141\165\164\150\x5f\x65\156\141\142\x6c\x65\137\x6f\141\165\x74\x68\137\x77\x70\x5f\x6c\x6f\x67\151\156");
        goto hq;
        Pz:
        $xW->mo_oauth_client_update_option("\x6d\x6f\137\x6f\x61\165\x74\x68\137\145\156\x61\x62\154\145\x5f\157\141\x75\x74\x68\x5f\x77\160\137\154\157\147\151\x6e", $k0["\x61\160\x70\111\x64"]);
        hq:
        return $k0;
    }
    public function save_grant_settings()
    {
        if (!(!isset($_POST["\155\157\x5f\157\x61\x75\x74\150\x5f\147\162\x61\156\164\x5f\163\145\164\x74\151\156\x67\163\x5f\156\x6f\x6e\143\x65"]) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST["\155\x6f\x5f\157\x61\x75\x74\150\137\x67\162\141\x6e\164\x5f\x73\x65\x74\164\x69\156\x67\163\137\x6e\x6f\156\143\145"])), "\155\157\137\x6f\x61\x75\164\x68\137\x67\162\x61\156\x74\x5f\163\145\164\x74\x69\x6e\147\x73"))) {
            goto q2;
        }
        return;
        q2:
        $post = $_POST;
        if (!(!isset($post[\MoOAuthConstants::OPTION]) || "\x6d\157\x5f\x6f\x61\x75\x74\150\x5f\147\162\141\156\164\137\163\145\164\x74\x69\156\147\163" !== $post[\MoOAuthConstants::OPTION])) {
            goto gj;
        }
        return;
        gj:
        if (!(!isset($post[\MoOAuthConstants::POST_APP_NAME]) || empty($post[\MoOAuthConstants::POST_APP_NAME]))) {
            goto la;
        }
        return;
        la:
        global $xW;
        $iR = $post[\MoOAuthConstants::POST_APP_NAME];
        $k0 = $xW->get_app_by_name($iR);
        $k0 = $k0->get_app_config();
        $k0["\x6a\x77\x74\x5f\x73\165\160\160\157\x72\164"] = isset($post["\x6a\167\164\137\163\165\160\160\x6f\x72\164"]) ? 1 : 0;
        $k0["\152\167\164\137\x61\x6c\x67\157"] = isset($post["\152\167\164\137\x61\154\147\x6f"]) ? stripslashes($post["\x6a\x77\164\137\x61\x6c\147\157"]) : "\110\x53\101";
        if ("\122\x53\x41" === $k0["\x6a\167\x74\x5f\x61\154\147\x6f"]) {
            goto qr;
        }
        if (!isset($k0["\x78\x35\x30\x39\x5f\143\x65\162\x74"])) {
            goto Gy;
        }
        unset($k0["\x78\x35\60\71\x5f\143\x65\x72\x74"]);
        Gy:
        goto ml;
        qr:
        $k0["\170\x35\x30\x39\137\x63\x65\x72\164"] = isset($post["\x6d\157\137\157\141\x75\164\150\137\170\x35\60\71\x5f\x63\145\162\164"]) ? stripslashes($post["\x6d\157\137\157\141\165\164\x68\x5f\x78\65\60\x39\137\x63\145\162\x74"]) : '';
        ml:
        $xW->set_app_by_name($iR, $k0);
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\x59\157\165\x72\x20\x53\145\164\x74\151\x6e\x67\x73\x20\x68\141\166\x65\x20\142\145\145\x6e\40\163\141\166\x65\144\40\x73\165\143\143\x65\163\163\x66\x75\154\154\171\x2e");
        $xW->mo_oauth_show_success_message();
        wp_safe_redirect("\141\x64\x6d\x69\156\x2e\x70\x68\x70\77\160\141\147\x65\75\x6d\x6f\137\157\141\x75\x74\150\x5f\163\145\164\x74\x69\x6e\147\163\x26\x61\143\x74\x69\x6f\156\75\x75\x70\144\141\164\x65\x26\141\160\x70\x3d" . rawurlencode($iR));
    }
    public function change_attribute_mapping($post, $k0)
    {
        $k0 = parent::change_attribute_mapping($post, $k0);
        $k0["\147\x72\157\165\160\156\x61\155\145\137\141\x74\x74\162\x69\142\165\x74\x65"] = isset($post["\x6d\141\x70\160\151\x6e\x67\x5f\147\162\157\x75\160\156\141\x6d\145\137\141\x74\x74\162\151\x62\165\164\x65"]) ? trim(stripslashes($post["\x6d\141\160\160\x69\x6e\147\137\147\162\x6f\165\160\x6e\141\155\145\x5f\141\164\164\x72\151\142\165\x74\145"])) : '';
        $c5 = array();
        $MC = 0;
        foreach ($post as $qV => $sw) {
            if (!(strpos($qV, "\x6d\x6f\x5f\157\x61\x75\x74\150\x5f\x63\x6c\x69\x65\156\164\137\x63\165\x73\164\x6f\x6d\137\x61\x74\164\x72\x69\142\165\x74\x65\x5f\x6b\145\x79") !== false && !empty($post[$qV]))) {
                goto sI;
            }
            $MC++;
            $tI = "\x6d\x6f\x5f\x6f\141\165\x74\x68\137\143\x6c\151\145\x6e\x74\x5f\x63\x75\x73\x74\157\x6d\137\x61\x74\164\162\x69\x62\165\x74\x65\137\x76\x61\x6c\165\x65\137" . $MC;
            $c5[$sw] = $post[$tI];
            sI:
            F8:
        }
        Bf:
        $k0["\143\x75\x73\x74\x6f\155\137\x61\x74\164\162\163\137\x6d\x61\160\160\x69\156\147"] = $c5;
        return $k0;
    }
    public function save_role_mapping()
    {
        global $xW;
        if (!(isset($_POST["\155\157\x5f\157\141\x75\x74\x68\x5f\143\154\x69\145\156\x74\137\163\141\x76\x65\137\162\x6f\x6c\145\137\x6d\141\x70\160\151\x6e\x67\137\x6e\157\x6e\x63\145"]) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST["\155\157\137\157\141\x75\164\x68\x5f\143\x6c\x69\145\156\164\x5f\x73\141\x76\x65\137\162\157\154\145\x5f\155\141\160\x70\x69\156\147\137\156\x6f\x6e\x63\x65"])), "\155\157\137\x6f\141\x75\164\150\137\x63\x6c\151\145\x6e\164\x5f\x73\141\166\x65\137\162\157\x6c\145\137\155\x61\x70\x70\151\156\147") && isset($_POST[\MoOAuthConstants::OPTION]) && "\x6d\x6f\x5f\157\141\x75\x74\x68\137\143\154\151\x65\x6e\164\x5f\163\x61\166\x65\x5f\x72\x6f\154\x65\x5f\155\x61\160\x70\151\156\147" === $_POST[\MoOAuthConstants::OPTION])) {
            goto MA;
        }
        $Sm = sanitize_text_field(wp_unslash(isset($_POST[\MoOAuthConstants::POST_APP_NAME]) ? $_POST[\MoOAuthConstants::POST_APP_NAME] : ''));
        $eL = $xW->get_app_by_name($Sm);
        $mh = $eL->get_app_config();
        $mh["\153\145\x65\x70\x5f\x65\170\151\163\164\151\156\x67\x5f\165\x73\x65\x72\137\x72\157\x6c\x65\x73"] = isset($_POST["\153\145\x65\x70\x5f\x65\170\151\x73\164\151\156\x67\x5f\165\x73\x65\162\137\162\157\154\x65\163"]) ? sanitize_text_field(wp_unslash($_POST["\x6b\x65\145\x70\137\x65\x78\151\163\164\151\156\x67\137\x75\x73\145\x72\x5f\162\x6f\x6c\145\x73"])) : 0;
        $mh["\x72\145\163\164\x72\151\x63\164\x5f\154\157\147\151\156\x5f\x66\x6f\x72\x5f\155\141\160\x70\x65\x64\137\162\157\154\145\163"] = isset($_POST["\x72\145\x73\x74\162\151\143\x74\137\x6c\157\147\x69\156\x5f\146\157\162\137\155\141\x70\x70\145\x64\137\x72\x6f\154\x65\163"]) ? sanitize_text_field(wp_unslash($_POST["\x72\145\x73\164\162\x69\x63\x74\x5f\x6c\x6f\147\151\156\x5f\146\157\162\137\x6d\141\x70\x70\145\144\x5f\162\157\x6c\x65\x73"])) : false;
        $p9 = 100;
        $I3 = 0;
        $MC = 1;
        UC:
        if (!($MC <= $p9)) {
            goto Z1;
        }
        if (isset($_POST[\MoOAuthConstants::MAP_KEY . $MC])) {
            goto vl;
        }
        goto Z1;
        goto WX;
        vl:
        if (!('' === $_POST[\MoOAuthConstants::MAP_KEY . $MC])) {
            goto x5;
        }
        goto VT;
        x5:
        $mh["\x5f\x6d\141\160\x70\151\x6e\147\x5f\x6b\x65\x79\x5f" . $MC] = sanitize_text_field(wp_unslash(isset($_POST[\MoOAuthConstants::MAP_KEY . $MC]) ? $_POST[\MoOAuthConstants::MAP_KEY . $MC] : ''));
        $mh["\137\x6d\x61\160\x70\x69\156\x67\x5f\166\x61\154\165\145\137" . $MC] = sanitize_text_field(wp_unslash(isset($_POST["\155\x61\x70\x70\x69\156\x67\x5f\166\141\154\x75\x65\x5f" . $MC]) ? $_POST["\155\141\x70\160\151\x6e\147\137\166\141\x6c\x75\145\137" . $MC] : ''));
        $I3++;
        WX:
        VT:
        $MC++;
        goto UC;
        Z1:
        $mh["\x72\157\x6c\145\x5f\x6d\141\x70\160\151\x6e\x67\137\x63\157\x75\x6e\164"] = $I3;
        $mh["\137\155\141\x70\160\x69\156\x67\137\166\141\154\x75\x65\137\144\145\x66\x61\x75\x6c\164"] = sanitize_text_field(wp_unslash(isset($_POST["\x6d\x61\160\x70\151\156\147\137\166\x61\154\165\x65\x5f\144\145\x66\x61\x75\154\164"]) ? $_POST["\155\141\x70\160\151\x6e\x67\137\166\x61\x6c\165\x65\137\144\x65\146\141\165\154\x74"] : ''));
        $Nr = $xW->set_app_by_name($Sm, $mh);
        if (!$Nr) {
            goto fC;
        }
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\131\157\165\x72\40\x73\145\164\x74\151\156\x67\163\40\x61\162\x65\40\163\x61\166\x65\144\x20\x73\165\x63\143\145\163\x73\146\165\x6c\x6c\171\x2e");
        $xW->mo_oauth_show_success_message();
        goto yv;
        fC:
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\x54\x68\x65\x72\145\x20\167\141\163\40\x61\156\40\145\x72\x72\x6f\162\40\163\141\166\151\x6e\x67\40\x73\x65\164\x74\x69\156\147\x73\56");
        $xW->mo_oauth_show_error_message();
        yv:
        wp_safe_redirect("\141\x64\155\x69\156\x2e\160\150\160\x3f\160\141\x67\145\75\x6d\x6f\x5f\157\141\x75\x74\150\137\x73\x65\x74\x74\151\x6e\147\163\x26\x74\x61\142\75\x63\157\x6e\146\x69\x67\x26\141\143\x74\x69\x6f\x6e\x3d\165\160\x64\x61\164\x65\x26\141\x70\160\75" . rawurlencode($Sm));
        MA:
    }
}
