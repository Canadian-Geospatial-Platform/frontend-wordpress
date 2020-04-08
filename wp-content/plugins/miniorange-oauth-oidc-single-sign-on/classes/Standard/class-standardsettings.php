<?php


namespace MoOauthClient\Standard;

use MoOauthClient\Free\FreeSettings;
use MoOauthClient\Free\CustomizationSettings;
use MoOauthClient\Standard\AppSettings;
use MoOauthClient\Standard\SignInSettingsSettings;
use MoOauthClient\Standard\Customer;
class StandardSettings
{
    private $free_settings;
    public function __construct()
    {
        $this->free_settings = new FreeSettings();
        add_action("\141\x64\x6d\x69\156\x5f\151\156\151\x74", array($this, "\155\157\x5f\x6f\x61\x75\x74\x68\x5f\x63\154\151\145\156\164\137\163\164\x61\x6e\x64\x61\x72\144\137\163\145\x74\x74\151\156\x67\163"));
        add_action("\144\157\137\x6d\141\x69\x6e\x5f\x73\x65\164\x74\x69\x6e\147\x73\137\x69\x6e\x74\x65\x72\156\141\154", array($this, "\x64\x6f\x5f\151\156\164\145\162\156\x61\x6c\x5f\163\145\164\164\x69\156\x67\163"), 1, 10);
    }
    public function mo_oauth_client_standard_settings()
    {
        $gd = new CustomizationSettings();
        $Tz = new SignInSettingsSettings();
        $n9 = new AppSettings();
        $gd->save_customization_settings();
        $n9->save_app_settings();
        $Tz->mo_oauth_save_settings();
    }
    public function do_internal_settings($post)
    {
        global $xW;
        if (!(isset($_POST["\155\157\x5f\x6f\x61\165\164\x68\x5f\x63\x6c\151\x65\156\164\x5f\166\x65\162\151\146\x79\137\154\151\x63\145\x6e\x73\x65\137\x6e\x6f\x6e\143\x65"]) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST["\155\157\x5f\x6f\141\x75\164\x68\x5f\143\154\151\x65\x6e\x74\137\166\145\162\151\x66\x79\137\154\x69\143\x65\x6e\163\x65\x5f\x6e\157\x6e\143\145"])), "\155\x6f\x5f\157\141\165\x74\150\137\143\154\x69\145\156\x74\137\x76\x65\x72\x69\146\x79\x5f\x6c\151\143\x65\x6e\x73\x65") && isset($post[\MoOAuthConstants::OPTION]) && "\x6d\x6f\137\x6f\x61\165\x74\x68\137\143\x6c\x69\x65\156\164\x5f\166\x65\x72\x69\146\x79\x5f\x6c\x69\x63\x65\156\x73\x65" === $post[\MoOAuthConstants::OPTION])) {
            goto F7C;
        }
        if (!(!isset($post["\x6d\157\x5f\157\141\165\164\150\137\x63\x6c\151\x65\156\x74\137\x6c\151\143\145\x6e\163\145\x5f\x6b\145\171"]) || empty($post["\x6d\x6f\x5f\x6f\x61\165\x74\150\137\143\154\151\145\x6e\x74\x5f\x6c\x69\x63\x65\156\x73\x65\x5f\x6b\x65\171"]))) {
            goto SV7;
        }
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\120\x6c\145\141\163\x65\40\x65\x6e\164\x65\162\x20\x76\141\x6c\151\144\40\x6c\x69\x63\145\x6e\x73\145\x20\x6b\145\x79\56");
        $this->mo_oauth_show_error_message();
        return;
        SV7:
        $tY = trim($post["\155\157\x5f\x6f\x61\x75\x74\150\137\x63\x6c\x69\x65\156\164\137\x6c\151\143\x65\156\163\145\137\153\x65\x79"]);
        $RA = new Customer();
        $PI = json_decode($RA->check_customer_ln(), true);
        if (strcasecmp($PI["\163\164\141\x74\x75\163"], "\123\125\x43\x43\x45\x53\x53") === 0) {
            goto nDt;
        }
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\111\x6e\166\x61\x6c\151\x64\x20\154\x69\143\x65\x6e\x73\145\56\x20\120\x6c\x65\141\x73\145\x20\164\x72\171\40\141\x67\141\x69\x6e\56");
        $xW->mo_oauth_show_error_message();
        goto BSl;
        nDt:
        $PI = json_decode($RA->XfskodsfhHJ($tY), true);
        if (strcasecmp($PI["\163\164\141\164\x75\x73"], "\123\x55\x43\x43\x45\x53\x53") === 0) {
            goto PGt;
        }
        if (strcasecmp($PI["\x73\x74\141\164\165\x73"], "\x46\x41\111\114\x45\104") === 0) {
            goto kE2;
        }
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\101\156\x20\x65\162\162\x6f\x72\40\157\143\143\x75\162\145\x64\x20\x77\x68\x69\x6c\x65\40\160\x72\x6f\143\x65\x73\163\151\x6e\x67\x20\x79\x6f\x75\x72\40\x72\145\161\x75\x65\163\164\56\x20\x50\154\145\141\x73\x65\x20\x54\162\x79\40\x61\147\x61\151\156\x2e");
        $xW->mo_oauth_show_error_message();
        goto HMX;
        PGt:
        $xW->mo_oauth_client_update_option("\x6d\157\x5f\157\141\165\x74\x68\x5f\x6c\153", $xW->mooauthencrypt($tY));
        $xW->mo_oauth_client_update_option("\155\x6f\x5f\x6f\x61\165\x74\150\x5f\154\166", $xW->mooauthencrypt("\164\x72\x75\x65"));
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\131\x6f\x75\x72\x20\154\x69\143\145\156\x73\x65\x20\151\163\x20\x76\x65\x72\x69\x66\x69\145\x64\x2e\40\x59\157\165\40\x63\141\156\x20\x6e\x6f\167\40\x73\145\164\165\x70\x20\x74\x68\x65\40\x70\x6c\165\x67\x69\x6e\56");
        $xW->mo_oauth_show_success_message();
        goto HMX;
        kE2:
        $xW->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\131\x6f\165\x20\x68\141\x76\x65\x20\145\156\164\145\162\145\144\x20\141\156\40\x69\x6e\x76\x61\154\151\x64\x20\154\151\143\x65\x6e\x73\145\x20\153\x65\171\56\x20\x50\154\145\x61\163\x65\x20\x65\x6e\164\145\162\x20\141\x20\x76\x61\154\x69\144\x20\x6c\x69\143\145\x6e\163\145\40\x6b\x65\x79\56");
        $xW->mo_oauth_show_error_message();
        HMX:
        BSl:
        F7C:
    }
}
