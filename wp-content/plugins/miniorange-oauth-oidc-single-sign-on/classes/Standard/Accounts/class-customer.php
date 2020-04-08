<?php


namespace MoOauthClient\Standard;

use MoOauthClient\Customer as NormalCustomer;
class Customer extends NormalCustomer
{
    public $email;
    public $phone;
    private $default_customer_key = "\x31\66\x35\65\x35";
    private $default_api_key = "\146\x46\x64\x32\x58\143\x76\124\x47\104\x65\x6d\x5a\166\142\x77\x31\142\143\125\145\x73\x4e\112\127\105\161\113\142\x62\x55\161";
    public function check_customer_ln()
    {
        global $xW;
        $a8 = $xW->mo_oauth_client_get_option("\150\157\x73\x74\137\x6e\141\x6d\x65") . "\57\155\157\x61\x73\x2f\x72\x65\x73\x74\57\143\x75\163\x74\157\x6d\145\x72\57\154\151\x63\145\156\x73\x65";
        $mH = $xW->mo_oauth_client_get_option("\155\x6f\x5f\157\x61\x75\x74\150\x5f\x61\x64\155\151\156\137\143\165\163\x74\x6f\x6d\145\162\137\153\x65\171");
        $hQ = $xW->mo_oauth_client_get_option("\x6d\x6f\137\x6f\141\165\x74\150\x5f\x61\144\155\151\x6e\137\x61\160\x69\137\x6b\145\171");
        $ZD = $xW->mo_oauth_client_get_option("\155\157\137\x6f\141\x75\164\150\x5f\x61\x64\x6d\x69\x6e\137\145\155\141\x69\154");
        $Fs = $xW->mo_oauth_client_get_option("\x6d\157\x5f\x6f\141\x75\x74\150\x5f\x61\144\x6d\151\156\x5f\160\150\157\156\145");
        $Cu = self::get_timestamp();
        $cu = $mH . $Cu . $hQ;
        $nN = hash("\163\x68\x61\x35\x31\62", $cu);
        $e4 = "\103\165\163\164\157\155\145\162\55\113\145\x79\x3a\40" . $mH;
        $T5 = "\124\x69\x6d\145\163\164\x61\155\x70\x3a\x20" . $Cu;
        $c3 = "\101\165\164\x68\157\x72\x69\x7a\141\164\151\x6f\156\72\x20" . $nN;
        $AA = '';
        $AA = array("\143\165\x73\164\157\155\145\162\x49\144" => $mH, "\x61\x70\160\x6c\151\x63\141\164\x69\157\156\x4e\141\x6d\x65" => "\x77\x70\x5f\157\141\x75\164\150\x5f\143\x6c\x69\x65\x6e\x74\x5f" . \strtolower($xW->get_versi_str()) . "\x5f\x70\154\141\x6e");
        $ct = wp_json_encode($AA);
        $bk = array("\x43\157\x6e\164\145\156\x74\x2d\x54\x79\160\x65" => "\x61\160\160\x6c\151\x63\141\164\151\157\x6e\x2f\x6a\x73\157\x6e");
        $bk["\103\x75\163\164\157\155\x65\x72\55\x4b\x65\171"] = $mH;
        $bk["\x54\151\155\145\163\x74\x61\x6d\160"] = $Cu;
        $bk["\101\x75\x74\150\157\x72\x69\172\141\x74\x69\x6f\156"] = $nN;
        $w1 = array("\155\145\x74\x68\x6f\144" => "\x50\x4f\x53\x54", "\142\x6f\x64\x79" => $ct, "\164\x69\155\145\x6f\x75\164" => "\x35", "\162\x65\144\151\x72\x65\x63\x74\151\157\156" => "\x35", "\150\164\x74\x70\166\x65\162\x73\x69\x6f\x6e" => "\61\x2e\60", "\x62\154\x6f\143\x6b\x69\x6e\147" => true, "\x68\145\141\144\x65\x72\x73" => $bk);
        $sL = wp_remote_post($a8, $w1);
        if (!is_wp_error($sL)) {
            goto qtO;
        }
        $N5 = $sL->get_error_message();
        echo "\x53\x6f\155\x65\164\150\151\156\x67\40\x77\x65\156\164\x20\x77\162\x6f\156\147\x3a\40{$N5}";
        die;
        qtO:
        return wp_remote_retrieve_body($sL);
    }
    public function XfskodsfhHJ($tY)
    {
        global $xW;
        $a8 = $xW->mo_oauth_client_get_option("\x68\157\163\164\137\x6e\141\155\x65") . "\57\x6d\157\141\x73\57\x61\x70\x69\57\142\x61\143\153\165\160\x63\x6f\144\145\x2f\166\x65\162\x69\x66\171";
        $mH = $xW->mo_oauth_client_get_option("\x6d\x6f\x5f\x6f\141\x75\x74\x68\137\x61\x64\155\151\156\x5f\143\x75\163\x74\x6f\155\145\x72\137\x6b\145\171");
        $hQ = $xW->mo_oauth_client_get_option("\155\x6f\137\x6f\x61\x75\164\150\x5f\141\x64\155\151\x6e\x5f\141\160\151\x5f\153\145\171");
        $ZD = $xW->mo_oauth_client_get_option("\155\x6f\137\157\141\165\164\x68\137\141\x64\155\151\x6e\137\x65\x6d\141\x69\154");
        $Fs = $xW->mo_oauth_client_get_option("\x6d\x6f\137\157\x61\x75\x74\150\x5f\x61\x64\155\x69\x6e\x5f\160\150\x6f\x6e\x65");
        $Cu = self::get_timestamp();
        $cu = $mH . $Cu . $hQ;
        $nN = hash("\x73\x68\x61\x35\61\62", $cu);
        $e4 = "\x43\x75\163\x74\x6f\x6d\x65\162\x2d\x4b\145\x79\72\x20" . $mH;
        $T5 = "\124\151\155\x65\163\x74\x61\155\x70\72\x20" . $Cu;
        $c3 = "\x41\165\164\150\x6f\x72\151\172\x61\x74\x69\x6f\156\72\40" . $nN;
        $AA = '';
        $AA = array("\143\157\x64\x65" => $tY, "\x63\x75\163\x74\157\x6d\x65\162\113\x65\x79" => $mH, "\141\x64\x64\151\164\x69\x6f\x6e\141\x6c\x46\151\145\x6c\144\x73" => array("\x66\151\x65\154\x64\61" => site_url()));
        $ct = wp_json_encode($AA);
        $bk = array("\103\157\x6e\x74\x65\x6e\164\x2d\124\x79\160\145" => "\141\160\x70\x6c\x69\143\141\164\x69\157\156\57\152\163\157\156");
        $bk["\x43\165\x73\164\157\x6d\x65\162\x2d\113\145\x79"] = $mH;
        $bk["\x54\151\x6d\145\x73\164\141\155\160"] = $Cu;
        $bk["\x41\x75\x74\150\157\162\151\x7a\141\164\x69\x6f\156"] = $nN;
        $w1 = array("\155\145\x74\150\x6f\x64" => "\x50\x4f\123\124", "\x62\157\x64\x79" => $ct, "\x74\151\x6d\x65\157\x75\x74" => "\x35", "\x72\145\x64\x69\162\145\143\x74\151\157\x6e" => "\65", "\x68\164\x74\x70\x76\145\162\163\151\157\156" => "\x31\56\x30", "\x62\154\157\143\153\x69\x6e\x67" => true, "\150\x65\141\144\x65\162\x73" => $bk);
        $sL = wp_remote_post($a8, $w1);
        if (!is_wp_error($sL)) {
            goto pWv;
        }
        $N5 = $sL->get_error_message();
        echo "\123\157\x6d\145\x74\x68\x69\156\147\x20\x77\145\156\164\x20\167\x72\157\x6e\147\72\x20{$N5}";
        die;
        pWv:
        return wp_remote_retrieve_body($sL);
    }
}
