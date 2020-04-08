<?php


namespace MoOauthClient\Standard;

use MoOauthClient\Config;
class SignInSettingsSettings
{
    private $plugin_config;
    public function __construct()
    {
        $rd = $this->get_config_option();
        if ($rd && isset($rd)) {
            goto LOg;
        }
        $this->plugin_config = new Config();
        $this->save_config_option($this->plugin_config);
        goto y6f;
        LOg:
        $this->save_config_option($rd);
        $this->plugin_config = $rd;
        y6f:
    }
    public function save_config_option($BX = array())
    {
        global $xW;
        if (!(isset($BX) && !empty($BX))) {
            goto mwD;
        }
        return $xW->mo_oauth_client_update_option("\x6d\x6f\x5f\x6f\x61\165\x74\x68\x5f\143\154\151\x65\x6e\x74\137\x63\157\x6e\x66\151\x67", $BX);
        mwD:
        return false;
    }
    public function get_config_option()
    {
        global $xW;
        return $xW->mo_oauth_client_get_option("\x6d\x6f\137\x6f\141\165\164\x68\x5f\143\154\151\145\156\x74\137\143\157\x6e\146\x69\x67");
    }
    public function get_sane_config()
    {
        $BX = $this->plugin_config;
        if ($BX && isset($BX)) {
            goto Xhw;
        }
        $BX = $this->get_config_option();
        Xhw:
        if (!(!$BX || !isset($BX))) {
            goto MbX;
        }
        $BX = new Config();
        MbX:
        return $BX;
    }
    public function mo_oauth_save_settings()
    {
        global $xW;
        $BX = $this->get_sane_config();
        if (!(isset($_POST["\x6d\x6f\137\x73\x69\x67\x6e\x69\156\163\145\164\x74\151\156\x67\x73\x5f\156\x6f\156\143\x65"]) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST["\155\x6f\x5f\163\x69\x67\156\151\x6e\x73\x65\x74\164\151\156\147\163\x5f\x6e\157\156\x63\x65"])), "\155\x6f\137\x6f\141\x75\164\150\x5f\143\154\x69\145\156\x74\137\163\151\147\156\137\x69\156\x5f\163\x65\x74\x74\151\156\147\163") && (isset($_POST[\MoOAuthConstants::OPTION]) && "\155\157\137\157\x61\x75\x74\150\137\143\154\151\145\156\164\x5f\141\x64\x76\x61\x6e\143\145\144\x5f\163\145\164\164\x69\x6e\147\x73" === $_POST[\MoOAuthConstants::OPTION]))) {
            goto hQn;
        }
        $BX = $this->change_current_config($_POST, $BX);
        $BX->save_settings($BX->get_current_config());
        $this->save_config_option($BX);
        hQn:
    }
    public function change_current_config($post, $BX)
    {
        $BX->add_config("\x61\146\x74\x65\x72\137\154\157\147\151\156\x5f\165\x72\154", isset($post["\143\x75\x73\164\x6f\155\137\x61\146\164\x65\x72\x5f\154\x6f\147\x69\x6e\x5f\x75\162\x6c"]) ? stripslashes(wp_unslash($post["\x63\x75\x73\164\157\155\137\x61\x66\x74\145\x72\x5f\x6c\157\x67\x69\x6e\x5f\x75\162\x6c"])) : '');
        $BX->add_config("\x61\146\164\x65\x72\x5f\x6c\157\x67\157\165\x74\137\x75\162\x6c", isset($post["\x63\x75\163\164\x6f\155\137\x61\146\164\x65\x72\x5f\154\157\x67\157\x75\x74\137\x75\162\x6c"]) ? stripslashes(wp_unslash($post["\143\165\x73\164\157\155\x5f\x61\x66\164\x65\162\137\154\x6f\x67\x6f\165\x74\x5f\165\x72\154"])) : '');
        $BX->add_config("\x70\x6f\160\165\160\x5f\x6c\157\147\151\x6e", isset($post["\x70\x6f\160\x75\x70\x5f\x6c\157\x67\151\156"]) ? stripslashes(wp_unslash($post["\160\157\160\165\x70\x5f\154\157\147\x69\x6e"])) : 0);
        $BX->add_config("\141\x75\x74\157\x5f\162\145\x67\x69\163\164\x65\162", isset($post["\141\165\x74\x6f\x5f\162\x65\x67\151\163\164\145\x72"]) ? stripslashes(wp_unslash($post["\x61\165\164\157\137\x72\x65\147\x69\163\164\145\x72"])) : 0);
        $BX->add_config("\143\157\x6e\x66\151\x72\x6d\137\x6c\157\147\x6f\x75\164", isset($post["\143\157\x6e\x66\x69\162\155\137\154\x6f\147\157\x75\x74"]) ? stripslashes(wp_unslash($post["\x63\x6f\156\146\151\x72\x6d\137\154\x6f\x67\x6f\165\164"])) : 0);
        return $BX;
    }
}
