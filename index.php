<?php
/**
 * User: onwer
 * Date: 11-10-23
 * Time: 下午9:59
 */
session_start();
include  dirname(__FILE__).'/lib/lib.php';



$table=new Table();
$filed=new Filed();
$manage= new Manage();
$publish=new Publish();

if(!User::islogin()){
    echo '请登陆';
}
$u=new User();
$v=$u->login('asdf','asd');

print_r($u->errorinfo) ;
var_dump($u->islogin());
var_dump($v)

?>



