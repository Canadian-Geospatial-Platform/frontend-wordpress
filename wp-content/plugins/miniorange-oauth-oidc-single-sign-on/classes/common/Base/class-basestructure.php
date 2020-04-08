<?php


namespace MoOauthClient\Base;

use MoOauthClient\Support;
require_once "\143\154\x61\x73\x73\55\154\x6f\141\144\x65\x72\x2e\x70\150\x70";
class BaseStructure
{
    private $loader;
    public function __construct()
    {
        add_action("\x61\144\x6d\x69\x6e\137\x6d\x65\156\165", array($this, "\x61\x64\155\x69\x6e\137\x6d\x65\156\x75"));
        $this->loader = new Loader();
    }
    public function admin_menu()
    {
        $y1 = add_menu_page("\x4d\x4f\40\117\x41\165\164\150\40\123\x65\x74\x74\151\156\147\163\40" . __("\x43\157\x6e\146\151\x67\x75\x72\145\40\117\x41\x75\x74\x68", "\x6d\x6f\x5f\x6f\141\x75\164\x68\137\x73\145\x74\x74\x69\x6e\147\x73"), "\155\x69\x6e\151\117\162\x61\156\147\x65\40\117\101\x75\164\x68", "\141\144\x6d\151\156\151\163\164\162\x61\x74\157\162", "\x6d\x6f\137\x6f\x61\x75\x74\150\x5f\x73\145\164\164\x69\156\x67\x73", array($this, "\x6d\145\x6e\x75\x5f\157\x70\x74\151\x6f\156\x73"), MOC_URL . "\162\145\x73\x6f\165\x72\x63\x65\163\57\x69\155\x61\x67\x65\163\x2f\x6d\151\156\151\157\x72\x61\x6e\x67\x65\x2e\160\x6e\x67");
        global $UO;
        if (!(is_array($UO) && isset($UO["\x6d\157\x5f\x6f\x61\x75\164\x68\x5f\x73\145\x74\164\151\156\147\163"]))) {
            goto tH;
        }
        $UO["\155\x6f\137\157\141\165\164\150\137\x73\145\164\164\x69\x6e\x67\163"][0][0] = __("\103\x6f\156\146\151\x67\x75\x72\x65\40\x4f\x41\x75\164\150", "\x6d\157\137\x6f\x61\x75\x74\x68\x5f\154\x6f\147\x69\x6e");
        tH:
    }
    public function menu_options()
    {
        $Dn = isset($_GET["\164\141\142"]) ? $_GET["\164\x61\142"] : '';
        ?>
		<div id="mo_oauth_settings">
			<div id='moblock' class='moc-overlay dashboard'></div>
			<div class="miniorange_container">
				<?php 
        $this->content_navbar($Dn);
        ?>
				<table style="width:100%;">
					<tr>
						<td style="vertical-align:top;width:65%;" class="mo_oauth_content">
							<?php 
        $this->loader->load_current_tab($Dn);
        ?>
						</td>
						<?php 
        if (!("\x6c\151\143\x65\x6e\x73\151\x6e\x67" !== $Dn)) {
            goto WU;
        }
        ?>
							<td style="vertical-align:top;padding-left:1%;" class="mo_oauth_sidebar">
							<?php 
        $P0 = new Support();
        $P0->support();
        ?>
							</td>
						<?php 
        WU:
        ?>
					</tr>
				</table>
			</div>

		</div>
		<?php 
    }
    public function content_navbar($Dn)
    {
        global $xW;
        ?>
		<div class="wrap">
			<div class="header-warp">
				<h1>miniOrange OAuth/OpenID Client
				&emsp;<a id="licensing_button_id" class="link_button top_license" href="admin.php?page=mo_oauth_settings&tab=licensing">Premium Plans</a>
				&nbsp;<a id="faq_button_id" class="link_button" href="https://faq.miniorange.com/kb/oauth-openid-connect/" target="_blank">FAQs</a>
				&nbsp;<a id="faq_button_id" class="link_button" href="https://forum.miniorange.com/" target="_blank">Ask questions on our forum</a>
				</h1>
				<?php 
        if (!("\x6c\x69\x63\145\156\x73\x69\156\x67" === $Dn)) {
            goto OA;
        }
        ?>
				<div id="moc-lp-imp-btns" style="float:right;">
					<a class="btn btn-outline-danger" target="_blank" href="https://plugins.miniorange.com/wordpress-oauth-client">Full Feature List</a>&emsp;<a class="btn btn-outline-primary" onclick="getlicensekeys()" href="#">Get License Keys</a>
				</div>
				<?php 
        OA:
        ?>
				<div><img style="float:left;" src="<?php 
        echo MOC_URL . "\57\x72\x65\163\157\x75\x72\143\x65\163\57\151\x6d\x61\147\145\163\57\x6c\157\x67\x6f\x2e\x70\156\147";
        ?>
"></div>
				<?php 
        if (!($xW->get_versi() === 0)) {
            goto Tp;
        }
        ?>
					<div class="buts" style="float:right;">
						<div id="restart_tour_button" class="mo-otp-help-button static" style="margin-right:10px;z-index:10">
								<a class="button button-primary button-large">
									<span class="dashicons dashicons-controls-repeat" style="margin:5% 0 0 0;"></span>
										Restart Tour
								</a>
						</div>
					</div>
				<?php 
        Tp:
        ?>
		</div>
		<div id="tab">
		<h2 class="nav-tab-wrapper">
			<a id="tab-config" class="nav-tab <?php 
        echo "\x63\x6f\156\x66\x69\147" === $Dn ? "\x6e\x61\166\x2d\164\x61\142\55\x61\x63\164\151\x76\145" : '';
        ?>
" href="admin.php?page=mo_oauth_settings&tab=config">Configure OAuth</a>
			<a id="tab-customization" class="nav-tab <?php 
        echo "\143\165\x73\164\x6f\x6d\151\172\141\164\x69\157\156" === $Dn ? "\156\141\x76\55\x74\x61\x62\55\x61\143\x74\x69\166\x65" : '';
        ?>
" href="admin.php?page=mo_oauth_settings&tab=customization">Customizations</a>
			<?php 
        if (!($xW->mo_oauth_client_get_option("\x6d\157\137\x6f\x61\165\x74\150\137\x65\x76\x65\157\156\154\x69\156\x65\x5f\x65\x6e\141\x62\154\145") === 1)) {
            goto YM;
        }
        ?>
				<a id="tab-eve" class="nav-tab <?php 
        echo "\155\157\x5f\157\141\165\164\150\x5f\x65\166\145\137\x6f\156\x6c\x69\156\145\137\x73\145\x74\165\x70" === $Dn ? "\156\141\x76\55\164\141\142\x2d\141\143\x74\x69\166\145" : '';
        ?>
" href="admin.php?page=mo_oauth_eve_online_setup">Advanced EVE Online Settings</a>
			<?php 
        YM:
        ?>
			<a id="tab-signinsettings" class="nav-tab <?php 
        echo "\163\x69\147\x6e\151\x6e\163\x65\164\164\151\x6e\147\163" === $Dn ? "\x6e\141\166\55\164\x61\142\x2d\x61\143\x74\x69\166\145" : '';
        ?>
" href="admin.php?page=mo_oauth_settings&tab=signinsettings">Sign In Settings</a>
			<?php 
        do_action("\x6d\157\137\157\x61\x75\164\150\137\x63\154\x69\145\156\164\x5f\x61\x64\144\137\x6e\x61\x76\x5f\164\141\142\x73\x5f\165\x69\137\x69\156\x74\x65\x72\x6e\x61\154", $Dn);
        ?>
			<?php 
        if (!($xW->get_versi() === 0)) {
            goto Rd;
        }
        ?>
				<a id="tab-requestdemo" class="nav-tab <?php 
        echo "\162\x65\161\x75\145\163\164\x66\157\x72\144\145\x6d\x6f" === $Dn ? "\156\141\166\x2d\x74\141\x62\55\x61\143\164\151\166\145" : '';
        ?>
" href="admin.php?page=mo_oauth_settings&tab=requestfordemo">Request For Demo</a>
			<?php 
        Rd:
        ?>
			<a id="acc_setup_button_id" class="nav-tab <?php 
        echo "\141\143\x63\x6f\165\x6e\164" === $Dn ? "\156\x61\166\x2d\164\141\142\55\x61\143\x74\151\x76\x65" : '';
        ?>
" href="admin.php?page=mo_oauth_settings&tab=account">Account Setup</a>
		</h2>
		</div>
		<?php 
    }
}
