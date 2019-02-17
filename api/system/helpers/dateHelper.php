<?php

class DateHelper {

    public static function initialize() {
        echo 'Hello DateHelper!';
    }

    public static function dateToDb($date) {
        if (!empty($date)) {
            $date = explode("/", $date);
            $date = $date[2] . '-' . $date[1] . '-' . $date[0];
        } else
            $date = '0000-00-00';
        return $date;
    }

    public static function dateFormat($date) {
        if(!empty($date()) {
            $date = explode("-", $date);
            $date = $date[2] . '/' . $date[1] . '/' . $date[0];
        } else $date = '';
        return $date;
    }

}
