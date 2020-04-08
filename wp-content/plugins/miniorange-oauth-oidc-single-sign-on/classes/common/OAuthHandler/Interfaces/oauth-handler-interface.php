<?php


namespace MoOauthClient;

interface OauthHandlerInterface
{
    public function get_token($FY, $w1, $jb, $vK);
    public function get_access_token($FY, $w1, $jb, $vK);
    public function get_id_token($FY, $w1, $jb, $vK);
    public function get_resource_owner_from_id_token($co);
    public function get_resource_owner($oj, $d9);
    public function get_response($a8);
}
