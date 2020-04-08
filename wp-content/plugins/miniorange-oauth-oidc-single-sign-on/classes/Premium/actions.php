<?php


function show_extra_attributes($user)
{
    global $xW;
    $c5 = get_user_meta($user->ID, "\155\157\x5f\157\x61\165\164\150\137\x63\165\x73\x74\x6f\155\x5f\141\164\x74\162\151\142\165\164\x65\x73");
    if (!$c5 || !is_array($c5) || empty($c5)) {
        goto e6;
    }
    $c5 = $c5[0];
    goto ew;
    e6:
    return;
    ew:
    ?>
	<h3>Extra profile information</h3>
	<table class="form-table" style="width:75%; border: 1px solid #aaa;">
		<tr>
			<td style="border: 1px solid #ccc;"><label for="user">User Name</label></td>
			<td style="border: 1px solid #ccc;"><strong><?php 
    echo esc_attr(get_the_author_meta("\x64\x69\163\x70\154\141\171\137\156\141\x6d\x65", $user->ID));
    ?>
</strong></td>
		</tr>
		<?php 
    foreach ($c5 as $qV => $sw) {
        ?>
			<tr>
				<td style="border: 1px solid #ccc;"><strong><?php 
        echo wp_kses($qV, get_valid_html());
        ?>
</strong></td>
				<td style="border: 1px solid #ccc;"><strong><?php 
        echo wp_kses($sw, get_valid_html());
        ?>
</strong></td>
			</tr>
		<?php 
        pv:
    }
    Fi:
    ?>
	</table>
	<?php 
}
add_action("\163\150\157\167\137\x75\x73\x65\x72\137\160\x72\x6f\x66\151\x6c\145", "\x73\x68\157\167\x5f\145\x78\x74\x72\x61\x5f\x61\x74\x74\x72\151\142\x75\164\145\x73");
add_action("\x65\144\151\164\137\x75\x73\145\x72\137\160\x72\x6f\146\x69\154\x65", "\163\150\x6f\167\137\145\x78\x74\162\141\137\141\x74\x74\x72\x69\x62\165\x74\145\163");
function control_password_grant()
{
    global $xW;
    $ys = new MoOauthClient\GrantTypes\Password();
    $ys->inject_ui();
    $ys->inject_behaviour();
}
add_action("\x6d\157\x5f\x6f\x61\165\x74\150\137\143\154\151\145\x6e\164\137\x61\x64\144\x5f\x70\167\x64\137\152\163", "\143\157\156\x74\162\x6f\x6c\137\160\x61\x73\163\x77\157\x72\x64\137\x67\x72\x61\156\164");
function enqueue_pwd_essentials()
{
    ?>
	<link rel="stylesheet" href="<?php 
    echo MOC_URL . "\143\x6c\x61\x73\x73\145\x73\x2f\x50\162\x65\155\x69\x75\155\x2f\162\x65\x73\157\x75\162\143\x65\163\57\x70\167\x64\x73\x74\x79\x6c\x65\56\143\163\x73";
    ?>
">
	<script src="<?php 
    echo MOC_URL . "\x63\154\x61\x73\163\145\x73\x2f\x50\162\145\155\x69\165\x6d\x2f\x72\x65\x73\x6f\x75\162\143\x65\x73\57\x6a\161\x75\145\162\171\56\155\151\156\x2e\152\163";
    ?>
"></script>
	<script src="<?php 
    echo MOC_URL . "\x63\154\x61\163\x73\x65\163\x2f\120\162\145\x6d\x69\x75\155\x2f\162\x65\x73\157\x75\162\x63\145\x73\x2f\160\167\x64\x2e\152\163";
    ?>
"></script>
	<?php 
}
add_action("\160\x77\144\137\x65\x73\163\x65\156\164\x69\x61\x6c\x73\x5f\151\x6e\164\x65\162\x6e\x61\154", "\145\156\161\x75\145\165\x65\137\x70\x77\144\x5f\x65\163\163\x65\156\164\151\141\154\x73");
