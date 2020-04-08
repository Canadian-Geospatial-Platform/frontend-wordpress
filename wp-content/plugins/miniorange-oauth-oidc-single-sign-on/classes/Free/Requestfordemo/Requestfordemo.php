<?php


namespace MoOauthClient\Free;

use MoOauthClient\Free\RequestForDemoInterface;
class Requestfordemo implements RequestForDemoInterface
{
    private $versi;
    public function __construct()
    {
        $this->versi = VERSION;
    }
    public function render_free_ui()
    {
        global $xW;
        ?>
		<div id="mo_oauth_requestdemo" class="mo_table_layout mo_oauth_app_requestdemo <?php 
        echo $g6;
        ?>
">
		<form id="form-common" name="form-common" method="post" action="admin.php?page=mo_oauth_settings&tab=requestfordemo">
			<input type="hidden" name="option" value="mo_oauth_app_requestdemo" />
			<?php 
        wp_nonce_field("\155\x6f\137\x6f\x61\x75\164\x68\x5f\x61\x70\x70\x5f\162\x65\x71\x75\x65\x73\x74\144\x65\155\157", "\x6d\157\x5f\157\x61\x75\164\150\x5f\141\160\x70\137\162\145\161\165\x65\x73\x74\x64\145\155\157\x5f\156\157\156\143\145");
        ?>
			<h2>Customize Icons</h2>
			<table class="mo_settings_table" cellpadding="4" cellspacing="4">
				<tr>
					<td><strong>Email : </strong></td>
					<td><input required type="text" style="<?php 
        echo $JL;
        ?>
" name="mo_oauth_client_demo_email" placeholder="Email for demo setup" value="<?php 
        echo get_option("\155\x6f\137\x6f\141\x75\x74\150\137\x61\x64\155\x69\x6e\x5f\x65\155\x61\x69\x6c");
        ?>
" /></td>
				</tr>
				<tr>
					<td><strong>Request a demo for : </strong></td>
					<td>
						<select required style="<?php 
        echo $JL;
        ?>
" name="mo_oauth_client_demo_plan" id="mo_oauth_client_demo_plan_id" onclick="moOauthClientAddDescriptionjs()">
							<option disabled selected>------------------ Select ------------------</option>
							<option value="WP OAuth Client Standard Plugin">WP OAuth Client Standard Plugin</option>
							<option value="WP OAuth Client Premium Plugin">WP OAuth Client Premium Plugin</option>
							<option value="WP OAuth Client Enterprise Plugin">WP OAuth Client Enterprise Plugin</option>
							<option value="Not Sure">Not Sure</option>
						</select>
					</td>
				</tr>
				<tr id="demoDescription" style="display:none;">
					<td><strong>Description : </strong></td>
					<td>
						<textarea type="text" name="mo_oauth_client_demo_description" style="resize: vertical; width:350px; height:100px;" rows="4" placeholder="Need assistance? Write us about your requirement and we will suggest the relevant plan for you." value="<?php 
        isset($A4);
        ?>
" /></textarea>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" name="submit" value="Submit Demo Request" class="button button-primary button-large" /></td>
				</tr>
			</table>
		</form>
		</div>
		<script type="text/javascript">
			function moOauthClientAddDescriptionjs() {
				// alert("working");
				var x = document.getElementById("mo_oauth_client_demo_plan_id").selectedIndex;
				var otherOption = document.getElementById("mo_oauth_client_demo_plan_id").options;
				if (otherOption[x].index == 4){
					demoDescription.style.display = "";
				} else {
					demoDescription.style.display = "none";
				}
			}
		</script>
		<?php 
    }
}
