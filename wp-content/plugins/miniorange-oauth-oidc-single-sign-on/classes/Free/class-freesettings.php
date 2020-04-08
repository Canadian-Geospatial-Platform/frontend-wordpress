<?php


namespace MoOauthClient\Free;

use MoOauthClient\Settings;
use MoOauthClient\Free\CustomizationSettings;
use MoOauthClient\Free\RequestfordemoSettings;
use MoOauthClient\Free\AppSettings;
use MoOauthClient\Customer;
class FreeSettings
{
    private $common_settings;
    public function __construct()
    {
        $this->common_settings = new Settings();
        add_action("\x61\144\155\151\x6e\137\151\x6e\x69\x74", array($this, "\x6d\x6f\x5f\x6f\x61\x75\x74\x68\x5f\143\154\151\x65\x6e\164\137\x66\x72\x65\145\137\163\145\164\164\151\156\147\x73"));
        add_action("\x61\144\155\151\156\137\x66\157\157\164\x65\162", array($this, "\x6d\x6f\137\157\x61\x75\164\150\137\143\154\x69\145\x6e\164\137\146\x65\145\x64\x62\141\x63\x6b\x5f\x72\145\x71\165\145\x73\164"));
    }
    public function mo_oauth_client_free_settings()
    {
        global $xW;
        $gd = new CustomizationSettings();
        $Q6 = new RequestfordemoSettings();
        $gd->save_customization_settings();
        $Q6->save_requestdemo_settings();
        $n9 = new AppSettings();
        $n9->save_app_settings();
        if (!(isset($_POST["\x6d\x6f\x5f\157\x61\165\x74\150\137\x63\154\151\145\x6e\164\x5f\146\145\145\x64\142\141\x63\x6b\x5f\156\x6f\156\143\x65"]) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST["\155\157\137\x6f\x61\x75\x74\x68\x5f\143\x6c\151\145\156\x74\x5f\146\145\145\144\142\141\x63\x6b\x5f\156\157\156\x63\145"])), "\155\x6f\137\x6f\x61\x75\164\150\x5f\143\154\x69\x65\156\x74\x5f\146\x65\x65\x64\142\x61\x63\x6b") && isset($_POST[\MoOAuthConstants::OPTION]) && "\x6d\x6f\137\x6f\141\x75\164\150\x5f\143\x6c\x69\x65\156\164\x5f\x66\x65\x65\144\x62\x61\143\x6b" === $_POST[\MoOAuthConstants::OPTION])) {
            goto fO;
        }
        $user = wp_get_current_user();
        $wP = "\120\154\x75\x67\x69\156\x20\104\x65\x61\143\164\x69\166\x61\164\x65\144\72";
        $hh = isset($_POST["\144\145\141\x63\x74\x69\x76\141\x74\x65\137\162\x65\141\163\157\156\x5f\162\x61\144\x69\157"]) ? sanitize_text_field(wp_unslash($_POST["\144\145\x61\143\164\x69\x76\x61\164\x65\x5f\162\x65\x61\163\157\156\137\x72\141\x64\x69\157"])) : false;
        $wh = isset($_POST["\x71\165\145\x72\171\x5f\x66\145\x65\144\142\141\143\153"]) ? sanitize_text_field(wp_unslash($_POST["\161\x75\145\162\171\x5f\146\x65\145\x64\x62\x61\143\x6b"])) : false;
        if ($hh) {
            goto ye;
        }
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\120\154\x65\141\163\x65\40\x53\x65\154\x65\143\x74\x20\x6f\x6e\145\40\157\x66\x20\164\150\145\40\162\x65\x61\x73\157\156\163\40\x2c\x69\x66\40\x79\157\165\162\x20\162\145\x61\x73\x6f\x6e\40\151\x73\40\156\157\x74\x20\x6d\145\x6e\x74\x69\157\x6e\145\144\40\x70\x6c\145\x61\x73\145\40\x73\x65\154\145\x63\164\40\117\x74\150\145\x72\x20\122\145\141\x73\157\x6e\x73");
        $xW->mo_oauth_show_error_message();
        ye:
        $wP .= $hh;
        if (!isset($wh)) {
            goto vo;
        }
        $wP .= "\72" . $wh;
        vo:
        $xv = $xW->mo_oauth_client_get_option("\x6d\x6f\137\157\141\165\x74\x68\137\141\144\155\151\156\137\x65\155\x61\x69\154");
        if (!($xv == '')) {
            goto TN;
        }
        $xv = $user->user_email;
        TN:
        $Fs = $xW->mo_oauth_client_get_option("\x6d\157\137\157\x61\x75\x74\x68\137\141\144\x6d\151\156\137\160\x68\x6f\156\145");
        $zu = new Customer();
        $To = json_decode($zu->mo_oauth_send_email_alert($xv, $Fs, $wP), true);
        deactivate_plugins(MOC_DIR . "\155\157\137\x6f\x61\165\164\x68\x5f\x73\145\x74\x74\151\x6e\x67\163\56\x70\150\x70");
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\x54\150\141\x6e\153\40\171\x6f\x75\x20\146\x6f\162\40\164\150\145\x20\146\145\145\x64\142\x61\143\x6b\56");
        $xW->mo_oauth_show_success_message();
        fO:
        if (!(isset($_POST["\155\157\x5f\x6f\141\x75\x74\150\137\x63\x6c\151\x65\156\164\137\x73\x6b\x69\x70\137\x66\145\145\x64\x62\141\143\153\x5f\156\x6f\156\143\145"]) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST["\155\157\x5f\x6f\x61\165\x74\150\x5f\x63\x6c\151\x65\156\164\x5f\x73\153\151\160\x5f\146\145\145\144\x62\x61\143\x6b\137\156\157\x6e\143\145"])), "\155\x6f\137\x6f\141\165\164\x68\x5f\x63\x6c\151\145\156\x74\137\x73\x6b\151\x70\x5f\x66\x65\x65\x64\142\141\143\x6b") && isset($_POST["\x6f\160\x74\x69\157\156"]) && "\155\x6f\x5f\x6f\x61\x75\164\150\137\143\154\151\x65\x6e\x74\x5f\163\x6b\151\x70\137\146\x65\145\144\142\x61\143\x6b" === $_POST["\x6f\x70\x74\151\x6f\x6e"])) {
            goto O6;
        }
        deactivate_plugins(MOC_DIR . "\x6d\x6f\x5f\157\141\165\164\x68\x5f\163\145\x74\x74\x69\x6e\147\x73\56\160\150\160");
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\120\x6c\165\x67\x69\x6e\x20\104\x65\141\x63\164\151\x76\x61\164\x65\x64\x2e");
        $xW->mo_oauth_show_success_message();
        O6:
    }
    public function mo_oauth_client_feedback_request()
    {
        $Bp = new \MoOauthClient\Free\Feedback();
        $Bp->show_form();
    }
}
