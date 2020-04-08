<?php


namespace MoOauthClient;

class StorageHandler
{
    private $storage;
    public function __construct($H6 = '')
    {
        $oh = empty($H6) || '' === $H6 ? json_encode(array()) : sanitize_text_field(wp_unslash($H6));
        $this->storage = json_decode($oh, true);
    }
    public function add_replace_entry($qV, $sw)
    {
        $this->storage[$qV]["\126"] = $sw;
        $this->storage[$qV]["\110"] = md5($sw);
    }
    public function get_value($qV)
    {
        if (isset($this->storage[$qV])) {
            goto sa;
        }
        return false;
        sa:
        $sw = $this->storage[$qV];
        if (!(!is_array($sw) || !isset($sw["\x56"]) || !isset($sw["\x48"]))) {
            goto BL;
        }
        return false;
        BL:
        if (!(md5($sw["\x56"]) !== $sw["\110"])) {
            goto Bp;
        }
        return false;
        Bp:
        return $sw["\x56"];
    }
    public function remove_key($qV)
    {
        if (!isset($this->storage[$qV])) {
            goto xG;
        }
        unset($this->storage[$qV]);
        xG:
    }
    public function stringify()
    {
        $Ky = $this->storage;
        $Ky[\bin2hex("\x75\151\144")]["\x56"] = bin2hex(MO_UID);
        $Ky[\bin2hex("\x75\151\x64")]["\110"] = md5($Ky[\bin2hex("\x75\x69\144")]["\126"]);
        return base64_encode(wp_json_encode($Ky));
    }
    public function get_storage()
    {
        return $this->storage;
    }
}
