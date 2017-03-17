<?php
  $path = '../../tmp/';
  if ($handle = opendir($path)) {
     while (false !== ($file = readdir($handle))) {
        if ((time()-filectime($path.$file)) < 86400) {
          if (preg_match('/\.pdf$/i', $file)) {
           unlink($path.$file);
        }
        }
     }
   }
?>
