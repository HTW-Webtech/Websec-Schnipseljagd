<?php

   require '../../session.php';

   $username = isset($_POST['username']) ? $_POST['username'] : '';
   $password = isset($_POST['password']) ? $_POST['password'] : '';

   if ($username && $password) {
      // https://www.sqlite.org/lang_keywords.html without `on` and `or`
      $sql_verbs = 'abort|action|add|after|all|alter|analyze|and|as|asc|attach|autoincrement|before|begin|between|by
         |cascade|case|cast|check|collate|column|commit|conflict|constraint|create|cross|current_date|current_time
         |current_timestamp|database|default|deferrable|deferred|delete|desc|detach|distinct|drop|each|else|end
         |escape|except|exclusive|exists|explain|fail|for|foreign|from|full|glob|group|having|if|ignore|immediate
         |in|index|indexed|initially|inner|insert|instead|intersect|into|is|isnull|join|key|left|like|limit|match
         |natural|no|not|notnull|null|of|offset|order|outer|plan|pragma|primary|query|raise|recursive|references
         |regexp|reindex|release|rename|replace|restrict|right|rollback|row|savepoint|select|set|table|temp|temporary
         |then|to|transaction|trigger|union|unique|update|using|vacuum|values|view|virtual|when|where|with|without';
      if (preg_match("/($sql_verbs)/i", $username . $password)) {
         exit('Meh ...');
      }

      try {
         $connection = new PDO('sqlite:users.sqlite');
         $result = $connection->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");

         if ($result && $result->fetch())
            $_SESSION['foodlogin'] = true;
         else
            $has_error = true;
      }
      catch (PDOException $exception) {
         die($exception->getMessage());
      }
   }

   if (isset($_SESSION['foodlogin'])) {
      header('Location: ../index.php');
      exit;
   }

?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>Formular</title>
   <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
   <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

   <div class="container">

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
               <input class="form-control" type="text" name="username" placeholder="Benutzername" required autofocus>
               <input class="form-control" type="password" name="password" placeholder="Passwort" required>
               <button type="submit" class="btn btn-primary btn-block">Einloggen</button>
            </form>

         </div> <!-- / .panel-body -->
      </div> <!-- / .panel -->

   </div> <!-- / .container -->

</body>
</html>
