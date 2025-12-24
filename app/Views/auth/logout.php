<?php

require "../../Core/database.php";
require "../../Models/User.php";

$obj = new Database();
$acc = new User($obj->getConnection());
$acc->logout();
