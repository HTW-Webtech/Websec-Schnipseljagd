<?php

   $file = isset($_GET['file']) ? $_GET['file'] : '';

   if ($file) {

      if (!file_exists($file)) {
         echo 'Jibbet nich';
      }

      elseif (substr_count($file, '.') > 3 || preg_match('/.php$/i', $file) || preg_match('/^\/.*/i', $file)) {
         echo 'Meh ...';
      }

      else {
         include $file;
      }

   }

?>