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

                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                    <div class="info">
                        <?php echo $actinfo;?>
                    </div>

                    <div>表名<input type="text" name="tname"> *</div>
                    <div>表描述 <input type="text" name="tdesc"> *</div>
                    <div><input type="submit" value="创建"></div>
                </form>

            </div>
        </div>
        <?php include 'mod_footer.php'; ?>
    </div>
</div>


</body>
</html>
