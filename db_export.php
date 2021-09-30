<?php

   error_reporting(E_ALL); // Activer le rapport d'erreurs PHP
   $db_charset = "utf8"; /* mettre utf8 ou latin1 */

    // Partie à personnaliser
   $db_server         = "localhost"; // Nom du serveur MySQL.  ex. mysql5-26.perso.db
   $db_name           = "pkfare_ibs"; // Nom de la base de données.  ex. mabase
   $db_username       = "pkfare_ibs"; // Nom de l'utilisateur / utilisatrice
   $db_password       = "%_=]pOpeuA}!"; // Mot de passe de la base de données.

    // Pas besoin de modifier ci-dessous
   $date = date('Y-m-d-H\hi\ms\s');

   $cmd_mysql = "mysqldump";
   $archive_GZIP      = "archive-".$db_name."-".$date.".gz";

   echo " Sauvegarde en cours de la base <b>$db_name</b> <br><br> Serveur : <b>".$db_server."</b><br>Fichier de destination : <b>$archive_GZIP</b> <br> <br> \n";

   $commande = $cmd_mysql." --host=$db_server --user=$db_username --password=$db_password -C -Q -e --default-character-set=$db_charset  $db_name  | gzip -c > $archive_GZIP ";

   $CR_exec = system($commande);

   if (file_exists($archive_GZIP))

      {
      $Taille_Sauve = filesize($archive_GZIP);
      echo "✔ Génération effectuée. Taille <b>".$Taille_Sauve." Ko</b>. \n";
      }

   echo "<br><br> <b>Fin</b><br><br> Pensez à conserver cette sauvegarde dans un endroit approprié. <br> Ce fichier de sauvegarde peut contenir des données sensibles (mot de passes, données personnelles, etc)";
?>
