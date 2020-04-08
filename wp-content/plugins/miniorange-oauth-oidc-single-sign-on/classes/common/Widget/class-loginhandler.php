<?php


namespace MoOauthClient;

use MoOauthClient\Base\InstanceHelper;
use MoOauthClient\OauthHandler;
use MoOauthClient\StorageManager;
class LoginHandler
{
    public $oauth_handler;
    public function __construct()
    {
        $this->oauth_handler = new OauthHandler();
        add_action("\x69\x6e\151\164", array($this, "\155\x6f\x5f\x6f\x61\x75\164\x68\x5f\x64\x65\x63\151\144\x65\x5f\146\154\x6f\167"));
        add_action("\155\x6f\137\x6f\x61\x75\x74\150\x5f\143\154\151\145\x6e\x74\137\164\151\147\150\x74\x5f\x6c\157\x67\x69\x6e\x5f\151\x6e\x74\145\162\x6e\141\x6c", array($this, "\x68\x61\156\144\x6c\145\x5f\x73\x73\x6f"), 10, 4);
    }
    public function mo_oauth_decide_flow()
    {
        global $xW;
        if (!(isset($_REQUEST[\MoOAuthConstants::OPTION]) && "\x74\145\163\164\x61\x74\x74\x72\x6d\141\x70\160\x69\x6e\x67\143\157\156\x66\151\147" === $_REQUEST[\MoOAuthConstants::OPTION])) {
            goto pn;
        }
        $jK = $_REQUEST["\x61\x70\x70"];
        wp_safe_redirect(site_url() . "\x3f\x6f\160\x74\x69\x6f\x6e\75\x6f\x61\165\x74\x68\x72\x65\144\151\162\x65\x63\164\x26\141\x70\x70\x5f\156\141\155\145\x3d" . rawurlencode($jK) . "\x26\x74\145\163\x74\x3d\164\x72\165\145");
        die;
        pn:
        $this->mo_oauth_login_validate();
    }
    public function mo_oauth_login_validate()
    {
        global $xW;
        $Sw = new StorageManager();
        if (!(isset($_REQUEST[\MoOAuthConstants::OPTION]) and strpos($_REQUEST[\MoOAuthConstants::OPTION], "\x6f\x61\165\164\150\162\x65\144\151\x72\145\x63\164") !== false)) {
            goto Ij;
        }
        if (!(isset($_REQUEST["\x72\x65\x73\x6f\x75\162\x63\x65"]) && !empty($_REQUEST["\162\x65\x73\157\x75\x72\143\145"]))) {
            goto RK;
        }
        $Sw = new StorageManager(urldecode($_REQUEST["\x72\145\x73\157\x75\x72\143\x65"]));
        if (!is_wp_error($Sw)) {
            goto Bg;
        }
        wp_die(wp_kses($Sw->get_error_message(), \get_valid_html()));
        Bg:
        $f8 = $Sw->get_value("\x72\145\x73\157\x75\x72\143\x65");
        $gQ = $Sw->get_value("\x61\160\160\x6e\141\155\x65");
        $U6 = $Sw->get_value("\x72\145\144\x69\x72\x65\x63\x74\137\165\x72\151");
        $d9 = $Sw->get_value("\141\143\143\x65\163\x73\137\x74\x6f\153\145\x6e");
        $mh = $xW->get_app_by_name($gQ)->get_app_config();
        $tE = isset($_REQUEST["\x74\x65\163\x74"]) && !empty($_REQUEST["\164\x65\163\164"]);
        if (!($tE && '' !== $tE)) {
            goto e_;
        }
        $this->handle_group_test_conf($f8, $mh, $d9, false, $tE);
        die;
        e_:
        $Sw->remove_key("\x72\x65\163\x6f\x75\x72\x63\145");
        $Sw->add_replace_entry("\x70\x6f\160\x75\x70", "\x69\147\x6e\x6f\162\145");
        $this->handle_sso($gQ, $mh, $f8, $Sw->get_state(), array("\141\x63\x63\x65\163\163\x5f\164\157\153\x65\156" => $d9));
        RK:
        $Sm = $_REQUEST["\141\160\x70\137\x6e\141\155\145"];
        $rj = $xW->mo_oauth_client_get_option("\155\157\x5f\x6f\141\x75\x74\150\x5f\141\x70\x70\x73\x5f\154\151\163\x74");
        $EN = isset($_REQUEST["\x72\145\144\x69\x72\145\x63\x74\x5f\x75\x72\154"]) ? urldecode($_REQUEST["\162\x65\144\x69\162\x65\143\164\x5f\x75\x72\x6c"]) : site_url();
        $tE = isset($_REQUEST["\x74\145\163\164"]) ? urldecode($_REQUEST["\164\145\163\x74"]) : false;
        $Rs = isset($_REQUEST["\x72\x65\x73\164\162\x69\x63\164\162\x65\x64\151\162\x65\143\164"]) ? urldecode($_REQUEST["\x72\145\163\164\162\x69\x63\164\x72\x65\x64\x69\162\x65\143\x74"]) : false;
        $eL = $xW->get_app_by_name($Sm);
        $T3 = $eL->get_app_config("\x67\x72\x61\x6e\164\x5f\164\171\x70\145");
        if (!($T3 && "\x50\x61\163\163\167\157\162\144\40\x47\x72\141\156\164" === $T3)) {
            goto BD;
        }
        do_action("\x70\167\144\137\145\163\163\145\x6e\x74\151\x61\154\x73\x5f\x69\156\164\145\162\x6e\x61\x6c");
        do_action("\x6d\157\x5f\157\x61\x75\164\150\137\143\x6c\x69\x65\x6e\x74\x5f\141\144\x64\137\160\167\x64\137\152\x73");
        ?>
				<script>
					var mo_oauth_app_name = "<?php 
        echo wp_kses($Sm, \get_valid_html());
        ?>
";
					document.addEventListener('DOMContentLoaded', function() {
						<?php 
        if ($tE) {
            goto aq;
        }
        ?>
							moOAuthLoginPwd(mo_oauth_app_name, false, '<?php 
        echo $EN;
        ?>
');
						<?php 
        goto bv;
        aq:
        ?>
							moOAuthLoginPwd(mo_oauth_app_name, true, '<?php 
        echo $EN;
        ?>
');
						<?php 
        bv:
        ?>
					}, false);
				</script>
				<?php 
        die;
        BD:
        $Sw->add_replace_entry("\141\x70\x70\156\141\x6d\x65", $Sm);
        $Sw->add_replace_entry("\162\x65\144\151\x72\x65\x63\x74\137\165\x72\x69", $EN);
        $Sw->add_replace_entry("\x74\145\163\x74\x5f\x63\157\156\x66\x69\x67", $tE);
        $Sw->add_replace_entry("\x72\x65\163\164\x72\x69\143\164\x72\145\144\151\x72\x65\x63\x74", $Rs);
        $tZ = $Sw->get_state();
        $tZ = apply_filters("\x73\x74\141\x74\145\x5f\x69\156\x74\x65\x72\x6e\141\154", $tZ);
        $ms = $eL->get_app_config("\141\165\x74\150\x6f\162\x69\172\145\x75\162\x6c");
        if (!(strpos($ms, "\147\157\x6f\147\154\x65") !== false)) {
            goto Fu;
        }
        $ms = "\150\x74\164\160\x73\72\57\57\141\x63\143\157\x75\156\164\163\56\147\x6f\x6f\x67\154\x65\56\x63\x6f\x6d\x2f\x6f\57\x6f\x61\x75\x74\x68\x32\x2f\141\165\164\150";
        Fu:
        if (strpos($ms, "\x3f") !== false) {
            goto JC;
        }
        $ms = $ms . "\x3f\x63\x6c\151\145\156\x74\137\151\x64\x3d" . urlencode($eL->get_app_config("\x63\x6c\151\145\156\164\x5f\x69\144")) . "\x26\x73\x63\x6f\x70\x65\75" . $eL->get_app_config("\163\143\x6f\160\145") . "\46\162\145\144\x69\162\145\x63\x74\137\x75\162\x69\x3d" . urlencode(\site_url()) . "\46\162\x65\163\x70\x6f\x6e\163\145\137\164\171\160\145\x3d\143\x6f\x64\145\x26\x73\x74\141\164\x65\75" . $tZ;
        goto eW;
        JC:
        $ms = $ms . "\x26\143\154\x69\x65\156\x74\137\x69\144\x3d" . urlencode($eL->get_app_config("\x63\154\x69\x65\156\164\x5f\x69\144")) . "\46\x73\143\x6f\160\x65\75" . $eL->get_app_config("\x73\x63\157\160\145") . "\x26\162\145\144\x69\x72\145\143\x74\137\x75\162\x69\x3d" . urlencode(\site_url()) . "\46\x72\x65\163\160\x6f\x6e\163\x65\x5f\x74\171\160\x65\75\x63\x6f\x64\x65\x26\x73\x74\x61\164\x65\75" . $tZ;
        eW:
        if (!(session_id() === '' || !isset($_SESSION))) {
            goto eq;
        }
        session_start(array("\x72\x65\141\x64\137\141\x6e\x64\137\143\x6c\157\x73\x65" => true));
        eq:
        $ms = apply_filters("\x6d\x6f\137\141\165\x74\x68\x5f\165\162\x6c\137\x69\156\164\x65\x72\156\x61\154", $ms, $Sm);
        header("\114\x6f\x63\141\164\x69\x6f\x6e\72\x20" . $ms);
        die;
        Ij:
        if (!(strpos($_SERVER["\122\x45\x51\125\105\123\124\137\x55\x52\x49"], "\57\x6f\141\x75\164\150\x63\x61\154\154\x62\x61\x63\x6b") !== false || isset($_GET["\143\157\144\x65"]))) {
            goto dz;
        }
        try {
            $tZ = isset($_GET["\x73\x74\x61\164\145"]) ? wp_unslash($_GET["\x73\x74\x61\164\x65"]) : false;
            $Sw = new StorageManager($tZ);
            if (!is_wp_error($Sw)) {
                goto m1;
            }
            wp_die(wp_kses($Sw->get_error_message(), \get_valid_html()));
            m1:
            $Sm = $Sw->get_value("\141\x70\x70\x6e\x61\x6d\x65");
            $tE = $Sw->get_value("\164\145\x73\164\x5f\x63\157\156\x66\x69\x67");
            $gQ = $Sm ? $Sm : '';
            $rj = $xW->mo_oauth_client_get_option("\155\x6f\137\157\141\x75\x74\x68\x5f\141\x70\x70\x73\x5f\154\151\x73\164");
            $zI = '';
            $NQ = '';
            $v_ = $xW->get_app_by_name($gQ);
            if ($v_) {
                goto fT;
            }
            die("\101\160\x70\154\151\x63\141\164\x69\157\156\40\156\x6f\164\x20\143\x6f\x6e\x66\x69\x67\x75\162\145\144\x2e");
            fT:
            $mh = $v_->get_app_config();
            $w1 = array("\x67\162\x61\x6e\164\137\164\171\160\145" => "\141\x75\164\x68\157\x72\151\x7a\141\164\151\x6f\156\x5f\143\157\x64\x65", "\143\x6c\x69\x65\156\164\x5f\x69\x64" => $mh["\x63\x6c\151\145\x6e\164\x5f\x69\x64"], "\143\154\151\145\x6e\164\x5f\163\x65\x63\162\145\x74" => $mh["\x63\154\x69\145\x6e\x74\x5f\x73\x65\x63\162\145\x74"], "\162\x65\x64\151\162\145\x63\164\137\x75\162\x69" => $mh["\x72\x65\144\x69\x72\145\143\164\x5f\165\x72\151"], "\x63\x6f\x64\x65" => $_GET["\x63\157\x64\145"], "\x73\x63\157\x70\145" => $v_->get_app_config("\163\x63\x6f\x70\145"));
            $jb = isset($mh["\x73\145\156\x64\137\150\x65\141\x64\x65\162\163"]) ? $mh["\x73\145\156\x64\137\150\145\141\144\145\162\163"] : 0;
            $vK = isset($mh["\x73\145\x6e\144\137\x62\157\x64\171"]) ? $mh["\163\x65\156\x64\x5f\x62\157\x64\x79"] : 0;
            if ("\x6f\x70\145\x6e\x69\144\143\157\x6e\156\145\143\164" === $v_->get_app_config("\141\x70\160\x5f\x74\171\x70\x65")) {
                goto Tc;
            }
            $ZP = $mh["\141\x63\143\x65\x73\163\164\x6f\x6b\x65\x6e\x75\162\x6c"];
            if (!(strpos($ZP, "\x67\157\157\x67\x6c\x65") !== false)) {
                goto ak;
            }
            $ZP = "\150\x74\x74\x70\163\72\x2f\x2f\x77\167\167\56\147\x6f\157\147\x6c\145\141\x70\151\x73\56\143\x6f\x6d\57\157\141\x75\164\150\62\x2f\x76\x34\x2f\x74\157\x6b\x65\x6e";
            ak:
            $qz = json_decode($this->oauth_handler->get_token($ZP, $w1, $jb, $vK), true);
            if (isset($qz["\141\x63\143\145\x73\163\x5f\164\x6f\x6b\x65\x6e"])) {
                goto IH;
            }
            die("\x49\x6e\x76\141\154\151\x64\40\x74\157\153\145\x6e\40\162\x65\143\x65\x69\166\x65\x64\x2e");
            IH:
            $oj = $mh["\x72\145\x73\157\x75\x72\143\x65\x6f\x77\156\x65\x72\144\145\x74\x61\x69\154\x73\x75\162\x6c"];
            if (!(substr($oj, -1) === "\x3d")) {
                goto Rf;
            }
            $oj .= $qz["\141\x63\x63\x65\x73\163\137\164\x6f\x6b\145\156"];
            Rf:
            if (!(strpos($oj, "\147\157\x6f\147\x6c\145") !== false)) {
                goto ug;
            }
            $oj = "\x68\164\164\x70\163\x3a\x2f\x2f\x77\x77\x77\56\147\157\157\147\154\x65\x61\x70\151\x73\56\143\157\155\x2f\157\141\x75\164\x68\62\x2f\x76\x31\57\x75\163\x65\x72\x69\156\x66\157";
            ug:
            $f8 = $this->oauth_handler->get_resource_owner($oj, $qz["\x61\143\143\x65\x73\x73\137\164\157\x6b\145\156"]);
            $NY = array();
            foreach ($f8 as $qV => $sw) {
                $NY[] = $qV;
                Un:
            }
            zU:
            $xW->mo_oauth_client_update_option("\x6d\x6f\137\x6f\x61\x75\164\150\x5f\x61\164\x74\x72\x5f\x6e\x61\x6d\x65\x5f\x6c\x69\163\164" . $gQ, $NY);
            if (!($tE && '' !== $tE)) {
                goto rH;
            }
            $this->handle_group_test_conf($f8, $mh, $qz["\x61\143\x63\x65\163\163\137\x74\157\153\x65\x6e"], false, $tE);
            die;
            rH:
            goto Um;
            Tc:
            $qz = json_decode($this->oauth_handler->get_token($mh["\x61\143\x63\x65\x73\163\x74\157\x6b\145\x6e\x75\162\x6c"], $w1, $jb, $vK), true);
            $co = isset($qz["\151\x64\x5f\x74\x6f\153\145\156"]) ? $qz["\151\144\137\164\x6f\153\x65\156"] : false;
            $d9 = isset($qz["\x61\x63\x63\x65\163\163\137\164\x6f\153\145\156"]) ? $qz["\x61\x63\143\145\163\163\x5f\x74\x6f\x6b\145\156"] : false;
            if (!$co) {
                goto y2;
            }
            $f8 = $this->get_resource_owner_from_app($co, $gQ);
            if (!($tE && '' !== $tE)) {
                goto mB;
            }
            $this->handle_group_test_conf($f8, $mh, $qz, false, $tE);
            die;
            mB:
            goto jc;
            y2:
            die("\x49\x6e\166\141\x6c\151\x64\40\x74\x6f\153\145\x6e\x20\x72\x65\143\145\151\166\x65\x64\56");
            jc:
            Um:
            $this->handle_sso($gQ, $mh, $f8, $tZ, $qz);
        } catch (Exception $yh) {
            die(esc_html($yh->getMessage()));
        }
        dz:
    }
    public function handle_group_test_conf($f8 = array(), $mh = array(), $d9 = '', $QI = false, $tE = false)
    {
        $this->render_test_config_output($f8, false);
    }
    public function testattrmappingconfig($bA, $B_)
    {
        foreach ($B_ as $qV => $Cq) {
            if (is_array($Cq) || is_object($Cq)) {
                goto eH;
            }
            echo "\x3c\164\x72\76\74\164\144\76";
            if (empty($bA)) {
                goto j3;
            }
            echo $bA . "\x2e";
            j3:
            echo $qV . "\74\57\x74\x64\x3e\74\164\144\x3e" . $Cq . "\74\x2f\x74\x64\x3e\x3c\57\164\162\76";
            goto cq;
            eH:
            if (empty($bA)) {
                goto Ef;
            }
            $bA .= "\x2e";
            Ef:
            $this->testattrmappingconfig($bA . $qV, $Cq);
            cq:
            Qj:
        }
        Wm:
    }
    public function render_test_config_output($f8, $QI = false)
    {
        echo "\74\144\x69\166\x20\x73\x74\x79\154\x65\x3d\42\x66\157\156\164\x2d\146\x61\x6d\151\154\171\x3a\103\x61\154\151\x62\x72\151\x3b\x70\x61\144\x64\151\x6e\x67\x3a\60\40\x33\45\73\x22\x3e";
        echo "\74\x73\x74\x79\x6c\145\x3e\164\141\x62\154\x65\173\x62\x6f\x72\144\x65\162\55\x63\157\x6c\x6c\141\160\163\145\x3a\x63\157\154\x6c\x61\x70\x73\145\73\x7d\164\150\40\173\142\141\143\153\147\x72\x6f\165\x6e\x64\x2d\x63\157\x6c\x6f\162\x3a\x20\43\x65\145\145\x3b\x20\x74\145\170\164\x2d\141\154\x69\x67\156\72\40\x63\x65\156\164\145\162\73\x20\x70\141\144\144\151\x6e\147\72\x20\x38\x70\170\x3b\x20\x62\x6f\x72\x64\145\x72\x2d\x77\151\144\x74\150\x3a\x31\x70\x78\x3b\x20\x62\x6f\162\144\x65\162\55\x73\164\171\154\x65\x3a\x73\x6f\154\151\144\x3b\x20\x62\x6f\x72\144\145\162\x2d\x63\x6f\154\x6f\162\72\x23\62\x31\62\61\x32\61\x3b\x7d\164\162\x3a\156\x74\150\55\x63\150\151\x6c\x64\x28\157\x64\x64\51\x20\173\142\x61\x63\153\147\x72\x6f\x75\156\x64\55\x63\157\154\x6f\x72\x3a\x20\43\146\x32\x66\x32\146\x32\73\175\40\x74\144\173\x70\141\144\144\x69\156\x67\72\70\160\170\73\142\157\x72\144\x65\162\55\167\x69\144\164\x68\72\61\160\170\x3b\40\142\x6f\162\x64\x65\162\x2d\163\x74\171\x6c\x65\x3a\163\x6f\x6c\151\144\x3b\x20\x62\x6f\162\x64\x65\162\55\x63\157\154\157\x72\x3a\43\62\61\x32\61\x32\x31\x3b\x7d\x3c\x2f\x73\164\x79\x6c\x65\x3e";
        echo "\74\150\62\x3e";
        echo $QI ? "\107\x72\157\165\160\x20\111\x6e\x66\x6f" : "\x54\x65\x73\164\x20\103\157\156\146\151\x67\165\x72\x61\x74\x69\x6f\156";
        echo "\74\57\150\62\76\74\x74\x61\x62\x6c\x65\76\x3c\x74\x72\x3e\74\164\x68\x3e\101\x74\x74\162\151\142\165\164\145\40\x4e\141\x6d\x65\74\x2f\x74\150\x3e\x3c\164\x68\x3e\x41\x74\164\x72\x69\x62\x75\164\145\x20\126\x61\154\x75\x65\x3c\57\164\150\x3e\74\57\164\x72\x3e";
        $this->testattrmappingconfig('', $f8);
        echo "\x3c\x2f\x74\141\142\x6c\145\x3e";
        if ($QI) {
            goto sO;
        }
        echo "\x3c\144\151\x76\x20\163\164\x79\154\x65\x3d\42\x70\x61\x64\x64\x69\x6e\x67\72\40\61\x30\160\170\73\x22\76\74\57\144\151\166\76\74\x69\156\x70\165\164\40\163\x74\x79\154\145\75\x22\160\x61\x64\144\151\156\x67\72\61\x25\x3b\x77\x69\x64\x74\x68\72\x31\60\60\x70\170\x3b\142\141\x63\x6b\x67\x72\x6f\165\x6e\x64\x3a\40\x23\x30\x30\71\x31\103\104\40\x6e\x6f\x6e\145\x20\x72\145\x70\x65\141\x74\40\163\143\162\x6f\154\x6c\40\x30\x25\40\60\x25\x3b\x63\x75\162\163\157\x72\x3a\x20\160\x6f\x69\156\x74\x65\162\73\x66\x6f\x6e\164\x2d\x73\151\x7a\x65\x3a\x31\x35\x70\170\x3b\x62\x6f\162\x64\x65\x72\55\167\x69\x64\x74\150\72\x20\x31\160\x78\73\x62\x6f\x72\x64\x65\162\x2d\163\164\171\154\145\x3a\x20\163\157\x6c\151\x64\x3b\x62\x6f\x72\144\x65\x72\x2d\x72\141\144\x69\165\163\x3a\40\x33\x70\170\73\x77\x68\x69\x74\x65\55\x73\160\141\143\145\x3a\40\156\157\167\162\141\160\x3b\x62\157\170\55\x73\x69\x7a\151\x6e\x67\72\x20\142\157\162\144\145\162\x2d\x62\x6f\x78\x3b\142\157\x72\144\145\x72\x2d\143\x6f\x6c\157\x72\72\x20\x23\x30\60\x37\63\101\x41\73\x62\157\170\x2d\163\150\x61\x64\157\167\x3a\40\60\160\x78\40\61\x70\x78\40\x30\x70\170\x20\x72\147\142\141\x28\x31\x32\x30\x2c\x20\x32\60\x30\x2c\x20\62\x33\x30\x2c\40\x30\56\x36\51\40\151\156\163\145\x74\x3b\143\x6f\x6c\x6f\162\72\40\43\x46\106\x46\x3b\x22\164\x79\160\145\75\42\142\165\x74\164\x6f\x6e\x22\40\x76\x61\154\165\x65\x3d\x22\104\x6f\156\x65\42\x20\x6f\156\103\x6c\151\143\x6b\75\x22\163\x65\154\x66\x2e\143\x6c\157\163\x65\x28\51\73\42\x3e\x3c\57\144\151\x76\76";
        sO:
    }
    public function handle_sso($gQ, $mh, $f8, $tZ, $qz, $ua = false)
    {
        global $xW;
        if (!(get_class($this) === "\115\x6f\117\141\165\x74\x68\103\x6c\x69\145\x6e\164\x5c\x4c\x6f\147\x69\x6e\110\x61\x6e\144\154\x65\x72" && $xW->check_versi(1))) {
            goto QW;
        }
        $Bk = new \MoOauthClient\Base\InstanceHelper();
        $Br = $Bk->get_login_handler_instance();
        $Br->handle_sso($gQ, $mh, $f8, $tZ, $qz, $ua);
        QW:
        $zI = isset($mh["\156\141\155\x65\x5f\141\x74\x74\x72"]) ? $mh["\x6e\141\x6d\x65\137\141\x74\164\162"] : '';
        $NQ = isset($mh["\145\x6d\141\x69\x6c\x5f\141\x74\164\162"]) ? $mh["\x65\155\x61\x69\154\137\141\164\164\x72"] : '';
        $xv = $xW->getnestedattribute($f8, $NQ);
        $ts = $xW->getnestedattribute($f8, $zI);
        if (!empty($xv)) {
            goto Cv;
        }
        wp_die("\x45\155\x61\151\x6c\x20\x61\144\144\162\x65\163\163\x20\x6e\x6f\x74\x20\x72\x65\x63\x65\x69\166\145\144\56\40\x43\150\x65\143\x6b\x20\x79\157\x75\162\40\x3c\x73\x74\x72\x6f\156\147\x3e\101\x74\x74\162\151\142\165\x74\x65\x20\x4d\141\x70\x70\x69\x6e\147\74\x2f\x73\164\162\x6f\156\147\x3e\x20\143\x6f\156\146\x69\x67\165\x72\x61\x74\151\x6f\156\x2e");
        Cv:
        if (!(false === strpos($xv, "\100"))) {
            goto le;
        }
        wp_die("\115\141\160\160\145\144\x20\105\155\141\x69\154\40\141\164\x74\162\151\x62\165\x74\x65\x20\x64\157\145\x73\x20\x6e\157\164\40\143\x6f\x6e\x74\x61\x69\156\40\166\141\154\x69\144\40\145\155\x61\151\154\56");
        le:
        $user = get_user_by("\x6c\x6f\147\151\x6e", $xv);
        if ($user) {
            goto Bu;
        }
        $user = get_user_by("\145\x6d\141\x69\x6c", $xv);
        Bu:
        if ($user) {
            goto Rx;
        }
        $bI = 0;
        if ($xW->mo_oauth_hbca_xyake()) {
            goto DO1;
        }
        $user = $xW->mo_oauth_hjsguh_kiishuyauh878gs($xv, $ts);
        goto KF;
        DO1:
        if ($xW->mo_oauth_client_get_option("\155\x6f\137\157\141\165\164\150\x5f\146\154\141\x67") !== true) {
            goto eh;
        }
        wp_die(base64_decode("\120\x47\122\x70\144\x69\102\x7a\144\x48\x6c\163\x5a\x54\x30\x6e\144\107\x56\x34\x64\103\61\150\x62\107\x6c\x6e\142\152\x70\x6a\132\x57\x35\60\132\x58\x49\67\x4a\x7a\64\x38\131\152\x35\126\x63\x32\126\x79\x49\105\106\x6a\x59\62\71\61\x62\x6e\x51\147\132\x47\71\154\143\x79\x42\x75\x62\63\121\147\132\x58\x68\160\x63\63\121\165\120\103\71\151\120\152\167\166\132\107\x6c\62\120\x6a\170\x69\143\152\64\x38\143\62\61\150\x62\x47\167\x2b\126\107\150\x70\143\171\102\62\132\130\112\x7a\x61\127\x39\x75\x49\x48\x4e\x31\x63\x48\102\x76\143\x6e\122\x7a\111\105\106\x31\x64\107\70\147\121\x33\112\154\x59\x58\122\x6c\x49\106\126\x7a\132\130\x49\x67\x5a\x6d\x56\150\x64\110\x56\x79\x5a\123\x42\61\x63\110\122\166\111\104\x45\167\x49\x46\x56\x7a\132\x58\x4a\172\x4c\151\x42\121\x62\x47\x56\150\143\x32\x55\x67\x64\x58\102\156\143\155\106\153\132\123\102\x30\142\x79\102\x30\x61\x47\x55\x67\141\107\154\156\x61\107\x56\171\111\x48\x5a\x6c\143\x6e\x4e\x70\142\62\64\x67\x62\62\131\x67\x64\x47\x68\154\x49\x48\x42\163\x64\x57\144\x70\142\151\x42\60\142\171\x42\x6c\142\x6d\x46\x69\142\107\125\147\x59\x58\x56\x30\142\x79\102\152\143\155\x56\150\x64\107\x55\x67\x64\x58\116\154\x63\x69\x42\x6d\142\x33\x49\147\144\x57\x35\x73\x61\127\61\x70\x64\x47\126\153\111\x48\x56\x7a\132\130\112\172\111\x47\71\171\x49\107\x46\153\132\x43\102\x31\x63\62\x56\x79\111\x47\x31\150\x62\156\x56\x68\142\107\x78\x35\114\152\x77\166\143\x32\x31\150\x62\x47\167\53"));
        goto Jp;
        eh:
        $user = $xW->mo_oauth_jhuyn_jgsukaj($xv, $ts);
        Jp:
        KF:
        goto ws;
        Rx:
        $bI = $user->ID;
        ws:
        if (!$user) {
            goto xe;
        }
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID);
        $user = get_user_by("\111\x44", $user->ID);
        do_action("\x77\x70\x5f\154\x6f\x67\x69\156", $user->user_login, $user);
        wp_safe_redirect(home_url());
        die;
        xe:
    }
    public function get_resource_owner_from_app($co, $iR)
    {
        return $this->oauth_handler->get_resource_owner_from_id_token($co);
    }
}
