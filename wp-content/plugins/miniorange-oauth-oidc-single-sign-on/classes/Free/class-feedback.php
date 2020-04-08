<?php


namespace MoOauthClient\Free;

class Feedback
{
    public function show_form()
    {
        global $xW;
        $qh = isset($_SERVER["\x50\110\120\137\123\105\114\106"]) ? sanitize_text_field(wp_unslash($_SERVER["\120\x48\120\137\x53\105\x4c\106"])) : '';
        if (!("\160\x6c\165\147\x69\156\163\56\160\150\160" !== basename($qh))) {
            goto v1;
        }
        return;
        v1:
        $this->enqueue_styles();
        if ($xW->check_versi(1)) {
            goto Go;
        }
        $this->render_feedback_form();
        Go:
    }
    private function enqueue_styles()
    {
        wp_enqueue_style("\167\x70\55\160\x6f\151\156\164\x65\x72");
        wp_enqueue_script("\167\x70\x2d\160\x6f\x69\x6e\164\x65\x72");
        wp_enqueue_script("\165\x74\151\154\163");
        wp_enqueue_style("\155\157\137\x6f\x61\165\x74\x68\x5f\x66\145\x65\144\x62\x61\x63\153\x5f\x73\164\171\154\x65", MOC_URL . "\143\154\141\163\163\x65\163\x2f\106\x72\145\x65\x2f\x72\145\163\157\165\162\x63\145\x73\x2f\146\145\145\144\x62\x61\143\153\x2e\x63\x73\163", array(), $Uy = null, $kK = false);
    }
    private function render_feedback_form()
    {
        ?>
		<div id="oauth_client_feedback_modal" class="mo_modal">
			<div class="mo_modal-content">
				<span class="mo_close">&times;</span>
				<h3>Tell us what happened? </h3>
				<form name="f" method="post" action="" id="mo_oauth_client_feedback">
					<input type="hidden" name="option" value="mo_oauth_client_feedback"/>
					<?php 
        wp_nonce_field("\x6d\157\x5f\x6f\141\165\164\150\137\143\154\x69\x65\x6e\x74\x5f\x66\x65\145\x64\x62\x61\143\x6b", "\155\x6f\137\x6f\x61\x75\164\x68\x5f\143\x6c\x69\145\x6e\x74\x5f\146\145\x65\x64\x62\141\x63\153\x5f\x6e\157\156\x63\145");
        ?>
					<div>
						<p style="margin-left:2%">
						<?php 
        $this->render_radios();
        ?>
						<br>
						<textarea id="query_feedback" name="query_feedback" rows="4" style="margin-left:2%;width: 330px"
								placeholder="Write your query here"></textarea>
						<br><br>
						<div class="mo_modal-footer">
							<input type="submit" name="miniorange_feedback_submit"
								class="button button-primary button-large" style="float: left;" value="Submit"/>
							<input id="mo_skip" type="submit" name="miniorange_feedback_skip"
								class="button button-primary button-large" style="float: right;" value="Skip"/>
						</div>
					</div>
				</form>
				<form name="f" method="post" action="" id="mo_feedback_form_close">
					<input type="hidden" name="option" value="mo_oauth_client_skip_feedback"/>
					<?php 
        wp_nonce_field("\155\x6f\x5f\157\x61\x75\x74\150\x5f\143\x6c\x69\x65\x6e\x74\137\163\x6b\x69\160\137\146\x65\x65\144\142\141\143\153", "\155\x6f\x5f\x6f\141\x75\164\x68\137\143\154\x69\x65\156\164\137\163\153\x69\x70\x5f\146\x65\x65\x64\142\x61\143\153\x5f\156\157\x6e\x63\x65");
        ?>
				</form>
			</div>
		</div>
		<?php 
        $this->emit_script();
    }
    private function emit_script()
    {
        ?>
		<script>
			jQuery('a[aria-label="Deactivate OAuth Single Sign On - SSO (OAuth client)"]').click(function () {
				var mo_modal = document.getElementById('oauth_client_feedback_modal');
				var mo_skip = document.getElementById('mo_skip');
				var span = document.getElementsByClassName("mo_close")[0];
				mo_modal.style.display = "block";
				jQuery('input:radio[name="deactivate_reason_radio"]').click(function () {
					var reason = jQuery(this).val();
					var query_feedback = jQuery('#query_feedback');
					query_feedback.removeAttr('required')
					if (reason === "Does not have the features I'm looking for") {
						query_feedback.attr("placeholder", "Let us know what feature are you looking for");
					} else if (reason === "Other Reasons:") {
						query_feedback.attr("placeholder", "Can you let us know the reason for deactivation");
						query_feedback.prop('required', true);
					} else if (reason === "Bugs in the plugin") {
						query_feedback.attr("placeholder", "Can you please let us know about the bug in detail?");
					} else if (reason === "Confusing Interface") {
						query_feedback.attr("placeholder", "Finding it confusing? let us know so that we can improve the interface");
					} else if (reason === "Endpoints not available") {
						query_feedback.attr("placeholder", "We will send you the Endpoints shortly, if you can tell us the name of your OAuth Server/App?");
					} else if (reason === "Unable to register") {
						query_feedback.attr("placeholder", "Error while receiving OTP? Can you please let us know the exact error?");
					}
				});
				span.onclick = function () {
					mo_modal.style.display = "none";
					jQuery('#mo_feedback_form_close').submit();
				}
				mo_skip.onclick = function() {
					mo_modal.style.display = "none";
					jQuery('#mo_feedback_form_close').submit();
				}
				window.onclick = function (event) {
					if (event.target == mo_modal) {
						mo_modal.style.display = "none";
					}
				}
				return false;
			});
		</script>
		<?php 
    }
    private function render_radios()
    {
        $UN = array("\104\x6f\145\x73\40\x6e\157\x74\x20\x68\x61\166\x65\40\164\x68\145\40\146\x65\141\164\165\x72\x65\x73\x20\x49\40\141\x6d\40\154\x6f\x6f\x6b\x69\156\147\40\146\157\162", "\x44\157\40\x6e\x6f\x74\40\x77\x61\x6e\x74\40\x74\x6f\x20\x75\160\147\x72\141\x64\x65\40\x74\x6f\40\x50\x72\x65\x6d\x69\x75\155\x20\x76\145\162\x73\151\157\156", "\103\157\x6e\x66\165\x73\x69\x6e\147\x20\111\156\x74\145\162\146\x61\x63\x65", "\102\165\147\x73\40\151\x6e\x20\x74\x68\x65\40\160\154\165\147\151\x6e", "\x55\156\141\142\154\x65\x20\164\x6f\40\162\145\x67\151\x73\x74\x65\162", "\105\156\x64\x70\x6f\151\156\x74\x73\40\x6e\x6f\x74\x20\x61\x76\x61\151\x6c\x61\142\154\x65", "\x4f\x74\150\145\x72\x20\x52\x65\x61\x73\x6f\x6e\x73");
        foreach ($UN as $hh) {
            ?>
			<div class="radio" style="padding:1px;margin-left:2%">
				<label style="font-weight:normal;font-size:14.6px" for="<?php 
            echo wp_kses($hh, \get_valid_html());
            ?>
">
					<input type="radio" name="deactivate_reason_radio" value="<?php 
            echo wp_kses($hh, \get_valid_html());
            ?>
"
						required>
					<?php 
            echo wp_kses($hh, \get_valid_html());
            ?>
				</label>
			</div>
			<?php 
            oL:
        }
        Zz:
    }
}
