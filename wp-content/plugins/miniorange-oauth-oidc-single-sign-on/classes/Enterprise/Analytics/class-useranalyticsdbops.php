<?php


namespace MoOauthClient\Enterprise;

class UserAnalyticsDBOps
{
    const USER_TRANSACTIONS_TABLE = "\x77\x70\156\x73\137\x74\162\141\156\x73\x61\143\x74\151\157\156\x73";
    public function __construct()
    {
        $this->make_table_if_not_exists();
        $this->add_col_if_not_exists(self::USER_TRANSACTIONS_TABLE, "\x65\155\x61\151\x6c");
        $this->add_col_if_not_exists(self::USER_TRANSACTIONS_TABLE, "\x63\x6c\x69\145\156\x74\x69\x70");
        $this->add_col_if_not_exists(self::USER_TRANSACTIONS_TABLE, "\156\141\166\151\147\141\x74\x69\x6f\156\165\162\x6c");
    }
    private function make_table_if_not_exists()
    {
        global $wpdb;
        $Gi = "\103\122\x45\101\124\x45\x20\x54\x41\x42\114\x45\40\x49\x46\x20\x4e\x4f\x54\40\x45\130\x49\x53\124\123\40" . $wpdb->base_prefix . self::USER_TRANSACTIONS_TABLE . "\40\50\xa\x9\11\x9\140\x69\144\140\40\x62\x69\147\151\156\164\x20\x4e\x4f\x54\40\116\x55\114\114\40\101\x55\x54\x4f\x5f\111\x4e\103\122\105\115\x45\116\x54\54\x20\x20\x60\x75\x73\145\x72\x6e\x61\x6d\145\x60\40\155\145\x64\x69\x75\x6d\164\145\170\164\x20\116\x4f\124\x20\x4e\125\114\114\x20\x2c\x60\163\164\141\x74\165\x73\140\x20\155\145\x64\x69\165\x6d\x74\x65\x78\x74\x20\x4e\117\124\40\x4e\125\x4c\x4c\x20\54\x60\141\x70\160\x6e\x61\x6d\145\x60\40\x6d\x65\144\151\165\155\x74\145\x78\164\40\116\x4f\124\x20\x4e\125\x4c\114\x2c\x20\x60\145\155\x61\x69\x6c\140\x20\x6d\145\x64\x69\165\155\x74\145\170\x74\40\x4e\117\x54\x20\116\125\x4c\114\x2c\40\x60\143\154\151\x65\156\164\151\160\140\40\x6d\145\144\151\x75\x6d\164\x65\x78\164\40\116\x4f\x54\40\116\125\114\114\54\x20\140\x6e\141\166\x69\147\141\x74\x69\157\156\x75\x72\154\140\40\155\145\144\151\x75\155\x74\x65\x78\164\x20\116\x4f\124\x20\116\x55\114\114\x2c\40\x60\143\162\145\x61\x74\x65\x64\x5f\x74\x69\155\x65\x73\164\141\x6d\x70\140\x20\124\111\115\105\123\x54\x41\115\120\x20\x44\x45\x46\x41\x55\114\124\x20\x43\x55\x52\x52\x45\x4e\x54\137\x54\111\x4d\105\123\x54\x41\x4d\x50\54\x20\125\116\x49\x51\x55\x45\40\x4b\x45\131\x20\151\x64\x20\50\x69\x64\51\51\x3b";
        require_once ABSPATH . "\167\160\55\x61\144\x6d\x69\156\x2f\x69\156\x63\x6c\x75\x64\x65\x73\x2f\165\160\147\162\141\x64\x65\56\160\x68\160";
        dbDelta($Gi);
    }
    public function check_col_exists($TR = '', $Ol = '')
    {
        if (!('' === $TR || '' === $Ol)) {
            goto qC;
        }
        return false;
        qC:
        global $wpdb;
        $Ik = $wpdb->get_results($wpdb->prepare("\123\105\114\105\103\124\x20\52\x20\x46\x52\117\x4d\40\111\116\106\117\x52\115\101\x54\x49\x4f\x4e\x5f\x53\x43\x48\x45\115\101\x2e\x43\117\114\x55\115\x4e\123\40\x57\110\105\122\x45\x20\124\x41\102\114\105\137\123\103\110\x45\115\101\40\x3d\40\x25\163\40\101\x4e\x44\x20\x54\x41\x42\114\105\x5f\x4e\x41\x4d\x45\x20\x3d\x20\x25\163\x20\x41\116\x44\x20\x43\x4f\114\x55\x4d\x4e\x5f\x4e\x41\115\105\x20\75\x20\45\x73\x20", DB_NAME, $wpdb->base_prefix . $TR, $Ol));
        if (empty($Ik)) {
            goto IZ;
        }
        return true;
        IZ:
        return false;
    }
    public function add_col_if_not_exists($TR = '', $Ol = '', $z6 = true)
    {
        $this->make_table_if_not_exists();
        if (!('' === $TR || '' === $Ol)) {
            goto wU;
        }
        return false;
        wU:
        if (!$this->check_col_exists($TR, $Ol)) {
            goto oS;
        }
        return true;
        oS:
        global $wpdb;
        $fR = $z6 ? "\116\x4f\x54\40\116\125\114\x4c" : '';
        $wpdb->query("\x41\x4c\124\105\122\x20\124\101\x42\114\x45\40" . $wpdb->base_prefix . self::USER_TRANSACTIONS_TABLE . "\40\101\104\104\x20" . $Ol . "\x20\x6d\x65\x64\x69\x75\x6d\164\145\x78\x74\x20" . $fR);
    }
    private function get_all_transactions()
    {
        global $wpdb;
        $dc = $wpdb->get_results("\123\x45\x4c\x45\x43\124\40\x75\163\x65\x72\156\x61\155\145\x2c\40\163\x74\141\164\165\163\x20\x2c\x61\x70\x70\x6e\x61\155\x65\x20\54\143\x72\x65\141\164\x65\x64\x5f\164\151\155\145\163\x74\141\x6d\160\54\40\145\155\x61\x69\154\54\x20\143\x6c\x69\x65\156\164\151\160\54\x20\156\141\x76\x69\147\141\x74\x69\x6f\x6e\165\x72\154\x20\106\122\117\115\40" . $wpdb->base_prefix . self::USER_TRANSACTIONS_TABLE);
        return $dc;
    }
    public function get_entries($w1 = true)
    {
        $mj = $this->get_all_transactions();
        if ($mj) {
            goto Ej;
        }
        return array();
        Ej:
        if (!(true === $w1)) {
            goto Ko;
        }
        return $mj;
        Ko:
        return array();
    }
    public function add_transact($w1 = array(), $XL = false)
    {
        if (!$XL) {
            goto Ls;
        }
        $this->add_to_wpdb();
        return true;
        Ls:
        $lL = $this->add_to_wpdb($ZD = isset($w1["\x75\163\145\162\156\141\x6d\145"]) ? $w1["\x75\x73\x65\x72\156\x61\x6d\145"] : "\55", $Nr = isset($w1["\163\164\141\164\165\x73"]) ? $w1["\163\x74\x61\x74\165\163"] : false, $tY = isset($w1["\143\x6f\144\x65"]) ? $w1["\x63\x6f\x64\145"] : "\55", $Sm = isset($w1["\x61\x70\160\x6c\151\x63\141\x74\151\x6f\156"]) ? $w1["\141\160\x70\154\151\x63\x61\x74\151\157\x6e"] : "\55", $xv = isset($w1["\145\x6d\x61\x69\x6c"]) ? $w1["\x65\x6d\x61\151\154"] : "\55", $ya = isset($w1["\143\x6c\x69\145\156\x74\137\151\x70"]) ? $w1["\x63\x6c\151\x65\156\x74\137\x69\x70"] : "\x2d", $ZE = isset($w1["\156\x61\x76\x69\147\141\164\151\x6f\x6e\x75\162\x6c"]) ? $w1["\156\141\166\x69\147\141\x74\x69\x6f\156\165\162\x6c"] : "\x2d");
        return \boolval($lL);
    }
    private function add_to_wpdb($ZD = '', $Nr = false, $tY = '', $Sm = '', $xv = '', $ya = '', $ZE = '')
    {
        $U2 = '';
        if (!('' === $tY && false === $Nr)) {
            goto xC;
        }
        $U2 = "\116\57\101";
        xC:
        $U2 = $this->get_status_message($tY, $Nr);
        $w1 = array("\x75\x73\x65\162\156\141\155\x65" => isset($ZD) && '' !== $ZD ? $ZD : "\55", "\x73\x74\x61\x74\165\163" => isset($U2) && '' !== $U2 ? $U2 : "\x2d", "\141\160\160\x6e\x61\155\145" => isset($Sm) && '' !== $Sm ? $Sm : "\55", "\145\x6d\141\x69\154" => isset($xv) && '' !== $xv ? $xv : "\x2d", "\x63\154\151\x65\x6e\x74\151\160" => isset($ya) && '' !== $ya ? $ya : "\x2d", "\156\x61\x76\x69\x67\x61\164\151\x6f\x6e\165\162\154" => isset($ZE) && '' !== $ZE ? $ZE : "\x2d");
        global $wpdb;
        return $wpdb->insert($wpdb->base_prefix . self::USER_TRANSACTIONS_TABLE, $w1);
    }
    private function get_status_message($tY = '', $Nr = '')
    {
        if (!(true === $Nr)) {
            goto lC;
        }
        return "\x53\125\x43\103\105\123\x53";
        lC:
        switch ($tY) {
            case "\105\x4d\101\111\x4c":
                return "\x46\101\111\114\105\x44\x2e\x20\x49\156\166\x61\154\x69\x64\x20\105\155\141\x69\154\40\x52\x65\x63\145\x69\x76\145\x64\56";
            case "\x55\116\x41\115\x45":
                return "\106\x41\x49\114\x45\104\56\40\111\x6e\166\141\x6c\x69\144\40\125\x73\x65\162\156\141\155\145\x20\x52\145\x63\x65\x69\145\x76\145\144\56";
            case "\122\x45\107\x49\x53\x54\122\x41\124\111\117\x4e\x5f\x44\111\x53\101\102\114\105\x44":
                return "\x46\101\x49\x4c\105\x44\56\x20\x52\145\147\x69\x73\x74\x72\x61\164\151\x6f\x6e\40\x64\151\163\141\x62\154\x65\144\56";
            default:
                return "\106\101\111\114\105\104";
        }
        x7:
        Sm:
    }
    public function drop_table()
    {
        global $wpdb;
        if (!($wpdb->get_var("\x53\x48\x4f\127\40\x54\101\x42\x4c\105\x53\40\x4c\111\113\105\40\47" . $wpdb->prefix . self::USER_TRANSACTIONS_TABLE . "\x27") === $wpdb->prefix . self::USER_TRANSACTIONS_TABLE)) {
            goto u9;
        }
        $mJ = $wpdb->get_results("\104\122\117\120\x20\x54\101\102\x4c\x45\x20" . $wpdb->prefix . self::USER_TRANSACTIONS_TABLE);
        u9:
    }
}
