<?php


namespace MoOauthClient;

use MoOauthClient\OauthHandlerInterface;
class OauthHandler implements OauthHandlerInterface
{
    public function get_token($FY, $w1, $jb = true, $vK = false)
    {
        global $xW;
        foreach ($w1 as $qV => $sw) {
            $w1[$qV] = html_entity_decode($sw);
            hP:
        }
        DX:
        $bk = array("\101\x63\x63\145\160\164" => "\141\x70\x70\154\x69\143\141\164\151\157\156\57\x6a\163\157\156", "\143\x68\141\162\x73\145\164" => "\125\x54\x46\40\55\40\70", "\103\157\156\164\145\x6e\x74\x2d\124\171\160\x65" => "\141\160\160\x6c\151\x63\141\164\151\157\x6e\57\x78\55\x77\167\x77\55\146\x6f\162\155\55\165\162\154\145\x6e\143\x6f\x64\x65\144", "\101\165\x74\150\x6f\162\x69\172\141\x74\151\157\x6e" => "\102\141\163\151\x63\x20" . base64_encode($w1["\143\154\151\x65\156\164\x5f\151\x64"] . "\72" . $w1["\143\x6c\151\145\156\x74\x5f\x73\x65\143\162\x65\x74"]));
        if (1 === $jb && 0 === $vK) {
            goto sT;
        }
        if (0 === $jb && 1 === $vK) {
            goto ru;
        }
        goto ac;
        sT:
        unset($w1["\x63\154\151\145\x6e\164\137\x69\144"]);
        unset($w1["\143\154\x69\x65\x6e\x74\x5f\163\145\143\x72\x65\164"]);
        goto ac;
        ru:
        unset($bk["\101\x75\x74\x68\x6f\162\151\x7a\141\x74\x69\157\156"]);
        ac:
        $sL = wp_remote_post($FY, array("\155\145\x74\150\157\144" => "\x50\117\123\124", "\x74\151\x6d\145\157\x75\164" => 45, "\162\145\x64\151\x72\x65\143\x74\151\157\156" => 5, "\150\x74\164\x70\x76\x65\x72\x73\151\157\156" => "\x31\56\x30", "\142\x6c\157\x63\153\151\x6e\147" => true, "\150\145\x61\x64\x65\162\x73" => $bk, "\x62\157\144\x79" => $w1, "\143\x6f\x6f\153\x69\145\x73" => array(), "\x73\163\154\x76\145\162\x69\x66\171" => false));
        if (!is_wp_error($sL)) {
            goto lf;
        }
        wp_die(wp_kses($sL->get_error_message(), \get_valid_html()));
        die;
        lf:
        $sL = $sL["\x62\157\144\x79"];
        if (is_array(json_decode($sL, true))) {
            goto w7;
        }
        echo "\x3c\x73\164\x72\157\156\147\76\x52\145\163\160\x6f\156\163\145\40\x3a\x20\x3c\x2f\x73\164\x72\157\156\x67\x3e\74\142\x72\x3e";
        print_r($sL);
        echo "\74\x62\162\x3e\74\142\x72\x3e";
        die("\x49\156\x76\141\x6c\151\x64\40\x72\x65\163\160\157\x6e\x73\145\x20\x72\145\x63\x65\151\166\145\144\56");
        w7:
        $PI = json_decode($sL, true);
        if (isset($PI["\x65\162\x72\x6f\162\137\144\145\x73\143\162\x69\160\x74\151\x6f\156"])) {
            goto kJ;
        }
        if (isset($PI["\145\162\162\x6f\162"])) {
            goto Cr;
        }
        goto nn;
        kJ:
        $this->handle_error(json_encode($PI["\x65\162\162\157\x72\x5f\144\145\x73\x63\162\x69\x70\x74\151\157\156"]), $w1);
        return;
        goto nn;
        Cr:
        $this->handle_error(json_encode($PI["\145\x72\x72\157\x72"]), $w1);
        return;
        nn:
        return $sL;
    }
    public function get_access_token($FY, $w1, $jb, $vK)
    {
        $sL = $this->get_token($FY, $w1, $jb, $vK);
        $PI = json_decode($sL, true);
        if (!("\160\141\x73\163\x77\157\x72\x64" === $w1["\x67\162\x61\156\164\137\164\x79\x70\145"])) {
            goto L_;
        }
        return $PI;
        L_:
        if (isset($PI["\141\x63\143\x65\x73\163\137\x74\x6f\153\145\156"])) {
            goto ma;
        }
        echo "\111\156\x76\x61\x6c\151\x64\40\x72\x65\163\x70\x6f\x6e\x73\x65\40\162\x65\143\x65\x69\x76\x65\144\40\146\162\x6f\155\40\117\x41\165\x74\150\x20\x50\162\x6f\x76\x69\x64\145\x72\56\x20\103\x6f\156\164\141\x63\x74\40\x79\x6f\x75\162\40\141\144\155\151\x6e\151\163\x74\x72\x61\x74\157\x72\x20\146\x6f\x72\40\155\157\162\145\x20\x64\x65\164\141\151\x6c\163\x2e\74\142\x72\76\x3c\142\162\x3e\x3c\163\164\162\x6f\156\147\76\122\x65\163\x70\157\x6e\163\x65\x20\x3a\x20\x3c\x2f\163\x74\x72\x6f\156\x67\x3e\74\142\162\x3e" . $sL;
        die;
        goto IG;
        ma:
        return $PI["\x61\x63\143\x65\x73\163\x5f\x74\x6f\x6b\145\x6e"];
        IG:
    }
    public function get_id_token($FY, $w1, $jb, $vK)
    {
        $sL = $this->get_token($FY, $w1, $jb, $vK);
        $PI = json_decode($sL, true);
        if (isset($PI["\151\144\137\164\157\x6b\x65\156"])) {
            goto li;
        }
        echo "\x49\x6e\166\141\154\151\144\x20\162\x65\x73\160\x6f\x6e\x73\x65\x20\x72\x65\x63\145\151\x76\x65\144\40\x66\x72\157\155\40\x4f\x70\x65\156\x49\x64\40\x50\162\x6f\166\x69\144\x65\162\x2e\40\x43\157\x6e\164\x61\143\x74\x20\171\x6f\x75\162\40\x61\144\x6d\x69\156\x69\163\164\x72\x61\x74\x6f\x72\40\x66\x6f\x72\x20\x6d\x6f\x72\x65\x20\144\145\164\x61\151\x6c\163\56\74\x62\162\x3e\74\x62\162\x3e\x3c\x73\x74\162\x6f\x6e\x67\76\x52\145\x73\160\x6f\156\163\x65\x20\72\x20\74\57\163\164\x72\x6f\156\147\x3e\74\142\162\x3e" . $sL;
        die;
        goto l3;
        li:
        return $PI;
        l3:
    }
    public function get_resource_owner_from_id_token($co)
    {
        $xr = explode("\x2e", $co);
        if (!isset($xr[1])) {
            goto n_;
        }
        $uS = base64_decode($xr[1]);
        if (!is_array(json_decode($uS, true))) {
            goto Kp;
        }
        return json_decode($uS, true);
        Kp:
        n_:
        echo "\x49\156\x76\141\x6c\151\144\40\x72\145\x73\x70\x6f\156\163\145\40\x72\x65\x63\145\x69\166\x65\144\x2e\74\x62\x72\x3e\74\x73\164\x72\157\156\147\76\151\x64\137\164\157\153\x65\156\40\72\x20\74\x2f\163\164\x72\157\x6e\x67\x3e" . $co;
        die;
    }
    public function get_resource_owner($oj, $d9)
    {
        global $xW;
        $bk = array();
        $bk["\101\x75\164\x68\157\162\151\172\141\x74\151\x6f\x6e"] = "\x42\145\141\x72\x65\x72\40" . $d9;
        if (!(strpos($oj, "\141\x63\x63\145\163\163\x5f\164\157\x6b\x65\x6e") !== false && strpos($oj, "\75") !== false)) {
            goto v3;
        }
        $oj .= $d9;
        v3:
        $sL = wp_remote_post($oj, array("\155\x65\x74\150\157\x64" => "\107\105\x54", "\x74\x69\155\145\x6f\x75\x74" => 45, "\x72\x65\x64\x69\x72\x65\x63\x74\x69\157\x6e" => 5, "\x68\164\164\160\166\145\162\163\x69\157\x6e" => "\x31\56\x30", "\x62\154\157\143\x6b\x69\156\x67" => true, "\x68\x65\141\x64\145\x72\163" => $bk, "\143\157\157\153\x69\x65\x73" => array(), "\163\163\x6c\166\x65\162\x69\146\171" => false));
        if (!is_wp_error($sL)) {
            goto wn;
        }
        wp_die(wp_kses($sL->get_error_message(), \get_valid_html()));
        die;
        wn:
        $sL = $sL["\142\x6f\144\x79"];
        if (is_array(json_decode($sL, true))) {
            goto tw;
        }
        echo "\74\x73\164\162\x6f\156\x67\76\122\x65\163\x70\157\156\163\145\x20\72\x20\74\x2f\x73\164\x72\157\x6e\x67\x3e\74\142\162\76";
        print_r($sL);
        echo "\x3c\142\162\76\x3c\142\162\x3e";
        die("\x49\156\x76\141\x6c\x69\144\x20\x72\145\163\x70\157\x6e\163\145\40\162\x65\x63\145\151\x76\x65\x64\x2e");
        tw:
        $PI = json_decode($sL, true);
        if (isset($PI["\x65\162\162\157\x72\x5f\144\145\163\x63\x72\151\x70\x74\151\157\156"])) {
            goto pW;
        }
        if (isset($PI["\x65\162\x72\157\162"])) {
            goto Xj;
        }
        goto Gx;
        pW:
        die(json_encode($PI["\x65\x72\x72\157\162\137\144\145\163\143\162\151\160\x74\x69\x6f\x6e"]));
        goto Gx;
        Xj:
        die(json_encode($PI["\x65\162\x72\157\x72"]));
        Gx:
        return $PI;
    }
    public function get_response($a8)
    {
        $sL = wp_remote_get($a8, array("\155\x65\x74\x68\x6f\144" => "\x47\105\x54", "\x74\x69\155\145\x6f\165\x74" => 45, "\x72\145\144\151\x72\x65\x63\164\x69\x6f\156" => 5, "\150\164\x74\x70\x76\x65\x72\x73\151\x6f\x6e" => 1.0, "\142\154\157\143\x6b\x69\156\x67" => true, "\x68\x65\141\x64\145\x72\163" => array(), "\143\157\x6f\x6b\151\x65\163" => array(), "\163\x73\x6c\x76\x65\162\151\x66\171" => false));
        if (!is_wp_error($sL)) {
            goto dc;
        }
        wp_die(wp_kses($sL->get_error_message(), \get_valid_html()));
        die;
        dc:
        $sL = $sL["\142\157\144\171"];
        $PI = json_decode($sL, true);
        if (isset($PI["\x65\162\x72\x6f\162\x5f\x64\x65\163\143\x72\x69\x70\x74\151\x6f\x6e"])) {
            goto hn;
        }
        if (isset($PI["\x65\162\x72\157\162"])) {
            goto Xx;
        }
        goto pe;
        hn:
        die($PI["\x65\162\x72\157\x72\x5f\x64\x65\163\x63\162\151\160\x74\151\x6f\x6e"]);
        goto pe;
        Xx:
        die($PI["\145\x72\162\x6f\x72"]);
        pe:
        return $PI;
    }
    private function handle_error($gn, $w1)
    {
        global $xW;
        if (!($w1["\x67\x72\x61\x6e\164\137\x74\171\x70\x65"] === "\160\141\163\163\167\157\162\x64")) {
            goto CU;
        }
        $EN = site_url();
        $EN = "\x3f\x6f\x70\164\x69\157\156\x3d\145\x72\162\x6f\x72\x6d\141\156\x61\x67\x65\162\46\145\162\162\157\x72\75" . \base64_encode($gn);
        $xW->redirect_user($EN);
        die;
        CU:
        die($gn);
    }
}
