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
                      /* ALL THE FUNCTIONS */

/* find_matches() : This function will parse the "singles.txt" CSV file
  and create a 2D array that will make the data accessible to query
  It will then identify all of the queried client's attributes and use
  them to create a date array that holds all of the corresponding
  field quantities used to filter matches */
function find_matches() {
    # request from the server
  $name  = htmlspecialchars($_GET["name"]);
    # $all_singles : stores the entire "singles.txt" file
  $all_singles = file('singles.txt');
    # $each_single : holds each line of the "singles.txt"
  $each_single = [];
    # $info_single : is an array of each single's information
  $info_single = [];
  /* $info : is a 2D array where the line number is the first index, the
     second index is the information for each person
     (i.e. $info[0][name] = Ada Lovelace
     because she is listed on the first line of the file) */
  $info = array();
  for ($i = 0; $i < 7; $i++){
    $info[$i] = array();
  }
  for ($i = 0; $i < count($all_singles); $i++) {
      $each_single[$i] = $all_singles[$i];
      $info_single = explode(",", $each_single[$i]);
      $info[$i][name] = $info_single[0];
      $info[$i][gender] = $info_single[1];
      $info[$i][age] = $info_single[2];
      $info[$i][type] = $info_single[3];
      $info[$i][os] = $info_single[4];
      $info[$i][minage] = $info_single[5];
      $info[$i][maxage] = $info_single[6];
  }

  $attributes_for_client = [];
  $line = 0;
    # identify which line the client is on in the "singles.txt" CSV
  while ($name != $info[$line][name]) {
    $line++;
   }
    # use that line to store all of the attributes of the client
  $attributes_for_client[gender] = $info[$line][gender];
  $attributes_for_client[minage] = $info[$line][minage];
  $attributes_for_client[maxage] = $info[$line][maxage];
  $attributes_for_client[os] = $info[$line][os];
  $attributes_for_client[type] = $info[$line][type];


  $attributes_for_date = [];

  /* Assign the appropriate value for the date's gender search parameter */
  $attributes_for_client[gender] == "F" ?
        $attributes_for_date[gender] = "M" : $attributes_for_date[gender] = "F";

  /* Assign the client's preferred operating system to
      the date's preferred operating system */
  $attributes_for_date[os] = $attributes_for_client[os];

  /* FILTER to find MATCHES */
  for ($i = 0; $i < count($all_singles); $i++){
    # gender check
      if ($info[$i][gender] == $attributes_for_date[gender]){
        # os check
        if ($info[$i][os] == $attributes_for_date[os]){
          # age check min
          if ($info[$i][age] >= $attributes_for_client[minage]){
            # age check max
            if ($info[$i][age] <= $attributes_for_client[maxage]){
              # type check
              if (type_match($info[$i][type], $attributes_for_client[type]) > 0){
                /* finally! Now that a match has been located, pass the
                corresponding information of the match/date to the display
                function */
                display_matches($info[$i][name], $info[$i][gender],
                                $info[$i][age], $info[$i][type], $info[$i][os]);
              }
            }
          }
        }
      }
    }
}

/* Will brake down the personality types of the client and the potential date,
   this function will return whether or not this is a match when considering
   Personality Type */
function type_match($type_date, $type_client) {

    $brake_type_client = [];
    $brake_type_date = [];
    $compatibility = 0;

    $brake_type_date = str_split($type_date);
    $brake_type_client = str_split($type_client);

    for ($i = 0; $i < 4; $i++){
        switch ($brake_type_client[$i]) {
          case $brake_type_date[0]:
               $compatibility++;
               break;
          case $brake_type_date[1]:
               $compatibility++;
               break;
          case $brake_type_date[2]:
               $compatibility++;
               break;
          case $brake_type_date[3]:
               $compatibility++;
               break;
         }
    }
  return $compatibility;
}
                    /* END OF THE FUNCTIONS */
?>

<?php include("top.html"); ?>

<?php $name  = htmlspecialchars($_GET["name"]); ?>

<h1>Matches for <?= $name ?></h1>
<!--
  find_matches() : This function will parse the "singles.txt" CSV file
     and find matches/dates for the client
-->
<?php find_matches(); ?>
<!--
  display_matches() : This function will display all of the accurate
    information for the matches
-->
<?php function display_matches($name, $gender, $age, $type, $os){ ?>
  <div class="match">
    <p>
      <img src="images/user.jpg" alt="icon" />
        <?= $name ?>
    </p>
    <ul>
        <li> <strong>gender:</strong> <?= $gender ?>
        </li>
        <li> <strong>age:</strong> <?= $age ?>
        </li>
        <li> <strong>type:</strong> <?= $type ?>
        </li>
        <li> <strong>OS:</strong> <?= $os ?>
    </ul>
</div>
<?php } ?> <!-- close display_matches() -->

<?php include("bottom.html"); ?>
