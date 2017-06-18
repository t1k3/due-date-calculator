<?php

namespace NagySzilveszter\DueDate\Interfaces;

interface ConfigInterface 
{
    public static function getInstance();
    public function getWorkingDays(): array;
    public function getWorkingHours(): array;
}
