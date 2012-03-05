
<ul class="prinav">
        <li class="prinavli">

            <h2><strong>设置</strong>  </h2>
            <ul>
                <li><span>表设置</span><a href="edittable.php?act=add">添加表</a> </li>
                <li>

                    <ul>

                        <?php
                        $alltable = $table->query();
                        foreach ($alltable as $v) {
                            ?>
                            <li>

                                <a href="editfiled.php?tid=<?php echo $v['id'];?>" title="<?php echo $v['table_desc'];?>">
                                    <?php echo $v['table_desc'] ?>
                                </a>
                                <a href="edittable.php?act=del&tid=<?php echo $v['id']?>">删除</a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
                <li><a href="">附带发布设置</a></li>
                <li><a href="">附件设置</a></li>
            </ul>
            <h2><strong>导航</strong> <span><a href="editmanage.php?act=add">新建根目录</a></span></h2>
            <ul>
                <li></li>
            </ul>
            <h2><strong>发布</strong></h2>
        </li>
    </ul>