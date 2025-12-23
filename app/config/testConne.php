<?php


    require_once "database.php";
    require_once "Router.php";
        new Database();
        $route = new Router();
        var_dump(Database::getValue('db'));


        $route->parseRoute($_SERVER['REQUEST_URI']);
      $route = $route->parseRoute("/search");
      var_dump($route);