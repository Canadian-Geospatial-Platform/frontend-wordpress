<?php


namespace MoOauthClient\GrantTypes;

use MoOauthClient\GrantTypes\JWSVerify;
use MoOauthClient\GrantTypes\Crypt_RSA;
use MoOauthClient\GrantTypes\Math_BigInteger;
class JWTUtils
{
    const HEADER = "\x48\x45\101\104\105\122";
    const PAYLOAD = "\120\101\x59\114\117\x41\104";
    const SIGN = "\123\x49\107\116";
    private $jwt;
    private $decoded_jwt;
    public function __construct($hu)
    {
        $hu = \explode("\x2e", $hu);
        if (!(3 > count($hu))) {
            goto ZCI;
        }
        return new WP_Error("\x69\x6e\166\141\154\x69\x64\137\152\167\164", __("\x4a\127\x54\x20\122\145\x63\145\x69\x76\x65\x64\40\151\163\40\x6e\x6f\x74\40\x61\x20\x76\141\154\151\144\x20\112\127\x54"));
        ZCI:
        $this->jwt = $hu;
        $Qg = $this->get_jwt_claim('', self::HEADER);
        $Xv = $this->get_jwt_claim('', self::PAYLOAD);
        $this->decoded_jwt = array("\x68\145\x61\x64\x65\x72" => $Qg, "\x70\141\171\x6c\x6f\x61\144" => $Xv);
    }
    private function get_jwt_claim($Z0 = '', $Yz = '')
    {
        $Rl = '';
        switch ($Yz) {
            case self::HEADER:
                $Rl = $this->jwt[0];
                goto z_9;
            case self::PAYLOAD:
                $Rl = $this->jwt[1];
                goto z_9;
            case self::SIGN:
                return $this->jwt[2];
            default:
                wp_die(wp_kses("\103\x61\x6e\x6e\157\x74\x20\x46\151\156\144\x20" . $Yz . "\x20\x69\156\x20\164\150\x65\40\112\x57\124", \get_valid_html()));
        }
        mzG:
        z_9:
        $Rl = json_decode(base64_decode($Rl), true);
        if (!(!$Rl || empty($Rl))) {
            goto bho;
        }
        return null;
        bho:
        return empty($Z0) ? $Rl : (isset($Rl[$Z0]) ? $Rl[$Z0] : null);
    }
    public function check_algo($Ba = '')
    {
        $M4 = $this->get_jwt_claim("\141\154\147", self::HEADER);
        $M4 = explode("\123", $M4);
        if (isset($M4[0])) {
            goto cuh;
        }
        wp_die(wp_kses("\x49\x6e\166\x61\154\x69\x64\x20\x52\145\163\160\157\156\x73\x65\x20\122\145\x63\145\151\166\145\x64\40\146\x72\x6f\155\40\117\x41\x75\x74\150\x2f\117\x70\x65\156\111\104\40\x50\x72\x6f\x76\x69\144\145\x72\56", \get_valid_html()));
        cuh:
        switch ($M4[0]) {
            case "\110":
                return "\x48\123\x41" === $Ba;
            case "\122":
                return "\x52\x53\x41" === $Ba;
            default:
                return false;
        }
        cCl:
        TYT:
    }
    public function verify($rw = '')
    {
        if (!empty($rw)) {
            goto DaO;
        }
        return false;
        DaO:
        $B9 = $this->get_jwt_claim("\145\170\160", self::PAYLOAD);
        if (!(is_null($B9) || time() > $B9)) {
            goto DVE;
        }
        wp_die(wp_kses("\x4a\x57\x54\40\150\x61\163\x20\142\145\145\156\x20\145\170\160\151\x72\x65\144\56\x20\x50\x6c\x65\x61\163\145\x20\x74\x72\x79\x20\x4c\157\x67\147\x69\x6e\x67\40\151\x6e\x20\x61\147\141\x69\156\56", \get_valid_html()));
        DVE:
        $TQ = $this->get_jwt_claim("\x6e\x62\x66", self::PAYLOAD);
        if (!(!is_null($TQ) || time() < $TQ)) {
            goto tsp;
        }
        wp_die(wp_kses("\x49\164\40\x69\163\40\x74\x6f\157\x20\145\x61\x72\154\171\40\164\x6f\x20\165\x73\x65\40\164\150\x69\x73\x20\x4a\x57\124\56\x20\120\154\145\x61\x73\x65\x20\164\x72\171\x20\114\157\147\147\151\156\147\40\x69\156\x20\x61\x67\x61\151\156\x2e", \get_valid_html()));
        tsp:
        $Hq = new JWSVerify($this->get_jwt_claim("\141\x6c\147", self::HEADER));
        $u8 = $this->get_header() . "\56" . $this->get_payload();
        return $Hq->verify(\utf8_decode($u8), $rw, base64_decode(strtr($this->get_jwt_claim(false, self::SIGN), "\55\x5f", "\x2b\x2f")));
    }
    public function verify_from_jwks($Zk = '', $M4 = "\x52\x53\62\x35\66")
    {
        global $xW;
        $g1 = wp_remote_get($Zk);
        if (!is_wp_error($g1)) {
            goto kVt;
        }
        return false;
        kVt:
        $g1 = json_decode($g1["\142\157\x64\171"], true);
        $z_ = false;
        if (!(json_last_error() !== JSON_ERROR_NONE)) {
            goto SWZ;
        }
        return $z_;
        SWZ:
        foreach ($g1["\153\x65\171\163"] as $qV => $sw) {
            if (!(!isset($sw["\153\164\171"]) || "\x52\123\101" !== $sw["\x6b\164\x79"] || !isset($sw["\145"]) || !isset($sw["\x6e"]))) {
                goto uaw;
            }
            goto Egl;
            uaw:
            $z_ = $z_ || $this->verify($this->jwks_to_pem(array("\156" => new Math_BigInteger($xW->base64url_decode($sw["\x6e"]), 256), "\145" => new Math_BigInteger($xW->base64url_decode($sw["\145"]), 256))));
            if (!(true === $z_)) {
                goto Nwl;
            }
            goto QE7;
            Nwl:
            Egl:
        }
        QE7:
        return $z_;
    }
    private function jwks_to_pem($X9 = array())
    {
        $dR = new Crypt_RSA();
        $dR->loadKey($X9);
        return $dR->getPublicKey();
    }
    public function get_decoded_header()
    {
        return $this->decoded_jwt["\x68\x65\141\x64\x65\162"];
    }
    public function get_decoded_payload()
    {
        return $this->decoded_jwt["\160\141\171\x6c\x6f\141\144"];
    }
    public function get_header()
    {
        return $this->jwt[0];
    }
    public function get_payload()
    {
        return $this->jwt[1];
    }
}
