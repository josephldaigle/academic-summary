<?php

spl_autoload_register(function ($class) {

   $root = __DIR__;

    $iter = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST,
        RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
    );

    $paths = array($root);
    foreach ($iter as $path => $dir) {
        if ($dir->isDir()) {
            $paths[] = $path;
        }
    }

   
    for ($i = 0; $i < count($paths); $i++) {
        $finalPath = $paths[$i] . "\\{$class}.php";
        if (file_exists($finalPath)) {
            require_once($finalPath);
        }
    }
});