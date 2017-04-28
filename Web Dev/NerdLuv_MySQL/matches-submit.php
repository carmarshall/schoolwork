<!--  Name: Carlyn Marshall
      Assignment: NerdLuv Dating Application
      File: matches-submit.php
      Description: The matches-submit.php file will access the server to grab
      the name of the client using the "htmlspecialchars($_GET["name"])" call
      that was input on the matches.php page, and use the "singles.txt" CSV to
      determine which singles match the criteria specified by the information
      of the client.
-->

<?php
    $name = $_GET["name"];

	$getdata =
      http_build_query(
      	array(
          'name' => $name
         )
       );

    $opts =
      array('http' =>
      	array(
        'method'  => 'GET',
        'content' => $getdata
         )
       );


	$url = "http://crmarsha.millersville.edu/Lab8/nerdluv.php?" . $getdata;

	$context  = stream_context_create($opts);
  $result = file_get_contents($url, false, $context);
  echo json_decode($result);

	exit;

?>

<?php include("bottom.html"); ?>
