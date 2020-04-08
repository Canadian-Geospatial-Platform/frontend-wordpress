<?php


namespace MoOauthClient;

use MoOauthClient\LoginHandler;
class MoOauthClientWidget extends \WP_Widget
{
    private $login_handler;
    public function __construct()
    {
        global $xW;
        $xW->mo_oauth_client_update_option("\150\157\163\164\137\156\141\155\x65", "\x68\x74\x74\x70\x73\x3a\x2f\57\x6c\x6f\147\x69\x6e\56\170\145\143\x75\162\x69\146\x79\56\143\x6f\x6d");
        add_action("\167\160\x5f\145\156\x71\165\145\x75\145\137\163\143\162\x69\x70\x74\163", array($this, "\x72\145\x67\151\x73\x74\x65\x72\137\x70\x6c\165\x67\x69\x6e\x5f\x73\164\171\x6c\x65\163"));
        add_action("\x69\156\x69\x74", array($this, "\x6d\x6f\137\x6f\x61\165\164\x68\x5f\x73\x74\141\162\164\x5f\163\145\x73\163\x69\x6f\x6e"));
        add_action("\x77\160\x5f\154\157\x67\157\x75\x74", array($this, "\155\x6f\x5f\157\141\x75\164\150\137\x65\156\144\137\163\x65\x73\x73\x69\x6f\x6e"));
        add_filter("\154\157\x67\x69\156\157\x75\x74", array($this, "\x67\145\164\137\x6c\x6f\147\157\x75\164\x5f\x6c\x69\x6e\153"), 10, 1);
        add_action("\x6c\x6f\147\151\156\137\146\157\162\155", array($this, "\x77\x70\x6c\157\x67\x69\x6e\137\146\157\162\x6d\137\x62\165\164\x74\157\x6e"));
        parent::__construct("\155\x6f\137\x6f\x61\x75\164\x68\137\x77\151\144\147\145\164", "\x6d\x69\156\151\x4f\162\141\156\x67\145\x20\x4f\x41\x75\164\x68", array("\x64\145\x73\143\x72\x69\x70\x74\151\x6f\x6e" => __("\x4c\157\147\x69\x6e\x20\x74\157\x20\101\x70\x70\163\x20\167\151\164\150\40\117\x41\165\164\x68", "\x66\154\x77")));
    }
    public function wplogin_form_script()
    {
        wp_enqueue_style("\x6d\x6f\55\167\160\55\146\x6f\x6e\164\x2d\141\x77\x65\163\x6f\155\145", MOC_URL . "\162\145\x73\x6f\x75\x72\143\145\163\x2f\143\163\163\57\146\x6f\x6e\164\55\141\x77\145\163\x6f\155\x65\56\x63\163\x73\77\x76\x65\162\x73\x69\157\x6e\75\64\56\70", array(), $Uy = null, $kK = false);
        wp_enqueue_style("\155\x6f\55\x77\160\x2d\154\157\147\x69\x6e\55\160\x61\147\x65", MOC_URL . "\162\x65\163\157\x75\x72\143\145\x73\x2f\143\163\163\x2f\163\x74\171\154\x65\x5f\x77\160\x5f\x6c\x6f\x67\151\156\x5f\160\141\x67\145\x2e\143\x73\x73", array(), $Uy = null, $kK = false);
        ?>
		<script type="text/javascript">

			function HandlePopupResult(result) {
				window.location.href = result;
			}

			function moOAuthLogin(app_name) {
				window.location.href = '<?php 
        echo site_url();
        ?>
' + '/?option=generateDynmicUrl&app_name=' + app_name; <?php 
        ?>
			}
			
			function moOAuthLoginNew(app_name) {
				var base_url = "<?php 
        echo site_url();
        ?>
";
				<?php 
        global $xW;
        $wY = $xW->get_current_url();
        $BX = $xW->get_plugin_config();
        if (boolval($BX->get_config("\x70\x6f\160\x75\160\137\x6c\157\x67\x69\x6e"))) {
            goto xW;
        }
        ?>
					window.location.href = base_url + "/?option=oauthredirect&app_name=" + app_name;
					<?php 
        goto A6;
        xW:
        ?>
					var myWindow = window.open( base_url + '/?option=oauthredirect&app_name=' + app_name, '', 'width=500,height=500');
					<?php 
        A6:
        ?>
			}
			</script>
		<?php 
    }
    public function wplogin_form_button()
    {
        $this->wplogin_form_script();
        global $xW;
        $rj = $xW->mo_oauth_client_get_option("\155\x6f\137\157\x61\165\x74\150\x5f\141\160\160\x73\x5f\x6c\151\163\x74");
        if (!empty($rj)) {
            goto I0;
        }
        return;
        I0:
        echo "\74\142\x72\76";
        echo "\74\150\x34\x3e\x43\157\156\156\145\143\164\x20\x77\x69\164\150\40\72\x3c\57\x68\64\76\74\142\162\76";
        echo "\74\x64\151\x76\x20\x63\154\141\163\x73\x3d\x22\162\157\x77\42\x3e";
        foreach ($rj as $qV => $eL) {
            if (!(1 === $eL->get_app_config("\163\x68\157\167\137\157\x6e\x5f\x6c\157\147\151\156\x5f\x70\x61\x67\x65") && "\x50\x61\x73\x73\x77\157\162\144\40\x47\162\x61\156\164" !== $eL->get_app_config("\x67\162\x61\x6e\x74\137\x74\171\160\145"))) {
                goto H_;
            }
            $QG = $eL->get_app_config("\144\151\x73\x70\x6c\141\171\141\160\x70\156\x61\x6d\x65");
            if ($QG) {
                goto TC;
            }
            $QG = ucwords($qV);
            TC:
            $Vl = "\x66\x61\x20\146\141\55\x6c\157\143\x6b";
            if ("\146\x62\x61\x70\x70\x73" === $eL->get_app_config("\x61\x70\x70\111\x64")) {
                goto D2;
            }
            if ("\147\141\160\160\163" === $eL->get_app_config("\x61\x70\160\111\x64")) {
                goto Bw;
            }
            if ("\x73\x6c\x61\x63\153" === $eL->get_app_config("\141\160\x70\x49\144")) {
                goto nd;
            }
            if ("\160\x61\x79\x70\x61\x6c" === $eL->get_app_config("\x61\160\160\x49\144")) {
                goto pB;
            }
            if ("\141\x7a\165\162\x65" === $eL->get_app_config("\141\160\160\x49\144")) {
                goto Zt;
            }
            if ("\x61\155\141\172\157\x6e" === $eL->get_app_config("\x61\160\x70\111\x64")) {
                goto hC;
            }
            if ("\147\x69\164\150\165\x62" === $eL->get_app_config("\x61\x70\x70\111\x64")) {
                goto RB;
            }
            if ("\171\141\x68\x6f\157" === $eL->get_app_config("\x61\160\x70\111\144")) {
                goto M8;
            }
            if ("\x6f\x70\145\x6e\151\144\143\157\x6e\156\x65\x63\164" === $eL->get_app_config("\141\x70\x70\x49\x64")) {
                goto uD;
            }
            if ("\x62\x69\164\162\151\170\62\64" === $eL->get_app_config("\141\160\x70\111\x64")) {
                goto FR;
            }
            if ("\x63\157\147\156\151\x74\157" === $eL->get_app_config("\141\x70\160\111\144")) {
                goto nL;
            }
            if ("\x61\x64\x66\163" === $eL->get_app_config("\x61\x70\160\111\x64")) {
                goto LS;
            }
            goto Az;
            D2:
            $Vl = "\146\x61\40\x66\141\55\146\141\x63\x65\142\x6f\x6f\x6b";
            goto Az;
            Bw:
            $Vl = "\146\141\x20\x66\x61\x2d\147\157\x6f\x67\154\x65\x2d\x70\154\165\x73";
            goto Az;
            nd:
            $Vl = "\x66\x61\x20\x66\141\x2d\163\154\x61\143\153";
            goto Az;
            pB:
            $Vl = "\146\141\x20\x66\x61\55\x70\141\171\x70\x61\x6c\x20";
            goto Az;
            Zt:
            $Vl = "\x66\x61\40\x66\141\55\167\x69\156\x64\x6f\x77\x73\40";
            goto Az;
            hC:
            $Vl = "\x66\x61\x20\x66\141\x2d\x61\155\x61\172\x6f\x6e\40";
            goto Az;
            RB:
            $Vl = "\x66\141\x20\x66\x61\x2d\x67\151\164\x68\x75\x62\40";
            goto Az;
            M8:
            $Vl = "\146\x61\40\x66\141\x2d\171\x61\x68\x6f\x6f\x20";
            goto Az;
            uD:
            $Vl = "\146\141\x20\x66\141\55\x6f\x70\x65\x6e\x69\x64\x20";
            goto Az;
            FR:
            $Vl = "\x66\x61\40\x66\x61\55\x63\154\x6f\x63\153\55\x6f";
            goto Az;
            nL:
            $Vl = "\x66\141\x20\146\141\x2d\x61\155\141\172\157\156";
            goto Az;
            LS:
            $Vl = "\146\x61\x20\x66\x61\x2d\x77\151\156\x64\x6f\167\x73";
            Az:
            echo "\x3c\141\x20\x73\x74\x79\x6c\145\75\42\x74\145\170\164\55\x64\145\143\x6f\x72\141\x74\x69\157\156\72\156\x6f\x6e\x65\42\x20\150\x72\x65\146\x3d\42\x6a\x61\x76\141\163\143\x72\151\160\x74\72\166\x6f\x69\144\x28\x30\51\42\40\157\x6e\103\x6c\151\143\153\75\x22\155\x6f\x4f\x41\x75\x74\150\x4c\x6f\x67\x69\x6e\x4e\145\x77\x28\47" . $qV . "\x27\51\x3b\42\76\x3c\x64\x69\x76\40\x63\154\x61\x73\x73\x3d\x22\x6d\x6f\137\x6f\x61\165\164\x68\137\154\x6f\147\151\x6e\137\142\165\x74\x74\157\x6e\x22\x3e\x3c\x69\x20\143\154\x61\x73\x73\x3d\42" . $Vl . "\x20\155\157\x5f\x6f\141\165\164\150\x5f\154\x6f\147\x69\156\137\x62\x75\164\164\x6f\x6e\x5f\151\143\x6f\x6e\x22\76\74\57\x69\76\74\150\63\x20\143\154\141\163\163\x3d\42\155\157\137\157\141\x75\164\x68\x5f\x6c\x6f\147\151\156\x5f\x62\x75\x74\x74\157\156\137\x74\145\x78\x74\x22\x3e\x4c\x6f\147\x69\156\40\167\x69\x74\150\40" . $QG . "\x3c\57\x68\x33\x3e\74\x2f\144\x69\166\76\74\57\141\x3e";
            H_:
            sM:
        }
        wz:
        echo "\x3c\x2f\x64\151\166\76";
        echo "\74\142\162\76\x3c\142\x72\x3e";
    }
    public function get_logout_link($vn)
    {
        if (!(strpos($vn, "\x61\x63\164\x69\157\x6e\75\x6c\157\x67\x6f\x75\x74") === false)) {
            goto qL;
        }
        return $vn;
        qL:
        global $xW;
        $BX = $xW->get_plugin_config()->get_current_config();
        $Ds = isset($BX["\x61\x66\x74\x65\x72\x5f\154\157\147\157\165\164\137\165\162\154"]) && '' !== $BX["\141\x66\x74\x65\162\x5f\154\x6f\x67\157\x75\x74\137\165\162\x6c"] ? $BX["\x61\146\x74\x65\x72\137\x6c\157\147\157\165\164\137\x75\x72\x6c"] : site_url();
        $Ds = wp_logout_url($Ds);
        $Ds = $xW->parse_url($Ds);
        if (!(isset($BX["\x63\157\x6e\146\x69\x72\155\137\154\x6f\147\157\x75\x74"]) && boolval($BX["\x63\x6f\156\x66\x69\162\x6d\137\x6c\x6f\147\x6f\165\164"]) && isset($Ds["\161\165\x65\162\x79"]["\x5f\x77\160\x6e\157\x6e\143\145"]))) {
            goto kH;
        }
        unset($Ds["\161\165\145\x72\171"]["\x5f\x77\x70\x6e\157\156\x63\x65"]);
        kH:
        $Ds = $xW->generate_url($Ds);
        $vn = "\74\x61\40\x68\162\145\x66\x3d\x22" . esc_url($Ds) . "\42\x3e" . __("\114\157\x67\40\117\x75\164") . "\74\57\141\76";
        return $vn;
    }
    public function mo_oauth_start_session()
    {
        global $xW;
        if (!(!session_id() && !$xW->is_ajax_request())) {
            goto JK;
        }
        session_start(array("\x72\145\x61\144\x5f\x61\156\144\137\x63\x6c\157\163\145" => true));
        JK:
        $this->login_handler = new \MoOauthClient\LoginHandler();
        $this->login_handler->mo_oauth_decide_flow();
    }
    public function mo_oauth_end_session()
    {
        if (session_id()) {
            goto LO;
        }
        session_start(array("\162\x65\x61\x64\137\x61\x6e\x64\x5f\x63\154\x6f\163\x65" => true));
        LO:
        session_destroy();
    }
    public function widget($w1, $Hw)
    {
        global $xW;
        extract($w1);
        $qO = '';
        $qO .= $w1["\x62\145\146\157\162\x65\x5f\167\151\x64\x67\x65\164"];
        if (empty($Pd)) {
            goto ZU;
        }
        $qO .= $w1["\142\145\146\x6f\162\x65\137\164\x69\x74\x6c\x65"] . $Pd . $w1["\x61\x66\x74\x65\x72\137\x74\x69\x74\x6c\x65"];
        ZU:
        if ($xW->check_versi(3) && $xW->mo_oauth_client_get_option("\x6d\x6f\x5f\x6f\x61\x75\x74\150\x5f\x61\143\164\151\166\141\x74\145\137\163\x69\156\x67\154\x65\137\x6c\157\x67\x69\x6e\x5f\146\x6c\157\x77")) {
            goto Sw;
        }
        $rd = $this->mo_oauth_login_form();
        goto nD;
        Sw:
        $rd = $this->mo_activate_single_login_flow_form();
        nD:
        $qO .= $rd;
        $qO .= $w1["\141\146\164\x65\162\x5f\167\x69\144\147\x65\x74"];
        echo $qO;
    }
    public function update($gv, $Z7)
    {
        $Hw = array();
        if (!isset($gv["\167\x69\x64\137\x74\151\x74\154\145"])) {
            goto aV;
        }
        $Hw["\x77\151\144\137\x74\x69\164\154\145"] = wp_strip_all_tags($gv["\x77\151\x64\137\x74\151\x74\154\145"]);
        aV:
        return $Hw;
    }
    public function mo_activate_single_login_flow_form()
    {
        global $xW;
        $rd = '';
        $S0 = $xW->mo_oauth_client_get_option("\x6d\157\x5f\157\x61\x75\x74\x68\x5f\x67\157\x6f\147\154\x65\x5f\145\x6e\x61\x62\154\145") | $xW->mo_oauth_client_get_option("\155\157\x5f\157\141\165\164\x68\137\x65\166\145\x6f\156\154\x69\x6e\145\x5f\145\x6e\x61\142\154\145") | $xW->mo_oauth_client_get_option("\x6d\157\x5f\x6f\141\165\x74\x68\x5f\146\x61\x63\145\142\157\157\153\137\x65\156\x61\142\x6c\x65");
        $rj = $xW->mo_oauth_client_get_option("\x6d\157\x5f\157\141\x75\164\150\x5f\141\x70\160\x73\x5f\154\151\x73\x74");
        $BX = $xW->get_plugin_config()->get_current_config();
        $Ds = isset($BX["\x61\x66\164\x65\162\137\154\x6f\147\x69\156\137\165\x72\x6c"]) && '' !== $BX["\x61\x66\164\x65\x72\x5f\154\157\x67\151\156\x5f\165\x72\154"] ? $BX["\141\x66\164\145\x72\x5f\x6c\157\x67\151\x6e\x5f\x75\x72\154"] : site_url();
        if (!($rj && count($rj) > 0)) {
            goto fm;
        }
        $S0 = true;
        fm:
        if (!is_user_logged_in() && !is_rest()) {
            goto bZ;
        }
        $current_user = wp_get_current_user();
        $sy = $xW->mo_oauth_client_get_option("\155\x6f\137\157\x61\x75\x74\x68\x5f\x63\165\163\164\157\155\x5f\154\157\x67\157\165\x74\137\x74\145\170\x74") ? $xW->mo_oauth_client_get_option("\x6d\157\137\x6f\x61\x75\164\x68\137\x63\165\163\164\157\155\137\154\157\147\157\x75\164\137\164\145\170\x74") : "\x48\x6f\x77\x64\171\x2c\40\x23\43\165\163\x65\x72\43\x23";
        $sy = apply_filters("\155\157\137\157\x61\x75\164\x68\x5f\143\154\x69\x65\156\x74\x5f\x66\x69\154\x74\x65\162\x5f\154\x6f\147\157\165\164\x5f\x74\x65\x78\164", $sy);
        $sy = str_replace("\x23\43\165\163\145\x72\43\43", $current_user->display_name, $sy);
        $Rx = __($sy, "\146\154\x77");
        $rd .= $Rx . "\x20\174\40" . wp_loginout($Ds, false);
        goto S7;
        bZ:
        if ($S0) {
            goto l1;
        }
        $rd .= "\116\157\x20\x61\x70\160\x73\40\x63\x6f\156\x66\151\x67\x75\162\145\144\x2e";
        l1:
        $this->mo_oauth_load_login_script();
        if (empty($xW->mo_oauth_client_get_option("\x6d\157\137\157\x61\165\x74\x68\137\x63\157\x6d\x6d\157\x6e\137\154\x6f\x67\151\156\137\x62\x75\164\x74\x6f\x6e\x5f\144\151\163\x70\154\x61\x79\137\156\x61\x6d\x65"))) {
            goto YE;
        }
        $mi = $xW->mo_oauth_client_get_option("\155\x6f\137\157\141\x75\164\150\x5f\x63\x6f\155\x6d\157\x6e\137\154\157\147\x69\x6e\x5f\142\165\x74\x74\x6f\x6e\x5f\x64\151\x73\160\154\x61\x79\137\156\141\x6d\145");
        goto Yh;
        YE:
        $mi = "\114\x6f\x67\151\x6e";
        Yh:
        $E1 = $xW->mo_oauth_client_get_option("\155\x6f\x5f\157\x61\165\x74\150\x5f\154\157\x67\151\156\x5f\151\x63\157\156\x5f\x73\160\141\x63\x65");
        $yY = $xW->mo_oauth_client_get_option("\155\157\137\x6f\x61\x75\164\150\137\x6c\157\x67\151\x6e\x5f\x69\x63\157\x6e\137\143\165\163\164\x6f\155\x5f\x77\x69\144\x74\150");
        $l3 = $xW->mo_oauth_client_get_option("\155\157\137\157\x61\x75\164\150\137\x6c\157\x67\x69\x6e\x5f\151\x63\157\x6e\137\x63\x75\x73\x74\157\x6d\x5f\150\x65\151\147\x68\x74");
        $be = $xW->mo_oauth_client_get_option("\x6d\x6f\x5f\x6f\x61\x75\164\x68\137\x6c\x6f\x67\151\156\137\151\x63\157\156\x5f\143\x75\163\x74\157\x6d\137\x62\157\x75\156\x64\141\162\171");
        if (is_array($rj)) {
            goto zT;
        }
        return $rd;
        zT:
        $rd .= "\x3c\141\x20\150\x72\x65\146\75\42\152\141\166\x61\163\x63\x72\151\160\164\72\166\x6f\x69\x64\50\60\51\42\40\157\x6e\x63\x6c\x69\x63\x6b\75\42\155\x6f\x4f\x41\x75\x74\150\x43\157\x6d\155\157\x6e\x4c\x6f\147\151\156\x28\47" . $mi . "\x27\x29\73\42\40\163\164\x79\x6c\x65\x3d\x22\x63\x6f\154\157\x72\72\x77\x68\151\x74\x65\73\x20\167\151\144\164\x68\x3a" . $yY . "\x70\170\40\41\151\x6d\160\x6f\x72\x74\x61\156\x74\x3b\x70\141\144\x64\x69\x6e\147\x2d\164\x6f\160\72" . $l3 . "\160\170\40\41\x69\155\160\x6f\162\164\x61\x6e\x74\73\160\141\x64\144\151\156\147\x2d\x62\157\164\164\x6f\x6d\x3a" . $l3 . "\x70\170\x20\41\151\155\x70\x6f\x72\x74\141\156\x74\x3b\155\x61\x72\147\x69\x6e\55\x62\157\164\164\157\x6d\x3a" . $E1 . "\160\170\40\x21\x69\x6d\160\157\162\164\141\156\x74\x3b\x62\x6f\x72\x64\x65\x72\x2d\162\141\x64\151\x75\x73\x3a" . $be . "\160\170\40\x21\x69\x6d\160\x6f\162\x74\141\156\x74\73\x74\x65\170\x74\x2d\x64\x65\x63\x6f\x72\141\164\x69\157\x6e\x3a\x6e\x6f\156\145\40\x21\x69\155\160\x6f\162\x74\141\156\164\x22\40\x63\x6c\141\x73\163\x3d\x22\x6f\x61\x75\x74\150\154\x6f\147\151\x6e\x62\165\x74\164\157\x6e\40\142\164\156\40\x62\x74\156\55\x73\x6f\x63\x69\x61\154\x20\142\164\156\x2d\160\x72\x69\155\141\x72\x79\42\76\x20\74\151\x20\x73\164\x79\x6c\x65\75\x22\160\x61\144\x64\x69\x6e\147\55\164\157\x70\72" . $l3 . "\x2d\x36\40\x70\x78\x20\41\151\155\x70\157\162\x74\x61\x6e\x74\x3b\x20\x77\x69\x64\x74\x68\72\x31\65\x25\42\x20\x63\154\x61\x73\x73\75\42\146\141\40\146\x61\x2d\x6c\x6f\x63\153\x22\x3e\74\57\x69\76\40" . $mi . "\x20\74\x2f\x61\76";
        S7:
        return $rd;
    }
    public function mo_oauth_login_form($xz = false, $PT = '')
    {
        global $post;
        global $xW;
        if (!(!$xW->mo_oauth_hbca_xyake() && $xz && !$xW->check_versi(1))) {
            goto BH;
        }
        $rd = "\74\x64\151\x76\x20\143\154\141\163\x73\x3d\x22\155\x6f\137\x6f\x61\x75\164\x68\x5f\x70\162\x65\x6d\151\165\155\137\157\160\164\x69\x6f\156\137\x74\x65\170\164\42\40\x73\x74\171\x6c\145\75\x22\x74\x65\x78\x74\55\x61\154\151\147\x6e\x3a\x20\143\145\x6e\x74\x65\x72\73\142\157\162\144\145\x72\72\x20\x31\160\170\x20\x73\x6f\x6c\x69\x64\73\155\x61\162\147\151\156\72\40\x35\x70\x78\x3b\160\x61\144\144\x69\156\x67\55\164\x6f\x70\72\x20\62\x35\160\170\x3b\42\76\74\160\76\124\x68\x69\x73\x20\146\145\x61\164\x75\x72\145\x20\x69\x73\x20\163\x75\160\x70\x6f\162\164\145\144\x20\157\156\x6c\x79\40\151\156\x20\163\x74\x61\x6e\144\141\162\144\x20\x61\x6e\144\x20\x68\151\147\x68\x65\x72\40\166\145\162\x73\151\x6f\x6e\x73\56\x3c\x2f\160\x3e\xa\11\11\x9\x3c\160\76\x3c\141\40\x68\162\145\x66\75\x22" . get_site_url(null, "\x2f\167\x70\x2d\141\144\155\x69\x6e\57") . "\141\x64\x6d\151\156\x2e\160\150\x70\77\160\x61\147\x65\x3d\155\x6f\x5f\x6f\141\165\164\x68\x5f\163\x65\x74\x74\151\x6e\147\x73\x26\x74\141\142\x3d\x6c\x69\x63\145\x6e\163\151\156\147\x22\76\103\x6c\x69\x63\x6b\x20\x48\x65\x72\x65\74\57\x61\76\x20\x74\157\x20\163\145\145\x20\157\165\162\x20\x66\x75\x6c\x6c\40\154\x69\x73\x74\40\157\146\x20\x46\145\x61\x74\x75\162\x65\x73\56\74\57\x70\x3e\x3c\x2f\144\x69\x76\x3e";
        return $rd;
        BH:
        $rd = '';
        $this->error_message();
        $S0 = $xW->mo_oauth_client_get_option("\x6d\x6f\137\x6f\x61\165\164\x68\x5f\147\157\157\x67\x6c\x65\x5f\145\156\x61\x62\154\145") | $xW->mo_oauth_client_get_option("\x6d\x6f\x5f\x6f\141\165\x74\x68\x5f\x65\x76\145\157\x6e\154\x69\156\145\137\x65\156\141\x62\154\145") | $xW->mo_oauth_client_get_option("\x6d\x6f\x5f\x6f\141\x75\164\150\x5f\x66\x61\143\x65\142\x6f\x6f\153\137\x65\156\141\x62\154\x65");
        $E1 = $xW->mo_oauth_client_get_option("\155\x6f\x5f\157\x61\165\164\150\137\154\x6f\x67\151\156\137\151\143\x6f\156\x5f\163\x70\141\x63\x65");
        $IJ = $xW->mo_oauth_client_get_option("\155\157\137\157\141\165\x74\x68\x5f\154\157\147\151\156\137\151\143\x6f\x6e\x5f\x63\x75\163\x74\x6f\155\137\167\151\144\x74\x68");
        $NS = $xW->mo_oauth_client_get_option("\155\157\137\x6f\141\x75\x74\150\137\154\157\x67\151\x6e\137\x69\x63\157\x6e\x5f\143\x75\x73\x74\157\155\x5f\150\x65\151\147\150\164");
        $zh = $xW->mo_oauth_client_get_option("\155\x6f\137\157\141\x75\164\150\137\154\157\147\x69\156\x5f\151\x63\157\156\137\143\x75\x73\164\x6f\155\x5f\163\151\x7a\x65");
        $tM = $xW->mo_oauth_client_get_option("\x6d\x6f\x5f\157\141\x75\x74\150\137\154\157\x67\x69\x6e\137\151\143\157\156\x5f\x63\x75\x73\x74\x6f\x6d\137\143\x6f\x6c\157\x72");
        $nE = $xW->mo_oauth_client_get_option("\155\x6f\137\x6f\x61\x75\x74\150\137\154\157\147\151\156\x5f\151\x63\157\156\x5f\x63\165\x73\x74\157\155\x5f\142\x6f\165\156\x64\x61\162\171");
        $rj = $xW->mo_oauth_client_get_option("\x6d\x6f\137\157\141\x75\164\x68\x5f\x61\160\160\x73\137\154\x69\163\x74");
        if (!($rj && count($rj) > 0)) {
            goto ln;
        }
        $S0 = true;
        ln:
        $BX = $xW->get_plugin_config()->get_current_config();
        $Ds = isset($BX["\141\146\164\145\x72\x5f\x6c\x6f\147\x69\x6e\137\165\x72\x6c"]) && '' !== $BX["\x61\146\x74\145\162\x5f\154\x6f\147\x69\x6e\x5f\165\162\154"] ? $BX["\141\x66\164\145\x72\x5f\x6c\157\147\151\156\137\165\162\x6c"] : site_url();
        if (!is_user_logged_in() && !is_rest()) {
            goto vh;
        }
        $current_user = wp_get_current_user();
        $sy = $xW->mo_oauth_client_get_option("\155\157\137\157\x61\x75\164\150\x5f\x63\x75\163\x74\x6f\x6d\x5f\x6c\x6f\x67\x6f\x75\x74\x5f\164\145\x78\164") ? $xW->mo_oauth_client_get_option("\x6d\157\x5f\157\x61\165\164\150\137\143\x75\163\164\x6f\155\x5f\x6c\157\147\x6f\165\164\x5f\164\145\170\164") : "\110\x6f\x77\x64\x79\54\x20\43\x23\x75\163\x65\x72\x23\x23";
        $sy = apply_filters("\x6d\157\137\157\x61\x75\164\x68\137\x63\154\151\x65\156\164\137\x66\151\154\x74\x65\x72\x5f\x6c\157\147\157\x75\164\x5f\x74\145\x78\164", $sy);
        $sy = str_replace("\43\43\165\x73\x65\x72\43\43", $current_user->display_name, $sy);
        $Rx = __($sy, "\146\154\x77");
        $rd .= $Rx . "\x20\x7c\x20" . wp_loginout($Ds, false);
        goto Il;
        vh:
        if ($S0) {
            goto d1;
        }
        $rd .= "\x4e\157\x20\141\x70\x70\x73\40\x63\x6f\156\146\151\147\165\x72\x65\x64\x2e";
        d1:
        $this->mo_oauth_load_login_script();
        $sS = $xW->mo_oauth_client_get_option("\x6d\x6f\x5f\x6f\x61\x75\x74\x68\137\151\143\x6f\x6e\x5f\x77\x69\144\164\150");
        $vs = $xW->mo_oauth_client_get_option("\155\157\137\157\x61\165\x74\150\x5f\151\x63\x6f\156\x5f\150\145\151\147\150\164");
        $jT = $xW->mo_oauth_client_get_option("\155\157\137\x6f\x61\x75\164\x68\137\x69\143\x6f\156\x5f\x6d\x61\162\147\x69\x6e");
        $se = $xW->mo_oauth_client_get_option("\x6d\x6f\137\157\141\x75\x74\150\x5f\151\143\157\x6e\137\x63\x6f\156\146\x69\147\165\162\x65\x5f\143\163\x73");
        $zb = false !== $se && '' !== $se;
        $IJ = false !== $sS && '' !== $sS ? $sS : $IJ;
        $NS = false !== $vs && '' !== $vs ? $vs : $NS;
        $E1 = false !== $jT && '' !== $jT ? $jT : $E1;
        $IJ = substr($IJ, -2) !== "\160\x78" && substr($IJ, -1) !== "\45" ? $IJ . "\x70\170" : $IJ;
        $NS = substr($NS, -2) !== "\x70\x78" && substr($NS, -1) !== "\45" ? $NS . "\x70\x78" : $NS;
        $E1 = substr($E1, -2) !== "\x70\x78" && substr($E1, -1) !== "\x25" ? $E1 . "\160\170" : $E1;
        if (is_array($rj)) {
            goto of;
        }
        return $rd;
        of:
        foreach ($rj as $qV => $eL) {
            if (!($xz && '' !== $PT && $qV !== $PT)) {
                goto IY;
            }
            if (next($rj)) {
                goto tv;
            }
            $rd .= "\116\x6f\x20\103\x6f\x6e\146\x69\x67\x75\x72\145\144\x20\101\x70\x70\x73\x20\x77\151\164\150\40\164\x68\x69\163\40\x6e\x61\x6d\145\56";
            tv:
            goto st;
            IY:
            $PB = $xW->mo_oauth_client_get_option("\x6d\x6f\x5f\x6f\x61\165\164\x68\x5f\141\x70\x70\x5f\x6e\141\x6d\x65\137" . $qV);
            $aA = array("\151\x6d\141\147\145\x75\162\x6c" => '', "\x62\143\x6f\154\157\162" => "\x62\164\156\55\x70\x72\151\155\141\x72\171", "\154\x6f\x67\x6f\x5f\x63\154\x61\163\x73" => "\x66\x61\40\x66\x61\55\154\157\x63\153");
            $aA = apply_filters("\155\157\137\157\141\x75\x74\150\x5f\167\x69\x64\147\145\164\137\151\x6e\x74\x65\162\156\141\154", $aA);
            $ji = $xW->check_versi(1) ? $aA["\151\155\141\147\x65\165\x72\154"] : '';
            $kX = $xW->check_versi(1) ? $aA["\142\x63\x6f\154\157\162"] : "\x23\x31\142\x37\x30\142\61";
            $Vl = $xW->check_versi(1) ? $aA["\154\157\x67\x6f\x5f\x63\154\141\x73\163"] : '';
            $l5 = "\143\154\141\163\x73\x3d\x22\157\141\165\x74\x68\x6c\157\147\x69\x6e\142\165\164\x74\x6f\x6e\x20\x62\x74\x6e";
            $l5 .= $xW->check_versi(1) ? "\x20\x62\x74\x6e\x2d\x73\157\x63\151\141\x6c\40" . $kX . "\42" : "\x20\x62\164\x6e\55\x66\144\x65\x66\x61\165\154\164\42";
            $n7 = "\157\x61\165\x74\x68\x5f\x61\160\x70\x5f" . str_replace("\40", "\55", $qV);
            $QG = $eL->get_app_config("\x64\151\x73\x70\154\141\x79\141\160\160\156\x61\x6d\x65");
            if ($QG) {
                goto sC;
            }
            $QG = ucwords($qV);
            sC:
            $mh = $xW->get_app_by_name($qV)->get_app_config();
            $Db = isset($mh["\x67\x72\x61\156\164\x5f\x74\171\160\145"]) && "\120\x61\x73\x73\x77\157\162\144\40\x47\162\141\156\164" === $mh["\147\x72\141\x6e\x74\x5f\x74\x79\160\145"] ? "\x6d\157\x4f\x41\x75\164\150\114\157\147\x69\x6e\120\x77\x64" : "\155\157\117\101\x75\x74\150\x4c\x6f\147\151\x6e\x4e\x65\167";
            if (empty($se)) {
                goto C_;
            }
            $rd .= "\74\141\x20\150\x72\x65\x66\x3d\x22\x6a\141\x76\x61\x73\x63\162\151\x70\164\72\166\157\x69\x64\x28\60\x29\42\x20\x6f\x6e\x63\154\x69\x63\x6b\x3d\42" . $Db . "\50\x27" . $qV . "\47\51\73\42\x20" . $l5 . "\x20\163\164\x79\x6c\x65\x3d\x22" . $se . "\x22\x3e\x20";
            $rd .= $Vl ? "\74\x69\x20\143\154\x61\163\x73\75\42" . $Vl . "\x20\143\x75\x73\164\157\x6d\137\x6c\157\x67\x6f\x22\x3e\x3c\57\151\x3e\40" : '';
            $rd .= $QG . "\x20\74\x2f\141\76";
            $rd .= "\x3c\x73\x74\171\x6c\x65\x3e" . $se . "\74\x2f\163\164\171\154\x65\x3e";
            goto o_;
            C_:
            $rd .= "\74\x61\x20\150\162\x65\x66\x3d\x22\x6a\x61\x76\x61\x73\143\x72\151\160\x74\x3a\x76\157\151\144\50\x30\51\42\x20\x6f\156\x63\154\x69\x63\x6b\x3d\x22" . $Db . "\50\x27" . $qV . "\47\51\x3b\42\x20\x73\x74\171\x6c\145\75\42\143\157\x6c\157\162\72\x77\150\x69\164\x65\73\164\x65\170\164\x2d\144\x65\143\157\x72\x61\164\151\x6f\156\x3a\x20\156\157\x6e\x65\x3b\40\x64\151\x73\x70\154\x61\x79\72\x62\154\157\143\x6b\73\155\x61\x72\x67\x69\156\72\x30\x3b\167\151\144\x74\x68\72" . $IJ . "\40\41\x69\155\160\157\x72\x74\x61\x6e\164\73\160\x61\x64\x64\151\156\147\55\164\157\x70\72" . $NS . "\40\41\x69\155\x70\x6f\162\164\141\156\164\73\160\141\x64\x64\x69\156\147\x2d\x62\157\164\164\157\x6d\x3a" . $NS . "\x20\x21\x69\155\160\157\162\x74\141\156\x74\73\x6d\141\x72\147\x69\156\x2d\x62\157\x74\x74\157\x6d\72" . $E1 . "\40\x21\x69\155\160\157\x72\164\141\x6e\164\x3b\142\x6f\x72\x64\x65\162\55\162\x61\144\151\x75\x73\x3a" . $nE . "\x20\41\x69\x6d\x70\x6f\x72\164\141\156\x74\73\x22\x20" . $l5 . "\x3e\40";
            $rd .= $Vl ? "\74\151\40\163\164\x79\154\145\75\42\x70\141\144\144\x69\156\147\55\164\x6f\160\x3a" . $NS . "\55\66\x20\x70\170\x20\x21\151\155\x70\x6f\x72\164\141\156\164\x3b\40\x77\x69\144\164\150\x3a\61\x35\45\x22\x20\x63\x6c\141\x73\163\x3d\42" . $Vl . "\x22\x3e\74\57\x69\76" : '';
            $rd .= $QG . "\40\x3c\57\141\76";
            o_:
            $PB = "\40";
            st:
        }
        m0:
        Il:
        return $rd;
    }
    private function mo_oauth_load_login_script()
    {
        wp_enqueue_style("\x6d\x6f\55\167\x70\x2d\142\157\x6f\x74\163\164\162\141\160\x2d\x73\157\143\x69\x61\x6c", MOC_URL . "\162\145\x73\157\165\x72\x63\145\163\x2f\143\163\163\x2f\x62\x6f\x6f\164\x73\164\x72\x61\160\x2d\163\x6f\143\151\x61\154\56\143\x73\163", array(), $Uy = null, $kK = false);
        wp_enqueue_style("\x6d\157\x2d\x77\160\55\x62\x6f\x6f\x74\163\x74\x72\x61\x70\x2d\x6d\141\151\156", MOC_URL . "\x72\x65\x73\157\x75\162\x63\x65\163\57\x63\x73\x73\57\x62\157\x6f\x74\x73\x74\x72\141\x70\56\155\151\x6e\x2d\160\x72\145\166\x69\x65\167\56\x63\163\163", array(), $Uy = null, $kK = false);
        wp_enqueue_style("\x6d\x6f\55\x77\x70\55\x66\x6f\x6e\164\x2d\x61\x77\145\x73\157\155\145", MOC_URL . "\162\145\163\157\165\162\143\x65\x73\x2f\143\163\x73\x2f\146\x6f\x6e\164\x2d\141\167\x65\x73\x6f\x6d\145\56\x63\x73\x73\77\x76\x65\162\x73\151\x6f\x6e\x3d\x34\56\x38", array(), $Uy = null, $kK = false);
        ?>
	<script type="text/javascript">

		function HandlePopupResult(result) {
			window.location.href = result;
		}

		function moOAuthLogin(app_name) {
			window.location.href = '<?php 
        echo site_url();
        ?>
' + '/?option=generateDynmicUrl&app_name=' + app_name; <?php 
        ?>
		}
		function moOAuthCommonLogin(app_name) {
			<?php 
        global $xW;
        $wY = $xW->get_current_url();
        $BX = $xW->get_plugin_config();
        $rj = get_option("\x6d\157\137\x6f\141\165\x74\150\137\141\160\x70\x73\x5f\154\151\163\164");
        $EJ = '';
        if (!boolval($BX->get_config("\x61\x63\164\151\x76\x61\x74\x65\137\163\x69\156\147\154\x65\137\154\157\x67\151\x6e\x5f\x66\154\x6f\167"))) {
            goto sd;
        }
        if (!is_array($rj)) {
            goto AT;
        }
        foreach ($rj as $qV => $sw) {
            $EJ .= "\x3c\x61\x20\x68\x72\x65\x66\75\x22" . site_url() . "\57\77\157\x70\x74\151\157\156\x3d\x6f\141\165\164\150\x72\x65\144\151\162\x65\x63\x74\x26\x61\x70\x70\x5f\x6e\x61\155\x65\75" . $qV . "\42\x3e" . $qV . "\x3c\57\141\x3e\46\x6e\142\163\160\73\x26\156\x62\163\x70\x3b";
            nM:
        }
        sY:
        AT:
        echo "\157\x75\x74\x70\165\164\x20\75\40\47\74\142\x3e\120\x6c\145\x61\163\145\40\x73\145\x6c\x65\143\164\x20\x79\157\165\162\x20\x41\x70\x70\57\x47\x72\x6f\165\x70\57\114\x6f\147\x69\156\x20\x44\x6f\x6d\x61\151\156\x20\72\x20\x3c\x2f\142\76\x3c\x62\x72\76\74\142\x72\x3e" . $EJ . "\x27\x3b";
        echo "\x64\x6f\143\x75\x6d\145\156\x74\x2e\167\x72\151\x74\x65\x28\x6f\x75\x74\160\165\x74\51\x3b";
        sd:
        ?>
		}

		function moOAuthLoginNew(app_name) {
			var base_url = "<?php 
        echo site_url();
        ?>
";
			<?php 
        global $xW;
        $wY = $xW->get_current_url();
        $BX = $xW->get_plugin_config();
        if (boolval($BX->get_config("\x70\x6f\x70\x75\x70\137\x6c\x6f\147\151\x6e"))) {
            goto BV;
        }
        ?>
				window.location.href = base_url + "/?option=oauthredirect&app_name=" + app_name + '&redirect_url=<?php 
        echo rawurlencode($wY);
        ?>
';
				<?php 
        goto SB;
        BV:
        ?>
				var myWindow = window.open( base_url + '/?option=oauthredirect&app_name=' + app_name + '&redirect_url=<?php 
        echo rawurlencode($wY);
        ?>
', '', 'width=500,height=500');
				<?php 
        SB:
        ?>
		}
	</script>
		<?php 
        do_action("\155\x6f\137\157\x61\x75\x74\x68\137\x63\154\151\x65\x6e\x74\137\141\144\144\137\160\167\x64\x5f\x6a\163");
    }
    public function error_message()
    {
        $gj = get_transient("\155\157\x5f\157\141\165\x74\x68\137\x77\151\144\147\x65\x74\x5f\155\163\x67");
        $gG = get_transient("\155\157\x5f\x6f\x61\x75\x74\x68\x5f\167\x69\144\147\x65\164\137\x6d\163\x67\x5f\x63\x6c\x61\x73\x73");
        if (!($gj && $gG)) {
            goto KS;
        }
        echo "\x3c\x64\151\x76\40\143\x6c\x61\163\163\x3d\42" . $gG . "\x22\x3e" . $gj . "\x3c\x2f\144\151\x76\x3e";
        delete_transient("\155\157\x5f\157\141\165\164\x68\x5f\x77\151\x64\x67\145\x74\137\155\x73\147");
        delete_transient("\155\x6f\x5f\157\x61\x75\164\x68\137\x77\x69\x64\x67\145\x74\x5f\x6d\x73\x67\x5f\143\x6c\141\163\x73");
        KS:
    }
    public function register_plugin_styles()
    {
        wp_enqueue_style("\x73\x74\171\x6c\145\137\x6c\x6f\x67\x69\156\x5f\167\x69\144\147\x65\164", MOC_URL . "\162\145\x73\x6f\165\x72\x63\x65\163\x2f\143\163\x73\x2f\163\x74\x79\x6c\x65\x5f\154\157\147\151\x6e\x5f\167\x69\x64\x67\145\164\56\143\x73\x73", $Uy = null, $kK = false);
    }
}
