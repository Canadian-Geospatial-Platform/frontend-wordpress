<?php


namespace MoOauthClient\Premium;

use MoOauthClient\Standard\StandardSettings;
use MoOauthClient\Premium\AppSettings;
use MoOauthClient\Premium\SignInSettingsSettings;
class PremiumSettings
{
    private $standard_settings;
    public function __construct()
    {
        $this->standard_settings = new StandardSettings();
        add_action("\141\144\155\x69\156\x5f\151\156\151\x74", array($this, "\x6d\x6f\137\157\x61\x75\x74\x68\x5f\143\x6c\151\145\x6e\164\x5f\160\162\x65\x6d\151\165\x6d\x5f\x73\145\164\x74\151\156\147\163"));
    }
    public function mo_oauth_client_premium_settings()
    {
        $Tz = new SignInSettingsSettings();
        $n9 = new AppSettings();
        $n9->save_app_settings();
        $n9->save_grant_settings();
        $Tz->mo_oauth_save_settings();
    }
}
