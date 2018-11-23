<?php

namespace Eluceo\iCal\Property\Event;

use PHPUnit\Framework\TestCase;

class RecurrenceRuleTest extends TestCase
{
    /**
     * Example taken from http://www.kanzaki.com/docs/ical/rrule.html
     */
    public function testUntil()
    {
        $rule = new RecurrenceRule();
        $rule->setFreq(RecurrenceRule::FREQ_DAILY);
        $rule->setInterval(null);
        $rule->setUntil(new \DateTime('1997-12-24'));
        $this->assertEquals(
            'FREQ=DAILY;UNTIL=19971224T000000Z',
            $rule->getEscapedValue()
        );
    }

    public function testMultipleDaysByDay()
    {
        $rule = new RecurrenceRule();
        $rule->setFreq(RecurrenceRule::FREQ_WEEKLY);
        $rule->setInterval(20);
        $rule->setByDay('MO,WE,FR');

        $this->assertEquals(
            'FREQ=WEEKLY;INTERVAL=20;BYDAY=MO,WE,FR',
            $rule->getEscapedValue()
        );
    }

    public function testSetCount()
    {
        $rule = new RecurrenceRule();
        $rule->setCount(5);

        $this->assertSame(5, $rule->getCount());
        $this->assertSame('FREQ=YEARLY;INTERVAL=1;COUNT=5', $rule->getEscapedValue());
    }

    public function testGetCount()
    {
        $rule = new RecurrenceRule();

        $this->assertNull($rule->getCount());
    }

    public function testGetUntil()
    {
        $rule = new RecurrenceRule();
        $rule->setUntil(new \DateTime('1997-12-24'));
        $result = $rule->getUntil();

        $this->assertInstanceOf(\DateTime::class, $result);
        $this->assertSame('1997-12-24', $result->format('Y-m-d'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The Frequency invalid_freq_string is not supported.
     */
    public function testSetFreqOnInvalidFreq()
    {
        $rule = new RecurrenceRule();
        $rule->setFreq('invalid_freq_string');
    }

    public function testGetFreq()
    {
        $rule = new RecurrenceRule();
        $rule->setFreq(RecurrenceRule::FREQ_DAILY);

        $this->assertSame('DAILY', $rule->getFreq());
    }

    public function testGetInterval()
    {
        $rule = new RecurrenceRule();
        $rule->setInterval(20);

        $this->assertSame(20, $rule->getInterval());
    }

    public function testSetWkst()
    {
        $rule = new RecurrenceRule();
        $rule->setWkst(RecurrenceRule::WEEKDAY_FRIDAY);

        $this->assertSame('FREQ=YEARLY;INTERVAL=1;WKST=FR', $rule->getEscapedValue());
    }

    public function testSetByMonth()
    {
        $rule = new RecurrenceRule();
        $rule->setByMonth(1);

        $this->assertSame('FREQ=YEARLY;INTERVAL=1;BYMONTH=1', $rule->getEscapedValue());
    }

    public function invalidMonthProvider()
    {
        return [
            ['invalid_month'],
            [-1],
            [0],
            [0.0001],
            [13],
        ];
    }

    /**
     * @dataProvider invalidMonthProvider
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid value for BYMONTH
     */
    public function testSetByMonthOnInvalidMonth($month)
    {
        $rule = new RecurrenceRule();
        $rule->setByMonth($month);
    }

    public function testSetByWeekNo()
    {
        $rule = new RecurrenceRule();
        $rule->setByWeekNo(1);

        $this->assertSame('FREQ=YEARLY;INTERVAL=1;BYWEEKNO=1', $rule->getEscapedValue());
    }

    public function invalidByWeekNoProvider()
    {
        return [
            [0],
            [0.001],
            [-54],
            [54]
        ];
    }

    /**
     * @dataProvider invalidByWeekNoProvider
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid value for BYWEEKNO
     */
    public function testSetByWeekNoOnInvalidByWeekNo($byWeekNo)
    {
        $rule = new RecurrenceRule();
        $rule->setByWeekNo($byWeekNo);
    }

    public function testSetByYearDay()
    {
        $rule = new RecurrenceRule();
        $rule->setByYearDay(1);

        $this->assertSame('FREQ=YEARLY;INTERVAL=1;BYYEARDAY=1', $rule->getEscapedValue());
    }

    public function invalidByYearDayProvider()
    {
        return [
            [0],
            [0.0001],
            [367],
            [-367]
        ];
    }

    /**
     * @dataProvider invalidByYearDayProvider
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid value for BYYEARDAY
     */
    public function testSetByYearDayOnInvalidByYeraDay($day)
    {
        $rule = new RecurrenceRule();
        $rule->setByYearDay($day);
    }

    public function testSetByMonthDay()
    {
        $rule = new RecurrenceRule();
        $rule->setByMonthDay(1);

        $this->assertSame('FREQ=YEARLY;INTERVAL=1;BYMONTHDAY=1', $rule->getEscapedValue());
    }

    public function invalidByMonthDayProvider()
    {
        return [
            [0],
            [0.0001],
            [32],
            [-32],
        ];
    }

    /**
     * @dataProvider invalidByMonthDayProvider
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid value for BYMONTHDAY
     */
    public function testSetByMonthDayOnInvalidByMonthDay($day)
    {
        $rule = new RecurrenceRule();
        $rule->setByMonthDay($day);
    }

    public function testSetByHour()
    {
        $rule = new RecurrenceRule();
        $rule->setByHour(1);

        $this->assertSame('FREQ=YEARLY;INTERVAL=1;BYHOUR=1', $rule->getEscapedValue());
    }

    public function invalidByHourProvider()
    {
        return [
            [0.0001],
            [-1],
            [24],
        ];
    }

    /**
     * @dataProvider invalidByHourProvider
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid value for BYHOUR
     */
    public function testSetByHourOnInvalidByHour($value)
    {
        $rule = new RecurrenceRule();
        $rule->setByHour($value);
    }

    public function testSetByMinute()
    {
        $rule = new RecurrenceRule();
        $rule->setByMinute(1);

        $this->assertSame('FREQ=YEARLY;INTERVAL=1;BYMINUTE=1', $rule->getEscapedValue());
    }

    public function invalidByMinuteProvider()
    {
        return [
            [0.0001],
            [-1],
            [60]
        ];
    }

    /**
     * @dataProvider invalidByMinuteProvider
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid value for BYMINUTE
     */
    public function testSetByMinuteOnInvalidByMinute($value)
    {
        $rule = new RecurrenceRule();
        $rule->setByMinute($value);
    }

    public function testSetBySecond()
    {
        $rule = new RecurrenceRule();
        $rule->setBySecond(1);

        $this->assertSame('FREQ=YEARLY;INTERVAL=1;BYSECOND=1', $rule->getEscapedValue());
    }

    public function invalidBySecondProvider()
    {
        return [
            [0.0001],
            [-1],
            [61]
        ];
    }

    /**
     * @dataProvider invalidBySecondProvider
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid value for BYSECOND
     */
    public function testSetBySecondOnInvalidBySecond($value)
    {
        $rule = new RecurrenceRule();
        $rule->setBySecond($value);
    }
}
