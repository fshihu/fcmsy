<?php


class User extends DB{

    protected $hash='FCMS';

    public function login($u,$p){
        //echo '<br>'.$this->encrypt($p).'<br>';
        $p=$this->encrypt($p);
        $qu=$this->safefilter($u);
        $qp=$this->safefilter($p);

        $sql=sprintf('SELECT *
                    FROM  `f_system_user`
                    WHERE  `user_name` =  %s
                    AND  `user_pass` =  %s',
                    $qu,$qp);
        $sth=$this->pdo->query($sql);
        $r=$sth->fetchAll(PDO::FETCH_ASSOC);
        $this->errorinfo=$sth->errorInfo();
        if($r===false){ return false;}

        if(empty($r)){
            $this->errorinfo[2]='用户名或密码错误';
            return false;
        }
        $_SESSION['login']=$this->encrypt($u);
        $_SESSION['u']=$u;
        setcookie('u',$_SESSION['login']);
        return true;

    }
    public static  function loginout(){
        $_SESSION['login']=null;
    }
    public function reg($u,$p,$param=array()){
        if($this->isexist($u)===1){
            $this->errorinfo[2]='用户名存在';
            return false;
        }
        $qu=$this->safefilter($u);
        $qp=$this->safefilter($this->encrypt($p));
        $sql=sprintf('INSERT INTO  `fcms`.`f_system_user` (
                        `id` ,
                        `user_name` ,
                        `user_pass`
                        )
                        VALUES (
                        NULL ,  %s,  %s
                        )',$qu,$qp);
        $r = $this->pdo->exec($sql);

        $this->errorinfo = $this->pdo->errorInfo();
        if ($r === false) {
            return false;
        }

        return true;

    }
    public function isexist($u){
        $qu=$this->safefilter($u);
        $sql=sprintf('SELECT *
                        FROM  `f_system_user`
                        WHERE  `user_name` =  %s
                        LIMIT 0 , 1 ',
                    $qu);
        $sth=$this->pdo->query($sql);
        $r=$sth->fetchAll(PDO::FETCH_ASSOC);
        $this->errorinfo=$sth->errorInfo();
        if($r===false){ return false;}

        if(!empty($r)){
            return 1;
        }else{
            return 0;
        }
    }
    public static function islogin(){

        if(isset($_SESSION['login']) && isset($_COOKIE['u']) && $_SESSION['login']==$_COOKIE['u']){
            return true;
        }else{
            return false;
        }
    }
    protected function encrypt($str){
        return substr(md5($this->hash).sha1($str),10,20);
    }
}

