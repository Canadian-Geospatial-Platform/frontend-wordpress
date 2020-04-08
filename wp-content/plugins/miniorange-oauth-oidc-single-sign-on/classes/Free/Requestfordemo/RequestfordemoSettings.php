<?php


namespace MoOauthClient\Free;

use MoOauthClient\Customer;
class RequestfordemoSettings
{
    public function save_requestdemo_settings()
    {
        global $xW;
        if (!(isset($_POST["\155\x6f\x5f\x6f\141\165\164\x68\137\141\x70\160\x5f\x72\145\x71\x75\x65\163\x74\x64\145\155\157\137\156\157\156\143\x65"]) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST["\155\157\x5f\x6f\141\x75\164\150\137\141\x70\x70\x5f\x72\145\x71\x75\x65\163\164\x64\145\x6d\157\x5f\156\157\156\x63\145"])), "\x6d\x6f\137\x6f\x61\x75\164\x68\137\x61\160\x70\x5f\162\145\161\x75\x65\163\x74\144\x65\x6d\x6f") && isset($_POST[\MoOAuthConstants::OPTION]) && "\x6d\157\137\x6f\x61\165\164\150\137\x61\160\x70\x5f\x72\x65\161\165\145\x73\164\x64\145\155\x6f" === $_POST[\MoOAuthConstants::OPTION])) {
            goto q0;
        }
        $xv = $_POST["\x6d\x6f\x5f\x6f\x61\165\164\x68\x5f\143\154\151\x65\x6e\164\x5f\144\145\155\157\x5f\145\155\141\x69\154"];
        $zW = $_POST["\x6d\157\137\157\141\165\164\x68\137\143\154\x69\145\156\164\x5f\x64\x65\155\x6f\x5f\160\x6c\141\156"];
        $LD = $_POST["\x6d\157\x5f\157\x61\x75\x74\150\x5f\x63\x6c\151\x65\156\164\x5f\x64\x65\155\157\137\x64\145\163\x63\162\151\x70\x74\x69\x6f\156"];
        $RA = new Customer();
        if ($xW->mo_oauth_check_empty_or_null($xv) || $xW->mo_oauth_check_empty_or_null($zW)) {
            goto yb;
        }
        $To = json_decode($RA->mo_oauth_send_demo_alert($xv, $zW, $LD, "\127\x50\40\x4f\101\165\x74\150\x20\123\151\156\x67\x6c\x65\x20\123\x69\147\156\x20\x4f\156\40\104\x65\155\x6f\x20\122\x65\161\165\x65\x73\164\x20\x2d\40" . $xv), true);
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\x54\x68\141\x6e\153\x73\40\146\x6f\x72\40\147\145\164\x74\x69\x6e\x67\x20\x69\156\x20\164\157\x75\x63\150\41\x20\127\x65\x20\x73\150\x61\x6c\x6c\x20\x67\x65\164\40\142\141\x63\153\x20\164\157\40\171\157\165\x20\163\150\x6f\x72\x74\154\171\56");
        $xW->mo_oauth_show_success_message();
        goto TD;
        yb:
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\x50\154\x65\x61\x73\x65\40\x66\x69\154\x6c\x20\165\160\x20\x45\155\141\151\x6c\40\146\x69\x65\154\x64\x20\164\157\x20\163\165\x62\x6d\x69\164\40\171\157\165\162\x20\x71\165\x65\x72\171\56");
        $xW->mo_oauth_show_success_message();
        TD:
        q0:
    }
}
