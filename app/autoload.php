<?php

spl_autoload_register(function ($class) {
    $prefix = 'App\\Core\\';
    $baseDir = __DIR__ . '/core/';

    // Check if the class uses the App\Core namespace
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // If not, exit the function
        return;
    }

    // Get the relative class name
    $relativeClass = substr($class, $len);

    // Replace namespace separators with directory separators
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});
