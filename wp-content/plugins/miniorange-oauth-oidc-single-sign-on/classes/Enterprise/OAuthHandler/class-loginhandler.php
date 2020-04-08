<?php


namespace MoOauthClient\Enterprise;

use MoOauthClient\Premium\LoginHandler as PremiumLoginHandler;
use MoOauthClient\Enterprise\UserAnalyticsDBOps;
class LoginHandler extends PremiumLoginHandler
{
    public function mo_oauth_client_generate_authorization_url($ms, $iR)
    {
        global $xW;
        $ms = parent::mo_oauth_client_generate_authorization_url($ms, $iR);
        $k4 = $xW->parse_url($ms);
        $BX = $xW->get_plugin_config();
        $xi = $BX->get_config("\x64\x79\156\141\x6d\x69\143\x5f\143\141\154\154\142\141\143\x6b\x5f\165\162\x6c");
        if (!(isset($xi) && '' !== $xi)) {
            goto UP;
        }
        $k4["\x71\x75\145\162\x79"]["\162\145\x64\151\162\145\x63\164\137\x75\162\x69"] = $xi;
        return $xW->generate_url($k4);
        UP:
        return $ms;
    }
    public function check_status($w1)
    {
        $r3 = new UserAnalyticsDBOps();
        if (isset($w1["\163\164\141\164\165\x73"])) {
            goto pR;
        }
        $r3->add_transact($w1, true);
        wp_die(wp_kses("\123\x6f\x6d\x65\x74\x68\151\156\147\x20\x77\145\x6e\x74\40\x77\x72\x6f\156\x67\x2e\40\x50\x6c\145\x61\163\x65\x20\164\162\171\40\x4c\157\x67\147\151\156\147\40\151\156\x20\141\x67\141\x69\x6e\56", \get_valid_html()));
        pR:
        $r3->add_transact($w1);
        if (!(true !== $w1["\163\164\141\x74\165\163"])) {
            goto LR;
        }
        $gj = isset($w1["\155\x73\147"]) && !empty($w1["\155\163\147"]) ? $w1["\x6d\163\147"] : "\123\157\155\145\x74\150\151\x6e\147\40\167\145\156\164\x20\x77\x72\x6f\x6e\x67\x2e\x20\120\154\145\141\163\145\x20\164\x72\x79\40\x4c\157\x67\x67\x69\x6e\x67\40\151\156\40\x61\147\141\x69\156\56";
        wp_die(wp_kses($gj, \get_valid_html()));
        die;
        LR:
    }
}
