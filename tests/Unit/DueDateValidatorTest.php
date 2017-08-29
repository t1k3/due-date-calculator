<?php

use \PHPUnit\Framework\TestCase;

use NagySzilveszter\DueDate\DueDateValidator;

class DueDateValidatorTest extends TestCase
{
    private $DueDateValidator;

    public function setUp()
    {
        $this->dueDateValidator = new DueDateValidator;
    }

    public function dataProviderForValidateConfigWorkingHours(): array
    {
        return [
            ['start' => '', 'end' => ''],
            ['start' => 0, 'end' => 24],
            ['start' => 23, 'end' => 3]
        ];
    }

    public function dataProviderForValidateInWorkingTime(): array
    {
        return [
            [new DateTime('2017-05-12 7:00')], // workingDays notWorkingHours
            [new DateTime('2017-05-13 8:00')], // notWorkingDays notWorkingHours
            [new DateTime('2017-05-13 9:00')] // notWorkingDays workingHours
        ];
    }

    /**
     * @dataProvider dataProviderForValidateConfigWorkingHours
     * @expectedException \NagySzilveszter\DueDate\Exceptions\DueDateException
     */
    public function testValidateConfigWorkingHours($start, $end)
    {
        $this->dueDateValidator->validateWorkingHours(['start' => $start, 'end' => $end]);
    }

    /**
     * @expectedException \NagySzilveszter\DueDate\Exceptions\DueDateException
     */
    public function testValidateConfigWorkingHoursInvalidArray()
    {
        $this->dueDateValidator->validateWorkingHours(['start' => 11]);
    }

    /**
     * @expectedException \NagySzilveszter\DueDate\Exceptions\DueDateException
     */
    public function testValidateConfigWorkingDays()
    {
        $this->dueDateValidator->validateWorkingDays([]);
        $this->dueDateValidator->validateWorkingDays([1, 2, 'test']);
    }

    /**
     * @expectedException \NagySzilveszter\DueDate\Exceptions\DueDateException
     */
    public function testValidateTurnaroundTime()
    {
        $this->dueDateValidator->validateTurnaroundTime(0);
    }

    /**
     * @dataProvider dataProviderForValidateInWorkingTime
     * @expectedException \NagySzilveszter\DueDate\Exceptions\DueDateException
     */
    public function testValidateInWorkingTime(DateTimeInterface $submitDateTime)
    {
        $this->dueDateValidator->validateInWorkingTime($submitDateTime);
    }
}
