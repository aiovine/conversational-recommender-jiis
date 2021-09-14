<?php 

function searchDuplicate($array){
   foreach($array as $key => $value){
      if(($i = array_search($value,$array))!== FALSE and $key==$i and strlen($value[0]) < 50){   
        $result[] = $array[$i];
      }
   }

   return $result;
}