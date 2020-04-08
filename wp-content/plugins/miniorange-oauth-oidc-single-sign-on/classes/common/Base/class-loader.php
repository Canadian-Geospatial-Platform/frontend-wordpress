<?php


namespace MoOauthClient\Base;

use MoOauthClient\Licensing;
use MoOauthClient\Base\InstanceHelper;
class Loader
{
    private $instance_helper;
    public function __construct()
    {
        add_action("\x61\x64\155\x69\156\x5f\x65\156\161\165\145\165\x65\x5f\163\143\162\151\160\164\x73", array($this, "\160\x6c\165\x67\151\156\137\163\145\x74\x74\x69\156\147\163\137\x73\164\x79\154\x65"));
        add_action("\141\x64\x6d\151\x6e\137\x65\x6e\x71\165\x65\165\145\137\163\143\x72\x69\160\x74\x73", array($this, "\160\154\x75\147\151\156\137\163\x65\x74\x74\151\156\147\163\x5f\x73\x63\x72\151\x70\x74"));
        $this->instance_helper = new InstanceHelper();
    }
    public function plugin_settings_style()
    {
        wp_enqueue_style("\155\x6f\137\x6f\141\x75\x74\x68\137\141\x64\155\x69\x6e\137\x73\x65\x74\164\x69\x6e\147\163\x5f\163\164\171\x6c\x65", MOC_URL . "\162\145\x73\157\165\x72\x63\x65\163\57\143\x73\x73\57\x73\x74\171\154\x65\x5f\x73\x65\x74\164\x69\x6e\x67\x73\x2e\x63\163\163", array(), $Uy = null, $kK = false);
        wp_enqueue_style("\155\x6f\x5f\x6f\141\165\164\150\x5f\141\x64\x6d\151\x6e\x5f\163\x65\x74\x74\x69\156\x67\163\137\x70\x68\157\156\x65\x5f\x73\x74\x79\x6c\x65", MOC_URL . "\162\x65\163\157\165\x72\x63\145\163\x2f\143\163\x73\x2f\x70\x68\157\156\145\x2e\x63\163\x73", array(), $Uy = null, $kK = false);
        wp_enqueue_style("\155\157\137\x6f\141\165\x74\x68\x5f\x61\144\x6d\151\x6e\137\163\145\x74\164\x69\156\x67\163\137\144\141\164\x61\164\141\x62\154\x65", MOC_URL . "\x72\145\x73\157\165\x72\143\x65\x73\x2f\143\163\x73\57\152\x71\x75\x65\162\x79\x2e\x64\141\x74\x61\x54\141\142\154\145\x73\x2e\155\x69\x6e\56\x63\x73\x73", array(), $Uy = null, $kK = false);
        wp_enqueue_style("\155\x6f\55\167\x70\55\x62\157\157\x74\x73\164\x72\141\x70\55\x73\x6f\143\151\141\154", MOC_URL . "\162\x65\163\157\165\x72\143\x65\x73\57\143\x73\163\57\x62\x6f\x6f\164\163\164\162\141\160\x2d\x73\x6f\143\151\x61\x6c\56\143\163\x73", array(), $Uy = null, $kK = false);
        wp_enqueue_style("\x6d\x6f\x2d\167\160\55\142\157\x6f\x74\163\164\162\141\160\x2d\155\141\x69\156", MOC_URL . "\162\x65\163\x6f\x75\x72\143\x65\163\x2f\x63\163\x73\57\142\x6f\157\164\163\164\162\141\160\x2e\x6d\151\156\x2d\160\162\145\x76\151\145\x77\56\x63\163\163", array(), $Uy = null, $kK = false);
        wp_enqueue_style("\155\x6f\55\x77\x70\55\146\157\156\x74\x2d\141\x77\x65\x73\x6f\155\145", MOC_URL . "\162\145\x73\157\x75\x72\x63\145\x73\x2f\143\x73\x73\x2f\x66\x6f\156\x74\55\x61\167\x65\163\157\x6d\145\x2e\x6d\151\x6e\56\x63\163\163\77\166\145\162\163\x69\157\156\75\64\x2e\x38", array(), $Uy = null, $kK = false);
        wp_enqueue_style("\155\x6f\55\167\160\x2d\x66\157\156\164\x2d\x61\167\145\163\x6f\x6d\x65", MOC_URL . "\162\145\x73\x6f\x75\162\x63\x65\x73\57\143\x73\x73\57\x66\157\x6e\164\55\x61\x77\x65\163\x6f\x6d\145\x2e\x63\x73\163\77\x76\x65\162\x73\151\x6f\x6e\75\64\x2e\x38", array(), $Uy = null, $kK = false);
        if (!(isset($_REQUEST["\x74\x61\142"]) && "\154\x69\x63\145\156\163\x69\156\x67" === $_REQUEST["\164\141\x62"])) {
            goto qO;
        }
        wp_enqueue_style("\x6d\157\x5f\157\141\x75\164\150\x5f\142\x6f\157\164\x73\x74\162\141\160\x5f\x63\x73\x73", MOC_URL . "\162\145\163\x6f\x75\x72\x63\x65\x73\x2f\143\163\x73\x2f\142\x6f\x6f\x74\163\164\162\141\160\57\142\x6f\x6f\164\x73\164\x72\x61\x70\56\x6d\x69\x6e\x2e\143\x73\163", array(), $Uy = null, $kK = false);
        qO:
    }
    public function plugin_settings_script()
    {
        wp_enqueue_script("\x6d\x6f\137\157\x61\165\x74\150\137\141\144\x6d\x69\x6e\137\x73\145\x74\x74\151\x6e\x67\x73\137\163\x63\162\x69\160\x74", MOC_URL . "\x72\x65\163\157\165\x72\143\145\x73\57\x6a\x73\57\163\x65\164\x74\151\x6e\147\x73\56\152\163", array(), $Uy = null, $kK = false);
        wp_enqueue_script("\x6d\157\137\x6f\x61\x75\164\150\x5f\141\144\155\x69\156\x5f\x73\145\164\164\x69\x6e\x67\x73\x5f\x70\150\x6f\x6e\x65\x5f\x73\x63\x72\151\x70\164", MOC_URL . "\x72\145\163\x6f\165\162\143\145\163\x2f\x6a\x73\57\x70\150\157\156\x65\56\152\163", array(), $Uy = null, $kK = false);
        wp_enqueue_script("\155\x6f\137\157\x61\x75\164\150\x5f\141\x64\155\x69\156\137\x73\x65\x74\164\x69\156\x67\163\137\x64\x61\164\141\x74\141\142\154\145", MOC_URL . "\162\145\x73\x6f\x75\x72\143\x65\x73\57\152\163\x2f\152\x71\165\x65\162\171\x2e\144\141\x74\x61\x54\141\x62\154\145\163\56\155\151\x6e\x2e\x6a\163", array(), $Uy = null, $kK = false);
        if (!(isset($_REQUEST["\164\x61\x62"]) && "\154\151\143\145\156\163\151\x6e\147" === $_REQUEST["\x74\141\142"])) {
            goto US;
        }
        wp_enqueue_script("\155\x6f\x5f\157\x61\165\x74\150\x5f\x6d\x6f\144\x65\162\x6e\151\172\x72\137\163\143\162\x69\x70\164", MOC_URL . "\x72\145\x73\157\165\162\x63\x65\163\57\152\x73\x2f\x6d\x6f\144\x65\162\x6e\x69\172\162\56\x6a\163", array(), $Uy = null, $kK = true);
        wp_enqueue_script("\x6d\157\137\157\x61\x75\x74\x68\137\160\x6f\160\x6f\166\x65\x72\137\x73\x63\x72\151\x70\164", MOC_URL . "\162\145\x73\157\165\x72\143\x65\163\57\x6a\163\57\142\157\157\164\163\x74\162\141\x70\57\160\x6f\160\160\145\162\56\x6d\151\x6e\x2e\152\163", array(), $Uy = null, $kK = true);
        wp_enqueue_script("\155\x6f\137\x6f\141\165\164\150\x5f\142\x6f\157\164\163\x74\162\x61\160\x5f\x73\143\x72\151\160\x74", MOC_URL . "\162\x65\x73\157\165\x72\143\x65\x73\57\x6a\163\57\x62\157\x6f\x74\x73\164\x72\141\160\57\142\157\157\x74\163\164\x72\141\x70\56\155\x69\156\56\152\163", array(), $Uy = null, $kK = true);
        US:
    }
    public function load_current_tab($Dn)
    {
        global $xW;
        $ps = 0 === $xW->get_versi();
        $oy = false;
        if ($ps) {
            goto vY;
        }
        $oy = $xW->mo_oauth_client_get_option("\x6d\x6f\137\x6f\141\x75\x74\x68\x5f\x63\x6c\151\145\156\x74\137\x6c\157\141\144\137\141\156\141\154\x79\x74\151\143\x73");
        $oy = boolval($oy) ? boolval($oy) : false;
        $ps = $xW->check_versi(1) && $xW->mo_oauth_is_clv();
        vY:
        if ("\x61\x63\143\157\165\x6e\164" === $Dn || !$ps) {
            goto Qs;
        }
        if ("\143\x75\163\164\157\155\x69\172\x61\164\x69\157\156" === $Dn && $ps) {
            goto pd;
        }
        if ("\x73\151\147\x6e\x69\156\163\145\164\x74\x69\156\147\163" === $Dn && $ps) {
            goto gb;
        }
        if ($oy && "\141\156\141\154\x79\164\x69\143\163" === $Dn && $ps) {
            goto p_;
        }
        if ("\154\151\143\x65\x6e\x73\151\156\x67" === $Dn) {
            goto V2;
        }
        if ("\x72\145\161\x75\x65\x73\164\x66\157\162\144\x65\x6d\157" === $Dn && $ps) {
            goto pz;
        }
        if (empty($Dn) && $ps) {
            goto TP;
        }
        $this->instance_helper->get_clientappui_instance()->render_free_ui();
        goto Hq;
        Qs:
        $mz = $this->instance_helper->get_accounts_instance();
        if ($xW->mo_oauth_client_get_option("\166\x65\x72\x69\x66\x79\137\x63\165\163\x74\x6f\x6d\145\x72") === "\164\162\x75\x65") {
            goto FQ;
        }
        if (trim($xW->mo_oauth_client_get_option("\x6d\x6f\x5f\x6f\141\x75\164\150\x5f\x61\x64\x6d\151\156\x5f\145\x6d\141\151\154")) !== '' && trim($xW->mo_oauth_client_get_option("\x6d\157\137\x6f\141\165\x74\150\x5f\x61\x64\155\151\156\137\x61\x70\x69\x5f\153\x65\x79")) === '' && $xW->mo_oauth_client_get_option("\156\145\167\137\x72\145\x67\151\x73\164\x72\x61\x74\151\157\156") !== "\x74\x72\x75\145") {
            goto rM;
        }
        if (!$xW->mo_oauth_is_clv() && $xW->check_versi(1) && $xW->mo_oauth_is_customer_registered()) {
            goto mI;
        }
        $mz->register();
        goto w2;
        FQ:
        $mz->verify_password_ui();
        goto w2;
        rM:
        $mz->verify_password_ui();
        goto w2;
        mI:
        $mz->mo_oauth_lp();
        w2:
        goto Hq;
        pd:
        $this->instance_helper->get_customization_instance()->render_free_ui();
        goto Hq;
        gb:
        $this->instance_helper->get_sign_in_settings_instance()->render_free_ui();
        goto Hq;
        p_:
        $this->instance_helper->get_user_analytics()->render_ui();
        goto Hq;
        V2:
        (new Licensing())->show_licensing_page();
        goto Hq;
        pz:
        $this->instance_helper->get_requestdemo_instance()->render_free_ui();
        goto Hq;
        TP:
        ?>
					<a id="goregister" style="display:none;" href="<?php 
        echo add_query_arg(array("\164\x61\x62" => "\x63\x6f\156\146\x69\x67"), htmlentities($_SERVER["\x52\105\121\125\105\123\x54\x5f\x55\x52\x49"]));
        ?>
">

					<script>
						location.href = jQuery('#goregister').attr('href');
					</script>
				<?php 
        Hq:
    }
}
