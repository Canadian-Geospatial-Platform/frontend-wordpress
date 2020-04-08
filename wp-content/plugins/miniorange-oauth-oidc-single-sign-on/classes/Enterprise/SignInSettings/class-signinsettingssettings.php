<?php


namespace MoOauthClient\Enterprise;

use MoOauthClient\Config;
use MoOauthClient\Premium\SignInSettingsSettings as PremiumSignInSettingsSettings;
class SignInSettingsSettings extends PremiumSignInSettingsSettings
{
    public function change_current_config($post, $BX)
    {
        $BX = parent::change_current_config($post, $BX);
        $BX->add_config("\x64\171\156\x61\x6d\151\143\137\143\141\x6c\x6c\142\141\143\x6b\x5f\165\x72\x6c", isset($post["\144\171\x6e\x61\155\x69\x63\x5f\143\x61\154\154\142\141\143\x6b\x5f\165\162\x6c"]) ? stripslashes(wp_unslash($post["\x64\171\x6e\141\x6d\151\x63\137\x63\141\154\154\142\x61\x63\x6b\137\165\x72\x6c"])) : '');
        $BX->add_config("\x61\143\164\x69\x76\141\164\x65\x5f\x75\163\x65\162\x5f\x61\x6e\141\x6c\171\x74\151\x63\x73", isset($post["\x6d\157\137\x61\x63\x74\x69\166\141\x74\145\x5f\x75\x73\x65\162\137\x61\x6e\x61\x6c\171\x74\151\143\x73"]) ? stripslashes(wp_unslash($post["\x6d\x6f\x5f\141\x63\164\x69\x76\141\164\145\137\165\x73\145\x72\137\x61\x6e\141\x6c\171\x74\151\x63\163"])) : '');
        $BX->add_config("\x61\x63\164\x69\x76\141\x74\x65\x5f\x73\x69\x6e\x67\154\145\x5f\x6c\x6f\x67\x69\156\x5f\146\x6c\157\167", isset($post["\155\157\x5f\x61\x63\x74\151\166\141\164\145\x5f\x73\151\156\147\x6c\145\137\x6c\157\147\151\156\x5f\146\154\157\167"]) ? stripslashes(wp_unslash($post["\x6d\x6f\x5f\141\x63\164\x69\166\x61\164\145\x5f\x73\x69\x6e\147\x6c\x65\x5f\154\157\147\151\156\x5f\x66\154\157\x77"])) : '');
        $BX->add_config("\x63\x6f\155\x6d\x6f\x6e\137\154\x6f\x67\151\x6e\137\x62\165\164\164\157\x6e\x5f\144\151\x73\x70\154\141\x79\137\156\x61\x6d\145", isset($post["\143\x6f\x6d\x6d\x6f\x6e\x5f\x6c\157\x67\151\x6e\x5f\142\x75\x74\x74\157\x6e\137\144\151\163\x70\154\141\171\137\x6e\141\x6d\x65"]) ? stripslashes(wp_unslash($post["\x63\x6f\x6d\x6d\157\156\137\x6c\x6f\147\151\x6e\x5f\x62\x75\164\164\157\x6e\137\144\151\x73\160\x6c\141\171\x5f\x6e\x61\155\x65"])) : '');
        global $xW;
        $xW->mo_oauth_client_update_option("\x6d\157\137\157\x61\165\x74\x68\137\x63\154\x69\x65\156\x74\137\x6c\157\x61\x64\137\141\x6e\x61\154\171\164\151\x63\163", isset($post["\x6d\157\x5f\x61\143\164\151\x76\x61\x74\x65\x5f\x75\163\x65\x72\x5f\x61\x6e\x61\154\171\164\x69\x63\x73"]));
        $xW->mo_oauth_client_update_option("\155\157\x5f\x6f\x61\165\164\150\x5f\x65\156\x61\142\x6c\145\137\x65\x78\151\x73\x74\x69\156\x67\137\x75\x73\x65\x72\x5f\x6c\x6f\147\151\x6e", isset($post["\x65\156\x61\x62\x6c\x65\137\x65\170\x69\x73\x74\x69\x6e\147\137\165\x73\x65\162\137\x6c\157\x67\x69\x6e"]));
        $xW->mo_oauth_client_update_option("\155\x6f\137\x6f\x61\x75\164\x68\x5f\141\143\164\x69\x76\x61\164\145\137\x73\x69\x6e\147\154\145\137\x6c\x6f\147\x69\156\x5f\146\x6c\x6f\x77", isset($post["\x6d\157\137\141\x63\164\151\x76\x61\x74\145\x5f\163\x69\x6e\x67\154\145\x5f\154\157\147\x69\x6e\x5f\x66\x6c\x6f\x77"]));
        $xW->mo_oauth_client_update_option("\155\x6f\137\157\x61\165\x74\150\137\143\x6f\x6d\x6d\x6f\x6e\137\154\157\x67\151\156\x5f\142\165\164\x74\157\156\x5f\x64\151\163\x70\154\141\x79\137\156\141\155\145", isset($post["\143\x6f\155\x6d\157\x6e\137\154\x6f\x67\x69\156\x5f\x62\165\164\164\x6f\x6e\x5f\144\x69\x73\x70\154\141\x79\137\156\x61\155\145"]) ? stripslashes(wp_unslash($post["\x63\x6f\155\155\x6f\x6e\137\x6c\x6f\x67\x69\156\x5f\x62\x75\x74\164\x6f\156\137\x64\x69\x73\160\154\141\x79\x5f\x6e\x61\x6d\x65"])) : '');
        return $BX;
    }
}
