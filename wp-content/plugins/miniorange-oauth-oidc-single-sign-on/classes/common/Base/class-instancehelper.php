<?php


namespace MoOauthClient\Base;

class InstanceHelper
{
    private $current_version = "\x46\122\x45\105";
    private $utils;
    public function __construct()
    {
        $this->utils = new \MoOauthClient\MOUtils();
        $this->current_version = $this->utils->get_versi_str();
    }
    public function get_sign_in_settings_instance()
    {
        if (class_exists("\x4d\x6f\117\x61\165\x74\x68\x43\x6c\x69\x65\x6e\x74\x5c\x45\156\164\145\162\x70\162\151\163\x65\x5c\x53\x69\x67\x6e\111\156\123\145\164\x74\x69\x6e\x67\x73") && $this->utils->check_versi(3)) {
            goto Pt;
        }
        if (class_exists("\x4d\x6f\x4f\x61\x75\164\150\x43\154\151\145\156\x74\134\x50\x72\x65\155\x69\x75\x6d\134\x53\151\147\156\111\156\123\145\x74\x74\x69\156\x67\x73") && $this->utils->check_versi(2)) {
            goto Gz;
        }
        if (class_exists("\x4d\157\117\141\165\164\x68\x43\154\x69\145\156\164\x5c\x53\x74\x61\156\144\x61\x72\144\x5c\123\151\147\x6e\x49\156\x53\145\x74\x74\151\156\x67\163") && $this->utils->check_versi(1)) {
            goto NU;
        }
        if (class_exists("\134\115\157\117\x61\x75\x74\x68\103\x6c\x69\145\x6e\x74\x5c\x46\162\145\145\134\123\x69\147\156\x49\x6e\123\x65\164\x74\151\x6e\x67\163") && $this->utils->check_versi(0)) {
            goto d_;
        }
        wp_die("\120\154\x65\141\x73\x65\40\x43\150\x61\x6e\x67\145\40\x54\150\x65\x20\166\x65\162\163\151\157\156\x20\x62\x61\143\153\x20\x74\157\x20\x77\150\x61\x74\x20\151\x74\x20\162\x65\x61\154\x6c\171\x20\x77\141\163");
        die;
        goto JV;
        Pt:
        return new \MoOauthClient\Enterprise\SignInSettings();
        goto JV;
        Gz:
        return new \MoOauthClient\Premium\SignInSettings();
        goto JV;
        NU:
        return new \MoOauthClient\Standard\SignInSettings();
        goto JV;
        d_:
        return new \MoOauthClient\Free\SignInSettings();
        JV:
    }
    public function get_requestdemo_instance()
    {
        if (!class_exists("\x5c\x4d\157\117\141\x75\164\x68\103\x6c\x69\x65\156\164\x5c\106\x72\x65\x65\134\122\x65\161\165\x65\x73\x74\x66\157\162\x64\145\x6d\157")) {
            goto py;
        }
        return new \MoOauthClient\Free\Requestfordemo();
        py:
    }
    public function get_customization_instance()
    {
        if (class_exists("\115\x6f\x4f\x61\x75\x74\x68\x43\154\151\x65\x6e\164\134\x45\156\x74\x65\x72\x70\x72\x69\x73\x65\x5c\103\165\x73\164\x6f\155\151\x7a\x61\x74\151\157\156") && $this->utils->check_versi(3)) {
            goto wx;
        }
        if (class_exists("\115\157\x4f\141\165\164\150\103\x6c\151\145\x6e\x74\x5c\x50\162\x65\x6d\x69\165\155\x5c\x43\165\x73\x74\157\x6d\151\x7a\141\x74\x69\157\x6e") && $this->utils->check_versi(2)) {
            goto ec;
        }
        if (class_exists("\x4d\x6f\117\x61\x75\x74\150\x43\154\x69\145\x6e\x74\x5c\123\x74\141\156\144\141\x72\144\134\x43\165\x73\164\x6f\x6d\151\x7a\x61\164\151\157\156") && $this->utils->check_versi(1)) {
            goto p2;
        }
        if (class_exists("\134\x4d\157\117\141\x75\x74\150\x43\x6c\x69\x65\x6e\164\x5c\x46\x72\x65\x65\x5c\103\165\x73\164\157\x6d\151\x7a\141\164\151\x6f\x6e") && $this->utils->check_versi(0)) {
            goto JH;
        }
        wp_die("\120\154\145\x61\163\145\40\x43\x68\x61\156\x67\145\40\x54\150\145\x20\x76\145\x72\163\151\x6f\x6e\40\142\x61\x63\153\x20\x74\x6f\40\x77\x68\141\x74\x20\x69\164\40\162\x65\x61\x6c\154\x79\40\167\141\163");
        die;
        goto ho;
        wx:
        return new \MoOauthClient\Enterprise\Customization();
        goto ho;
        ec:
        return new \MoOauthClient\Premium\Customization();
        goto ho;
        p2:
        return new \MoOauthClient\Standard\Customization();
        goto ho;
        JH:
        return new \MoOauthClient\Free\Customization();
        ho:
    }
    public function get_clientappui_instance()
    {
        if (class_exists("\x4d\x6f\x4f\x61\x75\x74\150\x43\154\x69\x65\x6e\x74\134\x45\156\164\145\162\x70\x72\x69\163\145\134\103\154\151\145\156\164\x41\x70\x70\x55\111") && $this->utils->check_versi(3)) {
            goto Aj;
        }
        if (class_exists("\x4d\x6f\x4f\141\165\x74\x68\103\x6c\151\145\156\x74\134\x50\x72\145\155\x69\x75\155\x5c\103\x6c\151\x65\x6e\164\x41\x70\x70\125\x49") && $this->utils->check_versi(2)) {
            goto en;
        }
        if (class_exists("\115\x6f\117\141\165\x74\150\103\x6c\151\145\156\x74\x5c\123\x74\x61\156\144\x61\162\144\134\103\154\151\145\156\x74\101\x70\x70\125\111") && $this->utils->check_versi(1)) {
            goto Et;
        }
        if (class_exists("\x5c\115\x6f\x4f\x61\165\164\150\x43\x6c\151\x65\x6e\x74\x5c\106\162\145\145\134\x43\x6c\151\145\x6e\x74\101\160\x70\125\111") && $this->utils->check_versi(0)) {
            goto I8;
        }
        wp_die("\120\154\x65\x61\163\145\40\x43\150\x61\x6e\147\145\x20\x54\150\x65\40\166\145\x72\x73\x69\157\x6e\40\142\141\x63\153\x20\164\157\40\167\x68\141\x74\x20\151\x74\x20\162\x65\141\154\154\x79\x20\167\x61\163");
        die;
        goto wB;
        Aj:
        return new \MoOauthClient\Enterprise\ClientAppUI();
        goto wB;
        en:
        return new \MoOauthClient\Premium\ClientAppUI();
        goto wB;
        Et:
        return new \MoOauthClient\Standard\ClientAppUI();
        goto wB;
        I8:
        return new \MoOauthClient\Free\ClientAppUI();
        wB:
    }
    public function get_login_handler_instance()
    {
        if (class_exists("\115\x6f\x4f\141\165\164\x68\103\154\x69\x65\x6e\164\x5c\x45\x6e\164\x65\162\x70\x72\151\163\x65\x5c\114\x6f\x67\x69\x6e\110\141\x6e\144\154\x65\x72") && $this->utils->check_versi(3)) {
            goto lZ;
        }
        if (class_exists("\115\157\x4f\141\x75\x74\150\103\154\151\x65\156\164\134\x50\x72\x65\155\151\x75\x6d\x5c\114\x6f\x67\151\156\x48\141\156\144\x6c\145\162") && $this->utils->check_versi(2)) {
            goto Jq;
        }
        if (class_exists("\x4d\x6f\117\x61\165\164\x68\x43\x6c\x69\145\156\x74\134\123\x74\141\156\144\x61\x72\144\x5c\114\157\147\151\x6e\110\x61\156\144\x6c\145\162") && $this->utils->check_versi(1)) {
            goto DD;
        }
        if (class_exists("\x5c\115\157\x4f\x61\165\164\150\103\154\151\145\x6e\164\x5c\114\157\147\x69\156\110\141\x6e\144\x6c\145\162") && $this->utils->check_versi(0)) {
            goto Rg;
        }
        wp_die("\120\x6c\145\141\x73\x65\x20\103\x68\141\x6e\x67\x65\40\x54\150\145\x20\166\x65\162\163\151\x6f\156\x20\x62\141\143\153\x20\164\x6f\40\x77\x68\141\x74\x20\151\164\x20\162\145\x61\154\154\171\40\x77\141\x73");
        die;
        goto U8;
        lZ:
        return new \MoOauthClient\Enterprise\LoginHandler();
        goto U8;
        Jq:
        return new \MoOauthClient\Premium\LoginHandler();
        goto U8;
        DD:
        return new \MoOauthClient\Standard\LoginHandler();
        goto U8;
        Rg:
        return new \MoOauthClient\LoginHandler();
        U8:
    }
    public function get_settings_instance()
    {
        if (class_exists("\x4d\x6f\x4f\x61\x75\164\x68\103\154\x69\x65\x6e\x74\134\x45\x6e\x74\145\x72\160\162\151\x73\x65\134\105\156\x74\x65\162\x70\x72\x69\x73\145\123\145\164\164\x69\x6e\147\x73") && $this->utils->check_versi(3)) {
            goto b1;
        }
        if (class_exists("\x4d\x6f\x4f\x61\165\x74\150\103\x6c\151\x65\x6e\x74\x5c\x50\x72\x65\x6d\x69\x75\155\x5c\x50\x72\x65\x6d\151\x75\155\x53\x65\164\164\151\156\x67\163") && $this->utils->check_versi(2)) {
            goto FM;
        }
        if (class_exists("\x4d\157\117\141\x75\164\x68\x43\x6c\151\x65\156\164\x5c\x53\x74\x61\156\x64\141\x72\x64\x5c\123\x74\x61\x6e\x64\x61\162\144\x53\145\164\x74\151\156\147\x73") && $this->utils->check_versi(1)) {
            goto He;
        }
        if (class_exists("\115\x6f\117\141\x75\x74\150\x43\154\151\x65\156\x74\134\x46\162\x65\x65\134\x46\162\x65\x65\123\x65\164\164\x69\156\147\163") && $this->utils->check_versi(0)) {
            goto Bk;
        }
        wp_die("\120\x6c\145\141\x73\x65\40\x43\150\x61\x6e\147\145\x20\x54\x68\145\40\x76\x65\x72\163\151\157\x6e\x20\x62\141\143\153\40\164\x6f\40\x77\x68\141\164\x20\x69\x74\x20\x72\145\x61\154\x6c\x79\40\x77\141\163");
        die;
        goto WN;
        b1:
        return new \MoOauthClient\Enterprise\EnterpriseSettings();
        goto WN;
        FM:
        return new \MoOauthClient\Premium\PremiumSettings();
        goto WN;
        He:
        return new \MoOauthClient\Standard\StandardSettings();
        goto WN;
        Bk:
        return new \MoOauthClient\Free\FreeSettings();
        WN:
    }
    public function get_accounts_instance()
    {
        if (class_exists("\115\157\117\141\x75\164\150\x43\x6c\x69\145\x6e\x74\x5c\x50\x61\x69\x64\134\x41\143\143\157\x75\156\164\163") && $this->utils->check_versi(1)) {
            goto AV;
        }
        return new \MoOauthClient\Accounts();
        goto pl;
        AV:
        return new \MoOauthClient\Paid\Accounts();
        pl:
    }
    public function get_user_analytics()
    {
        if (class_exists("\115\157\x4f\141\x75\164\x68\x43\x6c\x69\x65\x6e\x74\x5c\105\156\164\x65\162\160\x72\151\163\x65\x5c\125\163\145\x72\x41\x6e\141\154\171\164\x69\x63\x73") && $this->utils->check_versi(3)) {
            goto MH;
        }
        wp_die("\x50\154\145\x61\x73\145\x20\x43\150\x61\156\x67\145\x20\x54\150\145\40\x76\145\162\x73\151\157\x6e\40\x62\x61\x63\153\40\x74\157\x20\167\x68\x61\x74\x20\151\x74\40\x72\145\141\154\154\171\x20\x77\141\163");
        die;
        goto PZ;
        MH:
        return new \MoOauthClient\Enterprise\UserAnalytics();
        PZ:
    }
    public function get_utils_instance()
    {
        if (!(class_exists("\x4d\x6f\117\141\165\164\x68\103\154\151\145\156\x74\x5c\123\x74\x61\x6e\144\141\162\x64\134\x4d\117\x55\164\151\x6c\x73") && $this->utils->check_versi(1))) {
            goto WS;
        }
        return new \MoOauthClient\Standard\MOUtils();
        WS:
        return $this->utils;
    }
}
