<?php


const BASE_PATH = __DIR__ . '/../';

function dd($value){
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}



function base_path($path){
    return BASE_PATH . $path;
}