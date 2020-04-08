<?php


namespace MoOauthClient\Free;

use MoOauthClient\Free\SignInSettingsInterface;
class SignInSettings implements SignInSettingsInterface
{
    public function render_sign_in_options()
    {
        global $xW;
        ?>
		<div id="wid-shortcode" class="mo_table_layout">
			<h2>Sign in options</h2>
			<h4>Option 1: Use a Widget</h4>
			<ol>
				<li>Go to Appearances > Widgets.</li>
				<li>Select <strong>"miniOrange OAuth"</strong>. Drag and drop to your favourite location and save.</li>
			</ol>

			<h4>Option 2: Use a Shortcode <?php 
        echo !$xW->check_versi(1) ? "\74\163\x6d\x61\154\154\40\143\154\141\163\x73\75\x22\155\x6f\x5f\160\x72\x65\155\x69\165\x6d\137\x66\145\141\164\165\x72\145\x22\76\x5b\123\124\101\x4e\104\101\122\x44\x5d\74\57\163\155\x61\x6c\x6c\76" : '';
        ?>
</h4>
			<ul>
				<li>Place shortcode <strong>[mo_oauth_login]</strong> in WordPress pages or posts.</li>
			</ul>
		</div>
		<?php 
    }
    public function render_advanced_settings()
    {
        global $xW;
        $BX = $xW->get_plugin_config();
        ?>
		<form id="role_mapping_form" name="f" method="post" action="">
			<?php 
        wp_nonce_field("\155\157\137\157\x61\165\164\150\x5f\143\154\151\x65\156\164\137\x73\151\x67\156\x5f\x69\x6e\137\x73\145\164\x74\x69\x6e\147\163", "\155\157\x5f\163\x69\x67\156\151\156\163\145\164\x74\x69\x6e\x67\163\x5f\156\157\x6e\x63\145");
        ?>
			<input type="hidden" name="option" value="mo_oauth_client_advanced_settings">
			<input <?php 
        echo !$xW->check_versi(2) ? "\x64\x69\x73\x61\142\154\x65\x64" : "\156\141\x6d\145\x3d\x22\x72\145\163\164\162\151\x63\164\137\x74\x6f\137\154\x6f\x67\147\x65\x64\x5f\x69\156\137\x75\x73\145\x72\x73\x22\x20\166\141\x6c\x75\x65\75\42\x31\x22\x20" . intval(checked($BX->get_config("\162\x65\163\164\162\x69\143\164\x5f\x74\157\x5f\154\x6f\147\x67\x65\x64\137\151\x6e\x5f\165\x73\145\x72\163")) === 1) . "\40";
        ?>
 type="checkbox"><strong> Restrict site to logged in users</strong> ( Users will be auto redirected to OAuth login if not logged in )
			<?php 
        if (!($BX->get_config("\x72\145\x73\x74\x72\x69\143\x74\137\x74\157\137\x6c\157\x67\147\145\144\x5f\151\156\137\x75\163\145\162\x73") && $xW->check_versi(2))) {
            goto pF;
        }
        echo "\74\160\40\x73\164\171\x6c\x65\x3d\x63\x6f\x6c\157\x72\x3a\162\x65\144\76\x57\x61\x72\156\151\x6e\x67\x3a\40\x54\x68\151\x73\40\x77\x69\x6c\x6c\x20\144\151\163\x61\142\x6c\145\40\127\x6f\162\x64\x50\x72\145\163\163\x20\154\157\x67\151\156\163\56\x20\x59\x6f\165\40\x63\x61\156\40\x75\x73\x65\40\142\141\x63\x6b\144\157\157\x72\40\165\x72\154\40\146\x6f\x72\x20\167\157\x72\144\160\x72\x65\163\163\x20\154\157\147\151\156\x20\x3c\x62\x72\x3e\x3c\163\x74\162\157\x6e\x67\76" . site_url() . "\x2f\167\160\x2d\x6c\157\147\151\x6e\x2e\x70\x68\160\x3f\157\141\x75\x74\x68\154\x6f\x67\151\156\75\x66\141\x6c\x73\145\x3c\57\x73\164\x72\157\x6e\x67\x3e\74\x2f\x70\x3e";
        $O3 = $BX->get_config("\x61\165\x74\157\x5f\162\145\x64\151\162\x65\143\164\x5f\145\x78\143\154\x75\144\x65\137\165\x72\x6c\x73");
        echo "\74\x73\164\x72\157\156\x67\x3e\x55\122\114\x73\x20\x74\x6f\x20\145\x78\x63\x6c\165\144\145\x20\146\162\x6f\x6d\x20\x61\x75\164\157\x20\162\145\x64\151\162\145\143\x74\x20\x3a\40\74\x2f\163\164\x72\x6f\156\147\x3e\40\x28\x45\156\164\145\162\x20\125\122\114\x27\x73\40\x74\157\40\x65\x78\x63\154\165\144\x65\x20\x65\x61\x63\150\40\157\x6e\x20\156\x65\167\40\x6c\x69\x6e\145\51\74\x62\x72\76\x3c\x74\145\170\x74\141\162\x65\141\x20\162\157\x77\163\x3d\42\x31\x30\x22\x20\x6e\x61\155\x65\75\42\141\x75\x74\x6f\x5f\x72\145\144\151\x72\x65\143\x74\x5f\x65\x78\143\154\x75\x64\145\x5f\x75\162\154\163\42\40\x70\x6c\x61\143\145\x68\x6f\x6c\144\x65\x72\x3d\x22\x45\156\164\145\162\40\x55\122\114\47\x73\40\164\x6f\x20\145\x78\x63\154\x75\144\x65\40\145\x61\143\150\x20\157\156\40\156\x65\x77\x20\154\x69\156\x65\x22\x20\x73\x74\x79\154\145\75\x22\167\151\144\x74\x68\72\40\70\x30\45\73\x20\x6c\151\156\x65\55\150\145\151\147\150\164\72\40\61\70\160\x78\x3b\40\x66\x6f\156\x74\x2d\x73\151\x7a\145\72\x20\61\x33\x70\170\73\x22\x3e" . $O3 . "\x3c\x2f\x74\x65\x78\164\x61\x72\x65\x61\76\74\142\162\x3e\x3c\x62\162\x3e";
        pF:
        ?>
					<p><input <?php 
        echo !$xW->check_versi(1) ? "\144\151\x73\x61\142\x6c\x65\144" : "\156\x61\155\x65\75\42\x70\157\160\x75\x70\x5f\x6c\x6f\x67\x69\156\42\x20\166\141\x6c\165\x65\75\x22\x31\x22\x20" . checked(intval($BX->get_config("\x70\x6f\x70\165\160\x5f\154\157\147\151\x6e")) === 1) . "\x20";
        ?>
 type="checkbox"><strong> Open login window in Popup</strong></p>
					<p><input <?php 
        echo !$xW->check_versi(1) ? "\144\151\x73\141\x62\154\145\x64" : "\x6e\x61\x6d\x65\75\42\x61\165\x74\x6f\137\x72\145\147\151\163\x74\x65\x72\42\x20\x76\141\154\165\x65\x3d\42\61\x22\x20" . intval(checked($BX->get_config("\141\165\164\157\x5f\162\x65\x67\151\x73\164\145\x72")) === 1) . "\40";
        ?>
 type="checkbox"> <strong> Auto register Users </strong>(If unchecked, only existing users will be able to log-in)</p>
					<p><input <?php 
        echo !$xW->check_versi(2) ? "\x64\151\163\x61\x62\154\x65\x64" : "\156\x61\155\x65\75\x22\153\x65\x65\160\137\145\170\x69\163\164\151\x6e\x67\137\x75\163\145\x72\x73\x22\40\x76\141\154\165\145\x3d\x22\x31\42\x20" . intval(checked($BX->get_config("\153\x65\x65\x70\x5f\145\170\151\x73\x74\151\x6e\x67\137\x75\x73\x65\162\x73")) === 1) . "\40";
        ?>
 type="checkbox"> <strong> Keep Existing Users </strong>(If checked, existing users' attributes will <strong>NOT</strong> be overwritten when they log-in)</p>
					<p><input <?php 
        echo !$xW->check_versi(2) ? "\144\151\x73\x61\x62\154\x65\x64" : "\x6e\141\155\145\x3d\x22\145\156\x61\142\x6c\x65\x5f\145\170\x69\x73\x74\x69\x6e\x67\137\165\x73\145\162\137\x6c\157\x67\x69\156\42\40\x76\x61\x6c\x75\145\75\42\61\x22\40" . intval(checked($xW->mo_oauth_client_get_option("\x6d\x6f\137\157\x61\165\164\150\x5f\145\156\141\x62\x6c\145\x5f\145\x78\151\x73\x74\151\156\147\137\165\x73\145\x72\137\x6c\x6f\x67\x69\156")) === 1) . "\40";
        ?>
 type="checkbox"> <strong> Allow WordPress Users to Login with OAuth </strong>(If checked, users will be <strong>ALLOWED</strong> to log-in with their OAuth Provider's credentials)</p>
					<p><input <?php 
        echo !$xW->check_versi(1) ? "\x64\x69\x73\141\142\x6c\x65\x64" : "\x6e\141\155\x65\x3d\x22\x63\x6f\x6e\x66\151\162\x6d\137\x6c\x6f\x67\157\x75\164\x22\40\x76\x61\154\x75\145\75\x22\61\42\x20" . intval(checked($BX->get_config("\143\x6f\x6e\146\151\x72\x6d\x5f\154\157\147\x6f\165\164")) === 1) . "\x20";
        ?>
 type="checkbox"> <strong> Confirm when logging out </strong>(If checked, users will be <strong>ASKED</strong> to confirm if they want to log-out, when they click the widget/shortcode logout button)</p>
					<p><input <?php 
        echo !$xW->check_versi(3) ? "\144\151\163\141\x62\x6c\145\x64" : '';
        ?>
 type="checkbox"
					<?php 
        if (!$xW->check_versi(3)) {
            goto Qc;
        }
        echo boolval($BX->get_config("\x61\x63\164\151\166\x61\164\x65\137\x75\x73\x65\x72\x5f\x61\x6e\141\x6c\171\x74\151\x63\163")) ? "\143\150\145\143\153\x65\x64" : '';
        echo "\x20\156\x61\155\145\x3d\x22\x6d\x6f\137\x61\143\x74\x69\166\141\164\145\137\165\163\145\x72\137\x61\156\x61\x6c\171\164\151\143\x73\42\x20";
        Qc:
        ?>
					><strong> Enable User Analytics </strong><?php 
        echo !$xW->check_versi(3) ? "\x3c\x73\x6d\x61\x6c\x6c\x20\163\x74\171\154\x65\x3d\42\x63\157\x6c\x6f\162\72\162\145\x64\42\x3e\133\x45\x4e\x54\x45\122\x50\x52\111\x53\x45\135\x3c\57\x73\x6d\141\154\154\76" : '';
        ?>
</p>
					<p><input <?php 
        echo !$xW->check_versi(1) ? "\144\x69\x73\141\x62\154\145\x64" : "\x6e\x61\155\x65\75\x22\x61\154\154\157\x77\137\162\145\x73\x74\x72\151\143\164\x65\144\x5f\144\x6f\x6d\x61\151\156\163\42\40\166\x61\154\165\x65\75\42\x31\x22\40" . intval(checked($BX->get_config("\141\154\154\157\167\x5f\162\145\x73\164\x72\x69\x63\x74\x65\x64\x5f\144\x6f\x6d\x61\151\x6e\163")) === 1) . "\x20";
        ?>
 type="checkbox"> <strong> Allow Restricted Domains </strong>(By default, all domains in <strong>Restricted Domains</strong> field will be restricted. This option will invert this feature by allowing ONLY these domains)</p>
					<table class="mo_oauth_client_mapping_table" style="width:90%">
						<tbody>
							<tr>
								<td><span style="font-size:13px;font-weight:bold;">Restricted Domains </span><br>(Comma separated domains ex. domain1.com,domain2.com etc)
								</td>
								<td><input <?php 
        echo !$xW->check_versi(2) ? "\144\x69\x73\x61\x62\x6c\x65\x64" : "\x20\x6e\141\155\145\75\42\162\145\163\164\162\x69\143\164\145\x64\x5f\x64\x6f\x6d\141\x69\156\163\x22\x20\166\x61\154\165\145\75\42" . $BX->get_config("\x72\x65\163\164\x72\151\143\x74\x65\144\x5f\x64\x6f\155\x61\151\x6e\x73") . "\42\x20";
        ?>
 type="text"placeholder="domain1.com,domain2.com" style="width:100%;" ></td>
							</tr>
							<tr>
								<td><span style="font-size:13px;font-weight:bold;">Custom redirect URL after login </span><br>(Keep blank in case you want users to redirect to page from where SSO originated)
								</td>
								<td><input <?php 
        echo !$xW->check_versi(1) ? "\x64\x69\163\141\x62\x6c\x65\x64" : "\x20\x6e\141\x6d\145\75\42\143\x75\x73\164\x6f\155\137\141\146\x74\x65\162\137\x6c\x6f\147\x69\x6e\137\165\162\x6c\42\x20\x76\141\x6c\165\x65\x3d\42" . $BX->get_config("\141\146\164\x65\162\x5f\x6c\157\147\x69\x6e\137\165\162\154") . "\x22\x20";
        ?>
 type="url" pattern="https?://.+" title="Include https://" placeholder="https://" style="width:100%;"></td>
							</tr>
							<tr>
								<td><span style="font-size:13px;font-weight:bold;">Custom redirect URL after logout </span>
								</td>
								<td><input <?php 
        echo !$xW->check_versi(1) ? "\x64\x69\163\141\142\x6c\145\144" : "\40\156\x61\x6d\x65\x3d\x22\x63\x75\x73\164\157\155\x5f\141\x66\x74\145\162\137\x6c\x6f\x67\x6f\165\164\x5f\x75\x72\x6c\42\x20\x76\141\x6c\x75\x65\75\x22" . $BX->get_config("\141\146\164\145\x72\x5f\x6c\157\147\x6f\165\164\x5f\165\x72\x6c") . "\x22\40";
        ?>
 type="url" pattern="https?://.+" title="Include https://" placeholder="https://" style="width:100%;"></td>
							</tr>
							<tr>
								<td><span style="font-size:13px;font-weight:bold;">Dynamic Callback URL </span><?php 
        echo !$xW->check_versi(3) ? "\74\x73\x6d\x61\154\154\40\x73\x74\x79\154\145\x3d\42\x63\157\x6c\x6f\162\72\162\145\x64\42\x3e\x5b\x45\116\124\105\x52\120\122\111\x53\x45\x5d\74\57\x73\x6d\141\x6c\x6c\x3e" : '';
        ?>
								</td>
								<td><input <?php 
        echo !$xW->check_versi(3) ? "\144\151\x73\141\x62\x6c\145\x64" : "\40\x6e\141\x6d\145\x3d\42\x64\171\156\141\x6d\151\143\x5f\x63\x61\x6c\154\142\x61\143\153\x5f\165\162\154\42\x20\166\x61\x6c\x75\145\75\x22" . $BX->get_config("\144\171\156\141\155\151\143\x5f\x63\141\x6c\x6c\142\141\143\x6b\137\165\162\x6c") . "\42\40";
        ?>
 type="url" pattern="https?://.+" title="Include https://"  placeholder="Callback / Redirect URI" style="width:100%;"></td>
							</tr>
							<tr></tr>
							<tr>
								<td><input <?php 
        echo !$xW->check_versi(3) ? "\144\151\163\x61\142\154\x65\x64" : '';
        ?>
 type="checkbox"
								<?php 
        if (!$xW->check_versi(3)) {
            goto wD;
        }
        echo boolval($BX->get_config("\x61\x63\x74\x69\x76\141\x74\x65\137\163\x69\x6e\x67\154\x65\x5f\x6c\157\x67\151\156\137\x66\154\157\x77")) ? "\143\150\x65\143\x6b\145\144" : '';
        echo "\x20\156\x61\x6d\x65\75\42\x6d\x6f\137\x61\x63\164\x69\166\x61\164\x65\x5f\163\x69\156\x67\154\145\x5f\x6c\157\x67\x69\x6e\x5f\x66\154\x6f\167\42\x20";
        wD:
        ?>
								><span style="font-size:13px;font-weight:bold;"> Enable Single Login Flow </span><?php 
        echo !$xW->check_versi(3) ? "\74\x73\x6d\x61\x6c\154\40\163\164\171\154\x65\x3d\x22\143\157\154\157\162\x3a\162\x65\144\x22\76\x5b\105\116\124\x45\x52\120\122\x49\x53\105\x5d\74\x2f\163\155\141\154\x6c\x3e" : '';
        ?>
</td>
							</tr>
							<?php 
        if (!($xW->check_versi(3) && boolval($BX->get_config("\x61\143\x74\151\166\x61\x74\x65\x5f\163\x69\156\147\154\145\x5f\x6c\x6f\147\151\x6e\137\x66\154\157\167")))) {
            goto Fv;
        }
        ?>
	
									<tr>
										<td><font style="font-size:13px;font-weight:bold;">Display Name for Common Login Button </font></td>
										<td><input type="text" name="common_login_button_display_name"  placeholder="Login with AppName" style="width:100%;" value="<?php 
        echo $BX->get_config("\143\157\x6d\x6d\x6f\x6e\x5f\154\x6f\x67\151\x6e\x5f\142\165\164\164\157\x6e\137\144\x69\163\x70\154\x61\x79\x5f\156\141\155\x65");
        ?>
"></td>
									</tr>
									<?php 
        Fv:
        ?>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td><input <?php 
        echo !$xW->check_versi(1) ? "\x64\x69\x73\x61\142\x6c\145\x64" : '';
        ?>
 type="submit" class="button button-primary button-large" value="Save Settings"></td>
								<td>&nbsp;</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		<?php 
    }
    public function render_free_ui()
    {
        global $xW;
        self::render_sign_in_options();
        echo "\x3c\144\x69\x76\x20\x69\x64\x3d\x22\141\x64\x76\x61\156\143\145\x64\137\x73\x65\164\164\151\156\147\x73\x5f\x73\163\x6f\x22\x20\143\154\x61\163\163\x3d\42\155\157\137\x74\x61\x62\x6c\145\137\x6c\141\x79\x6f\165\164\40\x22\x3e\x3c\x68\x33\76\x41\144\166\x61\x6e\x63\145\144\x20\x53\145\164\x74\x69\156\x67\x73\x3c\x2f\150\63\76";
        if (!($xW->get_versi() === 0)) {
            goto i4;
        }
        ?>
		<small class="mo_premium_feature"> [PREMIUM]</small>
		<!--br><br-->
		<form id="role_mapping_form" name="f" method="post" action="">
		<h4>Select Grant Type</h4>
		<input checked disabled type="checkbox"> Authorization Code Grant&nbsp;&nbsp;
		<input disabled type="checkbox"> Password Grant&nbsp;&nbsp;
		<input disabled type="checkbox"> Client Credentials Grant&nbsp;&nbsp;
		<input disabled type="checkbox"> Implicit Grant&nbsp;&nbsp;
		<input disabled type="checkbox"> Refresh Token Grant
		<br><br><hr><br>
		<?php 
        i4:
        self::render_advanced_settings();
    }
}
