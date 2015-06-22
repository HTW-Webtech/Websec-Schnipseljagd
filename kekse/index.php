<?php

   header('Content-Disposition: attachment; filename="Kekse.zip"');
   header('Content-Type: application/octet-stream');

   $fp = popen('zip -r - keksdieb.js keksdose.php keksdose.txt', 'r');
   while(!feof($fp)) echo fread($fp, 8192);
   pclose($fp);
