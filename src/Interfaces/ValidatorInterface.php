<?php

namespace NagySzilveszter\DueDate\Interfaces;

use \DateTimeInterface;

interface ValidatorInterface 
{
    public function validateWorkingDays(array $workingDays);
    public function validateWorkingHours(array $workingHours);
    public function validateTurnaroundTime(int $turnaroundTim);
    public function validateInWorkingTime(DateTimeInterface $dateTime);
}
