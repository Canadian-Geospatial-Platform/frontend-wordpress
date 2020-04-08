<?php


namespace MoOauthClient\Paid;

use MoOauthClient\Accounts as CommonAccounts;
class Accounts extends CommonAccounts
{
    public function mo_oauth_lp()
    {
        $tY = isset($_POST["\x6d\157\137\x6f\141\x75\x74\x68\137\x63\154\151\x65\156\164\137\x6c\x69\143\x65\x6e\163\145\x5f\x6b\x65\x79"]) ? $_POST["\x6d\157\x5f\x6f\141\165\x74\x68\137\x63\154\151\x65\x6e\164\x5f\x6c\x69\x63\145\156\163\145\137\153\x65\171"] : '';
        ?>
		<div class="mo_table_layout">
		<br>
			<h3>Verify your license</h3>
			<form name="f" method="post" action="">
				<input type="hidden" name="option" value="mo_oauth_client_verify_license" />
				<?php 
        wp_nonce_field("\x6d\x6f\x5f\157\x61\165\x74\x68\x5f\143\154\x69\145\x6e\x74\137\166\x65\162\x69\x66\171\137\154\x69\x63\x65\156\163\145", "\155\157\137\x6f\141\165\x74\x68\x5f\143\154\x69\145\156\x74\137\166\145\162\x69\x66\x79\x5f\x6c\151\143\145\156\163\x65\137\156\157\156\143\x65");
        ?>
				<table class="mo_settings_table">
					<tr>
					<td><strong><span class="mo_premium_feature">*</span>License Key:</strong></td>
					<td><input class="mo_table_textbox" required type="text" name="mo_oauth_client_license_key" placeholder="Enter your license key to activate the plugin" value="<?php 
        echo $tY;
        ?>
" /></td>
					</tr>
					<tr><td>&nbsp;</td><td></td></tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<input type="submit" name="submit" value="Activate License" class="button button-primary button-large" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</form>
							
							<input type="button" name="change-account-button" id="mo_oauth_change_account_button" onclick="document.getElementById('mo_oauth_goto_login_form').submit();" value="Back" class="button button-primary button-large" />

							<form name="f1" method="post" action="" id="mo_oauth_goto_login_form">
								<input type="hidden" value="change_miniorange" name="option"/>
								<?php 
        wp_nonce_field("\143\x68\x61\x6e\x67\145\x5f\x6d\x69\156\151\157\162\x61\x6e\147\x65", "\x63\150\141\156\147\145\x5f\155\x69\x6e\151\x6f\x72\x61\x6e\x67\x65\137\156\157\x6e\143\145");
        ?>
							</form>
						</td>
					</tr>
					<tr><td>&nbsp;</td><td></td></tr>
					<tr><td>&nbsp;</td><td></td></tr>
				</table>
		</div>
		<?php 
    }
}
