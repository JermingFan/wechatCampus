<?php
function backImageUrl($str){  

 
  $s = new SaeStorage();  
  $zz=$s->write ( 'weiqinpicture' ,$str,"ddddd");  
  $erjin  = $s->read( 'weiqinpicture' ,$str) ;  
  echo $erjin;
   echo "url".$zz;
  //return $s->getUrl( 'weiqinpicture',$str);
}  
 //backImageUrl("dd/local.txt");  
   $s = new SaeStorage();  
 echo $s->getUrl( 'weiqinpicture',"zz.txt");
?>  