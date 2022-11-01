<?php


namespace App;


class Tools
{

    public static function _escape($str)
    {
        $search = array("\\", "\0", "\n", "\r", "\x1a", "'", '"');
        $replace = array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"');
        return str_replace($search, $replace, $str);
    }

    public static function escape($string, $html_ok = false, $bq_sql = false)
    {
        if (_PS_MAGIC_QUOTES_GPC_) {
            $string = stripslashes($string);
        }

        if (!is_numeric($string)) {
            $string = self::_escape($string);

            if (!$html_ok) {
                $string = strip_tags(str_replace(array("\r\n", "\r", "\n"), '<br />', $string));
            }

            if ($bq_sql === true) {
                $string = str_replace('`', '\`', $string);
            }
        }

        return $string;
    }

    public static function pSql($input, $html_ok = false, $bq_sql = false)
    {
        return Tools::escape($input, $html_ok, $bq_sql);
    }

    public static function ajaxDie($data)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        die();
    }

    public static function print_rDie($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die();
    }

    public static function printCode($data)
    {
        echo '<pre>';
        echo $data;
        echo '</pre>';
    }
}


