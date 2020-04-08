<?php


global $xW;
function mo_oauth_client_render_grant_settings($v_, $gQ)
{
    $Fm = isset($v_["\x6a\167\x74\137\x73\165\x70\x70\x6f\x72\164"]) ? $v_["\152\x77\164\x5f\x73\x75\x70\x70\157\162\164"] : 1;
    $n8 = isset($v_["\x6a\167\x74\137\x61\154\147\157"]) ? $v_["\x6a\167\164\x5f\x61\154\x67\157"] : "\110\123\x41";
    $Yx = isset($v_["\x78\x35\60\71\x5f\143\145\x72\x74"]) ? $v_["\x78\x35\x30\71\x5f\143\145\x72\164"] : '';
    $Pf = "\163\x65\154\145\143\164\145\144";
    $Zk = "\x6a\167\x6b\163\137\165\x72\151";
    ?>
	<div class="mo_table_layout" id="grant_settings">
		<form name="form-common" id="multipurpose-form" method="post" action="admin.php?page=mo_oauth_settings">
			<input type="hidden" name="option" value="mo_oauth_grant_settings" />
			<?php 
    wp_nonce_field("\x6d\x6f\137\x6f\141\165\x74\150\137\147\x72\x61\x6e\x74\137\163\x65\164\x74\x69\x6e\147\163", "\x6d\x6f\x5f\x6f\x61\x75\164\150\137\147\162\141\156\x74\137\x73\145\164\x74\151\x6e\147\163\x5f\156\157\156\143\x65");
    ?>
			<input required="" type="hidden" id="mo_oauth_app_name2" name="mo_oauth_app_name" value="<?php 
    echo $gQ;
    ?>
">
			<h3>Advanced Grant Type Configuration</h3>
				<div id="implicit-grant-settings">
					<table class="mo_settings_table" id="granttypetable">
						<tr>
							<td><strong>Enable JWT Verification:</strong></td>
							<td><input id="jwt_support" onclick="toggle_jwt(this)" type="checkbox" name="jwt_support" value="" <?php 
    echo 1 === $Fm ? "\143\150\145\143\153\x65\144" : '';
    ?>
 /></td>
						</tr>
						<tr>
							<td><strong>JWT Signing Algorithm:</strong></td>
							<td><select onclick="selectAlgo(this)" id="jwt_algo" <?php 
    echo 1 === $Fm ? '' : "\x64\x69\163\x61\142\x6c\145\144";
    ?>
 name="jwt_algo">
									<option <?php 
    echo wp_kses("\x48\123\101" === $n8 ? $Pf : '', get_valid_html());
    ?>
>HSA</option>
									<option <?php 
    echo wp_kses("\122\x53\x41" === $n8 ? $Pf : '', get_valid_html());
    ?>
>RSA</option>
								</select>
							</td>
						</tr>
						<tr <?php 
    echo "\x52\123\101" !== $n8 ? "\150\x69\x64\x64\145\156" : '';
    ?>
 id="x509_cert">
							<td>
								<strong>
									<span id='req-star' class="mo_premium_feature">
										<?php 
    echo "\122\x53\101" === $n8 && (isset($v_[$Zk]) && '' === $v_[$Zk]) ? "\x2a" : '';
    ?>
									</span>X509 Certificate:
								</strong>
							</td>
							<td>
								<textarea id="rsa_cert" style="resize:none;" <?php 
    echo "\x52\x53\101" === $n8 && (isset($v_[$Zk]) && '' === $v_[$Zk]) ? "\x72\x65\161\165\151\162\x65\x64" : '';
    ?>
 rows="10" cols="50" name="mo_oauth_x509_cert"><?php 
    echo $Yx;
    ?>
</textarea>
							</td>
						</tr>
					</table>
				</div>
			<br><br>
			<input type="submit" name="submit" value="Save settings" class="button button-primary button-large" style="margin: 10px;" />
		</form>
	</div>
		<script>
			function toggle_jwt(element) {
				if(element.checked) {
					document.getElementById("jwt_algo").disabled = false;
				} else {
					document.getElementById("jwt_algo").disabled = true;
				}
			}

			function selectAlgo(element) {
				var algo = element.options[element.selectedIndex].text;
				if(algo === "RSA") {
					document.getElementById("x509_cert").hidden = false;
					document.getElementById("req-star").innerHTML = "*";
					if(document.getElementById("mo_oauth_jwksurl").value === "") {
						document.getElementById("rsa_cert").required = true;
					} else {
						document.getElementById("req-star").hidden = true;
					}
					document.getElementById("rsa_cert").disabled = false;
					document.getElementById("rsa_cert").value = "";
					document.getElementById("jwt_algo").disabled = false;
				} else {
					document.getElementById("x509_cert").hidden = true;
					document.getElementById("rsa_cert").required = false;
					document.getElementById("rsa_cert").value = "";
					document.getElementById("req-star").innerHTML = "";
				}
			}
			if(document.getElementById("mo_oauth_jwksurl").value === "") {
				document.getElementById("rsa_cert").required = true;
			} else {
				document.getElementById("req-star").hidden = true;
				document.getElementById("rsa_cert").required = false;
			}
		</script>

		<?php 
}
add_action("\155\x6f\137\x6f\141\165\164\150\x5f\143\154\x69\x65\156\164\137\x67\162\x61\156\164\x5f\163\x65\164\164\x69\x6e\147\163\x5f\x69\156\x74\x65\x72\156\141\154", "\155\157\137\x6f\141\165\164\x68\137\x63\154\151\x65\x6e\164\x5f\162\x65\156\144\x65\162\x5f\x67\x72\x61\156\164\137\x73\145\164\164\151\x6e\x67\x73", 10, 2);
function add_grant_type_dd($v_)
{
    global $xW;
    $H5 = isset($v_["\147\162\141\156\x74\x5f\164\x79\160\x65"]) ? $v_["\147\x72\x61\x6e\164\x5f\164\x79\160\145"] : "\x41\165\x74\150\x6f\162\151\172\141\x74\151\x6f\x6e\40\x43\x6f\144\x65\x20\x47\x72\141\156\x74";
    $Pf = "\163\x65\154\x65\x63\164\x65\144";
    ?>
	<tr>
		<td><strong>Grant Type:</strong><br></td>
		<td><select id="grant_type" name="grant_type">
				<option <?php 
    echo wp_kses("\101\165\x74\x68\157\x72\151\172\141\x74\151\x6f\x6e\x20\103\157\144\145\x20\x47\x72\x61\x6e\x74" === $H5 ? $Pf : '', get_valid_html());
    ?>
>Authorization Code Grant</option>
				<option <?php 
    echo wp_kses("\x49\x6d\160\154\x69\x63\x69\164\x20\x47\x72\x61\x6e\164" === $H5 ? $Pf : '', get_valid_html());
    ?>
>Implicit Grant</option>
				<option <?php 
    echo wp_kses("\120\141\x73\x73\167\x6f\162\x64\x20\x47\162\x61\156\164" === $H5 ? $Pf : '', get_valid_html());
    ?>
>Password Grant</option>
			</select>
		</td>
	</tr>
	<?php 
    $ux = $xW->mo_oauth_client_get_option("\x6d\x6f\137\157\x61\165\164\150\137\145\x6e\x61\x62\x6c\145\137\x6f\141\x75\164\x68\137\167\160\x5f\x6c\157\147\x69\156");
    $ux = $ux && $v_["\x61\x70\160\x49\144"] === $ux;
    if (!("\120\x61\x73\x73\167\157\162\x64\x20\x47\162\x61\156\164" === $H5)) {
        goto Xn;
    }
    ?>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" <?php 
    echo $ux ? "\143\150\145\x63\x6b\145\x64" : '';
    ?>
 name="enable_oauth_wp_login" id="enable_oauth_wp_login">&nbsp;<strong>Check this if you want to allow users to login through default WordPress Login form.</strong></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<?php 
    Xn:
}
add_action("\155\x6f\137\157\x61\x75\164\x68\137\143\154\151\145\x6e\164\x5f\147\x72\141\156\164\137\144\144\137\151\x6e\x74\x65\x72\156\x61\154", "\141\x64\144\137\147\x72\x61\x6e\x74\137\164\171\x70\145\x5f\x64\144", 10, 1);
