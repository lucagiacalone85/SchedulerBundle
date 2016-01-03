<?php

namespace Jackal\Scheduler\Bundle\Cron;

final class CronDay
{
    private $day;

    public function __construct(\DateTime $dateTime){
        $this->day = $dateTime->format('N');
    }

    public function getDay(){
        return $this->day;
    }

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