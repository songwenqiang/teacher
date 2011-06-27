<?php
   $countfile = "counter.inf";
   if(($fp = fopen($countfile,"r+")) == false){
      printf("Open file %s failed!",$countfile);
      exit;
   }
   else{
      $count = fread($fp,10);
      if(!isset($_SESSION['count'])){
         $_SESSION['count'] = "1";
         $count = $count + 1;
      }
      echo "您是本站第";
      echo $count;
      echo "位客人";
   
      fclose($fp);
      $fp = fopen($countfile,"w+");
      fwrite($fp,$count);
      fclose($fp);
   }
?>