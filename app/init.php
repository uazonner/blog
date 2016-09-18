<?php
use Blog\core\Route;

require __DIR__ . '/../vendor/autoload.php';

echo '<pre>';
print_r(Route::start()); // Start routing
echo '</pre>';