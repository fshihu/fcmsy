<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
    <title>管理表-FCMS管理系统</title>
    <meta name="keywords" content="FCMS管理系统"/>
    <meta name="description" content="FCMS管理系统"/>
    <?php include 'mod_head.php'; ?>

</head>
<body>
<div class="wraper">
    <div class="wrap">
        <?php include  'mod_header.php' ?>

        <div class="contenter">
            <div class="prinavw">
                <?php include  'mod_prinav.php' ?>
            </div>
            <div class="pricont">

                <div class="pricnav">
                    <a href="editfiled.php?act=add&tid=<?php echo $tid;?>">添加字段</a>
                </div>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>字段名称</th>
                        <th>字段描述</th>
                        <th>字段类型</th>
                    </tr>

                    <?php
                    $fileds = $filed->query($tid);
                    foreach ($fileds as $v) {
                    ?>
                        <tr>
                            <td><?php echo $v['id']; ?></td>
                            <td><?php echo $v['filed_name']; ?> </td>
                            <td><?php echo $v['filed_desc']; ?></td>
                            <td><?php echo $v['filed_type']; ?></td>
                            <td><a href="<?php echo $_SERVER['REQUEST_URI'] . '&act=del&fid=' . $v['id']?>">删除</a></td>
                            <td><a href="<?php echo $_SERVER['REQUEST_URI'] . '&act=alt&fid=' . $v['id']?>">修改</a></td>
                        </tr>

                    <?php
                    }
                    ?>


                </table>
            </div>
        </div>
        <?php include 'mod_footer.php'; ?>
    </div>
</div>


</body>
</html>
