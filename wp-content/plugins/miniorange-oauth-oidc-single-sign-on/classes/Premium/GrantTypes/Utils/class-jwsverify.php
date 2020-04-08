<?php


namespace MoOauthClient\GrantTypes;

class JWSVerify
{
    public $algo;
    public function __construct($JX = '')
    {
        if (!empty($JX)) {
            goto BQJ;
        }
        return;
        BQJ:
        $JX = explode("\123", $JX);
        if (!(!is_array($JX) || 2 !== count($JX))) {
            goto Bss;
        }
        return WP_Error("\151\156\x76\x61\154\151\x64\137\163\151\x67\156\141\x74\165\x72\x65", __("\x54\x68\x65\40\x53\x69\147\x6e\141\x74\x75\x72\x65\x20\x73\145\x65\x6d\163\x20\x74\x6f\40\x62\145\40\151\x6e\x76\x61\x6c\151\x64\x20\x6f\162\40\165\x6e\x73\165\160\160\157\x72\x74\x65\x64\x2e"));
        Bss:
        if ("\110" === $JX[0]) {
            goto Gy2;
        }
        if ("\122" === $JX[0]) {
            goto xEb;
        }
        return WP_Error("\x69\156\x76\141\x6c\x69\144\x5f\163\151\x67\156\x61\x74\165\162\x65", __("\124\150\x65\x20\x73\x69\147\x6e\141\164\x75\162\145\40\x61\154\x67\x6f\x72\151\x74\150\x6d\x20\163\145\145\x6d\163\40\164\157\40\142\x65\x20\x75\x6e\x73\x75\160\x70\x6f\162\164\x65\x64\x20\x6f\x72\40\151\156\166\x61\154\151\144\56"));
        goto lEu;
        Gy2:
        $this->algo["\x61\154\x67"] = "\110\x53\x41";
        goto lEu;
        xEb:
        $this->algo["\x61\154\147"] = "\122\x53\101";
        lEu:
        $this->algo["\x73\150\141"] = $JX[1];
    }
    private function validate_hmac($u8 = '', $rw = '', $Kz = '')
    {
        if (!(empty($u8) || empty($Kz))) {
            goto AvO;
        }
        return false;
        AvO:
        $C0 = $this->algo["\x73\x68\x61"];
        $C0 = "\x73\x68\141" . $C0;
        $jC = \hash_hmac($C0, $u8, $rw, true);
        return hash_equals($jC, $Kz);
    }
    private function validate_rsa($u8 = '', $cy = '', $Kz = '')
    {
        if (!(empty($u8) || empty($Kz))) {
            goto Mm4;
        }
        return false;
        Mm4:
        $C0 = $this->algo["\x73\150\141"];
        $wT = '';
        $ec = explode("\55\x2d\x2d\55\x2d", $cy);
        if (preg_match("\57\134\162\x5c\156\174\x5c\162\174\x5c\156\x2f", $ec[2])) {
            goto ABd;
        }
        $tv = "\55\x2d\x2d\x2d\x2d" . $ec[1] . "\55\55\x2d\55\x2d\xa";
        $jo = 0;
        py4:
        if (!($P1 = substr($ec[2], $jo, 64))) {
            goto Q4G;
        }
        $tv .= $P1 . "\xa";
        $jo += 64;
        goto py4;
        Q4G:
        $tv .= "\x2d\55\x2d\x2d\55" . $ec[3] . "\x2d\x2d\55\55\55\xa";
        $wT = $tv;
        goto p2U;
        ABd:
        $wT = $cy;
        p2U:
        $z_ = false;
        switch ($C0) {
            case "\62\x35\x36":
                $z_ = openssl_verify($u8, $Kz, $wT, OPENSSL_ALGO_SHA256);
                goto Kqm;
            case "\x33\x38\x34":
                $z_ = openssl_verify($u8, $Kz, $wT, OPENSSL_ALGO_SHA384);
                goto Kqm;
            case "\x35\61\62":
                $z_ = openssl_verify($u8, $Kz, $wT, OPENSSL_ALGO_SHA512);
                goto Kqm;
            default:
                $z_ = false;
                goto Kqm;
        }
        lY0:
        Kqm:
        return $z_;
    }
    public function verify($u8 = '', $rw = '', $Kz = '')
    {
        if (!(empty($u8) || empty($Kz))) {
            goto tjS;
        }
        return false;
        tjS:
        $JX = $this->algo["\141\x6c\x67"];
        switch ($JX) {
            case "\x48\123\101":
                return $this->validate_hmac($u8, $rw, $Kz);
            case "\x52\x53\x41":
                return @$this->validate_rsa($u8, $rw, $Kz);
            default:
                return false;
        }
        EVF:
        Hxh:
    }
}
