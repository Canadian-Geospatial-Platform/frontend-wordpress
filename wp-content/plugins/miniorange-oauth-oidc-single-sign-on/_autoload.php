<?php


if (defined("\x41\x42\x53\120\101\x54\110")) {
    goto v_b;
}
die;
v_b:
define("\x4d\117\103\137\104\111\x52", plugin_dir_path(__FILE__));
define("\115\x4f\x43\x5f\x55\122\x4c", plugin_dir_url(__FILE__));
define("\x4d\117\137\125\111\104", "\104\106\x38\x56\x4b\x4a\x4f\x35\x46\104\x48\132\101\122\102\x52\x35\x5a\x44\123\62\x56\65\x4a\66\66\125\62\x4e\x44\122");
define("\126\x45\x52\123\x49\117\x4e", "\x6d\157\x5f\x65\x6e\164\145\x72\160\x72\x69\163\x65\137\166\145\162\x73\x69\157\x6e");
include_file(MOC_DIR . "\57\x63\x6c\141\x73\x73\145\163\x2f\x63\x6f\x6d\155\x6f\x6e");
include_file(MOC_DIR . "\57\x63\x6c\x61\163\163\145\x73\57\x46\162\145\145");
include_file(MOC_DIR . "\x2f\x63\154\141\163\x73\x65\163\x2f\x53\164\x61\156\x64\x61\x72\144");
include_file(MOC_DIR . "\57\x63\154\x61\x73\x73\x65\x73\57\120\x72\x65\x6d\151\165\155");
include_file(MOC_DIR . "\x2f\143\x6c\141\x73\163\x65\x73\x2f\x45\156\x74\x65\x72\160\x72\151\163\145");
function get_dir_contents($mS, &$mJ = array())
{
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($mS, RecursiveDirectoryIterator::KEY_AS_PATHNAME), RecursiveIteratorIterator::CHILD_FIRST) as $WI => $rh) {
        if (!($rh->isFile() && $rh->isReadable())) {
            goto k2R;
        }
        $mJ[$WI] = realpath($rh->getPathname());
        k2R:
        v2e:
    }
    ipg:
    return $mJ;
}
function get_sorted_files($mS)
{
    $LT = get_dir_contents($mS);
    $i3 = array();
    $sx = array();
    foreach ($LT as $WI => $XV) {
        if (!(strpos($XV, "\56\160\x68\160") !== false)) {
            goto qP5;
        }
        if (strpos($XV, "\x49\x6e\164\x65\x72\x66\141\143\145") !== false) {
            goto sdq;
        }
        $sx[$WI] = $XV;
        goto AuA;
        sdq:
        $i3[$WI] = $XV;
        AuA:
        qP5:
        LKA:
    }
    Ule:
    return array("\151\x6e\164\145\x72\146\141\143\x65\x73" => $i3, "\143\x6c\141\163\163\x65\x73" => $sx);
}
function include_file($mS)
{
    if (is_dir($mS)) {
        goto yZm;
    }
    return;
    yZm:
    $mS = sane_dir_path($mS);
    $DB = realpath($mS);
    if (!(false !== $DB && !is_dir($mS))) {
        goto YSo;
    }
    return;
    YSo:
    $KX = get_sorted_files($mS);
    require_all($KX["\x69\x6e\164\x65\162\146\141\x63\145\x73"]);
    require_all($KX["\143\x6c\141\163\x73\x65\x73"]);
}
function require_all($LT)
{
    foreach ($LT as $WI => $XV) {
        require_once $XV;
        l8z:
    }
    F9p:
}
function is_valid_file($TL)
{
    return '' !== $TL && "\x2e" !== $TL && "\x2e\x2e" !== $TL;
}
function get_valid_html($w1 = array())
{
    $lL = array("\x73\164\x72\157\156\x67" => array(), "\x65\x6d" => array(), "\142" => array(), "\x69" => array(), "\x61" => array("\x68\162\145\x66" => array(), "\164\141\162\147\145\164" => array()));
    if (empty($w1)) {
        goto Vwx;
    }
    return array_merge($w1, $lL);
    Vwx:
    return $lL;
}
function get_version_number()
{
    $c_ = get_file_data(MOC_DIR . "\57\x6d\157\x5f\x6f\x61\x75\x74\x68\x5f\163\x65\x74\164\x69\156\147\163\56\x70\150\x70", array("\x56\145\x72\x73\x69\x6f\156"), "\x70\x6c\165\147\151\x6e");
    $m1 = isset($c_[0]) ? $c_[0] : '';
    return $m1;
}
function sane_dir_path($mS)
{
    return str_replace("\57", DIRECTORY_SEPARATOR, $mS);
}
if (function_exists("\151\x73\137\162\145\163\164")) {
    goto dCP;
}
function is_rest()
{
    $FX = rest_get_url_prefix();
    if (!(defined("\x52\105\123\x54\x5f\122\x45\121\125\105\x53\124") && REST_REQUEST || isset($_GET["\x72\x65\163\x74\x5f\x72\x6f\x75\x74\x65"]) && strpos(trim($_GET["\162\x65\x73\164\x5f\x72\157\x75\x74\x65"], "\x5c\57"), $FX, 0) === 0)) {
        goto KTm;
    }
    return true;
    KTm:
    global $hX;
    if (!($hX === null)) {
        goto E__;
    }
    $hX = new WP_Rewrite();
    E__:
    $Vb = wp_parse_url(trailingslashit(rest_url()));
    $Oi = wp_parse_url(add_query_arg(array()));
    return strpos($Oi["\160\x61\x74\x68"], $Vb["\160\141\164\x68"], 0) === 0;
}
dCP:
