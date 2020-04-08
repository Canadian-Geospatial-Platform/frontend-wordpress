<?php


namespace MoOauthClient\Standard;

use MoOauthClient\App;
use MoOauthClient\Free\AppSettings as FreeAppSettings;
class AppSettings extends FreeAppSettings
{
    public function change_app_settings($post, $k0)
    {
        $k0 = parent::change_app_settings($post, $k0);
        $k0["\x64\151\x73\x70\x6c\x61\171\141\x70\x70\156\141\155\x65"] = isset($post["\x6d\157\137\x6f\141\165\164\x68\137\144\x69\163\x70\x6c\141\171\x5f\x61\160\160\x5f\156\x61\x6d\145"]) ? trim(stripslashes($post["\x6d\157\137\157\141\165\x74\x68\137\144\x69\x73\x70\x6c\x61\x79\137\141\x70\x70\x5f\156\141\155\145"])) : '';
        return $k0;
    }
    public function change_attribute_mapping($post, $k0)
    {
        $k0 = parent::change_attribute_mapping($post, $k0);
        $k0["\x65\155\x61\x69\154\137\141\164\x74\162"] = isset($post["\155\x6f\137\157\141\x75\x74\150\137\x65\x6d\x61\x69\x6c\x5f\141\x74\164\162"]) ? stripslashes($post["\155\157\x5f\157\x61\165\164\x68\x5f\145\x6d\x61\x69\154\x5f\141\x74\164\162"]) : '';
        $k0["\146\x69\162\163\x74\156\x61\x6d\145\137\141\x74\164\162"] = isset($post["\x6d\157\137\157\141\165\164\150\x5f\x66\x69\x72\163\164\156\x61\x6d\x65\137\141\164\164\162"]) ? trim(stripslashes($post["\x6d\157\x5f\157\x61\x75\x74\150\137\146\x69\x72\x73\164\156\141\x6d\x65\x5f\x61\164\x74\x72"])) : '';
        $k0["\154\x61\x73\x74\x6e\141\x6d\x65\137\141\x74\x74\x72"] = isset($post["\x6d\157\137\157\x61\x75\x74\x68\137\x6c\141\x73\x74\x6e\141\x6d\145\137\x61\x74\x74\x72"]) ? trim(stripslashes($post["\155\157\x5f\x6f\141\x75\x74\x68\137\x6c\x61\163\164\x6e\141\x6d\145\x5f\x61\x74\x74\162"])) : '';
        $k0["\x64\151\x73\x70\154\141\x79\x5f\x61\x74\164\162"] = isset($post["\157\x61\165\164\150\x5f\x63\154\x69\145\x6e\164\137\x61\155\x5f\x64\x69\x73\160\x6c\x61\x79\137\x6e\x61\x6d\145"]) ? trim(stripslashes($post["\x6f\x61\165\164\150\x5f\x63\x6c\151\145\x6e\x74\137\x61\x6d\137\x64\151\x73\160\x6c\141\171\137\x6e\141\155\145"])) : '';
        return $k0;
    }
}
