<?php

// This is just a simple sample usage code

require __DIR__.'./vendor/autoload.php';

use NagySzilveszter\DueDate\DueDateConfig;
use NagySzilveszter\DueDate\DueDateValidator;
use NagySzilveszter\DueDate\DueDateCalculator;

$validator  = new DueDateValidator;
$calculator = new DueDateCalculator($validator);

try {
    $date = $calculator->calculateDueDate(new DateTime('2017-05-9 14:00'), 16);
    var_dump($date->format('Y-m-d H:i:s'));
} catch (Exception $e) {
    echo $e->getMessage();
}