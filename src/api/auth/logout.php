<?php
namespace App\api\auth;

session_start();

session_unset();
session_destroy();

header("Location: /blog/");
exit();
?>
