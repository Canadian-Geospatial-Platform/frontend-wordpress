<?php


namespace MoOauthClient\GrantTypes;

define("\x4d\x41\124\110\x5f\x42\x49\107\111\x4e\124\x45\107\105\122\137\x4d\117\116\x54\x47\117\115\x45\x52\131", 0);
define("\115\101\124\x48\x5f\102\x49\107\x49\116\124\x45\x47\105\x52\137\102\101\122\x52\x45\124\124", 1);
define("\x4d\x41\x54\110\137\x42\x49\x47\x49\x4e\124\105\x47\x45\x52\x5f\x50\x4f\x57\x45\122\x4f\106\62", 2);
define("\115\x41\x54\110\x5f\x42\x49\x47\111\116\124\x45\x47\x45\122\137\x43\x4c\101\123\123\111\x43", 3);
define("\x4d\101\124\x48\137\102\111\107\x49\x4e\124\105\107\105\122\x5f\x4e\x4f\x4e\x45", 4);
define("\115\101\x54\x48\x5f\102\x49\x47\x49\116\124\105\x47\x45\122\137\x56\x41\114\125\x45", 0);
define("\115\101\x54\x48\137\102\111\x47\111\116\x54\x45\x47\x45\x52\137\x53\111\107\116", 1);
define("\x4d\x41\x54\x48\137\x42\111\x47\111\116\124\x45\x47\x45\122\x5f\126\x41\x52\x49\101\102\x4c\x45", 0);
define("\x4d\x41\x54\110\137\102\111\x47\111\x4e\124\105\x47\x45\x52\137\104\x41\124\101", 1);
define("\115\x41\x54\110\x5f\x42\111\107\x49\116\124\x45\x47\x45\122\x5f\115\x4f\x44\x45\x5f\111\x4e\x54\105\122\116\x41\114", 1);
define("\115\x41\x54\x48\137\x42\111\x47\x49\x4e\124\x45\107\x45\122\x5f\115\117\104\105\x5f\102\103\115\101\x54\x48", 2);
define("\x4d\101\x54\x48\x5f\x42\x49\107\x49\116\x54\x45\x47\105\122\x5f\x4d\117\x44\105\137\107\115\x50", 3);
define("\115\x41\x54\110\x5f\x42\111\x47\111\116\124\x45\107\x45\x52\137\113\x41\122\x41\124\x53\125\x42\101\x5f\x43\x55\x54\x4f\x46\x46", 25);
class Math_BigInteger
{
    var $value;
    var $is_negative = false;
    var $precision = -1;
    var $bitmask = false;
    var $hex;
    function __construct($hs = 0, $kY = 10)
    {
        if (defined("\115\101\124\x48\137\x42\x49\107\111\x4e\x54\105\x47\x45\x52\137\x4d\x4f\104\x45")) {
            goto rv;
        }
        switch (true) {
            case extension_loaded("\147\155\x70"):
                define("\x4d\101\x54\110\x5f\102\111\107\111\116\124\x45\x47\105\122\137\x4d\117\x44\105", MATH_BIGINTEGER_MODE_GMP);
                goto nk;
            case extension_loaded("\142\x63\155\x61\164\150"):
                define("\115\101\124\110\137\102\111\107\111\x4e\x54\x45\107\x45\x52\137\x4d\117\104\105", MATH_BIGINTEGER_MODE_BCMATH);
                goto nk;
            default:
                define("\115\x41\x54\x48\137\x42\111\107\111\116\x54\105\x47\105\122\x5f\115\117\104\x45", MATH_BIGINTEGER_MODE_INTERNAL);
        }
        AZ:
        nk:
        rv:
        if (!(extension_loaded("\x6f\x70\x65\x6e\x73\163\154") && !defined("\115\x41\124\x48\137\102\111\107\111\116\124\105\107\x45\122\x5f\117\x50\x45\116\123\123\x4c\x5f\x44\x49\x53\x41\102\x4c\105") && !defined("\115\101\124\x48\x5f\x42\x49\107\x49\x4e\124\105\x47\x45\x52\x5f\x4f\120\x45\116\123\123\114\x5f\105\116\x41\102\x4c\105\x44"))) {
            goto Qh;
        }
        ob_start();
        @phpinfo();
        $PI = ob_get_contents();
        ob_end_clean();
        preg_match_all("\43\x4f\160\x65\156\123\123\x4c\x20\x28\x48\145\141\144\x65\162\x7c\114\151\x62\x72\141\162\x79\x29\40\x56\x65\x72\163\x69\157\156\x28\56\52\51\43\151\155", $PI, $W4);
        $ZU = array();
        if (empty($W4[1])) {
            goto n4;
        }
        $MC = 0;
        s6:
        if (!($MC < count($W4[1]))) {
            goto Kr;
        }
        $MS = trim(str_replace("\x3d\x3e", '', strip_tags($W4[2][$MC])));
        if (!preg_match("\x2f\x28\x5c\x64\53\134\56\134\x64\53\x5c\x2e\134\144\x2b\51\57\151", $MS, $pf)) {
            goto jP;
        }
        $ZU[$W4[1][$MC]] = $pf[0];
        goto OO;
        jP:
        $ZU[$W4[1][$MC]] = $MS;
        OO:
        tU:
        $MC++;
        goto s6;
        Kr:
        n4:
        switch (true) {
            case !isset($ZU["\110\145\x61\144\x65\x72"]):
            case !isset($ZU["\x4c\x69\142\162\x61\162\x79"]):
            case $ZU["\110\145\141\x64\145\162"] == $ZU["\114\x69\142\162\141\162\171"]:
            case version_compare($ZU["\110\x65\141\144\x65\162"], "\61\56\x30\x2e\60") >= 0 && version_compare($ZU["\x4c\151\142\x72\x61\162\x79"], "\x31\x2e\60\x2e\x30") >= 0:
                define("\x4d\x41\124\110\137\102\111\107\x49\116\x54\x45\107\x45\122\x5f\x4f\x50\x45\x4e\123\x53\114\137\x45\x4e\x41\102\114\x45\104", true);
                goto Sv;
            default:
                define("\115\x41\124\x48\137\x42\x49\x47\x49\116\x54\x45\x47\105\122\x5f\x4f\120\105\x4e\x53\123\114\137\x44\x49\123\x41\102\114\105", true);
        }
        qE:
        Sv:
        Qh:
        if (defined("\120\110\x50\137\111\x4e\124\x5f\123\111\132\x45")) {
            goto N0;
        }
        define("\120\x48\x50\x5f\111\116\x54\x5f\x53\x49\x5a\x45", 4);
        N0:
        if (!(!defined("\x4d\101\x54\110\x5f\102\111\x47\111\x4e\x54\105\x47\105\x52\x5f\x42\x41\123\x45") && MATH_BIGINTEGER_MODE == MATH_BIGINTEGER_MODE_INTERNAL)) {
            goto Nc;
        }
        switch (PHP_INT_SIZE) {
            case 8:
                define("\x4d\101\124\110\x5f\x42\111\x47\111\116\124\105\x47\105\x52\137\x42\x41\x53\x45", 31);
                define("\115\x41\x54\x48\137\102\x49\107\x49\x4e\x54\x45\107\105\x52\137\102\x41\x53\105\x5f\x46\x55\114\x4c", 2147483648);
                define("\115\101\124\x48\137\x42\111\107\x49\116\124\105\107\x45\122\137\x4d\x41\130\x5f\104\111\x47\x49\x54", 2147483647);
                define("\115\101\124\x48\x5f\102\111\107\x49\x4e\x54\105\x47\x45\122\137\x4d\123\x42", 1073741824);
                define("\115\101\124\x48\137\102\x49\x47\x49\116\124\105\107\x45\x52\137\x4d\101\130\61\60", 1000000000);
                define("\115\101\x54\110\x5f\x42\111\x47\x49\116\x54\x45\107\105\x52\137\115\101\x58\61\60\x5f\114\105\116", 9);
                define("\115\101\x54\x48\x5f\102\x49\x47\x49\x4e\x54\105\x47\x45\x52\137\115\101\130\137\x44\111\x47\x49\124\62", pow(2, 62));
                goto nQ;
            default:
                define("\x4d\x41\x54\x48\x5f\102\111\107\111\116\x54\105\x47\x45\x52\x5f\x42\101\123\x45", 26);
                define("\x4d\x41\x54\x48\137\102\x49\107\111\116\x54\105\x47\x45\x52\x5f\102\x41\x53\105\137\x46\125\114\114", 67108864);
                define("\115\101\x54\x48\137\x42\x49\107\111\x4e\124\x45\107\x45\122\x5f\115\x41\x58\x5f\104\111\x47\x49\124", 67108863);
                define("\115\101\x54\x48\x5f\102\x49\107\111\x4e\x54\105\x47\105\x52\x5f\115\x53\x42", 33554432);
                define("\115\101\x54\110\137\x42\111\x47\x49\x4e\124\105\x47\105\x52\137\x4d\101\130\x31\60", 10000000);
                define("\x4d\101\124\x48\137\102\111\x47\x49\116\x54\105\107\x45\x52\x5f\x4d\101\130\61\60\x5f\x4c\105\x4e", 7);
                define("\115\101\124\110\137\102\111\107\111\116\124\x45\107\x45\122\x5f\x4d\101\130\137\104\x49\x47\x49\x54\x32", pow(2, 52));
        }
        xF:
        nQ:
        Nc:
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                switch (true) {
                    case is_resource($hs) && get_resource_type($hs) == "\x47\x4d\x50\40\151\x6e\164\145\147\x65\x72":
                    case is_object($hs) && get_class($hs) == "\x47\115\x50":
                        $this->value = $hs;
                        return;
                }
                L2:
                OV:
                $this->value = gmp_init(0);
                goto hw;
            case MATH_BIGINTEGER_MODE_BCMATH:
                $this->value = "\x30";
                goto hw;
            default:
                $this->value = array();
        }
        jm:
        hw:
        if (!(empty($hs) && (abs($kY) != 256 || $hs !== "\60"))) {
            goto t8;
        }
        return;
        t8:
        switch ($kY) {
            case -256:
                if (!(ord($hs[0]) & 128)) {
                    goto KV;
                }
                $hs = ~$hs;
                $this->is_negative = true;
                KV:
            case 256:
                switch (MATH_BIGINTEGER_MODE) {
                    case MATH_BIGINTEGER_MODE_GMP:
                        $this->value = function_exists("\x67\155\x70\137\x69\155\x70\x6f\162\x74") ? gmp_import($hs) : gmp_init("\60\x78" . bin2hex($hs));
                        if (!$this->is_negative) {
                            goto IF1;
                        }
                        $this->value = gmp_neg($this->value);
                        IF1:
                        goto wp;
                    case MATH_BIGINTEGER_MODE_BCMATH:
                        $r0 = strlen($hs) + 3 & 4294967292;
                        $hs = str_pad($hs, $r0, chr(0), STR_PAD_LEFT);
                        $MC = 0;
                        v0:
                        if (!($MC < $r0)) {
                            goto jM;
                        }
                        $this->value = bcmul($this->value, "\x34\x32\71\64\x39\66\x37\62\71\66", 0);
                        $this->value = bcadd($this->value, 16777216 * ord($hs[$MC]) + (ord($hs[$MC + 1]) << 16 | ord($hs[$MC + 2]) << 8 | ord($hs[$MC + 3])), 0);
                        QB:
                        $MC += 4;
                        goto v0;
                        jM:
                        if (!$this->is_negative) {
                            goto Q6;
                        }
                        $this->value = "\x2d" . $this->value;
                        Q6:
                        goto wp;
                    default:
                        Q0:
                        if (!strlen($hs)) {
                            goto uz;
                        }
                        $this->value[] = $this->_bytes2int($this->_base256_rshift($hs, MATH_BIGINTEGER_BASE));
                        goto Q0;
                        uz:
                }
                zQ:
                wp:
                if (!$this->is_negative) {
                    goto dQ;
                }
                if (!(MATH_BIGINTEGER_MODE != MATH_BIGINTEGER_MODE_INTERNAL)) {
                    goto UT;
                }
                $this->is_negative = false;
                UT:
                $rd = $this->add(new Math_BigInteger("\x2d\61"));
                $this->value = $rd->value;
                dQ:
                goto M3;
            case 16:
            case -16:
                if (!($kY > 0 && $hs[0] == "\55")) {
                    goto js;
                }
                $this->is_negative = true;
                $hs = substr($hs, 1);
                js:
                $hs = preg_replace("\x23\x5e\x28\x3f\x3a\60\170\x29\x3f\x28\x5b\101\55\106\141\x2d\146\x30\x2d\x39\135\52\51\x2e\52\43", "\44\61", $hs);
                $k3 = false;
                if (!($kY < 0 && hexdec($hs[0]) >= 8)) {
                    goto U_;
                }
                $this->is_negative = $k3 = true;
                $hs = bin2hex(~pack("\110\x2a", $hs));
                U_:
                switch (MATH_BIGINTEGER_MODE) {
                    case MATH_BIGINTEGER_MODE_GMP:
                        $rd = $this->is_negative ? "\x2d\x30\x78" . $hs : "\x30\x78" . $hs;
                        $this->value = gmp_init($rd);
                        $this->is_negative = false;
                        goto tI;
                    case MATH_BIGINTEGER_MODE_BCMATH:
                        $hs = strlen($hs) & 1 ? "\60" . $hs : $hs;
                        $rd = new Math_BigInteger(pack("\x48\52", $hs), 256);
                        $this->value = $this->is_negative ? "\x2d" . $rd->value : $rd->value;
                        $this->is_negative = false;
                        goto tI;
                    default:
                        $hs = strlen($hs) & 1 ? "\x30" . $hs : $hs;
                        $rd = new Math_BigInteger(pack("\x48\52", $hs), 256);
                        $this->value = $rd->value;
                }
                n0:
                tI:
                if (!$k3) {
                    goto rk;
                }
                $rd = $this->add(new Math_BigInteger("\x2d\x31"));
                $this->value = $rd->value;
                rk:
                goto M3;
            case 10:
            case -10:
                $hs = preg_replace("\43\50\x3f\x3c\41\x5e\51\50\77\x3a\x2d\x29\x2e\x2a\x7c\x28\x3f\x3c\75\x5e\x7c\55\51\x30\x2a\x7c\x5b\136\x2d\x30\55\x39\x5d\x2e\52\43", '', $hs);
                switch (MATH_BIGINTEGER_MODE) {
                    case MATH_BIGINTEGER_MODE_GMP:
                        $this->value = gmp_init($hs);
                        goto Kg;
                    case MATH_BIGINTEGER_MODE_BCMATH:
                        $this->value = $hs === "\x2d" ? "\60" : (string) $hs;
                        goto Kg;
                    default:
                        $rd = new Math_BigInteger();
                        $Lq = new Math_BigInteger();
                        $Lq->value = array(MATH_BIGINTEGER_MAX10);
                        if (!($hs[0] == "\55")) {
                            goto GP;
                        }
                        $this->is_negative = true;
                        $hs = substr($hs, 1);
                        GP:
                        $hs = str_pad($hs, strlen($hs) + (MATH_BIGINTEGER_MAX10_LEN - 1) * strlen($hs) % MATH_BIGINTEGER_MAX10_LEN, 0, STR_PAD_LEFT);
                        ZF:
                        if (!strlen($hs)) {
                            goto Bh;
                        }
                        $rd = $rd->multiply($Lq);
                        $rd = $rd->add(new Math_BigInteger($this->_int2bytes(substr($hs, 0, MATH_BIGINTEGER_MAX10_LEN)), 256));
                        $hs = substr($hs, MATH_BIGINTEGER_MAX10_LEN);
                        goto ZF;
                        Bh:
                        $this->value = $rd->value;
                }
                F6:
                Kg:
                goto M3;
            case 2:
            case -2:
                if (!($kY > 0 && $hs[0] == "\55")) {
                    goto Hv;
                }
                $this->is_negative = true;
                $hs = substr($hs, 1);
                Hv:
                $hs = preg_replace("\43\136\50\x5b\x30\x31\135\52\x29\x2e\x2a\43", "\44\61", $hs);
                $hs = str_pad($hs, strlen($hs) + 3 * strlen($hs) % 4, 0, STR_PAD_LEFT);
                $qM = "\x30\170";
                YJ:
                if (!strlen($hs)) {
                    goto kS;
                }
                $Yz = substr($hs, 0, 4);
                $qM .= dechex(bindec($Yz));
                $hs = substr($hs, 4);
                goto YJ;
                kS:
                if (!$this->is_negative) {
                    goto IE;
                }
                $qM = "\x2d" . $qM;
                IE:
                $rd = new Math_BigInteger($qM, 8 * $kY);
                $this->value = $rd->value;
                $this->is_negative = $rd->is_negative;
                goto M3;
            default:
        }
        VU:
        M3:
    }
    function Math_BigInteger($hs = 0, $kY = 10)
    {
        $this->__construct($hs, $kY);
    }
    function toBytes($rH = false)
    {
        if (!$rH) {
            goto zI;
        }
        $Z3 = $this->compare(new Math_BigInteger());
        if (!($Z3 == 0)) {
            goto aU;
        }
        return $this->precision > 0 ? str_repeat(chr(0), $this->precision + 1 >> 3) : '';
        aU:
        $rd = $Z3 < 0 ? $this->add(new Math_BigInteger(1)) : $this->copy();
        $Wp = $rd->toBytes();
        if (!empty($Wp)) {
            goto Iw;
        }
        $Wp = chr(0);
        Iw:
        if (!(ord($Wp[0]) & 128)) {
            goto BQ;
        }
        $Wp = chr(0) . $Wp;
        BQ:
        return $Z3 < 0 ? ~$Wp : $Wp;
        zI:
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                if (!(gmp_cmp($this->value, gmp_init(0)) == 0)) {
                    goto Xf;
                }
                return $this->precision > 0 ? str_repeat(chr(0), $this->precision + 1 >> 3) : '';
                Xf:
                if (function_exists("\x67\x6d\x70\137\x65\170\x70\x6f\x72\164")) {
                    goto tF;
                }
                $rd = gmp_strval(gmp_abs($this->value), 16);
                $rd = strlen($rd) & 1 ? "\x30" . $rd : $rd;
                $rd = pack("\110\x2a", $rd);
                goto Im;
                tF:
                $rd = gmp_export($this->value);
                Im:
                return $this->precision > 0 ? substr(str_pad($rd, $this->precision >> 3, chr(0), STR_PAD_LEFT), -($this->precision >> 3)) : ltrim($rd, chr(0));
            case MATH_BIGINTEGER_MODE_BCMATH:
                if (!($this->value === "\60")) {
                    goto xw;
                }
                return $this->precision > 0 ? str_repeat(chr(0), $this->precision + 1 >> 3) : '';
                xw:
                $sw = '';
                $vv = $this->value;
                if (!($vv[0] == "\55")) {
                    goto ox;
                }
                $vv = substr($vv, 1);
                ox:
                F4:
                if (!(bccomp($vv, "\x30", 0) > 0)) {
                    goto Yp;
                }
                $rd = bcmod($vv, "\x31\x36\x37\x37\67\x32\x31\66");
                $sw = chr($rd >> 16) . chr($rd >> 8) . chr($rd) . $sw;
                $vv = bcdiv($vv, "\61\x36\67\67\x37\x32\x31\66", 0);
                goto F4;
                Yp:
                return $this->precision > 0 ? substr(str_pad($sw, $this->precision >> 3, chr(0), STR_PAD_LEFT), -($this->precision >> 3)) : ltrim($sw, chr(0));
        }
        mt:
        e3:
        if (count($this->value)) {
            goto We;
        }
        return $this->precision > 0 ? str_repeat(chr(0), $this->precision + 1 >> 3) : '';
        We:
        $mE = $this->_int2bytes($this->value[count($this->value) - 1]);
        $rd = $this->copy();
        $MC = count($rd->value) - 2;
        Ve:
        if (!($MC >= 0)) {
            goto y6;
        }
        $rd->_base256_lshift($mE, MATH_BIGINTEGER_BASE);
        $mE = $mE | str_pad($rd->_int2bytes($rd->value[$MC]), strlen($mE), chr(0), STR_PAD_LEFT);
        r_:
        --$MC;
        goto Ve;
        y6:
        return $this->precision > 0 ? str_pad(substr($mE, -($this->precision + 7 >> 3)), $this->precision + 7 >> 3, chr(0), STR_PAD_LEFT) : $mE;
    }
    function toHex($rH = false)
    {
        return bin2hex($this->toBytes($rH));
    }
    function toBits($rH = false)
    {
        $YR = $this->toHex($rH);
        $Hg = '';
        $MC = strlen($YR) - 8;
        $Mw = strlen($YR) & 7;
        OT:
        if (!($MC >= $Mw)) {
            goto JG;
        }
        $Hg = str_pad(decbin(hexdec(substr($YR, $MC, 8))), 32, "\60", STR_PAD_LEFT) . $Hg;
        ff:
        $MC -= 8;
        goto OT;
        JG:
        if (!$Mw) {
            goto cy;
        }
        $Hg = str_pad(decbin(hexdec(substr($YR, 0, $Mw))), 8, "\60", STR_PAD_LEFT) . $Hg;
        cy:
        $mE = $this->precision > 0 ? substr($Hg, -$this->precision) : ltrim($Hg, "\60");
        if (!($rH && $this->compare(new Math_BigInteger()) > 0 && $this->precision <= 0)) {
            goto DJ;
        }
        return "\60" . $mE;
        DJ:
        return $mE;
    }
    function toString()
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                return gmp_strval($this->value);
            case MATH_BIGINTEGER_MODE_BCMATH:
                if (!($this->value === "\x30")) {
                    goto eu;
                }
                return "\x30";
                eu:
                return ltrim($this->value, "\x30");
        }
        Pj:
        Si:
        if (count($this->value)) {
            goto c1;
        }
        return "\x30";
        c1:
        $rd = $this->copy();
        $rd->is_negative = false;
        $ZR = new Math_BigInteger();
        $ZR->value = array(MATH_BIGINTEGER_MAX10);
        $mE = '';
        Sg:
        if (!count($rd->value)) {
            goto xU;
        }
        list($rd, $VT) = $rd->divide($ZR);
        $mE = str_pad(isset($VT->value[0]) ? $VT->value[0] : '', MATH_BIGINTEGER_MAX10_LEN, "\60", STR_PAD_LEFT) . $mE;
        goto Sg;
        xU:
        $mE = ltrim($mE, "\x30");
        if (!empty($mE)) {
            goto ay;
        }
        $mE = "\x30";
        ay:
        if (!$this->is_negative) {
            goto gP;
        }
        $mE = "\55" . $mE;
        gP:
        return $mE;
    }
    function copy()
    {
        $rd = new Math_BigInteger();
        $rd->value = $this->value;
        $rd->is_negative = $this->is_negative;
        $rd->precision = $this->precision;
        $rd->bitmask = $this->bitmask;
        return $rd;
    }
    function __toString()
    {
        return $this->toString();
    }
    function __clone()
    {
        return $this->copy();
    }
    function __sleep()
    {
        $this->hex = $this->toHex(true);
        $l6 = array("\150\145\x78");
        if (!($this->precision > 0)) {
            goto rx;
        }
        $l6[] = "\160\162\145\x63\x69\x73\151\x6f\x6e";
        rx:
        return $l6;
    }
    function __wakeup()
    {
        $rd = new Math_BigInteger($this->hex, -16);
        $this->value = $rd->value;
        $this->is_negative = $rd->is_negative;
        if (!($this->precision > 0)) {
            goto Cb;
        }
        $this->setPrecision($this->precision);
        Cb:
    }
    function __debugInfo()
    {
        $fu = array();
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $Lu = "\x67\x6d\160";
                goto ki;
            case MATH_BIGINTEGER_MODE_BCMATH:
                $Lu = "\142\x63\x6d\141\x74\150";
                goto ki;
            case MATH_BIGINTEGER_MODE_INTERNAL:
                $Lu = "\151\x6e\x74\x65\162\x6e\x61\154";
                $fu[] = PHP_INT_SIZE == 8 ? "\66\64\55\142\151\164" : "\63\x32\x2d\142\x69\x74";
        }
        t1:
        ki:
        if (!(MATH_BIGINTEGER_MODE != MATH_BIGINTEGER_MODE_GMP && defined("\x4d\101\x54\110\x5f\102\x49\x47\x49\116\124\x45\x47\x45\x52\137\117\120\x45\116\123\123\114\137\105\116\x41\102\114\105\x44"))) {
            goto pN;
        }
        $fu[] = "\x4f\x70\145\x6e\123\123\114";
        pN:
        if (empty($fu)) {
            goto Q8;
        }
        $Lu .= "\40\50" . implode($fu, "\54\x20") . "\x29";
        Q8:
        return array("\x76\x61\x6c\x75\x65" => "\x30\170" . $this->toHex(true), "\x65\x6e\147\x69\x6e\145" => $Lu);
    }
    function add($mc)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $rd = new Math_BigInteger();
                $rd->value = gmp_add($this->value, $mc->value);
                return $this->_normalize($rd);
            case MATH_BIGINTEGER_MODE_BCMATH:
                $rd = new Math_BigInteger();
                $rd->value = bcadd($this->value, $mc->value, 0);
                return $this->_normalize($rd);
        }
        X_:
        BY:
        $rd = $this->_add($this->value, $this->is_negative, $mc->value, $mc->is_negative);
        $mE = new Math_BigInteger();
        $mE->value = $rd[MATH_BIGINTEGER_VALUE];
        $mE->is_negative = $rd[MATH_BIGINTEGER_SIGN];
        return $this->_normalize($mE);
    }
    function _add($rP, $hx, $pS, $xL)
    {
        $iE = count($rP);
        $Us = count($pS);
        if ($iE == 0) {
            goto f5;
        }
        if ($Us == 0) {
            goto hQ;
        }
        goto fG;
        f5:
        return array(MATH_BIGINTEGER_VALUE => $pS, MATH_BIGINTEGER_SIGN => $xL);
        goto fG;
        hQ:
        return array(MATH_BIGINTEGER_VALUE => $rP, MATH_BIGINTEGER_SIGN => $hx);
        fG:
        if (!($hx != $xL)) {
            goto HU;
        }
        if (!($rP == $pS)) {
            goto jr;
        }
        return array(MATH_BIGINTEGER_VALUE => array(), MATH_BIGINTEGER_SIGN => false);
        jr:
        $rd = $this->_subtract($rP, false, $pS, false);
        $rd[MATH_BIGINTEGER_SIGN] = $this->_compare($rP, false, $pS, false) > 0 ? $hx : $xL;
        return $rd;
        HU:
        if ($iE < $Us) {
            goto GH;
        }
        $Rh = $Us;
        $sw = $rP;
        goto Ud;
        GH:
        $Rh = $iE;
        $sw = $pS;
        Ud:
        $sw[count($sw)] = 0;
        $Kh = 0;
        $MC = 0;
        $Jw = 1;
        wh:
        if (!($Jw < $Rh)) {
            goto SK;
        }
        $F9 = $rP[$Jw] * MATH_BIGINTEGER_BASE_FULL + $rP[$MC] + $pS[$Jw] * MATH_BIGINTEGER_BASE_FULL + $pS[$MC] + $Kh;
        $Kh = $F9 >= MATH_BIGINTEGER_MAX_DIGIT2;
        $F9 = $Kh ? $F9 - MATH_BIGINTEGER_MAX_DIGIT2 : $F9;
        $rd = MATH_BIGINTEGER_BASE === 26 ? intval($F9 / 67108864) : $F9 >> 31;
        $sw[$MC] = (int) ($F9 - MATH_BIGINTEGER_BASE_FULL * $rd);
        $sw[$Jw] = $rd;
        Kk:
        $MC += 2;
        $Jw += 2;
        goto wh;
        SK:
        if (!($Jw == $Rh)) {
            goto tq;
        }
        $F9 = $rP[$MC] + $pS[$MC] + $Kh;
        $Kh = $F9 >= MATH_BIGINTEGER_BASE_FULL;
        $sw[$MC] = $Kh ? $F9 - MATH_BIGINTEGER_BASE_FULL : $F9;
        ++$MC;
        tq:
        if (!$Kh) {
            goto qT;
        }
        U9:
        if (!($sw[$MC] == MATH_BIGINTEGER_MAX_DIGIT)) {
            goto HB;
        }
        $sw[$MC] = 0;
        oF:
        ++$MC;
        goto U9;
        HB:
        ++$sw[$MC];
        qT:
        return array(MATH_BIGINTEGER_VALUE => $this->_trim($sw), MATH_BIGINTEGER_SIGN => $hx);
    }
    function subtract($mc)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $rd = new Math_BigInteger();
                $rd->value = gmp_sub($this->value, $mc->value);
                return $this->_normalize($rd);
            case MATH_BIGINTEGER_MODE_BCMATH:
                $rd = new Math_BigInteger();
                $rd->value = bcsub($this->value, $mc->value, 0);
                return $this->_normalize($rd);
        }
        K3:
        MB:
        $rd = $this->_subtract($this->value, $this->is_negative, $mc->value, $mc->is_negative);
        $mE = new Math_BigInteger();
        $mE->value = $rd[MATH_BIGINTEGER_VALUE];
        $mE->is_negative = $rd[MATH_BIGINTEGER_SIGN];
        return $this->_normalize($mE);
    }
    function _subtract($rP, $hx, $pS, $xL)
    {
        $iE = count($rP);
        $Us = count($pS);
        if ($iE == 0) {
            goto P9;
        }
        if ($Us == 0) {
            goto aS1;
        }
        goto ir;
        P9:
        return array(MATH_BIGINTEGER_VALUE => $pS, MATH_BIGINTEGER_SIGN => !$xL);
        goto ir;
        aS1:
        return array(MATH_BIGINTEGER_VALUE => $rP, MATH_BIGINTEGER_SIGN => $hx);
        ir:
        if (!($hx != $xL)) {
            goto WL;
        }
        $rd = $this->_add($rP, false, $pS, false);
        $rd[MATH_BIGINTEGER_SIGN] = $hx;
        return $rd;
        WL:
        $DD = $this->_compare($rP, $hx, $pS, $xL);
        if ($DD) {
            goto hD;
        }
        return array(MATH_BIGINTEGER_VALUE => array(), MATH_BIGINTEGER_SIGN => false);
        hD:
        if (!(!$hx && $DD < 0 || $hx && $DD > 0)) {
            goto XL;
        }
        $rd = $rP;
        $rP = $pS;
        $pS = $rd;
        $hx = !$hx;
        $iE = count($rP);
        $Us = count($pS);
        XL:
        $Kh = 0;
        $MC = 0;
        $Jw = 1;
        Kw:
        if (!($Jw < $Us)) {
            goto Mf;
        }
        $F9 = $rP[$Jw] * MATH_BIGINTEGER_BASE_FULL + $rP[$MC] - $pS[$Jw] * MATH_BIGINTEGER_BASE_FULL - $pS[$MC] - $Kh;
        $Kh = $F9 < 0;
        $F9 = $Kh ? $F9 + MATH_BIGINTEGER_MAX_DIGIT2 : $F9;
        $rd = MATH_BIGINTEGER_BASE === 26 ? intval($F9 / 67108864) : $F9 >> 31;
        $rP[$MC] = (int) ($F9 - MATH_BIGINTEGER_BASE_FULL * $rd);
        $rP[$Jw] = $rd;
        cQ:
        $MC += 2;
        $Jw += 2;
        goto Kw;
        Mf:
        if (!($Jw == $Us)) {
            goto Ar;
        }
        $F9 = $rP[$MC] - $pS[$MC] - $Kh;
        $Kh = $F9 < 0;
        $rP[$MC] = $Kh ? $F9 + MATH_BIGINTEGER_BASE_FULL : $F9;
        ++$MC;
        Ar:
        if (!$Kh) {
            goto EL;
        }
        f9:
        if ($rP[$MC]) {
            goto xp;
        }
        $rP[$MC] = MATH_BIGINTEGER_MAX_DIGIT;
        NI:
        ++$MC;
        goto f9;
        xp:
        --$rP[$MC];
        EL:
        return array(MATH_BIGINTEGER_VALUE => $this->_trim($rP), MATH_BIGINTEGER_SIGN => $hx);
    }
    function multiply($hs)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $rd = new Math_BigInteger();
                $rd->value = gmp_mul($this->value, $hs->value);
                return $this->_normalize($rd);
            case MATH_BIGINTEGER_MODE_BCMATH:
                $rd = new Math_BigInteger();
                $rd->value = bcmul($this->value, $hs->value, 0);
                return $this->_normalize($rd);
        }
        mK:
        ii:
        $rd = $this->_multiply($this->value, $this->is_negative, $hs->value, $hs->is_negative);
        $cc = new Math_BigInteger();
        $cc->value = $rd[MATH_BIGINTEGER_VALUE];
        $cc->is_negative = $rd[MATH_BIGINTEGER_SIGN];
        return $this->_normalize($cc);
    }
    function _multiply($rP, $hx, $pS, $xL)
    {
        $gS = count($rP);
        $V5 = count($pS);
        if (!(!$gS || !$V5)) {
            goto YX;
        }
        return array(MATH_BIGINTEGER_VALUE => array(), MATH_BIGINTEGER_SIGN => false);
        YX:
        return array(MATH_BIGINTEGER_VALUE => min($gS, $V5) < 2 * MATH_BIGINTEGER_KARATSUBA_CUTOFF ? $this->_trim($this->_regularMultiply($rP, $pS)) : $this->_trim($this->_karatsuba($rP, $pS)), MATH_BIGINTEGER_SIGN => $hx != $xL);
    }
    function _regularMultiply($rP, $pS)
    {
        $gS = count($rP);
        $V5 = count($pS);
        if (!(!$gS || !$V5)) {
            goto IW;
        }
        return array();
        IW:
        if (!($gS < $V5)) {
            goto cT;
        }
        $rd = $rP;
        $rP = $pS;
        $pS = $rd;
        $gS = count($rP);
        $V5 = count($pS);
        cT:
        $CE = $this->_array_repeat(0, $gS + $V5);
        $Kh = 0;
        $Jw = 0;
        oG:
        if (!($Jw < $gS)) {
            goto si;
        }
        $rd = $rP[$Jw] * $pS[0] + $Kh;
        $Kh = MATH_BIGINTEGER_BASE === 26 ? intval($rd / 67108864) : $rd >> 31;
        $CE[$Jw] = (int) ($rd - MATH_BIGINTEGER_BASE_FULL * $Kh);
        ee:
        ++$Jw;
        goto oG;
        si:
        $CE[$Jw] = $Kh;
        $MC = 1;
        zA:
        if (!($MC < $V5)) {
            goto XS;
        }
        $Kh = 0;
        $Jw = 0;
        $bz = $MC;
        YK:
        if (!($Jw < $gS)) {
            goto qk;
        }
        $rd = $CE[$bz] + $rP[$Jw] * $pS[$MC] + $Kh;
        $Kh = MATH_BIGINTEGER_BASE === 26 ? intval($rd / 67108864) : $rd >> 31;
        $CE[$bz] = (int) ($rd - MATH_BIGINTEGER_BASE_FULL * $Kh);
        MV:
        ++$Jw;
        ++$bz;
        goto YK;
        qk:
        $CE[$bz] = $Kh;
        qW:
        ++$MC;
        goto zA;
        XS:
        return $CE;
    }
    function _karatsuba($rP, $pS)
    {
        $pf = min(count($rP) >> 1, count($pS) >> 1);
        if (!($pf < MATH_BIGINTEGER_KARATSUBA_CUTOFF)) {
            goto q_;
        }
        return $this->_regularMultiply($rP, $pS);
        q_:
        $Kd = array_slice($rP, $pf);
        $UT = array_slice($rP, 0, $pf);
        $QH = array_slice($pS, $pf);
        $LL = array_slice($pS, 0, $pf);
        $N6 = $this->_karatsuba($Kd, $QH);
        $fK = $this->_karatsuba($UT, $LL);
        $Cm = $this->_add($Kd, false, $UT, false);
        $rd = $this->_add($QH, false, $LL, false);
        $Cm = $this->_karatsuba($Cm[MATH_BIGINTEGER_VALUE], $rd[MATH_BIGINTEGER_VALUE]);
        $rd = $this->_add($N6, false, $fK, false);
        $Cm = $this->_subtract($Cm, false, $rd[MATH_BIGINTEGER_VALUE], false);
        $N6 = array_merge(array_fill(0, 2 * $pf, 0), $N6);
        $Cm[MATH_BIGINTEGER_VALUE] = array_merge(array_fill(0, $pf, 0), $Cm[MATH_BIGINTEGER_VALUE]);
        $r8 = $this->_add($N6, false, $Cm[MATH_BIGINTEGER_VALUE], $Cm[MATH_BIGINTEGER_SIGN]);
        $r8 = $this->_add($r8[MATH_BIGINTEGER_VALUE], $r8[MATH_BIGINTEGER_SIGN], $fK, false);
        return $r8[MATH_BIGINTEGER_VALUE];
    }
    function _square($hs = false)
    {
        return count($hs) < 2 * MATH_BIGINTEGER_KARATSUBA_CUTOFF ? $this->_trim($this->_baseSquare($hs)) : $this->_trim($this->_karatsubaSquare($hs));
    }
    function _baseSquare($sw)
    {
        if (!empty($sw)) {
            goto TT;
        }
        return array();
        TT:
        $vR = $this->_array_repeat(0, 2 * count($sw));
        $MC = 0;
        $wy = count($sw) - 1;
        C6:
        if (!($MC <= $wy)) {
            goto pg;
        }
        $KP = $MC << 1;
        $rd = $vR[$KP] + $sw[$MC] * $sw[$MC];
        $Kh = MATH_BIGINTEGER_BASE === 26 ? intval($rd / 67108864) : $rd >> 31;
        $vR[$KP] = (int) ($rd - MATH_BIGINTEGER_BASE_FULL * $Kh);
        $Jw = $MC + 1;
        $bz = $KP + 1;
        vZ:
        if (!($Jw <= $wy)) {
            goto bV;
        }
        $rd = $vR[$bz] + 2 * $sw[$Jw] * $sw[$MC] + $Kh;
        $Kh = MATH_BIGINTEGER_BASE === 26 ? intval($rd / 67108864) : $rd >> 31;
        $vR[$bz] = (int) ($rd - MATH_BIGINTEGER_BASE_FULL * $Kh);
        bK:
        ++$Jw;
        ++$bz;
        goto vZ;
        bV:
        $vR[$MC + $wy + 1] = $Kh;
        FU:
        ++$MC;
        goto C6;
        pg:
        return $vR;
    }
    function _karatsubaSquare($sw)
    {
        $pf = count($sw) >> 1;
        if (!($pf < MATH_BIGINTEGER_KARATSUBA_CUTOFF)) {
            goto jW;
        }
        return $this->_baseSquare($sw);
        jW:
        $Kd = array_slice($sw, $pf);
        $UT = array_slice($sw, 0, $pf);
        $N6 = $this->_karatsubaSquare($Kd);
        $fK = $this->_karatsubaSquare($UT);
        $Cm = $this->_add($Kd, false, $UT, false);
        $Cm = $this->_karatsubaSquare($Cm[MATH_BIGINTEGER_VALUE]);
        $rd = $this->_add($N6, false, $fK, false);
        $Cm = $this->_subtract($Cm, false, $rd[MATH_BIGINTEGER_VALUE], false);
        $N6 = array_merge(array_fill(0, 2 * $pf, 0), $N6);
        $Cm[MATH_BIGINTEGER_VALUE] = array_merge(array_fill(0, $pf, 0), $Cm[MATH_BIGINTEGER_VALUE]);
        $M3 = $this->_add($N6, false, $Cm[MATH_BIGINTEGER_VALUE], $Cm[MATH_BIGINTEGER_SIGN]);
        $M3 = $this->_add($M3[MATH_BIGINTEGER_VALUE], $M3[MATH_BIGINTEGER_SIGN], $fK, false);
        return $M3[MATH_BIGINTEGER_VALUE];
    }
    function divide($mc)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $Io = new Math_BigInteger();
                $Qs = new Math_BigInteger();
                list($Io->value, $Qs->value) = gmp_div_qr($this->value, $mc->value);
                if (!(gmp_sign($Qs->value) < 0)) {
                    goto tR;
                }
                $Qs->value = gmp_add($Qs->value, gmp_abs($mc->value));
                tR:
                return array($this->_normalize($Io), $this->_normalize($Qs));
            case MATH_BIGINTEGER_MODE_BCMATH:
                $Io = new Math_BigInteger();
                $Qs = new Math_BigInteger();
                $Io->value = bcdiv($this->value, $mc->value, 0);
                $Qs->value = bcmod($this->value, $mc->value);
                if (!($Qs->value[0] == "\55")) {
                    goto vf;
                }
                $Qs->value = bcadd($Qs->value, $mc->value[0] == "\x2d" ? substr($mc->value, 1) : $mc->value, 0);
                vf:
                return array($this->_normalize($Io), $this->_normalize($Qs));
        }
        Zk:
        i5:
        if (!(count($mc->value) == 1)) {
            goto CT;
        }
        list($U9, $Y4) = $this->_divide_digit($this->value, $mc->value[0]);
        $Io = new Math_BigInteger();
        $Qs = new Math_BigInteger();
        $Io->value = $U9;
        $Qs->value = array($Y4);
        $Io->is_negative = $this->is_negative != $mc->is_negative;
        return array($this->_normalize($Io), $this->_normalize($Qs));
        CT:
        static $Ms;
        if (isset($Ms)) {
            goto bu;
        }
        $Ms = new Math_BigInteger();
        bu:
        $hs = $this->copy();
        $mc = $mc->copy();
        $hj = $hs->is_negative;
        $Ce = $mc->is_negative;
        $hs->is_negative = $mc->is_negative = false;
        $DD = $hs->compare($mc);
        if ($DD) {
            goto JA;
        }
        $rd = new Math_BigInteger();
        $rd->value = array(1);
        $rd->is_negative = $hj != $Ce;
        return array($this->_normalize($rd), $this->_normalize(new Math_BigInteger()));
        JA:
        if (!($DD < 0)) {
            goto sE;
        }
        if (!$hj) {
            goto LU;
        }
        $hs = $mc->subtract($hs);
        LU:
        return array($this->_normalize(new Math_BigInteger()), $this->_normalize($hs));
        sE:
        $PE = $mc->value[count($mc->value) - 1];
        $gm = 0;
        Zb:
        if ($PE & MATH_BIGINTEGER_MSB) {
            goto lA;
        }
        $PE <<= 1;
        HP:
        ++$gm;
        goto Zb;
        lA:
        $hs->_lshift($gm);
        $mc->_lshift($gm);
        $pS =& $mc->value;
        $lm = count($hs->value) - 1;
        $sq = count($mc->value) - 1;
        $Io = new Math_BigInteger();
        $zc =& $Io->value;
        $zc = $this->_array_repeat(0, $lm - $sq + 1);
        static $rd, $OG, $RU;
        if (isset($rd)) {
            goto EU;
        }
        $rd = new Math_BigInteger();
        $OG = new Math_BigInteger();
        $RU = new Math_BigInteger();
        EU:
        $GA =& $rd->value;
        $xq =& $RU->value;
        $GA = array_merge($this->_array_repeat(0, $lm - $sq), $pS);
        Re:
        if (!($hs->compare($rd) >= 0)) {
            goto Au;
        }
        ++$zc[$lm - $sq];
        $hs = $hs->subtract($rd);
        $lm = count($hs->value) - 1;
        goto Re;
        Au:
        $MC = $lm;
        jb:
        if (!($MC >= $sq + 1)) {
            goto zz;
        }
        $rP =& $hs->value;
        $ly = array(isset($rP[$MC]) ? $rP[$MC] : 0, isset($rP[$MC - 1]) ? $rP[$MC - 1] : 0, isset($rP[$MC - 2]) ? $rP[$MC - 2] : 0);
        $oP = array($pS[$sq], $sq > 0 ? $pS[$sq - 1] : 0);
        $uu = $MC - $sq - 1;
        if ($ly[0] == $oP[0]) {
            goto G2;
        }
        $zc[$uu] = $this->_safe_divide($ly[0] * MATH_BIGINTEGER_BASE_FULL + $ly[1], $oP[0]);
        goto Lz;
        G2:
        $zc[$uu] = MATH_BIGINTEGER_MAX_DIGIT;
        Lz:
        $GA = array($oP[1], $oP[0]);
        $OG->value = array($zc[$uu]);
        $OG = $OG->multiply($rd);
        $xq = array($ly[2], $ly[1], $ly[0]);
        TB:
        if (!($OG->compare($RU) > 0)) {
            goto wI;
        }
        --$zc[$uu];
        $OG->value = array($zc[$uu]);
        $OG = $OG->multiply($rd);
        goto TB;
        wI:
        $ye = $this->_array_repeat(0, $uu);
        $GA = array($zc[$uu]);
        $rd = $rd->multiply($mc);
        $GA =& $rd->value;
        $GA = array_merge($ye, $GA);
        $hs = $hs->subtract($rd);
        if (!($hs->compare($Ms) < 0)) {
            goto Es;
        }
        $GA = array_merge($ye, $pS);
        $hs = $hs->add($rd);
        --$zc[$uu];
        Es:
        $lm = count($rP) - 1;
        m4:
        --$MC;
        goto jb;
        zz:
        $hs->_rshift($gm);
        $Io->is_negative = $hj != $Ce;
        if (!$hj) {
            goto Uj;
        }
        $mc->_rshift($gm);
        $hs = $mc->subtract($hs);
        Uj:
        return array($this->_normalize($Io), $this->_normalize($hs));
    }
    function _divide_digit($dx, $ZR)
    {
        $Kh = 0;
        $mE = array();
        $MC = count($dx) - 1;
        Aw:
        if (!($MC >= 0)) {
            goto WQ;
        }
        $rd = MATH_BIGINTEGER_BASE_FULL * $Kh + $dx[$MC];
        $mE[$MC] = $this->_safe_divide($rd, $ZR);
        $Kh = (int) ($rd - $ZR * $mE[$MC]);
        dm:
        --$MC;
        goto Aw;
        WQ:
        return array($mE, $Kh);
    }
    function modPow($yh, $lZ)
    {
        $lZ = $this->bitmask !== false && $this->bitmask->compare($lZ) < 0 ? $this->bitmask : $lZ->abs();
        if (!($yh->compare(new Math_BigInteger()) < 0)) {
            goto A7;
        }
        $yh = $yh->abs();
        $rd = $this->modInverse($lZ);
        if (!($rd === false)) {
            goto kd;
        }
        return false;
        kd:
        return $this->_normalize($rd->modPow($yh, $lZ));
        A7:
        if (!(MATH_BIGINTEGER_MODE == MATH_BIGINTEGER_MODE_GMP)) {
            goto f_;
        }
        $rd = new Math_BigInteger();
        $rd->value = gmp_powm($this->value, $yh->value, $lZ->value);
        return $this->_normalize($rd);
        f_:
        if (!($this->compare(new Math_BigInteger()) < 0 || $this->compare($lZ) > 0)) {
            goto RY;
        }
        list(, $rd) = $this->divide($lZ);
        return $rd->modPow($yh, $lZ);
        RY:
        if (!defined("\115\x41\x54\110\x5f\102\x49\107\111\x4e\124\105\x47\105\x52\137\x4f\120\x45\x4e\x53\123\x4c\x5f\x45\116\x41\x42\x4c\x45\x44")) {
            goto xd;
        }
        $a7 = array("\x6d\x6f\x64\165\154\165\163" => $lZ->toBytes(true), "\x70\165\142\154\151\x63\105\x78\160\x6f\x6e\145\156\x74" => $yh->toBytes(true));
        $a7 = array("\155\157\144\165\x6c\x75\163" => pack("\x43\x61\x2a\141\52", 2, $this->_encodeASN1Length(strlen($a7["\155\x6f\144\x75\154\x75\163"])), $a7["\155\157\x64\165\x6c\165\163"]), "\160\165\142\154\151\x63\105\x78\160\x6f\x6e\x65\x6e\164" => pack("\103\x61\52\141\x2a", 2, $this->_encodeASN1Length(strlen($a7["\160\165\x62\154\x69\143\105\x78\x70\x6f\x6e\145\156\x74"])), $a7["\160\x75\x62\154\151\143\x45\x78\160\x6f\156\145\156\x74"]));
        $SW = pack("\103\x61\52\x61\x2a\141\52", 48, $this->_encodeASN1Length(strlen($a7["\155\157\x64\x75\154\165\163"]) + strlen($a7["\x70\x75\142\154\x69\x63\105\x78\160\157\156\145\x6e\164"])), $a7["\155\157\x64\165\154\x75\x73"], $a7["\160\165\142\x6c\x69\143\105\170\160\157\x6e\x65\156\164"]);
        $kA = pack("\x48\x2a", "\x33\x30\60\x64\x30\66\x30\71\62\141\70\66\64\x38\x38\66\x66\67\60\144\x30\x31\60\61\x30\61\60\x35\x30\60");
        $SW = chr(0) . $SW;
        $SW = chr(3) . $this->_encodeASN1Length(strlen($SW)) . $SW;
        $CZ = pack("\x43\x61\x2a\x61\52", 48, $this->_encodeASN1Length(strlen($kA . $SW)), $kA . $SW);
        $SW = "\55\55\x2d\x2d\55\x42\105\107\111\x4e\40\x50\x55\x42\x4c\111\103\x20\113\105\x59\x2d\55\55\x2d\55\xd\xa" . chunk_split(base64_encode($CZ)) . "\x2d\55\x2d\x2d\55\x45\116\104\x20\x50\125\x42\114\111\103\x20\x4b\105\131\55\x2d\55\x2d\55";
        $IB = str_pad($this->toBytes(), strlen($lZ->toBytes(true)) - 1, "\x0", STR_PAD_LEFT);
        if (!openssl_public_encrypt($IB, $mE, $SW, OPENSSL_NO_PADDING)) {
            goto Fm;
        }
        return new Math_BigInteger($mE, 256);
        Fm:
        xd:
        if (!(MATH_BIGINTEGER_MODE == MATH_BIGINTEGER_MODE_BCMATH)) {
            goto qu;
        }
        $rd = new Math_BigInteger();
        $rd->value = bcpowmod($this->value, $yh->value, $lZ->value, 0);
        return $this->_normalize($rd);
        qu:
        if (!empty($yh->value)) {
            goto UK;
        }
        $rd = new Math_BigInteger();
        $rd->value = array(1);
        return $this->_normalize($rd);
        UK:
        if (!($yh->value == array(1))) {
            goto Db;
        }
        list(, $rd) = $this->divide($lZ);
        return $this->_normalize($rd);
        Db:
        if (!($yh->value == array(2))) {
            goto Hd;
        }
        $rd = new Math_BigInteger();
        $rd->value = $this->_square($this->value);
        list(, $rd) = $rd->divide($lZ);
        return $this->_normalize($rd);
        Hd:
        return $this->_normalize($this->_slidingWindow($yh, $lZ, MATH_BIGINTEGER_BARRETT));
        if (!($lZ->value[0] & 1)) {
            goto kX;
        }
        return $this->_normalize($this->_slidingWindow($yh, $lZ, MATH_BIGINTEGER_MONTGOMERY));
        kX:
        $MC = 0;
        h9:
        if (!($MC < count($lZ->value))) {
            goto BS;
        }
        if (!$lZ->value[$MC]) {
            goto dK;
        }
        $rd = decbin($lZ->value[$MC]);
        $Jw = strlen($rd) - strrpos($rd, "\x31") - 1;
        $Jw += 26 * $MC;
        goto BS;
        dK:
        Hb:
        ++$MC;
        goto h9;
        BS:
        $XP = $lZ->copy();
        $XP->_rshift($Jw);
        $sz = new Math_BigInteger();
        $sz->value = array(1);
        $sz->_lshift($Jw);
        $Bv = $XP->value != array(1) ? $this->_slidingWindow($yh, $XP, MATH_BIGINTEGER_MONTGOMERY) : new Math_BigInteger();
        $ka = $this->_slidingWindow($yh, $sz, MATH_BIGINTEGER_POWEROF2);
        $QH = $sz->modInverse($XP);
        $Ie = $XP->modInverse($sz);
        $mE = $Bv->multiply($sz);
        $mE = $mE->multiply($QH);
        $rd = $ka->multiply($XP);
        $rd = $rd->multiply($Ie);
        $mE = $mE->add($rd);
        list(, $mE) = $mE->divide($lZ);
        return $this->_normalize($mE);
    }
    function powMod($yh, $lZ)
    {
        return $this->modPow($yh, $lZ);
    }
    function _slidingWindow($yh, $lZ, $ke)
    {
        static $FP = array(7, 25, 81, 241, 673, 1793);
        $W7 = $yh->value;
        $m8 = count($W7) - 1;
        $Kv = decbin($W7[$m8]);
        $MC = $m8 - 1;
        Oy:
        if (!($MC >= 0)) {
            goto B_;
        }
        $Kv .= str_pad(decbin($W7[$MC]), MATH_BIGINTEGER_BASE, "\x30", STR_PAD_LEFT);
        vy:
        --$MC;
        goto Oy;
        B_:
        $m8 = strlen($Kv);
        $MC = 0;
        $tL = 1;
        a8:
        if (!($MC < count($FP) && $m8 > $FP[$MC])) {
            goto aW;
        }
        d5:
        ++$tL;
        ++$MC;
        goto a8;
        aW:
        $PK = $lZ->value;
        $M2 = array();
        $M2[1] = $this->_prepareReduce($this->value, $PK, $ke);
        $M2[2] = $this->_squareReduce($M2[1], $PK, $ke);
        $rd = 1 << $tL - 1;
        $MC = 1;
        og:
        if (!($MC < $rd)) {
            goto RE;
        }
        $KP = $MC << 1;
        $M2[$KP + 1] = $this->_multiplyReduce($M2[$KP - 1], $M2[2], $PK, $ke);
        yc:
        ++$MC;
        goto og;
        RE:
        $mE = array(1);
        $mE = $this->_prepareReduce($mE, $PK, $ke);
        $MC = 0;
        Kn:
        if (!($MC < $m8)) {
            goto Op;
        }
        if (!$Kv[$MC]) {
            goto qg;
        }
        $Jw = $tL - 1;
        xs:
        if (!($Jw > 0)) {
            goto l4;
        }
        if (empty($Kv[$MC + $Jw])) {
            goto Pl;
        }
        goto l4;
        Pl:
        Bs:
        --$Jw;
        goto xs;
        l4:
        $bz = 0;
        n6:
        if (!($bz <= $Jw)) {
            goto Qr;
        }
        $mE = $this->_squareReduce($mE, $PK, $ke);
        s2:
        ++$bz;
        goto n6;
        Qr:
        $mE = $this->_multiplyReduce($mE, $M2[bindec(substr($Kv, $MC, $Jw + 1))], $PK, $ke);
        $MC += $Jw + 1;
        goto Gk;
        qg:
        $mE = $this->_squareReduce($mE, $PK, $ke);
        ++$MC;
        Gk:
        te:
        goto Kn;
        Op:
        $rd = new Math_BigInteger();
        $rd->value = $this->_reduce($mE, $PK, $ke);
        return $rd;
    }
    function _reduce($hs, $lZ, $ke)
    {
        switch ($ke) {
            case MATH_BIGINTEGER_MONTGOMERY:
                return $this->_montgomery($hs, $lZ);
            case MATH_BIGINTEGER_BARRETT:
                return $this->_barrett($hs, $lZ);
            case MATH_BIGINTEGER_POWEROF2:
                $OG = new Math_BigInteger();
                $OG->value = $hs;
                $RU = new Math_BigInteger();
                $RU->value = $lZ;
                return $hs->_mod2($lZ);
            case MATH_BIGINTEGER_CLASSIC:
                $OG = new Math_BigInteger();
                $OG->value = $hs;
                $RU = new Math_BigInteger();
                $RU->value = $lZ;
                list(, $rd) = $OG->divide($RU);
                return $rd->value;
            case MATH_BIGINTEGER_NONE:
                return $hs;
            default:
        }
        CW:
        N8:
    }
    function _prepareReduce($hs, $lZ, $ke)
    {
        if (!($ke == MATH_BIGINTEGER_MONTGOMERY)) {
            goto MG;
        }
        return $this->_prepMontgomery($hs, $lZ);
        MG:
        return $this->_reduce($hs, $lZ, $ke);
    }
    function _multiplyReduce($hs, $mc, $lZ, $ke)
    {
        if (!($ke == MATH_BIGINTEGER_MONTGOMERY)) {
            goto PJ;
        }
        return $this->_montgomeryMultiply($hs, $mc, $lZ);
        PJ:
        $rd = $this->_multiply($hs, false, $mc, false);
        return $this->_reduce($rd[MATH_BIGINTEGER_VALUE], $lZ, $ke);
    }
    function _squareReduce($hs, $lZ, $ke)
    {
        if (!($ke == MATH_BIGINTEGER_MONTGOMERY)) {
            goto M4;
        }
        return $this->_montgomeryMultiply($hs, $hs, $lZ);
        M4:
        return $this->_reduce($this->_square($hs), $lZ, $ke);
    }
    function _mod2($lZ)
    {
        $rd = new Math_BigInteger();
        $rd->value = array(1);
        return $this->bitwise_and($lZ->subtract($rd));
    }
    function _barrett($lZ, $pf)
    {
        static $yd = array(MATH_BIGINTEGER_VARIABLE => array(), MATH_BIGINTEGER_DATA => array());
        $qS = count($pf);
        if (!(count($lZ) > 2 * $qS)) {
            goto mb;
        }
        $OG = new Math_BigInteger();
        $RU = new Math_BigInteger();
        $OG->value = $lZ;
        $RU->value = $pf;
        list(, $rd) = $OG->divide($RU);
        return $rd->value;
        mb:
        if (!($qS < 5)) {
            goto xx;
        }
        return $this->_regularBarrett($lZ, $pf);
        xx:
        if (($qV = array_search($pf, $yd[MATH_BIGINTEGER_VARIABLE])) === false) {
            goto NK;
        }
        extract($yd[MATH_BIGINTEGER_DATA][$qV]);
        goto OL;
        NK:
        $qV = count($yd[MATH_BIGINTEGER_VARIABLE]);
        $yd[MATH_BIGINTEGER_VARIABLE][] = $pf;
        $OG = new Math_BigInteger();
        $cx =& $OG->value;
        $cx = $this->_array_repeat(0, $qS + ($qS >> 1));
        $cx[] = 1;
        $RU = new Math_BigInteger();
        $RU->value = $pf;
        list($aJ, $Nv) = $OG->divide($RU);
        $aJ = $aJ->value;
        $Nv = $Nv->value;
        $yd[MATH_BIGINTEGER_DATA][] = array("\x75" => $aJ, "\x6d\x31" => $Nv);
        OL:
        $dM = $qS + ($qS >> 1);
        $R4 = array_slice($lZ, 0, $dM);
        $WQ = array_slice($lZ, $dM);
        $R4 = $this->_trim($R4);
        $rd = $this->_multiply($WQ, false, $Nv, false);
        $lZ = $this->_add($R4, false, $rd[MATH_BIGINTEGER_VALUE], false);
        if (!($qS & 1)) {
            goto YT;
        }
        return $this->_regularBarrett($lZ[MATH_BIGINTEGER_VALUE], $pf);
        YT:
        $rd = array_slice($lZ[MATH_BIGINTEGER_VALUE], $qS - 1);
        $rd = $this->_multiply($rd, false, $aJ, false);
        $rd = array_slice($rd[MATH_BIGINTEGER_VALUE], ($qS >> 1) + 1);
        $rd = $this->_multiply($rd, false, $pf, false);
        $mE = $this->_subtract($lZ[MATH_BIGINTEGER_VALUE], false, $rd[MATH_BIGINTEGER_VALUE], false);
        gB:
        if (!($this->_compare($mE[MATH_BIGINTEGER_VALUE], $mE[MATH_BIGINTEGER_SIGN], $pf, false) >= 0)) {
            goto zw;
        }
        $mE = $this->_subtract($mE[MATH_BIGINTEGER_VALUE], $mE[MATH_BIGINTEGER_SIGN], $pf, false);
        goto gB;
        zw:
        return $mE[MATH_BIGINTEGER_VALUE];
    }
    function _regularBarrett($hs, $lZ)
    {
        static $yd = array(MATH_BIGINTEGER_VARIABLE => array(), MATH_BIGINTEGER_DATA => array());
        $Ku = count($lZ);
        if (!(count($hs) > 2 * $Ku)) {
            goto rF;
        }
        $OG = new Math_BigInteger();
        $RU = new Math_BigInteger();
        $OG->value = $hs;
        $RU->value = $lZ;
        list(, $rd) = $OG->divide($RU);
        return $rd->value;
        rF:
        if (!(($qV = array_search($lZ, $yd[MATH_BIGINTEGER_VARIABLE])) === false)) {
            goto Lw;
        }
        $qV = count($yd[MATH_BIGINTEGER_VARIABLE]);
        $yd[MATH_BIGINTEGER_VARIABLE][] = $lZ;
        $OG = new Math_BigInteger();
        $cx =& $OG->value;
        $cx = $this->_array_repeat(0, 2 * $Ku);
        $cx[] = 1;
        $RU = new Math_BigInteger();
        $RU->value = $lZ;
        list($rd, ) = $OG->divide($RU);
        $yd[MATH_BIGINTEGER_DATA][] = $rd->value;
        Lw:
        $rd = array_slice($hs, $Ku - 1);
        $rd = $this->_multiply($rd, false, $yd[MATH_BIGINTEGER_DATA][$qV], false);
        $rd = array_slice($rd[MATH_BIGINTEGER_VALUE], $Ku + 1);
        $mE = array_slice($hs, 0, $Ku + 1);
        $rd = $this->_multiplyLower($rd, false, $lZ, false, $Ku + 1);
        if (!($this->_compare($mE, false, $rd[MATH_BIGINTEGER_VALUE], $rd[MATH_BIGINTEGER_SIGN]) < 0)) {
            goto ko;
        }
        $X1 = $this->_array_repeat(0, $Ku + 1);
        $X1[count($X1)] = 1;
        $mE = $this->_add($mE, false, $X1, false);
        $mE = $mE[MATH_BIGINTEGER_VALUE];
        ko:
        $mE = $this->_subtract($mE, false, $rd[MATH_BIGINTEGER_VALUE], $rd[MATH_BIGINTEGER_SIGN]);
        Zq:
        if (!($this->_compare($mE[MATH_BIGINTEGER_VALUE], $mE[MATH_BIGINTEGER_SIGN], $lZ, false) > 0)) {
            goto Eq;
        }
        $mE = $this->_subtract($mE[MATH_BIGINTEGER_VALUE], $mE[MATH_BIGINTEGER_SIGN], $lZ, false);
        goto Zq;
        Eq:
        return $mE[MATH_BIGINTEGER_VALUE];
    }
    function _multiplyLower($rP, $hx, $pS, $xL, $Uw)
    {
        $gS = count($rP);
        $V5 = count($pS);
        if (!(!$gS || !$V5)) {
            goto C2;
        }
        return array(MATH_BIGINTEGER_VALUE => array(), MATH_BIGINTEGER_SIGN => false);
        C2:
        if (!($gS < $V5)) {
            goto yk;
        }
        $rd = $rP;
        $rP = $pS;
        $pS = $rd;
        $gS = count($rP);
        $V5 = count($pS);
        yk:
        $CE = $this->_array_repeat(0, $gS + $V5);
        $Kh = 0;
        $Jw = 0;
        jx:
        if (!($Jw < $gS)) {
            goto tC;
        }
        $rd = $rP[$Jw] * $pS[0] + $Kh;
        $Kh = MATH_BIGINTEGER_BASE === 26 ? intval($rd / 67108864) : $rd >> 31;
        $CE[$Jw] = (int) ($rd - MATH_BIGINTEGER_BASE_FULL * $Kh);
        vd:
        ++$Jw;
        goto jx;
        tC:
        if (!($Jw < $Uw)) {
            goto tS;
        }
        $CE[$Jw] = $Kh;
        tS:
        $MC = 1;
        gH:
        if (!($MC < $V5)) {
            goto cZ;
        }
        $Kh = 0;
        $Jw = 0;
        $bz = $MC;
        zS:
        if (!($Jw < $gS && $bz < $Uw)) {
            goto xo;
        }
        $rd = $CE[$bz] + $rP[$Jw] * $pS[$MC] + $Kh;
        $Kh = MATH_BIGINTEGER_BASE === 26 ? intval($rd / 67108864) : $rd >> 31;
        $CE[$bz] = (int) ($rd - MATH_BIGINTEGER_BASE_FULL * $Kh);
        xa:
        ++$Jw;
        ++$bz;
        goto zS;
        xo:
        if (!($bz < $Uw)) {
            goto mO;
        }
        $CE[$bz] = $Kh;
        mO:
        sn:
        ++$MC;
        goto gH;
        cZ:
        return array(MATH_BIGINTEGER_VALUE => $this->_trim($CE), MATH_BIGINTEGER_SIGN => $hx != $xL);
    }
    function _montgomery($hs, $lZ)
    {
        static $yd = array(MATH_BIGINTEGER_VARIABLE => array(), MATH_BIGINTEGER_DATA => array());
        if (!(($qV = array_search($lZ, $yd[MATH_BIGINTEGER_VARIABLE])) === false)) {
            goto Uu;
        }
        $qV = count($yd[MATH_BIGINTEGER_VARIABLE]);
        $yd[MATH_BIGINTEGER_VARIABLE][] = $hs;
        $yd[MATH_BIGINTEGER_DATA][] = $this->_modInverse67108864($lZ);
        Uu:
        $bz = count($lZ);
        $mE = array(MATH_BIGINTEGER_VALUE => $hs);
        $MC = 0;
        fl:
        if (!($MC < $bz)) {
            goto F9;
        }
        $rd = $mE[MATH_BIGINTEGER_VALUE][$MC] * $yd[MATH_BIGINTEGER_DATA][$qV];
        $rd = $rd - MATH_BIGINTEGER_BASE_FULL * (MATH_BIGINTEGER_BASE === 26 ? intval($rd / 67108864) : $rd >> 31);
        $rd = $this->_regularMultiply(array($rd), $lZ);
        $rd = array_merge($this->_array_repeat(0, $MC), $rd);
        $mE = $this->_add($mE[MATH_BIGINTEGER_VALUE], false, $rd, false);
        Nn:
        ++$MC;
        goto fl;
        F9:
        $mE[MATH_BIGINTEGER_VALUE] = array_slice($mE[MATH_BIGINTEGER_VALUE], $bz);
        if (!($this->_compare($mE, false, $lZ, false) >= 0)) {
            goto Lp;
        }
        $mE = $this->_subtract($mE[MATH_BIGINTEGER_VALUE], false, $lZ, false);
        Lp:
        return $mE[MATH_BIGINTEGER_VALUE];
    }
    function _montgomeryMultiply($hs, $mc, $pf)
    {
        $rd = $this->_multiply($hs, false, $mc, false);
        return $this->_montgomery($rd[MATH_BIGINTEGER_VALUE], $pf);
        static $yd = array(MATH_BIGINTEGER_VARIABLE => array(), MATH_BIGINTEGER_DATA => array());
        if (!(($qV = array_search($pf, $yd[MATH_BIGINTEGER_VARIABLE])) === false)) {
            goto mP;
        }
        $qV = count($yd[MATH_BIGINTEGER_VARIABLE]);
        $yd[MATH_BIGINTEGER_VARIABLE][] = $pf;
        $yd[MATH_BIGINTEGER_DATA][] = $this->_modInverse67108864($pf);
        mP:
        $lZ = max(count($hs), count($mc), count($pf));
        $hs = array_pad($hs, $lZ, 0);
        $mc = array_pad($mc, $lZ, 0);
        $pf = array_pad($pf, $lZ, 0);
        $tt = array(MATH_BIGINTEGER_VALUE => $this->_array_repeat(0, $lZ + 1));
        $MC = 0;
        b4:
        if (!($MC < $lZ)) {
            goto g8;
        }
        $rd = $tt[MATH_BIGINTEGER_VALUE][0] + $hs[$MC] * $mc[0];
        $rd = $rd - MATH_BIGINTEGER_BASE_FULL * (MATH_BIGINTEGER_BASE === 26 ? intval($rd / 67108864) : $rd >> 31);
        $rd = $rd * $yd[MATH_BIGINTEGER_DATA][$qV];
        $rd = $rd - MATH_BIGINTEGER_BASE_FULL * (MATH_BIGINTEGER_BASE === 26 ? intval($rd / 67108864) : $rd >> 31);
        $rd = $this->_add($this->_regularMultiply(array($hs[$MC]), $mc), false, $this->_regularMultiply(array($rd), $pf), false);
        $tt = $this->_add($tt[MATH_BIGINTEGER_VALUE], false, $rd[MATH_BIGINTEGER_VALUE], false);
        $tt[MATH_BIGINTEGER_VALUE] = array_slice($tt[MATH_BIGINTEGER_VALUE], 1);
        Pg:
        ++$MC;
        goto b4;
        g8:
        if (!($this->_compare($tt[MATH_BIGINTEGER_VALUE], false, $pf, false) >= 0)) {
            goto sg;
        }
        $tt = $this->_subtract($tt[MATH_BIGINTEGER_VALUE], false, $pf, false);
        sg:
        return $tt[MATH_BIGINTEGER_VALUE];
    }
    function _prepMontgomery($hs, $lZ)
    {
        $OG = new Math_BigInteger();
        $OG->value = array_merge($this->_array_repeat(0, count($lZ)), $hs);
        $RU = new Math_BigInteger();
        $RU->value = $lZ;
        list(, $rd) = $OG->divide($RU);
        return $rd->value;
    }
    function _modInverse67108864($hs)
    {
        $hs = -$hs[0];
        $mE = $hs & 3;
        $mE = $mE * (2 - $hs * $mE) & 15;
        $mE = $mE * (2 - ($hs & 255) * $mE) & 255;
        $mE = $mE * (2 - ($hs & 65535) * $mE & 65535) & 65535;
        $mE = fmod($mE * (2 - fmod($hs * $mE, MATH_BIGINTEGER_BASE_FULL)), MATH_BIGINTEGER_BASE_FULL);
        return $mE & MATH_BIGINTEGER_MAX_DIGIT;
    }
    function modInverse($lZ)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $rd = new Math_BigInteger();
                $rd->value = gmp_invert($this->value, $lZ->value);
                return $rd->value === false ? false : $this->_normalize($rd);
        }
        ND:
        oY:
        static $Ms, $ix;
        if (isset($Ms)) {
            goto AN;
        }
        $Ms = new Math_BigInteger();
        $ix = new Math_BigInteger(1);
        AN:
        $lZ = $lZ->abs();
        if (!($this->compare($Ms) < 0)) {
            goto nV;
        }
        $rd = $this->abs();
        $rd = $rd->modInverse($lZ);
        return $this->_normalize($lZ->subtract($rd));
        nV:
        extract($this->extendedGCD($lZ));
        if ($dp->equals($ix)) {
            goto YO;
        }
        return false;
        YO:
        $hs = $hs->compare($Ms) < 0 ? $hs->add($lZ) : $hs;
        return $this->compare($Ms) < 0 ? $this->_normalize($lZ->subtract($hs)) : $this->_normalize($hs);
    }
    function extendedGCD($lZ)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                extract(gmp_gcdext($this->value, $lZ->value));
                return array("\x67\x63\x64" => $this->_normalize(new Math_BigInteger($Zq)), "\x78" => $this->_normalize(new Math_BigInteger($T6)), "\x79" => $this->_normalize(new Math_BigInteger($e9)));
            case MATH_BIGINTEGER_MODE_BCMATH:
                $aJ = $this->value;
                $xP = $lZ->value;
                $tt = "\61";
                $Uj = "\x30";
                $Wx = "\x30";
                $Hk = "\x31";
                I3:
                if (!(bccomp($xP, "\x30", 0) != 0)) {
                    goto Pp;
                }
                $U9 = bcdiv($aJ, $xP, 0);
                $rd = $aJ;
                $aJ = $xP;
                $xP = bcsub($rd, bcmul($xP, $U9, 0), 0);
                $rd = $tt;
                $tt = $Wx;
                $Wx = bcsub($rd, bcmul($tt, $U9, 0), 0);
                $rd = $Uj;
                $Uj = $Hk;
                $Hk = bcsub($rd, bcmul($Uj, $U9, 0), 0);
                goto I3;
                Pp:
                return array("\x67\x63\144" => $this->_normalize(new Math_BigInteger($aJ)), "\170" => $this->_normalize(new Math_BigInteger($tt)), "\171" => $this->_normalize(new Math_BigInteger($Uj)));
        }
        pD:
        Ky:
        $mc = $lZ->copy();
        $hs = $this->copy();
        $Zq = new Math_BigInteger();
        $Zq->value = array(1);
        Ow:
        if ($hs->value[0] & 1 || $mc->value[0] & 1) {
            goto CD;
        }
        $hs->_rshift(1);
        $mc->_rshift(1);
        $Zq->_lshift(1);
        goto Ow;
        CD:
        $aJ = $hs->copy();
        $xP = $mc->copy();
        $tt = new Math_BigInteger();
        $Uj = new Math_BigInteger();
        $Wx = new Math_BigInteger();
        $Hk = new Math_BigInteger();
        $tt->value = $Hk->value = $Zq->value = array(1);
        $Uj->value = $Wx->value = array();
        in:
        if (empty($aJ->value)) {
            goto Wc;
        }
        uv:
        if ($aJ->value[0] & 1) {
            goto PA;
        }
        $aJ->_rshift(1);
        if (!(!empty($tt->value) && $tt->value[0] & 1 || !empty($Uj->value) && $Uj->value[0] & 1)) {
            goto Ps;
        }
        $tt = $tt->add($mc);
        $Uj = $Uj->subtract($hs);
        Ps:
        $tt->_rshift(1);
        $Uj->_rshift(1);
        goto uv;
        PA:
        Hr:
        if ($xP->value[0] & 1) {
            goto Z_;
        }
        $xP->_rshift(1);
        if (!(!empty($Hk->value) && $Hk->value[0] & 1 || !empty($Wx->value) && $Wx->value[0] & 1)) {
            goto j5;
        }
        $Wx = $Wx->add($mc);
        $Hk = $Hk->subtract($hs);
        j5:
        $Wx->_rshift(1);
        $Hk->_rshift(1);
        goto Hr;
        Z_:
        if ($aJ->compare($xP) >= 0) {
            goto Fz;
        }
        $xP = $xP->subtract($aJ);
        $Wx = $Wx->subtract($tt);
        $Hk = $Hk->subtract($Uj);
        goto rO;
        Fz:
        $aJ = $aJ->subtract($xP);
        $tt = $tt->subtract($Wx);
        $Uj = $Uj->subtract($Hk);
        rO:
        goto in;
        Wc:
        return array("\147\x63\144" => $this->_normalize($Zq->multiply($xP)), "\x78" => $this->_normalize($Wx), "\171" => $this->_normalize($Hk));
    }
    function gcd($lZ)
    {
        extract($this->extendedGCD($lZ));
        return $dp;
    }
    function abs()
    {
        $rd = new Math_BigInteger();
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $rd->value = gmp_abs($this->value);
                goto nw;
            case MATH_BIGINTEGER_MODE_BCMATH:
                $rd->value = bccomp($this->value, "\x30", 0) < 0 ? substr($this->value, 1) : $this->value;
                goto nw;
            default:
                $rd->value = $this->value;
        }
        WK:
        nw:
        return $rd;
    }
    function compare($mc)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                return gmp_cmp($this->value, $mc->value);
            case MATH_BIGINTEGER_MODE_BCMATH:
                return bccomp($this->value, $mc->value, 0);
        }
        vB:
        Ry:
        return $this->_compare($this->value, $this->is_negative, $mc->value, $mc->is_negative);
    }
    function _compare($rP, $hx, $pS, $xL)
    {
        if (!($hx != $xL)) {
            goto P6;
        }
        return !$hx && $xL ? 1 : -1;
        P6:
        $mE = $hx ? -1 : 1;
        if (!(count($rP) != count($pS))) {
            goto IU;
        }
        return count($rP) > count($pS) ? $mE : -$mE;
        IU:
        $Rh = max(count($rP), count($pS));
        $rP = array_pad($rP, $Rh, 0);
        $pS = array_pad($pS, $Rh, 0);
        $MC = count($rP) - 1;
        TX:
        if (!($MC >= 0)) {
            goto j8;
        }
        if (!($rP[$MC] != $pS[$MC])) {
            goto lB;
        }
        return $rP[$MC] > $pS[$MC] ? $mE : -$mE;
        lB:
        ny:
        --$MC;
        goto TX;
        j8:
        return 0;
    }
    function equals($hs)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                return gmp_cmp($this->value, $hs->value) == 0;
            default:
                return $this->value === $hs->value && $this->is_negative == $hs->is_negative;
        }
        fc:
        Y3:
    }
    function setPrecision($Hg)
    {
        $this->precision = $Hg;
        if (MATH_BIGINTEGER_MODE != MATH_BIGINTEGER_MODE_BCMATH) {
            goto MS;
        }
        $this->bitmask = new Math_BigInteger(bcpow("\62", $Hg, 0));
        goto C0;
        MS:
        $this->bitmask = new Math_BigInteger(chr((1 << ($Hg & 7)) - 1) . str_repeat(chr(255), $Hg >> 3), 256);
        C0:
        $rd = $this->_normalize($this);
        $this->value = $rd->value;
    }
    function bitwise_and($hs)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $rd = new Math_BigInteger();
                $rd->value = gmp_and($this->value, $hs->value);
                return $this->_normalize($rd);
            case MATH_BIGINTEGER_MODE_BCMATH:
                $Gr = $this->toBytes();
                $ZL = $hs->toBytes();
                $Yy = max(strlen($Gr), strlen($ZL));
                $Gr = str_pad($Gr, $Yy, chr(0), STR_PAD_LEFT);
                $ZL = str_pad($ZL, $Yy, chr(0), STR_PAD_LEFT);
                return $this->_normalize(new Math_BigInteger($Gr & $ZL, 256));
        }
        Za:
        hu:
        $mE = $this->copy();
        $Yy = min(count($hs->value), count($this->value));
        $mE->value = array_slice($mE->value, 0, $Yy);
        $MC = 0;
        c8:
        if (!($MC < $Yy)) {
            goto mJ;
        }
        $mE->value[$MC] &= $hs->value[$MC];
        zn:
        ++$MC;
        goto c8;
        mJ:
        return $this->_normalize($mE);
    }
    function bitwise_or($hs)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $rd = new Math_BigInteger();
                $rd->value = gmp_or($this->value, $hs->value);
                return $this->_normalize($rd);
            case MATH_BIGINTEGER_MODE_BCMATH:
                $Gr = $this->toBytes();
                $ZL = $hs->toBytes();
                $Yy = max(strlen($Gr), strlen($ZL));
                $Gr = str_pad($Gr, $Yy, chr(0), STR_PAD_LEFT);
                $ZL = str_pad($ZL, $Yy, chr(0), STR_PAD_LEFT);
                return $this->_normalize(new Math_BigInteger($Gr | $ZL, 256));
        }
        ry:
        wN:
        $Yy = max(count($this->value), count($hs->value));
        $mE = $this->copy();
        $mE->value = array_pad($mE->value, $Yy, 0);
        $hs->value = array_pad($hs->value, $Yy, 0);
        $MC = 0;
        F0:
        if (!($MC < $Yy)) {
            goto iP;
        }
        $mE->value[$MC] |= $hs->value[$MC];
        jp:
        ++$MC;
        goto F0;
        iP:
        return $this->_normalize($mE);
    }
    function bitwise_xor($hs)
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                $rd = new Math_BigInteger();
                $rd->value = gmp_xor(gmp_abs($this->value), gmp_abs($hs->value));
                return $this->_normalize($rd);
            case MATH_BIGINTEGER_MODE_BCMATH:
                $Gr = $this->toBytes();
                $ZL = $hs->toBytes();
                $Yy = max(strlen($Gr), strlen($ZL));
                $Gr = str_pad($Gr, $Yy, chr(0), STR_PAD_LEFT);
                $ZL = str_pad($ZL, $Yy, chr(0), STR_PAD_LEFT);
                return $this->_normalize(new Math_BigInteger($Gr ^ $ZL, 256));
        }
        XU:
        xi:
        $Yy = max(count($this->value), count($hs->value));
        $mE = $this->copy();
        $mE->is_negative = false;
        $mE->value = array_pad($mE->value, $Yy, 0);
        $hs->value = array_pad($hs->value, $Yy, 0);
        $MC = 0;
        BI:
        if (!($MC < $Yy)) {
            goto hx;
        }
        $mE->value[$MC] ^= $hs->value[$MC];
        Q2:
        ++$MC;
        goto BI;
        hx:
        return $this->_normalize($mE);
    }
    function bitwise_not()
    {
        $rd = $this->toBytes();
        if (!($rd == '')) {
            goto Hg;
        }
        return $this->_normalize(new Math_BigInteger());
        Hg:
        $Bb = decbin(ord($rd[0]));
        $rd = ~$rd;
        $PE = decbin(ord($rd[0]));
        if (!(strlen($PE) == 8)) {
            goto dO1;
        }
        $PE = substr($PE, strpos($PE, "\x30"));
        dO1:
        $rd[0] = chr(bindec($PE));
        $Ho = strlen($Bb) + 8 * strlen($rd) - 8;
        $bu = $this->precision - $Ho;
        if (!($bu <= 0)) {
            goto y4;
        }
        return $this->_normalize(new Math_BigInteger($rd, 256));
        y4:
        $xd = chr((1 << ($bu & 7)) - 1) . str_repeat(chr(255), $bu >> 3);
        $this->_base256_lshift($xd, $Ho);
        $rd = str_pad($rd, strlen($xd), chr(0), STR_PAD_LEFT);
        return $this->_normalize(new Math_BigInteger($xd | $rd, 256));
    }
    function bitwise_rightShift($gm)
    {
        $rd = new Math_BigInteger();
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                static $II;
                if (isset($II)) {
                    goto ix;
                }
                $II = gmp_init("\x32");
                ix:
                $rd->value = gmp_div_q($this->value, gmp_pow($II, $gm));
                goto Ra;
            case MATH_BIGINTEGER_MODE_BCMATH:
                $rd->value = bcdiv($this->value, bcpow("\62", $gm, 0), 0);
                goto Ra;
            default:
                $rd->value = $this->value;
                $rd->_rshift($gm);
        }
        uQ:
        Ra:
        return $this->_normalize($rd);
    }
    function bitwise_leftShift($gm)
    {
        $rd = new Math_BigInteger();
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                static $II;
                if (isset($II)) {
                    goto dv;
                }
                $II = gmp_init("\62");
                dv:
                $rd->value = gmp_mul($this->value, gmp_pow($II, $gm));
                goto g6;
            case MATH_BIGINTEGER_MODE_BCMATH:
                $rd->value = bcmul($this->value, bcpow("\x32", $gm, 0), 0);
                goto g6;
            default:
                $rd->value = $this->value;
                $rd->_lshift($gm);
        }
        yy:
        g6:
        return $this->_normalize($rd);
    }
    function bitwise_leftRotate($gm)
    {
        $Hg = $this->toBytes();
        if ($this->precision > 0) {
            goto g4;
        }
        $rd = ord($Hg[0]);
        $MC = 0;
        pP:
        if (!($rd >> $MC)) {
            goto uG;
        }
        r2:
        ++$MC;
        goto pP;
        uG:
        $vW = 8 * strlen($Hg) - 8 + $MC;
        $sU = chr((1 << ($vW & 7)) - 1) . str_repeat(chr(255), $vW >> 3);
        goto wl;
        g4:
        $vW = $this->precision;
        if (MATH_BIGINTEGER_MODE == MATH_BIGINTEGER_MODE_BCMATH) {
            goto gN;
        }
        $sU = $this->bitmask->toBytes();
        goto UR;
        gN:
        $sU = $this->bitmask->subtract(new Math_BigInteger(1));
        $sU = $sU->toBytes();
        UR:
        wl:
        if (!($gm < 0)) {
            goto Kc;
        }
        $gm += $vW;
        Kc:
        $gm %= $vW;
        if ($gm) {
            goto dt;
        }
        return $this->copy();
        dt:
        $Gr = $this->bitwise_leftShift($gm);
        $Gr = $Gr->bitwise_and(new Math_BigInteger($sU, 256));
        $ZL = $this->bitwise_rightShift($vW - $gm);
        $mE = MATH_BIGINTEGER_MODE != MATH_BIGINTEGER_MODE_BCMATH ? $Gr->bitwise_or($ZL) : $Gr->add($ZL);
        return $this->_normalize($mE);
    }
    function bitwise_rightRotate($gm)
    {
        return $this->bitwise_leftRotate(-$gm);
    }
    function setRandomGenerator($o4)
    {
    }
    function _random_number_helper($Rh)
    {
        if (function_exists("\x63\x72\171\160\164\x5f\x72\141\x6e\x64\157\x6d\137\x73\x74\x72\151\156\x67")) {
            goto h1;
        }
        $CI = '';
        if (!($Rh & 1)) {
            goto Mt;
        }
        $CI .= chr(mt_rand(0, 255));
        Mt:
        $yZ = $Rh >> 1;
        $MC = 0;
        HM:
        if (!($MC < $yZ)) {
            goto KQ;
        }
        $CI .= pack("\156", mt_rand(0, 65535));
        ke:
        ++$MC;
        goto HM;
        KQ:
        goto lE;
        h1:
        $CI = crypt_random_string($Rh);
        lE:
        return new Math_BigInteger($CI, 256);
    }
    function random($Jr, $iL = false)
    {
        if (!($Jr === false)) {
            goto m_;
        }
        return false;
        m_:
        if ($iL === false) {
            goto JNU;
        }
        $BU = $Jr;
        $Wa = $iL;
        goto xp3;
        JNU:
        $Wa = $Jr;
        $BU = $this;
        xp3:
        $qw = $Wa->compare($BU);
        if (!$qw) {
            goto WtK;
        }
        if ($qw < 0) {
            goto jjv;
        }
        goto S9U;
        WtK:
        return $this->_normalize($BU);
        goto S9U;
        jjv:
        $rd = $Wa;
        $Wa = $BU;
        $BU = $rd;
        S9U:
        static $ix;
        if (isset($ix)) {
            goto bpO;
        }
        $ix = new Math_BigInteger(1);
        bpO:
        $Wa = $Wa->subtract($BU->subtract($ix));
        $Rh = strlen(ltrim($Wa->toBytes(), chr(0)));
        $Lk = new Math_BigInteger(chr(1) . str_repeat("\0", $Rh), 256);
        $CI = $this->_random_number_helper($Rh);
        list($Dt) = $Lk->divide($Wa);
        $Dt = $Dt->multiply($Wa);
        pMZ:
        if (!($CI->compare($Dt) >= 0)) {
            goto wyL;
        }
        $CI = $CI->subtract($Dt);
        $Lk = $Lk->subtract($Dt);
        $CI = $CI->bitwise_leftShift(8);
        $CI = $CI->add($this->_random_number_helper(1));
        $Lk = $Lk->bitwise_leftShift(8);
        list($Dt) = $Lk->divide($Wa);
        $Dt = $Dt->multiply($Wa);
        goto pMZ;
        wyL:
        list(, $CI) = $CI->divide($Wa);
        return $this->_normalize($CI->add($BU));
    }
    function randomPrime($Jr, $iL = false, $nz = false)
    {
        if (!($Jr === false)) {
            goto OgT;
        }
        return false;
        OgT:
        if ($iL === false) {
            goto XaA;
        }
        $BU = $Jr;
        $Wa = $iL;
        goto ryL;
        XaA:
        $Wa = $Jr;
        $BU = $this;
        ryL:
        $qw = $Wa->compare($BU);
        if (!$qw) {
            goto Frw;
        }
        if ($qw < 0) {
            goto cDf;
        }
        goto VVw;
        Frw:
        return $BU->isPrime() ? $BU : false;
        goto VVw;
        cDf:
        $rd = $Wa;
        $Wa = $BU;
        $BU = $rd;
        VVw:
        static $ix, $II;
        if (isset($ix)) {
            goto A3c;
        }
        $ix = new Math_BigInteger(1);
        $II = new Math_BigInteger(2);
        A3c:
        $Mw = time();
        $hs = $this->random($BU, $Wa);
        if (!(MATH_BIGINTEGER_MODE == MATH_BIGINTEGER_MODE_GMP && extension_loaded("\x67\155\x70") && version_compare(PHP_VERSION, "\x35\x2e\62\x2e\60", "\x3e\x3d"))) {
            goto VWD;
        }
        $Zm = new Math_BigInteger();
        $Zm->value = gmp_nextprime($hs->value);
        if (!($Zm->compare($Wa) <= 0)) {
            goto xsU;
        }
        return $Zm;
        xsU:
        if ($BU->equals($hs)) {
            goto D6h;
        }
        $hs = $hs->subtract($ix);
        D6h:
        return $hs->randomPrime($BU, $hs);
        VWD:
        if (!$hs->equals($II)) {
            goto ejw;
        }
        return $hs;
        ejw:
        $hs->_make_odd();
        if (!($hs->compare($Wa) > 0)) {
            goto lkO;
        }
        if (!$BU->equals($Wa)) {
            goto D8w;
        }
        return false;
        D8w:
        $hs = $BU->copy();
        $hs->_make_odd();
        lkO:
        $U3 = $hs->copy();
        SIx:
        if (!true) {
            goto obj;
        }
        if (!($nz !== false && time() - $Mw > $nz)) {
            goto Ot8;
        }
        return false;
        Ot8:
        if (!$hs->isPrime()) {
            goto D1j;
        }
        return $hs;
        D1j:
        $hs = $hs->add($II);
        if (!($hs->compare($Wa) > 0)) {
            goto vql;
        }
        $hs = $BU->copy();
        if (!$hs->equals($II)) {
            goto a4b;
        }
        return $hs;
        a4b:
        $hs->_make_odd();
        vql:
        if (!$hs->equals($U3)) {
            goto HdI;
        }
        return false;
        HdI:
        goto SIx;
        obj:
    }
    function _make_odd()
    {
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                gmp_setbit($this->value, 0);
                goto b3E;
            case MATH_BIGINTEGER_MODE_BCMATH:
                if (!($this->value[strlen($this->value) - 1] % 2 == 0)) {
                    goto tX6;
                }
                $this->value = bcadd($this->value, "\x31");
                tX6:
                goto b3E;
            default:
                $this->value[0] |= 1;
        }
        ZOr1:
        b3E:
    }
    function isPrime($e9 = false)
    {
        $Yy = strlen($this->toBytes());
        if ($e9) {
            goto oDE;
        }
        if ($Yy >= 163) {
            goto VCG;
        }
        if ($Yy >= 106) {
            goto Iyr;
        }
        if ($Yy >= 81) {
            goto hCt;
        }
        if ($Yy >= 68) {
            goto HVM;
        }
        if ($Yy >= 56) {
            goto Qdz;
        }
        if ($Yy >= 50) {
            goto hKC;
        }
        if ($Yy >= 43) {
            goto qNx;
        }
        if ($Yy >= 37) {
            goto lZd;
        }
        if ($Yy >= 31) {
            goto xPF;
        }
        if ($Yy >= 25) {
            goto yCW;
        }
        if ($Yy >= 18) {
            goto jPZ;
        }
        $e9 = 27;
        goto kKU;
        jPZ:
        $e9 = 18;
        kKU:
        goto NO2;
        yCW:
        $e9 = 15;
        NO2:
        goto cXc;
        xPF:
        $e9 = 12;
        cXc:
        goto GeA;
        lZd:
        $e9 = 9;
        GeA:
        goto BZd;
        qNx:
        $e9 = 8;
        BZd:
        goto HNK;
        hKC:
        $e9 = 7;
        HNK:
        goto dW4;
        Qdz:
        $e9 = 6;
        dW4:
        goto CbO;
        HVM:
        $e9 = 5;
        CbO:
        goto Ugv;
        hCt:
        $e9 = 4;
        Ugv:
        goto sqE;
        Iyr:
        $e9 = 3;
        sqE:
        goto UDW;
        VCG:
        $e9 = 2;
        UDW:
        oDE:
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                return gmp_prob_prime($this->value, $e9) != 0;
            case MATH_BIGINTEGER_MODE_BCMATH:
                if (!($this->value === "\x32")) {
                    goto iZ9;
                }
                return true;
                iZ9:
                if (!($this->value[strlen($this->value) - 1] % 2 == 0)) {
                    goto KD1;
                }
                return false;
                KD1:
                goto nyL;
            default:
                if (!($this->value == array(2))) {
                    goto m44;
                }
                return true;
                m44:
                if (!(~$this->value[0] & 1)) {
                    goto YmL;
                }
                return false;
                YmL:
        }
        imd:
        nyL:
        static $I6, $Ms, $ix, $II;
        if (isset($I6)) {
            goto WVo;
        }
        $I6 = array(3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97, 101, 103, 107, 109, 113, 127, 131, 137, 139, 149, 151, 157, 163, 167, 173, 179, 181, 191, 193, 197, 199, 211, 223, 227, 229, 233, 239, 241, 251, 257, 263, 269, 271, 277, 281, 283, 293, 307, 311, 313, 317, 331, 337, 347, 349, 353, 359, 367, 373, 379, 383, 389, 397, 401, 409, 419, 421, 431, 433, 439, 443, 449, 457, 461, 463, 467, 479, 487, 491, 499, 503, 509, 521, 523, 541, 547, 557, 563, 569, 571, 577, 587, 593, 599, 601, 607, 613, 617, 619, 631, 641, 643, 647, 653, 659, 661, 673, 677, 683, 691, 701, 709, 719, 727, 733, 739, 743, 751, 757, 761, 769, 773, 787, 797, 809, 811, 821, 823, 827, 829, 839, 853, 857, 859, 863, 877, 881, 883, 887, 907, 911, 919, 929, 937, 941, 947, 953, 967, 971, 977, 983, 991, 997);
        if (!(MATH_BIGINTEGER_MODE != MATH_BIGINTEGER_MODE_INTERNAL)) {
            goto rta;
        }
        $MC = 0;
        zY0:
        if (!($MC < count($I6))) {
            goto XJH;
        }
        $I6[$MC] = new Math_BigInteger($I6[$MC]);
        pMW:
        ++$MC;
        goto zY0;
        XJH:
        rta:
        $Ms = new Math_BigInteger();
        $ix = new Math_BigInteger(1);
        $II = new Math_BigInteger(2);
        WVo:
        if (!$this->equals($ix)) {
            goto wUz;
        }
        return false;
        wUz:
        if (MATH_BIGINTEGER_MODE != MATH_BIGINTEGER_MODE_INTERNAL) {
            goto rrs;
        }
        $sw = $this->value;
        foreach ($I6 as $V6) {
            list(, $Y4) = $this->_divide_digit($sw, $V6);
            if ($Y4) {
                goto Ter;
            }
            return count($sw) == 1 && $sw[0] == $V6;
            Ter:
            Gr8:
        }
        WQ1:
        goto hD9;
        rrs:
        foreach ($I6 as $V6) {
            list(, $Y4) = $this->divide($V6);
            if (!$Y4->equals($Ms)) {
                goto DfF;
            }
            return $this->equals($V6);
            DfF:
            l9y:
        }
        ZTR:
        hD9:
        $lZ = $this->copy();
        $bM = $lZ->subtract($ix);
        $D4 = $lZ->subtract($II);
        $Y4 = $bM->copy();
        $T7 = $Y4->value;
        if (MATH_BIGINTEGER_MODE == MATH_BIGINTEGER_MODE_BCMATH) {
            goto qiY;
        }
        $MC = 0;
        $SQ = count($T7);
        JcD:
        if (!($MC < $SQ)) {
            goto p84;
        }
        $rd = ~$T7[$MC] & 16777215;
        $Jw = 1;
        v3Q:
        if (!($rd >> $Jw & 1)) {
            goto Es5;
        }
        v_s:
        ++$Jw;
        goto v3Q;
        Es5:
        if (!($Jw != 25)) {
            goto ec9;
        }
        goto p84;
        ec9:
        ODS:
        ++$MC;
        goto JcD;
        p84:
        $T6 = 26 * $MC + $Jw;
        $Y4->_rshift($T6);
        goto bOf;
        qiY:
        $T6 = 0;
        sAk:
        if (!($Y4->value[strlen($Y4->value) - 1] % 2 == 0)) {
            goto gr3;
        }
        $Y4->value = bcdiv($Y4->value, "\62", 0);
        ++$T6;
        goto sAk;
        gr3:
        bOf:
        $MC = 0;
        Vj9:
        if (!($MC < $e9)) {
            goto GVD;
        }
        $tt = $this->random($II, $D4);
        $mc = $tt->modPow($Y4, $lZ);
        if (!(!$mc->equals($ix) && !$mc->equals($bM))) {
            goto K1p;
        }
        $Jw = 1;
        ph0:
        if (!($Jw < $T6 && !$mc->equals($bM))) {
            goto kGk;
        }
        $mc = $mc->modPow($II, $lZ);
        if (!$mc->equals($ix)) {
            goto P7b;
        }
        return false;
        P7b:
        hMX:
        ++$Jw;
        goto ph0;
        kGk:
        if ($mc->equals($bM)) {
            goto E1r;
        }
        return false;
        E1r:
        K1p:
        QC4:
        ++$MC;
        goto Vj9;
        GVD:
        return true;
    }
    function _lshift($gm)
    {
        if (!($gm == 0)) {
            goto j8u;
        }
        return;
        j8u:
        $Na = (int) ($gm / MATH_BIGINTEGER_BASE);
        $gm %= MATH_BIGINTEGER_BASE;
        $gm = 1 << $gm;
        $Kh = 0;
        $MC = 0;
        K0u:
        if (!($MC < count($this->value))) {
            goto iyt;
        }
        $rd = $this->value[$MC] * $gm + $Kh;
        $Kh = MATH_BIGINTEGER_BASE === 26 ? intval($rd / 67108864) : $rd >> 31;
        $this->value[$MC] = (int) ($rd - $Kh * MATH_BIGINTEGER_BASE_FULL);
        rhV:
        ++$MC;
        goto K0u;
        iyt:
        if (!$Kh) {
            goto TgB;
        }
        $this->value[count($this->value)] = $Kh;
        TgB:
        Dl9:
        if (!$Na--) {
            goto oOF;
        }
        array_unshift($this->value, 0);
        goto Dl9;
        oOF:
    }
    function _rshift($gm)
    {
        if (!($gm == 0)) {
            goto upE;
        }
        return;
        upE:
        $Na = (int) ($gm / MATH_BIGINTEGER_BASE);
        $gm %= MATH_BIGINTEGER_BASE;
        $sR = MATH_BIGINTEGER_BASE - $gm;
        $fz = (1 << $gm) - 1;
        if (!$Na) {
            goto J58;
        }
        $this->value = array_slice($this->value, $Na);
        J58:
        $Kh = 0;
        $MC = count($this->value) - 1;
        aTv:
        if (!($MC >= 0)) {
            goto sGS;
        }
        $rd = $this->value[$MC] >> $gm | $Kh;
        $Kh = ($this->value[$MC] & $fz) << $sR;
        $this->value[$MC] = $rd;
        nnD:
        --$MC;
        goto aTv;
        sGS:
        $this->value = $this->_trim($this->value);
    }
    function _normalize($mE)
    {
        $mE->precision = $this->precision;
        $mE->bitmask = $this->bitmask;
        switch (MATH_BIGINTEGER_MODE) {
            case MATH_BIGINTEGER_MODE_GMP:
                if (!($this->bitmask !== false)) {
                    goto aZ1;
                }
                $mE->value = gmp_and($mE->value, $mE->bitmask->value);
                aZ1:
                return $mE;
            case MATH_BIGINTEGER_MODE_BCMATH:
                if (empty($mE->bitmask->value)) {
                    goto zOg;
                }
                $mE->value = bcmod($mE->value, $mE->bitmask->value);
                zOg:
                return $mE;
        }
        qpV:
        IrR:
        $sw =& $mE->value;
        if (count($sw)) {
            goto yJ7;
        }
        return $mE;
        yJ7:
        $sw = $this->_trim($sw);
        if (empty($mE->bitmask->value)) {
            goto KX7;
        }
        $Yy = min(count($sw), count($this->bitmask->value));
        $sw = array_slice($sw, 0, $Yy);
        $MC = 0;
        Lte:
        if (!($MC < $Yy)) {
            goto MxW;
        }
        $sw[$MC] = $sw[$MC] & $this->bitmask->value[$MC];
        Pnc:
        ++$MC;
        goto Lte;
        MxW:
        KX7:
        return $mE;
    }
    function _trim($sw)
    {
        $MC = count($sw) - 1;
        ZV_:
        if (!($MC >= 0)) {
            goto AMi;
        }
        if (!$sw[$MC]) {
            goto Sh8;
        }
        goto AMi;
        Sh8:
        unset($sw[$MC]);
        qmy:
        --$MC;
        goto ZV_;
        AMi:
        return $sw;
    }
    function _array_repeat($PG, $Lq)
    {
        return $Lq ? array_fill(0, $Lq, $PG) : array();
    }
    function _base256_lshift(&$hs, $gm)
    {
        if (!($gm == 0)) {
            goto S3M;
        }
        return;
        S3M:
        $ie = $gm >> 3;
        $gm &= 7;
        $Kh = 0;
        $MC = strlen($hs) - 1;
        tV3:
        if (!($MC >= 0)) {
            goto saa;
        }
        $rd = ord($hs[$MC]) << $gm | $Kh;
        $hs[$MC] = chr($rd);
        $Kh = $rd >> 8;
        LXC:
        --$MC;
        goto tV3;
        saa:
        $Kh = $Kh != 0 ? chr($Kh) : '';
        $hs = $Kh . $hs . str_repeat(chr(0), $ie);
    }
    function _base256_rshift(&$hs, $gm)
    {
        if (!($gm == 0)) {
            goto XMy;
        }
        $hs = ltrim($hs, chr(0));
        return '';
        XMy:
        $ie = $gm >> 3;
        $gm &= 7;
        $Qs = '';
        if (!$ie) {
            goto n1O;
        }
        $Mw = $ie > strlen($hs) ? -strlen($hs) : -$ie;
        $Qs = substr($hs, $Mw);
        $hs = substr($hs, 0, -$ie);
        n1O:
        $Kh = 0;
        $sR = 8 - $gm;
        $MC = 0;
        Gx5:
        if (!($MC < strlen($hs))) {
            goto zpI;
        }
        $rd = ord($hs[$MC]) >> $gm | $Kh;
        $Kh = ord($hs[$MC]) << $sR & 255;
        $hs[$MC] = chr($rd);
        c3q:
        ++$MC;
        goto Gx5;
        zpI:
        $hs = ltrim($hs, chr(0));
        $Qs = chr($Kh >> $sR) . $Qs;
        return ltrim($Qs, chr(0));
    }
    function _int2bytes($hs)
    {
        return ltrim(pack("\x4e", $hs), chr(0));
    }
    function _bytes2int($hs)
    {
        $rd = unpack("\116\151\x6e\164", str_pad($hs, 4, chr(0), STR_PAD_LEFT));
        return $rd["\151\156\x74"];
    }
    function _encodeASN1Length($Yy)
    {
        if (!($Yy <= 127)) {
            goto LcY;
        }
        return chr($Yy);
        LcY:
        $rd = ltrim(pack("\x4e", $Yy), chr(0));
        return pack("\103\141\x2a", 128 | strlen($rd), $rd);
    }
    function _safe_divide($hs, $mc)
    {
        if (!(MATH_BIGINTEGER_BASE === 26)) {
            goto dDD;
        }
        return (int) ($hs / $mc);
        dDD:
        return ($hs - $hs % $mc) / $mc;
    }
}
