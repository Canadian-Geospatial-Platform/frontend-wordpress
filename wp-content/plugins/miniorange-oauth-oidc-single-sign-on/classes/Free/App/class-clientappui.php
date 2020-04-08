<?php


namespace MoOauthClient\Free;

use MoOauthClient\AppUI;
use MoOauthClient\App\UpdateAppUI;
use MoOauthClient\AppGuider;
class ClientAppUI
{
    private $common_app_ui;
    public function __construct()
    {
        $this->common_app_ui = new AppUI();
    }
    public function render_free_ui()
    {
        $Y9 = $this->common_app_ui->get_apps_list();
        if (!(isset($_GET["\x61\x63\164\151\x6f\x6e"]) && "\144\145\154\145\164\x65" === $_GET["\x61\143\x74\151\157\156"])) {
            goto X0;
        }
        if (!isset($_GET["\141\160\160"])) {
            goto rQ;
        }
        $this->common_app_ui->delete_app($_GET["\x61\160\160"]);
        return;
        rQ:
        X0:
        if (!(isset($_GET["\x61\143\164\151\157\156"]) && "\x69\x6e\163\x74\x72\165\143\x74\151\x6f\x6e\x73" === $_GET["\141\143\x74\x69\x6f\x6e"] || isset($_GET["\x73\150\x6f\167"]) && "\x69\x6e\163\164\x72\165\143\164\151\157\x6e\163" === $_GET["\x73\x68\x6f\x77"])) {
            goto O5;
        }
        if (!(isset($_GET["\x61\160\x70\x49\x64"]) && isset($_GET["\x66\x6f\162"]))) {
            goto o9;
        }
        $Vc = new AppGuider($_GET["\x61\160\160\111\x64"], $_GET["\146\157\162"]);
        $Vc->show_guide();
        o9:
        if (!(isset($_GET["\163\150\157\167"]) && "\x69\x6e\163\164\162\165\x63\x74\151\157\x6e\163" === $_GET["\x73\x68\x6f\x77"])) {
            goto k4;
        }
        $Vc = new AppGuider($_GET["\x61\x70\160\111\144"]);
        $Vc->show_guide();
        $this->common_app_ui->add_app_ui();
        return;
        k4:
        O5:
        if (!(isset($_GET["\141\143\164\x69\x6f\x6e"]) && "\141\144\144" === $_GET["\141\143\164\x69\157\x6e"])) {
            goto Om;
        }
        $this->common_app_ui->add_app_ui();
        return;
        Om:
        if (!(isset($_GET["\x61\x63\x74\151\157\156"]) && "\165\x70\144\x61\164\x65" === $_GET["\141\143\164\151\157\156"])) {
            goto aF;
        }
        if (!isset($_GET["\141\x70\160"])) {
            goto wo;
        }
        $eL = $this->common_app_ui->get_app_by_name($_GET["\141\x70\160"]);
        new UpdateAppUI($_GET["\x61\160\160"], $eL);
        return;
        wo:
        aF:
        if (!(isset($_GET["\141\x63\x74\x69\157\x6e"]) && "\x61\144\x64\x5f\x6e\x65\x77" === $_GET["\141\x63\x74\x69\157\x6e"])) {
            goto DU;
        }
        $this->common_app_ui->add_app_ui();
        return;
        DU:
        if (!(is_array($Y9) && count($Y9) > 0)) {
            goto kF;
        }
        $this->common_app_ui->show_apps_list_page();
        return;
        kF:
        $this->common_app_ui->add_app_ui();
    }
}
