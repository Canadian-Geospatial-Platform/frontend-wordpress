<?php


namespace MoOauthClient\Standard;

use MoOauthClient\LoginHandler as FreeLoginHandler;
use MoOauthClient\Config;
use MoOauthClient\StorageManager;
class LoginHandler extends FreeLoginHandler
{
    public $config;
    public function handle_group_test_conf($f8 = array(), $mh = array(), $d9 = '', $QI = false, $tE = false)
    {
        $this->render_test_config_output($f8, false);
        if (!(!isset($mh["\x67\162\157\x75\x70\x64\x65\164\x61\x69\x6c\163\165\162\154"]) || '' === $mh["\x67\x72\x6f\x75\x70\x64\x65\x74\x61\x69\154\x73\165\x72\154"])) {
            goto tqH;
        }
        return;
        tqH:
        $HW = array();
        $Gg = $mh["\147\162\157\165\x70\x64\x65\x74\x61\x69\154\163\165\162\x6c"];
        if (!('' === $d9)) {
            goto oVH;
        }
        return;
        oVH:
        if (!('' !== $Gg)) {
            goto ra7;
        }
        $HW = $this->oauth_handler->get_resource_owner($Gg, $d9);
        if (!($tE && '' !== $tE)) {
            goto w5E;
        }
        if (!(is_array($HW) && !empty($HW))) {
            goto q0B;
        }
        $this->render_test_config_output($HW, true);
        q0B:
        return;
        w5E:
        ra7:
    }
    public function handle_sso($gQ, $mh, $f8, $tZ, $qz, $ua = false)
    {
        global $xW;
        $eA = isset($mh["\165\163\x65\162\x6e\x61\155\x65\x5f\141\x74\164\x72"]) ? $mh["\165\x73\x65\x72\156\141\155\145\137\141\164\x74\x72"] : '';
        $NQ = isset($mh["\x65\x6d\x61\x69\154\137\x61\164\x74\x72"]) ? $mh["\x65\x6d\141\151\154\137\x61\164\x74\x72"] : '';
        $te = isset($mh["\x66\x69\162\x73\164\156\x61\155\145\137\x61\x74\164\x72"]) ? $mh["\x66\151\162\x73\x74\156\141\x6d\x65\x5f\141\x74\x74\162"] : '';
        $u4 = isset($mh["\154\141\x73\x74\x6e\x61\x6d\145\x5f\x61\x74\164\162"]) ? $mh["\154\x61\163\164\156\141\155\145\137\141\164\x74\x72"] : '';
        $xn = isset($mh["\144\x69\x73\160\154\141\171\137\141\x74\x74\162"]) ? $mh["\x64\151\163\160\x6c\x61\x79\137\x61\x74\x74\162"] : '';
        $ZD = $xW->getnestedattribute($f8, $eA);
        $xv = $xW->getnestedattribute($f8, $NQ);
        $eC = $xW->getnestedattribute($f8, $te);
        $lJ = $xW->getnestedattribute($f8, $u4);
        $d2 = $eC . "\x20" . $lJ;
        $this->config = $xW->mo_oauth_client_get_option("\155\157\x5f\x6f\141\x75\x74\x68\137\143\154\151\145\156\x74\137\x63\157\x6e\x66\151\147");
        $this->config = !$this->config || empty($this->config) ? array() : $this->config->get_current_config();
        $Sw = new StorageManager($tZ);
        if (!is_wp_error($Sw)) {
            goto qMj;
        }
        wp_die(wp_kses($Sw->get_error_message(), \get_valid_html()));
        qMj:
        do_action("\x6d\x6f\x5f\157\141\x75\x74\x68\x5f\147\145\x74\137\165\163\x65\162\x5f\x61\x74\x74\x72\x73", $f8);
        if (empty($xn)) {
            goto qG6;
        }
        switch ($xn) {
            case "\106\x4e\101\115\x45":
                $d2 = $eC;
                goto m71;
            case "\x4c\x4e\101\115\x45":
                $d2 = $lJ;
                goto m71;
            case "\x55\123\x45\x52\x4e\x41\x4d\105":
                $d2 = $ZD;
                goto m71;
            case "\114\x4e\x41\x4d\x45\x5f\106\x4e\x41\x4d\105":
                $d2 = $lJ . "\x20" . $eC;
            default:
                goto m71;
        }
        K6v:
        m71:
        qG6:
        if (!empty($ZD)) {
            goto r2I;
        }
        $this->check_status(array("\155\163\x67" => "\125\163\x65\162\156\141\x6d\x65\x20\156\157\x74\40\162\x65\143\x65\x69\x76\145\144\56\40\x43\150\x65\x63\153\x20\171\157\x75\162\40\x3c\x73\x74\x72\157\x6e\147\x3e\101\x74\164\162\x69\x62\x75\x74\145\40\115\141\160\x70\151\x6e\147\74\57\163\164\x72\157\x6e\x67\x3e\40\143\x6f\156\146\151\x67\x75\162\141\164\x69\x6f\156\x2e", "\143\x6f\x64\x65" => "\x55\116\x41\x4d\x45", "\163\x74\x61\164\x75\163" => false, "\x61\160\160\154\151\143\x61\x74\x69\157\x6e" => $gQ, "\145\155\x61\151\154" => '', "\165\x73\x65\x72\x6e\141\155\x65" => ''));
        r2I:
        if (!(!empty($xv) && false === strpos($xv, "\100"))) {
            goto M0w;
        }
        $this->check_status(array("\155\x73\147" => "\x4d\x61\160\160\145\144\x20\105\155\141\151\154\x20\x61\x74\164\162\151\x62\x75\x74\145\x20\144\157\x65\163\40\x6e\157\x74\x20\143\157\x6e\x74\x61\x69\156\x20\x76\x61\x6c\x69\x64\x20\145\155\x61\151\154\x2e", "\143\157\144\x65" => "\105\x4d\x41\111\114", "\163\164\141\x74\165\x73" => false, "\141\160\160\x6c\151\x63\141\x74\x69\x6f\x6e" => $gQ, "\143\154\x69\x65\156\x74\137\x69\x70" => $xW->get_client_ip(), "\145\155\141\151\x6c" => $xv, "\165\163\145\x72\156\141\155\145" => $ZD));
        M0w:
        do_action("\155\157\x5f\157\x61\165\164\x68\137\x72\x65\x73\164\x72\x69\143\164\x5f\x65\x6d\x61\151\x6c\163", $xv, $this->config);
        $user = get_user_by("\x6c\x6f\x67\151\x6e", $ZD);
        if ($user) {
            goto ROM;
        }
        $user = get_user_by("\x65\155\141\x69\x6c", $xv);
        ROM:
        $bI = $user ? $user->ID : 0;
        $qN = 0 === $bI;
        if (!(!(isset($this->config["\x61\165\x74\157\x5f\x72\145\x67\151\163\x74\x65\x72"]) && 1 === intval($this->config["\141\x75\x74\157\137\x72\145\x67\x69\x73\164\145\x72"])) && $qN)) {
            goto Thp;
        }
        $this->check_status(array("\x6d\x73\x67" => "\122\x65\x67\x69\x73\164\x72\x61\164\x69\x6f\x6e\x20\x69\163\40\144\151\163\141\142\x6c\x65\144\40\x66\x6f\162\x20\164\150\151\163\x20\163\x69\164\x65\56\40\x50\x6c\145\x61\x73\x65\x20\143\x6f\156\164\141\143\164\40\171\157\x75\162\40\141\x64\x6d\151\x6e\x69\x73\164\x72\141\x74\x6f\162", "\x63\x6f\144\x65" => "\x52\105\107\111\x53\x54\x52\101\124\111\x4f\116\137\x44\x49\x53\x41\102\x4c\105\104", "\163\x74\141\164\x75\x73" => false, "\x61\x70\160\154\x69\x63\141\x74\151\x6f\156" => $gQ, "\143\154\x69\145\156\x74\137\151\160" => $xW->get_client_ip(), "\x65\155\141\151\154" => $xv, "\165\x73\145\162\x6e\x61\x6d\145" => $ZD));
        Thp:
        if (!$qN) {
            goto BYd;
        }
        $bt = wp_generate_password(10, false);
        $bI = wp_create_user($ZD, $bt, $xv);
        BYd:
        if (!($qN || (!isset($this->config["\153\x65\x65\160\x5f\x65\x78\x69\x73\x74\151\156\147\x5f\165\163\x65\x72\163"]) || 1 !== intval($this->config["\x6b\x65\145\x70\137\145\x78\x69\x73\164\151\156\147\x5f\x75\x73\x65\162\163"])))) {
            goto HDn;
        }
        if (!is_wp_error($bI)) {
            goto kpb;
        }
        $bI = get_user_by("\x6c\x6f\x67\151\156", $ZD)->ID;
        kpb:
        wp_update_user(array("\x49\x44" => $bI, "\x66\151\162\163\x74\137\x6e\x61\155\x65" => $eC, "\154\x61\x73\x74\x5f\x6e\x61\x6d\145" => $lJ, "\144\x69\163\160\154\x61\x79\x5f\x6e\141\x6d\x65" => $d2, "\x75\163\x65\x72\137\x6c\157\147\151\156" => $ZD, "\165\163\145\x72\x5f\x65\x6d\x61\x69\x6c" => $xv, "\165\163\145\x72\x5f\x6e\x69\143\x65\156\141\155\145" => $ZD));
        update_user_meta($bI, "\155\x6f\x5f\x6f\141\165\164\150\x5f\x62\x75\x64\144\171\x70\x72\145\163\163\x5f\x61\x74\x74\162\151\x62\x75\x74\145\x73", $f8);
        HDn:
        $user = get_user_by("\111\x44", $bI);
        if ($user) {
            goto Ukc;
        }
        return;
        Ukc:
        $wY = '';
        if (isset($this->config["\141\146\164\x65\162\x5f\x6c\x6f\147\x69\x6e\137\165\x72\x6c"]) && '' !== $this->config["\141\146\x74\x65\162\137\x6c\157\147\x69\156\x5f\x75\x72\x6c"]) {
            goto SUV;
        }
        $ah = $Sw->get_value("\x72\x65\x64\151\162\145\x63\x74\x5f\165\x72\x69");
        $wY = rawurldecode($ah && '' !== $ah ? $ah : site_url());
        goto BZ2;
        SUV:
        $wY = $this->config["\x61\146\x74\x65\x72\137\x6c\157\x67\151\x6e\137\x75\162\x6c"];
        BZ2:
        do_action("\155\x6f\x5f\157\x61\165\x74\150\137\x63\154\x69\x65\156\x74\137\155\141\160\137\162\x6f\x6c\x65\x73", array("\x75\x73\145\162\x5f\x69\144" => $bI, "\141\160\x70\x5f\x63\x6f\156\x66\x69\x67" => $mh, "\156\x65\167\x5f\165\163\x65\x72" => $qN, "\x72\x65\x73\x6f\165\162\143\x65\x5f\x6f\167\156\145\162" => $f8));
        do_action("\x6d\x6f\x5f\157\x61\165\164\150\137\x6c\157\x67\x67\145\x64\137\x69\156\x5f\165\163\x65\162\137\164\x6f\153\145\x6e", $user, $qz);
        $this->check_status(array("\x6d\x73\x67" => "\114\x6f\147\x69\x6e\x20\x53\x75\x63\143\145\163\163\x66\x75\154\x21", "\x63\x6f\x64\x65" => "\x4c\117\x47\x49\x4e\x5f\123\x55\103\x43\105\123\x53", "\163\164\x61\x74\x75\x73" => true, "\x61\x70\x70\154\151\143\x61\x74\x69\x6f\x6e" => $gQ, "\143\x6c\x69\145\x6e\164\137\x69\160" => $xW->get_client_ip(), "\x6e\141\166\151\x67\x61\x74\x69\157\x6e\165\x72\154" => $wY, "\145\155\141\151\154" => $xv, "\165\x73\x65\x72\156\141\155\x65" => $ZD));
        if (!$ua) {
            goto DGN;
        }
        return $user;
        DGN:
        update_user_meta($user->ID, "\155\x6f\137\157\141\165\x74\150\x5f\x63\154\x69\145\x6e\164\137\x6c\x61\x73\x74\137\151\144\x5f\164\157\153\x65\156", isset($qz["\x69\x64\137\164\x6f\x6b\x65\156"]) ? $qz["\151\144\x5f\164\x6f\x6b\145\156"] : false);
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID);
        do_action("\167\160\137\x6c\x6f\147\x69\x6e", $user->user_login, $user);
        $I0 = $Sw->get_value("\x72\x65\x73\x74\162\151\x63\164\x72\x65\144\x69\x72\x65\x63\164") !== false;
        $Nq = $Sw->get_value("\160\x6f\x70\165\160") === "\151\147\x6e\x6f\162\145";
        if (isset($this->config["\160\157\x70\x75\x70\x5f\154\157\x67\151\156"]) && 1 === intval($this->config["\160\157\160\165\160\x5f\154\x6f\x67\x69\156"]) && !$Nq && !boolval($I0)) {
            goto YfS;
        }
        wp_redirect($wY);
        goto IPS;
        YfS:
        echo "\x3c\163\x63\162\151\x70\164\76\167\x69\x6e\144\157\167\x2e\157\160\145\x6e\x65\x72\x2e\x48\141\156\x64\154\145\x50\x6f\x70\165\160\122\145\x73\165\x6c\164\x28\42" . $wY . "\42\x29\x3b\x77\x69\x6e\x64\x6f\x77\56\x63\x6c\157\x73\x65\x28\51\x3b\74\x2f\163\143\x72\151\x70\x74\76";
        IPS:
        die;
    }
    public function check_status($w1)
    {
        if (isset($w1["\x73\164\x61\164\x75\163"])) {
            goto Jha;
        }
        wp_die(wp_kses("\123\x6f\x6d\145\x74\x68\x69\156\x67\x20\167\x65\156\x74\x20\167\162\x6f\x6e\x67\x2e\40\120\x6c\145\x61\163\x65\40\x74\x72\x79\40\x4c\x6f\147\147\x69\x6e\147\x20\x69\156\x20\141\x67\x61\151\x6e\x2e", \get_valid_html()));
        Jha:
        if (!(isset($w1["\x73\164\141\164\x75\x73"]) && true === $w1["\163\x74\x61\x74\165\x73"] && (isset($w1["\x63\x6f\144\x65"]) && "\114\x4f\107\x49\x4e\137\123\125\103\103\105\x53\x53" === $w1["\x63\x6f\144\x65"]))) {
            goto fog;
        }
        return true;
        fog:
        if (!(true !== $w1["\x73\164\x61\x74\x75\163"])) {
            goto gDq;
        }
        $gj = isset($w1["\x6d\x73\147"]) && !empty($w1["\x6d\x73\147"]) ? $w1["\x6d\x73\147"] : "\x53\157\155\x65\164\150\x69\x6e\x67\40\x77\x65\x6e\x74\40\167\x72\157\156\147\x2e\x20\120\154\145\x61\x73\145\x20\x74\162\x79\x20\x4c\157\147\147\151\156\147\x20\x69\156\40\x61\x67\141\151\x6e\x2e";
        wp_die(wp_kses($gj, \get_valid_html()));
        die;
        gDq:
    }
}
