<?php

use \PHPUnit\Framework\TestCase;

use NagySzilveszter\DueDate\DueDateValidator;
use NagySzilveszter\DueDate\DueDateCalculator;

class DueDateCalculatorTest extends TestCase
{
    private $dueDateCalculator;

    public function setUp()
    {
        $dueDateValidator        = new DueDateValidator;
        $this->dueDateCalculator = new DueDateCalculator($dueDateValidator);
    }

    public function dataProvider(): array
    {
        return [
            [new DateTime("2017-05-9 9:00"), 1, new DateTime("2017-05-9 10:00")], // simple
            [new DateTime("2017-05-9 9:00"), 16, new DateTime("2017-05-10 17:00")], // first working hour, notWorkingHours
            [new DateTime("2017-05-9 14:00"), 16, new DateTime("2017-05-11 14:00")], // simple, notWorkingHours
            [new DateTime("2017-05-9 17:00"), 16, new DateTime("2017-05-11 17:00")], // last working hour, notWorkingHours
            [new DateTime("2017-05-11 12:00"), 32, new DateTime("2017-05-17 12:00")], // working day, notWorkingDays
            [new DateTime("2017-05-12 17:00"), 40, new DateTime("2017-05-19 17:00")] // last working day-hour, notWorkingDays
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCalculateDueDate(DateTimeInterface $submitDateTime, int $turnaroundTime, DateTimeInterface $dueDateTime)
    {
        $calulatedDueDateTime = $this->dueDateCalculator->calculateDueDate($submitDateTime, $turnaroundTime);
        $this->assertEquals($dueDateTime, $dueDateTime);
    }
}
