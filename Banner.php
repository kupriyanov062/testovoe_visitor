<?php
include("Database.php");

class Banner
{
    private static $_pathFoto = "odessa.jpg";
    private $_ip_address;

    public static function getURL()
    {
        Banner::saveInfo();
        echo Banner::$_pathFoto;
    }

    public static function saveInfo()
    {
        $ip_address = $_SERVER['HTTP_X_REAL_IP'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $page_url = $_SERVER['REQUEST_URI'];
        $db = new Database();
        $issetUser = $db->query("SELECT * FROM `user` WHERE `ip_address` = '" . $ip_address . "' and `user_agent` = '" . $user_agent . "' and `page_url` = '" . $page_url . "'");
        if (empty($issetUser)) {
            $id = $db->add("INSERT INTO `user` (`id`, `ip_address`, `user_agent`, `page_url`) VALUES (NULL, '" . $ip_address . "',  '" . $user_agent . "', '" . $page_url . "')");
            $db->query("INSERT INTO `visit` (`id_user`, `view_date`,  `views_count`) VALUES ('" . $id . "', CURRENT_TIMESTAMP, '1')");
        } else {
            $coutNow = $db->query("SELECT `views_count` FROM `visit` WHERE `id_user` = 1");
            $count = $coutNow[0]['views_count'] + 1;
            $db->update("UPDATE `visit` SET `view_date` = CURRENT_TIMESTAMP , `views_count` = '" . $count . "'WHERE `id_user` ='" . $issetUser[0]['id'] . "'");
        }
    }

}
