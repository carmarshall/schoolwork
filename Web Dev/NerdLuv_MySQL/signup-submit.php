<!--  Name: Carlyn Marshall
      Assignment: NerdLuv Dating Application
      File: signup-submit.php
      Description: The signup-submit.php file will welcome the client that had
      just filled out the form on the signup.php page, and provide a link to a
      matches.php login page.
-->

<?php include("top.html"); ?>

<?php
$url = 'http://crmarsha.millersville.edu/Lab8/nerdluv.php';

$data = array(
          'name' = $_REQUEST["name"],
          'gender' = $_REQUEST["gender"],
          'age' = $_REQUEST["age"],
          'type' = $_REQUEST["type"],
          'os' = $_REQUEST["os"],
          'minage' = $_REQUEST["minage"],
          'maxage' = $_REQUEST["maxage"]  /*
  		    'name' => 'Carly',
          'gender' => 'F',
          'age' => '24',
          'type' => 'YYYY',
          'os' => 'Windows',
          'minage' => '22',
          'maxage' => '33'
  */
       );

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */ }

var_dump($result);

?>
<h1>Thank you!</h1>

Welcome to NerdLuv,
  <?php print($_REQUEST["name"] . "!"); ?>
<br />
<br />
Now <a href="matches.php"> log in to see your matches! </a>

<?php include("bottom.html"); ?>
