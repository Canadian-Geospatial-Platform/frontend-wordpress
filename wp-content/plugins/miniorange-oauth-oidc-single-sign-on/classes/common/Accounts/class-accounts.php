<?php


namespace MoOauthClient;

use MoOauthClient\Accounts\AccountsInterface;
class Accounts implements AccountsInterface
{
    public function register()
    {
        global $xW;
        if ($xW->mo_oauth_is_customer_registered()) {
            goto BX;
        }
        if ($xW->get_versi() === 0) {
            goto b8;
        }
        self::verify_password_ui();
        goto dP;
        BX:
        self::show_customer_info();
        goto dP;
        b8:
        self::mo_oauth_show_new_registration_page();
        dP:
    }
    public function mo_oauth_show_new_registration_page()
    {
        global $xW;
        $xW->mo_oauth_client_update_option("\x6e\x65\x77\x5f\162\x65\x67\151\163\x74\x72\x61\x74\x69\x6f\x6e", "\164\x72\x75\x65");
        $current_user = wp_get_current_user();
        ?>
		<!--Register with miniOrange-->
		<form name="f" method="post" action="">
			<input type="hidden" name="option" value="mo_oauth_register_customer" />
			<?php 
        wp_nonce_field("\155\157\137\x6f\x61\165\x74\x68\x5f\162\145\147\x69\163\164\x65\x72\x5f\143\165\x73\x74\157\x6d\x65\x72", "\x6d\157\x5f\157\141\165\164\x68\x5f\x72\x65\147\x69\x73\164\x65\162\137\143\165\163\164\157\155\x65\162\x5f\156\157\156\143\145");
        ?>
			<div class="mo_table_layout">
				<div id="toggle1" class="panel_toggle">
					<h3>Register with miniOrange</h3>
				</div>
				<div id="panel1">
					<!--<p><strong>Register with miniOrange</strong></p>-->
					<p>Please enter a valid Email ID that you have access to.
					</p>
					<table class="mo_settings_table">
						<tr>
							<td><strong><span class="mo_premium_feature">*</span>Email:</strong></td>
							<td><input class="mo_table_textbox" type="email" name="email"
								required placeholder="person@example.com"
								value="<?php 
        echo wp_kses($xW->mo_oauth_client_get_option("\x6d\x6f\137\x6f\141\165\x74\150\x5f\141\x64\x6d\x69\156\137\145\x6d\141\x69\154"), \get_valid_html());
        ?>
" />
							</td>
						</tr>
						<tr class="hidden">
							<td><strong><span class="mo_premium_feature">*</span>Website/Company Name:</strong></td>
							<td><input class="mo_table_textbox" type="text" name="company"
							required placeholder="Enter website or company name"
							value="<?php 
        echo wp_kses(isset($_SERVER["\x53\x45\122\x56\105\122\137\x4e\x41\115\105"]) ? sanitize_text_field(wp_unslash($_SERVER["\123\105\x52\x56\105\122\137\116\101\x4d\105"])) : '', \get_valid_html());
        ?>
"/></td>
						</tr>
						<tr  class="hidden">
							<td><strong>&nbsp;&nbsp;First Name:</strong></td>
							<td><input class="mo_openid_table_textbox" type="text" name="fname"
							placeholder="Enter first name" value="<?php 
        echo wp_kses($current_user->user_firstname, \get_valid_html());
        ?>
" /></td>
						</tr>
						<tr class="hidden">
							<td><strong>&nbsp;&nbsp;Last Name:</strong></td>
							<td><input class="mo_openid_table_textbox" type="text" name="lname"
							placeholder="Enter last name" value="<?php 
        echo wp_kses($current_user->user_lastname, \get_valid_html());
        ?>
?>" /></td>
						</tr>

						<tr  class="hidden">
							<td><strong>&nbsp;&nbsp;Phone number :</strong></td>
							<td><input class="mo_table_textbox" type="text" name="phone" pattern="[\+]?([0-9]{1,4})?\s?([0-9]{7,12})?" id="phone" title="Phone with country code eg. +1xxxxxxxxxx" placeholder="Phone with country code eg. +1xxxxxxxxxx" value="<?php 
        echo wp_kses($xW->mo_oauth_client_get_option("\155\157\x5f\x6f\141\165\x74\150\x5f\x61\x64\155\151\x6e\x5f\160\x68\x6f\156\x65"), \get_valid_html());
        ?>
" />
							This is an optional field. We will contact you only if you need support.</td>
							</tr>
						</tr>
						<tr  class="hidden">
							<td></td>
							<td>We will call only if you need support.</td>
						</tr>
						<tr>
							<td><strong><span class="mo_premium_feature">*</span>Password:</strong></td>
							<td><input class="mo_table_textbox" required type="password"
								name="password" placeholder="Choose your password (Min. length 8)" /></td>
						</tr>
						<tr>
							<td><strong><span class="mo_premium_feature">*</span>Confirm Password:</strong></td>
							<td><input class="mo_table_textbox" required type="password"
								name="confirmPassword" placeholder="Confirm your password" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><br /><input type="submit" name="submit" value="Save" style="width:100px;"
								class="button button-primary button-large" /></td>
						</tr>
					</table>
				</div>
			</div>
		</form>
		<script>
			jQuery("#phone").intlTelInput();
		</script>
		<?php 
    }
    public function verify_password_ui()
    {
        global $xW;
        ?>
		<form name="f" method="post" action="">
			<input type="hidden" name="option" value="mo_oauth_verify_customer" />
			<?php 
        wp_nonce_field("\x6d\x6f\x5f\157\x61\165\164\x68\137\x76\x65\162\151\x66\x79\x5f\x63\x75\x73\x74\x6f\x6d\x65\x72", "\x6d\x6f\137\157\x61\165\x74\150\x5f\x76\x65\162\151\x66\x79\x5f\x63\x75\163\x74\157\x6d\145\162\137\156\157\x6e\x63\x65");
        ?>
			<div class="mo_table_layout">
				<div id="toggle1" class="mo_panel_toggle">
					<h3>Login with miniOrange</h3>
				</div>
				<p><strong>It seems you already have an account with miniOrange. Please enter your miniOrange email and password.<br/> <a href="#mo_oauth_forgot_password_link">Click here if you forgot your password?</a></strong></p>

				<div id="panel1">
					</p>
					<table class="mo_settings_table">
						<tr>
							<td><strong><span class="mo_premium_feature">*</span>Email:</strong></td>
							<td><input class="mo_table_textbox" type="email" name="email"
								required placeholder="person@example.com"
								value="<?php 
        echo wp_kses($xW->mo_oauth_client_get_option("\x6d\157\x5f\x6f\x61\165\x74\x68\x5f\x61\144\155\x69\156\x5f\145\155\141\151\154"), \get_valid_html());
        ?>
" /></td>
						</tr>
						<td><strong><span class="mo_premium_feature">*</span>Password:</strong></td>
						<td><input class="mo_table_textbox" required type="password"
							name="password" placeholder="Choose your password" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" name="submit"
								class="button button-primary button-large" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</form>

								<input type="button" name="back-button" id="mo_oauth_back_button" onclick="document.getElementById('mo_oauth_change_email_form').submit();" value="Back" class="button button-primary button-large" />

								<form id="mo_oauth_change_email_form" method="post" action="">
									<input type="hidden" name="option" value="mo_oauth_change_email" />
									<?php 
        wp_nonce_field("\155\x6f\137\x6f\x61\x75\x74\x68\x5f\143\150\x61\x6e\x67\145\137\x65\x6d\141\x69\154", "\155\x6f\137\157\x61\x75\164\150\137\x63\150\141\156\x67\x65\x5f\x65\155\x61\x69\x6c\137\x6e\157\x6e\x63\145");
        ?>
								</form></td>
							</td>
						</tr>
					</table>
				</div>
			</div>

		<!-- <form name="f" method="post" action="" id="mo_oauth_forgotpassword_form">
			<input type="hidden" name="option" value="mo_oauth_forgot_password_form_option"/>
			<?php 
        ?>
		</form> -->
		<script>
			jQuery("a[href=\"#mo_oauth_forgot_password_link\"]").click(function(){
				window.open('https://login.xecurify.com/moas/idp/resetpassword');
				//jQuery("#mo_oauth_forgotpassword_form").submit();
			});
		</script>

		<?php 
    }
    public function show_customer_info()
    {
        global $xW;
        ?>
		<div class="mo_table_layout" >
			<h2>Thank you for registering with miniOrange.</h2>
			<table border="1" style="background-color:#FFFFFF; border:1px solid #CCCCCC; border-collapse: collapse; padding:0px 0px 0px 10px; margin:2px; width:85%">
			<tr>
				<td style="width:45%; padding: 10px;">miniOrange Account Email</td>
				<td style="width:55%; padding: 10px;"><?php 
        echo wp_kses($xW->mo_oauth_client_get_option("\155\157\x5f\x6f\x61\165\x74\x68\137\x61\144\x6d\x69\x6e\137\x65\x6d\x61\x69\x6c"), \get_valid_html());
        ?>
</td>
			</tr>
			<tr>
				<td style="width:45%; padding: 10px;">Customer ID</td>
				<td style="width:55%; padding: 10px;"><?php 
        echo wp_kses($xW->mo_oauth_client_get_option("\x6d\157\x5f\x6f\141\165\x74\x68\x5f\141\144\155\x69\156\x5f\143\x75\x73\x74\x6f\155\145\162\x5f\153\x65\x79"), \get_valid_html());
        ?>
</td>
			</tr>
			</table>
			<br /><br />

		<table>
		<tr>
		<td>
		<form name="f1" method="post" action="" id="mo_oauth_goto_login_form">
			<input type="hidden" value="change_miniorange" name="option"/>
			<?php 
        wp_nonce_field("\x63\x68\x61\x6e\x67\x65\x5f\155\151\156\151\157\x72\141\156\x67\x65", "\x63\x68\x61\156\x67\145\x5f\155\x69\x6e\151\157\x72\x61\156\147\x65\x5f\156\x6f\x6e\x63\x65");
        ?>
			<input type="submit" value="Change Account" class="button button-primary button-large"/>
		</form>
		</td><td>
		<a href="<?php 
        echo wp_kses(add_query_arg(array("\x74\x61\x62" => "\154\151\x63\x65\156\x73\151\156\x67"), htmlentities(sanitize_text_field(wp_unslash(isset($_SERVER["\122\x45\121\x55\105\123\x54\137\125\x52\x49"]) ? $_SERVER["\x52\105\121\125\x45\x53\x54\x5f\125\x52\x49"] : '')))), \get_valid_html());
        ?>
"><input type="button" class="button button-primary button-large" value="Check Licensing Plans"/></a>
		</td>
		</tr>
		</table>
		<br />
		</div>
		<?php 
    }
}
