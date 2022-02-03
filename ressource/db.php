<?php
   try {
      $dbh = new PDO('mysql:host=192.168.1.26;dbname=cube2', 'root', 'root');
   } catch (PDOException $e) {
      print "Erreur !: " . $e->getMessage() . "<br/>";
      die();
   }
?>