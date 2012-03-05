<?php
/**
 * User: Administrator
 * Date: 12-2-29
 * Time: 下午5:58
 */
require 'lib/lib.php';
include 'islogin.php';


//TODO 新建？  $manage->add(); 显示？
$manage = new Manage();
$arr = $manage->query();
$act = isset($_GET['act']) ? $_GET['act'] : '';
print_r($arr);
$navcat = new Catalog(array('id' => 'id', 'pid' => 'parent_catalog'));

echo ($navcat->get($arr));

switch ($act) {
    case 'add':
        {

        include ADMIN_TPL_SRC . 'manage_add.php';
        break;
        }
}

?>

