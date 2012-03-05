<?php
/**
 * User: onwer
 * Date: 11-12-13
 * Time: 下午11:58
 */

include 'lib/lib.php';
//退出
if(isset($_GET['loginout'])){
    User::loginout();
}
//登陆
    $actinfo='';
    $skip=isset($_GET['skip'])?$_GET['skip']:'home.php';
if(isset($_POST['username'])&&isset($_POST['password'])){
    $user=new User();

    if(!$user->login($_POST['username'],$_POST['password'])){
        $actinfo = $user->errorinfo[2];
    }else{
        Fun::jump($skip);
    }


}
include ADMIN_TPL_SRC . 'login.php';
