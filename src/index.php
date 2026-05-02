<?php

use Illea\TestExerice\Classes\Core\App;

require_once dirname(__DIR__).'/vendor/autoload.php';

// Створюємо екземпляр класу App
$app = new App;

// Запускаємо застосунок
$app->run();