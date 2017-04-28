<!--  Name: Carlyn Marshall
      Assignment: NerdLuv Dating Application
      File: signup-submit.php
      Description: The signup-submit.php file will welcome the client that had
      just filled out the form on the signup.php page, and provide a link to a
      matches.php login page
-->

<?php include("top.html"); ?>

<?php
/* Adding the new signee's information to the singles.txt file*/
$person = [];
$person[0] = $_REQUEST["name"];
$person[1] = $_REQUEST["gender"];
$person[2] = $_REQUEST["age"];
$person[3] = $_REQUEST["type"];
$person[4] = $_REQUEST["os"];
$person[5] = $_REQUEST["minage"];
$person[6] = $_REQUEST["maxage"];

$string_of_person = implode(", ",$person);

$file = "singles.txt";
$current .= $string_of_person;
file_put_contents($file, $current."\n", FILE_APPEND);
 ?>

<h1>Thank you!</h1>

Welcome to NerdLuv,
  <?= $_REQUEST["name"]; print('!'); ?>
<br />
<br />
Now <a href="matches.php"> log in to see your matches! </a>


<?php include("bottom.html"); ?>
