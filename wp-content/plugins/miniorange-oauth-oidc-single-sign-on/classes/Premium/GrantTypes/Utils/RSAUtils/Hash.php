<?php


namespace MoOauthClient\GrantTypes;

define("\103\x52\131\x50\x54\x5f\110\x41\123\110\137\115\x4f\x44\105\x5f\x49\116\x54\105\122\x4e\x41\x4c", 1);
define("\x43\x52\x59\120\x54\x5f\x48\x41\x53\x48\137\115\x4f\x44\x45\137\x4d\110\x41\x53\x48", 2);
define("\103\122\131\x50\x54\137\110\x41\x53\x48\x5f\x4d\x4f\x44\105\137\110\x41\123\x48", 3);
class Crypt_Hash
{
    var $hashParam;
    var $b;
    var $l = false;
    var $hash;
    var $key = false;
    var $opad;
    var $ipad;
    function __construct($cQ = "\163\x68\141\x31")
    {
        if (defined("\x43\122\131\120\x54\x5f\x48\101\x53\110\x5f\x4d\x4f\x44\105")) {
            goto fA;
        }
        switch (true) {
            case extension_loaded("\150\141\x73\x68"):
                define("\103\x52\131\x50\124\137\110\101\x53\x48\x5f\115\117\x44\x45", CRYPT_HASH_MODE_HASH);
                goto cS;
            case extension_loaded("\x6d\x68\141\x73\x68"):
                define("\103\122\131\x50\x54\137\x48\101\123\110\x5f\115\117\104\x45", CRYPT_HASH_MODE_MHASH);
                goto cS;
            default:
                define("\103\122\131\x50\124\x5f\x48\x41\x53\x48\x5f\115\x4f\x44\x45", CRYPT_HASH_MODE_INTERNAL);
        }
        D3:
        cS:
        fA:
        $this->setHash($cQ);
    }
    function Crypt_Hash($cQ = "\163\150\141\61")
    {
        $this->__construct($cQ);
    }
    function setKey($qV = false)
    {
        $this->key = $qV;
    }
    function getHash()
    {
        return $this->hashParam;
    }
    function setHash($cQ)
    {
        $this->hashParam = $cQ = strtolower($cQ);
        switch ($cQ) {
            case "\x6d\144\x35\x2d\x39\x36":
            case "\x73\x68\x61\61\x2d\71\x36":
            case "\x73\x68\141\x32\65\x36\55\71\x36":
            case "\x73\x68\x61\65\x31\62\55\x39\x36":
                $cQ = substr($cQ, 0, -3);
                $this->l = 12;
                goto vj;
            case "\x6d\x64\62":
            case "\155\144\65":
                $this->l = 16;
                goto vj;
            case "\163\x68\x61\61":
                $this->l = 20;
                goto vj;
            case "\163\x68\x61\62\65\66":
                $this->l = 32;
                goto vj;
            case "\x73\150\141\x33\70\64":
                $this->l = 48;
                goto vj;
            case "\x73\x68\x61\x35\61\x32":
                $this->l = 64;
        }
        oO:
        vj:
        switch ($cQ) {
            case "\155\x64\62":
                $ke = CRYPT_HASH_MODE == CRYPT_HASH_MODE_HASH && in_array("\x6d\144\x32", hash_algos()) ? CRYPT_HASH_MODE_HASH : CRYPT_HASH_MODE_INTERNAL;
                goto q1;
            case "\x73\150\141\63\x38\x34":
            case "\163\x68\x61\x35\x31\x32":
                $ke = CRYPT_HASH_MODE == CRYPT_HASH_MODE_MHASH ? CRYPT_HASH_MODE_INTERNAL : CRYPT_HASH_MODE;
                goto q1;
            default:
                $ke = CRYPT_HASH_MODE;
        }
        P7:
        q1:
        switch ($ke) {
            case CRYPT_HASH_MODE_MHASH:
                switch ($cQ) {
                    case "\x6d\x64\x35":
                        $this->hash = MHASH_MD5;
                        goto w1;
                    case "\163\x68\x61\62\x35\66":
                        $this->hash = MHASH_SHA256;
                        goto w1;
                    case "\163\x68\x61\x31":
                    default:
                        $this->hash = MHASH_SHA1;
                }
                YD:
                w1:
                return;
            case CRYPT_HASH_MODE_HASH:
                switch ($cQ) {
                    case "\x6d\x64\65":
                        $this->hash = "\x6d\x64\x35";
                        return;
                    case "\x6d\144\62":
                    case "\163\150\x61\62\x35\x36":
                    case "\x73\150\141\63\70\x34":
                    case "\163\150\141\65\61\62":
                        $this->hash = $cQ;
                        return;
                    case "\x73\150\x61\61":
                    default:
                        $this->hash = "\163\x68\141\61";
                }
                Cc:
                vN:
                return;
        }
        ob:
        UG:
        switch ($cQ) {
            case "\x6d\x64\x32":
                $this->b = 16;
                $this->hash = array($this, "\137\155\x64\x32");
                goto QM;
            case "\x6d\x64\x35":
                $this->b = 64;
                $this->hash = array($this, "\137\155\x64\x35");
                goto QM;
            case "\x73\x68\x61\x32\x35\66":
                $this->b = 64;
                $this->hash = array($this, "\137\163\150\141\62\x35\66");
                goto QM;
            case "\x73\x68\x61\x33\x38\x34":
            case "\x73\x68\141\65\x31\62":
                $this->b = 128;
                $this->hash = array($this, "\x5f\163\150\x61\x35\61\62");
                goto QM;
            case "\163\x68\x61\61":
            default:
                $this->b = 64;
                $this->hash = array($this, "\x5f\x73\150\141\61");
        }
        VP:
        QM:
        $this->ipad = str_repeat(chr(54), $this->b);
        $this->opad = str_repeat(chr(92), $this->b);
    }
    function hash($bT)
    {
        $ke = is_array($this->hash) ? CRYPT_HASH_MODE_INTERNAL : CRYPT_HASH_MODE;
        if (!empty($this->key) || is_string($this->key)) {
            goto mW;
        }
        switch ($ke) {
            case CRYPT_HASH_MODE_MHASH:
                $li = mhash($this->hash, $bT);
                goto Ik;
            case CRYPT_HASH_MODE_HASH:
                $li = hash($this->hash, $bT, true);
                goto Ik;
            case CRYPT_HASH_MODE_INTERNAL:
                $li = call_user_func($this->hash, $bT);
        }
        NB:
        Ik:
        goto TM;
        mW:
        switch ($ke) {
            case CRYPT_HASH_MODE_MHASH:
                $li = mhash($this->hash, $bT, $this->key);
                goto SF;
            case CRYPT_HASH_MODE_HASH:
                $li = hash_hmac($this->hash, $bT, $this->key, true);
                goto SF;
            case CRYPT_HASH_MODE_INTERNAL:
                $qV = strlen($this->key) > $this->b ? call_user_func($this->hash, $this->key) : $this->key;
                $qV = str_pad($qV, $this->b, chr(0));
                $rd = $this->ipad ^ $qV;
                $rd .= $bT;
                $rd = call_user_func($this->hash, $rd);
                $li = $this->opad ^ $qV;
                $li .= $rd;
                $li = call_user_func($this->hash, $li);
        }
        lW:
        SF:
        TM:
        return substr($li, 0, $this->l);
    }
    function getLength()
    {
        return $this->l;
    }
    function _md5($pf)
    {
        return pack("\110\52", md5($pf));
    }
    function _sha1($pf)
    {
        return pack("\110\x2a", sha1($pf));
    }
    function _md2($pf)
    {
        static $T6 = array(41, 46, 67, 201, 162, 216, 124, 1, 61, 54, 84, 161, 236, 240, 6, 19, 98, 167, 5, 243, 192, 199, 115, 140, 152, 147, 43, 217, 188, 76, 130, 202, 30, 155, 87, 60, 253, 212, 224, 22, 103, 66, 111, 24, 138, 23, 229, 18, 190, 78, 196, 214, 218, 158, 222, 73, 160, 251, 245, 142, 187, 47, 238, 122, 169, 104, 121, 145, 21, 178, 7, 63, 148, 194, 16, 137, 11, 34, 95, 33, 128, 127, 93, 154, 90, 144, 50, 39, 53, 62, 204, 231, 191, 247, 151, 3, 255, 25, 48, 179, 72, 165, 181, 209, 215, 94, 146, 42, 172, 86, 170, 198, 79, 184, 56, 210, 150, 164, 125, 182, 118, 252, 107, 226, 156, 116, 4, 241, 69, 157, 112, 89, 100, 113, 135, 32, 134, 91, 207, 101, 230, 45, 168, 2, 27, 96, 37, 173, 174, 176, 185, 246, 28, 70, 97, 105, 52, 64, 126, 15, 85, 71, 163, 35, 221, 81, 175, 58, 195, 92, 249, 206, 186, 197, 234, 38, 44, 83, 13, 110, 133, 40, 132, 9, 211, 223, 205, 244, 65, 129, 77, 82, 106, 220, 55, 200, 108, 193, 171, 250, 36, 225, 123, 8, 12, 189, 177, 74, 120, 136, 149, 139, 227, 99, 232, 109, 233, 203, 213, 254, 59, 0, 29, 57, 242, 239, 183, 14, 102, 88, 208, 228, 166, 119, 114, 248, 235, 117, 75, 10, 49, 68, 80, 180, 143, 237, 31, 26, 219, 153, 141, 51, 159, 17, 131, 20);
        $EY = 16 - (strlen($pf) & 15);
        $pf .= str_repeat(chr($EY), $EY);
        $Yy = strlen($pf);
        $Wx = str_repeat(chr(0), 16);
        $L0 = chr(0);
        $MC = 0;
        x8:
        if (!($MC < $Yy)) {
            goto vq;
        }
        $Jw = 0;
        r4:
        if (!($Jw < 16)) {
            goto qS;
        }
        $Wx[$Jw] = chr($T6[ord($pf[$MC + $Jw] ^ $L0)] ^ ord($Wx[$Jw]));
        $L0 = $Wx[$Jw];
        oR1:
        $Jw++;
        goto r4;
        qS:
        wV:
        $MC += 16;
        goto x8;
        vq:
        $pf .= $Wx;
        $Yy += 16;
        $hs = str_repeat(chr(0), 48);
        $MC = 0;
        LG:
        if (!($MC < $Yy)) {
            goto gq;
        }
        $Jw = 0;
        pw:
        if (!($Jw < 16)) {
            goto vS;
        }
        $hs[$Jw + 16] = $pf[$MC + $Jw];
        $hs[$Jw + 32] = $hs[$Jw + 16] ^ $hs[$Jw];
        Gl:
        $Jw++;
        goto pw;
        vS:
        $e9 = chr(0);
        $Jw = 0;
        NZ:
        if (!($Jw < 18)) {
            goto Wf;
        }
        $bz = 0;
        rU:
        if (!($bz < 48)) {
            goto gf;
        }
        $hs[$bz] = $e9 = $hs[$bz] ^ chr($T6[ord($e9)]);
        L8:
        $bz++;
        goto rU;
        gf:
        $e9 = chr(ord($e9) + $Jw);
        Zj:
        $Jw++;
        goto NZ;
        Wf:
        gA:
        $MC += 16;
        goto LG;
        gq:
        return substr($hs, 0, 16);
    }
    function _sha256($pf)
    {
        if (!extension_loaded("\x73\165\x68\157\x73\151\156")) {
            goto Js;
        }
        return pack("\x48\x2a", sha256($pf));
        Js:
        $cQ = array(1779033703, 3144134277, 1013904242, 2773480762, 1359893119, 2600822924, 528734635, 1541459225);
        static $bz = array(1116352408, 1899447441, 3049323471, 3921009573, 961987163, 1508970993, 2453635748, 2870763221, 3624381080, 310598401, 607225278, 1426881987, 1925078388, 2162078206, 2614888103, 3248222580, 3835390401, 4022224774, 264347078, 604807628, 770255983, 1249150122, 1555081692, 1996064986, 2554220882, 2821834349, 2952996808, 3210313671, 3336571891, 3584528711, 113926993, 338241895, 666307205, 773529912, 1294757372, 1396182291, 1695183700, 1986661051, 2177026350, 2456956037, 2730485921, 2820302411, 3259730800, 3345764771, 3516065817, 3600352804, 4094571909, 275423344, 430227734, 506948616, 659060556, 883997877, 958139571, 1322822218, 1537002063, 1747873779, 1955562222, 2024104815, 2227730452, 2361852424, 2428436474, 2756734187, 3204031479, 3329325298);
        $Yy = strlen($pf);
        $pf .= str_repeat(chr(0), 64 - ($Yy + 8 & 63));
        $pf[$Yy] = chr(128);
        $pf .= pack("\x4e\62", 0, $Yy << 3);
        $uG = str_split($pf, 64);
        foreach ($uG as $de) {
            $o8 = array();
            $MC = 0;
            wg:
            if (!($MC < 16)) {
                goto xv;
            }
            extract(unpack("\116\x74\145\155\160", $this->_string_shift($de, 4)));
            $o8[] = $rd;
            b9:
            $MC++;
            goto wg;
            xv:
            $MC = 16;
            nU:
            if (!($MC < 64)) {
                goto Av;
            }
            $LK = $this->_rightRotate($o8[$MC - 15], 7) ^ $this->_rightRotate($o8[$MC - 15], 18) ^ $this->_rightShift($o8[$MC - 15], 3);
            $ch = $this->_rightRotate($o8[$MC - 2], 17) ^ $this->_rightRotate($o8[$MC - 2], 19) ^ $this->_rightShift($o8[$MC - 2], 10);
            $o8[$MC] = $this->_add($o8[$MC - 16], $LK, $o8[$MC - 7], $ch);
            NL:
            $MC++;
            goto nU;
            Av:
            list($tt, $Uj, $Wx, $Hk, $yh, $WW, $Zq, $NK) = $cQ;
            $MC = 0;
            LD:
            if (!($MC < 64)) {
                goto NV;
            }
            $LK = $this->_rightRotate($tt, 2) ^ $this->_rightRotate($tt, 13) ^ $this->_rightRotate($tt, 22);
            $HZ = $tt & $Uj ^ $tt & $Wx ^ $Uj & $Wx;
            $OT = $this->_add($LK, $HZ);
            $ch = $this->_rightRotate($yh, 6) ^ $this->_rightRotate($yh, 11) ^ $this->_rightRotate($yh, 25);
            $Kl = $yh & $WW ^ $this->_not($yh) & $Zq;
            $WR = $this->_add($NK, $ch, $Kl, $bz[$MC], $o8[$MC]);
            $NK = $Zq;
            $Zq = $WW;
            $WW = $yh;
            $yh = $this->_add($Hk, $WR);
            $Hk = $Wx;
            $Wx = $Uj;
            $Uj = $tt;
            $tt = $this->_add($WR, $OT);
            el:
            $MC++;
            goto LD;
            NV:
            $cQ = array($this->_add($cQ[0], $tt), $this->_add($cQ[1], $Uj), $this->_add($cQ[2], $Wx), $this->_add($cQ[3], $Hk), $this->_add($cQ[4], $yh), $this->_add($cQ[5], $WW), $this->_add($cQ[6], $Zq), $this->_add($cQ[7], $NK));
            CI:
        }
        un:
        return pack("\116\x38", $cQ[0], $cQ[1], $cQ[2], $cQ[3], $cQ[4], $cQ[5], $cQ[6], $cQ[7]);
    }
    function _sha512($pf)
    {
        if (class_exists("\x4d\141\x74\150\137\102\151\x67\111\156\164\x65\x67\145\162")) {
            goto Fh;
        }
        include_once "\x4d\141\x74\150\57\x42\151\147\x49\x6e\164\x65\147\145\162\56\x70\150\160";
        Fh:
        static $ur, $vZ, $bz;
        if (isset($bz)) {
            goto Uw;
        }
        $ur = array("\143\142\142\x62\x39\144\x35\144\143\61\x30\65\71\x65\x64\x38", "\66\x32\x39\141\x32\x39\62\x61\x33\x36\67\x63\x64\x35\60\x37", "\x39\61\65\x39\60\x31\65\x61\x33\x30\67\60\144\x64\x31\x37", "\61\65\62\x66\x65\143\144\70\146\x37\60\x65\x35\x39\63\71", "\66\x37\x33\63\62\x36\66\67\146\146\x63\60\60\x62\x33\x31", "\70\145\142\64\x34\x61\x38\x37\66\70\65\x38\x31\x35\x31\x31", "\144\x62\x30\x63\62\x65\x30\144\x36\64\x66\71\x38\146\141\x37", "\64\x37\x62\x35\64\x38\61\144\142\x65\x66\x61\x34\x66\141\64");
        $vZ = array("\x36\141\x30\x39\145\66\66\x37\x66\63\x62\x63\x63\71\60\x38", "\142\x62\66\x37\x61\145\x38\65\70\x34\x63\x61\141\67\x33\142", "\x33\x63\66\145\146\63\67\x32\x66\145\x39\64\146\x38\x32\x62", "\x61\x35\64\x66\x66\65\63\x61\65\x66\x31\x64\63\x36\x66\x31", "\65\x31\60\145\x35\62\67\146\141\144\145\66\70\x32\x64\61", "\71\142\60\x35\66\x38\70\143\x32\142\63\x65\x36\143\61\146", "\x31\x66\x38\x33\144\71\x61\142\146\142\64\61\142\x64\x36\142", "\65\x62\145\x30\x63\x64\61\x39\61\x33\x37\x65\x32\x31\x37\71");
        $MC = 0;
        vn:
        if (!($MC < 8)) {
            goto yn;
        }
        $ur[$MC] = new Math_BigInteger($ur[$MC], 16);
        $ur[$MC]->setPrecision(64);
        $vZ[$MC] = new Math_BigInteger($vZ[$MC], 16);
        $vZ[$MC]->setPrecision(64);
        JJ:
        $MC++;
        goto vn;
        yn:
        $bz = array("\64\62\x38\141\62\146\x39\70\144\x37\x32\70\x61\x65\62\62", "\67\x31\63\x37\64\x34\71\61\x32\x33\145\146\66\65\143\144", "\142\65\x63\x30\x66\x62\x63\146\x65\143\x34\x64\63\x62\62\146", "\145\x39\x62\x35\144\142\x61\x35\70\61\x38\x39\x64\x62\x62\143", "\63\x39\65\x36\x63\x32\x35\142\146\63\64\x38\142\x35\63\70", "\x35\71\146\x31\x31\61\146\61\x62\66\x30\x35\144\x30\x31\71", "\71\x32\x33\x66\70\62\x61\x34\x61\146\x31\x39\x34\x66\71\x62", "\141\142\61\143\x35\x65\144\x35\144\x61\66\x64\x38\x31\x31\x38", "\144\x38\x30\67\141\x61\x39\70\141\x33\x30\63\60\62\x34\x32", "\61\62\70\x33\x35\x62\x30\61\x34\65\67\x30\x36\146\142\x65", "\62\x34\63\x31\x38\65\x62\x65\64\x65\x65\64\x62\62\x38\143", "\65\x35\x30\x63\x37\144\x63\x33\144\65\x66\x66\x62\x34\145\x32", "\x37\x32\142\x65\x35\144\x37\x34\x66\62\67\142\70\x39\66\146", "\x38\x30\144\145\x62\x31\x66\x65\x33\142\61\x36\x39\66\x62\x31", "\71\142\144\x63\60\x36\141\67\62\x35\143\x37\x31\x32\63\x35", "\143\x31\71\x62\146\x31\x37\x34\143\x66\x36\71\x32\x36\x39\x34", "\145\x34\71\142\x36\x39\143\x31\x39\x65\146\61\x34\x61\x64\x32", "\145\x66\142\x65\x34\x37\x38\x36\x33\70\64\x66\62\65\x65\63", "\60\x66\143\61\71\144\143\x36\70\x62\x38\x63\144\65\x62\65", "\x32\x34\x30\143\x61\61\x63\x63\67\x37\x61\x63\71\x63\66\x35", "\62\x64\x65\x39\62\143\x36\146\x35\71\x32\x62\60\62\x37\x35", "\64\141\x37\x34\70\64\x61\141\x36\145\141\66\145\x34\70\63", "\65\x63\142\60\141\x39\144\143\142\x64\x34\x31\146\142\144\64", "\x37\x36\146\x39\70\70\x64\141\x38\x33\61\x31\65\x33\x62\x35", "\x39\x38\x33\145\x35\61\x35\62\x65\145\x36\66\x64\x66\x61\x62", "\x61\x38\x33\x31\143\66\66\144\62\144\142\64\63\x32\61\x30", "\x62\60\x30\x33\62\x37\143\70\71\70\146\x62\x32\61\x33\146", "\x62\146\65\x39\67\146\143\x37\x62\x65\x65\x66\60\x65\145\64", "\x63\66\x65\x30\60\142\x66\63\x33\144\141\x38\x38\146\143\x32", "\144\x35\141\67\71\61\64\x37\71\x33\60\x61\141\67\x32\65", "\x30\66\x63\x61\66\x33\x35\61\145\x30\x30\x33\70\62\66\x66", "\61\x34\x32\x39\x32\x39\x36\x37\60\x61\x30\145\x36\145\x37\x30", "\x32\x37\142\67\60\x61\x38\65\x34\66\144\x32\x32\146\x66\x63", "\62\145\x31\142\x32\x31\x33\70\65\143\62\x36\143\71\x32\66", "\64\x64\62\x63\x36\144\146\143\x35\141\x63\64\62\x61\145\x64", "\x35\63\x33\70\60\x64\61\63\x39\144\x39\65\142\63\x64\146", "\66\65\x30\x61\x37\x33\x35\x34\70\x62\141\146\x36\63\x64\x65", "\x37\x36\66\x61\x30\x61\142\142\x33\143\x37\67\142\x32\x61\70", "\x38\61\x63\x32\x63\71\x32\x65\64\67\x65\144\x61\145\x65\66", "\71\x32\67\x32\62\143\70\65\61\x34\x38\x32\63\65\63\x62", "\x61\x32\x62\146\145\70\141\x31\64\x63\x66\61\60\63\66\x34", "\141\70\x31\141\x36\66\64\142\x62\x63\64\x32\x33\60\60\x31", "\x63\62\64\142\x38\142\x37\60\x64\x30\x66\x38\x39\x37\71\x31", "\x63\67\66\x63\65\x31\x61\63\60\66\x35\x34\x62\x65\x33\x30", "\144\61\71\62\145\70\x31\71\144\66\145\x66\65\62\61\x38", "\x64\x36\71\x39\60\x36\62\64\65\x35\66\65\x61\x39\61\x30", "\x66\64\x30\145\x33\x35\70\65\65\x37\67\x31\x32\60\x32\x61", "\x31\60\66\141\x61\60\x37\x30\x33\62\142\x62\144\61\x62\x38", "\61\71\141\64\143\61\61\66\142\x38\144\x32\x64\x30\143\70", "\61\x65\63\67\x36\143\60\70\x35\61\64\x31\x61\x62\x35\x33", "\x32\67\64\70\x37\x37\64\x63\x64\146\x38\x65\145\x62\x39\x39", "\63\x34\142\x30\142\x63\x62\65\x65\61\71\x62\x34\x38\x61\x38", "\63\71\61\143\x30\143\x62\x33\143\65\x63\71\x35\141\x36\63", "\64\145\x64\70\141\x61\64\141\145\x33\x34\61\70\141\x63\142", "\65\142\71\x63\x63\x61\64\x66\x37\x37\66\63\x65\63\x37\63", "\66\70\62\x65\66\x66\146\x33\x64\66\142\62\x62\70\141\63", "\x37\64\70\x66\70\62\145\x65\65\144\145\x66\x62\x32\x66\143", "\x37\70\x61\65\66\63\x36\146\x34\x33\61\x37\62\146\66\60", "\70\x34\x63\70\x37\70\x31\64\x61\61\146\x30\141\142\67\62", "\x38\x63\x63\x37\x30\62\x30\x38\61\x61\66\x34\63\71\145\143", "\71\x30\x62\x65\146\146\x66\x61\62\x33\66\63\x31\145\x32\x38", "\141\x34\x35\x30\x36\143\x65\x62\144\x65\x38\x32\x62\x64\145\x39", "\x62\145\146\71\x61\x33\146\x37\142\x32\143\x36\67\71\61\x35", "\143\66\x37\x31\x37\x38\x66\x32\145\x33\67\x32\65\x33\62\x62", "\x63\141\x32\67\x33\x65\x63\x65\x65\141\x32\x36\66\61\x39\143", "\x64\x31\x38\66\x62\70\x63\67\x32\61\x63\x30\x63\x32\60\x37", "\x65\141\x64\x61\67\144\144\66\x63\144\x65\60\145\142\x31\145", "\x66\65\x37\144\x34\x66\x37\146\145\x65\x36\145\x64\61\x37\70", "\x30\66\146\60\66\x37\141\x61\67\62\x31\x37\x36\x66\x62\x61", "\60\x61\x36\x33\67\x64\143\x35\141\62\143\x38\x39\70\141\x36", "\x31\61\x33\x66\x39\70\60\x34\x62\145\x66\x39\60\x64\141\145", "\61\x62\67\x31\60\142\63\x35\x31\x33\61\143\x34\67\x31\x62", "\62\x38\144\142\67\x37\146\x35\x32\x33\60\64\x37\144\x38\x34", "\63\62\143\x61\141\142\67\x62\64\60\143\x37\62\64\x39\x33", "\63\143\x39\x65\x62\x65\x30\x61\x31\65\x63\x39\142\x65\x62\143", "\x34\x33\61\144\66\67\x63\x34\71\143\61\60\x30\144\x34\143", "\64\143\x63\x35\x64\x34\x62\x65\143\x62\63\145\x34\62\x62\x36", "\65\71\67\x66\x32\x39\x39\143\146\143\66\65\x37\x65\62\141", "\65\x66\143\x62\x36\146\x61\x62\63\141\x64\66\146\141\x65\x63", "\66\x63\64\64\61\71\70\143\x34\141\64\x37\65\x38\x31\x37");
        $MC = 0;
        Zn:
        if (!($MC < 80)) {
            goto ps;
        }
        $bz[$MC] = new Math_BigInteger($bz[$MC], 16);
        vs:
        $MC++;
        goto Zn;
        ps:
        Uw:
        $cQ = $this->l == 48 ? $ur : $vZ;
        $Yy = strlen($pf);
        $pf .= str_repeat(chr(0), 128 - ($Yy + 16 & 127));
        $pf[$Yy] = chr(128);
        $pf .= pack("\116\64", 0, 0, 0, $Yy << 3);
        $uG = str_split($pf, 128);
        foreach ($uG as $de) {
            $o8 = array();
            $MC = 0;
            Ml:
            if (!($MC < 16)) {
                goto mA;
            }
            $rd = new Math_BigInteger($this->_string_shift($de, 8), 256);
            $rd->setPrecision(64);
            $o8[] = $rd;
            hN:
            $MC++;
            goto Ml;
            mA:
            $MC = 16;
            Do1:
            if (!($MC < 80)) {
                goto T3;
            }
            $rd = array($o8[$MC - 15]->bitwise_rightRotate(1), $o8[$MC - 15]->bitwise_rightRotate(8), $o8[$MC - 15]->bitwise_rightShift(7));
            $LK = $rd[0]->bitwise_xor($rd[1]);
            $LK = $LK->bitwise_xor($rd[2]);
            $rd = array($o8[$MC - 2]->bitwise_rightRotate(19), $o8[$MC - 2]->bitwise_rightRotate(61), $o8[$MC - 2]->bitwise_rightShift(6));
            $ch = $rd[0]->bitwise_xor($rd[1]);
            $ch = $ch->bitwise_xor($rd[2]);
            $o8[$MC] = $o8[$MC - 16]->copy();
            $o8[$MC] = $o8[$MC]->add($LK);
            $o8[$MC] = $o8[$MC]->add($o8[$MC - 7]);
            $o8[$MC] = $o8[$MC]->add($ch);
            LY:
            $MC++;
            goto Do1;
            T3:
            $tt = $cQ[0]->copy();
            $Uj = $cQ[1]->copy();
            $Wx = $cQ[2]->copy();
            $Hk = $cQ[3]->copy();
            $yh = $cQ[4]->copy();
            $WW = $cQ[5]->copy();
            $Zq = $cQ[6]->copy();
            $NK = $cQ[7]->copy();
            $MC = 0;
            Le:
            if (!($MC < 80)) {
                goto XA;
            }
            $rd = array($tt->bitwise_rightRotate(28), $tt->bitwise_rightRotate(34), $tt->bitwise_rightRotate(39));
            $LK = $rd[0]->bitwise_xor($rd[1]);
            $LK = $LK->bitwise_xor($rd[2]);
            $rd = array($tt->bitwise_and($Uj), $tt->bitwise_and($Wx), $Uj->bitwise_and($Wx));
            $HZ = $rd[0]->bitwise_xor($rd[1]);
            $HZ = $HZ->bitwise_xor($rd[2]);
            $OT = $LK->add($HZ);
            $rd = array($yh->bitwise_rightRotate(14), $yh->bitwise_rightRotate(18), $yh->bitwise_rightRotate(41));
            $ch = $rd[0]->bitwise_xor($rd[1]);
            $ch = $ch->bitwise_xor($rd[2]);
            $rd = array($yh->bitwise_and($WW), $Zq->bitwise_and($yh->bitwise_not()));
            $Kl = $rd[0]->bitwise_xor($rd[1]);
            $WR = $NK->add($ch);
            $WR = $WR->add($Kl);
            $WR = $WR->add($bz[$MC]);
            $WR = $WR->add($o8[$MC]);
            $NK = $Zq->copy();
            $Zq = $WW->copy();
            $WW = $yh->copy();
            $yh = $Hk->add($WR);
            $Hk = $Wx->copy();
            $Wx = $Uj->copy();
            $Uj = $tt->copy();
            $tt = $WR->add($OT);
            V0:
            $MC++;
            goto Le;
            XA:
            $cQ = array($cQ[0]->add($tt), $cQ[1]->add($Uj), $cQ[2]->add($Wx), $cQ[3]->add($Hk), $cQ[4]->add($yh), $cQ[5]->add($WW), $cQ[6]->add($Zq), $cQ[7]->add($NK));
            VS:
        }
        H8:
        $rd = $cQ[0]->toBytes() . $cQ[1]->toBytes() . $cQ[2]->toBytes() . $cQ[3]->toBytes() . $cQ[4]->toBytes() . $cQ[5]->toBytes();
        if (!($this->l != 48)) {
            goto h4;
        }
        $rd .= $cQ[6]->toBytes() . $cQ[7]->toBytes();
        h4:
        return $rd;
    }
    function _rightRotate($HK, $wI)
    {
        $ry = 32 - $wI;
        $sU = (1 << $ry) - 1;
        return $HK << $ry & 4294967295 | $HK >> $wI & $sU;
    }
    function _rightShift($HK, $wI)
    {
        $sU = (1 << 32 - $wI) - 1;
        return $HK >> $wI & $sU;
    }
    function _not($HK)
    {
        return ~$HK & 4294967295;
    }
    function _add()
    {
        static $VT;
        if (isset($VT)) {
            goto p4;
        }
        $VT = pow(2, 32);
        p4:
        $mE = 0;
        $kI = func_get_args();
        foreach ($kI as $wX) {
            $mE += $wX < 0 ? ($wX & 2147483647) + 2147483648 : $wX;
            y3:
        }
        di:
        switch (true) {
            case is_int($mE):
            case version_compare(PHP_VERSION, "\x35\x2e\x33\x2e\x30") >= 0 && (php_uname("\155") & "\337\xdf\337") != "\101\x52\115":
            case (PHP_OS & "\xdf\xdf\337") === "\x57\x49\x4e":
                return fmod($mE, $VT);
        }
        LI:
        yl:
        return fmod($mE, 2147483648) & 2147483647 | (fmod(floor($mE / 2147483648), 2) & 1) << 31;
    }
    function _string_shift(&$Fp, $iN = 1)
    {
        $Mq = substr($Fp, 0, $iN);
        $Fp = substr($Fp, $iN);
        return $Mq;
    }
}
