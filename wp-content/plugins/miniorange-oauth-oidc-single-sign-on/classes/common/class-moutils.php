<?php


namespace MoOauthClient;

use MoOauthClient\App;
class MOUtils
{
    const FREE = 0;
    const STANDARD = 1;
    const PREMIUM = 2;
    const ENTERPRISE = 3;
    public function __construct()
    {
        remove_action("\141\144\x6d\151\156\x5f\156\x6f\x74\151\143\145\x73", array($this, "\155\x6f\x5f\x6f\x61\x75\164\150\x5f\x73\x75\x63\x63\x65\163\x73\x5f\x6d\145\163\x73\x61\x67\x65"));
        remove_action("\x61\144\x6d\x69\x6e\137\156\157\x74\x69\x63\x65\163", array($this, "\155\157\x5f\x6f\x61\165\164\x68\137\x65\162\162\x6f\x72\x5f\155\x65\163\163\141\147\x65"));
    }
    public function mo_oauth_success_message()
    {
        $kC = "\145\x72\162\x6f\162";
        $wP = $this->mo_oauth_client_get_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION);
        echo "\74\144\151\x76\40\143\154\x61\163\x73\75\x27" . $kC . "\47\x3e\x20\x3c\160\x3e" . $wP . "\74\x2f\160\x3e\74\x2f\144\x69\x76\x3e";
    }
    public function mo_oauth_error_message()
    {
        $kC = "\x75\x70\144\x61\x74\x65\x64";
        $wP = $this->mo_oauth_client_get_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION);
        echo "\x3c\144\x69\x76\40\143\x6c\141\163\x73\75\47" . $kC . "\x27\76\x3c\160\76" . $wP . "\x3c\57\160\x3e\74\57\144\151\166\x3e";
    }
    public function mo_oauth_show_success_message()
    {
        remove_action("\x61\x64\155\151\156\137\156\x6f\x74\x69\143\x65\163", array($this, "\x6d\157\137\x6f\141\165\x74\150\x5f\x73\x75\x63\x63\145\163\163\137\x6d\145\163\x73\x61\x67\145"));
        add_action("\141\144\155\151\156\x5f\156\x6f\164\151\x63\x65\163", array($this, "\x6d\x6f\137\157\x61\x75\164\150\137\145\162\162\157\x72\137\x6d\145\163\x73\x61\147\145"));
    }
    public function mo_oauth_show_error_message()
    {
        remove_action("\141\x64\155\151\156\137\x6e\157\164\x69\143\145\x73", array($this, "\x6d\157\x5f\x6f\x61\x75\x74\x68\137\145\162\x72\157\x72\137\155\x65\x73\163\x61\147\145"));
        add_action("\x61\144\x6d\x69\156\x5f\156\157\x74\151\x63\x65\163", array($this, "\x6d\x6f\137\x6f\141\x75\x74\150\x5f\163\x75\x63\x63\145\163\163\137\155\145\x73\163\141\x67\145"));
    }
    public function mo_oauth_is_customer_registered()
    {
        $xv = $this->mo_oauth_client_get_option("\155\x6f\137\x6f\141\x75\164\150\137\x61\144\155\x69\156\137\x65\155\x61\x69\x6c");
        $mH = $this->mo_oauth_client_get_option("\x6d\157\137\157\141\165\164\150\137\141\x64\155\x69\x6e\137\x63\x75\163\x74\x6f\x6d\145\162\137\153\145\171");
        if (!$xv || !$mH || !is_numeric(trim($mH))) {
            goto E6;
        }
        return 1;
        goto Oh;
        E6:
        return 0;
        Oh:
    }
    public function mooauthencrypt($qM)
    {
        $L6 = $this->mo_oauth_client_get_option("\143\165\163\164\157\x6d\x65\x72\x5f\x74\157\x6b\145\x6e");
        if ($L6) {
            goto J4;
        }
        return "\146\x61\154\x73\145";
        J4:
        $L6 = str_split(str_pad('', strlen($qM), $L6, STR_PAD_RIGHT));
        $Rz = str_split($qM);
        foreach ($Rz as $bz => $xP) {
            $q7 = ord($xP) + ord($L6[$bz]);
            $Rz[$bz] = chr($q7 > 255 ? $q7 - 256 : $q7);
            eK:
        }
        BB:
        return base64_encode(join('', $Rz));
    }
    public function mooauthdecrypt($qM)
    {
        $qM = base64_decode($qM);
        $L6 = $this->mo_oauth_client_get_option("\x63\165\x73\x74\157\x6d\x65\x72\137\x74\157\153\x65\x6e");
        if ($L6) {
            goto Lk;
        }
        return "\146\x61\x6c\x73\145";
        Lk:
        $L6 = str_split(str_pad('', strlen($qM), $L6, STR_PAD_RIGHT));
        $Rz = str_split($qM);
        foreach ($Rz as $bz => $xP) {
            $q7 = ord($xP) - ord($L6[$bz]);
            $Rz[$bz] = chr($q7 < 0 ? $q7 + 256 : $q7);
            K2:
        }
        aQ:
        return join('', $Rz);
    }
    public function mo_oauth_check_empty_or_null($sw)
    {
        if (!(!isset($sw) || empty($sw))) {
            goto id;
        }
        return true;
        id:
        return false;
    }
    public function mo_oauth_is_curl_installed()
    {
        if (in_array("\x63\165\x72\154", get_loaded_extensions())) {
            goto jA;
        }
        return 0;
        goto ue;
        jA:
        return 1;
        ue:
    }
    public function mo_oauth_show_curl_error()
    {
        if (!($this->mo_oauth_is_curl_installed() === 0)) {
            goto vz;
        }
        $this->mo_oauth_client_update_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION, "\x3c\141\40\x68\x72\x65\x66\75\42\150\x74\164\160\72\x2f\57\160\x68\x70\x2e\156\x65\164\57\x6d\141\x6e\x75\x61\x6c\57\x65\156\x2f\x63\x75\x72\x6c\56\151\x6e\x73\164\x61\154\154\141\x74\151\x6f\x6e\x2e\x70\x68\160\x22\x20\x74\141\x72\x67\x65\x74\75\x22\x5f\x62\x6c\x61\x6e\153\42\x3e\120\110\x50\x20\103\125\122\114\40\145\x78\x74\145\x6e\x73\x69\157\x6e\74\57\x61\76\40\x69\x73\40\156\157\x74\x20\151\156\163\164\141\x6c\x6c\x65\144\x20\157\162\40\144\151\163\141\x62\154\x65\144\56\40\120\x6c\145\x61\x73\x65\x20\145\x6e\x61\142\154\145\x20\151\164\40\164\157\40\x63\x6f\156\x74\151\156\x75\x65\x2e");
        $this->mo_oauth_show_error_message();
        return;
        vz:
    }
    public function mo_oauth_is_clv()
    {
        $Wz = $this->mo_oauth_client_get_option("\x6d\x6f\137\157\x61\x75\x74\150\137\x6c\166");
        $Wz = boolval($Wz) ? $this->mooauthdecrypt($Wz) : "\x66\141\x6c\163\x65";
        return !empty($this->mo_oauth_client_get_option("\x6d\x6f\x5f\x6f\141\x75\164\x68\137\x6c\x6b")) && "\164\x72\165\x65" === $Wz ? 1 : 0;
    }
    public function mo_oauth_hbca_xyake()
    {
        if ($this->mo_oauth_is_customer_registered()) {
            goto yw;
        }
        return false;
        yw:
        if ($this->mo_oauth_client_get_option("\155\x6f\137\157\141\165\x74\x68\x5f\x61\x64\x6d\151\x6e\137\x63\x75\x73\164\157\155\x65\x72\137\153\145\171") > 138200) {
            goto Gp;
        }
        return false;
        goto v4;
        Gp:
        return true;
        v4:
    }
    public function get_default_app($pi, $mN = false)
    {
        if ($pi) {
            goto TO;
        }
        return false;
        TO:
        $lL = false;
        $Lj = wp_remote_get(MOC_URL . "\162\x65\x73\x6f\165\162\x63\x65\x73\57\x61\x70\x70\137\x63\x6f\155\160\x6f\156\x65\x6e\x74\163\57\x64\x65\146\x61\165\x6c\x74\141\160\x70\163\x2e\x6a\163\x6f\x6e", array("\163\163\x6c\x76\x65\x72\x69\146\171" => false))["\142\157\x64\x79"];
        $YW = json_decode($Lj, $mN);
        foreach ($YW as $nX => $Kw) {
            if (!($nX === $pi)) {
                goto d9;
            }
            if ($mN) {
                goto i8;
            }
            $Kw->appId = $nX;
            goto mH;
            i8:
            $Kw["\x61\160\x70\x49\x64"] = $nX;
            mH:
            return $Kw;
            d9:
            vL:
        }
        H5:
        return false;
    }
    public function get_plugin_config()
    {
        $BX = $this->mo_oauth_client_get_option("\x6d\x6f\137\157\x61\165\164\x68\x5f\x63\x6c\151\x65\156\x74\137\x63\x6f\x6e\x66\151\x67");
        return !$BX || empty($BX) ? new Config(array()) : $BX;
    }
    public function get_app_list()
    {
        return $this->mo_oauth_client_get_option("\x6d\x6f\x5f\157\141\165\x74\x68\x5f\x61\x70\x70\x73\137\x6c\151\163\x74") ? $this->mo_oauth_client_get_option("\155\x6f\x5f\157\141\165\164\150\137\141\x70\x70\163\137\x6c\x69\163\x74") : false;
    }
    public function get_app_by_name($Sm = '')
    {
        $rj = $this->get_app_list();
        if ($rj) {
            goto bs;
        }
        return false;
        bs:
        if (!('' === $Sm || false === $Sm)) {
            goto E3;
        }
        $Mu = array_values($rj);
        return isset($Mu[0]) ? $Mu[0] : false;
        E3:
        foreach ($rj as $qV => $eL) {
            if (!($Sm === $qV)) {
                goto Zd;
            }
            return $eL;
            Zd:
            F1:
        }
        R9:
        return false;
    }
    public function get_default_app_by_code_name($Sm = '')
    {
        $rj = $this->mo_oauth_client_get_option("\155\x6f\137\157\141\165\164\x68\137\x61\x70\x70\163\x5f\x6c\x69\163\x74") ? $this->mo_oauth_client_get_option("\155\x6f\x5f\157\x61\165\x74\150\137\141\160\160\x73\x5f\154\151\163\164") : false;
        if ($rj) {
            goto ra;
        }
        return false;
        ra:
        if (!('' === $Sm)) {
            goto Ty;
        }
        $Mu = array_values($rj);
        return isset($Mu[0]) ? $Mu[0] : false;
        Ty:
        foreach ($rj as $qV => $eL) {
            $kU = $eL->get_app_name();
            if (!($Sm === $kU)) {
                goto UY;
            }
            return $this->get_default_app($eL->get_app_config("\x61\x70\x70\x5f\164\171\160\x65"), true);
            UY:
            ca:
        }
        UZ:
        return false;
    }
    public function set_app_by_name($Sm, $mh)
    {
        $rj = $this->mo_oauth_client_get_option("\155\x6f\137\x6f\x61\165\x74\x68\137\x61\160\x70\163\x5f\154\x69\x73\x74") ? $this->mo_oauth_client_get_option("\x6d\x6f\x5f\x6f\x61\x75\164\x68\x5f\141\160\160\163\137\154\151\163\164") : false;
        if ($rj) {
            goto qM;
        }
        return false;
        qM:
        foreach ($rj as $qV => $eL) {
            if (!($Sm === $qV)) {
                goto sR;
            }
            $rj[$qV] = new App($mh);
            $rj[$qV]->set_app_name($qV);
            $this->mo_oauth_client_update_option("\x6d\157\x5f\x6f\141\165\164\150\x5f\141\160\x70\163\137\x6c\x69\x73\164", $rj);
            return true;
            sR:
            YH:
        }
        pt:
        return false;
    }
    public function mo_oauth_jhuyn_jgsukaj($gW, $vD)
    {
        return $this->mo_oauth_jkhuiysuayhbw($gW, $vD);
    }
    public function mo_oauth_jkhuiysuayhbw($VS, $rp)
    {
        $Sp = 0;
        $DL = false;
        $Tb = $this->mo_oauth_client_get_option("\155\157\137\157\x61\165\x74\150\x5f\x61\165\x74\150\157\162\x69\x7a\141\x74\151\157\x6e\163");
        if (empty($Tb)) {
            goto uK;
        }
        $Sp = $this->mo_oauth_client_get_option("\155\x6f\x5f\x6f\x61\165\x74\x68\x5f\x61\165\164\x68\x6f\x72\x69\x7a\141\164\x69\157\x6e\x73");
        uK:
        $user = $this->mo_oauth_hjsguh_kiishuyauh878gs($VS, $rp);
        if (!$user) {
            goto Gd;
        }
        ++$Sp;
        Gd:
        $this->mo_oauth_client_update_option("\x6d\x6f\137\x6f\141\165\x74\150\137\x61\165\x74\150\x6f\162\151\x7a\141\164\151\x6f\x6e\163", $Sp);
        if (!($Sp >= 10)) {
            goto N6;
        }
        $Nl = base64_decode("\x62\x57\71\x66\142\62\x46\x31\x64\107\x68\146\132\x6d\x78\x68\132\x77\75\x3d");
        $this->mo_oauth_client_update_option($Nl, true);
        N6:
        return $user;
    }
    public function mo_oauth_hjsguh_kiishuyauh878gs($xv, $ts)
    {
        $bt = wp_generate_password(10, false);
        $bI = is_email($xv) ? wp_create_user($xv, $bt, $xv) : wp_create_user($xv, $bt);
        $user = get_user_by("\154\x6f\147\x69\x6e", $xv);
        wp_update_user(array("\x49\104" => $bI, "\x66\x69\x72\x73\x74\x5f\x6e\141\x6d\145" => $ts));
        return $user;
    }
    public function check_versi($QB)
    {
        return $this->get_versi() >= $QB;
    }
    public function get_versi()
    {
        return VERSION === "\155\x6f\137\x65\156\x74\145\x72\160\162\x69\x73\x65\137\x76\x65\162\x73\x69\157\156" ? self::ENTERPRISE : (VERSION === "\x6d\157\137\x70\x72\x65\x6d\151\x75\x6d\x5f\166\145\162\x73\151\157\156" ? self::PREMIUM : (VERSION === "\155\157\x5f\163\164\141\156\x64\141\x72\x64\x5f\166\x65\x72\x73\151\x6f\156" ? self::STANDARD : self::FREE));
    }
    public function get_versi_str()
    {
        switch ($this->get_versi()) {
            case self::ENTERPRISE:
                return "\105\x4e\124\105\122\x50\x52\111\123\x45";
            case self::PREMIUM:
                return "\x50\x52\x45\115\x49\125\x4d";
            case self::STANDARD:
                return "\123\x54\101\116\104\x41\x52\x44";
            case self::FREE:
            default:
                return "\x46\x52\x45\105";
        }
        xy:
        ld:
    }
    public function mo_oauth_client_get_option($qV, $Rb = false)
    {
        return get_option($qV, $Rb);
    }
    public function mo_oauth_client_update_option($qV, $sw)
    {
        return update_option($qV, $sw);
    }
    public function mo_oauth_client_delete_option($qV)
    {
        return delete_option($qV);
    }
    public function array_overwrite($JP, $oV, $b5)
    {
        if ($b5) {
            goto pY;
        }
        array_push($JP, $oV);
        return array_unique($JP);
        pY:
        foreach ($oV as $qV => $sw) {
            $JP[$qV] = $sw;
            qo:
        }
        xh:
        return $JP;
    }
    public function gen_rand_str($Yy = 10)
    {
        $Ns = "\141\142\x63\x64\x65\146\x67\x68\151\152\153\x6c\x6d\156\157\160\161\162\x73\164\x75\x76\167\x78\171\172\x41\102\103\104\105\106\x47\110\111\x4a\113\x4c\115\x4e\117\x50\121\122\x53\x54\125\x56\127\130\131\132";
        $ff = strlen($Ns);
        $I4 = '';
        $MC = 0;
        HE:
        if (!($MC < $Yy)) {
            goto E4;
        }
        $I4 .= $Ns[rand(0, $ff - 1)];
        I2:
        $MC++;
        goto HE;
        E4:
        return $I4;
    }
    public function parse_url($a8)
    {
        $lL = array();
        $ec = explode("\x3f", $a8);
        $lL["\150\157\x73\x74"] = $ec[0];
        $lL["\x71\165\145\x72\171"] = isset($ec[1]) && '' !== $ec[1] ? $ec[1] : '';
        if (!(empty($lL["\x71\165\x65\x72\171"]) || '' === $lL["\x71\165\x65\x72\x79"])) {
            goto K5;
        }
        return $lL;
        K5:
        $rt = array();
        foreach (explode("\46", $lL["\x71\x75\x65\162\171"]) as $cg) {
            $ec = explode("\75", $cg);
            if (!(is_array($ec) && count($ec) === 2)) {
                goto Xo;
            }
            $rt[str_replace("\x61\x6d\x70\x3b", '', $ec[0])] = $ec[1];
            Xo:
            if (!(is_array($ec) && "\163\x74\141\x74\145" === $ec[0])) {
                goto ef;
            }
            $ec = explode("\163\x74\141\x74\x65\75", $cg);
            $rt["\x73\x74\141\x74\x65"] = $ec[1];
            ef:
            HS:
        }
        zK:
        $lL["\x71\165\x65\162\x79"] = is_array($rt) && !empty($rt) ? $rt : array();
        return $lL;
    }
    public function generate_url($tc)
    {
        if (!(!is_array($tc) || empty($tc))) {
            goto ns;
        }
        return '';
        ns:
        if (isset($tc["\x68\157\x73\x74"])) {
            goto uh;
        }
        return '';
        uh:
        $a8 = $tc["\150\x6f\x73\x74"];
        $C8 = '';
        $MC = 0;
        foreach ($tc["\x71\x75\145\162\x79"] as $mP => $sw) {
            if (!($MC !== 0)) {
                goto T8;
            }
            $C8 .= "\x26";
            T8:
            $C8 .= "{$mP}\x3d{$sw}";
            $MC += 1;
            St:
        }
        a4:
        return $a8 . "\x3f" . $C8;
    }
    public function getnestedattribute($Cq, $qV)
    {
        if (!empty($qV)) {
            goto Sa;
        }
        return '';
        Sa:
        $YI = explode("\56", $qV);
        if (count($YI) > 1) {
            goto Yg;
        }
        $jZ = $YI[0];
        if (!isset($Cq[$jZ])) {
            goto s1;
        }
        return $Cq[$jZ];
        s1:
        goto k8;
        Yg:
        $jZ = $YI[0];
        if (!isset($Cq[$jZ])) {
            goto Hs;
        }
        return $this->getnestedattribute($Cq[$jZ], str_replace($jZ . "\x2e", '', $qV));
        Hs:
        k8:
    }
    public function get_client_ip()
    {
        $Dl = '';
        if (getenv("\x48\124\x54\120\137\x43\114\x49\105\x4e\x54\x5f\x49\120")) {
            goto XY;
        }
        if (getenv("\x48\x54\124\120\137\x58\137\x46\117\x52\x57\101\122\x44\105\x44\x5f\106\x4f\122")) {
            goto ZI;
        }
        if (getenv("\x48\x54\124\x50\x5f\x58\x5f\106\x4f\x52\x57\x41\x52\x44\x45\104")) {
            goto Nl;
        }
        if (getenv("\x48\x54\x54\x50\137\106\x4f\122\127\101\x52\104\x45\x44\x5f\x46\x4f\122")) {
            goto bR;
        }
        if (getenv("\x48\x54\124\x50\x5f\x46\x4f\122\x57\101\x52\x44\x45\104")) {
            goto zB;
        }
        if (getenv("\x52\x45\115\x4f\124\x45\137\x41\x44\x44\x52")) {
            goto KB;
        }
        $Dl = "\x55\116\x4b\x4e\117\127\116";
        goto ht;
        XY:
        $Dl = getenv("\x48\x54\x54\120\x5f\x43\114\111\x45\x4e\x54\x5f\111\x50");
        goto ht;
        ZI:
        $Dl = getenv("\x48\124\124\x50\x5f\130\x5f\x46\117\x52\x57\x41\x52\x44\105\104\x5f\106\117\x52");
        goto ht;
        Nl:
        $Dl = getenv("\x48\124\x54\x50\x5f\x58\137\x46\117\122\127\101\122\x44\x45\104");
        goto ht;
        bR:
        $Dl = getenv("\x48\x54\124\x50\137\x46\117\122\x57\101\x52\104\105\x44\137\x46\x4f\122");
        goto ht;
        zB:
        $Dl = getenv("\x48\124\124\120\137\x46\x4f\122\127\x41\x52\x44\105\x44");
        goto ht;
        KB:
        $Dl = getenv("\122\x45\x4d\117\x54\x45\137\x41\x44\x44\122");
        ht:
        return $Dl;
    }
    public function get_current_url()
    {
        return (isset($_SERVER["\110\124\124\120\123"]) ? "\150\164\164\160\163" : "\x68\x74\x74\160") . "\x3a\57\x2f{$_SERVER["\x48\x54\x54\120\137\x48\x4f\123\124"]}{$_SERVER["\x52\x45\x51\x55\105\x53\x54\x5f\125\x52\x49"]}";
    }
    public function store_info($i4 = '', $sw = false)
    {
        if (!('' === $i4 || !$sw)) {
            goto tP;
        }
        return;
        tP:
        setcookie($i4, $sw);
    }
    public function redirect_user($a8 = false, $Hz = false)
    {
        if (!(false === $a8)) {
            goto Zo;
        }
        return;
        Zo:
        if (!$Hz) {
            goto Q1;
        }
        ?>
			<script>
				var myWindow = window.open("<?php 
        echo $a8;
        ?>
", "Test Configuration", "width=600, height=600");
				while(1) {
					if(myWindow.closed()) {
						$(document).trigger("config_tested");
						break;
					} else {continue;}
				}
			</script>
			<?php 
        Q1:
        ?>
		<script>
			window.location.replace("<?php 
        echo $a8;
        ?>
");
		</script>
		<?php 
        die;
    }
    public function is_ajax_request()
    {
        return defined("\104\117\x49\x4e\107\x5f\x41\112\101\x58") && DOING_AJAX;
    }
    public function deactivate_plugin()
    {
        $this->mo_oauth_client_delete_option("\150\157\x73\164\137\156\x61\155\x65");
        $this->mo_oauth_client_delete_option("\x6e\x65\x77\137\x72\x65\147\151\x73\164\x72\x61\164\x69\x6f\x6e");
        $this->mo_oauth_client_delete_option("\155\157\x5f\x6f\x61\165\164\150\137\141\x64\x6d\151\156\137\160\150\157\156\145");
        $this->mo_oauth_client_delete_option("\166\145\162\151\146\171\137\143\x75\x73\x74\x6f\155\x65\x72");
        $this->mo_oauth_client_delete_option("\155\157\x5f\x6f\141\165\164\150\137\141\144\155\151\156\137\143\165\163\x74\x6f\x6d\145\x72\137\x6b\145\x79");
        $this->mo_oauth_client_delete_option("\155\157\x5f\157\141\x75\164\x68\x5f\x61\144\x6d\x69\156\x5f\x61\160\x69\137\x6b\145\x79");
        $this->mo_oauth_client_delete_option("\155\157\137\157\141\165\x74\x68\137\156\x65\x77\137\x63\x75\163\x74\157\155\145\162");
        $this->mo_oauth_client_delete_option("\x63\x75\163\164\157\x6d\145\x72\x5f\164\157\x6b\x65\156");
        $this->mo_oauth_client_delete_option(\MoOAuthConstants::PANEL_MESSAGE_OPTION);
        $this->mo_oauth_client_delete_option("\x6d\x6f\x5f\x6f\x61\165\x74\x68\x5f\x72\x65\x67\x69\x73\164\162\x61\164\x69\x6f\156\137\163\164\x61\x74\x75\163");
        $this->mo_oauth_client_delete_option("\155\x6f\137\x6f\141\x75\x74\150\137\156\x65\x77\137\x63\x75\x73\x74\157\155\x65\x72");
        $this->mo_oauth_client_delete_option("\x6e\x65\167\137\x72\145\147\151\x73\164\162\x61\x74\x69\157\x6e");
        $this->mo_oauth_client_delete_option("\155\x6f\x5f\x6f\141\165\164\x68\137\x6c\157\147\151\156\137\x69\143\x6f\156\137\143\165\x73\x74\157\x6d\x5f\150\x65\x69\x67\x68\164");
        $this->mo_oauth_client_delete_option("\x6d\x6f\x5f\157\141\x75\x74\150\137\154\x6f\147\x69\156\137\151\143\x6f\x6e\137\x63\165\163\x74\x6f\155\137\x73\151\172\x65");
        $this->mo_oauth_client_delete_option("\155\x6f\137\157\x61\165\x74\x68\137\x6c\157\147\x69\156\137\x69\x63\157\156\137\143\165\163\x74\x6f\x6d\137\x63\x6f\154\157\162");
        $this->mo_oauth_client_delete_option("\155\157\x5f\157\141\165\x74\x68\x5f\154\x6f\x67\x69\156\137\x69\143\157\x6e\137\x63\165\x73\x74\157\155\x5f\142\x6f\x75\156\144\141\x72\171");
    }
    public function base64url_encode($p7)
    {
        return rtrim(strtr(base64_encode($p7), "\53\57", "\x2d\137"), "\75");
    }
    public function base64url_decode($p7)
    {
        return base64_decode(str_pad(strtr($p7, "\x2d\x5f", "\x2b\57"), strlen($p7) % 4, "\x3d", STR_PAD_RIGHT));
    }
    function export_plugin_config($oS = false)
    {
        $xs = array();
        $Ld = array();
        $GO = array();
        $xs = $this->get_plugin_config();
        $Ld = get_option("\x6d\157\x5f\x6f\x61\x75\164\150\137\141\x70\160\x73\137\154\x69\x73\164");
        if (empty($xs)) {
            goto nO;
        }
        $xs = $xs->get_current_config();
        nO:
        if (!is_array($Ld)) {
            goto mN;
        }
        foreach ($Ld as $iR => $mh) {
            $ag = $mh->get_app_config();
            if (!$oS) {
                goto RO;
            }
            unset($ag["\x63\x6c\151\x65\156\164\x5f\x69\144"]);
            unset($ag["\x63\x6c\x69\145\156\164\x5f\x73\145\143\x72\x65\164"]);
            RO:
            $GO[$iR] = $ag;
            W8:
        }
        dd:
        mN:
        $AM = array("\160\x6c\165\147\x69\x6e\x5f\x63\157\x6e\x66\x69\147" => $xs, "\141\160\160\137\x63\157\156\146\151\147\163" => $GO);
        return $AM;
    }
}
