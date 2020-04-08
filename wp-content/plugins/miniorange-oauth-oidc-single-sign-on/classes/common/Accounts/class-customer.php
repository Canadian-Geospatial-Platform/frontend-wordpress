<?php


namespace MoOauthClient;

class Customer
{
    public $email;
    public $phone;
    private $default_customer_key = "\x31\x36\x35\65\65";
    private $default_api_key = "\146\x46\x64\62\x58\143\166\x54\107\x44\145\155\132\166\x62\x77\61\142\x63\125\145\163\116\x4a\x57\x45\161\113\x62\x62\x55\161";
    private $host_name = '';
    private $host_key = '';
    public function __construct()
    {
        global $xW;
        $this->host_name = $xW->mo_oauth_client_get_option("\x68\157\x73\164\137\x6e\141\x6d\x65");
        $this->email = $xW->mo_oauth_client_get_option("\x6d\x6f\x5f\x6f\141\165\x74\x68\137\141\x64\155\151\x6e\x5f\145\x6d\141\x69\x6c");
        $this->phone = $xW->mo_oauth_client_get_option("\x6d\157\137\157\141\x75\x74\x68\x5f\141\144\x6d\x69\x6e\x5f\160\x68\x6f\156\x65");
        $this->host_key = $xW->mo_oauth_client_get_option("\160\x61\163\x73\167\157\x72\x64");
    }
    public function create_customer()
    {
        global $xW;
        $a8 = $this->host_name . "\57\155\x6f\x61\163\57\x72\x65\163\164\57\x63\165\x73\164\157\155\145\x72\57\141\144\144";
        $Wd = $this->host_key;
        $eC = $xW->mo_oauth_client_get_option("\x6d\x6f\x5f\157\x61\x75\164\x68\137\141\x64\155\x69\x6e\137\146\x6e\141\x6d\x65");
        $lJ = $xW->mo_oauth_client_get_option("\155\x6f\x5f\x6f\x61\x75\x74\x68\x5f\141\144\155\x69\156\137\154\x6e\141\155\145");
        $W0 = $xW->mo_oauth_client_get_option("\155\157\137\157\x61\x75\x74\x68\x5f\141\144\x6d\151\156\x5f\x63\x6f\x6d\x70\x61\x6e\x79");
        $AA = array("\143\157\155\160\141\x6e\171\x4e\x61\155\x65" => $W0, "\x61\x72\x65\141\117\146\x49\x6e\x74\x65\x72\145\x73\x74" => "\x57\120\x20\117\101\165\164\x68\40\x43\154\151\145\x6e\164", "\146\151\x72\163\164\x6e\x61\x6d\145" => $eC, "\x6c\x61\x73\x74\156\141\155\x65" => $lJ, \MoOAuthConstants::EMAIL => $this->email, "\160\x68\x6f\x6e\145" => $this->phone, "\160\141\x73\163\x77\157\x72\144" => $Wd);
        $ct = wp_json_encode($AA);
        return $this->send_request(array(), false, $ct, array(), false, $a8);
    }
    public function get_customer_key()
    {
        global $xW;
        $a8 = $this->host_name . "\57\x6d\x6f\x61\x73\57\x72\145\163\x74\x2f\x63\x75\163\164\x6f\155\145\162\57\x6b\x65\x79";
        $xv = $this->email;
        $Wd = $this->host_key;
        $AA = array(\MoOAuthConstants::EMAIL => $xv, "\x70\141\163\163\167\x6f\x72\x64" => $Wd);
        $ct = wp_json_encode($AA);
        return $this->send_request(array(), false, $ct, array(), false, $a8);
    }
    public function add_oauth_application($ts, $iR)
    {
        global $xW;
        $a8 = $this->host_name . "\57\x6d\157\x61\163\x2f\x72\x65\x73\164\x2f\141\160\x70\154\151\143\x61\164\151\157\156\x2f\141\x64\x64\x6f\141\x75\164\x68";
        $mH = $xW->mo_oauth_client_get_option("\x6d\x6f\137\x6f\x61\165\x74\x68\137\x61\144\155\x69\156\137\x63\165\163\x74\157\x6d\x65\x72\137\x6b\145\x79");
        $LV = $xW->mo_oauth_client_get_option("\155\x6f\x5f\x6f\141\165\164\x68\137" . $ts . "\x5f\163\143\157\160\145");
        $bY = $xW->mo_oauth_client_get_option("\x6d\157\137\157\x61\x75\164\150\137" . $ts . "\x5f\x63\154\151\145\x6e\x74\x5f\151\144");
        $uN = $xW->mo_oauth_client_get_option("\155\157\x5f\157\x61\165\x74\150\x5f" . $ts . "\137\x63\154\151\145\x6e\164\x5f\x73\145\x63\162\145\164");
        if (false !== $LV) {
            goto YY;
        }
        $AA = array("\x61\x70\x70\x6c\151\x63\141\x74\x69\157\x6e\x4e\x61\155\x65" => $iR, "\x63\x75\163\x74\157\155\145\x72\111\144" => $mH, "\x63\x6c\x69\x65\x6e\164\111\x64" => $bY, "\143\154\x69\145\x6e\164\x53\145\x63\x72\145\164" => $uN);
        goto Q5;
        YY:
        $AA = array("\x61\x70\x70\154\151\x63\141\164\151\x6f\156\x4e\141\155\x65" => $iR, "\x73\x63\157\x70\x65" => $LV, "\x63\165\x73\x74\157\155\x65\162\x49\144" => $mH, "\143\x6c\x69\x65\x6e\x74\x49\x64" => $bY, "\x63\154\x69\145\156\164\x53\145\143\162\x65\x74" => $uN);
        Q5:
        $ct = wp_json_encode($AA);
        return $this->send_request(array(), false, $ct, array(), false, $a8);
    }
    public function submit_contact_us($xv, $Fs, $LD, $ir = true)
    {
        global $current_user;
        global $xW;
        wp_get_current_user();
        $xs = $xW->export_plugin_config(true);
        $AM = json_encode($xs, JSON_UNESCAPED_SLASHES);
        $mH = $this->default_customer_key;
        $hQ = $this->default_api_key;
        $Cu = time();
        $a8 = $this->host_name . "\x2f\x6d\x6f\141\x73\x2f\141\x70\x69\57\156\x6f\164\x69\x66\x79\x2f\x73\145\x6e\x64";
        $cu = $mH . $Cu . $hQ;
        $nN = hash("\163\150\141\65\x31\x32", $cu);
        $Xw = $xv;
        $KW = \ucwords(\strtolower($xW->get_versi_str())) . "\x20\55\40" . \get_version_number();
        $Qn = "\x51\x75\145\162\x79\x3a\x20\x57\x6f\x72\x64\120\x72\x65\x73\163\x20\x4f\101\165\x74\x68\x20" . $KW . "\x20\x50\x6c\165\x67\x69\x6e";
        $LD = "\x5b\x57\120\40\117\x41\165\164\150\x20\x43\154\151\x65\x6e\164\x20" . $KW . "\135\x20" . $LD;
        if (!$ir) {
            goto bb;
        }
        $LD .= "\x3c\142\162\76\74\142\162\x3e\103\157\x6e\146\x69\147\x20\x53\164\x72\151\156\x67\x3a\x3c\142\x72\76\74\x70\162\145\40\163\164\x79\x6c\145\x3d\x22\142\x6f\162\x64\145\x72\x3a\61\x70\x78\40\x73\157\154\x69\x64\40\43\x34\x34\x34\x3b\x70\x61\x64\144\151\156\x67\x3a\x31\x30\160\x78\x3b\42\76\74\x63\157\x64\145\76" . $AM . "\74\57\143\157\144\x65\x3e\x3c\57\x70\162\x65\x3e";
        bb:
        $WG = isset($_SERVER["\123\105\x52\126\x45\x52\137\116\x41\x4d\x45"]) ? sanitize_text_field(wp_unslash($_SERVER["\123\x45\x52\126\x45\122\x5f\x4e\x41\x4d\x45"])) : '';
        $PI = "\74\144\x69\166\40\x3e\110\145\154\x6c\x6f\54\x20\x3c\x62\162\x3e\74\x62\162\76\106\151\x72\x73\164\x20\116\x61\x6d\145\40\x3a" . $current_user->user_firstname . "\x3c\x62\162\76\74\142\x72\76\114\x61\163\164\40\40\116\141\x6d\x65\x20\72" . $current_user->user_lastname . "\x20\40\x20\x3c\142\162\76\x3c\x62\162\x3e\103\x6f\155\x70\x61\x6e\171\40\72\74\x61\40\150\162\145\146\x3d\42" . $WG . "\x22\40\x74\141\162\147\145\x74\x3d\42\x5f\142\x6c\141\156\x6b\42\40\x3e" . $WG . "\74\x2f\141\76\x3c\x62\162\x3e\74\142\x72\76\120\x68\157\x6e\145\40\x4e\x75\x6d\x62\145\162\x20\x3a" . $Fs . "\x3c\142\x72\76\x3c\142\x72\76\105\x6d\x61\x69\x6c\x20\72\74\x61\x20\x68\162\145\x66\75\42\155\141\x69\154\164\x6f\x3a" . $Xw . "\42\40\x74\141\x72\147\145\x74\75\42\x5f\142\x6c\x61\x6e\x6b\42\76" . $Xw . "\x3c\57\x61\76\74\142\162\x3e\x3c\x62\x72\76\x51\165\145\162\x79\40\72" . $LD . "\x3c\x2f\144\x69\166\76";
        $AA = array("\x63\x75\x73\164\157\x6d\x65\162\x4b\x65\x79" => $mH, "\x73\145\x6e\x64\x45\x6d\x61\x69\x6c" => true, \MoOAuthConstants::EMAIL => array("\x63\x75\x73\x74\x6f\x6d\x65\162\x4b\145\x79" => $mH, "\x66\x72\x6f\155\x45\x6d\141\151\x6c" => $Xw, "\142\x63\143\x45\x6d\x61\x69\154" => "\x69\156\146\157\100\170\x65\x63\165\162\x69\x66\x79\56\x63\x6f\x6d", "\146\x72\157\155\x4e\x61\x6d\x65" => "\x6d\x69\156\151\x4f\162\141\156\147\x65", "\164\157\105\155\x61\151\154" => "\x6f\x61\x75\164\x68\163\x75\x70\x70\x6f\162\x74\100\x78\x65\143\165\x72\x69\146\x79\56\143\x6f\155", "\x74\x6f\116\x61\x6d\145" => "\x6f\x61\x75\164\x68\x73\165\x70\x70\157\162\164\100\x78\x65\143\165\162\151\x66\171\56\x63\157\155", "\x73\x75\142\152\145\x63\164" => $Qn, "\143\x6f\156\164\x65\156\164" => $PI));
        $ct = json_encode($AA, JSON_UNESCAPED_SLASHES);
        $bk = array("\x43\x6f\156\x74\x65\156\x74\55\x54\x79\160\145" => "\141\x70\160\154\151\143\x61\164\x69\157\x6e\57\x6a\163\157\x6e");
        $bk["\x43\165\x73\x74\x6f\x6d\145\162\55\113\x65\x79"] = $mH;
        $bk["\124\151\155\x65\x73\x74\x61\x6d\x70"] = $Cu;
        $bk["\101\165\164\x68\157\162\x69\172\x61\x74\151\157\156"] = $nN;
        return $this->send_request($bk, true, $ct, array(), false, $a8);
    }
    public function send_otp_token($xv = '', $Fs = '', $MU = true, $RN = false)
    {
        global $xW;
        $a8 = $this->host_name . "\57\x6d\157\141\x73\x2f\x61\160\x69\x2f\141\165\x74\150\x2f\143\150\x61\x6c\x6c\x65\156\x67\x65";
        $mH = $this->default_customer_key;
        $hQ = $this->default_api_key;
        $ZD = $this->email;
        $Fs = $xW->mo_oauth_client_get_option("\155\x6f\137\157\x61\x75\x74\150\x5f\141\x64\x6d\x69\x6e\x5f\x70\150\157\x6e\x65");
        $Cu = self::get_timestamp();
        $cu = $mH . $Cu . $hQ;
        $nN = hash("\163\x68\x61\x35\61\62", $cu);
        $e4 = "\103\x75\163\164\157\155\145\162\x2d\x4b\145\x79\72\40" . $mH;
        $T5 = "\124\151\x6d\x65\163\x74\141\155\x70\x3a\x20" . $Cu;
        $c3 = "\101\x75\x74\x68\157\x72\x69\x7a\x61\164\151\x6f\156\x3a\x20" . $nN;
        if ($MU) {
            goto ZO;
        }
        $AA = array("\143\x75\x73\164\x6f\x6d\x65\162\113\145\171" => $mH, "\x70\150\x6f\156\145" => $Fs, "\141\x75\164\150\x54\171\160\145" => "\123\x4d\123");
        goto ya;
        ZO:
        $AA = array("\x63\165\163\x74\x6f\155\x65\x72\x4b\x65\171" => $mH, \MoOAuthConstants::EMAIL => $ZD, "\x61\x75\164\x68\x54\171\160\x65" => "\105\115\x41\111\114");
        ya:
        $ct = wp_json_encode($AA);
        $bk = array("\x43\x6f\x6e\x74\145\156\x74\x2d\124\171\160\145" => "\141\x70\x70\154\x69\x63\141\x74\151\157\156\57\x6a\163\157\x6e");
        $bk["\x43\x75\163\x74\157\x6d\145\162\55\113\145\171"] = $mH;
        $bk["\x54\151\155\x65\x73\x74\141\155\160"] = $Cu;
        $bk["\x41\165\x74\x68\x6f\162\x69\172\141\164\151\157\x6e"] = $nN;
        return $this->send_request($bk, true, $ct, array(), false, $a8);
    }
    public function get_timestamp()
    {
        global $xW;
        $a8 = $this->host_name . "\57\155\x6f\141\163\57\162\x65\163\164\57\155\157\x62\151\154\145\x2f\147\x65\x74\55\x74\x69\x6d\145\x73\164\x61\x6d\x70";
        return $this->send_request(array(), false, '', array(), false, $a8);
    }
    public function validate_otp_token($vk, $br)
    {
        global $xW;
        $a8 = $this->host_name . "\57\x6d\157\141\163\57\141\160\151\57\141\x75\164\150\57\166\141\154\151\x64\x61\x74\145";
        $mH = $this->default_customer_key;
        $hQ = $this->default_api_key;
        $ZD = $this->email;
        $Cu = self::get_timestamp();
        $cu = $mH . $Cu . $hQ;
        $nN = hash("\x73\150\141\65\x31\62", $cu);
        $e4 = "\x43\x75\163\x74\157\x6d\x65\162\55\113\x65\171\72\40" . $mH;
        $T5 = "\124\x69\155\145\163\x74\x61\x6d\160\72\x20" . $Cu;
        $c3 = "\x41\165\x74\x68\x6f\162\x69\x7a\x61\x74\x69\157\156\72\x20" . $nN;
        $ct = '';
        $AA = array("\164\170\x49\144" => $vk, "\164\x6f\153\145\156" => $br);
        $ct = wp_json_encode($AA);
        $bk = array("\103\157\x6e\x74\145\156\x74\x2d\124\171\160\145" => "\141\160\160\154\151\143\x61\164\x69\157\156\x2f\152\x73\157\156");
        $bk["\x43\165\163\x74\157\155\145\x72\x2d\x4b\x65\171"] = $mH;
        $bk["\x54\151\x6d\145\163\x74\141\x6d\160"] = $Cu;
        $bk["\101\x75\x74\150\157\162\151\172\x61\164\x69\157\156"] = $nN;
        return $this->send_request($bk, true, $ct, array(), false, $a8);
    }
    public function check_customer()
    {
        global $xW;
        $a8 = $this->host_name . "\57\155\x6f\x61\163\x2f\162\x65\163\164\x2f\143\x75\163\164\157\x6d\x65\x72\x2f\x63\150\x65\143\x6b\55\151\146\x2d\145\170\151\x73\x74\163";
        $xv = $this->email;
        $AA = array(\MoOAuthConstants::EMAIL => $xv);
        $ct = wp_json_encode($AA);
        return $this->send_request(array(), false, $ct, array(), false, $a8);
    }
    public function mo_oauth_send_email_alert($xv, $Fs, $wP)
    {
        global $xW;
        if ($this->check_internet_connection()) {
            goto cH;
        }
        return;
        cH:
        $a8 = $this->host_name . "\57\155\157\x61\163\57\141\160\151\57\x6e\x6f\x74\151\146\171\57\163\x65\x6e\144";
        global $user;
        $mH = $this->default_customer_key;
        $hQ = $this->default_api_key;
        $Cu = self::get_timestamp();
        $cu = $mH . $Cu . $hQ;
        $nN = hash("\163\150\141\65\61\x32", $cu);
        $Xw = $xv;
        $Qn = "\106\145\145\x64\x62\x61\x63\153\72\x20\x57\x6f\x72\144\120\x72\145\x73\163\40\x4f\101\165\164\x68\x20\103\154\x69\x65\156\164\x20\x50\x6c\x75\x67\151\156";
        $mk = site_url();
        $user = wp_get_current_user();
        $KW = \ucwords(\strtolower($xW->get_versi_str())) . "\40\x2d\40" . \get_version_number();
        $LD = "\x5b\x57\120\40\117\x41\165\x74\x68\40\62\x2e\x30\x20\x43\x6c\151\145\156\164\40" . $KW . "\x5d\40\x3a\x20" . $wP;
        $WG = isset($_SERVER["\x53\105\122\x56\105\x52\x5f\x4e\x41\x4d\105"]) ? sanitize_text_field(wp_unslash($_SERVER["\x53\105\122\126\x45\122\137\x4e\x41\x4d\x45"])) : '';
        $PI = "\74\x64\151\x76\x20\x3e\x48\x65\154\154\x6f\x2c\x20\74\x62\162\76\74\142\x72\76\106\151\162\x73\164\x20\116\x61\155\x65\40\72" . $user->user_firstname . "\x3c\142\x72\x3e\74\142\162\x3e\114\x61\x73\x74\40\x20\116\141\x6d\x65\x20\x3a" . $user->user_lastname . "\x20\x20\x20\74\142\x72\x3e\x3c\142\x72\x3e\x43\157\x6d\160\141\x6e\171\x20\x3a\74\x61\40\x68\162\x65\146\75\x22" . $WG . "\x22\x20\x74\x61\x72\147\x65\164\x3d\42\137\142\154\141\x6e\x6b\42\x20\76" . $WG . "\x3c\x2f\141\76\74\142\x72\76\74\x62\162\76\x50\x68\157\156\145\x20\x4e\x75\155\142\145\x72\x20\x3a" . $Fs . "\74\x62\162\76\x3c\142\x72\76\105\155\141\151\154\x20\72\74\x61\x20\150\x72\145\x66\75\42\155\141\151\154\x74\157\72" . $Xw . "\42\x20\164\x61\162\x67\145\x74\x3d\x22\137\x62\154\x61\156\x6b\42\76" . $Xw . "\x3c\x2f\141\76\x3c\142\x72\x3e\74\x62\162\x3e\x51\165\x65\162\x79\40\72" . $LD . "\74\57\144\x69\166\76";
        $AA = array("\143\165\x73\164\x6f\155\145\x72\x4b\145\x79" => $mH, "\163\x65\x6e\x64\x45\x6d\x61\x69\x6c" => true, \MoOAuthConstants::EMAIL => array("\143\x75\163\164\157\x6d\145\162\x4b\x65\x79" => $mH, "\146\162\157\x6d\105\155\141\151\x6c" => $Xw, "\x62\143\143\x45\155\x61\151\x6c" => "\x6f\x61\x75\164\150\x73\165\160\x70\157\162\x74\100\x6d\151\156\x69\157\x72\141\x6e\147\x65\x2e\x63\157\155", "\x66\162\157\x6d\x4e\x61\x6d\x65" => "\x6d\151\x6e\x69\x4f\162\141\x6e\x67\x65", "\164\157\x45\155\141\x69\154" => "\157\x61\165\x74\x68\163\x75\x70\x70\x6f\x72\x74\100\x6d\x69\x6e\151\x6f\162\x61\x6e\147\145\56\143\157\x6d", "\x74\157\116\x61\x6d\145" => "\x6f\141\x75\x74\150\163\x75\x70\160\157\x72\164\100\155\x69\156\151\x6f\x72\141\156\x67\145\x2e\x63\x6f\x6d", "\x73\165\x62\x6a\145\143\164" => $Qn, "\143\157\x6e\x74\x65\156\164" => $PI));
        $ct = wp_json_encode($AA);
        $bk = array("\103\x6f\156\164\145\x6e\x74\x2d\124\171\x70\145" => "\141\160\160\x6c\151\x63\141\164\x69\x6f\x6e\57\x6a\163\x6f\x6e");
        $bk["\x43\x75\163\164\157\155\x65\x72\x2d\x4b\x65\x79"] = $mH;
        $bk["\x54\151\x6d\145\x73\164\x61\155\160"] = $Cu;
        $bk["\101\165\164\150\157\162\x69\x7a\x61\164\151\157\x6e"] = $nN;
        return $this->send_request($bk, true, $ct, array(), false, $a8);
    }
    public function mo_oauth_send_demo_alert($xv, $zW, $wP, $Qn)
    {
        if ($this->check_internet_connection()) {
            goto Wi;
        }
        return;
        Wi:
        $a8 = $this->host_name . "\57\155\x6f\141\x73\x2f\x61\160\151\x2f\x6e\157\164\x69\146\171\57\163\x65\156\x64";
        $mH = $this->default_customer_key;
        $hQ = $this->default_api_key;
        $Cu = self::get_timestamp();
        $cu = $mH . $Cu . $hQ;
        $nN = hash("\x73\150\141\65\61\62", $cu);
        $Xw = $xv;
        global $user;
        $user = wp_get_current_user();
        $PI = "\74\144\151\x76\40\76\110\145\154\154\157\x2c\x20\x3c\57\x61\x3e\74\x62\x72\x3e\x3c\x62\x72\x3e\x45\155\x61\151\154\40\72\x3c\x61\x20\x68\162\x65\x66\x3d\x22\x6d\x61\151\x6c\x74\x6f\72" . $Xw . "\x22\40\x74\x61\162\x67\x65\164\x3d\42\137\142\x6c\x61\156\153\x22\76" . $Xw . "\74\57\x61\x3e\74\x62\x72\76\x3c\x62\162\76\x52\145\161\165\145\x73\x74\x65\144\x20\x44\145\x6d\157\40\x66\157\x72\40\40\40\40\40\x3a\x20" . $zW . "\x3c\x62\162\x3e\74\x62\162\76\x52\145\x71\165\151\162\x65\155\x65\156\x74\163\40\40\x20\40\40\x20\x20\x20\x20\40\40\72\40" . $wP . "\74\57\144\x69\166\76";
        $AA = array("\x63\x75\x73\x74\157\155\x65\162\113\x65\171" => $mH, "\x73\x65\x6e\144\x45\x6d\141\151\154" => true, \MoOAuthConstants::EMAIL => array("\143\x75\163\164\157\x6d\145\x72\x4b\x65\171" => $mH, "\x66\x72\x6f\155\x45\155\x61\x69\x6c" => $Xw, "\142\143\x63\x45\155\141\151\154" => "\x6f\141\165\164\x68\x73\x75\x70\160\x6f\x72\164\100\155\151\156\151\x6f\162\x61\x6e\x67\145\56\143\x6f\155", "\146\162\157\155\x4e\141\x6d\145" => "\155\x69\156\151\x4f\x72\x61\x6e\147\145", "\164\157\x45\x6d\141\x69\x6c" => "\x6f\x61\165\x74\x68\x73\x75\160\160\157\x72\x74\100\155\x69\156\151\x6f\162\141\x6e\x67\x65\56\x63\157\155", "\164\x6f\x4e\141\155\x65" => "\x6f\x61\165\164\x68\x73\165\160\160\x6f\x72\164\100\x6d\151\x6e\151\x6f\162\x61\x6e\147\145\56\143\157\x6d", "\163\x75\142\152\145\143\x74" => $Qn, "\x63\157\x6e\164\x65\156\164" => $PI));
        $ct = json_encode($AA);
        $bk = array("\x43\x6f\x6e\164\x65\x6e\164\55\124\x79\x70\x65" => "\x61\x70\160\x6c\151\143\x61\x74\x69\157\x6e\x2f\x6a\163\x6f\156");
        $bk["\x43\165\x73\164\x6f\x6d\x65\162\x2d\113\145\x79"] = $mH;
        $bk["\x54\x69\x6d\145\163\164\x61\155\160"] = $Cu;
        $bk["\101\165\164\150\x6f\x72\x69\x7a\x61\x74\151\x6f\156"] = $nN;
        $sL = $this->send_request($bk, true, $ct, array(), false, $a8);
    }
    public function mo_oauth_forgot_password($xv)
    {
        global $xW;
        $a8 = $this->host_name . "\x2f\155\x6f\x61\163\57\162\x65\163\164\57\x63\165\x73\164\x6f\x6d\145\x72\57\x70\141\x73\x73\167\x6f\x72\x64\55\162\145\163\x65\x74";
        $mH = $xW->mo_oauth_client_get_option("\x6d\x6f\137\157\141\x75\164\x68\x5f\141\144\x6d\151\x6e\137\x63\165\x73\x74\x6f\155\145\x72\x5f\x6b\145\171");
        $hQ = $xW->mo_oauth_client_get_option("\x6d\x6f\137\157\x61\165\x74\x68\x5f\141\x64\x6d\151\156\x5f\x61\160\151\x5f\153\145\171");
        $Cu = self::get_timestamp();
        $cu = $mH . $Cu . $hQ;
        $nN = hash("\x73\150\141\65\x31\62", $cu);
        $e4 = "\x43\x75\x73\164\x6f\x6d\x65\162\55\113\x65\171\x3a\40" . $mH;
        $T5 = "\x54\x69\155\x65\x73\164\141\x6d\x70\x3a\x20" . number_format($Cu, 0, '', '');
        $c3 = "\x41\165\x74\x68\x6f\x72\151\x7a\x61\x74\x69\157\x6e\x3a\x20" . $nN;
        $ct = '';
        $AA = array(\MoOAuthConstants::EMAIL => $xv);
        $ct = wp_json_encode($AA);
        $bk = array("\x43\157\x6e\164\145\x6e\x74\55\124\171\160\145" => "\141\160\x70\x6c\x69\x63\x61\x74\151\x6f\156\x2f\x6a\163\157\156");
        $bk["\103\165\x73\164\157\x6d\145\x72\55\x4b\x65\171"] = $mH;
        $bk["\x54\x69\x6d\x65\x73\x74\141\155\x70"] = $Cu;
        $bk["\101\x75\164\150\x6f\162\151\172\x61\x74\151\x6f\x6e"] = $nN;
        return $this->send_request($bk, true, $ct, array(), false, $a8);
    }
    public function check_internet_connection()
    {
        return (bool) @fsockopen("\154\x6f\147\151\x6e\56\x78\x65\143\165\162\151\146\171\56\x63\x6f\x6d", 443, $AE, $KO, 5);
    }
    private function send_request($ZK = false, $XZ = false, $ct = '', $BR = false, $TT = false, $a8 = '')
    {
        $bk = array("\x43\x6f\156\x74\145\x6e\x74\x2d\x54\x79\160\145" => "\x61\160\160\154\x69\x63\x61\164\151\157\156\x2f\x6a\x73\157\156", "\x63\x68\141\162\163\145\x74" => "\125\x54\x46\40\x2d\x20\70", "\101\x75\x74\150\157\162\151\172\x61\x74\151\157\x6e" => "\102\141\x73\151\x63");
        $bk = $XZ && $ZK ? $ZK : array_unique(array_merge($bk, $ZK));
        $w1 = array("\155\145\x74\150\x6f\144" => "\120\x4f\123\124", "\x62\157\144\x79" => $ct, "\x74\x69\x6d\x65\157\165\x74" => "\x35", "\162\x65\x64\x69\162\145\x63\x74\151\x6f\x6e" => "\x35", "\150\164\x74\160\x76\x65\x72\x73\x69\157\x6e" => "\61\x2e\60", "\142\154\157\143\153\151\x6e\147" => true, "\x68\145\x61\x64\x65\162\163" => $bk, "\163\x73\154\166\x65\162\x69\x66\171" => true);
        $w1 = $TT ? $BR : array_unique(array_merge($w1, $BR), SORT_REGULAR);
        $sL = wp_remote_post($a8, $w1);
        if (!is_wp_error($sL)) {
            goto K4;
        }
        $N5 = $sL->get_error_message();
        echo wp_kses("\123\157\x6d\145\164\x68\x69\x6e\x67\40\167\x65\156\x74\40\x77\162\157\156\x67\72\x20{$N5}", \get_valid_html());
        die;
        K4:
        return wp_remote_retrieve_body($sL);
    }
}
