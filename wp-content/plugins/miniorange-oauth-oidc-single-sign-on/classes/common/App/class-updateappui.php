<?php


namespace MoOauthClient\App;

class UpdateAppUI
{
    private $app;
    public function __construct($Sm, $eL)
    {
        if (!(false === $eL)) {
            goto dY;
        }
        $EN = admin_url() . "\57\x61\x64\x6d\x69\x6e\x2e\x70\150\x70\x3f\160\x61\x67\x65\x3d\155\157\x5f\157\x61\x75\x74\x68\x5f\163\145\x74\x74\151\x6e\x67\x73\x26\x74\141\142\75\143\157\156\146\151\147";
        echo "\117\x6f\160\163\41\40\x53\157\x6d\x65\x74\150\x69\x6e\x67\40\167\x65\x6e\164\x20\167\162\x6f\156\x67\56\40\120\154\x65\141\163\145\x20\167\141\x69\164\x2e\56\x2e";
        ?>
			<script>
				window.location.replace("<?php 
        echo wp_kses($EN, \get_valid_html());
        ?>
");
			</script>
			<?php 
        dY:
        $this->app = $eL;
        $this->render_update_app_page($Sm, $eL->get_app_config());
    }
    public function render_update_app_page($gQ, $v_)
    {
        global $xW;
        ?>
		<div class="mo_table_layout" id="app_config_panel">
		<div id="toggle2" class="mo_panel_toggle">
			<h3>Update Application</h3>
		</div>
		<div id="mo_oauth_update_app">
		<form id="form-common" name="form-common" method="post" action="admin.php?page=mo_oauth_settings&tab=config&action=update&app=<?php 
        echo $gQ;
        ?>
">
		<input type="hidden" name="option" value="mo_oauth_add_app" />
		<?php 
        wp_nonce_field("\x6d\157\137\x6f\x61\x75\x74\150\137\141\144\144\x5f\141\x70\x70", "\x6d\x6f\137\x6f\141\165\164\150\137\x61\144\144\137\141\160\160\137\x6e\x6f\x6e\x63\x65");
        ?>
		<table class="mo_settings_table">
			<tr>
			<td><strong><span class="mo_premium_feature">*</span>Application:</strong></td>
			<td>
				<input class="mo_table_textbox" required="" type="hidden" name="mo_oauth_app_name" value="<?php 
        echo $gQ;
        ?>
">
				<input class="mo_table_textbox" required="" type="hidden" name="mo_oauth_custom_app_name" value="<?php 
        echo $gQ;
        ?>
">
				<input type="hidden" name="mo_oauth_app_type" value="<?php 
        echo $v_["\141\x70\x70\137\x74\171\160\145"];
        ?>
">
				<?php 
        echo $gQ;
        ?>
<br><br>
			</td>
			</tr>
			<tr id="mo_oauth_display_app_name_div">
				<td><strong>Display App Name:</strong><?php 
        echo !$xW->check_versi(1) ? "\x3c\x62\162\76\x26\145\x6d\x73\x70\x3b\74\x73\160\141\x6e\x20\143\154\x61\x73\x73\x3d\42\x6d\x6f\137\x70\x72\145\x6d\x69\165\155\x5f\146\x65\x61\x74\165\162\x65\x22\76\133\x53\x54\x41\x4e\104\x41\x52\104\135\x3c\57\x73\160\x61\x6e\x3e" : '';
        ?>
</td>
				<td><input <?php 
        echo !$xW->check_versi(1) ? "\x64\151\x73\141\x62\154\x65\144" : '';
        ?>
 class="mo_table_textbox" type="text" id="mo_oauth_display_app_name" name="mo_oauth_display_app_name" value="<?php 
        echo wp_kses(isset($v_["\144\x69\163\x70\154\141\x79\x61\160\x70\x6e\x61\155\x65"]) ? $v_["\144\x69\x73\x70\154\x61\x79\141\x70\x70\x6e\x61\x6d\x65"] : '', \get_valid_html());
        ?>
" pattern="[a-zA-Z0-9\s]+" title="Please do not add any special characters."></td>
			</tr>
			<tr><td><strong>Redirect / Callback URL</strong></td>
			<td><input class="mo_table_textbox"  type="text" readonly="true" value='<?php 
        echo "\145\166\145\157\x6e\154\151\x6e\x65" !== $gQ ? \site_url() : "\x68\x74\164\x70\x73\x3a\57\x2f\x6c\x6f\147\x69\156\x2e\170\x65\143\x75\x72\151\x66\x79\x2e\x63\157\155\x2f\155\157\x61\x73\x2f\157\x61\165\164\150\x2f\143\x6c\151\x65\156\x74\x2f\143\x61\154\154\x62\141\143\x6b";
        ?>
'></td>
			</tr>
			<tr>
				<td><strong><span class="mo_premium_feature">*</span>Client ID:</strong></td>
				<td><input class="mo_table_textbox" required="" type="text" name="mo_oauth_client_id" value="<?php 
        echo $v_["\x63\x6c\151\145\x6e\164\137\151\x64"];
        ?>
"></td>
			</tr>
			<tr>
				<td><strong><span class="mo_premium_feature">*</span>Client Secret:</strong></td>
				<td><input class="mo_table_textbox" required="" type="text" name="mo_oauth_client_secret" value="<?php 
        echo $v_["\143\x6c\x69\145\x6e\164\137\x73\x65\143\x72\x65\x74"];
        ?>
"></td>
			</tr>
			<tr>
				<td><strong>Scope:</strong></td>
				<td><input class="mo_table_textbox" type="text" name="mo_oauth_scope" value="<?php 
        echo $v_["\163\x63\x6f\x70\145"];
        ?>
"></td>
			</tr>
			<tr  id="mo_oauth_authorizeurl_div">
				<td><strong><span class="mo_premium_feature">*</span>Authorize Endpoint:</strong></td>
				<td><input class="mo_table_textbox" required="" type="url" id="mo_oauth_authorizeurl" name="mo_oauth_authorizeurl" value="<?php 
        echo $v_["\141\165\x74\x68\x6f\x72\151\x7a\145\x75\x72\x6c"];
        ?>
"></td>
			</tr>
			<tr id="mo_oauth_accesstokenurl_div">
				<td><strong><span class="mo_premium_feature">*</span>Access Token Endpoint:</strong></td>
				<td><input class="mo_table_textbox" required="" type="url" id="mo_oauth_accesstokenurl" name="mo_oauth_accesstokenurl" value="<?php 
        echo $v_["\141\x63\x63\145\x73\x73\164\157\x6b\x65\156\165\162\154"];
        ?>
"></td>
			</tr>
			<tr>
				<td></td>
				<td><div style="padding:5px;"></div><input type="checkbox" name="mo_oauth_authorization_header" value ="1" <?php 
        echo isset($v_["\x73\x65\156\x64\137\150\145\x61\144\145\162\x73"]) ? 1 === $v_["\163\x65\156\144\137\x68\145\141\x64\x65\162\163"] ? "\x63\x68\145\143\x6b\x65\x64" : '' : "\x63\150\145\143\x6b\x65\x64";
        ?>
 />Set client credentials in Header<span style="padding:0px 0px 0px 8px;"></span><input type="checkbox" name="mo_oauth_body" value ="1" <?php 
        echo isset($v_["\x73\x65\x6e\x64\x5f\x62\x6f\x64\171"]) ? 1 === $v_["\x73\x65\156\x64\x5f\x62\x6f\144\171"] ? "\x63\150\x65\x63\x6b\x65\x64" : '' : "\x63\150\x65\143\x6b\x65\x64";
        ?>
 />Set client credentials in Body<div style="padding:5px;"></div></td>
			</tr>
				<?php 
        $CU = isset($v_["\x61\160\160\137\164\171\160\145"]) && "\157\160\145\156\151\144\x63\x6f\156\x6e\145\143\164" !== $v_["\141\x70\160\x5f\x74\171\x70\145"] ? false : true;
        ?>
				<tr id="mo_oauth_resourceownerdetailsurl_div">
					<td><strong><?php 
        echo false === $CU ? "\74\x73\x70\141\156\x20\x63\154\141\163\163\x3d\42\155\157\x5f\x70\162\145\x6d\151\165\155\x5f\x66\x65\141\x74\165\x72\x65\42\x3e\52\x3c\x2f\163\x70\x61\x6e\x3e" : '';
        ?>
Get User Info Endpoint:</strong></td>
					<td><input class="mo_table_textbox" type="url" id="mo_oauth_resourceownerdetailsurl" name="mo_oauth_resourceownerdetailsurl" <?php 
        echo false === $CU ? "\x72\145\x71\x75\151\162\145\144" : '';
        ?>
 value="<?php 
        echo isset($v_["\162\145\x73\157\165\x72\x63\145\x6f\167\x6e\x65\x72\144\145\164\141\151\154\163\165\162\154"]) ? $v_["\162\145\163\x6f\x75\x72\x63\x65\x6f\x77\x6e\x65\162\x64\145\164\x61\151\x6c\x73\x75\x72\154"] : '';
        ?>
"></td>
				</tr>
			<tr><td><strong>Client Authentication:</strong></td><td><div style="padding:5px;"></div><input class="mo_table_textbox" type="radio" name="disable_authorization_header" id="disable_authorization_header" <?php 
        echo intval($xW->mo_oauth_client_get_option("\155\x6f\x5f\157\x61\165\164\x68\137\143\154\151\145\156\164\x5f\x64\151\163\141\142\x6c\145\x5f\141\165\164\150\157\162\151\x7a\141\x74\x69\157\156\137\x68\145\141\x64\145\x72")) ? '' : "\x63\x68\x65\143\153\x65\144";
        ?>
 value="0">HTTP Basic (Recommended)<div style="padding:5px;"></div><input class="mo_table_textbox" type="radio" name="disable_authorization_header" id="disable_authorization_header" value="1" <?php 
        echo intval($xW->mo_oauth_client_get_option("\x6d\x6f\137\x6f\x61\165\164\x68\x5f\143\154\x69\x65\156\164\137\144\151\x73\141\142\x6c\145\137\x61\x75\164\x68\157\x72\x69\x7a\141\x74\151\x6f\x6e\137\x68\145\x61\144\145\162")) ? "\x63\150\x65\x63\153\145\x64" : '';
        ?>
>Request Body<div style="padding:5px;"></div></td></tr>
			<?php 
        do_action("\155\157\137\x6f\141\x75\164\150\137\143\154\151\145\156\164\x5f\147\x72\x61\156\x74\x5f\144\144\x5f\x69\156\164\145\162\156\x61\154", $v_);
        ?>
			<?php 
        if (!$xW->check_versi(2)) {
            goto Hu;
        }
        ?>
			<tr id="mo_oauth_groupdetailsurl_div">
				<td><strong>Group User Info Endpoint:</strong></td>
				<td><input class="mo_table_textbox" type="text" id="mo_oauth_groupdetailsurl" name="mo_oauth_groupdetailsurl" value="<?php 
        echo isset($v_["\147\162\157\x75\x70\144\145\x74\141\x69\154\163\165\x72\x6c"]) ? $v_["\x67\x72\x6f\165\x70\x64\x65\164\141\x69\154\x73\165\162\x6c"] : '';
        ?>
"></td>
			</tr>
			<tr id="mo_oauth_jwksurl_div">
				<td><strong>JWKS URL:</strong></td>
				<td><input class="mo_table_textbox" type="text" id="mo_oauth_jwksurl" name="mo_oauth_jwksurl" value="<?php 
        echo isset($v_["\152\x77\x6b\163\x75\x72\x6c"]) ? $v_["\x6a\167\153\163\x75\162\x6c"] : '';
        ?>
"></td>
			</tr>
			<?php 
        Hu:
        ?>
			<tr>
				<td><strong>login button:</strong></td>
				<td><div style="padding:5px;"></div><input type="checkbox" name="mo_oauth_show_on_login_page" value ="1" <?php 
        echo isset($v_["\163\x68\x6f\x77\x5f\x6f\156\x5f\x6c\157\147\151\x6e\x5f\x70\x61\x67\145"]) ? 1 === $v_["\163\x68\157\x77\x5f\157\156\x5f\x6c\157\x67\151\x6e\137\x70\x61\147\145"] ? "\x63\x68\x65\x63\153\x65\144" : '' : '';
        ?>
/>Show on login page</td>
			</tr>
			<tr>
				<td><br></td>
				<td><br></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="submit" name="submit" value="Save settings" class="button button-primary button-large" />
					<input id="mo_oauth_test_configuration" type="button" name="button" value="Test Configuration" class="button button-primary button-large" onclick="testConfiguration()" />
				</td>
			</tr>
		</table>
		</form>
		</div>
		</div>

		<?php 
        do_action("\155\x6f\x5f\x6f\141\165\164\150\x5f\x63\x6c\151\x65\156\x74\x5f\x67\x72\141\x6e\164\137\163\x65\164\164\151\156\147\163\x5f\151\156\x74\x65\x72\156\141\x6c", $v_, $gQ);
        $this->mo_oauth_attribute_mapping($v_, $gQ);
        $this->mo_oauth_client_rolemapping($v_, $gQ);
        if (!(isset($v_["\147\x72\141\156\164\137\164\171\x70\145"]) && "\x50\141\x73\x73\167\x6f\x72\144\40\107\x72\141\156\x74" === $v_["\147\x72\141\156\x74\137\x74\x79\160\145"])) {
            goto Vl;
        }
        do_action("\x6d\157\x5f\157\x61\165\164\150\x5f\143\154\x69\145\156\164\137\141\x64\x64\137\160\x77\144\137\x6a\x73");
        Vl:
        ?>
		<script>
		function HandleOnCloseEvent() {
			window.location.href = window.location.href;
		}
		function testConfiguration(){
			var mo_oauth_app_name = jQuery("#mo_oauth_app_name").val();
			if ( typeof moOAuthLoginPwd === 'function' ) {
				moOAuthLoginPwd(mo_oauth_app_name, true, '<?php 
        echo site_url();
        ?>
');
				return;
			}
			var myWindow = window.open('<?php 
        echo site_url();
        ?>
' + '/?option=testattrmappingconfig&app='+mo_oauth_app_name, "Test Attribute Configuration", "width=600, height=600");
			
			myWindow.onbeforeunload = function(){
		       myWindow.opener.HandleOnCloseEvent();
		    }
			while(1) {
				if(myWindow.closed()) {
					$(document).trigger("config_tested");
					break;
				} else {continue;}
			}
		}
		</script>
			<?php 
    }
    public function mo_oauth_attribute_mapping($v_, $gQ)
    {
        global $xW;
        $sC = !$xW->check_versi(1);
        $cb = $sC ? "\144\151\163\141\142\x6c\145\x64\x3d\42\164\162\165\145\42" : '';
        $Bh = $sC ? "\162\x65\x71\x75\x69\x72\145\144\75\42\146\141\154\163\145\42" : '';
        $BX = $xW->get_plugin_config();
        $NY = $xW->mo_oauth_client_get_option("\155\157\x5f\x6f\141\165\x74\150\x5f\x61\x74\x74\x72\137\156\141\x6d\145\137\154\151\163\164" . $gQ);
        ?>
		<div class="mo_table_layout" id="attrmapping">
			<form name="form-common" method="post" action="admin.php?page=mo_oauth_settings">
			<h3>Attribute Mapping</h3>
			<p style="font-size:10px">Do <strong>Test Configuration</strong> above to configure attribute mapping.<br></p>
			<input type="hidden" name="option" value="mo_oauth_attribute_mapping" />
			<?php 
        wp_nonce_field("\155\x6f\137\157\141\165\x74\x68\x5f\141\164\x74\x72\151\142\165\x74\x65\137\155\x61\x70\160\x69\156\147", "\155\x6f\137\157\x61\165\164\x68\x5f\x61\x74\x74\x72\x69\x62\165\x74\145\x5f\155\x61\x70\x70\x69\156\147\x5f\x6e\x6f\156\143\145");
        ?>
			<input class="mo_table_textbox" required="" type="hidden" id="mo_oauth_app_name" name="mo_oauth_app_name" value="<?php 
        echo $gQ;
        ?>
">
			<input class="mo_table_textbox" required="" type="hidden" name="mo_oauth_custom_app_name" value="<?php 
        echo $gQ;
        ?>
">
			<table class="mo_settings_table" id="attributemappingtable">
				<tr id="mo_oauth_name_attr_div">
					<td><strong><span class="mo_premium_feature">*</span>Username Attribute:</strong></td>
					<td>
						<?php 
        if (is_array($NY)) {
            goto cY;
        }
        ?>
							<input class="mo_table_textbox" required="" type="text" id="mo_oauth_username_attr" name="mo_oauth_username_attr" placeholder="Username Attributes Name" value="<?php 
        echo isset($v_["\x75\x73\x65\162\156\141\155\145\x5f\x61\x74\x74\162"]) ? $v_["\165\163\145\162\x6e\141\155\145\137\x61\x74\164\162"] : '';
        ?>
"><?php 
        goto jt;
        cY:
        ?>
							<select class="mo_table_textbox" id="mo_oauth_username_attr" name="mo_oauth_username_attr">
							<option value="">---------------- Select an Attribute ----------------</option>
								<?php 
        foreach ($NY as $qV => $sw) {
            echo "\x3c\x6f\160\164\151\x6f\156\40\x76\141\x6c\165\x65\x3d\x27" . $sw . "\x27";
            if (isset($v_["\165\x73\x65\162\x6e\x61\x6d\x65\x5f\x61\164\164\x72"]) && $v_["\x75\163\145\162\156\x61\155\145\x5f\141\164\164\x72"] === $sw) {
                goto pO;
            }
            echo '';
            goto Y6;
            pO:
            echo "\40\x73\x65\154\145\143\164\145\x64";
            Y6:
            echo "\40\76" . $sw . "\74\57\x6f\x70\164\x69\157\x6e\x3e";
            Ey:
        }
        dn:
        ?>
							</select>
							<?php 
        jt:
        ?>
					</td>
				</tr>
				<?php 
        echo $sC ? "\x3c\164\162\x3e\74\x74\144\76\x26\x6e\142\163\x70\73\x3c\x2f\164\144\76\x3c\164\144\x3e\74\160\x3e\101\144\x76\141\x6e\x63\x65\144\x20\x61\164\164\162\151\x62\x75\x74\x65\40\155\141\x70\x70\x69\x6e\147\x20\x69\x73\40\141\166\x61\x69\x6c\x61\142\x6c\x65\40\151\156\40\x3c\141\x20\x68\x72\x65\x66\x3d\x22\141\144\155\x69\156\56\x70\x68\160\x3f\x70\141\x67\x65\x3d\155\x6f\137\157\x61\165\164\150\x5f\163\x65\164\164\x69\156\x67\x73\x26\x61\155\x70\x3b\x74\x61\x62\75\x6c\151\143\145\156\x73\x69\156\x67\x22\76\x3c\163\164\162\157\156\x67\76\160\162\145\155\x69\x75\155\74\57\163\x74\x72\x6f\x6e\x67\x3e\x3c\x2f\141\x3e\x20\x76\145\162\x73\151\157\x6e\x2e\x3c\57\x70\x3e\x3c\57\x74\144\x3e\x3c\57\164\162\x3e" : '';
        ?>
				<tr id="mo_oauth_name_attr_div">
					<td><strong><span class="mo_premium_feature"></span>First Name Attribute:</strong></td>
					<td><input class="mo_table_textbox" type="text"
					<?php 
        echo $cb;
        echo !$sC ? "\151\144\x3d\42\155\x6f\137\157\141\165\164\150\137\146\x69\x72\163\164\156\x61\x6d\145\x5f\141\x74\164\162\x22\x20\156\x61\155\145\x3d\42\155\157\x5f\157\141\165\x74\x68\x5f\146\151\x72\x73\164\156\x61\155\x65\137\141\164\164\162\42\40\166\141\x6c\x75\x65\75\42" . (isset($v_["\x66\x69\x72\x73\x74\156\141\155\x65\x5f\x61\164\x74\162"]) ? $v_["\146\x69\162\x73\164\156\141\x6d\145\137\141\164\164\x72"] : '') . "\42\40" : "\x20";
        ?>
					placeholder="FirstName Attributes Name"></td>
				</tr>
				<tr id="mo_oauth_name_attr_div">
					<td><strong><span class="mo_premium_feature"></span>Last Name Attribute:</strong></td>
					<td><input class="mo_table_textbox" type="text"
					<?php 
        echo $cb;
        echo !$sC ? "\151\x64\75\x22\x6d\x6f\x5f\157\141\165\x74\x68\137\154\x61\163\164\156\141\155\x65\x5f\x61\164\164\x72\x22\x20\156\141\x6d\145\x3d\x22\x6d\x6f\137\x6f\x61\x75\x74\150\x5f\154\x61\163\164\156\141\155\x65\x5f\141\x74\x74\x72\42\x20\x76\141\x6c\165\x65\x3d\42" . (isset($v_["\x6c\141\x73\164\156\141\x6d\x65\137\x61\x74\x74\162"]) ? $v_["\154\141\x73\x74\156\141\x6d\145\x5f\x61\164\x74\162"] : '') . "\42\x20" : "\40";
        ?>
					placeholder="LastName Attributes Name"></td>
				</tr>
				<tr id="mo_oauth_email_attr_div">
					<td><strong>Email Attribute:</strong></td>
					<td><input class="mo_table_textbox" type="text"
						<?php 
        echo $cb;
        echo !$sC ? "\151\x64\x3d\42\x6d\157\137\157\x61\x75\164\x68\137\145\155\x61\151\x6c\137\x61\x74\164\162\x22\x20\156\141\155\x65\x3d\x22\155\157\137\x6f\x61\x75\x74\150\x5f\145\155\x61\x69\x6c\x5f\x61\164\164\162\42\x20\x76\x61\154\x75\145\x3d\x22" . (isset($v_["\145\155\141\151\x6c\137\141\164\164\x72"]) ? $v_["\145\155\141\151\x6c\137\141\164\x74\162"] : '') . "\x22\x20" : "\x20";
        ?>
					placeholder="Email Attributes Name"></td>
				</tr>
				<tr id="mo_oauth_name_attr_div">
					<td><strong><span class="mo_premium_feature"></span>Group Attributes Name:</strong></td>
					<td>
						<?php 
        $tT = isset($v_["\147\x72\157\x75\160\x6e\x61\x6d\x65\137\141\x74\x74\162\x69\142\x75\164\145"]) ? $v_["\x67\162\157\165\160\x6e\141\x6d\145\137\x61\164\x74\x72\151\142\165\164\145"] : '';
        ?>
						<input type="text"  class="mo_table_textbox"
						<?php 
        echo $cb;
        echo !$sC ? "\x69\144\75\42\155\x61\160\160\x69\156\x67\x5f\x67\x72\157\165\160\156\141\x6d\x65\x5f\141\164\x74\162\x69\x62\x75\164\145\x22\x20\156\x61\155\x65\75\42\155\141\160\x70\151\x6e\147\x5f\147\162\157\x75\x70\156\141\155\x65\137\141\164\x74\162\151\142\x75\164\x65\42\40\x76\141\x6c\165\x65\75\42" . $tT . "\42\x20" : "\x20";
        ?>
						placeholder="Group Attributes Name">
					</td>
				</tr>
				<?php 
        $qd = isset($v_["\x67\162\157\x75\160\x5f\x61\164\164\x72"]) ? $v_["\147\162\x6f\x75\x70\137\x61\x74\164\x72"] : '';
        $au = isset($v_["\144\151\163\160\x6c\141\x79\x5f\x61\164\x74\162"]) ? $v_["\x64\151\163\x70\154\141\171\x5f\141\164\x74\162"] : '';
        echo "\xa\11\x9\x9\11\40\40\x3c\x74\162\x3e\12\x9\x9\x9\x9\11\x3c\164\144\x3e\x3c\x73\164\x72\157\156\x67\x3e\x44\151\x73\x70\154\141\171\x20\116\x61\155\x65\72\74\x2f\163\164\162\157\156\147\76\x3c\57\164\144\76\12\x9\11\11\x9\x9\x3c\164\144\76\xa\x9\11\x9\11\11\x9\x3c\163\145\154\x65\143\x74\x20" . $cb . "\x6e\141\x6d\145\x3d\x22\x6f\x61\x75\x74\x68\137\x63\x6c\x69\x65\x6e\164\x5f\141\155\137\144\x69\x73\160\x6c\x61\x79\137\156\141\x6d\145\x22\40\151\144\x3d\42\x6f\141\165\x74\x68\x5f\143\x6c\x69\145\156\x74\137\141\x6d\x5f\x64\x69\163\160\x6c\x61\171\x5f\156\x61\155\x65\42\x20\x3e";
        echo "\74\157\160\x74\151\157\x6e\40\166\x61\154\x75\x65\x3d\42\125\x53\105\122\x4e\101\115\105\x22";
        echo "\x55\x53\x45\122\x4e\101\x4d\x45" === $au ? "\163\x65\154\145\x63\164\145\144\x3d\x22\163\x65\x6c\x65\143\x74\145\x64\x22" : '';
        echo "\x3e\125\163\145\x72\x6e\141\155\145\74\57\x6f\x70\164\151\157\156\x3e\x3c\x6f\x70\164\x69\157\x6e\x20\166\141\154\165\145\75\42\106\x4e\x41\115\105\42";
        echo "\106\x4e\x41\x4d\105" === $au ? "\x73\145\154\x65\x63\x74\145\x64\x3d\42\163\x65\x6c\145\x63\164\x65\x64\x22" : '';
        echo "\76\x46\151\x72\163\x74\116\x61\155\145\x3c\57\157\160\164\x69\x6f\156\76\74\x6f\160\x74\x69\157\156\40\166\141\x6c\165\x65\75\42\x4c\116\101\115\105\x22";
        echo "\x4c\x4e\101\115\105" === $au ? "\163\x65\x6c\x65\143\164\145\x64\x3d\x22\163\145\x6c\145\x63\x74\145\x64\x22" : '';
        echo "\x3e\114\141\163\164\x4e\141\x6d\145\74\x2f\157\160\x74\x69\157\156\76\x3c\157\160\x74\x69\x6f\156\x20\x76\141\x6c\165\x65\75\42\x46\x4e\101\x4d\105\x5f\x4c\x4e\101\x4d\x45\42";
        echo "\x46\116\101\115\105\x5f\x4c\116\101\x4d\105" === $au ? "\163\x65\x6c\x65\x63\164\145\144\75\42\x73\145\154\x65\x63\164\x65\x64\42" : '';
        echo "\x3e\x46\x69\x72\163\164\116\141\155\145\40\x4c\x61\163\164\116\x61\x6d\x65\74\57\157\160\x74\x69\x6f\156\x3e\74\157\160\x74\151\x6f\156\x20\x76\141\x6c\165\145\75\42\x4c\116\101\115\x45\137\x46\x4e\x41\x4d\x45\x22";
        echo "\114\x4e\x41\x4d\105\x5f\x46\116\101\x4d\x45" === $au ? "\x73\x65\x6c\x65\143\164\x65\x64\x3d\x22\x73\x65\154\145\x63\164\x65\144\42" : '';
        echo "\76\x4c\141\x73\x74\116\141\x6d\145\x20\x46\151\x72\163\164\116\x61\x6d\145\74\x2f\x6f\x70\x74\x69\157\x6e\x3e\12\x9\11\11\11\x9\11\x3c\x2f\x73\x65\154\x65\143\x74\x3e\xa\x9\x9\x9\11\x9\74\x2f\x74\x64\76\12\11\x9\11\x9\x20\40\x3c\57\164\162\x3e\12\11\11\x9\x9\x20\40\74\x74\162\76\x3c\x74\144\x20\143\x6f\154\163\x70\141\x6e\75\x22\62\x22\x3e";
        $sC = !$xW->check_versi(2);
        $cb = $sC ? "\x64\151\x73\x61\142\x6c\x65\x64\75\42\x74\x72\x75\145\x22" : '';
        $Bh = $sC ? "\x72\145\161\x75\x69\162\145\x64\x3d\x22\x66\x61\154\163\x65\x22" : '';
        echo "\x3c\x68\63\x3e\x4d\141\x70\x20\x43\165\x73\164\157\155\x20\101\x74\x74\162\x69\x62\165\x74\145\163";
        echo $sC ? "\46\145\x6d\x73\160\x3b\74\x73\x6d\141\154\x6c\40\x63\154\x61\x73\x73\75\42\155\157\x5f\x70\162\x65\x6d\151\x75\155\137\146\x65\x61\x74\x75\x72\145\42\x3e\133\120\x52\105\x4d\111\x55\x4d\x5d\74\x2f\163\155\x61\154\154\x3e" : '';
        echo "\x3c\x2f\150\63\x3e\115\x61\x70\40\145\x78\164\162\x61\x20\117\101\165\x74\150\x20\x50\162\x6f\166\151\144\145\162\40\x61\x74\x74\x72\x69\142\x75\164\x65\163\40\x77\150\151\x63\x68\40\x79\x6f\165\40\x77\x69\x73\x68\x20\164\157\x20\142\145\40\151\x6e\x63\x6c\165\x64\145\x64\40\151\156\x20\x74\150\145\x20\165\163\145\162\x20\160\162\x6f\146\151\154\x65\40\142\145\x6c\x6f\x77\12\11\x9\11\x9\x3c\57\x74\x64\76\x3c\x74\144\x3e\x3c\x69\156\160\x75\x74\40\x74\171\x70\x65\75\x22\142\x75\164\x74\x6f\156\x22\40";
        echo $sC ? $cb : '';
        echo "\156\141\155\x65\75\42\x61\x64\x64\x5f\141\164\164\x72\151\x62\165\164\145\x22\x20\166\x61\154\x75\x65\75\x22\53\x22\40\157\156\x63\x6c\151\143\153\75\x22\141\x64\144\137\143\x75\x73\164\157\x6d\137\x61\x74\164\x72\151\142\165\x74\x65\x28\x29\73\42\40\x63\x6c\x61\x73\x73\75\42\142\165\164\x74\x6f\156\x20\x62\165\x74\164\x6f\x6e\x2d\x70\x72\x69\x6d\x61\162\171\42\40\40\x2f\76\74\57\164\144\x3e";
        echo "\x3c\x74\x64\76\74\151\x6e\160\x75\164\x20\x74\171\x70\x65\75\42\142\165\164\x74\x6f\x6e\42\40";
        echo $sC ? $cb : '';
        echo "\x6e\x61\x6d\x65\75\x22\x72\145\155\x6f\166\145\137\x61\x74\x74\x72\x69\142\x75\x74\x65\x22\40\x76\x61\154\165\x65\x3d\x22\x2d\x22\40\x6f\156\143\154\x69\143\x6b\x3d\42\x72\145\155\157\x76\x65\137\143\165\x73\x74\x6f\x6d\137\141\164\x74\x72\x69\142\x75\164\x65\50\x29\73\42\40\x63\x6c\141\x73\163\75\42\142\x75\164\164\x6f\156\x20\142\165\164\x74\157\x6e\x2d\x70\162\x69\x6d\x61\162\x79\42\x20\x20\x20\x2f\x3e\x3c\x2f\164\144\76\74\x2f\x74\162\76\12\11\x9\x9\11";
        if (isset($v_["\143\165\163\164\x6f\155\x5f\x61\164\164\x72\x73\137\155\x61\160\160\x69\156\x67"]) && !empty($v_["\143\165\x73\x74\x6f\155\x5f\141\164\x74\x72\163\137\155\141\160\x70\x69\156\x67"])) {
            goto SE;
        }
        echo "\x3c\164\x72\40\x63\154\141\163\163\x3d\x22\162\157\167\x73\x22\x3e\74\164\144\x3e\74\151\156\160\x75\164\x20" . $cb . "\40\164\171\x70\145\x3d\x22\164\145\x78\164\x22";
        echo !$sC ? "\x20\x6e\141\x6d\x65\75\x22\x6d\x6f\137\x6f\x61\x75\164\x68\137\143\x6c\151\145\156\x74\137\143\165\x73\164\157\x6d\137\x61\x74\164\x72\x69\x62\165\164\145\x5f\153\x65\171\137\x31\x22\40" : "\40";
        echo "\x20\160\154\141\x63\x65\x68\x6f\x6c\x64\x65\x72\75\x22\105\156\164\x65\x72\40\146\151\x65\154\x64\x20\x6d\x65\x74\141\40\x6e\141\x6d\145\x22\40\40\40\x2f\x3e\x3c\x2f\x74\144\x3e";
        echo "\74\164\x64\76\x3c\x69\x6e\x70\165\164\x20" . $cb;
        echo !$sC ? "\x20\156\x61\x6d\145\75\x22\155\x6f\x5f\x6f\x61\165\x74\150\x5f\x63\154\x69\145\156\x74\x5f\143\165\163\164\x6f\155\x5f\x61\x74\x74\x72\x69\x62\x75\164\145\x5f\166\141\154\x75\145\x5f\61\x22" : "\40";
        echo "\x20\x74\171\160\145\x3d\x22\x74\145\170\x74\x22\40\160\x6c\x61\143\x65\150\x6f\x6c\x64\145\162\x3d\42\x45\x6e\164\x65\x72\x20\141\x74\x74\162\151\x62\x75\164\x65\40\156\x61\x6d\x65\x20\146\162\x6f\x6d\40\x4f\101\x75\164\x68\40\x50\162\x6f\x76\x69\144\145\x72\x22\x20\163\x74\171\x6c\x65\x3d\x22\x77\x69\x64\164\150\x3a\x37\64\45\73\x22\40\x20\x2f\76\74\x2f\x74\144\76";
        echo "\74\x2f\x74\x72\x3e";
        goto Fc;
        SE:
        $c5 = $v_["\x63\x75\x73\x74\x6f\x6d\137\x61\x74\x74\x72\x73\137\155\x61\x70\x70\151\156\x67"];
        $MC = 0;
        foreach ($c5 as $qV => $sw) {
            $MC++;
            echo "\x3c\x74\162\40\x63\154\x61\x73\163\x3d\42\162\x6f\x77\163\x22\x3e\x3c\x74\x64\x3e\74\151\x6e\x70\x75\164\x20" . $cb . "\x20\164\x79\160\x65\75\x22\x74\x65\x78\164\42\x20\x6e\x61\155\145\x3d\x22\x6d\157\137\157\141\x75\x74\150\x5f\x63\154\151\x65\x6e\164\137\x63\x75\x73\164\157\155\x5f\x61\x74\x74\x72\151\x62\165\x74\x65\137\153\145\171\137" . $MC . "\42\40\160\154\141\143\x65\x68\157\x6c\144\x65\162\x3d\x22\x45\x6e\164\145\x72\x20\x66\x69\x65\x6c\x64\x20\155\145\x74\x61\x20\156\141\155\145\x22\40\x20\x76\141\x6c\x75\145\75\x22" . $qV . "\x22\x20\x2f\x3e\74\57\x74\x64\x3e\x3c\x74\144\x3e\74\x69\156\160\165\x74\x20" . $cb;
            echo !$sC ? "\40\x6e\x61\x6d\x65\75\42\155\x6f\x5f\x6f\141\x75\x74\150\x5f\x63\x6c\x69\145\x6e\164\137\143\165\163\164\157\x6d\137\x61\164\x74\162\151\142\165\x74\x65\137\x76\x61\x6c\165\145\x5f" . $MC . "\x22" : "\x20";
            echo "\40\164\x79\x70\145\75\42\164\145\x78\164\42\x20\x70\154\141\143\145\x68\x6f\154\x64\x65\162\75\42\x45\156\164\145\162\x20\141\x74\164\x72\151\142\x75\x74\x65\x20\x6e\x61\155\145\x20\146\162\x6f\x6d\x20\x4f\101\x75\164\x68\x20\x50\162\157\x76\x69\144\145\162\x22\40\x73\x74\171\x6c\x65\75\42\167\151\144\x74\150\x3a\67\64\45\x3b\x22\x20\166\141\154\x75\145\75\x22" . $sw . "\42\40\57\x3e\74\57\164\x64\76\x3c\x2f\x74\x72\76";
            Oa:
        }
        ea:
        Fc:
        ?>
				<tr id="save_config_element">
					<td>&nbsp;</td>
					<td><input type="submit" name="submit" value="Save settings"
						class="button button-primary button-large" /></td>
				</tr>
				</table>
			</form>
			<?php 
        echo "\x3c\163\x63\x72\x69\x70\x74\76\xa\x9\x9\x9\11\166\141\162\40\x63\x6f\x75\x6e\164\x41\164\x74\162\x69\142\165\x74\x65\163\40\75\x20\x6a\x51\165\145\162\171\50\42\x23\141\x74\x74\x72\151\x62\x75\164\x65\155\x61\160\x70\x69\x6e\147\164\x61\x62\154\x65\x20\164\x72\x2e\162\x6f\167\163\42\51\x2e\x6c\145\x6e\147\164\150\x3b\12\x9\11\11\11\x66\165\x6e\x63\x74\151\157\156\x20\141\144\x64\x5f\143\x75\163\x74\157\x6d\137\x61\164\164\162\x69\x62\x75\164\x65\50\51\x7b\xa\11\11\x9\11\11\x63\x6f\x75\156\x74\x41\x74\x74\162\151\142\165\x74\x65\x73\40\53\75\x20\x31\x3b\12\11\11\x9\11\11\x72\x6f\x77\163\x20\x3d\x20\42\74\164\x72\40\151\x64\75\134\42\x72\x6f\x77\137\x22\40\x2b\143\x6f\165\156\164\x41\164\164\x72\x69\x62\x75\x74\x65\163\40\x2b\40\42\x5c\42\76\x3c\x74\x64\76\x3c\151\x6e\x70\165\164\x20\x74\171\x70\145\75\x5c\42\164\x65\x78\164\x5c\x22\40\x6e\141\x6d\x65\x3d\134\x22\155\x6f\137\x6f\x61\x75\x74\x68\137\143\154\x69\145\156\x74\x5f\143\165\x73\164\157\155\137\141\x74\x74\162\x69\x62\x75\164\145\x5f\x6b\145\171\x5f\42\40\x2b\x20\143\x6f\x75\156\x74\x41\x74\164\162\151\x62\x75\x74\x65\163\x20\53\40\x22\134\42\x20\151\144\75\x5c\x22\x6d\157\137\157\x61\x75\164\x68\x5f\143\154\x69\x65\156\164\x5f\x63\165\x73\x74\x6f\155\x5f\x61\x74\x74\x72\151\x62\165\164\145\x5f\153\x65\x79\137\42\x20\53\143\x6f\165\x6e\x74\x41\164\164\x72\x69\x62\165\x74\145\x73\40\53\40\42\x5c\42\x20\40\x70\x6c\141\143\x65\150\157\x6c\x64\x65\162\x3d\x5c\42\105\156\164\x65\x72\40\146\151\x65\x6c\144\40\x6d\145\x74\141\40\156\141\x6d\145\134\x22\x20\40\76\x3c\57\x74\144\x3e\74\164\144\76\74\151\156\x70\x75\x74\40\x74\x79\160\145\x3d\134\x22\164\145\x78\x74\x5c\42\40\156\141\155\145\x3d\134\42\x6d\x6f\x5f\x6f\x61\x75\164\x68\137\143\154\x69\x65\156\x74\137\143\165\x73\x74\157\155\137\x61\164\164\162\151\142\165\164\145\x5f\166\141\154\x75\145\x5f\42\40\x2b\x63\x6f\x75\156\164\x41\164\164\x72\x69\x62\165\164\x65\163\40\x2b\x20\x22\x5c\42\x20\x69\x64\75\134\42\155\157\x5f\157\141\x75\x74\150\137\x63\x6c\151\x65\156\x74\137\x63\165\x73\164\x6f\155\x5f\141\x74\164\x72\x69\x62\165\164\x65\x5f\166\x61\154\165\145\137\42\x20\53\x63\x6f\165\x6e\x74\101\x74\x74\162\x69\x62\x75\164\145\x73\x20\53\x20\x22\134\42\x20\160\154\x61\x63\x65\x68\x6f\154\x64\x65\162\75\134\x22\x45\x6e\164\145\x72\40\x41\164\164\x72\151\x62\165\x74\x65\x20\116\141\155\x65\40\x66\162\157\x6d\40\x4f\101\x75\x74\x68\x20\120\162\x6f\166\x69\144\x65\162\x5c\x22\40\x73\164\171\154\145\x3d\134\42\167\151\144\x74\x68\72\67\x34\x25\73\134\42\x20\x2f\x3e\74\57\x74\x64\76\74\x2f\164\x72\x3e\x22\73\12\xa\11\11\x9\x9\x9\x6a\121\165\145\x72\171\x28\x72\x6f\167\163\51\x2e\151\x6e\163\x65\x72\x74\x42\145\x66\x6f\162\x65\x28\152\x51\165\145\x72\x79\x28\42\x23\163\x61\166\145\x5f\x63\x6f\x6e\x66\151\147\137\145\x6c\145\155\145\156\x74\x22\51\51\x3b\12\11\11\11\11\175\xa\12\x9\x9\x9\x9\146\x75\x6e\x63\x74\x69\157\156\40\x72\x65\x6d\157\x76\145\137\x63\x75\163\164\157\x6d\x5f\141\x74\x74\162\151\x62\x75\x74\x65\50\51\173\xa\x9\11\11\x9\11\152\121\x75\145\x72\171\50\42\x23\x72\157\x77\x5f\x22\x20\x2b\x20\143\157\x75\x6e\x74\101\164\164\162\x69\142\165\164\145\163\x29\56\x72\x65\x6d\x6f\x76\145\50\x29\x3b\xa\11\11\11\x9\x9\x63\x6f\165\156\164\101\x74\x74\x72\x69\x62\165\x74\x65\x73\x20\x2d\75\40\61\73\12\11\11\11\11\11\151\146\x28\143\x6f\x75\x6e\x74\101\x74\164\162\x69\142\x75\x74\145\163\40\x3d\x3d\40\x30\x29\xa\11\11\x9\x9\x9\11\143\x6f\165\x6e\x74\101\164\x74\162\151\142\165\x74\145\x73\x20\75\40\61\73\xa\11\x9\11\x9\175\xa\11\x9\11\11\74\x2f\163\x63\x72\x69\x70\x74\76";
        ?>
			</div>
		<?php 
    }
    public function mo_oauth_client_rolemapping($v_, $gQ)
    {
        global $xW;
        $sC = !$xW->check_versi(2);
        $cb = $sC ? "\144\x69\x73\x61\142\154\145\x64\75\x22\x74\x72\x75\145\x22" : '';
        $Bh = $sC ? "\x72\x65\x71\x75\151\x72\145\144\75\42\x66\x61\154\x73\145\x22" : '';
        $v_["\x6b\x65\145\x70\137\145\170\151\x73\x74\151\156\x67\x5f\x75\163\145\162\137\x72\x6f\154\x65\163"] = isset($v_["\x6b\145\x65\x70\137\145\170\151\x73\x74\151\x6e\147\x5f\x75\x73\145\x72\137\162\x6f\x6c\145\x73"]) ? $v_["\153\x65\x65\160\137\x65\x78\151\163\x74\151\156\x67\x5f\165\x73\x65\162\137\162\157\154\x65\x73"] : 0;
        $v_["\x72\145\163\164\162\x69\143\164\137\x6c\157\147\x69\156\x5f\146\157\x72\137\155\141\x70\160\x65\x64\x5f\x72\157\x6c\x65\x73"] = isset($v_["\162\145\x73\164\162\151\x63\x74\137\x6c\x6f\x67\151\x6e\x5f\x66\157\x72\x5f\155\x61\x70\160\145\x64\137\162\x6f\154\145\x73"]) ? $v_["\162\x65\163\x74\162\151\143\164\x5f\154\x6f\x67\x69\x6e\x5f\x66\x6f\x72\137\x6d\141\x70\x70\145\x64\x5f\162\157\154\145\163"] : false;
        $v_["\137\155\141\x70\x70\x69\x6e\147\137\166\141\154\x75\145\137\x64\145\x66\x61\165\154\x74"] = isset($v_["\137\x6d\x61\160\160\x69\x6e\147\x5f\166\141\154\165\x65\x5f\x64\x65\x66\141\165\154\x74"]) ? $v_["\137\x6d\x61\160\x70\151\x6e\x67\x5f\x76\141\x6c\x75\145\137\144\x65\x66\x61\x75\x6c\164"] : false;
        $v_["\x72\157\154\x65\x5f\x6d\x61\160\x70\151\156\x67\137\143\x6f\x75\156\164"] = isset($v_["\162\157\x6c\x65\x5f\155\141\160\160\x69\x6e\147\x5f\x63\157\165\x6e\x74"]) ? $v_["\162\157\154\x65\137\x6d\x61\x70\x70\x69\x6e\147\x5f\x63\157\165\156\164"] : 0;
        $v_["\147\162\x6f\x75\160\x6e\141\x6d\145\x5f\141\164\164\x72\x69\142\x75\164\145"] = isset($v_["\x67\162\157\165\160\x6e\141\x6d\x65\x5f\141\164\164\x72\151\142\165\x74\145"]) ? $v_["\147\x72\x6f\165\160\156\141\x6d\145\x5f\141\164\x74\x72\151\x62\x75\x74\x65"] : '';
        ?>
		<div class="mo_table_layout" id="rolemapping">
		<div class="mo_oauth_client_small_layout" style="margin-top:0px;">
		<br><h3>Role Mapping (Optional)</h3>
		<?php 
        $tT = $v_["\147\x72\157\x75\x70\x6e\x61\155\x65\137\141\164\x74\162\151\142\x75\164\x65"];
        if (!empty($tT)) {
            goto Ff;
        }
        echo "\74\x70\40\x73\x74\x79\x6c\145\x3d\143\157\154\157\162\72\162\x65\x64\x3e\103\x6f\156\146\151\x67\x75\x72\x65\x20\x3c\163\x74\x72\x6f\156\x67\76\x47\x72\x6f\x75\x70\40\101\x74\164\162\x69\142\165\164\x65\40\116\x61\x6d\145\74\57\163\x74\x72\157\x6e\147\x3e\x20\x69\x6e\40\x61\164\164\x72\151\142\165\164\145\x20\x6d\x61\x70\160\x69\x6e\147\x20\x61\142\157\166\145\40\x74\x6f\x20\x65\x6e\x61\142\x6c\145\40\x72\x6f\x6c\x65\40\155\141\160\x70\x69\156\147\56\x3c\57\160\x3e";
        Ff:
        ?>
		<strong>NOTE: </strong>Role will be assigned only to non-admin users (user that do NOT have Administrator privileges). You will have to manually change the role of Administrator users.<br>
		<form id="role_mapping_form" name="f" method="post" action="">
			<input class="mo_table_textbox" required="" type="hidden"  name="mo_oauth_app_name" value="<?php 
        echo $gQ;
        ?>
">
			<input  type="hidden" name="option" value="mo_oauth_client_save_role_mapping" />
			<?php 
        wp_nonce_field("\x6d\157\x5f\x6f\x61\x75\x74\150\x5f\143\x6c\x69\x65\x6e\x74\x5f\x73\141\166\145\x5f\162\x6f\x6c\x65\137\x6d\141\x70\x70\151\x6e\x67", "\155\157\137\x6f\x61\165\x74\150\x5f\143\154\x69\145\156\x74\x5f\163\141\166\x65\137\162\x6f\x6c\145\137\155\x61\x70\160\151\x6e\x67\x5f\156\x6f\x6e\x63\x65");
        ?>
			<p><input type="checkbox"
			<?php 
        echo $cb;
        echo !$sC ? "\156\x61\155\x65\x3d\x22\153\145\x65\160\137\145\170\x69\163\164\x69\156\x67\137\x75\163\145\162\x5f\162\x6f\x6c\145\163\x22\x20\166\x61\154\165\x65\75\42\61\42\40" . checked(intval($v_["\153\145\145\x70\137\x65\x78\151\x73\x74\x69\x6e\147\x5f\165\163\x65\x72\137\162\x6f\154\x65\x73"]) === 1) . "\42\x20" : "\40";
        ?>
			/><strong> Keep existing user roles</strong> <?php 
        echo $sC ? "\46\145\x6d\163\160\73\74\163\155\141\x6c\154\40\x63\x6c\141\163\163\75\42\155\x6f\137\x70\162\x65\155\151\165\x6d\137\x66\145\141\164\x75\162\x65\x22\x3e\x5b\x50\x52\x45\x4d\111\125\115\135\74\57\x73\155\141\x6c\154\x3e" : '';
        ?>
 <br><small>Role mapping won't apply to existing WordPress users.</small></p>
			<p><input type="checkbox"
			<?php 
        echo $cb;
        echo !$sC ? "\156\x61\155\x65\75\42\x72\145\163\x74\x72\151\x63\164\x5f\x6c\157\147\x69\x6e\x5f\x66\157\x72\x5f\x6d\x61\x70\x70\145\x64\137\x72\x6f\x6c\145\x73\42\40\166\x61\154\x75\145\75\x22\164\162\x75\x65\x22\x20" . checked(boolval($v_["\x72\145\x73\x74\x72\x69\x63\x74\137\x6c\157\147\x69\156\x5f\x66\157\162\x5f\x6d\x61\x70\160\145\x64\x5f\162\157\154\x65\x73"]) === true) . "\x22\x20" : "\x20";
        ?>
			/><strong> Do Not allow login if roles are not mapped here </strong><?php 
        echo $sC ? "\46\x65\x6d\163\160\73\x3c\163\x6d\x61\154\154\40\143\x6c\141\x73\x73\x3d\42\x6d\157\x5f\x70\162\x65\155\151\165\x6d\x5f\146\x65\x61\164\165\x72\x65\42\x3e\x5b\120\x52\x45\115\111\125\x4d\x5d\x3c\57\163\155\x61\154\x6c\x3e" : '';
        ?>
</p><small>We won't allow users to login if we don't find users role/group mapped below.</small></p>

			<div id="panel1">
				<table class="mo_oauth_client_mapping_table" id="mo_oauth_client_role_mapping_table" style="width:90%">
						<tr><td>&nbsp;</td></tr>
						<tr>
						<td><span style="font-size:13px;font-weight:bold;">Default Role </span>
						</td>
						<td>
							<select name="mapping_value_default" style="width:100%" id="default_group_mapping" <?php 
        echo $v_["\162\x65\163\x74\x72\x69\x63\x74\137\154\x6f\147\151\156\137\x66\x6f\162\137\x6d\x61\160\160\145\144\x5f\x72\157\x6c\x65\163"] ? "\x64\x69\x73\141\142\x6c\145\144\x3d\42\164\x72\x75\145\42" : "\40";
        ?>
>
							<?php 
        $Kr = $v_["\x5f\x6d\x61\x70\x70\151\156\147\137\x76\141\154\165\145\137\144\145\146\x61\165\154\x74"] ? $v_["\137\x6d\x61\x70\160\151\x6e\147\x5f\166\141\154\x75\x65\x5f\x64\x65\x66\x61\165\154\x74"] : $xW->mo_oauth_client_get_option("\144\x65\x66\141\x75\x6c\x74\137\x72\x6f\154\x65");
        wp_dropdown_roles($Kr);
        ?>
							</select>
							<select style="display:none" id="wp_roles_list">
							<?php 
        wp_dropdown_roles($Kr);
        ?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan=2><em> Default role will be assigned to all users for which mapping is not specified.</em></td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td style="width:50%"><strong>Group Attribute Value</strong><?php 
        echo $sC ? "\x26\x65\155\163\160\73\x3c\163\155\x61\154\x6c\x20\143\x6c\141\163\163\x3d\x22\x6d\x6f\x5f\160\162\145\x6d\x69\165\x6d\137\146\145\141\x74\165\162\145\42\76\x5b\x50\x52\x45\115\111\x55\115\135\74\57\163\x6d\x61\154\154\76" : '';
        ?>
</td>
						<td style="width:50%"><strong>WordPress Role</strong></td>
					</tr>

					<?php 
        $Xq = is_numeric($v_["\162\157\154\145\x5f\x6d\141\160\160\151\x6e\147\137\143\x6f\165\156\x74"]) ? intval($v_["\162\157\154\x65\x5f\x6d\141\160\x70\151\156\x67\x5f\x63\157\x75\156\164"]) : 1;
        $MC = 1;
        II:
        if (!($MC <= $Xq)) {
            goto gr;
        }
        ?>
					<tr>
						<td><input class="mo_oauth_client_table_textbox" type="text" name="mapping_key_<?php 
        echo wp_kses($MC, \get_valid_html());
        ?>
"
							value="<?php 
        echo isset($v_["\x5f\155\141\160\x70\x69\x6e\x67\x5f\x6b\145\x79\137" . $MC]) ? $v_["\137\x6d\x61\160\160\x69\156\147\x5f\153\145\171\137" . $MC] : '';
        ?>
"  placeholder="group name"  />
						</td>
						<td>
							<select name="mapping_value_<?php 
        echo wp_kses($MC, \get_valid_html());
        ?>
" id="role" style="width:100%" >
							<?php 
        wp_dropdown_roles(isset($v_["\x5f\x6d\x61\x70\x70\151\156\147\137\166\141\x6c\x75\145\137" . $MC]) ? $v_["\x5f\155\x61\160\160\151\x6e\x67\137\166\x61\x6c\165\145\137" . $MC] : '');
        ?>
							</select>
						</td>
					</tr>
						<?php 
        Ep:
        $MC++;
        goto II;
        gr:
        if (!(0 === $Xq)) {
            goto OX;
        }
        ?>
					<tr>
						<td><input class="mo_oauth_client_table_textbox" type="text"
							<?php 
        echo $cb;
        echo !$sC ? "\40\156\x61\x6d\145\75\x22\x6d\141\160\160\x69\156\x67\137\153\145\x79\x5f\61\42\x20\x76\141\154\165\x65\x3d\x22\x22" : "\x20";
        ?>
							placeholder="group name" />
						</td>
						<td>
							<select style="width:100%"
							<?php 
        echo $cb;
        echo !$sC ? "\40\x6e\x61\x6d\x65\x3d\x22\x6d\x61\160\x70\151\156\147\137\x76\141\154\165\x65\x5f\61\42\x20\151\x64\75\x22\x72\x6f\x6c\145\x22" : "\x20";
        ?>
							>
							<?php 
        wp_dropdown_roles();
        ?>
							</select>
						</td>
					</tr>
						<?php 
        OX:
        ?>
					</table>
					<table class="mo_oauth_client_mapping_table" style="width:90%;">
						<tr><td><a style="cursor:pointer" id="add_mapping">Add More Mapping</a><br><br></td><td>&nbsp;</td></tr>
						<tr>
							<td><input type="submit" class="button button-primary button-large" value="Save Mapping" /></td>
							<td>&nbsp;</td>
						</tr>
					</table>
					</div>
				</form>
			</div>
		</div>
		<script>
			jQuery( document ).ready(function() {
				jQuery("#default_group_mapping option[value='administrator']").remove();
				<?php 
        if (!empty($tT)) {
            goto PW;
        }
        ?>
				jQuery("#rolemapping :input").prop("disabled", true);
				<?php 
        PW:
        ?>

			});

			jQuery('#add_mapping').click(function() {
				var last_index_name = jQuery('#mo_oauth_client_role_mapping_table tr:last .mo_oauth_client_table_textbox').attr('name');
				var splittedArray = last_index_name.split("_");
				var last_index = parseInt(splittedArray[splittedArray.length-1])+1;
				var dropdown = jQuery("#wp_roles_list").html();
				var new_row = '<tr><td><input class="mo_oauth_client_table_textbox" type="text" placeholder="group name" name="mapping_key_'+last_index+'" value="" /></td><td><select name="mapping_value_'+last_index+'" style="width:100%" id="role">'+dropdown+'</select></td></tr>';
				jQuery('#mo_oauth_client_role_mapping_table tr:last').after(new_row);
			});

		</script>
		<?php 
    }
}
