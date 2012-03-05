<?php
/**
 * User: onwer
 * Date: 11-11-10
 * Time: 下午10:16
 */

class Manage extends DB
{
    /**
     * @param  $catname  目录名称
     * @param int $cattplid 模板类型，表ID
     * @param string $listfile 列表文件
     * @param string $listtpl 列表模板
     * @param string $filetpl 内容模板
     * @param string $namerule 命名规则
     * @param int $pagenum 分页数目
     * @param string $filepath 文件路径
     * @param int $parent 父目录
     * @return   int 失败返回0，成功返回插入的ID
     */
    public function create($catname, $cattplid, $listfile = '', $listtpl = '', $filetpl = '', $namerule = '',
        $pagenum = 20, $filepath = '', $parent = 0)
    {
        if (empty($catname)) {
            $this->errorinfo[2] = '目录名不能为空！';
            return false;
        }
        $qcatname = $this->safefilter($catname);
        $qlistfile = $this->safefilter($listfile);
        $qlisttpl = $this->safefilter($listtpl);
        $qfiletpl = $this->safefilter($filetpl);
        $qnamerule = $this->safefilter($namerule);
        $qfilepath = $this->safefilter($filepath);
        $sql = sprintf('INSERT INTO  `f_system_manage` (
                    `id` ,
                    `cat_name` ,
                    `cat_tpl_id` ,
                    `list_flie` ,
                    `list_tpl` ,
                    `file_tpl` ,
                    `name_rule` ,
                    `page_num` ,
                    `file_path` ,
                    `parent_catalog`
                    )
                    VALUES (
                    NULL ,  %s,  %d,  %s,  %s,  %s, %s, %d,  %s,  %d
                    )',
                   $qcatname, $cattplid, $qlistfile, $qlisttpl, $qfiletpl, $qnamerule, $pagenum, $qfilepath, $parent);
        $r = $this->pdo->exec($sql);
        $this->errorinfo = $this->pdo->errorInfo();
        if ($r === false) {
            return 0;
        }

        return $this->pdo->lastInsertId();
    }

    /**
     * 更新目录
     * @param int $mid manage表ID
     * @param string $catname
     * @param int $cattplid
     * @param string $listfile
     * @param string $listtpl
     * @param string $filetpl
     * @param string $namerule
     * @param int $pagenum
     * @param string $filepath
     * @return bool
     */
    public function update($mid, $catname, $cattplid, $listfile = '', $listtpl = '', $filetpl = '',
        $namerule = '', $pagenum = 20, $filepath = '')
    {
        if (empty($catname)) {
            $this->errorinfo[2] = '目录名不能为空！';
            return false;
        }
        $qcatname = $this->safefilter($catname);
        $qlistfile = $this->safefilter($listfile);
        $qlisttpl = $this->safefilter($listtpl);
        $qfiletpl = $this->safefilter($filetpl);
        $qnamerule = $this->safefilter($namerule);
        $qfilepath = $this->safefilter($filepath);
        $sql = sprintf('UPDATE  `fcms`.`f_system_manage` SET
                `cat_name` =  %s,
                `cat_tpl_id` =  %d,
                `list_flie` =  %s,
                `list_tpl` =  %s,
                `file_tpl` =  %s,
                `name_rule` =  %s,
                `page_num` =  %d,
                `file_path` =  %s
                WHERE `f_system_manage`.`id` =%d',
                   $qcatname, $cattplid, $qlistfile, $qlisttpl, $qfiletpl, $qnamerule, $pagenum, $qfilepath, $mid);
        $r = $this->pdo->exec($sql);
        $this->errorinfo = $this->pdo->errorInfo();
        if ($r === false) {
            return false;
        }
        return true;
    }

    /**
     * 删除目录
     * @param  $id
     * @return bool
     */
    public function del($id)
    {
        //删除目录ID
        $sql = sprintf('DELETE FROM `f_system_manage` WHERE `f_system_manage`.`id` = %d', $id);
        $r = $this->pdo->exec($sql);
        $this->errorinfo = $this->pdo->errorInfo();
        if ($r === false) {
            return false;
        }
        //删除该目录的子目录
        $sql = sprintf('DELETE FROM `f_system_manage` WHERE `f_system_manage`.`parent_catalog` = %d', $id);
        $r = $this->pdo->exec($sql);
        $this->errorinfo = $this->pdo->errorInfo();
        if ($r === false) {
            return false;
        }
        return true;
    }

    /**
     * @param  $id
     * @return Array
     */
    public function query($id=0)
    {
        if($id===0){
            $sql = sprintf('SELECT * FROM  `f_system_manage`', $id);
        }else{
         }

        $sth = $this->pdo->query($sql);
        $r = $sth->fetchAll(PDO::FETCH_ASSOC);
        $this->errorinfo = $sth->errorInfo();
        return $r;
    }


}

