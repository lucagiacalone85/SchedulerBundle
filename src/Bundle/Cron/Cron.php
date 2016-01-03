<?php

namespace Jackal\Scheduler\Bundle\Cron;

class Cron
{
    /**
     * @var int
     */
    private $second;

    /**
     * @var int
     */
    private $minute;

    /**
     * @var int
     */
    private $hour;

    /**
     * @var int
     */
    private $day;

    /**
     * @var int
     */
    private $month;

    /**
     * @var int
     */
    private $dayOfWeek;

    /**
     *     * * * * * *  command to execute
     *     │ │ │ │ │ │
     *     │ │ │ │ │ │
     *     │ │ │ │ │ └───── day of week (1 - 7) (1 to 7 are Monday to Sunday)
     *     │ │ │ │ └────────── month (1 - 12)
     *     │ │ │ └─────────────── day of month (1 - 31)
     *     │ │ └──────────────────── hour (0 - 23)
     *     | └───────────────────────── min (0 - 59).
     *     └ └───────────────────────── sec (0 - 59).
     */
    public function __construct($second, $minute, $hour, $day, $month, $dayOfWeek)
    {
        $this->second = $second;
        $this->minute = $minute;
        $this->hour = $hour;
        $this->day = $day;
        $this->month = $month;
        $this->dayOfWeek = $dayOfWeek;
    }

    /**
     * @param $day
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @return Cron
     */
    public static function everyMonthAt($day, $hour = 0, $minute = 0, $second = 0)
    {
        return new self($second, $minute, $hour, $day, null, null);
    }

    /**
     * @param $hour
     * @param int $minute
     * @param int $second
     * @return Cron
     */
    public static function everyDayAt($hour, $minute = 0, $second = 0)
    {
        return new self($second, $minute, $hour, null, null, null);
    }

    /**
     * @param $hour
     * @param int $minute
     * @param int $second
     * @return Cron
     */
    public static function everyMondayAt($hour, $minute = 0, $second = 0)
    {
        return new self($second, $minute, $hour, null, null, CronDay::Monday());
    }

    /**
     * @param $hour
     * @param int $minute
     * @param int $second
     * @return Cron
     */
    public static function everyTuesdayAt($hour, $minute = 0, $second = 0)
    {
        return new self($second, $minute, $hour, null, null, CronDay::Tuesday());
    }

    /**
     * @param $hour
     * @param int $minute
     * @param int $second
     * @return Cron
     */
    public static function everyWednesdayAt($hour, $minute = 0, $second = 0)
    {
        return new self($second, $minute, $hour, null, null, CronDay::Wednesday());
    }

    /**
     * @param $hour
     * @param int $minute
     * @param int $second
     * @return Cron
     */
    public static function everyThursdayAt($hour, $minute = 0, $second = 0)
    {
        return new self($second, $minute, $hour, null, null, CronDay::Thursday());
    }

    /**
     * @param $hour
     * @param int $minute
     * @param int $second
     * @return Cron
     */
    public static function everyFridayAt($hour, $minute = 0, $second = 0)
    {
        return new self($second, $minute, $hour, null, null, CronDay::Friday());
    }

    /**
     * @param $hour
     * @param int $minute
     * @param int $second
     * @return Cron
     */
    public static function everySaturdayAt($hour, $minute = 0, $second = 0)
    {
        return new self($second, $minute, $hour, null, null, CronDay::Saturday());
    }

    /**
     * @param $hour
     * @param int $minute
     * @param int $second
     * @return Cron
     */
    public static function everySundayAt($hour, $minute = 0, $second = 0)
    {
        return new self($second, $minute, $hour, null, null, CronDay::Sunday());
    }

    /**
     * @param int $minute
     * @param int $second
     * @return Cron
     */
    public static function everyHour($minute = 0, $second = 0)
    {
        return new self($second, $minute, null, null, null, null);
    }

    /**
     * @param int $second
     * @return Cron
     */
    public static function everyMinute($second = 0)
    {
        return new self($second, null, null, null, null, null);
    }

    /**
     * @return Cron
     */
    public static function everySecond()
    {
        return new self(null, null, null, null, null, null);
    }

    /**
     * @param \DateTime
     *
     * @return bool
     */
    private function matchTime(\DateTime $time)
    {
        $matchPattern = [
            'N' => $this->dayOfWeek,
            'n' => $this->month,
            'j' => $this->day,
            'G' => $this->hour,
            'i' => $this->minute,
            's' => $this->second,
        ];

        foreach ($matchPattern as $pattern => $timePart) {
            if (!$this->matchTimePart((int)$time->format($pattern), $timePart)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param int $currentTimePart
     * @param int $declaredTimePart
     *
     * @return bool
     */
    private function matchTimePart($currentTimePart, $declaredTimePart)
    {
        return $declaredTimePart === null ? true : $currentTimePart == $declaredTimePart;
    }

    /**
     * @param \DateTime|null $dateTime
     * @return bool
     */
    public function isTimeToWakeUp(\DateTime $dateTime = null)
    {
        return $this->matchTime($dateTime === null ? new \DateTime('now') : $dateTime);
    }


    function __toString()
    {
        return sprintf('%s %s %s %s %s %s',
            $this->second === null ? '*' : $this->second,
            $this->minute === null ? '*' : $this->minute,
            $this->hour === null ? '*' : $this->hour,
            $this->day === null ? '*' : $this->day,
            $this->month === null ? '*' : $this->month,
            $this->dayOfWeek === null ? '*' : $this->dayOfWeek
        );
    }

    /**
     * @return int
     */
    public function getSecond()
    {
        return $this->second;
    }

    /**
     * @return int
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * @return int
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @return int
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return int
     */
    public function getDayOfWeek()
    {
        return $this->dayOfWeek;
    }


}
