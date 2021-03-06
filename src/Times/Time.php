<?php
/*
 *
 *
 */

namespace U0mo5\Tools\Times;

class Time
{

// +----------------------------------------------------------------------
    // | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
    // +----------------------------------------------------------------------
    // | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
    // +----------------------------------------------------------------------
    // | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
    // +----------------------------------------------------------------------
    // | Author: 刘志淳 <chun@engineer.com>
    // +----------------------------------------------------------------------


    /**
     * 返回今日开始和结束的时间戳 与laravel Carbon  冲突
     *
     * @return array
     */

    public static  function today()
    {
        return [
            mktime(0, 0, 0, date('m'), date('d'), date('Y')),
            mktime(23, 59, 59, date('m'), date('d'), date('Y'))
        ];
    }


    /**
     * 返回昨日开始和结束的时间戳
     *
     * @return array
     */
    public static  function yesterday()
    {
        $yesterday = date('d') - 1;
        return [
            mktime(0, 0, 0, date('m'), $yesterday, date('Y')),
            mktime(23, 59, 59, date('m'), $yesterday, date('Y'))
        ];
    }

    /**
     * 返回本周开始和结束的时间戳
     *
     * @return array
     */
    public static  function week()
    {
        $timestamp = time();
        return [
            strtotime(date('Y-m-d', strtotime("+0 week Monday", $timestamp))),
            strtotime(date('Y-m-d', strtotime("+0 week Sunday", $timestamp))) + 24 * 3600 - 1
        ];
    }

    /**
     * 返回上周开始和结束的时间戳
     *
     * @return array
     */
    public static  function lastWeek()
    {
        $timestamp = time();
        return [
            strtotime(date('Y-m-d', strtotime("last week Monday", $timestamp))),
            strtotime(date('Y-m-d', strtotime("last week Sunday", $timestamp))) + 24 * 3600 - 1
        ];
    }


    /**
     * 返回本月开始和结束的时间戳
     *
     * @return array
     */
    public static  function month()
    {
        return [
            mktime(0, 0, 0, date('m'), 1, date('Y')),
            mktime(23, 59, 59, date('m'), date('t'), date('Y'))
        ];
    }

    /**
     * 返回上个月开始和结束的时间戳
     *
     * @return array
     */
    public static  function lastMonth()
    {
        $begin = mktime(0, 0, 0, date('m') - 1, 1, date('Y'));
        $end = mktime(23, 59, 59, date('m') - 1, date('t', $begin), date('Y'));

        return [$begin, $end];
    }

    /**
     * 返回今年开始和结束的时间戳
     *
     * @return array
     */
    public static  function year()
    {
        return [
            mktime(0, 0, 0, 1, 1, date('Y')),
            mktime(23, 59, 59, 12, 31, date('Y'))
        ];
    }

    /**
     * 返回去年开始和结束的时间戳
     *
     * @return array
     */
    public static  function lastYear()
    {
        $year = date('Y') - 1;
        return [
            mktime(0, 0, 0, 1, 1, $year),
            mktime(23, 59, 59, 12, 31, $year)
        ];
    }

    public static  function dayOf()
    {
    }

    /**
     * 获取几天前零点到现在/昨日结束的时间戳
     *
     * @param int $day 天数
     * @param bool $now 返回现在或者昨天结束时间戳
     * @return array
     */
    public static  function dayToNow($day = 1, $now = true)
    {
        $foo=null;
        $end = time();
        if (!$now) {
            list($foo, $end) = yesterday();
        }
        unset($foo);
        return [
            mktime(0, 0, 0, date('m'), date('d') - $day, date('Y')),
            $end
        ];
    }

    /**
     * 返回几天前的时间戳
     *
     * @param int $day
     * @return int
     */
    public static  function daysAgo($day = 1)
    {
        $nowTime = time();
        return $nowTime - daysToSecond($day);
    }

    /**
     * 返回几天后的时间戳
     *
     * @param int $day
     * @return int
     */
    public static  function daysAfter($day = 1)
    {
        $nowTime = time();
        return $nowTime + daysToSecond($day);
    }

    /**
     * 天数转换成秒数
     *
     * @param int $day
     * @return int
     */
    public static  function daysToSecond($day = 1)
    {
        return $day * 86400;
    }

    /**
     * 周数转换成秒数
     *
     * @param int $week
     * @return int
     */
    public static  function weekToSecond($week = 1)
    {
        return daysToSecond() * 7 * $week;
    }



    //from ecshop   thanks
    /**
     * 获得当前格林威治时间的时间戳
     *
     * @return  integer
     */
    public static  function gmtime()
    {
        return (time() - date('Z'));
    }

    /**
     * 获得服务器的时区
     *
     * @return  integer
     */
    public static  function server_timezone()
    {
        if (function_exists('date_default_timezone_get')) {
            return date_default_timezone_get();
        } else {
            return date('Z') / 3600;
        }
    }


    /**
     *  生成一个用户自定义时区日期的GMT时间戳
     *
     *
     */
    public static  function local_mktime($hour = null, $minute = null, $second = null, $month = null, $day = null, $year = null)
    {
        $timezone = isset($_SESSION['timezone']) ? $_SESSION['timezone'] : $GLOBALS['_CFG']['timezone'];

        /**
         * $time = mktime($hour, $minute, $second, $month, $day, $year) - date('Z') + (date('Z') - $timezone * 3600)
         * 先用mktime生成时间戳，再减去date('Z')转换为GMT时间，然后修正为用户自定义时间。以下是化简后结果
         **/
        $time = mktime($hour, $minute, $second, $month, $day, $year) - $timezone * 3600;

        return $time;
    }


    /**
     * 将GMT时间戳格式化为用户自定义时区日期
     *
     * @param  string $format
     * @param  integer $time 该参数必须是一个GMT的时间戳
     *
     * @return  string
     */

    public static  function local_date($format, $time = null)
    {
        $timezone = isset($_SESSION['timezone']) ? $_SESSION['timezone'] : $GLOBALS['_CFG']['timezone'];

        if ($time === null) {
            $time = gmtime();
        } elseif ($time <= 0) {
            return '';
        }

        $time += ($timezone * 3600);

        return date($format, $time);
    }


    /**
     * 转换字符串形式的时间表达式为GMT时间戳
     *
     * @param   string $str
     *
     * @return  integer
     */
    public static  function gmstr2time($str)
    {
        $time = strtotime($str);

        if ($time > 0) {
            $time -= date('Z');
        }

        return $time;
    }

    /**
     *  将一个用户自定义时区的日期转为GMT时间戳
     *
     * @access  public
     * @param   string $str
     *
     * @return  integer
     */
    public static  function local_strtotime($str)
    {
        $timezone = isset($_SESSION['timezone']) ? $_SESSION['timezone'] : $GLOBALS['_CFG']['timezone'];

        /**
         * $time = mktime($hour, $minute, $second, $month, $day, $year) - date('Z') + (date('Z') - $timezone * 3600)
         * 先用mktime生成时间戳，再减去date('Z')转换为GMT时间，然后修正为用户自定义时间。以下是化简后结果
         **/
        $time = strtotime($str) - $timezone * 3600;

        return $time;
    }

    /**
     * 获得用户所在时区指定的时间戳
     *
     * @param   $timestamp  integer     该时间戳必须是一个服务器本地的时间戳
     *
     * @return  array
     */
    public static  function local_gettime($timestamp = null)
    {
        $tmp = local_getdate($timestamp);
        return $tmp[0];
    }

    /**
     * 获得用户所在时区指定的日期和时间信息
     *
     * @param   $timestamp  integer     该时间戳必须是一个服务器本地的时间戳
     *
     * @return  array
     */
    public static  function local_getdate($timestamp = null)
    {
        $timezone = isset($_SESSION['timezone']) ? $_SESSION['timezone'] : $GLOBALS['_CFG']['timezone'];

        /* 如果时间戳为空，则获得服务器的当前时间 */
        if ($timestamp === null) {
            $timestamp = time();
        }

        $gmt = $timestamp - date('Z');       // 得到该时间的格林威治时间
        $local_time = $gmt + ($timezone * 3600);    // 转换为用户所在时区的时间戳

        return getdate($local_time);
    }


    //获得当前毫秒级时间戳
    public static  function getMillisecond()
    {
        list($t1, $t2) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($t1)+floatval($t2))*1000);
    }
    //获得时间
    public static  function get_datetime()
    {
        return  date('Y-m-d H:i:s') ;
    }

    //Facebook (x mins age, y hours ago etc)
    //$date = "2015-07-05 03:45";
    //$result = nicetime($date); // 2 days ago


    public static  function nicetime($date)
    {
        if (empty($date)) {
            return "No date provided";
        }

        $periods  = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths  = array("60","60","24","7","4.35","12","10");

        $now  = time();
        $unix_date  = strtotime($date);

        // check validity of date
        if (empty($unix_date)) {
            return "Bad date";
        }
        // is it future date or past date
        if ($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense  = "ago";
        } else {
            $difference = $unix_date - $now;
            $tense  = "from now";
        }

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j].= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }


    //昨天0时时间戳
    //$yesterday_zero = strtotime(date('Y-m-d')) - 3600 * 24;
    //昨天此时时间戳
    //$yesterday_now = strtotime('-1 day');
    //本周一时间戳
    //$week_this_monday = strtotime('last Monday');
    //明天时间戳
    //$tomorrow = strtotime("+1 day");
    //上周一时间戳
    //$week_last_monday = strtotime('last Monday') - 3600 * 24 * 7;
    //上周日时间戳
    //$week_last_sunday = strtotime('last Monday') - 3600 * 24;
    //本月第一天时间戳
    //$month_first = strtotime(date("Y") . "-" . date("m") . "-1");
    //本月最后一天时间戳
    //$month_last = strtotime(date("Y") . "-" . date("m") . "-" . date("t"));
    //获取上个月第一天及最后一天
    //echo date('Y-m-01', strtotime('-1 month'));
    //echo "<br/>";
    //echo date('Y-m-t', strtotime('-1 month'));

    /**
     * 中文字符串转换为时间戳
     * @param string $str
     * @return false|int
     */
    public static  function ch_strtotime($str='')
    {
        // $str='2017年11月20日  14:00'
        $str=str_replace("年", "-", $str);
        $str=str_replace("月", "-", $str);
        $str=str_replace("日", "", $str);
        // echo $str;
        return strtotime($str);
    }
}
