<?php

   require '../session.php';

   $username = 'heronimus';
   $password = 'honigbrot';

   $klausurfragen = '../dokumente/klausurfragen.txt';
   $hall_of_fame = '../hall_of_fame.csv';

   $logged_in = false;
   $hall_of_fame_member = isset($_SESSION['hall_of_fame_member']);

   if (isset($_SESSION['logged_in'])) {
      $logged_in = true;
   }

   elseif (isset($_POST['username']) && isset($_POST['password'])) {
      if ($_POST['username'] === $username && $_POST['password'] === $password) {
         $_SESSION['logged_in'] = $logged_in = true;
      } else {
         $has_error = true;
      }
   }

   if (isset($_POST['matrn']) && !$hall_of_fame_member) {

      if (!preg_match('/^s0[0-9]{6}$/', $_POST['matrn'])) {
         exit('Meh ...');
      }

      $matrn = $_POST['matrn'];
      $cookie_file = "../foodlog/images/$matrn.jpg.js";
      $user_agent = filter_var($_SERVER['HTTP_USER_AGENT'], FILTER_SANITIZE_STRING);
      $remote_addr = filter_var($_SERVER['REMOTE_ADDR'], FILTER_SANITIZE_STRING);
      $comment = '';

      if (!file_exists($hall_of_fame)) {
         $template = "Matrikelnummer, HTTP_USER_AGENT, REMOTE_ADDR, Uhrzeit, Kommentar\n";
         file_put_contents($hall_of_fame, $template);
      }

      if (file_exists($cookie_file)) {
         unlink($cookie_file);
      } else {
         $comment = 'Keine Script-Datei';
      }

      $fp = fopen($hall_of_fame, 'a');
      $values = array($matrn, $user_agent, $remote_addr, date('d.m.Y H:i'), $comment);
      fputcsv($fp, $values);
      fclose($fp);
      $_SESSION['hall_of_fame_member'] = $hall_of_fame_member = true;
   }

   if (isset($_POST['aufgabe'])) {
      $aufgabe = filter_var($_POST['aufgabe'], FILTER_SANITIZE_SPECIAL_CHARS);
      file_put_contents($klausurfragen, "$aufgabe\n", FILE_APPEND);
   }

?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <title>Dokumente</title>
   <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
   <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

   <div class="container">

   <?php if (!$logged_in) : ?>

      <div class="panel panel-default panel-small">

         <div class="panel-heading">
            <h3 class="panel-title">Bitte loggen Sie sich ein</h3>
         </div>

         <div class="panel-body">

            <?php if (isset($has_error)) : ?>
               <div class="alert alert-danger">
                  <strong>Falsches Passwort!</strong> Versuchen Sie es erneut.
               </div>
            <?php endif; ?>

            <form role="form" action="." method="POST">
               <input class="form-control" type="text" name="username" placeholder="Benutzername" autofocus>
               <input class="form-control" type="password" name="password" placeholder="Passwort">
               <button type="submit" class="btn btn-primary btn-block">Einloggen</button>
            </form>

         </div> <!-- / .panel-body -->
      </div> <!-- / .panel -->

   <?php else : ?>

      <div class="panel panel-success panel-small">

         <div class="panel-heading">
            <h3 class="panel-title">Hall of Fame</h3>
         </div>

         <div class="panel-body">

         <?php if (!$hall_of_fame_member) : ?>

            <p class="lead">Woohoo! Sie haben es geschafft.</p>

            <form role="form" action="." method="POST">
               <input class="form-control" type="text" name="matrn" placeholder="Matrikelnummer" pattern="s0[0-9]{6}" title="Matrikelnummer im Format s0543210 eingeben.">
               <button type="submit" class="btn btn-success btn-block">Verewigen</button>
            </form>

         <?php else: ?>

            <p class="lead check">✔</p>

         <?php endif; ?>

         </div> <!-- / .panel-body -->
      </div> <!-- / .panel -->


      <form class="input-group input-task" action="." method="POST">
         <input class="form-control input-lg" type="text" name="aufgabe" placeholder="Neue Aufgabe &hellip;">
         <span class="input-group-btn">
            <button type="submit" class="btn btn-default btn-lg">Hinzufügen</button>
         </span>
      </form>

      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title">Aufgaben</h3>
         </div>
            <ol class="list-group">
            <?php
               if ($handle = fopen($klausurfragen, 'r')) {
                  while (($line = fgets($handle)) !== false) {
                     echo "<li class=\"list-group-item\">$line</li>";
                  }
               }
            ?>
            </ol>
      </div>

   <?php endif; ?>

   </div> <!-- / .container -->
</body>
</html>
