<?php
/**
 * User: onwer
 * Date: 11-11-1
 * Time: 下午11:21
 */
/**
 * 创建表（表名，描述, 类型）
	删除表（表名）
	选择表（表名）--返回数组
 */
class Table extends DB{


    /**
     * 创建表
     * @param  string $name    表名
     * @param  string $desc    表描述
     * @param  int $type    表类型  1系统，0用户
     * @return bool
     */
    public function create($name,$desc,$type=1){

           if(!$this->isletter($name)){
                $this->errorinfo[2]='请使用英文名称！';
                return false;
           }
           if(!preg_match('/^0|1$/',$type)){
                $this->errorinfo[2]='type只能为1或0！';
                return false;
           }
            $tablename=$this->table_type[$type].$name;
            //添加单引号
           $qdesc=$this->safefilter($desc);
           $qtablename=$this->safefilter($tablename);

          //在管理表中添加字段
           $sql=sprintf('INSERT INTO  `f_system_table` (
                `id` ,
                `table_name` ,
                `table_desc` ,
                `table_type`
                )
                VALUES ( NULL ,  %s,  %s, %d )',
               $qtablename,$qdesc,$type);
           $r=$this->pdo->exec($sql);
           $this->errorinfo=$this->pdo->errorInfo();
           if($r===false){ return $r;}

            //创建表
           $sql=sprintf('CREATE TABLE  `%s` (
                `id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `cat_id` INT( 10 ) NOT NULL
                ) ENGINE = INNODB;',$tablename);
           $this->pdo->exec($sql);
           $this->errorinfo=$this->pdo->errorInfo();
           return   true;

    }
    /**
     * @param string  $tid    表名
     * @return bool
     */
    public function del($tid){

        $curtabelarr=$this->query('',$tid);

        if(empty($curtabelarr)){
            $this->errorinfo[2] ='已经删除了！';
            return false;
        }
        $curtabel=$curtabelarr[0];

        //从管理字段表中删除字段
        $sql=sprintf('DELETE FROM `f_system_filed` WHERE `f_system_filed`.`table_id` = %d ',$tid);
        $r=$this->pdo->exec($sql);
        $this->errorinfo=$this->pdo->errorInfo();
        if($r===false){ return false;}
        //从管理表中删除表
        $sql=sprintf('DELETE FROM `f_system_table` WHERE `f_system_table`.`id` = %d ',$tid);
        $r=$this->pdo->exec($sql);
        $this->errorinfo=$this->pdo->errorInfo();
        if($r===false){ return false;}
        //删除表
        $sql=sprintf('DROP TABLE %s',$curtabel['table_name']);
        $r=$this->pdo->exec($sql);
        $this->errorinfo=$this->pdo->errorInfo();
        if($r===false){ return false;}
        return true;
    }
    /**
     * @param string  $name 表名
     * @param int $id 可选，如果ID>0则根据ID查询，否则根据表名
     * @return array 查询结果，关联数组，可能为空数组
     */
    public function query($name='',$id=0){
        $qname=$this->safefilter($name);
        if($id>0){
            $sql=sprintf('SELECT * FROM  `f_system_table`
                WHERE  `id` =  %d
                LIMIT 0 , 1',$id);
        }else if($name!==''){
            $sql=sprintf('SELECT * FROM  `f_system_table`
                WHERE  `table_name` = %s
                LIMIT 0 , 1',$qname);
        }else{
            $sql=sprintf('SELECT * FROM  `f_system_table` ');

        }

        $sth=$this->pdo->query($sql);
        $r=$sth->fetchAll(PDO::FETCH_ASSOC);
        $this->errorinfo=$sth->errorInfo();
        return $r;
    }


}
