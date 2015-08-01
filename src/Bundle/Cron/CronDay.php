<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 22:51
 */

namespace Jackal\SchedulerBundle\Cron;


class CronDay
{
    public static function Monday(){
        return 1;
    }

    public static function Tuesday(){
        return 2;
    }

    public static function Wednesday(){
        return 3;
    }

    public static function Thursday(){
        return 4;
    }

    public static function Friday(){
        return 5;
    }

    public static function Saturday(){
        return 6;
    }

    public static function Sunday(){
        return 7;
    }


}