<?php

namespace NagySzilveszter\DueDate;

use \DateTimeInterface;
use NagySzilveszter\DueDate\Interfaces\ValidatorInterface;
use NagySzilveszter\DueDate\Exceptions\DueDateException;

class DueDateValidator implements ValidatorInterface
{
    public function validateWorkingDays(array $workingDays)
    {
        if (!is_array($workingDays)) {
            throw new DueDateException('Working days must be array (of integers).');
        }

        foreach ($workingDays as $day) {
            if (!is_integer($day)) {
                throw new DueDateException(sprintf('Working day must be integer: %s', $day));
            }
        }
    }

    public function validateWorkingHours(array $workingHours)
    {
        extract($workingHours);

        if(!isset($start) || !isset($end)) {
            throw new DueDateException('Working hours keys name must be: start, end.');
        }

        if (!is_integer($start) || !is_integer($end)) {
            throw new DueDateException('Working hours must be integer.');
        }

        if ((int)$start < 1 || (int)$end > 24) {
            throw new DueDateException('Working hours start at biggest than 1 and end at lower than 24');
        }

        if ((int)$start >= (int)$end) {
            throw new DueDateException('Working hours end at biggest than start at.');
        }
    }

    public function validateTurnaroundTime(int $turnaroundTime)
    {
        if ($turnaroundTime < 1) {
            throw new DueDateException('Turnaround time must be integer and biggest than 1.');
        }
    }

    public function validateInWorkingTime(DateTimeInterface $dateTime)
    {
        $dueDateConfig = DueDateConfig::getInstance();

        $start         = $dueDateConfig->getWorkingHours()['start'];
        $end           = $dueDateConfig->getWorkingHours()['end'];
        $time          = (int)$dateTime->format('H')+(int)$dateTime->format('i')/60;
        
        $isWorkginDay  = in_array((int)$dateTime->format('N'), $dueDateConfig->getWorkingDays());
        $isWorkingHour = $start <= $time && $time <= $end;

        if (!$isWorkginDay) {
            throw new DueDateException('Submit date must be on working days.');
        }
        if (!$isWorkingHour) {
            throw new DueDateException('Submit date must be between than working hours start/end at.');
        }
    }
}
