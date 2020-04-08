<?php


namespace MoOauthClient\Premium;

use MoOauthClient\Config;
use MoOauthClient\Standard\SignInSettingsSettings as StandardSignInSettingsSettings;
class SignInSettingsSettings extends StandardSignInSettingsSettings
{
    public function change_current_config($post, $BX)
    {
        global $xW;
        $BX = parent::change_current_config($post, $BX);
        $BX->add_config("\x72\x65\163\x74\x72\151\x63\x74\145\144\x5f\144\157\155\x61\151\156\163", isset($post["\x72\x65\163\164\x72\x69\143\x74\x65\x64\137\144\x6f\155\141\151\x6e\163"]) ? stripslashes(wp_unslash($post["\162\145\163\164\x72\x69\x63\x74\145\144\137\x64\x6f\x6d\141\x69\156\x73"])) : '');
        $BX->add_config("\x72\x65\163\164\x72\151\x63\164\x5f\164\x6f\x5f\x6c\x6f\x67\x67\145\144\x5f\151\x6e\137\165\163\x65\x72\163", isset($post["\x72\x65\163\x74\162\x69\143\x74\x5f\x74\x6f\137\154\x6f\x67\147\145\x64\137\151\156\x5f\165\x73\145\162\x73"]) ? stripslashes(wp_unslash($post["\x72\x65\x73\x74\x72\151\143\164\137\164\157\x5f\x6c\157\x67\x67\145\x64\x5f\151\156\x5f\165\163\x65\x72\163"])) : '');
        $BX->add_config("\x6b\145\145\160\137\x65\170\x69\163\x74\x69\156\x67\137\x75\163\145\x72\163", isset($post["\x6b\x65\x65\160\137\145\170\x69\x73\x74\x69\x6e\147\137\x75\x73\145\x72\163"]) ? stripslashes(wp_unslash($post["\153\x65\x65\x70\x5f\x65\x78\151\163\164\x69\x6e\x67\137\x75\163\145\162\x73"])) : '');
        $BX->add_config("\141\154\x6c\157\167\x5f\162\x65\x73\x74\x72\x69\143\164\x65\x64\137\x64\157\x6d\141\x69\156\163", isset($post["\x61\154\154\157\167\x5f\162\145\163\x74\162\x69\143\x74\x65\144\x5f\x64\x6f\x6d\x61\x69\x6e\x73"]) ? stripslashes(wp_unslash($post["\141\x6c\154\157\x77\x5f\x72\x65\x73\x74\162\x69\x63\x74\x65\x64\137\144\x6f\155\141\x69\x6e\x73"])) : '');
        $BX->add_config("\141\165\x74\x6f\137\162\145\x64\151\x72\x65\143\164\x5f\x65\x78\x63\154\x75\144\145\x5f\165\x72\x6c\163", isset($post["\141\165\x74\x6f\x5f\x72\145\x64\x69\x72\145\x63\x74\137\x65\170\143\154\165\144\x65\x5f\x75\x72\x6c\163"]) ? stripslashes(wp_unslash($post["\x61\x75\164\x6f\137\x72\145\x64\151\x72\145\x63\164\x5f\145\x78\143\x6c\165\144\145\x5f\x75\162\x6c\x73"])) : '');
        $xW->mo_oauth_client_update_option("\155\x6f\137\x6f\x61\165\x74\x68\x5f\145\156\x61\142\x6c\145\137\145\170\x69\x73\x74\151\x6e\x67\x5f\165\163\x65\x72\137\154\157\147\x69\x6e", isset($post["\145\x6e\x61\142\154\x65\137\145\x78\151\x73\x74\151\156\147\137\x75\x73\x65\x72\137\x6c\x6f\147\151\156"]));
        return $BX;
    }
}
