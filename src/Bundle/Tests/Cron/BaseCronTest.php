<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 19:29.
 */

namespace Jackal\Scheduler\Bundle\Tests\Cron;

use Jackal\Scheduler\Bundle\Cron\Cron;

abstract class BaseCronTest extends \PHPUnit_Framework_TestCase
{
    private function invokeInternalMethod(Cron $cron, \DateTime $dateTime)
    {
        $reflection = new \ReflectionClass($cron);
        $method = $reflection->getMethod('matchTime');
        $method->setAccessible(true);

        $result = $method->invoke($cron, $dateTime);
        return $result;
    }

    protected function assertValidDateTime(Cron $cron, \DateTime $dateTime)
    {
        $this->assertTrue($this->invokeInternalMethod($cron, $dateTime));
    }

    protected function assertInvalidDateTime(Cron $cron, \DateTime $dateTime)
    {
        $this->assertFalse($this->invokeInternalMethod($cron, $dateTime));
    }
}
