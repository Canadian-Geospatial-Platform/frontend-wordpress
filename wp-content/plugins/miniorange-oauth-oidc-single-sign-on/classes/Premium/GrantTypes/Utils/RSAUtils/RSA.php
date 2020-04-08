<?php


namespace MoOauthClient\GrantTypes;

if (function_exists("\x63\162\x79\x70\164\x5f\162\141\156\144\157\x6d\137\x73\164\x72\x69\x6e\x67")) {
    goto k3;
}
include_once "\x52\141\x6e\144\157\x6d\x2e\x70\x68\160";
k3:
if (class_exists("\103\x72\x79\160\x74\137\110\x61\x73\x68")) {
    goto Y0;
}
include_once "\110\141\x73\x68\x2e\160\x68\x70";
Y0:
define("\x43\x52\x59\120\124\x5f\x52\123\x41\137\x45\x4e\x43\x52\x59\120\124\x49\117\116\137\117\101\x45\x50", 1);
define("\103\122\131\x50\x54\x5f\x52\123\101\x5f\x45\116\103\122\x59\x50\x54\111\x4f\116\137\120\113\103\x53\61", 2);
define("\x43\122\x59\120\x54\137\122\123\x41\137\x45\116\103\x52\x59\x50\124\111\117\x4e\137\116\117\116\x45", 3);
define("\x43\122\131\120\124\137\x52\123\101\137\x53\111\107\116\x41\124\125\x52\105\x5f\120\123\x53", 1);
define("\x43\122\131\120\124\137\122\x53\101\137\123\111\107\x4e\101\x54\x55\122\105\x5f\x50\x4b\103\123\61", 2);
define("\x43\122\x59\120\124\x5f\x52\x53\101\137\101\123\116\61\x5f\x49\116\x54\105\x47\x45\x52", 2);
define("\x43\122\131\x50\x54\x5f\x52\123\x41\137\x41\123\x4e\61\x5f\102\111\124\123\x54\x52\111\x4e\x47", 3);
define("\103\x52\x59\x50\x54\137\x52\123\101\x5f\x41\123\116\x31\137\x4f\103\124\105\124\123\x54\122\x49\x4e\107", 4);
define("\x43\122\x59\120\x54\137\122\123\x41\137\x41\x53\x4e\x31\x5f\x4f\x42\112\105\103\x54", 6);
define("\103\x52\x59\120\124\137\x52\x53\x41\x5f\x41\123\x4e\x31\137\123\105\121\x55\x45\x4e\103\x45", 48);
define("\x43\x52\131\120\x54\x5f\x52\123\101\x5f\115\x4f\x44\105\137\111\x4e\124\105\122\x4e\101\x4c", 1);
define("\103\122\x59\x50\124\137\x52\x53\101\137\115\117\x44\x45\x5f\x4f\120\105\116\123\123\x4c", 2);
define("\x43\122\x59\120\124\137\x52\123\101\137\x4f\x50\x45\116\123\x53\114\137\x43\x4f\x4e\x46\111\107", dirname(__FILE__) . "\x2f\x2e\56\57\x6f\x70\x65\x6e\163\163\154\56\x63\x6e\146");
define("\103\122\131\120\124\x5f\122\123\x41\137\x50\122\x49\x56\101\x54\105\x5f\106\117\x52\115\101\x54\137\120\113\x43\123\x31", 0);
define("\103\x52\131\120\124\x5f\x52\x53\x41\x5f\120\122\111\x56\101\124\x45\x5f\106\x4f\122\115\x41\x54\137\120\x55\124\x54\x59", 1);
define("\x43\x52\131\120\x54\x5f\122\123\101\x5f\x50\122\x49\x56\101\124\x45\x5f\x46\x4f\x52\x4d\x41\124\137\x58\x4d\x4c", 2);
define("\x43\122\x59\x50\x54\137\122\x53\x41\137\120\x52\x49\x56\x41\x54\105\137\x46\x4f\122\x4d\x41\x54\x5f\120\x4b\x43\x53\70", 8);
define("\103\x52\x59\120\124\137\122\123\x41\137\x50\125\102\114\111\103\137\x46\x4f\x52\x4d\101\124\x5f\122\101\127", 3);
define("\103\x52\x59\x50\124\x5f\x52\x53\x41\137\120\125\102\114\x49\103\137\x46\x4f\x52\x4d\101\124\137\x50\113\103\x53\x31", 4);
define("\x43\x52\x59\120\124\137\x52\123\101\137\120\x55\102\x4c\111\103\x5f\106\117\122\x4d\101\x54\x5f\x50\113\x43\x53\61\137\x52\101\127", 4);
define("\103\122\x59\120\x54\137\122\123\101\x5f\x50\125\102\x4c\x49\x43\x5f\x46\117\122\x4d\101\124\x5f\x58\115\x4c", 5);
define("\x43\x52\x59\120\124\x5f\122\123\x41\137\x50\x55\x42\114\x49\x43\137\106\x4f\x52\115\x41\x54\137\117\120\105\x4e\x53\123\110", 6);
define("\x43\122\131\120\124\x5f\122\x53\x41\137\120\x55\x42\114\111\x43\x5f\106\117\x52\115\101\124\x5f\120\x4b\103\x53\x38", 7);
class Crypt_RSA
{
    var $zero;
    var $one;
    var $privateKeyFormat = CRYPT_RSA_PRIVATE_FORMAT_PKCS1;
    var $publicKeyFormat = CRYPT_RSA_PUBLIC_FORMAT_PKCS8;
    var $modulus;
    var $k;
    var $exponent;
    var $primes;
    var $exponents;
    var $coefficients;
    var $hashName;
    var $hash;
    var $hLen;
    var $sLen;
    var $mgfHash;
    var $mgfHLen;
    var $encryptionMode = CRYPT_RSA_ENCRYPTION_OAEP;
    var $signatureMode = CRYPT_RSA_SIGNATURE_PSS;
    var $publicExponent = false;
    var $password = false;
    var $components = array();
    var $current;
    var $configFile;
    var $comment = "\x70\150\160\163\x65\143\154\151\142\x2d\147\145\156\145\x72\141\x74\x65\x64\x2d\x6b\145\171";
    function __construct()
    {
        if (class_exists("\115\x61\164\x68\x5f\x42\151\147\x49\156\164\145\x67\x65\162")) {
            goto da;
        }
        include_once dirname(__FILE__) . "\57\115\141\164\x68\x2f\x42\x69\x67\111\156\164\x65\x67\x65\x72\56\x70\150\x70";
        da:
        $this->configFile = CRYPT_RSA_OPENSSL_CONFIG;
        if (defined("\x43\x52\131\120\x54\x5f\122\123\101\137\x4d\117\x44\105")) {
            goto Pr;
        }
        switch (true) {
            case defined("\x4d\x41\124\x48\x5f\102\111\x47\111\116\x54\x45\x47\105\x52\x5f\117\x50\x45\x4e\x53\123\114\137\104\111\x53\x41\102\114\105"):
                define("\103\x52\131\120\x54\137\x52\x53\101\137\x4d\x4f\104\x45", CRYPT_RSA_MODE_INTERNAL);
                goto Hn;
            case !function_exists("\157\160\145\156\163\163\x6c\x5f\x70\153\145\x79\137\x67\x65\164\137\144\x65\x74\141\151\x6c\x73"):
                define("\103\122\x59\120\124\137\x52\123\101\137\115\x4f\x44\105", CRYPT_RSA_MODE_INTERNAL);
                goto Hn;
            case extension_loaded("\157\x70\x65\x6e\163\x73\154") && version_compare(PHP_VERSION, "\x34\56\x32\56\60", "\76\x3d") && file_exists($this->configFile):
                ob_start();
                @phpinfo();
                $PI = ob_get_contents();
                ob_end_clean();
                preg_match_all("\x23\x4f\x70\145\156\x53\x53\114\40\50\x48\x65\141\144\145\x72\174\x4c\x69\x62\162\141\162\171\x29\40\x56\145\x72\163\151\157\x6e\x28\56\x2a\x29\x23\151\x6d", $PI, $W4);
                $ZU = array();
                if (empty($W4[1])) {
                    goto LQ;
                }
                $MC = 0;
                Ys:
                if (!($MC < count($W4[1]))) {
                    goto Io;
                }
                $MS = trim(str_replace("\75\76", '', strip_tags($W4[2][$MC])));
                if (!preg_match("\57\50\x5c\144\x2b\134\56\134\144\53\x5c\56\x5c\144\53\x29\57\x69", $MS, $pf)) {
                    goto xu;
                }
                $ZU[$W4[1][$MC]] = $pf[0];
                goto EV;
                xu:
                $ZU[$W4[1][$MC]] = $MS;
                EV:
                Wa:
                $MC++;
                goto Ys;
                Io:
                LQ:
                switch (true) {
                    case !isset($ZU["\x48\x65\x61\x64\145\162"]):
                    case !isset($ZU["\x4c\151\x62\162\141\x72\x79"]):
                    case $ZU["\x48\145\x61\144\145\x72"] == $ZU["\114\x69\142\x72\x61\162\x79"]:
                    case version_compare($ZU["\x48\x65\x61\144\145\x72"], "\x31\x2e\60\x2e\x30") >= 0 && version_compare($ZU["\x4c\x69\142\x72\141\162\171"], "\x31\56\60\x2e\x30") >= 0:
                        define("\103\x52\x59\120\x54\x5f\122\x53\x41\137\115\x4f\104\105", CRYPT_RSA_MODE_OPENSSL);
                        goto Dq;
                    default:
                        define("\103\122\131\120\x54\x5f\x52\123\101\137\115\117\x44\x45", CRYPT_RSA_MODE_INTERNAL);
                        define("\x4d\101\124\110\137\102\111\x47\x49\x4e\124\x45\107\105\x52\137\117\120\x45\116\x53\x53\114\137\104\111\123\x41\x42\x4c\x45", true);
                }
                Va:
                Dq:
                goto Hn;
            default:
                define("\x43\x52\131\120\124\x5f\x52\x53\x41\x5f\x4d\117\x44\x45", CRYPT_RSA_MODE_INTERNAL);
        }
        vA:
        Hn:
        Pr:
        $this->zero = new Math_BigInteger();
        $this->one = new Math_BigInteger(1);
        $this->hash = new Crypt_Hash("\x73\x68\x61\61");
        $this->hLen = $this->hash->getLength();
        $this->hashName = "\x73\150\x61\61";
        $this->mgfHash = new Crypt_Hash("\x73\150\141\61");
        $this->mgfHLen = $this->mgfHash->getLength();
    }
    function Crypt_RSA()
    {
        $this->__construct();
    }
    function createKey($Hg = 1024, $nz = false, $an = array())
    {
        if (defined("\103\x52\131\120\124\x5f\122\123\101\137\105\x58\120\x4f\116\x45\x4e\124")) {
            goto nX;
        }
        define("\103\x52\131\120\124\x5f\x52\x53\x41\137\x45\130\120\117\x4e\105\116\124", "\x36\x35\65\x33\x37");
        nX:
        if (defined("\103\x52\x59\x50\x54\137\122\123\x41\x5f\x53\115\x41\114\x4c\105\123\124\x5f\120\122\111\115\x45")) {
            goto ed;
        }
        define("\103\122\x59\120\124\x5f\122\123\101\x5f\123\115\x41\x4c\x4c\105\123\124\x5f\x50\122\x49\115\105", 4096);
        ed:
        if (!(CRYPT_RSA_MODE == CRYPT_RSA_MODE_OPENSSL && $Hg >= 384 && CRYPT_RSA_EXPONENT == 65537)) {
            goto lK;
        }
        $BX = array();
        if (!isset($this->configFile)) {
            goto hR;
        }
        $BX["\143\157\156\146\151\147"] = $this->configFile;
        hR:
        $dR = openssl_pkey_new(array("\160\x72\x69\x76\141\x74\x65\137\x6b\145\171\x5f\x62\x69\x74\x73" => $Hg) + $BX);
        openssl_pkey_export($dR, $sN, null, $BX);
        $DS = openssl_pkey_get_details($dR);
        $DS = $DS["\153\x65\x79"];
        $sN = call_user_func_array(array($this, "\137\x63\x6f\x6e\166\145\x72\x74\x50\162\x69\166\x61\164\x65\x4b\x65\x79"), array_values($this->_parseKey($sN, CRYPT_RSA_PRIVATE_FORMAT_PKCS1)));
        $DS = call_user_func_array(array($this, "\137\x63\x6f\156\x76\x65\x72\164\x50\165\142\x6c\151\x63\x4b\145\171"), array_values($this->_parseKey($DS, CRYPT_RSA_PUBLIC_FORMAT_PKCS1)));
        lv:
        if (!(openssl_error_string() !== false)) {
            goto uc;
        }
        goto lv;
        uc:
        return array("\160\x72\x69\166\x61\164\x65\x6b\x65\171" => $sN, "\160\165\142\x6c\x69\143\153\x65\x79" => $DS, "\x70\x61\162\x74\x69\x61\154\153\145\171" => false);
        lK:
        static $yh;
        if (isset($yh)) {
            goto JQ;
        }
        $yh = new Math_BigInteger(CRYPT_RSA_EXPONENT);
        JQ:
        extract($this->_generateMinMax($Hg));
        $C3 = $BU;
        $rd = $Hg >> 1;
        if ($rd > CRYPT_RSA_SMALLEST_PRIME) {
            goto z4;
        }
        $SC = 2;
        goto IK;
        z4:
        $SC = floor($Hg / CRYPT_RSA_SMALLEST_PRIME);
        $rd = CRYPT_RSA_SMALLEST_PRIME;
        IK:
        extract($this->_generateMinMax($rd + $Hg % $rd));
        $W9 = $Wa;
        extract($this->_generateMinMax($rd));
        $o4 = new Math_BigInteger();
        $lZ = $this->one->copy();
        if (!empty($an)) {
            goto Vk;
        }
        $jR = $wr = $I6 = array();
        $Q4 = array("\x74\157\x70" => $this->one->copy(), "\142\x6f\x74\x74\157\x6d" => false);
        goto Bo;
        Vk:
        extract(unserialize($an));
        Bo:
        $Mw = time();
        $jf = count($I6) + 1;
        e4:
        $MC = $jf;
        oh:
        if (!($MC <= $SC)) {
            goto l2;
        }
        if (!($nz !== false)) {
            goto MD;
        }
        $nz -= time() - $Mw;
        $Mw = time();
        if (!($nz <= 0)) {
            goto lb;
        }
        return array("\160\x72\151\x76\141\x74\145\153\145\x79" => '', "\160\165\142\154\x69\x63\153\x65\x79" => '', "\160\141\x72\x74\151\x61\x6c\153\x65\x79" => serialize(array("\160\162\x69\x6d\x65\163" => $I6, "\x63\157\145\146\146\x69\143\x69\x65\156\164\x73" => $wr, "\x6c\x63\x6d" => $Q4, "\x65\x78\160\x6f\156\x65\x6e\164\163" => $jR)));
        lb:
        MD:
        if ($MC == $SC) {
            goto Fb;
        }
        $I6[$MC] = $o4->randomPrime($BU, $Wa, $nz);
        goto vr;
        Fb:
        list($BU, $rd) = $C3->divide($lZ);
        if ($rd->equals($this->zero)) {
            goto M5;
        }
        $BU = $BU->add($this->one);
        M5:
        $I6[$MC] = $o4->randomPrime($BU, $W9, $nz);
        vr:
        if (!($I6[$MC] === false)) {
            goto qp;
        }
        if (count($I6) > 1) {
            goto Cm;
        }
        array_pop($I6);
        $m9 = serialize(array("\160\x72\x69\x6d\x65\163" => $I6, "\143\157\145\x66\146\151\143\151\x65\x6e\x74\163" => $wr, "\154\143\155" => $Q4, "\145\x78\160\157\156\x65\156\x74\163" => $jR));
        goto Hm;
        Cm:
        $m9 = '';
        Hm:
        return array("\160\x72\x69\166\x61\x74\x65\x6b\x65\x79" => '', "\160\x75\x62\154\x69\143\153\145\x79" => '', "\160\141\162\x74\151\x61\154\153\x65\171" => $m9);
        qp:
        if (!($MC > 2)) {
            goto KG;
        }
        $wr[$MC] = $lZ->modInverse($I6[$MC]);
        KG:
        $lZ = $lZ->multiply($I6[$MC]);
        $rd = $I6[$MC]->subtract($this->one);
        $Q4["\164\x6f\160"] = $Q4["\164\x6f\160"]->multiply($rd);
        $Q4["\x62\157\164\164\157\155"] = $Q4["\142\157\x74\x74\157\x6d"] === false ? $rd : $Q4["\x62\157\164\x74\157\x6d"]->gcd($rd);
        $jR[$MC] = $yh->modInverse($rd);
        zo:
        $MC++;
        goto oh;
        l2:
        list($rd) = $Q4["\x74\157\160"]->divide($Q4["\142\157\x74\x74\157\155"]);
        $dp = $rd->gcd($yh);
        $jf = 1;
        if (!$dp->equals($this->one)) {
            goto e4;
        }
        FB:
        $Hk = $yh->modInverse($rd);
        $wr[2] = $I6[2]->modInverse($I6[1]);
        return array("\160\162\x69\166\x61\x74\145\x6b\x65\171" => $this->_convertPrivateKey($lZ, $yh, $Hk, $I6, $jR, $wr), "\160\x75\142\x6c\151\143\153\145\171" => $this->_convertPublicKey($lZ, $yh), "\160\x61\162\164\151\141\x6c\x6b\145\171" => false);
    }
    function _convertPrivateKey($lZ, $yh, $Hk, $I6, $jR, $wr)
    {
        $jY = $this->privateKeyFormat != CRYPT_RSA_PRIVATE_FORMAT_XML;
        $SC = count($I6);
        $Cz = array("\x76\x65\162\x73\151\x6f\x6e" => $SC == 2 ? chr(0) : chr(1), "\x6d\157\144\x75\154\x75\x73" => $lZ->toBytes($jY), "\x70\x75\x62\x6c\x69\x63\x45\170\160\x6f\x6e\x65\x6e\x74" => $yh->toBytes($jY), "\x70\x72\151\x76\x61\x74\145\105\x78\x70\157\156\x65\156\x74" => $Hk->toBytes($jY), "\160\x72\x69\155\x65\61" => $I6[1]->toBytes($jY), "\160\x72\x69\x6d\x65\x32" => $I6[2]->toBytes($jY), "\x65\170\160\157\156\145\156\164\x31" => $jR[1]->toBytes($jY), "\145\170\x70\157\156\x65\156\164\62" => $jR[2]->toBytes($jY), "\x63\157\x65\146\146\x69\x63\x69\x65\156\x74" => $wr[2]->toBytes($jY));
        switch ($this->privateKeyFormat) {
            case CRYPT_RSA_PRIVATE_FORMAT_XML:
                if (!($SC != 2)) {
                    goto nZ;
                }
                return false;
                nZ:
                return "\x3c\122\x53\101\113\x65\171\x56\x61\x6c\x75\x65\76\15\12" . "\40\40\x3c\115\x6f\x64\165\154\x75\163\76" . base64_encode($Cz["\155\157\144\x75\x6c\165\163"]) . "\x3c\57\115\157\144\x75\x6c\x75\x73\76\15\xa" . "\x20\40\x3c\x45\170\x70\x6f\x6e\x65\156\164\x3e" . base64_encode($Cz["\160\x75\142\x6c\x69\x63\x45\170\160\x6f\x6e\145\156\164"]) . "\74\57\105\x78\x70\x6f\156\145\x6e\164\76\15\xa" . "\40\40\74\x50\76" . base64_encode($Cz["\x70\162\151\x6d\145\61"]) . "\x3c\57\120\x3e\xd\12" . "\40\40\74\x51\x3e" . base64_encode($Cz["\x70\x72\x69\x6d\x65\x32"]) . "\74\57\x51\x3e\15\xa" . "\40\40\74\104\120\x3e" . base64_encode($Cz["\x65\x78\160\157\x6e\x65\156\x74\61"]) . "\74\57\x44\120\76\15\12" . "\40\40\74\x44\x51\x3e" . base64_encode($Cz["\x65\x78\160\x6f\x6e\x65\x6e\164\x32"]) . "\x3c\x2f\104\x51\x3e\xd\xa" . "\x20\40\x3c\111\156\166\x65\x72\163\145\121\76" . base64_encode($Cz["\143\x6f\145\x66\x66\x69\x63\x69\x65\x6e\164"]) . "\x3c\x2f\x49\x6e\166\x65\162\163\x65\121\76\xd\12" . "\40\40\x3c\x44\x3e" . base64_encode($Cz["\x70\x72\151\166\141\164\x65\x45\170\x70\x6f\x6e\145\156\164"]) . "\x3c\57\104\76\xd\12" . "\x3c\57\122\123\x41\113\145\x79\126\x61\154\165\x65\x3e";
                goto PK;
            case CRYPT_RSA_PRIVATE_FORMAT_PUTTY:
                if (!($SC != 2)) {
                    goto Bx;
                }
                return false;
                Bx:
                $qV = "\x50\165\124\124\x59\x2d\125\163\145\x72\55\113\145\x79\x2d\x46\x69\154\145\55\x32\72\x20\163\163\150\x2d\x72\x73\x61\xd\12\x45\x6e\143\162\171\160\x74\151\157\x6e\72\x20";
                $vL = !empty($this->password) || is_string($this->password) ? "\141\145\x73\62\65\x36\x2d\143\x62\x63" : "\156\x6f\156\x65";
                $qV .= $vL;
                $qV .= "\xd\12\x43\157\155\x6d\x65\156\164\72\40" . $this->comment . "\xd\12";
                $nU = pack("\116\141\52\x4e\x61\x2a\x4e\141\x2a", strlen("\x73\x73\x68\x2d\162\x73\x61"), "\x73\x73\x68\x2d\x72\163\x61", strlen($Cz["\x70\165\142\x6c\151\143\x45\170\x70\x6f\156\145\156\x74"]), $Cz["\160\x75\142\x6c\x69\143\x45\x78\160\x6f\x6e\145\156\x74"], strlen($Cz["\155\157\x64\165\x6c\165\x73"]), $Cz["\155\157\144\165\154\165\163"]);
                $pX = pack("\116\141\52\x4e\141\x2a\116\141\52\x4e\141\x2a", strlen("\x73\x73\x68\x2d\162\x73\x61"), "\x73\x73\150\x2d\162\x73\x61", strlen($vL), $vL, strlen($this->comment), $this->comment, strlen($nU), $nU);
                $nU = base64_encode($nU);
                $qV .= "\x50\165\142\x6c\x69\x63\55\114\151\156\x65\x73\x3a\x20" . (strlen($nU) + 63 >> 6) . "\xd\12";
                $qV .= chunk_split($nU, 64);
                $JN = pack("\116\141\52\x4e\x61\x2a\116\x61\x2a\x4e\141\52", strlen($Cz["\x70\162\x69\x76\141\164\145\x45\170\x70\157\156\x65\156\164"]), $Cz["\160\x72\151\x76\x61\164\145\x45\170\x70\157\x6e\145\x6e\164"], strlen($Cz["\160\x72\151\155\145\61"]), $Cz["\160\162\151\x6d\x65\x31"], strlen($Cz["\x70\x72\151\155\145\62"]), $Cz["\160\162\x69\x6d\145\62"], strlen($Cz["\x63\157\145\146\146\x69\x63\151\x65\x6e\164"]), $Cz["\x63\x6f\145\x66\x66\x69\x63\x69\145\156\x74"]);
                if (empty($this->password) && !is_string($this->password)) {
                    goto op;
                }
                $JN .= crypt_random_string(16 - (strlen($JN) & 15));
                $pX .= pack("\116\141\52", strlen($JN), $JN);
                if (class_exists("\x43\x72\x79\x70\x74\x5f\101\105\123")) {
                    goto Kx;
                }
                include_once "\103\162\171\160\x74\57\101\105\x53\56\160\150\160";
                Kx:
                $CM = 0;
                $kk = '';
                Gm:
                if (!(strlen($kk) < 32)) {
                    goto Qb;
                }
                $rd = pack("\116\x61\x2a", $CM++, $this->password);
                $kk .= pack("\110\52", sha1($rd));
                goto Gm;
                Qb:
                $kk = substr($kk, 0, 32);
                $sT = new Crypt_AES();
                $sT->setKey($kk);
                $sT->disablePadding();
                $JN = $sT->encrypt($JN);
                $JG = "\x70\x75\164\x74\x79\x2d\160\x72\151\166\141\x74\x65\55\153\x65\171\55\x66\x69\154\x65\55\x6d\141\x63\55\x6b\x65\171" . $this->password;
                goto gS;
                op:
                $pX .= pack("\116\141\52", strlen($JN), $JN);
                $JG = "\x70\x75\164\164\171\55\160\162\151\x76\x61\x74\145\x2d\x6b\145\171\x2d\146\151\x6c\x65\55\x6d\141\x63\55\x6b\145\x79";
                gS:
                $JN = base64_encode($JN);
                $qV .= "\120\162\151\166\141\164\145\x2d\x4c\151\x6e\145\163\72\40" . (strlen($JN) + 63 >> 6) . "\15\xa";
                $qV .= chunk_split($JN, 64);
                if (class_exists("\x43\162\x79\x70\x74\x5f\x48\x61\x73\x68")) {
                    goto aR;
                }
                include_once "\x43\162\171\x70\164\57\x48\x61\163\150\x2e\x70\150\x70";
                aR:
                $cQ = new Crypt_Hash("\x73\x68\x61\x31");
                $cQ->setKey(pack("\x48\x2a", sha1($JG)));
                $qV .= "\120\162\151\166\x61\164\x65\55\x4d\x41\103\x3a\40" . bin2hex($cQ->hash($pX)) . "\15\xa";
                return $qV;
            default:
                $a7 = array();
                foreach ($Cz as $ts => $sw) {
                    $a7[$ts] = pack("\x43\x61\x2a\141\52", CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($sw)), $sw);
                    W9:
                }
                Ct:
                $mY = implode('', $a7);
                if (!($SC > 2)) {
                    goto Jg;
                }
                $mQ = '';
                $MC = 3;
                bo:
                if (!($MC <= $SC)) {
                    goto lg;
                }
                $s6 = pack("\103\141\52\141\x2a", CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($I6[$MC]->toBytes(true))), $I6[$MC]->toBytes(true));
                $s6 .= pack("\103\x61\52\x61\52", CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($jR[$MC]->toBytes(true))), $jR[$MC]->toBytes(true));
                $s6 .= pack("\x43\141\x2a\141\52", CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($wr[$MC]->toBytes(true))), $wr[$MC]->toBytes(true));
                $mQ .= pack("\103\x61\x2a\x61\x2a", CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($s6)), $s6);
                oc:
                $MC++;
                goto bo;
                lg:
                $mY .= pack("\103\141\x2a\141\52", CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($mQ)), $mQ);
                Jg:
                $mY = pack("\103\141\x2a\x61\52", CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($mY)), $mY);
                if (!($this->privateKeyFormat == CRYPT_RSA_PRIVATE_FORMAT_PKCS8)) {
                    goto az;
                }
                $kA = pack("\110\52", "\63\60\x30\144\60\x36\60\71\x32\x61\70\66\64\x38\x38\66\x66\67\60\x64\x30\61\x30\61\x30\x31\x30\65\x30\x30");
                $mY = pack("\103\x61\x2a\x61\52\x43\x61\x2a\141\52", CRYPT_RSA_ASN1_INTEGER, "\1\x0", $kA, 4, $this->_encodeLength(strlen($mY)), $mY);
                $mY = pack("\103\141\52\x61\52", CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($mY)), $mY);
                if (!empty($this->password) || is_string($this->password)) {
                    goto GL;
                }
                $mY = "\55\x2d\55\x2d\55\102\x45\107\111\x4e\40\120\x52\111\126\x41\124\105\x20\x4b\105\131\55\55\x2d\x2d\55\15\12" . chunk_split(base64_encode($mY), 64) . "\x2d\55\55\55\55\105\116\104\x20\x50\x52\111\126\x41\x54\105\40\x4b\x45\x59\55\55\x2d\x2d\55";
                goto ov;
                GL:
                $EH = crypt_random_string(8);
                $QM = 2048;
                if (class_exists("\103\x72\171\x70\x74\137\x44\x45\123")) {
                    goto oo;
                }
                include_once "\103\x72\x79\160\164\57\x44\x45\123\x2e\160\x68\160";
                oo:
                $sT = new Crypt_DES();
                $sT->setPassword($this->password, "\x70\142\153\x64\146\61", "\x6d\x64\x35", $EH, $QM);
                $mY = $sT->encrypt($mY);
                $WE = pack("\x43\x61\52\141\52\103\x61\x2a\x4e", CRYPT_RSA_ASN1_OCTETSTRING, $this->_encodeLength(strlen($EH)), $EH, CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(4), $QM);
                $Ym = "\x2a\x86\x48\206\367\15\x1\5\x3";
                $je = pack("\x43\141\52\141\x2a\x43\x61\52\x61\x2a", CRYPT_RSA_ASN1_OBJECT, $this->_encodeLength(strlen($Ym)), $Ym, CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($WE)), $WE);
                $mY = pack("\103\x61\x2a\x61\52\103\141\x2a\141\x2a", CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($je)), $je, CRYPT_RSA_ASN1_OCTETSTRING, $this->_encodeLength(strlen($mY)), $mY);
                $mY = pack("\103\141\52\141\x2a", CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($mY)), $mY);
                $mY = "\55\x2d\55\55\55\102\105\x47\111\116\x20\x45\x4e\x43\x52\131\x50\124\x45\x44\40\x50\x52\111\126\x41\x54\105\40\x4b\x45\x59\x2d\55\x2d\55\x2d\15\12" . chunk_split(base64_encode($mY), 64) . "\55\55\55\55\55\x45\116\104\40\x45\x4e\x43\122\131\120\124\105\x44\x20\x50\122\x49\126\101\x54\x45\40\113\x45\131\55\55\x2d\55\x2d";
                ov:
                return $mY;
                az:
                if (!empty($this->password) || is_string($this->password)) {
                    goto yH;
                }
                $mY = "\55\x2d\55\55\55\102\x45\x47\x49\116\40\122\123\101\40\x50\122\x49\126\101\x54\x45\x20\113\105\x59\55\x2d\55\55\x2d\15\xa" . chunk_split(base64_encode($mY), 64) . "\55\55\x2d\55\x2d\x45\116\104\40\122\123\x41\40\120\x52\111\126\101\x54\x45\x20\113\105\131\x2d\x2d\55\55\x2d";
                goto QN;
                yH:
                $hl = crypt_random_string(8);
                $kk = pack("\110\52", md5($this->password . $hl));
                $kk .= substr(pack("\110\x2a", md5($kk . $this->password . $hl)), 0, 8);
                if (class_exists("\103\x72\171\160\164\137\x54\x72\151\x70\x6c\145\104\105\123")) {
                    goto WD;
                }
                include_once "\x43\x72\171\x70\164\57\124\x72\151\160\x6c\145\104\x45\x53\56\x70\x68\x70";
                WD:
                $G1 = new Crypt_TripleDES();
                $G1->setKey($kk);
                $G1->setIV($hl);
                $hl = strtoupper(bin2hex($hl));
                $mY = "\55\x2d\55\55\x2d\x42\x45\107\111\116\40\122\x53\x41\40\120\122\111\x56\101\124\105\40\113\x45\x59\x2d\x2d\55\x2d\x2d\15\12" . "\120\162\x6f\x63\55\124\171\x70\145\x3a\x20\x34\x2c\x45\116\x43\x52\131\x50\x54\105\104\xd\12" . "\x44\x45\113\55\x49\156\146\x6f\72\40\x44\x45\123\55\x45\104\x45\63\x2d\103\102\103\54{$hl}\15\12" . "\xd\xa" . chunk_split(base64_encode($G1->encrypt($mY)), 64) . "\55\x2d\55\55\x2d\x45\x4e\104\40\x52\123\x41\40\120\122\x49\x56\x41\x54\x45\x20\113\105\x59\x2d\55\x2d\x2d\x2d";
                QN:
                return $mY;
        }
        qb:
        PK:
    }
    function _convertPublicKey($lZ, $yh)
    {
        $jY = $this->publicKeyFormat != CRYPT_RSA_PUBLIC_FORMAT_XML;
        $Ke = $lZ->toBytes($jY);
        $zN = $yh->toBytes($jY);
        switch ($this->publicKeyFormat) {
            case CRYPT_RSA_PUBLIC_FORMAT_RAW:
                return array("\145" => $yh->copy(), "\x6e" => $lZ->copy());
            case CRYPT_RSA_PUBLIC_FORMAT_XML:
                return "\74\x52\x53\x41\113\x65\171\x56\141\x6c\165\x65\x3e\15\12" . "\40\40\x3c\115\157\x64\x75\x6c\x75\163\76" . base64_encode($Ke) . "\x3c\x2f\115\157\144\165\154\x75\x73\x3e\15\xa" . "\40\x20\74\105\170\160\x6f\x6e\x65\156\164\x3e" . base64_encode($zN) . "\x3c\57\105\x78\x70\157\x6e\145\x6e\164\x3e\15\xa" . "\x3c\x2f\x52\123\101\x4b\145\171\126\141\154\165\x65\76";
                goto iG;
            case CRYPT_RSA_PUBLIC_FORMAT_OPENSSH:
                $SW = pack("\x4e\x61\52\116\141\x2a\116\x61\x2a", strlen("\163\163\x68\55\162\163\141"), "\163\163\x68\x2d\x72\x73\x61", strlen($zN), $zN, strlen($Ke), $Ke);
                $SW = "\x73\x73\x68\55\x72\x73\x61\40" . base64_encode($SW) . "\40" . $this->comment;
                return $SW;
            default:
                $a7 = array("\x6d\157\x64\165\154\165\x73" => pack("\x43\141\52\x61\52", CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($Ke)), $Ke), "\160\x75\x62\x6c\151\143\x45\170\x70\x6f\156\145\156\x74" => pack("\x43\x61\x2a\141\x2a", CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($zN)), $zN));
                $SW = pack("\103\x61\52\141\52\x61\x2a", CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($a7["\155\x6f\x64\165\154\165\163"]) + strlen($a7["\160\165\x62\x6c\151\x63\105\x78\160\x6f\x6e\145\x6e\x74"])), $a7["\x6d\157\x64\165\154\x75\x73"], $a7["\160\x75\x62\154\x69\x63\105\170\160\x6f\x6e\x65\156\164"]);
                if ($this->publicKeyFormat == CRYPT_RSA_PUBLIC_FORMAT_PKCS1_RAW) {
                    goto Sj;
                }
                $kA = pack("\110\52", "\63\x30\x30\144\60\x36\60\x39\62\x61\70\66\x34\70\70\x36\x66\67\60\x64\x30\x31\60\x31\60\x31\x30\65\x30\60");
                $SW = chr(0) . $SW;
                $SW = chr(3) . $this->_encodeLength(strlen($SW)) . $SW;
                $SW = pack("\x43\x61\52\141\x2a", CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($kA . $SW)), $kA . $SW);
                $SW = "\x2d\55\55\55\55\x42\x45\107\x49\x4e\40\120\125\102\x4c\x49\103\x20\x4b\x45\x59\x2d\55\55\x2d\x2d\15\xa" . chunk_split(base64_encode($SW), 64) . "\55\x2d\55\x2d\55\105\116\104\40\x50\125\102\x4c\111\x43\40\113\x45\131\x2d\x2d\x2d\x2d\55";
                goto EY;
                Sj:
                $SW = "\55\x2d\55\55\55\x42\105\107\111\116\x20\122\x53\x41\40\x50\x55\102\x4c\x49\103\40\x4b\105\131\55\55\x2d\55\55\15\xa" . chunk_split(base64_encode($SW), 64) . "\x2d\x2d\x2d\55\55\105\x4e\104\x20\122\x53\x41\x20\x50\125\x42\114\111\x43\x20\x4b\105\131\55\x2d\55\x2d\55";
                EY:
                return $SW;
        }
        y7:
        iG:
    }
    function _parseKey($qV, $PR)
    {
        if (!($PR != CRYPT_RSA_PUBLIC_FORMAT_RAW && !is_string($qV))) {
            goto Bq;
        }
        return false;
        Bq:
        switch ($PR) {
            case CRYPT_RSA_PUBLIC_FORMAT_RAW:
                if (is_array($qV)) {
                    goto pG;
                }
                return false;
                pG:
                $a7 = array();
                switch (true) {
                    case isset($qV["\145"]):
                        $a7["\160\x75\x62\x6c\151\x63\105\x78\160\157\156\x65\x6e\164"] = $qV["\x65"]->copy();
                        goto Jj;
                    case isset($qV["\145\170\x70\x6f\156\145\x6e\x74"]):
                        $a7["\x70\165\142\154\151\143\105\170\x70\x6f\x6e\x65\x6e\x74"] = $qV["\145\x78\x70\x6f\156\x65\x6e\x74"]->copy();
                        goto Jj;
                    case isset($qV["\160\x75\x62\154\151\143\x45\x78\x70\157\x6e\145\156\164"]):
                        $a7["\x70\165\142\154\151\x63\x45\x78\160\157\156\x65\x6e\x74"] = $qV["\160\165\142\x6c\x69\x63\x45\x78\160\157\x6e\x65\156\164"]->copy();
                        goto Jj;
                    case isset($qV[0]):
                        $a7["\x70\x75\142\154\x69\x63\105\x78\160\157\156\145\156\164"] = $qV[0]->copy();
                }
                ZG:
                Jj:
                switch (true) {
                    case isset($qV["\x6e"]):
                        $a7["\155\157\144\x75\x6c\x75\x73"] = $qV["\156"]->copy();
                        goto sk;
                    case isset($qV["\x6d\157\144\x75\x6c\x6f"]):
                        $a7["\155\157\x64\x75\x6c\x75\163"] = $qV["\x6d\x6f\144\x75\154\x6f"]->copy();
                        goto sk;
                    case isset($qV["\x6d\157\144\x75\x6c\x75\163"]):
                        $a7["\x6d\x6f\144\x75\x6c\x75\x73"] = $qV["\x6d\x6f\144\x75\154\165\163"]->copy();
                        goto sk;
                    case isset($qV[1]):
                        $a7["\x6d\157\x64\165\154\165\163"] = $qV[1]->copy();
                }
                f4:
                sk:
                return isset($a7["\155\157\144\x75\154\165\163"]) && isset($a7["\160\x75\142\x6c\151\x63\x45\170\x70\157\156\145\x6e\x74"]) ? $a7 : false;
            case CRYPT_RSA_PRIVATE_FORMAT_PKCS1:
            case CRYPT_RSA_PRIVATE_FORMAT_PKCS8:
            case CRYPT_RSA_PUBLIC_FORMAT_PKCS1:
                if (preg_match("\43\x44\105\x4b\x2d\x49\x6e\x66\157\72\40\x28\x2e\x2b\x29\54\50\x2e\x2b\51\x23", $qV, $W4)) {
                    goto O8;
                }
                $du = $this->_extractBER($qV);
                goto DT;
                O8:
                $hl = pack("\110\52", trim($W4[2]));
                $kk = pack("\110\52", md5($this->password . substr($hl, 0, 8)));
                $kk .= pack("\x48\x2a", md5($kk . $this->password . substr($hl, 0, 8)));
                $qV = preg_replace("\x23\136\50\77\72\120\162\157\x63\x2d\124\171\x70\145\x7c\104\105\x4b\55\111\156\x66\157\51\x3a\40\x2e\x2a\x23\x6d", '', $qV);
                $Z4 = $this->_extractBER($qV);
                if (!($Z4 === false)) {
                    goto JP;
                }
                $Z4 = $qV;
                JP:
                switch ($W4[1]) {
                    case "\101\x45\x53\x2d\x32\65\66\x2d\x43\x42\103":
                        if (class_exists("\x43\x72\171\x70\164\137\101\x45\x53")) {
                            goto B4;
                        }
                        include_once "\103\x72\x79\160\164\57\x41\x45\x53\x2e\x70\x68\160";
                        B4:
                        $sT = new Crypt_AES();
                        goto GW;
                    case "\101\105\x53\x2d\61\x32\x38\x2d\x43\x42\x43":
                        if (class_exists("\103\162\x79\160\164\137\101\x45\123")) {
                            goto jF;
                        }
                        include_once "\x43\x72\171\x70\164\x2f\101\x45\123\x2e\x70\150\160";
                        jF:
                        $kk = substr($kk, 0, 16);
                        $sT = new Crypt_AES();
                        goto GW;
                    case "\x44\x45\123\x2d\105\104\105\63\x2d\x43\x46\102":
                        if (class_exists("\x43\162\171\x70\164\137\124\162\x69\x70\154\x65\x44\x45\x53")) {
                            goto G3;
                        }
                        include_once "\103\162\x79\x70\x74\57\124\162\151\160\154\x65\104\x45\x53\x2e\160\x68\160";
                        G3:
                        $sT = new Crypt_TripleDES(CRYPT_DES_MODE_CFB);
                        goto GW;
                    case "\x44\x45\x53\x2d\x45\104\105\63\55\103\x42\x43":
                        if (class_exists("\x43\162\x79\x70\x74\x5f\124\162\x69\x70\154\145\x44\105\123")) {
                            goto qN;
                        }
                        include_once "\103\162\x79\x70\164\57\x54\x72\151\160\x6c\x65\x44\x45\123\56\x70\x68\x70";
                        qN:
                        $kk = substr($kk, 0, 24);
                        $sT = new Crypt_TripleDES();
                        goto GW;
                    case "\104\x45\123\55\103\x42\103":
                        if (class_exists("\x43\x72\x79\160\x74\x5f\x44\x45\x53")) {
                            goto W6;
                        }
                        include_once "\x43\162\171\160\x74\57\104\x45\x53\56\160\x68\x70";
                        W6:
                        $sT = new Crypt_DES();
                        goto GW;
                    default:
                        return false;
                }
                Rc:
                GW:
                $sT->setKey($kk);
                $sT->setIV($hl);
                $du = $sT->decrypt($Z4);
                DT:
                if (!($du !== false)) {
                    goto oC;
                }
                $qV = $du;
                oC:
                $a7 = array();
                if (!(ord($this->_string_shift($qV)) != CRYPT_RSA_ASN1_SEQUENCE)) {
                    goto kb;
                }
                return false;
                kb:
                if (!($this->_decodeLength($qV) != strlen($qV))) {
                    goto L6;
                }
                return false;
                L6:
                $i4 = ord($this->_string_shift($qV));
                if (!($i4 == CRYPT_RSA_ASN1_INTEGER && substr($qV, 0, 3) == "\1\x0\60")) {
                    goto e5;
                }
                $this->_string_shift($qV, 3);
                $i4 = CRYPT_RSA_ASN1_SEQUENCE;
                e5:
                if (!($i4 == CRYPT_RSA_ASN1_SEQUENCE)) {
                    goto bx;
                }
                $rd = $this->_string_shift($qV, $this->_decodeLength($qV));
                if (!(ord($this->_string_shift($rd)) != CRYPT_RSA_ASN1_OBJECT)) {
                    goto RJ;
                }
                return false;
                RJ:
                $Yy = $this->_decodeLength($rd);
                switch ($this->_string_shift($rd, $Yy)) {
                    case "\52\x86\x48\x86\xf7\xd\x1\x1\x1":
                        goto B1;
                    case "\x2a\206\x48\x86\367\xd\x1\5\x3":
                        if (!(ord($this->_string_shift($rd)) != CRYPT_RSA_ASN1_SEQUENCE)) {
                            goto hm;
                        }
                        return false;
                        hm:
                        if (!($this->_decodeLength($rd) != strlen($rd))) {
                            goto n1;
                        }
                        return false;
                        n1:
                        $this->_string_shift($rd);
                        $EH = $this->_string_shift($rd, $this->_decodeLength($rd));
                        if (!(ord($this->_string_shift($rd)) != CRYPT_RSA_ASN1_INTEGER)) {
                            goto CJ;
                        }
                        return false;
                        CJ:
                        $this->_decodeLength($rd);
                        list(, $QM) = unpack("\x4e", str_pad($rd, 4, chr(0), STR_PAD_LEFT));
                        $this->_string_shift($qV);
                        $Yy = $this->_decodeLength($qV);
                        if (!(strlen($qV) != $Yy)) {
                            goto Eo;
                        }
                        return false;
                        Eo:
                        if (class_exists("\x43\162\x79\x70\164\x5f\x44\x45\123")) {
                            goto bp;
                        }
                        include_once "\x43\162\171\x70\164\x2f\x44\x45\123\x2e\160\150\160";
                        bp:
                        $sT = new Crypt_DES();
                        $sT->setPassword($this->password, "\x70\142\x6b\x64\x66\x31", "\155\x64\65", $EH, $QM);
                        $qV = $sT->decrypt($qV);
                        if (!($qV === false)) {
                            goto EB;
                        }
                        return false;
                        EB:
                        return $this->_parseKey($qV, CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
                    default:
                        return false;
                }
                Jv:
                B1:
                $i4 = ord($this->_string_shift($qV));
                $this->_decodeLength($qV);
                if (!($i4 == CRYPT_RSA_ASN1_BITSTRING)) {
                    goto Ur;
                }
                $this->_string_shift($qV);
                Ur:
                if (!(ord($this->_string_shift($qV)) != CRYPT_RSA_ASN1_SEQUENCE)) {
                    goto B3;
                }
                return false;
                B3:
                if (!($this->_decodeLength($qV) != strlen($qV))) {
                    goto oN;
                }
                return false;
                oN:
                $i4 = ord($this->_string_shift($qV));
                bx:
                if (!($i4 != CRYPT_RSA_ASN1_INTEGER)) {
                    goto mV;
                }
                return false;
                mV:
                $Yy = $this->_decodeLength($qV);
                $rd = $this->_string_shift($qV, $Yy);
                if (!(strlen($rd) != 1 || ord($rd) > 2)) {
                    goto N4;
                }
                $a7["\x6d\x6f\x64\x75\154\165\x73"] = new Math_BigInteger($rd, 256);
                $this->_string_shift($qV);
                $Yy = $this->_decodeLength($qV);
                $a7[$PR == CRYPT_RSA_PUBLIC_FORMAT_PKCS1 ? "\160\165\142\x6c\x69\x63\x45\170\x70\157\156\x65\156\x74" : "\x70\x72\x69\x76\x61\x74\x65\x45\170\x70\x6f\156\145\156\x74"] = new Math_BigInteger($this->_string_shift($qV, $Yy), 256);
                return $a7;
                N4:
                if (!(ord($this->_string_shift($qV)) != CRYPT_RSA_ASN1_INTEGER)) {
                    goto ct;
                }
                return false;
                ct:
                $Yy = $this->_decodeLength($qV);
                $a7["\155\157\144\x75\x6c\165\x73"] = new Math_BigInteger($this->_string_shift($qV, $Yy), 256);
                $this->_string_shift($qV);
                $Yy = $this->_decodeLength($qV);
                $a7["\160\x75\142\x6c\151\x63\x45\170\160\157\156\x65\x6e\x74"] = new Math_BigInteger($this->_string_shift($qV, $Yy), 256);
                $this->_string_shift($qV);
                $Yy = $this->_decodeLength($qV);
                $a7["\160\162\x69\x76\141\x74\x65\x45\170\x70\x6f\x6e\x65\156\x74"] = new Math_BigInteger($this->_string_shift($qV, $Yy), 256);
                $this->_string_shift($qV);
                $Yy = $this->_decodeLength($qV);
                $a7["\160\162\x69\x6d\x65\x73"] = array(1 => new Math_BigInteger($this->_string_shift($qV, $Yy), 256));
                $this->_string_shift($qV);
                $Yy = $this->_decodeLength($qV);
                $a7["\160\x72\x69\x6d\145\163"][] = new Math_BigInteger($this->_string_shift($qV, $Yy), 256);
                $this->_string_shift($qV);
                $Yy = $this->_decodeLength($qV);
                $a7["\x65\170\160\157\156\x65\156\x74\x73"] = array(1 => new Math_BigInteger($this->_string_shift($qV, $Yy), 256));
                $this->_string_shift($qV);
                $Yy = $this->_decodeLength($qV);
                $a7["\x65\170\x70\157\x6e\145\156\164\163"][] = new Math_BigInteger($this->_string_shift($qV, $Yy), 256);
                $this->_string_shift($qV);
                $Yy = $this->_decodeLength($qV);
                $a7["\x63\157\x65\x66\x66\151\x63\151\145\156\x74\x73"] = array(2 => new Math_BigInteger($this->_string_shift($qV, $Yy), 256));
                if (empty($qV)) {
                    goto lu;
                }
                if (!(ord($this->_string_shift($qV)) != CRYPT_RSA_ASN1_SEQUENCE)) {
                    goto uH;
                }
                return false;
                uH:
                $this->_decodeLength($qV);
                CA:
                if (empty($qV)) {
                    goto ZT;
                }
                if (!(ord($this->_string_shift($qV)) != CRYPT_RSA_ASN1_SEQUENCE)) {
                    goto kG;
                }
                return false;
                kG:
                $this->_decodeLength($qV);
                $qV = substr($qV, 1);
                $Yy = $this->_decodeLength($qV);
                $a7["\160\162\151\x6d\x65\x73"][] = new Math_BigInteger($this->_string_shift($qV, $Yy), 256);
                $this->_string_shift($qV);
                $Yy = $this->_decodeLength($qV);
                $a7["\x65\x78\x70\157\156\x65\x6e\x74\163"][] = new Math_BigInteger($this->_string_shift($qV, $Yy), 256);
                $this->_string_shift($qV);
                $Yy = $this->_decodeLength($qV);
                $a7["\x63\157\x65\146\146\151\143\x69\x65\156\x74\163"][] = new Math_BigInteger($this->_string_shift($qV, $Yy), 256);
                goto CA;
                ZT:
                lu:
                return $a7;
            case CRYPT_RSA_PUBLIC_FORMAT_OPENSSH:
                $ec = explode("\40", $qV, 3);
                $qV = isset($ec[1]) ? base64_decode($ec[1]) : false;
                if (!($qV === false)) {
                    goto SG;
                }
                return false;
                SG:
                $dZ = isset($ec[2]) ? $ec[2] : false;
                $q5 = substr($qV, 0, 11) == "\0\x0\0\7\x73\163\x68\x2d\162\163\x61";
                if (!(strlen($qV) <= 4)) {
                    goto Hz;
                }
                return false;
                Hz:
                extract(unpack("\116\154\145\156\147\x74\x68", $this->_string_shift($qV, 4)));
                $zN = new Math_BigInteger($this->_string_shift($qV, $Yy), -256);
                if (!(strlen($qV) <= 4)) {
                    goto BN;
                }
                return false;
                BN:
                extract(unpack("\x4e\154\145\156\x67\x74\150", $this->_string_shift($qV, 4)));
                $Ke = new Math_BigInteger($this->_string_shift($qV, $Yy), -256);
                if ($q5 && strlen($qV)) {
                    goto Ap;
                }
                return strlen($qV) ? false : array("\x6d\157\x64\165\154\165\x73" => $Ke, "\x70\x75\142\154\151\143\x45\x78\x70\157\x6e\145\156\x74" => $zN, "\143\157\155\x6d\x65\x6e\164" => $dZ);
                goto nJ;
                Ap:
                if (!(strlen($qV) <= 4)) {
                    goto i0;
                }
                return false;
                i0:
                extract(unpack("\x4e\x6c\145\156\147\x74\x68", $this->_string_shift($qV, 4)));
                $xa = new Math_BigInteger($this->_string_shift($qV, $Yy), -256);
                return strlen($qV) ? false : array("\x6d\x6f\x64\165\154\165\163" => $xa, "\x70\x75\x62\154\x69\x63\105\170\160\x6f\x6e\145\x6e\164" => $Ke, "\x63\157\155\x6d\x65\x6e\164" => $dZ);
                nJ:
            case CRYPT_RSA_PRIVATE_FORMAT_XML:
            case CRYPT_RSA_PUBLIC_FORMAT_XML:
                $this->components = array();
                $kW = xml_parser_create("\x55\x54\x46\x2d\x38");
                xml_set_object($kW, $this);
                xml_set_element_handler($kW, "\137\163\164\141\x72\x74\137\x65\x6c\145\155\x65\x6e\164\137\150\x61\x6e\144\x6c\145\162", "\x5f\163\164\x6f\160\x5f\145\154\145\x6d\145\x6e\164\137\150\x61\x6e\x64\154\145\162");
                xml_set_character_data_handler($kW, "\x5f\144\x61\x74\x61\x5f\x68\141\156\144\x6c\x65\162");
                if (xml_parse($kW, "\74\x78\x6d\154\76" . $qV . "\74\57\170\155\154\76")) {
                    goto BP;
                }
                return false;
                BP:
                return isset($this->components["\155\x6f\144\165\154\x75\163"]) && isset($this->components["\160\x75\142\x6c\151\143\105\170\160\157\156\145\156\164"]) ? $this->components : false;
            case CRYPT_RSA_PRIVATE_FORMAT_PUTTY:
                $a7 = array();
                $qV = preg_split("\43\x5c\162\x5c\156\x7c\x5c\x72\174\x5c\x6e\43", $qV);
                $PR = trim(preg_replace("\x23\120\165\124\124\131\55\125\x73\145\162\x2d\x4b\145\x79\x2d\106\151\x6c\145\x2d\x32\x3a\40\50\x2e\x2b\x29\x23", "\44\61", $qV[0]));
                if (!($PR != "\163\163\x68\x2d\162\x73\x61")) {
                    goto de;
                }
                return false;
                de:
                $vL = trim(preg_replace("\43\105\x6e\143\x72\171\x70\x74\151\157\x6e\72\40\x28\56\x2b\x29\43", "\44\x31", $qV[1]));
                $dZ = trim(preg_replace("\43\x43\x6f\155\x6d\145\x6e\x74\72\40\50\x2e\53\51\x23", "\x24\61", $qV[2]));
                $nA = trim(preg_replace("\x23\x50\165\142\154\x69\x63\55\114\x69\x6e\145\x73\72\40\50\x5c\144\53\51\43", "\44\x31", $qV[3]));
                $nU = base64_decode(implode('', array_map("\x74\162\x69\x6d", array_slice($qV, 4, $nA))));
                $nU = substr($nU, 11);
                extract(unpack("\116\154\145\156\x67\164\150", $this->_string_shift($nU, 4)));
                $a7["\x70\165\x62\x6c\151\x63\105\x78\160\157\156\x65\156\164"] = new Math_BigInteger($this->_string_shift($nU, $Yy), -256);
                extract(unpack("\x4e\x6c\x65\x6e\147\164\x68", $this->_string_shift($nU, 4)));
                $a7["\x6d\x6f\144\x75\x6c\x75\x73"] = new Math_BigInteger($this->_string_shift($nU, $Yy), -256);
                $Kq = trim(preg_replace("\43\120\x72\151\x76\141\164\x65\x2d\x4c\x69\x6e\145\x73\x3a\x20\50\x5c\144\53\x29\43", "\x24\61", $qV[$nA + 4]));
                $JN = base64_decode(implode('', array_map("\x74\162\151\x6d", array_slice($qV, $nA + 5, $Kq))));
                switch ($vL) {
                    case "\141\x65\163\x32\65\x36\55\x63\142\143":
                        if (class_exists("\x43\x72\171\160\x74\x5f\x41\105\123")) {
                            goto oy;
                        }
                        include_once "\x43\162\x79\160\x74\57\101\105\x53\x2e\160\150\x70";
                        oy:
                        $kk = '';
                        $CM = 0;
                        iC:
                        if (!(strlen($kk) < 32)) {
                            goto RS;
                        }
                        $rd = pack("\116\141\52", $CM++, $this->password);
                        $kk .= pack("\x48\52", sha1($rd));
                        goto iC;
                        RS:
                        $kk = substr($kk, 0, 32);
                        $sT = new Crypt_AES();
                }
                kx:
                TH:
                if (!($vL != "\x6e\x6f\156\x65")) {
                    goto KH;
                }
                $sT->setKey($kk);
                $sT->disablePadding();
                $JN = $sT->decrypt($JN);
                if (!($JN === false)) {
                    goto ae;
                }
                return false;
                ae:
                KH:
                extract(unpack("\x4e\154\x65\156\147\x74\150", $this->_string_shift($JN, 4)));
                if (!(strlen($JN) < $Yy)) {
                    goto lL;
                }
                return false;
                lL:
                $a7["\160\162\151\166\141\x74\145\x45\170\160\157\156\x65\x6e\x74"] = new Math_BigInteger($this->_string_shift($JN, $Yy), -256);
                extract(unpack("\116\x6c\x65\x6e\x67\x74\x68", $this->_string_shift($JN, 4)));
                if (!(strlen($JN) < $Yy)) {
                    goto eM;
                }
                return false;
                eM:
                $a7["\160\162\151\155\x65\163"] = array(1 => new Math_BigInteger($this->_string_shift($JN, $Yy), -256));
                extract(unpack("\x4e\x6c\145\156\x67\164\150", $this->_string_shift($JN, 4)));
                if (!(strlen($JN) < $Yy)) {
                    goto tG;
                }
                return false;
                tG:
                $a7["\160\x72\x69\x6d\x65\163"][] = new Math_BigInteger($this->_string_shift($JN, $Yy), -256);
                $rd = $a7["\160\162\151\155\x65\x73"][1]->subtract($this->one);
                $a7["\x65\x78\x70\157\156\145\156\x74\x73"] = array(1 => $a7["\160\x75\142\154\151\143\x45\x78\160\x6f\x6e\x65\156\164"]->modInverse($rd));
                $rd = $a7["\160\x72\151\x6d\x65\163"][2]->subtract($this->one);
                $a7["\x65\170\160\x6f\x6e\145\156\x74\x73"][] = $a7["\x70\x75\142\154\x69\143\x45\170\x70\x6f\x6e\x65\x6e\164"]->modInverse($rd);
                extract(unpack("\x4e\x6c\145\x6e\x67\x74\x68", $this->_string_shift($JN, 4)));
                if (!(strlen($JN) < $Yy)) {
                    goto fy;
                }
                return false;
                fy:
                $a7["\143\157\145\146\x66\x69\x63\151\x65\x6e\164\x73"] = array(2 => new Math_BigInteger($this->_string_shift($JN, $Yy), -256));
                return $a7;
        }
        pM:
        uN:
    }
    function getSize()
    {
        return !isset($this->modulus) ? 0 : strlen($this->modulus->toBits());
    }
    function _start_element_handler($il, $ts, $i0)
    {
        switch ($ts) {
            case "\115\117\104\x55\114\x55\x53":
                $this->current =& $this->components["\x6d\x6f\144\165\x6c\165\163"];
                goto oX;
            case "\105\x58\120\x4f\116\105\116\124":
                $this->current =& $this->components["\x70\x75\142\154\x69\x63\105\170\160\157\156\x65\x6e\x74"];
                goto oX;
            case "\x50":
                $this->current =& $this->components["\160\162\x69\x6d\145\163"][1];
                goto oX;
            case "\121":
                $this->current =& $this->components["\x70\162\x69\155\x65\163"][2];
                goto oX;
            case "\104\x50":
                $this->current =& $this->components["\145\170\160\157\x6e\145\x6e\164\x73"][1];
                goto oX;
            case "\x44\x51":
                $this->current =& $this->components["\145\x78\x70\x6f\156\x65\x6e\x74\x73"][2];
                goto oX;
            case "\x49\116\126\x45\x52\x53\x45\x51":
                $this->current =& $this->components["\143\157\x65\x66\146\x69\143\151\145\156\164\x73"][2];
                goto oX;
            case "\104":
                $this->current =& $this->components["\x70\x72\x69\x76\141\164\x65\x45\x78\x70\x6f\156\x65\156\164"];
        }
        CB:
        oX:
        $this->current = '';
    }
    function _stop_element_handler($il, $ts)
    {
        if (!isset($this->current)) {
            goto Z2;
        }
        $this->current = new Math_BigInteger(base64_decode($this->current), 256);
        unset($this->current);
        Z2:
    }
    function _data_handler($il, $p7)
    {
        if (!(!isset($this->current) || is_object($this->current))) {
            goto qw;
        }
        return;
        qw:
        $this->current .= trim($p7);
    }
    function loadKey($qV, $PR = false)
    {
        if (!(is_object($qV) && strtolower(get_class($qV)) == "\x63\x72\171\160\164\137\162\163\141")) {
            goto s_;
        }
        $this->privateKeyFormat = $qV->privateKeyFormat;
        $this->publicKeyFormat = $qV->publicKeyFormat;
        $this->k = $qV->k;
        $this->hLen = $qV->hLen;
        $this->sLen = $qV->sLen;
        $this->mgfHLen = $qV->mgfHLen;
        $this->encryptionMode = $qV->encryptionMode;
        $this->signatureMode = $qV->signatureMode;
        $this->password = $qV->password;
        $this->configFile = $qV->configFile;
        $this->comment = $qV->comment;
        if (!is_object($qV->hash)) {
            goto TK;
        }
        $this->hash = new Crypt_Hash($qV->hash->getHash());
        TK:
        if (!is_object($qV->mgfHash)) {
            goto Ju;
        }
        $this->mgfHash = new Crypt_Hash($qV->mgfHash->getHash());
        Ju:
        if (!is_object($qV->modulus)) {
            goto Oq;
        }
        $this->modulus = $qV->modulus->copy();
        Oq:
        if (!is_object($qV->exponent)) {
            goto EI;
        }
        $this->exponent = $qV->exponent->copy();
        EI:
        if (!is_object($qV->publicExponent)) {
            goto Ed;
        }
        $this->publicExponent = $qV->publicExponent->copy();
        Ed:
        $this->primes = array();
        $this->exponents = array();
        $this->coefficients = array();
        foreach ($this->primes as $V6) {
            $this->primes[] = $V6->copy();
            IR:
        }
        YF:
        foreach ($this->exponents as $mF) {
            $this->exponents[] = $mF->copy();
            Ah:
        }
        OG:
        foreach ($this->coefficients as $kn) {
            $this->coefficients[] = $kn->copy();
            br:
        }
        zl:
        return true;
        s_:
        if ($PR === false) {
            goto Mu;
        }
        $a7 = $this->_parseKey($qV, $PR);
        goto Sd;
        Mu:
        $Q0 = array(CRYPT_RSA_PUBLIC_FORMAT_RAW, CRYPT_RSA_PRIVATE_FORMAT_PKCS1, CRYPT_RSA_PRIVATE_FORMAT_XML, CRYPT_RSA_PRIVATE_FORMAT_PUTTY, CRYPT_RSA_PUBLIC_FORMAT_OPENSSH);
        foreach ($Q0 as $PR) {
            $a7 = $this->_parseKey($qV, $PR);
            if (!($a7 !== false)) {
                goto yU;
            }
            goto jy;
            yU:
            rA:
        }
        jy:
        Sd:
        if (!($a7 === false)) {
            goto h6;
        }
        $this->comment = null;
        $this->modulus = null;
        $this->k = null;
        $this->exponent = null;
        $this->primes = null;
        $this->exponents = null;
        $this->coefficients = null;
        $this->publicExponent = null;
        return false;
        h6:
        if (!(isset($a7["\143\x6f\155\155\x65\156\x74"]) && $a7["\143\x6f\155\155\x65\156\164"] !== false)) {
            goto CM;
        }
        $this->comment = $a7["\x63\x6f\155\155\x65\156\164"];
        CM:
        $this->modulus = $a7["\x6d\157\x64\165\x6c\165\163"];
        $this->k = strlen($this->modulus->toBytes());
        $this->exponent = isset($a7["\160\162\151\166\x61\164\145\105\170\160\157\x6e\x65\156\x74"]) ? $a7["\x70\162\151\x76\141\x74\145\105\170\160\157\x6e\x65\x6e\x74"] : $a7["\160\x75\142\x6c\x69\143\x45\x78\160\157\156\145\x6e\164"];
        if (isset($a7["\x70\x72\x69\x6d\145\x73"])) {
            goto DB;
        }
        $this->primes = array();
        $this->exponents = array();
        $this->coefficients = array();
        $this->publicExponent = false;
        goto PV;
        DB:
        $this->primes = $a7["\x70\162\x69\155\x65\163"];
        $this->exponents = $a7["\x65\170\x70\157\x6e\145\156\x74\163"];
        $this->coefficients = $a7["\143\x6f\145\146\146\x69\x63\x69\x65\156\x74\x73"];
        $this->publicExponent = $a7["\160\165\142\x6c\x69\143\105\x78\x70\x6f\x6e\145\156\164"];
        PV:
        switch ($PR) {
            case CRYPT_RSA_PUBLIC_FORMAT_OPENSSH:
            case CRYPT_RSA_PUBLIC_FORMAT_RAW:
                $this->setPublicKey();
                goto Lb;
            case CRYPT_RSA_PRIVATE_FORMAT_PKCS1:
                switch (true) {
                    case strpos($qV, "\55\102\105\107\x49\116\40\120\x55\102\x4c\111\103\x20\x4b\x45\131\x2d") !== false:
                    case strpos($qV, "\55\x42\105\x47\x49\116\x20\x52\123\101\x20\120\x55\x42\114\111\x43\40\113\x45\131\55") !== false:
                        $this->setPublicKey();
                }
                sv:
                Og:
        }
        Z4:
        Lb:
        return true;
    }
    function setPassword($Wd = false)
    {
        $this->password = $Wd;
    }
    function setPublicKey($qV = false, $PR = false)
    {
        if (empty($this->publicExponent)) {
            goto Ab;
        }
        return false;
        Ab:
        if (!($qV === false && !empty($this->modulus))) {
            goto Sn;
        }
        $this->publicExponent = $this->exponent;
        return true;
        Sn:
        if ($PR === false) {
            goto oQ;
        }
        $a7 = $this->_parseKey($qV, $PR);
        goto Qv;
        oQ:
        $Q0 = array(CRYPT_RSA_PUBLIC_FORMAT_RAW, CRYPT_RSA_PUBLIC_FORMAT_PKCS1, CRYPT_RSA_PUBLIC_FORMAT_XML, CRYPT_RSA_PUBLIC_FORMAT_OPENSSH);
        foreach ($Q0 as $PR) {
            $a7 = $this->_parseKey($qV, $PR);
            if (!($a7 !== false)) {
                goto nI;
            }
            goto ep;
            nI:
            pK:
        }
        ep:
        Qv:
        if (!($a7 === false)) {
            goto gk;
        }
        return false;
        gk:
        if (!(empty($this->modulus) || !$this->modulus->equals($a7["\155\x6f\144\x75\154\x75\x73"]))) {
            goto T2;
        }
        $this->modulus = $a7["\x6d\x6f\x64\x75\x6c\x75\x73"];
        $this->exponent = $this->publicExponent = $a7["\160\165\142\x6c\151\143\x45\x78\x70\x6f\156\x65\x6e\x74"];
        return true;
        T2:
        $this->publicExponent = $a7["\160\x75\x62\x6c\x69\x63\x45\170\160\157\x6e\145\156\x74"];
        return true;
    }
    function setPrivateKey($qV = false, $PR = false)
    {
        if (!($qV === false && !empty($this->publicExponent))) {
            goto Jb;
        }
        $this->publicExponent = false;
        return true;
        Jb:
        $dR = new Crypt_RSA();
        if ($dR->loadKey($qV, $PR)) {
            goto tj;
        }
        return false;
        tj:
        $dR->publicExponent = false;
        $this->loadKey($dR);
        return true;
    }
    function getPublicKey($PR = CRYPT_RSA_PUBLIC_FORMAT_PKCS8)
    {
        if (!(empty($this->modulus) || empty($this->publicExponent))) {
            goto i3;
        }
        return false;
        i3:
        $gX = $this->publicKeyFormat;
        $this->publicKeyFormat = $PR;
        $rd = $this->_convertPublicKey($this->modulus, $this->publicExponent);
        $this->publicKeyFormat = $gX;
        return $rd;
    }
    function getPublicKeyFingerprint($s0 = "\155\x64\x35")
    {
        if (!(empty($this->modulus) || empty($this->publicExponent))) {
            goto QX;
        }
        return false;
        QX:
        $Ke = $this->modulus->toBytes(true);
        $zN = $this->publicExponent->toBytes(true);
        $SW = pack("\x4e\141\52\x4e\x61\x2a\x4e\x61\52", strlen("\x73\163\x68\x2d\x72\x73\141"), "\163\x73\x68\x2d\x72\x73\141", strlen($zN), $zN, strlen($Ke), $Ke);
        switch ($s0) {
            case "\x73\150\141\62\65\x36":
                $cQ = new Crypt_Hash("\163\x68\141\62\65\66");
                $kY = base64_encode($cQ->hash($SW));
                return substr($kY, 0, strlen($kY) - 1);
            case "\x6d\x64\65":
                return substr(chunk_split(md5($SW), 2, "\72"), 0, -1);
            default:
                return false;
        }
        bI:
        xZ:
    }
    function getPrivateKey($PR = CRYPT_RSA_PUBLIC_FORMAT_PKCS1)
    {
        if (!empty($this->primes)) {
            goto QE;
        }
        return false;
        QE:
        $gX = $this->privateKeyFormat;
        $this->privateKeyFormat = $PR;
        $rd = $this->_convertPrivateKey($this->modulus, $this->publicExponent, $this->exponent, $this->primes, $this->exponents, $this->coefficients);
        $this->privateKeyFormat = $gX;
        return $rd;
    }
    function _getPrivatePublicKey($ke = CRYPT_RSA_PUBLIC_FORMAT_PKCS8)
    {
        if (!(empty($this->modulus) || empty($this->exponent))) {
            goto Cy;
        }
        return false;
        Cy:
        $gX = $this->publicKeyFormat;
        $this->publicKeyFormat = $ke;
        $rd = $this->_convertPublicKey($this->modulus, $this->exponent);
        $this->publicKeyFormat = $gX;
        return $rd;
    }
    function __toString()
    {
        $qV = $this->getPrivateKey($this->privateKeyFormat);
        if (!($qV !== false)) {
            goto Rb;
        }
        return $qV;
        Rb:
        $qV = $this->_getPrivatePublicKey($this->publicKeyFormat);
        return $qV !== false ? $qV : '';
    }
    function __clone()
    {
        $qV = new Crypt_RSA();
        $qV->loadKey($this);
        return $qV;
    }
    function _generateMinMax($Hg)
    {
        $Wp = $Hg >> 3;
        $BU = str_repeat(chr(0), $Wp);
        $Wa = str_repeat(chr(255), $Wp);
        $PE = $Hg & 7;
        if ($PE) {
            goto iJ;
        }
        $BU[0] = chr(128);
        goto J_;
        iJ:
        $BU = chr(1 << $PE - 1) . $BU;
        $Wa = chr((1 << $PE) - 1) . $Wa;
        J_:
        return array("\x6d\151\156" => new Math_BigInteger($BU, 256), "\x6d\141\170" => new Math_BigInteger($Wa, 256));
    }
    function _decodeLength(&$Fp)
    {
        $Yy = ord($this->_string_shift($Fp));
        if (!($Yy & 128)) {
            goto Xa;
        }
        $Yy &= 127;
        $rd = $this->_string_shift($Fp, $Yy);
        list(, $Yy) = unpack("\x4e", substr(str_pad($rd, 4, chr(0), STR_PAD_LEFT), -4));
        Xa:
        return $Yy;
    }
    function _encodeLength($Yy)
    {
        if (!($Yy <= 127)) {
            goto rb;
        }
        return chr($Yy);
        rb:
        $rd = ltrim(pack("\116", $Yy), chr(0));
        return pack("\x43\x61\52", 128 | strlen($rd), $rd);
    }
    function _string_shift(&$Fp, $iN = 1)
    {
        $Mq = substr($Fp, 0, $iN);
        $Fp = substr($Fp, $iN);
        return $Mq;
    }
    function setPrivateKeyFormat($Co)
    {
        $this->privateKeyFormat = $Co;
    }
    function setPublicKeyFormat($Co)
    {
        $this->publicKeyFormat = $Co;
    }
    function setHash($cQ)
    {
        switch ($cQ) {
            case "\155\144\62":
            case "\155\x64\65":
            case "\163\x68\141\61":
            case "\x73\x68\141\62\65\x36":
            case "\x73\x68\141\63\70\64":
            case "\163\150\141\65\x31\62":
                $this->hash = new Crypt_Hash($cQ);
                $this->hashName = $cQ;
                goto LW;
            default:
                $this->hash = new Crypt_Hash("\x73\150\141\x31");
                $this->hashName = "\163\150\x61\x31";
        }
        va:
        LW:
        $this->hLen = $this->hash->getLength();
    }
    function setMGFHash($cQ)
    {
        switch ($cQ) {
            case "\155\x64\62":
            case "\155\144\65":
            case "\x73\150\141\x31":
            case "\163\x68\141\x32\65\66":
            case "\x73\150\141\63\70\64":
            case "\163\x68\x61\65\x31\62":
                $this->mgfHash = new Crypt_Hash($cQ);
                goto Mc;
            default:
                $this->mgfHash = new Crypt_Hash("\x73\x68\141\61");
        }
        MK:
        Mc:
        $this->mgfHLen = $this->mgfHash->getLength();
    }
    function setSaltLength($zz)
    {
        $this->sLen = $zz;
    }
    function _i2osp($hs, $Sr)
    {
        $hs = $hs->toBytes();
        if (!(strlen($hs) > $Sr)) {
            goto jT;
        }
        user_error("\111\x6e\x74\145\x67\145\x72\x20\x74\x6f\157\40\154\141\x72\147\145");
        return false;
        jT:
        return str_pad($hs, $Sr, chr(0), STR_PAD_LEFT);
    }
    function _os2ip($hs)
    {
        return new Math_BigInteger($hs, 256);
    }
    function _exponentiate($hs)
    {
        switch (true) {
            case empty($this->primes):
            case $this->primes[1]->equals($this->zero):
            case empty($this->coefficients):
            case $this->coefficients[2]->equals($this->zero):
            case empty($this->exponents):
            case $this->exponents[1]->equals($this->zero):
                return $hs->modPow($this->exponent, $this->modulus);
        }
        wA:
        Ws:
        $SC = count($this->primes);
        if (defined("\x43\x52\x59\x50\x54\x5f\x52\123\101\137\104\111\123\x41\x42\114\105\137\x42\114\x49\116\104\111\x4e\107")) {
            goto t3;
        }
        $iQ = $this->primes[1];
        $MC = 2;
        Fg:
        if (!($MC <= $SC)) {
            goto uA;
        }
        if (!($iQ->compare($this->primes[$MC]) > 0)) {
            goto Jr;
        }
        $iQ = $this->primes[$MC];
        Jr:
        tZ:
        $MC++;
        goto Fg;
        uA:
        $ix = new Math_BigInteger(1);
        $Y4 = $ix->random($ix, $iQ->subtract($ix));
        $A1 = array(1 => $this->_blind($hs, $Y4, 1), 2 => $this->_blind($hs, $Y4, 2));
        $NK = $A1[1]->subtract($A1[2]);
        $NK = $NK->multiply($this->coefficients[2]);
        list(, $NK) = $NK->divide($this->primes[1]);
        $pf = $A1[2]->add($NK->multiply($this->primes[2]));
        $Y4 = $this->primes[1];
        $MC = 3;
        ce:
        if (!($MC <= $SC)) {
            goto H7;
        }
        $A1 = $this->_blind($hs, $Y4, $MC);
        $Y4 = $Y4->multiply($this->primes[$MC - 1]);
        $NK = $A1->subtract($pf);
        $NK = $NK->multiply($this->coefficients[$MC]);
        list(, $NK) = $NK->divide($this->primes[$MC]);
        $pf = $pf->add($Y4->multiply($NK));
        Wb:
        $MC++;
        goto ce;
        H7:
        goto D1;
        t3:
        $A1 = array(1 => $hs->modPow($this->exponents[1], $this->primes[1]), 2 => $hs->modPow($this->exponents[2], $this->primes[2]));
        $NK = $A1[1]->subtract($A1[2]);
        $NK = $NK->multiply($this->coefficients[2]);
        list(, $NK) = $NK->divide($this->primes[1]);
        $pf = $A1[2]->add($NK->multiply($this->primes[2]));
        $Y4 = $this->primes[1];
        $MC = 3;
        hI:
        if (!($MC <= $SC)) {
            goto FF;
        }
        $A1 = $hs->modPow($this->exponents[$MC], $this->primes[$MC]);
        $Y4 = $Y4->multiply($this->primes[$MC - 1]);
        $NK = $A1->subtract($pf);
        $NK = $NK->multiply($this->coefficients[$MC]);
        list(, $NK) = $NK->divide($this->primes[$MC]);
        $pf = $pf->add($Y4->multiply($NK));
        Yx:
        $MC++;
        goto hI;
        FF:
        D1:
        return $pf;
    }
    function _blind($hs, $Y4, $MC)
    {
        $hs = $hs->multiply($Y4->modPow($this->publicExponent, $this->primes[$MC]));
        $hs = $hs->modPow($this->exponents[$MC], $this->primes[$MC]);
        $Y4 = $Y4->modInverse($this->primes[$MC]);
        $hs = $hs->multiply($Y4);
        list(, $hs) = $hs->divide($this->primes[$MC]);
        return $hs;
    }
    function _equals($hs, $mc)
    {
        if (!(strlen($hs) != strlen($mc))) {
            goto gd;
        }
        return false;
        gd:
        $mE = 0;
        $MC = 0;
        Zx:
        if (!($MC < strlen($hs))) {
            goto v7;
        }
        $mE |= ord($hs[$MC]) ^ ord($mc[$MC]);
        nP:
        $MC++;
        goto Zx;
        v7:
        return $mE == 0;
    }
    function _rsaep($pf)
    {
        if (!($pf->compare($this->zero) < 0 || $pf->compare($this->modulus) > 0)) {
            goto Pe;
        }
        user_error("\115\x65\163\x73\141\147\x65\x20\x72\x65\160\x72\x65\163\145\x6e\164\141\164\151\x76\145\40\157\x75\x74\40\x6f\146\x20\162\x61\156\147\x65");
        return false;
        Pe:
        return $this->_exponentiate($pf);
    }
    function _rsadp($Wx)
    {
        if (!($Wx->compare($this->zero) < 0 || $Wx->compare($this->modulus) > 0)) {
            goto SD;
        }
        user_error("\x43\151\x70\x68\145\x72\x74\x65\x78\x74\40\162\x65\160\162\145\x73\145\x6e\164\141\164\151\x76\145\40\157\165\164\x20\x6f\146\x20\x72\141\156\x67\x65");
        return false;
        SD:
        return $this->_exponentiate($Wx);
    }
    function _rsasp1($pf)
    {
        if (!($pf->compare($this->zero) < 0 || $pf->compare($this->modulus) > 0)) {
            goto BG;
        }
        user_error("\115\145\x73\x73\141\147\x65\x20\162\145\x70\x72\145\163\x65\x6e\x74\x61\164\x69\166\x65\40\157\165\164\x20\157\x66\40\162\141\x6e\x67\x65");
        return false;
        BG:
        return $this->_exponentiate($pf);
    }
    function _rsavp1($T6)
    {
        if (!($T6->compare($this->zero) < 0 || $T6->compare($this->modulus) > 0)) {
            goto qY;
        }
        user_error("\123\151\147\156\141\x74\165\x72\145\40\x72\x65\160\x72\x65\163\145\156\164\141\164\151\166\145\x20\x6f\x75\164\40\157\146\40\162\141\156\147\145");
        return false;
        qY:
        return $this->_exponentiate($T6);
    }
    function _mgf1($DA, $bl)
    {
        $e9 = '';
        $wN = ceil($bl / $this->mgfHLen);
        $MC = 0;
        Ot:
        if (!($MC < $wN)) {
            goto EA;
        }
        $Wx = pack("\116", $MC);
        $e9 .= $this->mgfHash->hash($DA . $Wx);
        Of:
        $MC++;
        goto Ot;
        EA:
        return substr($e9, 0, $bl);
    }
    function _rsaes_oaep_encrypt($pf, $L0 = '')
    {
        $As = strlen($pf);
        if (!($As > $this->k - 2 * $this->hLen - 2)) {
            goto C4;
        }
        user_error("\x4d\x65\x73\163\141\147\145\x20\164\x6f\x6f\x20\x6c\157\156\x67");
        return false;
        C4:
        $kj = $this->hash->hash($L0);
        $f4 = str_repeat(chr(0), $this->k - $As - 2 * $this->hLen - 2);
        $Oh = $kj . $f4 . chr(1) . $pf;
        $Ci = crypt_random_string($this->hLen);
        $Bu = $this->_mgf1($Ci, $this->k - $this->hLen - 1);
        $fP = $Oh ^ $Bu;
        $k6 = $this->_mgf1($fP, $this->hLen);
        $at = $Ci ^ $k6;
        $Xi = chr(0) . $at . $fP;
        $pf = $this->_os2ip($Xi);
        $Wx = $this->_rsaep($pf);
        $Wx = $this->_i2osp($Wx, $this->k);
        return $Wx;
    }
    function _rsaes_oaep_decrypt($Wx, $L0 = '')
    {
        if (!(strlen($Wx) != $this->k || $this->k < 2 * $this->hLen + 2)) {
            goto bm;
        }
        user_error("\104\145\143\162\171\160\164\151\157\x6e\40\x65\162\x72\157\162");
        return false;
        bm:
        $Wx = $this->_os2ip($Wx);
        $pf = $this->_rsadp($Wx);
        if (!($pf === false)) {
            goto hp;
        }
        user_error("\x44\x65\x63\162\x79\x70\x74\151\157\156\40\x65\x72\162\x6f\162");
        return false;
        hp:
        $Xi = $this->_i2osp($pf, $this->k);
        $kj = $this->hash->hash($L0);
        $mc = ord($Xi[0]);
        $at = substr($Xi, 1, $this->hLen);
        $fP = substr($Xi, $this->hLen + 1);
        $k6 = $this->_mgf1($fP, $this->hLen);
        $Ci = $at ^ $k6;
        $Bu = $this->_mgf1($Ci, $this->k - $this->hLen - 1);
        $Oh = $fP ^ $Bu;
        $vf = substr($Oh, 0, $this->hLen);
        $pf = substr($Oh, $this->hLen);
        if ($this->_equals($kj, $vf)) {
            goto Ks;
        }
        user_error("\104\145\143\162\171\160\x74\151\x6f\x6e\40\x65\x72\162\157\162");
        return false;
        Ks:
        $pf = ltrim($pf, chr(0));
        if (!(ord($pf[0]) != 1)) {
            goto dy;
        }
        user_error("\104\145\x63\x72\x79\160\164\x69\x6f\156\40\145\x72\x72\157\162");
        return false;
        dy:
        return substr($pf, 1);
    }
    function _raw_encrypt($pf)
    {
        $rd = $this->_os2ip($pf);
        $rd = $this->_rsaep($rd);
        return $this->_i2osp($rd, $this->k);
    }
    function _rsaes_pkcs1_v1_5_encrypt($pf)
    {
        $As = strlen($pf);
        if (!($As > $this->k - 11)) {
            goto Ha;
        }
        user_error("\x4d\x65\163\x73\x61\x67\145\x20\164\157\157\x20\x6c\x6f\156\147");
        return false;
        Ha:
        $BD = $this->k - $As - 3;
        $f4 = '';
        CN:
        if (!(strlen($f4) != $BD)) {
            goto e9;
        }
        $rd = crypt_random_string($BD - strlen($f4));
        $rd = str_replace("\x0", '', $rd);
        $f4 .= $rd;
        goto CN;
        e9:
        $PR = 2;
        if (!(defined("\x43\x52\x59\x50\x54\x5f\x52\x53\x41\x5f\120\113\x43\x53\x31\x35\x5f\103\117\115\x50\x41\x54") && (!isset($this->publicExponent) || $this->exponent !== $this->publicExponent))) {
            goto cc;
        }
        $PR = 1;
        $f4 = str_repeat("\377", $BD);
        cc:
        $Xi = chr(0) . chr($PR) . $f4 . chr(0) . $pf;
        $pf = $this->_os2ip($Xi);
        $Wx = $this->_rsaep($pf);
        $Wx = $this->_i2osp($Wx, $this->k);
        return $Wx;
    }
    function _rsaes_pkcs1_v1_5_decrypt($Wx)
    {
        if (!(strlen($Wx) != $this->k)) {
            goto db;
        }
        user_error("\104\145\x63\162\x79\160\164\x69\157\x6e\x20\145\162\162\157\x72");
        return false;
        db:
        $Wx = $this->_os2ip($Wx);
        $pf = $this->_rsadp($Wx);
        if (!($pf === false)) {
            goto MU;
        }
        user_error("\x44\145\143\x72\171\160\x74\x69\x6f\x6e\x20\145\x72\x72\x6f\162");
        return false;
        MU:
        $Xi = $this->_i2osp($pf, $this->k);
        if (!(ord($Xi[0]) != 0 || ord($Xi[1]) > 2)) {
            goto RA;
        }
        user_error("\104\x65\x63\x72\x79\160\164\x69\157\x6e\x20\145\x72\x72\x6f\162");
        return false;
        RA:
        $f4 = substr($Xi, 2, strpos($Xi, chr(0), 2) - 2);
        $pf = substr($Xi, strlen($f4) + 3);
        if (!(strlen($f4) < 8)) {
            goto pj;
        }
        user_error("\x44\x65\x63\x72\x79\160\164\x69\x6f\156\x20\145\x72\x72\x6f\x72");
        return false;
        pj:
        return $pf;
    }
    function _emsa_pss_encode($pf, $FF)
    {
        $XB = $FF + 1 >> 3;
        $zz = $this->sLen !== null ? $this->sLen : $this->hLen;
        $ZF = $this->hash->hash($pf);
        if (!($XB < $this->hLen + $zz + 2)) {
            goto aZ;
        }
        user_error("\105\156\143\x6f\144\x69\x6e\147\40\145\x72\162\x6f\162");
        return false;
        aZ:
        $EH = crypt_random_string($zz);
        $FM = "\0\0\x0\x0\x0\0\0\x0" . $ZF . $EH;
        $NK = $this->hash->hash($FM);
        $f4 = str_repeat(chr(0), $XB - $zz - $this->hLen - 2);
        $Oh = $f4 . chr(1) . $EH;
        $Bu = $this->_mgf1($NK, $XB - $this->hLen - 1);
        $fP = $Oh ^ $Bu;
        $fP[0] = ~chr(255 << ($FF & 7)) & $fP[0];
        $Xi = $fP . $NK . chr(188);
        return $Xi;
    }
    function _emsa_pss_verify($pf, $Xi, $FF)
    {
        $XB = $FF + 1 >> 3;
        $zz = $this->sLen !== null ? $this->sLen : $this->hLen;
        $ZF = $this->hash->hash($pf);
        if (!($XB < $this->hLen + $zz + 2)) {
            goto vi;
        }
        return false;
        vi:
        if (!($Xi[strlen($Xi) - 1] != chr(188))) {
            goto Kj;
        }
        return false;
        Kj:
        $fP = substr($Xi, 0, -$this->hLen - 1);
        $NK = substr($Xi, -$this->hLen - 1, $this->hLen);
        $rd = chr(255 << ($FF & 7));
        if (!((~$fP[0] & $rd) != $rd)) {
            goto IX;
        }
        return false;
        IX:
        $Bu = $this->_mgf1($NK, $XB - $this->hLen - 1);
        $Oh = $fP ^ $Bu;
        $Oh[0] = ~chr(255 << ($FF & 7)) & $Oh[0];
        $rd = $XB - $this->hLen - $zz - 2;
        if (!(substr($Oh, 0, $rd) != str_repeat(chr(0), $rd) || ord($Oh[$rd]) != 1)) {
            goto C1;
        }
        return false;
        C1:
        $EH = substr($Oh, $rd + 1);
        $FM = "\0\x0\0\0\0\x0\0\x0" . $ZF . $EH;
        $Z2 = $this->hash->hash($FM);
        return $this->_equals($NK, $Z2);
    }
    function _rsassa_pss_sign($pf)
    {
        $Xi = $this->_emsa_pss_encode($pf, 8 * $this->k - 1);
        $pf = $this->_os2ip($Xi);
        $T6 = $this->_rsasp1($pf);
        $T6 = $this->_i2osp($T6, $this->k);
        return $T6;
    }
    function _rsassa_pss_verify($pf, $T6)
    {
        if (!(strlen($T6) != $this->k)) {
            goto GA;
        }
        user_error("\111\156\166\x61\154\x69\144\40\x73\x69\147\156\x61\x74\x75\162\x65");
        return false;
        GA:
        $gP = 8 * $this->k;
        $CH = $this->_os2ip($T6);
        $FM = $this->_rsavp1($CH);
        if (!($FM === false)) {
            goto Jw;
        }
        user_error("\111\156\166\x61\154\151\x64\x20\163\151\147\156\141\164\x75\162\145");
        return false;
        Jw:
        $Xi = $this->_i2osp($FM, $gP >> 3);
        if (!($Xi === false)) {
            goto Oz;
        }
        user_error("\111\156\166\141\154\x69\144\x20\163\x69\147\x6e\141\x74\x75\x72\x65");
        return false;
        Oz:
        return $this->_emsa_pss_verify($pf, $Xi, $gP - 1);
    }
    function _emsa_pkcs1_v1_5_encode($pf, $XB)
    {
        $NK = $this->hash->hash($pf);
        if (!($NK === false)) {
            goto YC;
        }
        return false;
        YC:
        switch ($this->hashName) {
            case "\x6d\x64\62":
                $e9 = pack("\x48\52", "\x33\x30\x32\60\x33\x30\x30\x63\x30\66\60\x38\62\x61\70\x36\x34\70\x38\x36\146\67\x30\x64\60\x32\60\62\x30\x35\x30\x30\x30\x34\61\60");
                goto GJ;
            case "\155\x64\65":
                $e9 = pack("\110\x2a", "\x33\60\x32\x30\x33\60\60\x63\60\66\x30\70\x32\x61\70\66\x34\70\70\66\x66\67\60\144\x30\62\x30\x35\60\x35\60\x30\x30\64\x31\x30");
                goto GJ;
            case "\163\150\141\x31":
                $e9 = pack("\110\52", "\63\x30\62\x31\63\60\x30\71\x30\66\60\x35\62\142\60\x65\x30\x33\x30\62\61\x61\x30\x35\60\x30\60\x34\x31\64");
                goto GJ;
            case "\163\150\141\62\x35\66":
                $e9 = pack("\x48\52", "\x33\60\x33\x31\x33\60\x30\144\x30\66\x30\71\66\x30\70\x36\x34\70\60\61\66\65\60\x33\x30\64\60\x32\60\61\60\65\x30\60\60\x34\62\60");
                goto GJ;
            case "\x73\x68\x61\63\70\x34":
                $e9 = pack("\x48\52", "\63\60\64\61\63\60\x30\144\60\66\60\71\66\x30\x38\x36\64\x38\x30\61\66\x35\x30\x33\60\64\60\x32\x30\62\x30\65\60\x30\60\x34\63\x30");
                goto GJ;
            case "\163\150\141\x35\61\62":
                $e9 = pack("\110\x2a", "\x33\60\x35\61\63\60\x30\x64\x30\x36\60\x39\66\x30\70\66\64\x38\x30\x31\66\x35\60\x33\60\64\60\62\x30\63\x30\x35\x30\60\x30\x34\64\60");
        }
        Px:
        GJ:
        $e9 .= $NK;
        $J3 = strlen($e9);
        if (!($XB < $J3 + 11)) {
            goto At;
        }
        user_error("\111\156\164\145\156\x64\x65\x64\40\x65\x6e\143\157\144\145\x64\x20\x6d\145\x73\163\141\147\x65\x20\x6c\145\x6e\147\x74\x68\x20\164\157\157\x20\163\x68\x6f\162\x74");
        return false;
        At:
        $f4 = str_repeat(chr(255), $XB - $J3 - 3);
        $Xi = "\0\1{$f4}\0{$e9}";
        return $Xi;
    }
    function _rsassa_pkcs1_v1_5_sign($pf)
    {
        $Xi = $this->_emsa_pkcs1_v1_5_encode($pf, $this->k);
        if (!($Xi === false)) {
            goto LC;
        }
        user_error("\x52\x53\101\40\155\x6f\x64\165\x6c\x75\x73\x20\164\x6f\x6f\40\163\150\x6f\x72\164");
        return false;
        LC:
        $pf = $this->_os2ip($Xi);
        $T6 = $this->_rsasp1($pf);
        $T6 = $this->_i2osp($T6, $this->k);
        return $T6;
    }
    function _rsassa_pkcs1_v1_5_verify($pf, $T6)
    {
        if (!(strlen($T6) != $this->k)) {
            goto Sl;
        }
        user_error("\111\156\x76\x61\154\151\x64\x20\163\151\147\x6e\x61\x74\165\x72\x65");
        return false;
        Sl:
        $T6 = $this->_os2ip($T6);
        $FM = $this->_rsavp1($T6);
        if (!($FM === false)) {
            goto tX;
        }
        user_error("\x49\x6e\166\x61\154\x69\144\40\163\x69\147\156\141\164\x75\x72\145");
        return false;
        tX:
        $Xi = $this->_i2osp($FM, $this->k);
        if (!($Xi === false)) {
            goto OI;
        }
        user_error("\x49\x6e\x76\141\154\x69\x64\40\163\151\x67\156\x61\x74\x75\162\145");
        return false;
        OI:
        $MG = $this->_emsa_pkcs1_v1_5_encode($pf, $this->k);
        if (!($MG === false)) {
            goto yC;
        }
        user_error("\x52\x53\101\40\x6d\157\x64\165\x6c\165\x73\40\x74\157\x6f\x20\163\150\157\162\164");
        return false;
        yC:
        return $this->_equals($Xi, $MG);
    }
    function setEncryptionMode($ke)
    {
        $this->encryptionMode = $ke;
    }
    function setSignatureMode($ke)
    {
        $this->signatureMode = $ke;
    }
    function setComment($dZ)
    {
        $this->comment = $dZ;
    }
    function getComment()
    {
        return $this->comment;
    }
    function encrypt($IB)
    {
        switch ($this->encryptionMode) {
            case CRYPT_RSA_ENCRYPTION_NONE:
                $IB = str_split($IB, $this->k);
                $Z4 = '';
                foreach ($IB as $pf) {
                    $Z4 .= $this->_raw_encrypt($pf);
                    eL:
                }
                lt:
                return $Z4;
            case CRYPT_RSA_ENCRYPTION_PKCS1:
                $Yy = $this->k - 11;
                if (!($Yy <= 0)) {
                    goto s0;
                }
                return false;
                s0:
                $IB = str_split($IB, $Yy);
                $Z4 = '';
                foreach ($IB as $pf) {
                    $Z4 .= $this->_rsaes_pkcs1_v1_5_encrypt($pf);
                    Qd:
                }
                Q7:
                return $Z4;
            default:
                $Yy = $this->k - 2 * $this->hLen - 2;
                if (!($Yy <= 0)) {
                    goto uR;
                }
                return false;
                uR:
                $IB = str_split($IB, $Yy);
                $Z4 = '';
                foreach ($IB as $pf) {
                    $Z4 .= $this->_rsaes_oaep_encrypt($pf);
                    PI:
                }
                nE:
                return $Z4;
        }
        dB:
        hd:
    }
    function decrypt($Z4)
    {
        if (!($this->k <= 0)) {
            goto Iy;
        }
        return false;
        Iy:
        $Z4 = str_split($Z4, $this->k);
        $Z4[count($Z4) - 1] = str_pad($Z4[count($Z4) - 1], $this->k, chr(0), STR_PAD_LEFT);
        $IB = '';
        switch ($this->encryptionMode) {
            case CRYPT_RSA_ENCRYPTION_NONE:
                $fn = "\137\162\141\x77\137\145\156\143\x72\171\160\164";
                goto j9;
            case CRYPT_RSA_ENCRYPTION_PKCS1:
                $fn = "\x5f\162\163\x61\x65\x73\137\x70\153\143\163\61\137\x76\x31\x5f\x35\x5f\x64\x65\x63\x72\171\160\164";
                goto j9;
            default:
                $fn = "\137\x72\x73\x61\x65\163\137\x6f\141\145\160\137\144\145\143\162\x79\160\x74";
        }
        F3:
        j9:
        foreach ($Z4 as $Wx) {
            $rd = $this->{$fn}($Wx);
            if (!($rd === false)) {
                goto WM;
            }
            return false;
            WM:
            $IB .= $rd;
            nK:
        }
        nW:
        return $IB;
    }
    function sign($wP)
    {
        if (!(empty($this->modulus) || empty($this->exponent))) {
            goto gh;
        }
        return false;
        gh:
        switch ($this->signatureMode) {
            case CRYPT_RSA_SIGNATURE_PKCS1:
                return $this->_rsassa_pkcs1_v1_5_sign($wP);
            default:
                return $this->_rsassa_pss_sign($wP);
        }
        Y7:
        g5:
    }
    function verify($wP, $PV)
    {
        if (!(empty($this->modulus) || empty($this->exponent))) {
            goto Jd;
        }
        return false;
        Jd:
        switch ($this->signatureMode) {
            case CRYPT_RSA_SIGNATURE_PKCS1:
                return $this->_rsassa_pkcs1_v1_5_verify($wP, $PV);
            default:
                return $this->_rsassa_pss_verify($wP, $PV);
        }
        oB:
        bM:
    }
    function _extractBER($qM)
    {
        $rd = preg_replace("\x23\56\52\77\136\55\x2b\133\x5e\55\x5d\53\55\53\x5b\x5c\162\134\156\x20\135\x2a\44\43\155\x73", '', $qM, 1);
        $rd = preg_replace("\x23\x2d\x2b\133\136\55\x5d\x2b\55\x2b\x23", '', $rd);
        $rd = str_replace(array("\xd", "\12", "\x20"), '', $rd);
        $rd = preg_match("\43\x5e\x5b\141\x2d\x7a\x41\55\132\134\144\x2f\x2b\135\52\75\173\x30\54\62\175\x24\x23", $rd) ? base64_decode($rd) : false;
        return $rd != false ? $rd : $qM;
    }
}
