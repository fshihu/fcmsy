<?php
/**
 * User: onwer
 * Date: 11-11-7
 * Time: 下午11:37
 */

class Filed extends DB
{
    public static $filetype = array('文字' => 'varchar( 200)','数字' => 'int(11)',
        '图片' => 'varchar( 300)', '文件' => 'varchar( 300)', '文本区域' => 'text', '日期' => 'date');

    public function __construct()
    {
        $this->table = new Table();
        parent::__construct();

    }

    /**
     * @param  string $filedname 字段名，英文名称
     * @param  string $filedesc 字段描述
     * @param  string $filedtype 字段类型，只能为已定义
     * @param  int $tableid 表ID，属于哪个表
     * @return bool
     */
    public function add($filedname, $filedesc, $filedtype, $tableid)
    {

        if (!$this->isvalid($filedname)) {
            $this->errorinfo[2] = '字段名，只能有英文字母，下划线，英文字母开头！';
            return false;
        }
        if (trim($filedesc) === '') {
            $this->errorinfo[2] = '字段描述不能为空！';
            return false;
        }

        if (!array_key_exists($filedtype, self::$filetype)) {
            $this->errorinfo[2] = '字段类型错误，未定义的类型！';
            return false;
        }
        //查询表是否存在
        $curtablearr = $this->table->query('', $tableid);
        $curtable = $curtablearr[0];
        if (empty($curtable)) {
            $this->errorinfo[2] = $tableid . '不存在！';
            return false;
        }
        $qfiledname = $this->safefilter($filedname);
        $qfiledesc = $this->safefilter($filedesc);
        $qfiledtype = $this->safefilter($filedtype);

        //添加字段
        $sql = sprintf('ALTER TABLE  `%s` ADD  `%s` %s ', $curtable['table_name'],
            $filedname, self::$filetype[$filedtype]);
        $r = $this->pdo->exec($sql);
        $this->errorinfo = $this->pdo->errorInfo();
        if ($r === false) {
            return false;
        }
        //在管理字段表插入行
        $sql = sprintf('INSERT INTO  `f_system_filed` (
                    `id` ,
                    `filed_name` ,
                    `filed_desc` ,
                    `filed_type` ,
                    `table_id`
                    )
                    VALUES (
                    NULL ,  %s,  %s,  %s,  %d
                    )',
            $qfiledname, $qfiledesc, $qfiledtype, $tableid);
        $r = $this->pdo->exec($sql);
        $this->errorinfo = $this->pdo->errorInfo();
        if ($r === false) {
            return false;
        }
        return true;
    }

    /**
     * @param $filedname
     * @param $filedesc
     * @param $filedtype
     * @param $filedid
     * @param $tableid
     * @return boolean
     */
    public function alter($filedname, $filedesc, $filedtype, $filedid, $tableid)
    {
        if (!$this->isvalid($filedname)) {
            $this->errorinfo[2] = '字段名，只能有英文字母，下划线，英文字母开头！';
            return false;
        }
        if (trim($filedesc) === '') {
            $this->errorinfo[2] = '字段描述不能为空！';
            return false;
        }
        $qfiledname = $this->safefilter($filedname);
        $qfiledesc = $this->safefilter($filedesc);
        $qfiledtype = $this->safefilter($filedtype);

        $curfiledarr=$this->query(0,$filedid);
        $curfiled=$curfiledarr[0];
        //更新字段表中字段数据
        $sql = sprintf('UPDATE  `fcms`.`f_system_filed`
                        SET `filed_name` = %s ,`filed_desc` = %s, `filed_type` = %s
                        WHERE  `f_system_filed`.`id` =%d',
            $qfiledname, $qfiledesc, $qfiledtype, $filedid

        );
        $r = $this->pdo->exec($sql);
        $this->errorinfo = $this->pdo->errorInfo();
        if ($r === false) {
            return false;
        }
        $curtablearr = $this->table->query('', $tableid);
        $curtable = $curtablearr[0];
        //修改具体表中的字段
        $sql = sprintf('ALTER TABLE  `%s` CHANGE  `%s`  `%s` %s  NOT NULL ',
              $curtable['table_name'],$curfiled['filed_name'],$filedname ,self::$filetype[$filedtype]);
        $r = $this->pdo->exec($sql);

        $this->errorinfo = $this->pdo->errorInfo();
        if ($r === false) {
            return false;
        }


        return true;
    }

    /**
     * 删除字段
     * @param  int $tableid
     * @param  int $filedid
     * @return bool
     */
    public function del($tableid, $filedid)
    {
        //字段名为空



        //获取表类型
        $curtablearr = $this->table->query('',$tableid);
        $curtable=$curtablearr[0];

        $curfiledarr=$this->query(0,$filedid);
        $curfiled=$curfiledarr[0];

        //删除表的字段
        $sql = sprintf('ALTER TABLE `%s`  DROP `%s`', $curtable['table_name'], $curfiled['filed_name']);

        $r = $this->pdo->exec($sql);
        $this->errorinfo = $this->pdo->errorInfo();
        if ($r === false) {
            return false;
        }
        //在管理字段中删除行
        $sql = sprintf('DELETE FROM `f_system_filed` WHERE `f_system_filed`.`id` = %d  ', $filedid );

        $r = $this->pdo->exec($sql);
        $this->errorinfo = $this->pdo->errorInfo();
        if ($r === false) {
            return false;
        }
        return true;

    }

    /**
     * 返回表所以的字段
     * @param  $tableid
     * @param $filedid
     * @return array
     */
    public function query($tableid = 0, $filedid = 0)
    {
        if ($tableid === 0) {
            $sql = sprintf('SELECT * FROM  `f_system_filed`
                                    WHERE  `id` =  %d',
                $filedid);
        } else {
            $sql = sprintf('SELECT * FROM  `f_system_filed`
                                    WHERE  `table_id` =  %d',
                $tableid);

        }

        $sth = $this->pdo->query($sql);
        $r = $sth->fetchAll(PDO::FETCH_ASSOC);
        $this->errorinfo = $sth->errorInfo();

        return $r;
    }
}
