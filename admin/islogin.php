<?php
/**
 * User: onwer
 * Date: 11-12-22
 * Time: 上午12:38
 */



if(!User::islogin()){
    header('location:login.php?skip='.$_SERVER['REQUEST_URI']);
    exit;
}
