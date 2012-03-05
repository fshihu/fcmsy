<?php
/**
 * User: onwer
 * Date: 11-11-1
 * Time: 下午11:24
 */



class DB{
    public $pdo;
    protected $table_type;
    public $errorinfo=array();
    public function __construct(){
        try {
            $PDO = new PDO(DBDSN, DBUSER, DBPASSWORD);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
       $PDO->query('set names utf8');
       $this->pdo=$PDO;
       $this->table_type=array('f_system_','f_user_');
    }
    /**
     * @param  string $str
     * @return int 0失败，1成功
     */
    public function isletter($str){
        return preg_match('/^[a-z]+$/i',$str);
    }
    /**
     * 是否有效的名称，英文开头，可以有字符串
     * @param string $str
     * @return int 0失败，1成功
     */
    public function isvalid($str){
        return preg_match('/^[a-z][a-z_]*$/i',$str);
    }
    /**
     * @description 添加单引号，并过滤单引号
     * @param  string $str
     * @return bool
     */
    public function safefilter($str){
        return $this->pdo->quote($str);
    }
}