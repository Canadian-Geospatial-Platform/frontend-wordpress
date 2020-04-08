<?php


namespace MoOauthClient;

use MoOauthClient\App;
use MoOauthClient\App\UpdateAppUI;
class AppUI
{
    private $app_config;
    private $apps_list;
    public function __construct()
    {
        $this->app_config = array("\x63\x6c\x69\145\x6e\x74\x5f\151\144", "\143\x6c\151\145\156\x74\x5f\x73\x65\x63\162\145\164", "\x73\143\157\160\x65", "\162\x65\x64\x69\162\x65\x63\164\137\x75\162\151", "\141\160\x70\x5f\x74\171\x70\145", "\141\165\164\x68\x6f\x72\151\x7a\x65\165\162\154", "\x61\x63\143\x65\163\x73\x74\157\x6b\x65\156\165\162\x6c", "\162\145\163\x6f\165\162\x63\x65\157\167\x6e\x65\x72\144\x65\164\141\x69\154\x73\x75\162\154", "\147\x72\157\165\x70\144\x65\x74\x61\151\x6c\163\x75\x72\x6c", "\x6a\167\153\x73\137\165\162\151", "\x64\x69\163\160\154\141\171\141\x70\160\x6e\141\155\x65", "\x61\160\160\x49\x64");
        self::populate_appslist();
    }
    public function get_apps_list()
    {
        return $this->apps_list;
    }
    public function set_apps_list($rj)
    {
        global $xW;
        $this->apps_list = $rj;
        $xW->mo_oauth_client_update_option("\x6d\x6f\137\x6f\x61\165\164\150\x5f\141\x70\160\163\x5f\x6c\151\x73\x74", $rj);
    }
    public function delete_app($Sm)
    {
        global $xW;
        $rj = $this->apps_list;
        $EN = admin_url("\141\144\x6d\151\156\56\160\x68\160\77\160\x61\147\x65\75\x6d\x6f\x5f\x6f\x61\165\x74\x68\x5f\163\x65\164\x74\x69\156\147\x73");
        if (!($rj && count($rj) > 0)) {
            goto hz;
        }
        foreach ($rj as $qV => $eL) {
            if (!($Sm === $qV)) {
                goto yS;
            }
            unset($rj[$qV]);
            if (!("\145\166\x65\157\156\154\151\x6e\x65" === $Sm)) {
                goto bQ;
            }
            $xW->mo_oauth_client_update_option("\155\x6f\137\157\141\165\164\150\x5f\145\166\145\157\156\154\x69\x6e\x65\x5f\x65\156\141\142\154\x65", 0);
            bQ:
            yS:
            ZZ:
        }
        v9:
        $this->set_apps_list($rj);
        hz:
        echo "\74\x73\x74\x72\157\156\147\76\120\154\145\x61\x73\x65\x20\x57\x61\151\x74\x2e\56\x2e\74\57\x73\164\x72\157\156\147\76";
        ?>
		<script>
			window.onload = function() {
				window.location.href = "<?php 
        echo $EN;
        ?>
";
			}
		</script>
		<?php 
        die;
    }
    public function get_app_by_name($Sm)
    {
        global $xW;
        $rj = $xW->mo_oauth_client_get_option("\155\x6f\137\x6f\x61\165\x74\x68\x5f\141\160\x70\x73\137\x6c\151\163\164") ? $xW->mo_oauth_client_get_option("\155\157\137\157\x61\165\164\150\137\x61\160\x70\163\137\154\151\x73\164") : false;
        if ($rj) {
            goto Hf;
        }
        return false;
        Hf:
        foreach ($rj as $qV => $eL) {
            if (!($Sm === $qV)) {
                goto SJ;
            }
            return $eL;
            SJ:
            s3:
        }
        hy:
        return false;
    }
    private function populate_appslist()
    {
        global $xW;
        $rj = $xW->mo_oauth_client_get_option("\155\x6f\x5f\x6f\x61\165\x74\150\x5f\141\x70\160\163\x5f\x6c\151\163\164") ? $xW->mo_oauth_client_get_option("\155\157\137\157\x61\165\164\x68\x5f\x61\x70\160\163\x5f\154\151\x73\x74") : array();
        if (!(is_array($rj) && 0 < count($rj))) {
            goto ik;
        }
        foreach ($rj as $qV => $sw) {
            if (is_array($sw) && !empty($sw)) {
                goto wL;
            }
            $this->apps_list[$qV] = $sw;
            goto FL;
            wL:
            $sw["\x63\x6c\x69\x65\x6e\164\x5f\x69\x64"] = isset($sw["\x63\154\x69\145\156\164\151\144"]) ? $sw["\143\154\x69\x65\156\164\x69\144"] : '';
            $sw["\x63\x6c\x69\145\x6e\164\x5f\163\x65\143\x72\x65\164"] = isset($sw["\x63\x6c\x69\145\x6e\164\163\145\x63\x72\x65\164"]) ? $sw["\x63\154\x69\x65\x6e\x74\x73\145\x63\x72\x65\164"] : '';
            unset($sw["\x63\154\x69\145\x6e\164\151\144"]);
            unset($sw["\x63\154\151\x65\156\x74\x73\145\x63\162\145\164"]);
            $eL = new App();
            $eL->migrate_app($sw, $qV);
            $this->apps_list[$qV] = $eL;
            FL:
            aP:
        }
        aE:
        ik:
        $xW->mo_oauth_client_update_option("\155\157\137\157\x61\165\164\150\x5f\x61\x70\x70\163\137\x6c\x69\163\x74", $this->apps_list);
    }
    private function show_default_apps()
    {
        wp_enqueue_script("\x6d\x6f\x5f\x6f\141\165\164\x68\x5f\141\144\155\151\x6e\x5f\x61\x70\160\137\x73\145\x61\x72\143\x68\x5f\163\x63\162\151\x70\x74", MOC_URL . "\162\145\163\x6f\x75\162\143\x65\163\x2f\141\160\160\137\x63\157\x6d\x70\x6f\x6e\145\156\164\163\x2f\x73\145\x61\x72\x63\x68\137\141\x70\160\163\56\152\163", array(), $Uy = null, $kK = true);
        ?>
	<input type="text" id="mo_oauth_client_default_apps_input" onkeyup="mo_oauth_client_default_apps_input_filter()" placeholder="Select application" title="Type in a Application Name">
	<h3>OAuth Providers</h3>
	<hr />
	<ul id="mo_oauth_client_default_apps">
		<?php 
        $Lj = wp_remote_get(MOC_URL . "\162\145\163\157\x75\162\143\x65\x73\x2f\141\160\x70\x5f\x63\157\x6d\x70\x6f\x6e\145\x6e\164\x73\57\144\145\146\x61\165\x6c\164\x61\x70\x70\163\56\152\163\157\x6e", array("\x73\163\154\x76\145\162\x69\146\171" => false))["\x62\x6f\144\171"];
        $YW = json_decode($Lj);
        foreach ($YW as $nX => $Kw) {
            echo "\74\154\x69\40\x64\141\x74\x61\55\x61\160\160\x69\144\x3d\42" . $nX . "\42\76\x3c\141\40\x68\162\145\x66\75\x22\x23\x22\x3e\x3c\151\155\x67\40\143\154\141\163\x73\x3d\x22\155\157\137\157\141\165\164\150\137\x63\154\151\x65\x6e\164\137\144\x65\146\x61\165\154\164\x5f\141\x70\x70\x5f\151\x63\x6f\x6e\x22\x20\163\162\x63\x3d\x22" . MOC_URL . "\162\x65\x73\x6f\x75\x72\143\145\x73\57\141\160\x70\x5f\143\x6f\x6d\x70\x6f\x6e\x65\x6e\x74\x73\x2f\x69\155\141\147\145\x73\57" . $Kw->image . "\42\x3e\x3c\x62\162\76" . $Kw->label . "\74\x2f\x61\x3e\74\57\x6c\151\x3e";
            Uy:
        }
        Z3:
        ?>
	</ul>
	<div id="mo_oauth_client_search_res"></div>
	<script>
		jQuery("#mo_oauth_client_default_apps li").click(function(){
			var appId = jQuery(this).data("appid");
				window.location.href += "&appId="+appId;
		});
	</script>
		<?php 
    }
    public function add_app_ui()
    {
        ?>
		<div id="mo_oauth_client_default_apps_container" class="mo_table_layout">
			<div id="toggle2" class="mo_panel_toggle">
				<table class="mo_settings_table">
					<tr>
						<td><h3>Add Application</h3></td>
						<?php 
        if (isset($_GET["\141\160\160\111\x64"])) {
            goto J1;
        }
        ?>
							<td align="right"><span style="position: relative; float: right;padding-left: 13px;padding-right:13px;background-color:white;border-radius:4px;">
								<!-- <button type="button" id="restart_tour_id" class="button button-primary button-large" onclick="jQuery('#show_pointers').submit();"><em class="fa fa-refresh"></em>Restart Tour</button> -->
							</span></td>
							<?php 
        goto EW;
        J1:
        $pi = $_GET["\x61\x70\x70\111\144"];
        if (isset($_GET["\141\x63\x74\151\x6f\156"]) && "\151\x6e\x73\x74\x72\165\x63\164\x69\x6f\156\163" === $_GET["\141\143\x74\151\x6f\x6e"] || isset($_GET["\x73\x68\x6f\x77"]) && "\151\156\163\x74\x72\x75\143\x74\151\157\156\163" === $_GET["\x73\150\157\x77"]) {
            goto jV;
        }
        echo "\12\x9\11\11\x9\x9\11\x9\x9\74\164\144\x20\141\x6c\x69\x67\x6e\x3d\42\x72\x69\147\x68\164\42\76\x3c\141\x20\150\162\x65\146\75\42\x61\144\155\x69\156\x2e\160\x68\160\x3f\160\141\147\x65\x3d\x6d\157\137\157\141\165\164\x68\137\x73\145\164\164\x69\156\147\163\x26\x61\143\x74\x69\x6f\x6e\75\x61\144\144\46\x73\x68\x6f\167\x3d\x69\156\x73\x74\x72\165\143\x74\x69\x6f\x6e\163\x26\141\160\x70\x49\x64\x3d" . $pi . "\x22\76\x3c\144\151\166\40\151\x64\x3d\x22\x6d\x6f\x5f\x6f\x61\x75\x74\x68\137\143\x6f\x6e\146\x69\x67\x5f\x67\165\151\144\145\42\x20\x73\x74\x79\154\x65\x3d\x22\144\151\x73\x70\154\x61\x79\x3a\151\156\x6c\151\x6e\x65\x3b\x62\x61\143\153\x67\162\157\x75\x6e\144\55\143\157\154\157\x72\x3a\43\60\x30\x38\65\142\x61\73\x63\x6f\x6c\157\162\72\x23\x66\146\146\x3b\160\141\144\144\151\156\147\72\x34\160\x78\x20\x38\x70\170\x3b\x62\x6f\x72\x64\x65\162\55\162\141\x64\x69\x75\x73\x3a\64\160\170\x3b\42\76\110\157\x77\x20\164\x6f\x20\103\157\156\146\151\147\165\x72\x65\x3f\74\57\144\151\166\76\x3c\57\141\x3e\x3c\57\164\144\x3e";
        goto ah;
        jV:
        echo "\12\11\x9\11\x9\x9\x9\11\x9\74\164\x64\40\x61\x6c\x69\x67\156\75\42\x72\151\147\x68\164\42\x3e\x3c\141\x20\x68\x72\145\146\75\42\141\x64\x6d\151\x6e\56\x70\150\160\77\160\141\147\145\75\x6d\x6f\137\157\141\x75\x74\x68\x5f\x73\145\x74\164\151\x6e\147\163\x26\x61\x63\x74\x69\x6f\x6e\x3d\141\x64\x64\46\x61\x70\x70\111\x64\x3d" . $pi . "\x22\x3e\x3c\144\x69\x76\x20\151\144\75\x22\155\157\x5f\157\141\165\164\x68\137\143\x6f\x6e\x66\151\x67\x5f\x67\165\151\x64\x65\42\x20\163\164\x79\154\145\75\x22\x64\x69\x73\x70\154\141\171\x3a\151\x6e\154\x69\156\x65\73\x62\x61\143\153\x67\162\157\165\x6e\144\x2d\143\x6f\x6c\x6f\162\72\x23\x30\x30\70\65\x62\x61\x3b\143\157\x6c\157\x72\x3a\x23\146\146\x66\73\x70\x61\144\144\151\156\x67\72\x34\160\x78\x20\x38\x70\x78\73\x62\157\x72\144\x65\x72\x2d\x72\x61\144\151\165\x73\72\64\160\170\x3b\42\76\x48\151\x64\x65\40\151\x6e\163\164\x72\x75\x63\x74\x69\157\156\x73\x20\136\74\x2f\144\x69\166\76\x3c\57\x61\x3e\x3c\x2f\164\x64\x3e\40";
        ah:
        EW:
        ?>
					</tr>
				</table>
				<form name="f" method="post" id="show_pointers">
					<input type="hidden" name="option" value="clear_pointers"/>
					<?php 
        wp_nonce_field("\143\x6c\x65\141\x72\137\x70\157\151\x6e\x74\145\x72\163", "\143\154\x65\141\x72\x5f\x70\157\x69\x6e\164\x65\x72\x73\137\x6e\157\x6e\143\x65");
        ?>
				</form>
			</div>
				<?php 
        if (!isset($_GET["\x61\x70\x70\x49\x64"])) {
            goto nq;
        }
        self::show_add_app_page();
        goto nv;
        nq:
        self::show_default_apps();
        nv:
        ?>
		</div>
		<?php 
    }
    public function show_add_app_page()
    {
        global $xW;
        $pi = isset($_GET["\x61\x70\160\111\144"]) ? $_GET["\x61\160\x70\x49\x64"] : false;
        $v_ = $xW->get_default_app($pi);
        if (!(false === $v_)) {
            goto PC;
        }
        $EN = admin_url() . "\x2f\141\144\155\x69\156\x2e\160\150\x70\77\x70\x61\x67\145\x3d\155\x6f\x5f\x6f\141\x75\164\150\x5f\x73\145\x74\164\151\x6e\x67\163\46\x74\x61\142\x3d\x63\x6f\x6e\x66\x69\x67";
        echo "\117\x6f\160\163\x21\x20\x53\157\155\145\164\x68\x69\x6e\147\x20\x77\145\156\164\40\167\x72\x6f\x6e\x67\56\x20\x50\154\145\141\x73\145\x20\x77\141\151\x74\56\x2e\x2e";
        ?>
			<script>
				window.location.replace("<?php 
        echo $EN;
        ?>
");
			</script>
			<?php 
        PC:
        ?>
	<div id="mo_oauth_add_app">
	<form id="form-common" name="form-common" method="post" action="admin.php?page=mo_oauth_settings">
	<input type="hidden" name="option" value="mo_oauth_add_app" />
		<?php 
        wp_nonce_field("\155\157\x5f\157\141\165\164\150\x5f\x61\144\x64\x5f\x61\160\x70", "\155\157\x5f\x6f\141\x75\x74\150\137\x61\144\x64\x5f\x61\160\160\x5f\156\157\156\143\x65");
        ?>
	<table class="mo_settings_table">
		<tr>
		<td><strong><span class="mo_premium_feature">*</span>Application:<br><br></strong></td>
		<td>
			<input type="hidden" name="mo_oauth_app_name" value="<?php 
        echo esc_html($pi);
        ?>
">
			<input type="hidden" name="mo_oauth_app_type" value="<?php 
        echo esc_html($v_->type);
        ?>
">
			<?php 
        echo $v_->label;
        ?>
 &nbsp;&nbsp;&nbsp;&nbsp; <a style="text-decoration:none" href ="admin.php?page=mo_oauth_settings&action=add"><div style="display:inline;background-color:#0085ba;color:#fff;padding:4px 8px;border-radius:4px">Change Application</div></a><br><br>
		</td>
		</tr>
		<tr><td><strong>Redirect / Callback URL</strong></td>
		<td><input class="mo_table_textbox" id="callbackurl"  type="text" readonly="true" value='<?php 
        echo esc_url(site_url());
        ?>
'></td>
		</tr>
		<tr id="mo_oauth_custom_app_name_div">
			<td><strong><span class="mo_premium_feature">*</span>App Name:</strong></td>
			<td><input class="mo_table_textbox" type="text" id="mo_oauth_custom_app_name" name="mo_oauth_custom_app_name" value="" pattern="[a-zA-Z0-9]+" required title="Please do not add any special characters."></td>
		</tr>
		<tr id="mo_oauth_display_app_name_div">
			<td><strong>Display App Name:<?php 
        echo !$xW->check_versi(1) ? "\x3c\142\162\x3e\x26\x65\155\163\160\x3b\x3c\163\x70\x61\156\40\x63\154\141\163\x73\x3d\x22\155\x6f\x5f\x70\x72\x65\155\151\165\x6d\137\x66\145\x61\x74\x75\x72\x65\x22\x3e\133\x53\x54\101\116\104\101\122\104\x5d\x3c\x2f\x73\x70\x61\x6e\76" : '';
        ?>
</strong></td>
			<td><input <?php 
        echo !$xW->check_versi(1) ? "\144\151\x73\x61\x62\154\145\x64" : '';
        ?>
 class="mo_table_textbox" type="text" id="mo_oauth_display_app_name" name="mo_oauth_display_app_name" value="" pattern="[a-zA-Z0-9\s]+" title="Please do not add any special characters."></td>
		</tr>
		<tr>
			<td><strong><span class="mo_premium_feature">*</span>Client ID:</strong></td>
			<td><input class="mo_table_textbox" required="" type="text" name="mo_oauth_client_id" value=""></td>
		</tr>
		<tr>
			<td><strong><span class="mo_premium_feature">*</span>Client Secret:</strong></td>
			<td><input class="mo_table_textbox" required="" type="text"  name="mo_oauth_client_secret" value=""></td>
		</tr>
		<tr>
			<td><strong>Scope:</strong></td>
			<td><input class="mo_table_textbox" type="text" name="mo_oauth_scope" value="<?php 
        echo isset($v_->scope) ? esc_html(trim($v_->scope)) : '';
        ?>
"></td>
		</tr>
		<tr id="mo_oauth_authorizeurl_div">
			<td><strong><span class="mo_premium_feature">*</span>Authorize Endpoint:</strong></td>
			<td><input class="mo_table_textbox" required type="url" id="mo_oauth_authorizeurl" name="mo_oauth_authorizeurl" value="<?php 
        echo isset($v_->authorize) ? esc_url(trim($v_->authorize)) : '';
        ?>
"></td>
		</tr>
		<tr id="mo_oauth_accesstokenurl_div">
			<td><strong><span class="mo_premium_feature">*</span>Access Token Endpoint:</strong></td>
			<td><input class="mo_table_textbox" required type="url" id="mo_oauth_accesstokenurl" name="mo_oauth_accesstokenurl" value="<?php 
        echo isset($v_->token) ? esc_url($v_->token) : '';
        ?>
 "></td>
		</tr>
		<tr>
			<td></td>
			<td><div style="padding:5px;"></div><input type="checkbox" name="mo_oauth_authorization_header" value ="1" checked />Set client credentials in Header<span style="padding:0px 0px 0px 8px;"></span><input type="checkbox" name="mo_oauth_body" value ="1"/>Set client credentials in Body<div style="padding:5px;"></div></td>
		</tr>
		<?php 
        if (!(!isset($v_->type) || "\157\141\x75\164\150" === $v_->type)) {
            goto Sx;
        }
        ?>
			<tr id="mo_oauth_resourceownerdetailsurl_div">
				<td><strong><span class="mo_premium_feature">*</span>Get User Info Endpoint:</strong></td>
				<td><input class="mo_table_textbox" <?php 
        echo !isset($v_->type) || "\x6f\141\x75\164\150" === $v_->type ? "\162\x65\161\165\x69\x72\x65\144\40" : '';
        ?>
 type="url" id="mo_oauth_resourceownerdetailsurl" name="mo_oauth_resourceownerdetailsurl" value="<?php 
        echo isset($v_->userinfo) ? esc_url($v_->userinfo) : '';
        ?>
"></td>
			</tr>
		<?php 
        Sx:
        ?>
		<tr>
			<td><strong>login button:</strong></td>
			<td><div style="padding:5px;"></div><input type="checkbox" name="mo_oauth_show_on_login_page" value ="1" checked/>Show on login page</td>
		</tr>
		<tr>
			<td><br></td>
			<td><br></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit" value="Save settings"
				class="button button-primary button-large" /></td>
		</tr>
		</table>
	</form>
	<div id="instructions">

	</div>
	</div>
		<?php 
    }
    public function show_apps_list_page()
    {
        global $xW;
        ?>
	<style>
		.tableborder {
			border-collapse: collapse;
			width: 100%;
			border-color:#eee;
		}

		.tableborder th, .tableborder td {
			text-align: left;
			padding: 8px;
			border-color:#eee;
		}

		.tableborder tr:nth-child(even){background-color: #f2f2f2}
	</style>
	<div id="mo_oauth_app_list" class="mo_table_layout">
		<?php 
        if ($xW->mo_oauth_client_get_option("\x6d\157\x5f\x6f\x61\165\164\x68\137\141\x70\x70\x73\x5f\154\x69\x73\x74")) {
            goto XF;
        }
        self::show_add_app_page();
        goto mj;
        XF:
        $rj = $xW->mo_oauth_client_get_option("\x6d\157\137\157\141\x75\164\x68\x5f\x61\x70\x70\163\x5f\154\151\163\x74");
        if (count($rj) > 0 && !$xW->check_versi(3)) {
            goto Cz;
        }
        echo "\x3c\x62\x72\76\x3c\x61\40\150\x72\x65\x66\x3d\x27\x61\x64\155\x69\156\x2e\x70\x68\x70\x3f\160\141\x67\x65\x3d\x6d\157\x5f\157\141\165\x74\150\x5f\x73\145\x74\x74\x69\x6e\147\163\46\141\143\x74\x69\x6f\156\x3d\141\144\144\x5f\x6e\x65\x77\47\76\74\x62\x75\x74\164\157\156\x20\143\154\141\x73\x73\x3d\x27\142\x75\164\164\157\156\40\142\165\x74\164\157\156\x2d\x70\x72\x69\155\x61\162\171\40\x62\165\164\x74\157\156\x2d\x6c\141\162\147\x65\47\x20\163\164\x79\154\145\x3d\x27\x66\154\157\141\x74\72\x72\x69\147\150\x74\47\76\101\x64\144\40\101\160\160\154\151\143\x61\x74\x69\x6f\x6e\74\57\x62\165\164\164\157\x6e\76\74\57\x61\76";
        goto v_;
        Cz:
        echo "\x3c\142\162\x3e\74\141\40\150\x72\145\x66\75\x27\x23\47\76\74\x62\x75\164\164\x6f\156\40\x64\151\163\141\x62\x6c\x65\x64\x20\x63\154\141\163\x73\x3d\x27\142\165\x74\164\x6f\156\x20\142\165\164\164\x6f\156\55\160\x72\151\x6d\x61\162\171\x20\x62\165\164\164\157\156\x2d\154\141\x72\x67\145\x27\x20\x73\x74\171\154\x65\x3d\47\146\154\x6f\141\x74\72\162\x69\147\150\x74\x27\x3e\101\x64\x64\x20\101\x70\160\154\151\143\x61\x74\151\x6f\156\x3c\57\x62\165\164\164\x6f\156\76\x3c\57\x61\76";
        v_:
        echo "\x3c\150\x33\x3e\101\x70\x70\154\151\143\141\x74\x69\157\156\x73\40\x4c\151\x73\x74\x3c\57\x68\x33\76";
        if (!(is_array($rj) && count($rj) > 0 && !$xW->check_versi(3))) {
            goto bE;
        }
        echo "\74\160\x20\x73\x74\171\154\x65\x3d\x27\143\157\x6c\x6f\x72\x3a\x23\x61\x39\64\64\64\62\x3b\142\x61\143\x6b\x67\162\x6f\165\x6e\x64\55\x63\157\x6c\157\x72\x3a\43\x66\x32\x64\x65\x64\145\73\142\x6f\162\x64\145\162\55\x63\x6f\x6c\x6f\x72\x3a\43\x65\142\x63\x63\144\61\x3b\142\x6f\162\x64\145\162\x2d\162\141\144\151\x75\163\x3a\x35\160\x78\x3b\x70\x61\x64\x64\151\156\x67\72\61\x32\x70\170\x27\76\131\x6f\165\40\143\141\x6e\x20\157\156\x6c\171\x20\x61\x64\x64\40\61\x20\x61\160\160\154\x69\x63\141\164\151\x6f\x6e\40\167\x69\164\150\x20" . esc_html(strtolower($xW->get_versi_str())) . "\x20\x76\x65\162\x73\151\157\156\x2e\40\x55\160\x67\162\141\x64\145\40\x74\x6f\40\x3c\141\x20\150\162\145\x66\75\47\x61\144\x6d\151\156\56\x70\x68\x70\77\160\141\x67\x65\75\x6d\157\137\x6f\x61\x75\x74\x68\x5f\x73\145\x74\164\x69\x6e\x67\163\46\164\141\142\x3d\154\x69\143\145\156\163\x69\156\147\47\76\x3c\163\x74\x72\x6f\x6e\147\76\x65\156\164\x65\x72\160\x72\151\163\x65\x3c\x2f\x73\164\x72\x6f\156\147\76\74\x2f\141\x3e\x20\164\157\x20\141\144\144\x20\x6d\x6f\x72\145\56\74\57\x70\x3e";
        bE:
        echo "\x3c\x74\x61\142\x6c\145\40\143\x6c\x61\x73\x73\75\x27\164\141\x62\x6c\x65\142\157\162\x64\145\162\47\x3e";
        echo "\x3c\164\x72\x3e\x3c\164\x68\x3e\74\163\x74\162\x6f\x6e\147\x3e\x4e\141\x6d\x65\x3c\x2f\163\x74\x72\157\156\147\76\x3c\57\164\150\76\x3c\164\x68\x3e\101\143\164\x69\157\x6e\74\57\164\x68\76\x3c\x2f\164\x72\76";
        $qO = '';
        foreach ($rj as $qV => $eL) {
            $qO .= "\74\x74\x72\x3e\74\x74\144\x3e" . $qV . "\x3c\57\164\x64\x3e\74\164\x64\x3e\74\141\x20\x68\x72\x65\x66\x3d\x27\141\x64\155\151\156\x2e\x70\150\160\x3f\x70\141\x67\x65\x3d\155\157\137\x6f\141\165\x74\x68\137\x73\x65\x74\164\151\x6e\x67\x73\46\164\x61\x62\75\x63\x6f\x6e\x66\151\147\46\x61\x63\164\x69\157\156\75\165\160\x64\141\164\x65\46\x61\160\x70\x3d" . rawurlencode($qV) . "\47\76\x45\144\x69\164\x20\101\x70\x70\154\x69\143\141\164\151\157\x6e\74\x2f\141\76\x20\174\x20\x3c\x61\x20\x68\x72\x65\x66\75\x27\141\144\155\151\x6e\x2e\x70\150\x70\x3f\x70\x61\x67\x65\75\x6d\157\137\x6f\x61\165\164\150\137\x73\x65\164\x74\x69\x6e\147\x73\46\x74\x61\142\x3d\x63\157\156\146\151\x67\46\141\143\x74\151\x6f\156\75\x75\x70\x64\141\x74\x65\x26\x61\x70\160\x3d" . rawurlencode($qV) . "\x23\x61\x74\164\x72\155\x61\x70\160\151\x6e\x67\x27\x3e\x41\164\164\x72\151\142\x75\x74\x65\x20\115\141\x70\x70\x69\156\147\x3c\x2f\141\76\40\174\x20\74\141\x20\x68\162\145\x66\x3d\47\141\x64\x6d\151\x6e\x2e\x70\150\160\x3f\x70\141\147\x65\75\155\x6f\x5f\157\x61\x75\x74\150\137\x73\x65\164\x74\151\156\x67\163\x26\164\141\x62\x3d\x63\x6f\x6e\x66\151\147\x26\141\143\x74\151\157\x6e\75\165\160\144\x61\x74\145\x26\x61\x70\160\x3d" . rawurlencode($qV) . "\43\162\157\154\x65\155\141\160\x70\151\156\147\x27\76\x52\157\154\145\40\x4d\x61\160\x70\151\156\x67\74\57\x61\76\40\174\40\74\141\40\x6f\156\143\x6c\x69\x63\x6b\x3d\47\x72\x65\164\x75\x72\x6e\40\x63\x6f\156\146\151\x72\155\50\42\101\x72\x65\40\x79\x6f\165\40\163\x75\162\x65\40\171\x6f\x75\x20\x77\141\156\164\x20\164\157\x20\144\145\154\145\x74\x65\40\164\x68\151\x73\x20\151\164\145\x6d\x3f\x22\51\47\x20\150\162\145\146\x3d\x27\x61\144\x6d\x69\x6e\56\160\x68\160\x3f\x70\141\x67\x65\x3d\155\x6f\x5f\157\x61\165\x74\150\137\163\x65\x74\x74\x69\156\147\x73\46\x74\141\142\x3d\143\x6f\156\x66\x69\x67\x26\141\143\x74\x69\x6f\156\75\144\145\154\x65\x74\145\x26\141\160\160\75" . rawurlencode($qV) . "\47\76\104\x65\x6c\145\x74\x65\74\x2f\x61\x3e\x20\x7c\40";
            if (isset($_GET["\x61\x63\164\151\x6f\156"]) && "\x69\x6e\163\x74\162\165\143\x74\151\157\156\163" === $_GET["\x61\143\164\151\157\x6e"] && isset($_GET["\146\157\x72"]) && rawurlencode($qV) === $_GET["\146\157\162"]) {
                goto Zr;
            }
            $qO .= "\74\x61\40\x68\162\145\x66\x3d\47\x61\x64\155\151\156\x2e\x70\150\160\x3f\160\141\147\145\75\x6d\157\x5f\x6f\141\165\164\x68\137\x73\x65\164\x74\x69\x6e\147\163\46\x74\x61\142\75\143\157\x6e\x66\x69\x67\46\141\143\x74\x69\157\156\75\x69\x6e\163\164\162\165\143\x74\x69\x6f\156\163\46\141\160\x70\111\x64\x3d" . ($eL->get_app_config("\x61\160\160\111\x64") ? $eL->get_app_config("\141\160\160\x49\144") : '') . "\x26\x66\157\162\75" . rawurlencode($qV) . "\47\x3e\x48\157\x77\40\x74\157\x20\103\x6f\156\x66\x69\147\165\x72\145\x3f\x3c\x2f\x61\76\x3c\57\x74\x64\x3e\74\x2f\164\x72\x3e";
            goto Tt;
            Zr:
            $qO .= "\74\141\40\x68\162\145\146\75\x27\141\144\155\x69\x6e\56\x70\150\x70\77\x70\141\147\145\x3d\155\157\x5f\157\x61\165\x74\150\x5f\163\145\x74\x74\x69\156\x67\163\x26\164\141\142\x3d\143\157\156\x66\x69\x67\47\x3e\x48\151\x64\145\x20\x49\156\x73\164\162\x75\x63\x74\151\157\156\163\74\57\141\x3e\x3c\x2f\x74\144\x3e\x3c\x2f\164\x72\76";
            Tt:
            Cq:
        }
        Bd:
        $qO .= "\x3c\57\x74\141\x62\154\145\76";
        $qO .= "\74\142\x72\76\74\142\162\x3e";
        echo $qO;
        mj:
        ?>
		</div>
		<?php 
    }
}
