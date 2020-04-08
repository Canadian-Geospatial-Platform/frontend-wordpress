<?php


namespace MoOauthClient\Standard;

use MoOauthClient\MOUtils as CommonUtils;
class MOUtils extends CommonUtils
{
    private function manage_deactivate_cache()
    {
        global $xW;
        $eB = $xW->mo_oauth_client_get_option("\155\x6f\x5f\157\141\165\x74\150\x5f\x6c\153");
        if (!(!$xW->mo_oauth_is_customer_registered() || false === $eB || empty($eB))) {
            goto eDg;
        }
        return;
        eDg:
        $VL = $xW->mo_oauth_client_get_option("\x68\157\163\x74\x5f\x6e\x61\x6d\x65");
        $a8 = $VL . "\57\x6d\x6f\141\163\x2f\x61\x70\x69\57\142\141\x63\x6b\165\160\143\157\x64\145\57\165\160\x64\141\x74\x65\x73\x74\x61\164\165\x73";
        $mH = $xW->mo_oauth_client_get_option("\x6d\157\137\157\141\165\x74\150\x5f\141\x64\155\151\x6e\x5f\x63\x75\163\x74\x6f\x6d\x65\x72\x5f\153\x65\171");
        $hQ = $xW->mo_oauth_client_get_option("\155\157\x5f\157\141\x75\x74\150\x5f\x61\144\x6d\x69\x6e\x5f\141\x70\151\x5f\153\x65\171");
        $tY = $xW->mooauthdecrypt($eB);
        $Cu = round(microtime(true) * 1000);
        $Cu = number_format($Cu, 0, '', '');
        $cu = $mH . $Cu . $hQ;
        $nN = hash("\x73\x68\141\65\x31\62", $cu);
        $e4 = "\x43\x75\x73\164\157\155\x65\162\x2d\x4b\145\x79\72\x20" . $mH;
        $T5 = "\x54\151\155\x65\163\x74\x61\155\160\x3a\x20" . $Cu;
        $c3 = "\x41\165\x74\150\157\162\x69\172\141\164\x69\x6f\x6e\x3a\40" . $nN;
        $AA = '';
        $AA = array("\143\x6f\x64\x65" => $tY, "\x63\165\x73\x74\157\x6d\x65\162\113\145\x79" => $mH, "\x61\x64\x64\x69\x74\x69\157\x6e\x61\154\x46\151\x65\x6c\x64\x73" => array("\x66\x69\145\x6c\144\x31" => home_url()));
        $ct = wp_json_encode($AA);
        $bk = array("\x43\157\156\x74\x65\x6e\164\x2d\x54\171\160\145" => "\x61\x70\x70\154\151\143\141\164\151\157\x6e\x2f\x6a\163\157\x6e");
        $bk["\x43\x75\x73\164\x6f\155\145\162\55\113\x65\x79"] = $mH;
        $bk["\x54\x69\x6d\145\x73\x74\x61\x6d\x70"] = $Cu;
        $bk["\101\x75\164\x68\157\x72\151\x7a\141\164\151\x6f\156"] = $nN;
        $w1 = array("\x6d\145\164\150\x6f\x64" => "\x50\117\x53\x54", "\142\157\x64\x79" => $ct, "\164\x69\155\145\157\x75\164" => "\65", "\x72\145\144\x69\x72\x65\143\x74\151\157\156" => "\65", "\x68\x74\164\x70\166\x65\x72\163\151\157\x6e" => "\61\x2e\60", "\x62\154\157\x63\153\x69\x6e\147" => true, "\150\x65\141\x64\x65\162\x73" => $bk);
        $sL = wp_remote_post($a8, $w1);
        if (!is_wp_error($sL)) {
            goto zRe;
        }
        $N5 = $sL->get_error_message();
        echo "\123\157\x6d\x65\x74\x68\151\156\147\40\167\x65\x6e\x74\40\x77\x72\157\156\147\72\40{$N5}";
        die;
        zRe:
        return wp_remote_retrieve_body($sL);
    }
    public function deactivate_plugin()
    {
        $this->manage_deactivate_cache();
        parent::deactivate_plugin();
        $this->mo_oauth_client_delete_option("\x6d\x6f\x5f\157\x61\x75\164\x68\x5f\154\153");
        $this->mo_oauth_client_delete_option("\155\157\137\x6f\141\165\x74\150\137\x6c\x76");
    }
}
