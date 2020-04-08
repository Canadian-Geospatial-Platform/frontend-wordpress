<?php


namespace MoOauthClient;

use MoOauthClient\StorageHandler;
class StorageManager
{
    private $storage_handler;
    const PRETTY = "\160\x72\x65\x74\164\171";
    const JSON = "\152\163\x6f\156";
    const RAW = "\x72\x61\x77";
    public function __construct($H6 = '')
    {
        if (!(!$H6 && '' !== $H6)) {
            goto KJ;
        }
        return new \WP_Error("\x69\x6e\166\141\x6c\x69\144\x5f\x73\x74\x61\164\x65", "\x54\x68\145\40\163\164\x61\x74\145\40\x69\x73\x20\145\155\x70\164\171\40\157\x72\40\x69\x6e\166\141\154\x69\x64\56");
        KJ:
        $this->storage_handler = new StorageHandler('' === $H6 ? $H6 : base64_decode($H6));
    }
    private function decrypt($Fp)
    {
        return empty($Fp) || '' === $Fp ? $Fp : strtolower(hex2bin($Fp));
    }
    private function encrypt($Fp)
    {
        return empty($Fp) || '' === $Fp ? $Fp : strtoupper(bin2hex($Fp));
    }
    public function get_state()
    {
        return $this->storage_handler->stringify();
    }
    public function add_replace_entry($qV, $sw)
    {
        if ($sw) {
            goto ri;
        }
        return;
        ri:
        $sw = is_string($sw) ? $sw : wp_json_encode($sw);
        $this->storage_handler->add_replace_entry(bin2hex($qV), bin2hex($sw));
    }
    public function get_value($qV)
    {
        $sw = $this->storage_handler->get_value(bin2hex($qV));
        if ($sw) {
            goto rc;
        }
        return false;
        rc:
        $ey = json_decode(hex2bin($sw), true);
        return json_last_error() === JSON_ERROR_NONE ? $ey : hex2bin($sw);
    }
    public function remove_key($qV)
    {
        $sw = $this->storage_handler->remove_key(bin2hex($qV));
    }
    public function validate()
    {
        return $this->storage_handler->validate();
    }
    public function dump_all_storage($Co = self::RAW)
    {
        $Ky = $this->storage_handler->get_storage();
        $vI = array();
        foreach ($Ky as $qV => $sw) {
            $gY = \hex2bin($qV);
            if ($gY) {
                goto Xr;
            }
            goto Gt;
            Xr:
            $vI[$gY] = $this->get_value($gY);
            Gt:
        }
        Ea:
        switch ($Co) {
            case self::PRETTY:
                echo "\x3c\x70\x72\145\x3e";
                print_r($vI);
                echo "\74\57\x70\162\x65\76";
                goto DR;
            case self::JSON:
                echo \json_encode($vI);
                goto DR;
            default:
            case self::RAW:
                print_r($vI);
                goto DR;
        }
        RV:
        DR:
    }
}
