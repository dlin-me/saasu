<?php
namespace Dlin\Saasu\Util;
/**
 * Class DateTime
 *
 * This class is to assist generating datetime and date string for the api
 *
 */
class DateTime
{

    /**
     * Generate a date
     * @param $time
     * @return string
     */
    public static function getDate($time)
    {
        return substr(self::getDateTimes($time), 0, 10);

    }

    /**
     * Generate a datetime format string
     *
     *
     * @param $time  timestamp or date string
     * @return string
     * @throws \Exception
     */
    public static function getDateTimes($time)
    {

        if (is_numeric($time)) {
            $intTime = $time;
        } else {
            $intTime = strtotime(strval($time));
            if ($intTime === false) {
                throw new \Exception("$time is invalid format");
            }
        }
        $res = date('c', $intTime);

        return substr($res, 0, 19);

    }


}