<?php


namespace MoOauthClient\Premium;

class MappingHandler
{
    private $user_id = 0;
    private $app_config = array();
    private $group_name = '';
    private $is_new_user = false;
    public function __construct($bI = 0, $mh = array(), $hB = '', $qN = false)
    {
        if (!(!array($mh) || empty($mh))) {
            goto VZ1;
        }
        return;
        VZ1:
        if (!user_can($bI, "\x61\x64\155\151\x6e\151\163\164\x72\141\164\157\162")) {
            goto Szb;
        }
        return;
        Szb:
        $kT = is_array($hB) ? $hB : $this->get_group_array($hB);
        $this->group_name = $kT;
        $this->user_id = $bI;
        $this->app_config = $mh;
        $this->is_new_user = $qN;
    }
    private function get_group_array($QI)
    {
        $du = json_decode($QI, true);
        return is_array($du) && json_last_error() === JSON_ERROR_NONE ? $du : explode("\73", $QI);
    }
    public function apply_custom_attribute_mapping($f8)
    {
        if (!(!isset($this->app_config["\143\165\163\x74\x6f\x6d\137\x61\164\x74\x72\x73\x5f\155\x61\160\160\151\156\x67"]) || '' === $this->app_config["\x63\x75\x73\164\157\155\x5f\x61\164\164\x72\163\137\x6d\141\160\x70\151\156\147"])) {
            goto tvX;
        }
        return;
        tvX:
        global $xW;
        $MC = -1;
        $c5 = $this->app_config["\x63\x75\x73\x74\x6f\155\x5f\x61\164\x74\162\163\137\x6d\x61\x70\160\x69\156\147"];
        $e1 = array();
        foreach ($c5 as $qV => $sw) {
            $tI = $xW->getnestedattribute($f8, $sw);
            $e1[$qV] = $tI;
            update_user_meta($this->user_id, $qV, $tI);
            qsT:
        }
        B1V:
        update_user_meta($this->user_id, "\155\157\x5f\x6f\x61\165\164\x68\x5f\143\x75\x73\164\157\x6d\x5f\141\x74\164\x72\x69\142\x75\164\x65\x73", $e1);
    }
    public function apply_role_mapping()
    {
        if (!(!$this->is_new_user && isset($this->app_config["\153\x65\145\160\137\145\170\x69\x73\x74\151\156\147\137\165\x73\x65\x72\x5f\x72\x6f\x6c\145\x73"]) && 1 === intval($this->app_config["\153\145\x65\160\x5f\x65\170\x69\x73\164\151\x6e\147\137\x75\x73\145\162\137\162\x6f\x6c\x65\163"]))) {
            goto xiw;
        }
        return;
        xiw:
        $OE = new \WP_User($this->user_id);
        $nr = 0;
        $Xq = isset($this->app_config["\x72\157\154\145\137\155\141\x70\x70\151\156\147\x5f\x63\157\165\x6e\x74"]) ? intval($this->app_config["\162\x6f\154\145\137\155\141\160\x70\x69\x6e\x67\x5f\143\157\165\x6e\x74"]) : 0;
        $OS = array();
        $MC = 1;
        lyi:
        if (!($MC <= $Xq)) {
            goto Ymr;
        }
        $lA = isset($this->app_config["\x5f\x6d\x61\160\x70\151\x6e\147\137\153\145\171\137" . $MC]) ? $this->app_config["\x5f\x6d\x61\160\160\x69\156\x67\x5f\x6b\145\x79\137" . $MC] : '';
        array_push($OS, $lA);
        foreach ($this->group_name as $og) {
            if (!(strtolower($og) === strtolower($lA))) {
                goto WXn;
            }
            $cX = isset($this->app_config["\137\155\x61\160\x70\x69\x6e\x67\x5f\166\141\154\x75\x65\x5f" . $MC]) ? $this->app_config["\x5f\x6d\141\x70\160\x69\x6e\147\137\x76\x61\154\165\x65\x5f" . $MC] : '';
            if (!$cX) {
                goto UK2;
            }
            if (!(0 === $nr)) {
                goto ZBA;
            }
            $OE->set_role('');
            ZBA:
            $OE->add_role($cX);
            $nr++;
            UK2:
            WXn:
            QKD:
        }
        j2F:
        uFh:
        $MC++;
        goto lyi;
        Ymr:
        if (!(0 === $nr && isset($this->app_config["\x5f\155\141\160\160\x69\x6e\x67\137\x76\x61\x6c\165\145\137\x64\x65\x66\x61\x75\154\164"]) && '' !== $this->app_config["\x5f\x6d\x61\x70\x70\x69\x6e\x67\x5f\x76\141\x6c\x75\145\137\144\x65\146\141\165\x6c\x74"])) {
            goto FRH;
        }
        $OE->set_role($this->app_config["\137\155\141\160\x70\x69\156\147\x5f\x76\x61\x6c\x75\145\x5f\144\145\x66\x61\x75\154\x74"]);
        FRH:
        if (!(isset($this->app_config["\162\145\163\x74\x72\151\143\x74\137\154\x6f\x67\x69\x6e\x5f\x66\157\162\137\x6d\141\x70\x70\145\144\137\162\157\x6c\x65\x73"]) && boolval($this->app_config["\x72\145\163\x74\162\151\x63\164\137\154\157\147\151\156\x5f\146\x6f\162\137\x6d\141\x70\x70\x65\x64\x5f\162\x6f\x6c\145\163"]))) {
            goto C8k;
        }
        foreach ($this->group_name as $H7) {
            if (in_array($H7, $OS, true)) {
                goto YHA;
            }
            require_once ABSPATH . "\167\x70\x2d\141\144\x6d\151\156\x2f\151\156\143\154\165\x64\145\163\57\165\163\145\x72\56\160\x68\x70";
            \wp_delete_user($this->user_id);
            wp_die("\131\157\x75\40\x64\x6f\x20\156\x6f\x74\x20\x68\x61\166\145\40\160\x65\x72\155\151\163\x73\x69\157\x6e\x73\x20\x74\157\x20\x6c\157\147\151\156\x20\x77\151\164\x68\x20\171\157\x75\162\x20\143\x75\x72\162\x65\156\x74\x20\x72\157\x6c\145\x73\56\x20\x50\154\x65\x61\x73\145\40\143\157\156\x74\x61\x63\x74\x20\x74\150\145\x20\101\x64\x6d\151\156\151\163\164\162\141\x74\x6f\x72\x2e");
            YHA:
            mUi:
        }
        m2q:
        C8k:
    }
}
