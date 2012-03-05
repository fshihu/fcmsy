<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
    <title>登陆-FCMS管理系统</title>
    <meta name="keywords" content="FCMS管理系统"/
    <meta name="description" content="FCMS管理系统"/>
    <link rel="stylesheet" href="<?php echo ADMIN_TPL_SRC?>css/style.css">

</head>
<body>


<div class="login">
   <form action="<?php echo $_SERVER['PHP_SELF'].'?skip='.$skip;?>" method="post">
       <div class="info">
           <?php echo $actinfo;?>
       </div>

        <p><label for="username">用户名</label><input type="text" name="username" id="username"></p>

        <p><label for="password">密 &nbsp;码</label><input type="text" name="password" id="password"></p>

       <p><input type="submit" value="登陆"></p>
    </form>
</div>

</body>
</html>