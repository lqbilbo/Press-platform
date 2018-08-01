<?php
/**
 * Created by PhpStorm.
 * User: luoqi
 * Date: 2018/8/1
 * Time: 下午10:14
 */

class fileutil
{
    function get_ini_file($file_name = "config.ini") {
        $str = file_get_contents($file_name);
        $ini_list = explode("\n", $str);
        $ini_items = array();
        foreach($ini_list as $item) {
            $one_item = explode("=", $item);
            if (isset($one_item[0]) && isset($one_item[1]))
                $ini_items[trim($one_item[0])] = trim($one_item[1]);
        }
        return $ini_items;
    }

    function get_ini_item($ini_items = null, $item_name = '') {
        if (empty($ini_items))
            return "";
        else
            return $ini_items[$item_name];
    }
}