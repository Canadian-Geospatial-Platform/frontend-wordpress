<?php


namespace MoOauthClient\GrantTypes;

if (function_exists("\x63\162\171\160\164\x5f\x72\141\156\x64\x6f\155\x5f\x73\164\162\151\156\x67")) {
    goto Zak;
}
define("\x43\122\x59\120\x54\x5f\x52\101\116\104\117\x4d\137\111\x53\137\127\111\x4e\104\117\127\x53", strtoupper(substr(PHP_OS, 0, 3)) === "\127\x49\x4e");
function crypt_random_string($Yy)
{
    if ($Yy) {
        goto HWo;
    }
    return '';
    HWo:
    if (CRYPT_RANDOM_IS_WINDOWS) {
        goto wgK;
    }
    if (!(extension_loaded("\x6f\160\145\x6e\163\163\x6c") && version_compare(PHP_VERSION, "\x35\56\63\x2e\x30", "\76\x3d"))) {
        goto YxZ;
    }
    return openssl_random_pseudo_bytes($Yy);
    YxZ:
    static $jG = true;
    if (!($jG === true)) {
        goto Hc0;
    }
    $jG = @fopen("\x2f\x64\x65\x76\x2f\165\162\141\156\x64\157\x6d", "\x72\x62");
    Hc0:
    if (!($jG !== true && $jG !== false)) {
        goto UqW;
    }
    return fread($jG, $Yy);
    UqW:
    if (!extension_loaded("\x6d\x63\x72\171\x70\x74")) {
        goto WCj;
    }
    return @mcrypt_create_iv($Yy, MCRYPT_DEV_URANDOM);
    WCj:
    goto HuZ;
    wgK:
    if (!(extension_loaded("\155\x63\x72\171\x70\x74") && version_compare(PHP_VERSION, "\65\56\x33\56\60", "\76\x3d"))) {
        goto tSl;
    }
    return @mcrypt_create_iv($Yy);
    tSl:
    if (!(extension_loaded("\157\160\145\x6e\163\x73\x6c") && version_compare(PHP_VERSION, "\x35\56\x33\56\x34", "\x3e\x3d"))) {
        goto hh2;
    }
    return openssl_random_pseudo_bytes($Yy);
    hh2:
    HuZ:
    static $sT = false, $xP;
    if (!($sT === false)) {
        goto wNF;
    }
    $mb = session_id();
    $AV = ini_get("\x73\x65\x73\x73\151\x6f\x6e\56\x75\163\x65\x5f\x63\x6f\157\x6b\x69\145\163");
    $Fa = session_cache_limiter();
    $zL = isset($_SESSION) ? $_SESSION : false;
    if (!($mb != '')) {
        goto FxR;
    }
    session_write_close();
    FxR:
    session_id(1);
    ini_set("\163\145\x73\x73\x69\x6f\x6e\x2e\165\163\x65\x5f\x63\157\157\x6b\151\145\163", 0);
    session_cache_limiter('');
    session_start(array("\162\x65\141\144\137\x61\156\144\x5f\143\154\157\163\x65" => true));
    $xP = $Ci = $_SESSION["\x73\145\x65\144"] = pack("\x48\52", sha1((isset($_SERVER) ? phpseclib_safe_serialize($_SERVER) : '') . (isset($_POST) ? phpseclib_safe_serialize($_POST) : '') . (isset($_GET) ? phpseclib_safe_serialize($_GET) : '') . (isset($_COOKIE) ? phpseclib_safe_serialize($_COOKIE) : '') . phpseclib_safe_serialize($GLOBALS) . phpseclib_safe_serialize($_SESSION) . phpseclib_safe_serialize($zL)));
    if (isset($_SESSION["\143\157\165\156\x74"])) {
        goto jRh;
    }
    $_SESSION["\143\x6f\165\x6e\x74"] = 0;
    jRh:
    $_SESSION["\143\x6f\x75\156\x74"]++;
    session_write_close();
    if ($mb != '') {
        goto j41;
    }
    if ($zL !== false) {
        goto wr2;
    }
    unset($_SESSION);
    goto Ras;
    wr2:
    $_SESSION = $zL;
    unset($zL);
    Ras:
    goto Cx4;
    j41:
    session_id($mb);
    session_start(array("\x72\145\141\144\137\141\156\x64\x5f\143\x6c\157\163\x65" => true));
    ini_set("\163\x65\163\163\x69\157\156\x2e\165\163\145\137\143\x6f\157\x6b\151\145\x73", $AV);
    session_cache_limiter($Fa);
    Cx4:
    $qV = pack("\x48\52", sha1($Ci . "\x41"));
    $hl = pack("\110\x2a", sha1($Ci . "\103"));
    switch (true) {
        case phpseclib_resolve_include_path("\103\162\x79\x70\x74\57\101\x45\123\x2e\x70\x68\x70"):
            if (class_exists("\x43\x72\x79\x70\x74\x5f\101\x45\x53")) {
                goto MIt;
            }
            include_once "\x41\105\123\56\160\150\x70";
            MIt:
            $sT = new Crypt_AES(CRYPT_AES_MODE_CTR);
            goto Zi3;
        case phpseclib_resolve_include_path("\x43\x72\171\x70\164\57\x54\167\157\146\x69\163\x68\x2e\160\x68\160"):
            if (class_exists("\103\162\x79\x70\164\137\x54\x77\157\x66\x69\163\x68")) {
                goto kVc;
            }
            include_once "\x54\167\157\x66\151\x73\150\x2e\160\150\x70";
            kVc:
            $sT = new Crypt_Twofish(CRYPT_TWOFISH_MODE_CTR);
            goto Zi3;
        case phpseclib_resolve_include_path("\x43\162\x79\160\164\x2f\x42\x6c\x6f\167\x66\x69\163\150\56\x70\x68\160"):
            if (class_exists("\x43\x72\171\160\164\x5f\x42\154\x6f\x77\x66\151\163\x68")) {
                goto ekw;
            }
            include_once "\102\x6c\x6f\167\x66\x69\163\150\x2e\x70\150\x70";
            ekw:
            $sT = new Crypt_Blowfish(CRYPT_BLOWFISH_MODE_CTR);
            goto Zi3;
        case phpseclib_resolve_include_path("\x43\x72\171\160\x74\57\x54\x72\x69\x70\154\x65\x44\105\123\x2e\160\x68\160"):
            if (class_exists("\103\x72\171\160\x74\x5f\124\162\x69\x70\154\145\104\105\x53")) {
                goto ute;
            }
            include_once "\x54\162\151\160\154\145\x44\105\x53\x2e\160\150\160";
            ute:
            $sT = new Crypt_TripleDES(CRYPT_DES_MODE_CTR);
            goto Zi3;
        case phpseclib_resolve_include_path("\x43\x72\x79\x70\x74\x2f\104\105\x53\x2e\160\150\160"):
            if (class_exists("\x43\162\171\x70\x74\137\x44\105\123")) {
                goto o1w;
            }
            include_once "\x44\105\x53\56\160\x68\160";
            o1w:
            $sT = new Crypt_DES(CRYPT_DES_MODE_CTR);
            goto Zi3;
        case phpseclib_resolve_include_path("\103\x72\171\160\164\57\x52\x43\64\x2e\x70\x68\160"):
            if (class_exists("\x43\x72\171\160\164\137\122\103\64")) {
                goto m_C;
            }
            include_once "\x52\103\x34\56\x70\x68\160";
            m_C:
            $sT = new Crypt_RC4();
            goto Zi3;
        default:
            user_error("\143\162\171\160\164\137\x72\141\156\x64\157\155\x5f\163\164\162\151\x6e\147\x20\x72\x65\x71\165\x69\162\145\x73\40\141\x74\x20\x6c\x65\141\x73\164\40\157\x6e\145\40\x73\x79\x6d\x6d\145\164\x72\x69\x63\x20\143\151\160\150\145\162\40\142\145\40\154\157\141\144\x65\x64");
            return false;
    }
    V2D:
    Zi3:
    $sT->setKey($qV);
    $sT->setIV($hl);
    $sT->enableContinuousBuffer();
    wNF:
    $mE = '';
    C3g:
    if (!(strlen($mE) < $Yy)) {
        goto kTw;
    }
    $MC = $sT->encrypt(microtime());
    $Y4 = $sT->encrypt($MC ^ $xP);
    $xP = $sT->encrypt($Y4 ^ $MC);
    $mE .= $Y4;
    goto C3g;
    kTw:
    return substr($mE, 0, $Yy);
}
Zak:
if (function_exists("\160\x68\x70\x73\x65\143\154\151\142\x5f\x73\x61\x66\x65\137\x73\x65\x72\151\x61\154\151\x7a\145")) {
    goto PV8;
}
function phpseclib_safe_serialize(&$cr)
{
    if (!is_object($cr)) {
        goto HTx;
    }
    return '';
    HTx:
    if (is_array($cr)) {
        goto GmE;
    }
    return serialize($cr);
    GmE:
    if (!isset($cr["\x5f\137\x70\x68\160\163\145\x63\154\151\142\x5f\155\141\162\153\145\x72"])) {
        goto VBm;
    }
    return '';
    VBm:
    $GD = array();
    $cr["\x5f\x5f\x70\150\160\163\145\x63\154\151\142\137\x6d\141\162\x6b\x65\x72"] = true;
    foreach (array_keys($cr) as $qV) {
        if (!($qV !== "\x5f\137\160\x68\160\x73\145\x63\154\151\x62\137\155\141\x72\153\x65\162")) {
            goto fVn;
        }
        $GD[$qV] = phpseclib_safe_serialize($cr[$qV]);
        fVn:
        gnB:
    }
    x5x:
    unset($cr["\x5f\137\x70\150\160\x73\x65\143\154\151\142\x5f\155\141\162\x6b\x65\x72"]);
    return serialize($GD);
}
PV8:
if (function_exists("\160\x68\x70\163\145\143\154\x69\142\x5f\162\x65\163\x6f\x6c\166\x65\137\x69\x6e\143\x6c\165\x64\145\x5f\x70\141\x74\x68")) {
    goto kpr;
}
function phpseclib_resolve_include_path($TL)
{
    if (!function_exists("\163\x74\x72\145\141\155\x5f\162\x65\163\x6f\154\x76\145\137\151\156\143\x6c\x75\x64\x65\137\x70\x61\164\150")) {
        goto dbJ;
    }
    return stream_resolve_include_path($TL);
    dbJ:
    if (!file_exists($TL)) {
        goto y4z;
    }
    return realpath($TL);
    y4z:
    $Vj = PATH_SEPARATOR == "\72" ? preg_split("\x23\50\x3f\74\41\160\x68\x61\162\x29\72\x23", get_include_path()) : explode(PATH_SEPARATOR, get_include_path());
    foreach ($Vj as $FX) {
        $eT = substr($FX, -1) == DIRECTORY_SEPARATOR ? '' : DIRECTORY_SEPARATOR;
        $WI = $FX . $eT . $TL;
        if (!file_exists($WI)) {
            goto BSe;
        }
        return realpath($WI);
        BSe:
        WQY:
    }
    aCw:
    return false;
}
kpr:
