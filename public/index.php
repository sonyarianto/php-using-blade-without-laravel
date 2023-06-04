<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config.php';
require_once __DIR__ . '/../src/Blade.php';

$blade = new Blade();

$blade->render('page', [
    'title' => 'Title',
    'text' => 'This is my text!',
]);