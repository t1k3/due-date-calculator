<?php

namespace NagySzilveszter\DueDate;

use NagySzilveszter\DueDate\Interfaces\ConfigInterface;
use NagySzilveszter\DueDate\DueDateValidator;

class DueDateConfig implements ConfigInterface
{
    private static $instance = null;
    protected $workingDays;
    protected $workingHours;

    private function __construct()
    {
        $config = require __DIR__.'/config/due-date-calculator.php';
        extract($config);

        $dueDateValidator = new DueDateValidator;
        $dueDateValidator->validateWorkingDays($workingDays);
        $dueDateValidator->validateWorkingHours($workingHours);

        $this->workingDays  = $workingDays;
        $this->workingHours = $workingHours;
    }

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    public function getWorkingDays(): array
    {
        return $this->workingDays;
    }

    public function getWorkingHours(): array
    {
        return $this->workingHours;
    }
}
