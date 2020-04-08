<?php


namespace MoOauthClient\GrantTypes;

use MoOauthClient\GrantTypes\Implicit;
use MoOauthClient\OauthHandler;
use MoOauthClient\StorageManager;
use MoOauthClient\Base\InstanceHelper;
class Password
{
    const CSS_URL = MOC_URL . "\x63\154\x61\x73\163\145\x73\x2f\x50\x72\x65\x6d\x69\165\x6d\x2f\x72\145\163\x6f\x75\162\143\145\163\x2f\x70\167\x64\163\x74\171\x6c\145\x2e\143\163\163";
    const JS_URL = MOC_URL . "\x63\x6c\141\163\163\145\x73\x2f\x50\x72\x65\x6d\x69\165\x6d\x2f\162\145\163\x6f\165\162\x63\145\x73\x2f\x70\167\x64\x2e\152\x73";
    public function __construct($ua = false)
    {
        if (!$ua) {
            goto aM;
        }
        return;
        aM:
        add_action("\x69\x6e\x69\x74", array($this, "\142\145\x68\141\166\145"));
    }
    public function inject_ui()
    {
        global $xW;
        wp_enqueue_style("\167\160\55\x6d\x6f\55\157\x63\x2d\160\167\x64\x2d\x63\163\x73", self::CSS_URL, array(), $Uy = null, $kK = false);
        $Vx = $xW->parse_url($xW->get_current_url());
        $RE = "\142\165\164\x74\x6f\156";
        if (!isset($Vx["\161\x75\145\x72\x79"]["\154\x6f\x67\x69\x6e"])) {
            goto QR;
        }
        return;
        QR:
        ?>
		<div id="password-grant-modal" class="password-modal mo_table_layout">
			<div class="password-modal-content">
				<div class="password-modal-header">
					<div class="password-modal-header-title">
						<span class="password-modal-close">&times;</span>
						<span id="password-modal-header-title-text"></span>
					</div>
				</div>
				<form id="pwdgrntfrm">
					<input type="hidden" name="login" value="pwdgrntfrm">
					<input type="text" class="mo_table_textbox" id="pwdgrntfrm-unmfld" name="caller" placeholder="Username">
					<input type="password" class="mo_table_textbox" id="pwdgrntfrm-pfld" name="tool" placeholder="Password">
					<input type="<?php 
        echo $RE;
        ?>
" class="button button-primary button-large" id="pwdgrntfrm-login" value="Login">
				</form>
			</div>
		</div>
		<?php 
    }
    public function inject_behaviour()
    {
        wp_enqueue_script("\167\160\55\x6d\157\x2d\x6f\143\55\160\x77\144\x2d\152\163", self::JS_URL, array("\152\x71\x75\145\162\171"), $Uy = null, $kK = true);
    }
    public function behave($xH = '', $Rj = '', $iR = '', $IZ = '', $WK = false, $ua = false)
    {
        global $xW;
        $xH = !empty($xH) ? hex2bin($xH) : false;
        $Rj = !empty($Rj) ? hex2bin($Rj) : false;
        $iR = !empty($iR) ? $iR : false;
        $IZ = !empty($IZ) ? $IZ : site_url();
        if (!(!$xH || !$Rj || !$iR)) {
            goto O9;
        }
        $xW->redirect_user(urldecode($IZ));
        die;
        O9:
        $eL = $xW->get_app_by_name($iR);
        if ($eL) {
            goto Tk;
        }
        $tc = $xW->parse_url(urldecode(site_url()));
        $tc["\x71\165\x65\162\171"]["\145\162\x72\157\x72"] = "\124\x68\145\x72\x65\40\151\x73\x20\x6e\x6f\40\141\160\160\x6c\151\x63\141\x74\151\x6f\x6e\x20\143\157\156\146\x69\x67\165\x72\x65\144\40\146\157\x72\x20\x74\150\151\x73\x20\x72\145\161\x75\x65\x73\164";
        $xW->redirect_user($xW->generate_url($tc));
        Tk:
        $mh = $eL->get_app_config();
        $w1 = array("\147\162\141\156\x74\x5f\164\171\x70\x65" => "\x70\141\x73\163\x77\157\x72\144", "\143\154\151\x65\x6e\164\x5f\x69\x64" => $mh["\x63\154\151\145\156\x74\137\151\144"], "\x63\154\x69\145\x6e\x74\x5f\x73\x65\143\162\145\164" => $mh["\143\x6c\151\145\x6e\164\137\163\x65\143\162\x65\164"], "\x75\163\145\162\156\141\155\145" => $xH, "\x70\x61\163\x73\167\157\162\x64" => $Rj, "\x73\143\157\160\145" => $eL->get_app_config("\x73\x63\x6f\x70\145"), "\162\x65\144\151\162\x65\x63\164\137\x75\x72\x69" => $eL->get_app_config("\x72\145\x64\x69\162\x65\x63\x74\137\x75\162\151"));
        $lv = new OauthHandler();
        $ZP = $mh["\x61\x63\x63\x65\x73\163\x74\157\153\145\156\x75\162\154"];
        if (!(strpos($ZP, "\x67\x6f\157\x67\x6c\145") !== false)) {
            goto be;
        }
        $ZP = "\x68\x74\x74\160\x73\x3a\x2f\57\x77\x77\x77\x2e\147\157\157\147\154\x65\141\160\151\163\56\143\x6f\155\x2f\x6f\141\x75\x74\150\x32\x2f\166\64\57\164\x6f\x6b\x65\156";
        be:
        $jb = isset($mh["\163\x65\156\x64\x5f\150\145\x61\144\x65\x72\163"]) ? $mh["\163\x65\x6e\x64\137\150\145\x61\144\145\162\x73"] : 0;
        $vK = isset($mh["\163\x65\156\x64\x5f\142\x6f\x64\171"]) ? $mh["\163\145\x6e\x64\x5f\x62\157\144\171"] : 0;
        $qz = $lv->get_access_token($ZP, $w1, $jb, $vK);
        $d9 = isset($qz["\x61\x63\x63\x65\163\163\137\x74\x6f\x6b\145\x6e"]) ? $qz["\x61\x63\x63\x65\x73\x73\137\164\157\x6b\x65\x6e"] : false;
        $co = isset($qz["\151\144\x5f\164\x6f\x6b\x65\156"]) ? $qz["\151\x64\x5f\164\x6f\x6b\145\156"] : false;
        $IG = isset($qz["\x74\157\153\x65\x6e"]) ? $qz["\164\157\x6b\145\156"] : false;
        $f8 = array();
        if (false !== $co || false !== $IG) {
            goto WZ;
        }
        if ($d9) {
            goto J5;
        }
        die("\x49\156\x76\141\154\x69\144\x20\x74\157\x6b\x65\x6e\40\162\145\143\x65\151\x76\145\144\x2e");
        J5:
        goto lO;
        WZ:
        $rt = '';
        if (!(false !== $IG)) {
            goto Sb;
        }
        $rt = "\x74\x6f\x6b\x65\x6e\75" . $IG;
        Sb:
        if (!(false !== $co)) {
            goto bA;
        }
        $rt = "\151\144\x5f\x74\157\x6b\x65\x6e\x3d" . $co;
        bA:
        $dJ = new Implicit($rt);
        if (!is_wp_error($dJ)) {
            goto OU;
        }
        wp_die(wp_kses($dJ->get_error_message(), \get_valid_html()));
        die("\120\x6c\x65\x61\163\145\40\164\x72\x79\40\114\x6f\147\147\x69\x6e\x67\40\151\156\x20\141\x67\141\151\156\56");
        OU:
        $hu = $dJ->get_jwt_from_query_param();
        $f8 = $hu->get_decoded_payload();
        lO:
        $oj = $mh["\162\x65\163\x6f\x75\162\x63\x65\x6f\167\156\145\162\144\x65\164\x61\151\154\x73\x75\x72\x6c"];
        if (!(substr($oj, -1) === "\75")) {
            goto tY;
        }
        $oj .= $d9;
        tY:
        if (!(strpos($oj, "\x67\x6f\157\147\154\x65") !== false)) {
            goto T9;
        }
        $oj = "\150\x74\x74\x70\163\x3a\57\57\167\x77\167\56\x67\157\x6f\x67\x6c\x65\x61\160\151\163\x2e\x63\157\155\57\157\x61\x75\x74\150\x32\57\166\x31\57\165\163\x65\x72\x69\156\x66\x6f";
        T9:
        if (empty($oj)) {
            goto Oj;
        }
        $f8 = $lv->get_resource_owner($oj, $d9);
        Oj:
        $Bk = new InstanceHelper();
        $Br = $Bk->get_login_handler_instance();
        if (!$WK) {
            goto l9;
        }
        $Br->handle_group_test_conf($f8, $mh, $d9, false, $WK);
        die;
        l9:
        $Sw = new StorageManager();
        $Sw->add_replace_entry("\x72\x65\144\x69\x72\145\x63\x74\x5f\165\162\x69", $IZ);
        $tZ = $Sw->get_state();
        $user = $Br->handle_sso($mh["\x61\160\160\111\x64"], $mh, $f8, $tZ, $qz, $ua);
        if (!$ua) {
            goto Kz;
        }
        return $user;
        Kz:
    }
    public function mo_oauth_wp_login($user, $ZD, $Wd)
    {
        global $xW;
        $gn = new \WP_Error();
        if (!(empty($ZD) || empty($Wd))) {
            goto oe;
        }
        if (!empty($ZD)) {
            goto bY;
        }
        $gn->add("\145\155\160\x74\x79\137\x75\x73\145\x72\x6e\x61\155\145", __("\x3c\163\164\x72\157\x6e\147\76\105\x52\x52\x4f\122\74\57\x73\x74\162\157\x6e\147\x3e\72\x20\105\155\141\x69\154\x20\x66\151\145\x6c\144\40\x69\x73\40\145\x6d\160\164\171\x2e"));
        bY:
        if (!empty($Wd)) {
            goto Oi;
        }
        $gn->add("\x65\155\x70\x74\171\x5f\160\141\163\163\x77\157\162\144", __("\74\163\164\x72\157\156\147\x3e\105\x52\122\x4f\122\74\x2f\x73\x74\x72\x6f\156\147\x3e\x3a\x20\x50\x61\x73\163\x77\x6f\x72\x64\40\x66\x69\x65\154\144\x20\151\x73\x20\145\155\160\x74\x79\x2e"));
        Oi:
        return $gn;
        oe:
        $iR = $xW->mo_oauth_client_get_option("\155\157\x5f\x6f\141\x75\x74\x68\137\145\x6e\141\142\x6c\x65\x5f\x6f\x61\165\164\x68\x5f\167\160\x5f\x6c\157\x67\x69\x6e");
        $Lt = $xW->mo_oauth_client_get_option("\155\157\x5f\157\141\165\164\150\137\145\156\x61\x62\154\145\137\x65\170\151\x73\164\x69\156\x67\137\x75\x73\x65\x72\137\x6c\157\x67\151\x6e");
        $user = false;
        if (\username_exists($ZD)) {
            goto XT;
        }
        if (!email_exists($ZD)) {
            goto m8;
        }
        $user = get_user_by("\145\155\x61\151\154", $ZD);
        m8:
        goto Ki;
        XT:
        $user = \get_user_by("\154\157\147\x69\x6e", $ZD);
        Ki:
        if (!($user && !$Lt)) {
            goto W0;
        }
        if (!wp_check_password($Wd, $user->data->user_pass, $user->ID)) {
            goto wS;
        }
        return $user;
        wS:
        $gn->add("\x69\156\x76\141\154\151\x64\137\x70\x61\163\x73\x77\157\162\144", __("\x3c\x73\x74\162\x6f\156\x67\76\x45\122\122\117\x52\74\x2f\163\164\x72\157\x6e\x67\76\x3a\40\125\x73\x65\x72\x6e\x61\155\x65\40\x6f\x72\x20\x50\x61\163\163\167\x6f\162\x64\x20\151\x73\x20\151\x6e\x76\141\x6c\x69\144\56"));
        return $gn;
        W0:
        if (!(false !== $iR)) {
            goto R7;
        }
        return $this->behave(\bin2hex($ZD), \bin2hex($Wd), $iR, site_url(), false, true);
        R7:
    }
}
