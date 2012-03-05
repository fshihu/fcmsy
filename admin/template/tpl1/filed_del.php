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
               <div class="info">
                   <?php
                       if(isset($_GET['confirm'])&&$_GET['confirm']==='yes'){
                           printf('%s',$actinfo);
                       }else{
                           printf('<a href="%s&confirm=yes">一定要删除吗？</a>',Fun::curcul());
                       }
                   ?>
               </div>
           </div>
       </div>
       <?php include 'mod_footer.php'; ?>
   </div>
</div>


</body>
</html>
