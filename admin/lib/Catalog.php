<?php
/**
 * User: Administrator
 * Date: 12-3-2
 * Time: 下午2:18
 */
class Catalog{
    protected $result='';
    protected $opt=array('p_class'=>'parent','i_class'=>'item','item_fn'=>'return $item["id"];');
    /*
     * <dl>
     * <dt>父类1</dt>
     * <dd>
     * <dl>
     * <dt>子类1</dt>
     * </dl>
     * </dd>
     * </dl>

     *
     */
    public function  __construct($opt ){
        $this->opt=array_merge($this->opt,$opt);
        //$this->result=sprintf('<dl class="%s"></dl>',$this->opt['p_class']);
        $this->result=new DOMDocument();
        $dl = $this->result->createElement('dl');
        $dl->setAttribute('class',$this->opt['p_class']);
        $this->result->appendChild($dl);



    }
    public function get($arr){
        $opt=$this->opt;
        $id=$opt['id'];
        $pid=$opt['pid'];
        foreach ($arr as $valarr) {

            if($valarr[$pid]==0){
                $this->catadd($valarr,$valarr[$id]);
            }else{
                $this->catchildadd($valarr,$valarr[$id],$valarr[$pid]);
            }

        }

        return $this->result->saveHTML();

    }
    protected function catadd($item,$id){
        $opt=$this->opt;
        $itemfn=create_function('$item',$opt['item_fn']);

        $dt = $this->result->createElement('dt',$itemfn($item));
        $dt->setAttribute('class',sprintf('%s %s_%d',$opt['p_class'],$opt['i_class'],$id));

        $this->result->documentElement->appendChild($dt);

        $parenttpl=sprintf('<dt class="%s %s_%d">%s</dt>',$opt['p_class'],$opt['i_class'],$id,$itemfn($item));

       // return str_replace('</dl>',$parenttpl.'</dl>',$this->result);
    }
    protected function query($tag,$class){
        $nodes=$this->result->getElementsByTagName($tag);
        foreach($nodes as $node){
            if($node->attributes->getNamedItem("class")->nodeValue==$class){
                return $node;
            }
        }
    }
    //<dl><dd>1</dd><dd>2</dd></dl>
    protected function catchildadd($item,$id,$pid){
        $opt=$this->opt;
        $pclass=sprintf('%s %s_%d',$opt['p_class'],$opt['i_class'],$pid);
        $iclass=sprintf('%s %s_%d',$opt['p_class'],$opt['i_class'],$id);
        $pnode=$this->query('dt',$pclass);
        $itemfn=create_function('$item',$opt['item_fn']);
        if($pnode){
            if($pnode->nextSibling && $pnode->nextSibling->nodeName=='dd'){

            }else{
                $dt=$this->result->createElement('dt',$itemfn($item));
                $dt->setAttribute('class',$iclass);
                $dl=$this->result->createElement('dl');
                $dl->appendChild($dt);

                $dd=$this->result->createElement('dd');
                $dd->appendChild($dl);
                $dd->setAttribute('class','child');


                $pnode->parentNode->insertBefore($dd, $pnode->nextSibling);
            }
            echo $pnode->nodeValue;
        }

      /*  $itemfn=create_function('$item',$opt['item_fn']);
        $itemstr=$itemfn($item);
        $nochildtpl=sprintf('<dd class="child child_%d"><dl><dt class="%s %s_%d">%s</dt></dl></dd>',
            $id,$opt['p_class'],$opt['i_class'],$id,$itemstr);
        $haschildtpl=sprintf('<dt class="%s %s_%d">%s</dt>',$opt['p_class'],$opt['i_class'],$id,$itemfn($item));

        $child=sprintf('<dd><dl><dt>%s</dt></dl></dd>',$item);

        $haschild=sprintf('/<dt class="%s %s_%d">.*?<\/dt><dd/',$opt['p_class'],$opt['i_class'],$pid,$itemstr);
        $nochild=sprintf('/(<dt class="%s %s_%d">.*?<\/dt>)/',$opt['p_class'],$opt['i_class'],$pid,$itemstr);

        //<dd>3</dd><dt><dl><dd>5</dd></dl></dt>
echo    $haschild.$id."\n";

        if(preg_match($haschild,$this->result,$r) ){
//            echo $id;
            print_r($r);
            $haschildparent=sprintf('/(<dd>%s<\/dd>.*?)(<\/dl><\/dt>)/',$pid);
            $child=sprintf('<dd>%s</dd>',$item);
            return preg_replace($haschildparent,'$1'.$child.'$2',$this->result);
        }else{
            return preg_replace($nochild,'$1'.$nochildtpl,$this->result);
        }*/
        
    }
    protected function haschild(){

    }
}
