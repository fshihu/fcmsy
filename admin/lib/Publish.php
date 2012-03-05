<?php
/**
 * User: onwer
 * Date: 11-11-28
 * Time: 下午11:41
 */

class Publish extends DB
{

    /**
     * 添加数据
     * @param  $catid int 目录ID
     * @param  $param array 对应的键值
     * @return bool
     */
    public function add($catid, $param)
    {
        $filed = '';
        $value = '';

        foreach ($param as $k => $v) {
            $v = $this->safefilter($v);
            $filed .= sprintf(' ,`%s`', $k);
            $value .= sprintf(' , %s', $v);
        }

        $sql = sprintf('INSERT INTO  `fcms`.`f_user_ac` (
                    `id` ,
                    `cat_id`
                    %s
                    )
                    VALUES ( NULL ,  %d %s )',
                       $filed, $catid, $value);
        $r = $this->pdo->exec($sql);

        $this->errorinfo = $this->pdo->errorInfo();
        if ($r === false) {
            return false;
        }
        return true;

    }

    /**
     * @param  int $catid 管理表ID
     * @return array
     */
    public function query($catid)
    {
        //查找表ID
        $sql = sprintf('SELECT * FROM  `f_system_manage`
                    WHERE  `id` =  %d
                    LIMIT 0 , 1', $catid);
        $sth = $this->pdo->query($sql);
        $r1 = $sth->fetch(PDO::FETCH_ASSOC);
        $this->errorinfo = $sth->errorInfo();
        //查找表名
        $sql = sprintf('SELECT * FROM  `f_system_table`
                    WHERE  `id` =  %d
                    LIMIT 0 , 1', $r1['cat_tpl_id']);
        $sth = $this->pdo->query($sql);
        $r2 = $sth->fetch(PDO::FETCH_ASSOC);
        $this->errorinfo = $sth->errorInfo();
        $tablename = $this->table_type[$r2['table_type']] . $r2['table_name'];
        //查找可显示的字段
        $filed = new Filed($this->pdo);
        $r3 = $filed->query($r1['cat_tpl_id']);
        //所有的字段
        $showfiled = '';
        foreach ($r3 as $v) {
            $showfiled .= $v['filed_name'] . ',';
        }

        $showfiled = substr($showfiled, 0, -1);

        $sql = sprintf('SELECT %s FROM  `%s` ', $showfiled, $tablename);
        $sth = $this->pdo->query($sql);
        $r4 = $sth->fetchAll(PDO::FETCH_ASSOC);
        $this->errorinfo = $sth->errorInfo();
        return $r4;
    }
}
