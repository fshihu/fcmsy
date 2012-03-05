<?php
/**
 * User: onwer
 * Date: 11-12-1
 * Time: 下午11:04
 */
 
class File {
    protected $filetype=array('img'=>array('image/gif','image/jpg','image/png'),'txt'=>array('text/plain'));
    public $ismulti;
    protected $file;
    public $errorinfo;
    public function __construct($file){
        $this->file=$file;
    }
    /**
     * @param string $type
     * @param int $maxsize kb
     * @param int $minsize kb
     * @return bool
     */
    public function checkfile($type,$maxsize=2048,$minsize=0){
        $maxsize=$maxsize*1024;
        $minsize=$minsize*1024;

        return  $this->file['size']>$minsize && $this->file['size']<$maxsize &&
                in_array($this->file['type'],$this->filetype[$type]);
    }
    /**
     * @param string $src 路径  ''  'aa/'
     * @param string $name 名称，可选。若没有，则是默认文件名
     * @return bool|string 失败返回false，成功文件完整路径
     */
    public function save($src,$name=''){
        if(empty($name)){
            $name= basename($this->file['name']);
        }
        $uploadfile = $src .$name;

        if(is_uploaded_file($this->file['tmp_name'])&& @move_uploaded_file($this->file['tmp_name'],$uploadfile)){
            $this->errorinfo='ok';
            return  $uploadfile;
        }else{
            $this->errorinfo='error '.$this->file['error'];
        }
        return false;
    }
}
