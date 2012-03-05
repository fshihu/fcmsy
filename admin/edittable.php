<?php
/**
 * User: onwer
 * Date: 11-12-28
 * Time: 上午12:02
 */

require 'lib/lib.php';
include 'islogin.php';

$act=isset($_GET['act'])?$_GET['act']:'';
$actinfo='';
switch ($act){
    case 'add':{
        if(isset($_POST['tname']) && isset($_POST['tdesc'])){
            if($table->create($_POST['tname'],$_POST['tdesc'])){
                $actinfo='创建表成功!';
            }else{
                $actinfo=$table->errorinfo[2];
            }
        }
        include ADMIN_TPL_SRC . 'table_add.php';
        break;
    }

    case 'del':{
        if(isset($_GET['tid'])&&isset($_GET['confirm'])&&$_GET['confirm']==='yes'){
            if($table->del($_GET['tid'])){
                $actinfo='删除成功！';
            }else{
                $actinfo= $table->errorinfo[2];
            }
        }
        include ADMIN_TPL_SRC . 'table_del.php';
        break;
    }
    default:{
        include ADMIN_TPL_SRC . 'table_add.php';
    }
}
