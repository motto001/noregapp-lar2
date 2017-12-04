<?php
namespace App\Handler;
use Collective\Html\Form;

class MoHand
{
//tömbkezelő------------------------------------------------------

public function setIndexFromKey($T,$key)
{
$res=[];    
foreach($T as $row){
$res[$row[$key]]=$row;
}
return $res;
}
public function mergeAssoc($T1,$T2)
{
$res=[];    
foreach($T1 as $key=>$Val){
    if(isset($T2[$key]))
    {$res[$key]=array_merge($T1[$key],$T2[$key]);}
    else{$res[$key]=$T1[$key];}
}
return $res;
}
/*
public  $request;

function __construct(Request $request) {
    $this->request=$request;
}
*/

//gombok--------------------------------------------------------------------------------------
public function buttons($buttonT=[])
{
    
    $res='';
    foreach($buttonT as $button){
    $tip=  $button['tip'] ?? ''; 
     if($tip=='del'){$res.=delButton($button);}
     else{$res.=linkButton($button);}   
       
    }
return $res;
}


public function linkButton($button=[])
{    
    $res='';
 
      $title=$button['title'] ?? '';

       $res.='<a href="'.$button['link'] .'" '.
     //  $res.=' title="'.$title.' " >'.
       $this->button($button).'
       </a>';     

return $res;
}
public function button($button=[])
{    
    $res='';
      $size=  $button['size'] ?? 'xs';
      $class=$button['class'] ?? 'btn btn-primary btn-'.$size;
      $name=  $button['name'] ?? '';
      $onclick= '';
      if(isset($button['onclick'])){$onclick='onclick="'.$button['onclick'].'"';}
      $type= '';
      if(isset($button['type'])){$type='type="'.$button['type'].'"';}
      $fa='';
      if(isset($button['fa'])){$fa='<i class="fa fa-'.$button['fa'].'" aria-hidden="true"></i>';}
   
       $res.='<button class="'.$class.'" '.$type.'>'.$fa;
       $res.= $name.'</button>';     

return $res;
}
public function delButton($button=[])
{    
    $size=  $button['size'] ?? 'xs';
    if(!isset($button['class'])){$button['class'] = 'btn btn-danger btn-'.$size;}
    $res= \Form::open([
        'method'=>'DELETE',
        'url' => [$button['link']],
        'style' => 'display:inline'
    ]);
    if(!isset($button['onclick'])){$button['onclick']='return confirm("Confirm delete?")';}
    $res.=$this->button($button);
    $res.= \Form::close();

return $res;
}


//url manipulation--------------------------------------------------------------------
/**
 * $pargetT=param[getT] : ebből generálja a link get részét
 * $getT:az a tömb amivel felül kell írni a param[getT]-et (új érték adás)
 */
    public function link_param($pargetT=[],$getT=[],$parstart='/?')
    {  
      $pargetT=array_merge($pargetT,$getT);
        if(!empty($pargetT)){ 
            foreach($pargetT as $key=>$val){
                if(empty($val)){$val='0';}
                $parstart.=$key.'='.$val.'&';
                
            }
            $parstart= substr($parstart,0,-1);
       }
        else
      {$parstart='';}

      
     return  $parstart;
    }

  /**
   * kész url-t (routot) állít elő
   */
    public function url($url='',$pargetT=[],$getT=[],$parstart='/?',$start='/')
    {    

     return  $start.$url.$this->link_param($pargetT,$getT,$parstart);
    }
}