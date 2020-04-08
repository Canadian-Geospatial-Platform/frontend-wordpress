<?php


function mo_oauth_client_page_restriction()
{
    global $xW;
    $BX = $xW->get_plugin_config();
    $I0 = $BX->get_config("\x72\145\163\164\x72\151\143\x74\137\x74\157\x5f\154\x6f\x67\147\145\144\137\x69\156\137\x75\x73\145\162\x73");
    $I0 = '' !== $I0 ? $I0 : false;
    $a9 = $BX->get_config("\141\165\x74\x6f\137\162\145\144\x69\x72\145\143\x74\137\x65\x78\143\x6c\165\x64\145\x5f\165\162\x6c\163");
    if (!(!is_user_logged_in() && boolval($I0))) {
        goto pXF;
    }
    if (!(isset($_REQUEST["\157\141\165\x74\x68\154\x6f\147\x69\156"]) && "\x66\141\154\x73\145" === $_REQUEST["\x6f\x61\x75\164\x68\x6c\157\147\151\x6e"])) {
        goto eKv;
    }
    return;
    eKv:
    if (!(isset($_REQUEST[\MoOAuthConstants::OPTION]) && "\157\x61\x75\x74\x68\x72\145\144\x69\162\x65\x63\x74" === $_REQUEST[\MoOAuthConstants::OPTION])) {
        goto ZUX;
    }
    return;
    ZUX:
    if (!(isset($_REQUEST["\143\x6f\x64\145"]) && '' !== $_REQUEST["\x63\x6f\144\x65"])) {
        goto Aek;
    }
    return;
    Aek:
    if (!(isset($_REQUEST["\141\x63\x63\145\163\x73\137\x74\157\153\145\156"]) && '' !== $_REQUEST["\141\x63\143\x65\163\163\137\x74\x6f\x6b\x65\156"])) {
        goto dC0;
    }
    return;
    dC0:
    if (!(isset($_REQUEST["\x6c\x6f\147\151\156"]) && "\160\x77\x64\x67\162\x6e\x74\146\162\x6d" === $_REQUEST["\x6c\157\x67\x69\x6e"])) {
        goto WuU;
    }
    return;
    WuU:
    if (empty($a9)) {
        goto sgJ;
    }
    $wY = $xW->get_current_url();
    $wY = trim($wY, "\57");
    $a9 = explode("\12", $a9);
    foreach ($a9 as $yc) {
        $yc = trim($yc, "\x2f");
        if (empty($yc)) {
            goto xLn;
        }
        if (!($wY === $yc)) {
            goto CEA;
        }
        return;
        CEA:
        xLn:
        OEa:
    }
    s9E:
    sgJ:
    $d1 = $xW->get_app_by_name();
    if ($d1) {
        goto CqW;
    }
    return;
    CqW:
    $sK = $d1->get_app_config("\x61\x66\x74\x65\162\x5f\154\157\x67\151\x6e\x5f\x75\162\154");
    $wY = $sK ? $sK : $xW->get_current_url();
    echo "\x52\145\144\151\162\x65\143\164\x69\x6e\147\40\164\157\x20\144\x65\x66\141\165\x6c\x74\x20\x6c\157\147\x69\156\x2e\x2e\x2e";
    ?>
		<script>
			var url = "<?php 
    echo site_url();
    ?>
";
			url = url + '/?option=oauthredirect&app_name=' + "<?php 
    echo wp_kses($d1->get_app_name(), \get_valid_html());
    ?>
" + '&redirect_url=' + "<?php 
    echo rawurlencode($wY);
    ?>
" + '&restrictredirect=true';
			window.location.replace( url );
		</script>
		<?php 
    pXF:
}
add_action("\x69\x6e\151\164", "\155\x6f\x5f\157\141\165\164\x68\x5f\143\154\151\145\x6e\x74\137\x70\141\147\145\x5f\x72\145\x73\x74\162\151\143\x74\x69\x6f\x6e");
