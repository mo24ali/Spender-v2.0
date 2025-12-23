<?php


    class Router{
        public function parseRoute($route){
            $route = str_replace('',"",$_SERVER['REQUEST_URI']);
            $route = explode(
                '/',$route
            );
        }
    }