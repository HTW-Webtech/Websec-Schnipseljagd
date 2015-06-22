<?php

   error_reporting(E_ALL);
   ini_set('display_errors', true);

   require '../session.php';

   require 'php_error.php';
   $options = array(
      'snippet_num_lines' => 0,
      'background_text'  => '',
      'error_reporting_off' => 0,
      'error_reporting_on' => E_ALL | E_STRICT
   );
   \php_error\reportErrors($options);


   $dir = 'images/';

   if (isset($_SESSION['foodlogin']) && isset($_POST['submit'])) {
      if (preg_match('/\.jpg/i', $_FILES['bild']['name'])) {
         $file = $dir . basename($_FILES['bild']['name']);
         move_uploaded_file($_FILES['bild']['tmp_name'], $file);
      }
      else {
         $error_message = '<strong>Falscher Dateityp!</strong> Bitte wählen Sie ein Bild.';
      }
   }

?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>Formular</title>
   <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
   <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

   <div class="container">

   <?php if (isset($_SESSION['foodlogin'])) : ?>


      <div class="panel panel-default panel-small">

         <div class="panel-heading">
            <h3 class="panel-title">Neues Bild hochladen</h3>
         </div>

         <div class="panel-body">

            <?php if (isset($error_message)) : ?>
               <div class="alert alert-danger">
                  <?= $error_message?>
               </div>
            <?php endif; ?>

            <form class="input-group input-task" enctype="multipart/form-data" action="." method="POST" style="margin-bottom: 0">
               <input class="form-control" type="file" name="bild">
               <span class="input-group-btn">
                  <button type="submit" name="submit" class="btn btn-default">Hinzufügen</button>
               </span>
            </form>

         </div> <!-- / .panel-body -->
      </div> <!-- / .panel -->

   <?php endif; ?>

      <div class="row list-group products">

      <?php
         $files = glob("$dir*jpg");
         usort($files, create_function('$a,$b', 'return filemtime($a) - filemtime($b);'));

         foreach ($files as $file) {
            echo '<div class="item col-xs-4">
               <div class="thumbnail">
                  <div class="image" style="background-image: url(' . $dir . rawurlencode(basename($file)) . ')">
                  </div>
                  <div class="caption">
                     <span class="lead">' . htmlspecialchars(basename($file, '.jpg')) . '</span>
                  </div>
               </div>
            </div>';
         }
      ?>
      </div> <!-- / .products -->

   </div> <!-- / .container -->
</body>
</html>
