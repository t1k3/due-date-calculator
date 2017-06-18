<?php

namespace NagySzilveszter\DueDate;

use \DateTimeInterface;
use NagySzilveszter\DueDate\Interfaces\ValidatorInterface;

class DueDateCalculator
{
    protected $dueDateValidator;
    protected $dueDateConfig;

    public function __construct(ValidatorInterface $dueDateValidator)
    {
        $this->dueDateConfig    = DueDateConfig::getInstance();
        $this->dueDateValidator = $dueDateValidator;
    }

    public function calculateDueDate(DateTimeInterface $submitDateTime, int $turnaroundTime): DateTimeInterface
    {
        $this->dueDateValidator->validateTurnaroundTime($turnaroundTime);
        $this->dueDateValidator->validateInWorkingTime($submitDateTime);

        $dueDateTime = clone $submitDateTime;
        $addedHours  = 0;

        while ($addedHours < $turnaroundTime) {
            $dueDateTime->modify('+1 hour');
            if ($this->isWorkingDay($dueDateTime) && $this->isWorkingHour($dueDateTime) && !$this->isFirstWorkingHour($dueDateTime)) {
                $addedHours++;
            }
        }

        return $dueDateTime;
    }

    protected function time2float(DateTimeInterface $dateTime): float
    {
        return (int)$dateTime->format('H')+(int)$dateTime->format('i')/60;
    }

    protected function isWorkingDay(DateTimeInterface $dateTime): bool
    {
        $workingDays = $this->dueDateConfig->getWorkingDays();
        $day         = (int)$dateTime->format('N');

        return in_array($day, $workingDays);
    }

    protected function isWorkingHour(DateTimeInterface $dateTime): bool
    {
        $start = $this->dueDateConfig->getWorkingHours()['start'];
        $end   = $this->dueDateConfig->getWorkingHours()['end'];
        $time  = $this->time2float($dateTime);

        return $start <= $time && $time <= $end;
    }

    protected function isFirstWorkingHour(DateTimeInterface $dateTime): bool
    {
        $start = $this->dueDateConfig->getWorkingHours()['start'];
        $time  = $this->time2float($dateTime);

        return $time == $start;
    }
}
