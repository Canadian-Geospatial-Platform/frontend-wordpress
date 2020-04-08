<?php


namespace MoOauthClient;

class Support
{
    public static function support()
    {
        self::support_page();
    }
    private static function support_page()
    {
        global $xW;
        ?>
		<div id="mo_support_layout" class="mo_support_layout">
			<div>
				<h3>Contact Us</h3>
				<p>Need any help? Couldn't find an answer in <a href="<?php 
        echo add_query_arg(array("\164\x61\142" => "\x66\x61\x71"), $_SERVER["\x52\105\121\125\x45\x53\124\x5f\x55\x52\111"]);
        ?>
">FAQ</a>?<br>Just send us a query so we can help you.</p>
				<form method="post" action="">
					<input type="hidden" name="option" value="mo_oauth_contact_us_query_option" />
					<?php 
        wp_nonce_field("\x6d\157\137\x6f\x61\x75\x74\x68\x5f\143\x6f\x6e\164\x61\x63\164\x5f\x75\x73\137\x71\x75\x65\x72\171\x5f\157\x70\x74\151\x6f\156", "\155\x6f\137\157\x61\165\x74\150\x5f\143\x6f\x6e\164\x61\x63\164\137\165\x73\137\x71\x75\145\x72\x79\x5f\157\x70\164\151\x6f\x6e\137\156\157\x6e\143\x65");
        ?>
					<table class="mo_settings_table">
						<tr>
							<td><input type="email" class="mo_table_textbox" required name="mo_oauth_contact_us_email" placeholder="Enter email here"
							value="<?php 
        echo wp_kses($xW->mo_oauth_client_get_option("\155\157\137\157\141\165\x74\x68\137\x61\144\x6d\x69\156\137\x65\x6d\x61\x69\x6c"), \get_valid_html());
        ?>
"></td>
						</tr>
						<tr>
							<td><input type="tel" id="contact_us_phone" pattern="[\+]\d{11,14}|[\+]\d{1,4}[\s]\d{9,10}" placeholder="Enter phone here" class="mo_table_textbox" name="mo_oauth_contact_us_phone" value="<?php 
        echo wp_kses($xW->mo_oauth_client_get_option("\x6d\157\x5f\x6f\141\165\164\150\x5f\141\144\x6d\151\x6e\x5f\160\x68\157\x6e\x65"), \get_valid_html());
        ?>
"></td>
						</tr>
						<tr>
							<td><textarea class="mo_table_textbox" onkeypress="mo_oauth_valid_query(this)" placeholder="Enter your query here" onkeyup="mo_oauth_valid_query(this)" onblur="mo_oauth_valid_query(this)" required name="mo_oauth_contact_us_query" rows="4" style="resize: vertical;"></textarea></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="mo_oauth_send_plugin_config" id="mo_oauth_send_plugin_config" checked>&nbsp;Send Plugin Configuration</td>
						</tr>
						<tr>
							<td><small style="color:#666">We will not be sending your Client IDs or Client Secrets.</small></td>
						</tr>
					</table>
					<div style="text-align:left;">
						<input type="submit" name="submit" style="margin-top:15px; width:100px;" class="button button-primary button-large" />
					</div>
					<p>If you want custom features in the plugin, just drop an email at <a href="mailto:info@miniorange.com">info@miniorange.com</a>.</p>
				</form>
			</div>
		</div>
		<script>
			jQuery("#contact_us_phone").intlTelInput();
			function mo_oauth_valid_query(f) {
				!(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(
						/[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;
			}
		</script>
		<?php 
    }
}
