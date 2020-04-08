<?php


namespace MoOauthClient\Free;

class CustomizationSettings
{
    public function save_customization_settings()
    {
        global $xW;
        if (!(isset($_POST["\155\157\137\x6f\x61\165\164\x68\137\141\160\160\137\143\x75\163\x74\157\155\x69\x7a\141\164\x69\157\x6e\x5f\x6e\x6f\156\143\145"]) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST["\155\157\137\x6f\x61\165\x74\x68\137\x61\x70\160\137\143\x75\x73\164\x6f\155\151\x7a\x61\164\151\x6f\156\137\x6e\x6f\x6e\x63\x65"])), "\x6d\157\x5f\x6f\x61\165\164\x68\137\x61\x70\x70\x5f\x63\x75\x73\164\x6f\x6d\x69\x7a\x61\x74\x69\x6f\156") && isset($_POST[\MoOAuthConstants::OPTION]) && "\155\157\x5f\157\141\x75\164\150\137\141\x70\x70\137\143\165\163\x74\x6f\155\151\x7a\141\164\x69\157\x6e" === $_POST[\MoOAuthConstants::OPTION])) {
            goto pU;
        }
        $xW->mo_oauth_client_update_option("\155\x6f\x5f\x6f\x61\x75\164\x68\137\151\x63\157\156\x5f\x77\x69\x64\x74\150", stripslashes($_POST["\155\157\137\157\141\x75\x74\x68\137\151\143\157\x6e\137\x77\x69\x64\x74\x68"]));
        $xW->mo_oauth_client_update_option("\155\x6f\137\157\x61\x75\164\150\137\x69\143\x6f\156\x5f\150\145\151\x67\150\x74", stripslashes($_POST["\155\157\x5f\157\x61\165\x74\x68\x5f\x69\x63\157\x6e\x5f\x68\145\x69\147\x68\x74"]));
        $xW->mo_oauth_client_update_option("\155\x6f\x5f\157\141\165\x74\x68\137\151\143\157\x6e\x5f\155\141\162\x67\151\156", stripslashes($_POST["\155\157\x5f\157\x61\x75\x74\x68\x5f\151\143\x6f\156\x5f\155\x61\162\x67\151\156"]));
        $xW->mo_oauth_client_update_option("\155\157\x5f\157\x61\165\164\x68\137\x69\143\157\156\x5f\x63\157\x6e\x66\151\147\165\x72\145\137\143\x73\163", stripcslashes(stripslashes($_POST["\x6d\157\137\x6f\141\165\x74\150\137\151\143\x6f\x6e\137\x63\157\156\x66\151\x67\x75\x72\145\137\x63\x73\163"])));
        $xW->mo_oauth_client_update_option("\x6d\x6f\x5f\x6f\x61\x75\x74\x68\x5f\x63\x75\x73\x74\x6f\x6d\137\154\157\x67\157\x75\x74\x5f\x74\x65\170\x74", stripslashes($_POST["\x6d\x6f\x5f\157\x61\x75\x74\x68\x5f\143\165\x73\x74\157\155\x5f\x6c\x6f\x67\x6f\x75\164\x5f\x74\145\x78\x74"]));
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\131\157\x75\162\40\x73\x65\x74\x74\151\x6e\x67\163\x20\x77\145\x72\x65\x20\x73\x61\166\145\144");
        $xW->mo_oauth_show_success_message();
        pU:
    }
}
?>
