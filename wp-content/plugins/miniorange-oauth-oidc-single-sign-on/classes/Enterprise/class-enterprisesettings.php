<?php


namespace MoOauthClient\Enterprise;

use MoOauthClient\Premium\PremiumSettings;
use MoOauthClient\Enterprise\SignInSettingsSettings;
use MoOauthClient\Enterprise\UserAnalyticsDBOps as DBOps;
class EnterpriseSettings
{
    private $premium_settings;
    public function __construct()
    {
        $this->premium_settings = new PremiumSettings();
        add_action("\141\144\155\x69\156\x5f\x69\156\151\164", array($this, "\x6d\x6f\x5f\157\141\x75\x74\x68\x5f\x63\x6c\x69\145\x6e\x74\137\145\x6e\164\145\x72\160\162\x69\163\x65\137\x73\x65\x74\x74\151\x6e\147\x73"));
    }
    public function mo_oauth_client_enterprise_settings()
    {
        $Tz = new SignInSettingsSettings();
        $Tz->mo_oauth_save_settings();
        if (!(isset($_POST["\x6d\157\x5f\167\x70\156\x73\x5f\x6d\141\156\x75\x61\154\x5f\143\154\145\141\x72\137\x6e\x6f\156\x63\145"]) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST["\x6d\x6f\137\x77\x70\156\x73\137\x6d\141\156\165\x61\154\137\143\x6c\145\x61\x72\137\x6e\157\x6e\x63\145"])), "\155\157\137\167\x70\x6e\x73\137\155\141\156\x75\141\x6c\137\143\x6c\x65\141\x72") && isset($_POST[\MoOAuthConstants::OPTION]) && "\155\x6f\137\x77\160\156\x73\137\x6d\141\156\x75\141\x6c\137\x63\x6c\x65\141\x72" === $_POST[\MoOAuthConstants::OPTION])) {
            goto I5;
        }
        $r3 = new DBOps();
        $r3->drop_table();
        I5:
    }
}
