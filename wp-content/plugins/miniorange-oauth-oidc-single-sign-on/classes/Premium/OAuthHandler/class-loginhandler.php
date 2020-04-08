<?php


namespace MoOauthClient\Premium;

use MoOauthClient\Standard\LoginHandler as StandardLoginHandler;
use MoOauthClient\GrantTypes\Implicit;
use MoOauthClient\GrantTypes\Password;
use MoOauthClient\GrantTypes\JWSVerify;
use MoOauthClient\GrantTypes\JWTUtils;
use MoOauthClient\Premium\MappingHandler;
use MoOauthClient\StorageManager;
class LoginHandler extends StandardLoginHandler
{
    private $implicit_handler;
    private $app_name = '';
    private $group_mapping_attr = false;
    private $resource_owner = false;
    public function __construct()
    {
        global $xW;
        parent::__construct();
        add_filter("\155\157\137\x61\165\x74\x68\x5f\x75\162\x6c\x5f\x69\x6e\x74\145\162\x6e\x61\154", array($this, "\155\157\137\157\141\x75\x74\150\137\x63\x6c\151\x65\x6e\x74\137\147\x65\156\x65\162\141\x74\x65\137\x61\165\164\150\157\162\151\172\141\164\151\157\x6e\x5f\165\162\154"), 5, 2);
        add_action("\167\160\x5f\146\x6f\x6f\x74\145\162", array($this, "\155\x6f\137\157\x61\165\164\150\137\143\x6c\x69\145\156\x74\x5f\151\x6d\160\154\x69\x63\x69\x74\137\x66\x72\141\147\155\145\x6e\164\x5f\x68\141\156\144\x6c\x65\162"));
        add_action("\155\x6f\x5f\157\141\165\x74\150\x5f\162\x65\163\x74\x72\151\x63\164\x5f\145\155\141\x69\154\163", array($this, "\155\x6f\x5f\x6f\141\x75\x74\150\x5f\x63\x6c\x69\x65\156\164\x5f\162\x65\x73\x74\162\x69\143\164\x5f\x65\x6d\141\x69\154\163"), 10, 2);
        add_action("\x6d\157\x5f\157\x61\x75\x74\150\137\143\x6c\151\x65\x6e\x74\137\155\141\x70\137\x72\157\154\145\x73", array($this, "\155\157\x5f\x6f\x61\x75\164\150\x5f\143\x6c\151\145\156\x74\x5f\x6d\141\x70\x5f\x72\x6f\x6c\145\x73"), 10, 1);
        $xO = $xW->mo_oauth_client_get_option("\x6d\157\137\157\x61\165\164\x68\137\x65\156\141\142\154\145\137\x6f\x61\x75\x74\x68\137\x77\x70\x5f\154\157\x67\x69\156");
        if (!$xO) {
            goto Akc;
        }
        remove_filter("\141\165\164\x68\x65\156\164\151\x63\141\164\145", "\167\x70\x5f\x61\165\164\x68\145\x6e\164\x69\x63\141\x74\145\x5f\x75\163\145\x72\156\141\x6d\x65\137\x70\x61\163\163\x77\157\x72\x64", 20, 3);
        $ys = new Password(true);
        add_filter("\141\x75\x74\150\145\156\x74\x69\143\x61\164\x65", array($ys, "\155\157\x5f\x6f\141\165\x74\x68\x5f\x77\x70\137\x6c\157\x67\151\x6e"), 20, 3);
        Akc:
    }
    public function mo_oauth_client_restrict_emails($xv, $BX)
    {
        $Iv = isset($BX["\x72\x65\x73\x74\162\151\143\164\145\x64\137\x64\x6f\155\141\x69\x6e\x73"]) ? $BX["\162\x65\x73\x74\x72\151\x63\x74\145\x64\137\x64\157\155\141\x69\x6e\x73"] : '';
        if (!empty($Iv)) {
            goto y1g;
        }
        return;
        y1g:
        $EA = isset($BX["\x61\154\x6c\157\167\137\162\x65\163\164\162\x69\143\x74\145\x64\x5f\x64\157\155\x61\x69\x6e\x73"]) ? $BX["\141\x6c\x6c\157\x77\137\x72\x65\x73\164\162\x69\x63\x74\145\x64\137\x64\x6f\155\141\151\x6e\163"] : '';
        if (!empty($EA)) {
            goto pQM;
        }
        $EA = false;
        pQM:
        $EA = intval($EA);
        $Iv = explode("\x2c", $Iv);
        $al = substr($xv, strpos($xv, "\x40") + 1);
        $aU = in_array($al, $Iv, false);
        $aU = $EA ? !$aU : $aU;
        $HO = !empty($Iv) && $aU;
        if (!$HO) {
            goto Uy3;
        }
        wp_die("\x59\157\x75\x20\x64\x6f\40\x6e\157\164\x20\150\141\166\x65\x20\162\x69\x67\150\164\x73\40\164\x6f\x20\x61\143\x63\x65\163\x73\40\x74\150\151\x73\x20\160\141\x67\145\56\x20\120\x6c\145\141\163\145\x20\143\157\156\x74\141\143\164\40\x74\150\x65\40\x61\x64\x6d\151\156\151\163\x74\x72\x61\164\157\x72\x2e");
        Uy3:
    }
    public function mo_oauth_client_generate_authorization_url($ms, $iR)
    {
        global $xW;
        $k4 = $xW->parse_url($ms);
        $BX = $xW->get_app_by_name($iR)->get_app_config();
        if (!(isset($BX["\147\x72\x61\x6e\x74\x5f\x74\171\160\145"]) && "\x49\155\160\x6c\x69\143\151\164\x20\x47\x72\141\x6e\164" === $BX["\147\x72\x61\x6e\164\137\164\171\160\x65"])) {
            goto zfu;
        }
        $k4["\161\165\145\x72\171"]["\x72\x65\x73\x70\x6f\x6e\163\x65\137\x74\171\160\145"] = "\x74\x6f\153\145\x6e";
        return $xW->generate_url($k4);
        zfu:
        return $ms;
    }
    public function mo_oauth_client_map_roles($w1)
    {
        $mh = isset($w1["\x61\160\160\x5f\143\157\156\146\x69\147"]) && !empty($w1["\141\160\160\x5f\143\x6f\x6e\x66\x69\x67"]) ? $w1["\x61\160\x70\137\143\157\156\x66\x69\147"] : array();
        $Wn = isset($mh["\147\x72\x6f\x75\160\156\141\x6d\x65\x5f\x61\164\x74\162\x69\142\x75\x74\x65"]) && '' !== $mh["\x67\162\157\165\160\156\141\x6d\x65\x5f\141\164\164\162\x69\x62\165\x74\x65"] ? $mh["\147\x72\157\x75\160\x6e\x61\155\x65\x5f\141\164\x74\x72\151\x62\165\164\x65"] : false;
        $this->resource_owner = isset($w1["\x72\x65\163\157\x75\162\143\145\137\157\x77\156\145\162"]) && !empty($w1["\x72\x65\163\x6f\165\x72\143\145\x5f\x6f\167\x6e\145\162"]) ? $w1["\x72\x65\163\x6f\x75\x72\x63\x65\x5f\x6f\x77\156\145\162"] : array();
        $this->group_mapping_attr = $this->get_group_mapping_attribute($this->resource_owner, false, $Wn);
        $BM = new MappingHandler(isset($w1["\165\163\x65\x72\x5f\151\144"]) && is_numeric($w1["\165\x73\x65\162\137\x69\144"]) ? intval($w1["\165\x73\145\162\x5f\x69\x64"]) : 0, $mh, $this->group_mapping_attr ? $this->group_mapping_attr : '', isset($w1["\156\145\167\x5f\x75\163\145\x72"]) ? \boolval($w1["\156\145\x77\x5f\x75\x73\145\x72"]) : true);
        $BM->apply_custom_attribute_mapping(is_array($this->resource_owner) ? $this->resource_owner : array());
        $BM->apply_role_mapping();
    }
    public function mo_oauth_client_implicit_fragment_handler()
    {
        ?>
			<script>
				function convert_to_url(obj) {
					return Object
					.keys(obj)
					.map(k => `${encodeURIComponent(k)}=${encodeURIComponent(obj[k])}`)
					.join('&');
				}

				function pass_to_backend() {
					if(window.location.hash) {
						var hash = window.location.hash;
						var elements = {};
						hash.split("#")[1].split("&").forEach(element => {
							var vars = element.split("=");
							elements[vars[0]] = vars[1];
						});
						if(("access_token" in elements) || ("id_token" in elements) || ("token" in elements)) {
							if(window.location.href.indexOf("?") !== -1) {
								window.location = (window.location.href.split("?")[0] + window.location.hash).split('#')[0] + "?" + convert_to_url(elements);
							} else {
								window.location = window.location.href.split('#')[0] + "?" + convert_to_url(elements);
							}
						}
					}
				}

				pass_to_backend();
			</script>

		<?php 
    }
    private function check_state($dJ)
    {
        $tZ = str_replace("\45\63\x44", "\x3d", urldecode($dJ->get_query_param("\163\164\x61\164\145")));
        $Sw = new StorageManager($tZ);
        if (!is_wp_error($Sw)) {
            goto nJE;
        }
        wp_die(wp_kses($Sw->get_error_message(), \get_valid_html()));
        nJE:
        $ma = $Sw->get_value("\165\x69\x64");
        if (!($ma && MO_UID === $ma)) {
            goto P4F;
        }
        $this->appname = $Sw->get_value("\x61\x70\x70\156\141\155\145");
        return $Sw;
        P4F:
        return false;
    }
    public function mo_oauth_login_validate()
    {
        parent::mo_oauth_login_validate();
        global $xW;
        if (!(isset($_REQUEST["\164\157\x6b\145\156"]) && !empty($_REQUEST["\164\157\x6b\x65\156"]) || isset($_REQUEST["\151\144\137\164\157\x6b\145\x6e"]) && !empty($_REQUEST["\x69\x64\137\x74\x6f\153\x65\x6e"]))) {
            goto dLJ;
        }
        $dJ = new Implicit(isset($_SERVER["\x51\125\105\x52\131\x5f\x53\x54\x52\x49\116\107"]) ? $_SERVER["\121\125\x45\x52\x59\x5f\x53\124\x52\111\x4e\107"] : '');
        if (!is_wp_error($dJ)) {
            goto svV;
        }
        wp_die(wp_kses($dJ->get_error_message(), \get_valid_html()));
        die("\x50\x6c\145\141\163\x65\40\x74\162\x79\40\x4c\157\147\x67\x69\x6e\x67\40\x69\156\40\x61\147\x61\x69\x6e\x2e");
        svV:
        $hu = $dJ->get_jwt_from_query_param();
        if (!is_wp_error($hu)) {
            goto UH7;
        }
        wp_die(wp_kses($hu->get_error_message(), \get_valid_html()));
        UH7:
        $Sw = $this->check_state($dJ);
        if ($Sw) {
            goto j_r;
        }
        wp_die("\123\x74\141\x74\x65\x20\x50\141\x72\x61\x6d\145\164\x65\162\x20\144\x69\144\40\156\x6f\x74\x20\x76\x65\x72\151\146\x79\56\40\120\154\x65\x61\x73\x65\40\x54\x72\x79\40\114\157\147\x67\x69\x6e\147\40\x69\156\40\141\147\141\x69\156\56");
        j_r:
        $mh = $xW->get_app_by_name($this->app_name);
        $mh = $mh ? $mh->get_app_config() : false;
        $f8 = $this->handle_jwt($hu);
        if (!is_wp_error($f8)) {
            goto gst;
        }
        wp_die(wp_kses($f8->get_error_message(), \get_valid_html()));
        gst:
        if ($mh) {
            goto INe;
        }
        wp_die("\x53\164\141\164\145\40\120\x61\162\x61\x6d\x65\164\145\x72\40\144\x69\144\40\156\x6f\x74\40\x76\x65\162\x69\146\x79\x2e\40\x50\x6c\x65\141\163\x65\40\124\162\x79\40\x4c\x6f\147\147\151\156\x67\x20\x69\x6e\x20\x61\x67\141\151\x6e\x2e");
        INe:
        if ($f8) {
            goto L1d;
        }
        wp_die("\112\127\124\40\123\151\x67\x6e\x61\x74\165\162\x65\x20\x64\151\144\40\156\157\164\x20\166\145\162\151\146\171\x2e\40\x50\154\145\141\163\x65\40\124\162\x79\40\x4c\x6f\147\147\151\156\147\x20\151\x6e\x20\x61\147\x61\x69\x6e\x2e");
        L1d:
        $tE = $Sw->get_value("\164\x65\163\x74\137\x63\157\156\146\x69\147");
        $this->handle_group_details($dJ->get_query_param("\x61\143\143\145\x73\x73\x5f\x74\x6f\153\145\156"), isset($mh["\147\162\157\x75\160\144\145\164\x61\151\x6c\x73\165\x72\x6c"]) ? $mh["\147\162\x6f\x75\x70\144\x65\x74\141\x69\154\163\165\x72\x6c"] : '', isset($mh["\147\x72\157\x75\x70\156\141\x6d\x65\137\141\164\x74\162\151\142\165\x74\x65"]) ? $mh["\147\162\157\x75\160\x6e\x61\x6d\x65\x5f\x61\x74\164\162\x69\142\x75\164\145"] : '', $tE);
        if (!($tE && '' !== $tE)) {
            goto P0s;
        }
        $this->render_test_config_output($f8);
        die;
        P0s:
        $this->handle_sso($this->app_name, $mh, $f8, $Sw->get_state(), $dJ->get_query_param());
        dLJ:
        if (!(isset($_REQUEST["\x61\143\143\x65\163\163\x5f\164\x6f\x6b\145\156"]) && '' !== $_REQUEST["\141\143\x63\x65\163\x73\x5f\164\157\153\145\156"])) {
            goto scI;
        }
        $dJ = new Implicit(isset($_SERVER["\121\125\x45\122\131\x5f\123\x54\x52\111\x4e\107"]) ? $_SERVER["\x51\125\x45\x52\131\137\x53\x54\x52\111\x4e\x47"] : '');
        $Sw = $this->check_state($dJ);
        if ($Sw) {
            goto oD7;
        }
        wp_die("\123\x74\141\164\x65\x20\x50\141\x72\141\x6d\145\x74\x65\162\40\x64\x69\144\40\x6e\x6f\x74\40\166\145\x72\151\146\x79\56\x20\120\x6c\145\141\163\145\x20\x54\x72\x79\x20\x4c\157\x67\x67\151\156\147\x20\151\x6e\40\x61\147\x61\151\x6e\x2e");
        oD7:
        $mh = $xW->get_app_by_name($Sw->get_value("\141\160\160\x6e\141\x6d\x65"));
        $mh = $mh->get_app_config();
        $f8 = $this->oauth_handler->get_resource_owner($mh["\x72\x65\163\157\165\x72\143\x65\x6f\x77\156\x65\162\x64\x65\164\141\x69\x6c\163\165\162\154"], $dJ->get_query_param("\141\143\x63\x65\163\x73\x5f\164\x6f\x6b\145\x6e"));
        $this->resource_owner = $f8;
        $tE = $Sw->get_value("\x74\145\163\x74\x5f\x63\157\x6e\146\x69\x67");
        $this->handle_group_details($dJ->get_query_param("\141\x63\x63\145\163\x73\137\x74\x6f\x6b\x65\156"), isset($mh["\147\x72\x6f\165\x70\144\x65\164\141\x69\154\163\x75\162\x6c"]) ? $mh["\147\162\157\x75\x70\x64\145\x74\x61\151\x6c\x73\x75\x72\154"] : '', isset($mh["\147\162\x6f\165\x70\x6e\141\155\x65\x5f\x61\x74\x74\162\x69\142\x75\x74\145"]) ? $mh["\x67\162\x6f\x75\x70\156\x61\x6d\145\137\x61\164\164\162\151\142\165\164\145"] : '', $tE);
        if (!($tE && '' !== $tE)) {
            goto WsF;
        }
        $this->render_test_config_output($f8);
        die;
        WsF:
        $tZ = str_replace("\45\x33\104", "\x3d", rawurldecode($dJ->get_query_param("\x73\x74\x61\164\145")));
        $this->handle_sso($this->app_name, $mh, $f8, $tZ, $dJ->get_query_param());
        scI:
        if (!(isset($_REQUEST["\x6c\157\147\x69\156"]) && "\160\167\x64\147\x72\156\x74\x66\162\x6d" === $_REQUEST["\x6c\157\x67\x69\156"])) {
            goto Ogb;
        }
        $ys = new Password();
        $xH = isset($_REQUEST["\x63\141\x6c\x6c\x65\x72"]) && !empty($_REQUEST["\x63\141\x6c\154\x65\x72"]) ? $_REQUEST["\x63\141\x6c\x6c\145\162"] : false;
        $Rj = isset($_REQUEST["\x74\157\157\154"]) && !empty($_REQUEST["\164\x6f\x6f\154"]) ? $_REQUEST["\164\157\x6f\x6c"] : false;
        $iR = isset($_REQUEST["\x61\x70\160\137\x6e\x61\x6d\145"]) && !empty($_REQUEST["\x61\160\160\x5f\156\x61\x6d\x65"]) ? $_REQUEST["\141\x70\160\x5f\156\x61\155\x65"] : false;
        $IZ = isset($_REQUEST["\154\157\x63\x61\x74\x69\x6f\x6e"]) && !empty($_REQUEST["\154\157\x63\141\164\x69\x6f\x6e"]) ? $_REQUEST["\x6c\157\x63\141\x74\151\157\x6e"] : site_url();
        $WK = isset($_REQUEST["\164\x65\x73\x74"]) && !empty($_REQUEST["\x74\145\x73\164"]);
        if (!(!$xH || !$Rj || !$iR)) {
            goto n_a;
        }
        $xW->redirect_user(urldecode($IZ));
        n_a:
        $ys->behave($xH, $Rj, $iR, $IZ, $WK);
        Ogb:
    }
    public function handle_group_details($d9 = '', $Gg = '', $hB = '', $tE = false)
    {
        $HW = array();
        if (!('' === $d9 || '' === $hB)) {
            goto Vsn;
        }
        return;
        Vsn:
        if (!('' !== $Gg)) {
            goto n_I;
        }
        $HW = $this->oauth_handler->get_resource_owner($Gg, $d9);
        if (!(isset($_COOKIE["\155\x6f\x5f\x6f\x61\165\164\150\x5f\164\145\163\x74"]) && $_COOKIE["\x6d\x6f\137\x6f\x61\x75\x74\x68\137\x74\145\163\164"])) {
            goto YNR;
        }
        if (!(is_array($HW) && !empty($HW))) {
            goto QM5;
        }
        $this->render_test_config_output($HW, true);
        QM5:
        return;
        YNR:
        n_I:
        $Wn = $this->get_group_mapping_attribute($this->resource_owner, $HW, $hB);
        $this->group_mapping_attr = '' !== $Wn ? false : $Wn;
    }
    public function get_group_mapping_attribute($f8 = array(), $HW = array(), $hB = '')
    {
        global $xW;
        $Eu = '';
        if (!('' === $hB)) {
            goto g8M;
        }
        return '';
        g8M:
        if (isset($HW) && !empty($HW)) {
            goto xeK;
        }
        if (isset($f8) && !empty($f8)) {
            goto BVt;
        }
        goto k15;
        xeK:
        $Eu = $xW->getnestedattribute($HW, $hB);
        goto k15;
        BVt:
        $Eu = $xW->getnestedattribute($f8, $hB);
        k15:
        return !empty($Eu) ? $Eu : '';
    }
    public function handle_jwt($hu)
    {
        global $xW;
        $eL = $xW->get_app_by_name($this->app_name);
        $z2 = $eL->get_app_config("\152\167\164\x5f\x73\x75\x70\160\x6f\x72\x74");
        if ($z2) {
            goto TuH;
        }
        return $hu->get_decoded_payload();
        TuH:
        $Ba = $eL->get_app_config("\x6a\167\x74\x5f\141\154\147\x6f");
        if ($hu->check_algo($Ba)) {
            goto JGA;
        }
        return new \WP_Error("\x69\x6e\166\141\x6c\x69\x64\137\163\x69\x67\x6e", __("\x4a\x57\x54\x20\x53\151\147\x6e\x69\156\147\x20\141\154\147\x6f\x72\151\x74\150\x6d\40\151\x73\x20\156\157\x74\40\141\x6c\x6c\157\167\x65\x64\40\x6f\x72\40\x75\x6e\x73\x75\x70\x70\157\162\164\145\x64\x2e"));
        JGA:
        $rw = "\x52\x53\101" === $Ba ? $eL->get_app_config("\x78\65\60\x39\137\143\x65\162\164") : $eL->get_app_config("\x63\x6c\x69\145\156\164\x5f\x73\145\143\x72\x65\164");
        $Zk = $eL->get_app_config("\152\x77\153\x73\x75\162\x6c");
        $z_ = $Zk ? $hu->verify_from_jwks($Zk) : $hu->verify($rw);
        return !$z_ ? $z_ : $hu->get_decoded_payload();
    }
    public function get_resource_owner_from_app($co, $eL)
    {
        $this->app_name = $eL;
        $hu = new JWTUtils($co);
        if (!is_wp_error($hu)) {
            goto d2V;
        }
        wp_die($hu);
        d2V:
        $f8 = $this->handle_jwt($hu);
        if (!is_wp_error($f8)) {
            goto RkN;
        }
        wp_die($f8);
        RkN:
        if (!(false === $f8)) {
            goto ZkH;
        }
        wp_die("\106\x61\151\x6c\x65\144\40\164\x6f\40\x76\145\x72\x69\146\x79\40\x4a\127\x54\x20\x54\x6f\153\145\x6e\x2e\x20\120\x6c\145\x61\x73\x65\x20\x63\150\x65\x63\x6b\x20\x79\157\165\162\x20\x63\x6f\x6e\146\x69\x67\x75\162\x61\x74\151\157\156\40\x6f\162\40\143\x6f\x6e\164\141\x63\x74\40\x79\x6f\x75\162\40\101\144\x6d\151\156\151\163\164\162\x61\x74\157\x72\56");
        ZkH:
        return $f8;
    }
}
