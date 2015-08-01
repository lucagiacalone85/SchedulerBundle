<?php

namespace Jackal\Scheduler\Bundle\Cron;

/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 17:20.
 */
abstract class Cron
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
            if (!$this->matchTimePart((int) $time->format($pattern), $timePart)) {
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
     * @return bool
     */
    public function isTimeToWakeUp()
    {
        return $this->matchTime(new \DateTime('now'));
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


}
