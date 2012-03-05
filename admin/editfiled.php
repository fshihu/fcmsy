<?php
/**
 * User: onwer
 * Date: 11-12-28
 * Time: 上午12:02
 */

require 'lib/lib.php';
include 'islogin.php';

    $filed= new Filed();
    $tid=isset($_GET['tid'])?$_GET['tid']:0;
    $act=isset($_GET['act'])?$_GET['act']:'';
    $fid=isset($_GET['fid'])?$_GET['fid']:0;
    $actinfo='';

switch ($act){
    case 'add':{
        if(isset($_POST['fname']) && isset($_POST['fdesc'])&&isset($_POST['ftype'])&&isset($_GET['tid'])){

            if($filed->add($_POST['fname'],$_POST['fdesc'],$_POST['ftype'], $_GET['tid'])){
                $actinfo='添加成功！';
            }else{
                $actinfo= $filed->errorinfo[2];
            }

        }
        include ADMIN_TPL_SRC . 'filed_add.php';
        break;
    }
    case 'alt':{
        $curfiled=$filed->query(0,$fid);
        if(isset($_POST['fname'])&&isset($_POST['fdesc'])){
            if($filed->alter($_POST['fname'],$_POST['fdesc'],$_POST['ftype'],$curfiled[0]['id'],$tid)){
                $actinfo = '修改成功';
                $curfiled=$filed->query(0,$fid);
            }else{
                $actinfo = $filed->errorinfo[2];
            }

        }
        include ADMIN_TPL_SRC . 'filed_alt.php';
        break;
    }
    case 'del':{
        if( isset($_GET['confirm'])&&$_GET['confirm']==='yes'){
            if($filed->del($tid,$fid)){
                $actinfo = '删除成功';
            }else{
                $actinfo = $filed->errorinfo[2];
            }

        }
        include ADMIN_TPL_SRC . 'filed_del.php';
        break;
    }
    default:{
        include ADMIN_TPL_SRC . 'filed_show.php';
    }
}

