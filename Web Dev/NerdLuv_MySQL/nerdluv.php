<?php
/* Name: Carlyn Marshall
   Date: April 23th 2017
   Assignment: Web Development and Database NerdLuv Dating Assignment
   Description: Revising the front end of the NerdLuv dating application
                to enable communication using HTTP requests and JSON using
                (specifically) GET and POST PHP methods.
                Below is the NerdLuv web service using PHP with PDO to connect
                to a MySQL Database, to which the username and password is in
                the db.txt file.
*/

header("Content-type: application/json");
/* This web service should handle two types of requests:
	1) a GET request with a name parameter
	2) a POST request with the following parameters:
		- name
		- gender
		- age
		- ptype
		- os
		- minage
		- maxage
	You do not need to do validation checking on the values of the parameters.
	For this lab, we'll assume the values are all valid (no weird OS spellings, etc.)

	There are no results from the POST request. However, if a failure occurs, your
	page should return an HTTP error code of 400.

	The results of the GET request should be a json object named data with the set
	of matches as an array. For example:
	{"data":[{"name":"Dana Scully",
			  "gender":"F",
			  "age":"41",
			  "type":"ISTJ",
			  "os":"Mac OS X",
			  "minage":"36",
			  "maxage":"54"},
	         {"name":"Jadzia Dax",
			  "gender":"F",
			  "age":"46",
			  "type":"ENFJ",
			  "os":"Mac OS X",
			  "minage":"18",
			  "maxage":"32"}
			 ]
	}

	If no matches are found, return an empty data array (as follows):
	{"data":[]
	}
	If a failure occurs, your page should return an HTTP error code of 400.


/* Your db.txt file should contain two variable initializations:
	$username (probably "root", your db username)
	$login (the password for your db login) */
include("db.txt");


/* Logic to handle the POST request to add a new
user and the GET request to get matches for a user */

  # if GET (associated with matches-submit.php)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  $DB = getConnection($username, $login);
  $name = $_GET["name"];
  $user = getUser($DB, $name);

  # the $user array will be the entire row of $user's attributes
  $arr_user = array('name' => $user[0], 'gender' => $user[1], 'age' => $user[2],
                    'type' => $user[3], 'os' => $user[4], 'minage' => $user[5],
                    'maxage' => $user[6]);

  					#print "Matches for: " . $arr_user['name'] . "\n\n";

  getBasicMatches($DB, $user);


   #if POST (associated with signup-submit.php)
}else {

   $DB = getConnection($username, $login);

  # Get data
   $name = $_POST["name"];
   $gender = $_POST["gender"];
   $age = $_POST["age"];
   $type = $_POST["type"];
   $os = $_POST["os"];
   $minage = $_POST["minage"];
   $maxage = $_POST["maxage"];
   			# print "New User: " . $name . " " . $gender . " " . $age . " " . $type.
        #   " " . $os . " " . $minage . " " . $maxage;
   addUser($DB, $name, $gender, $age, $type, $os, $minage, $maxage);
}


/* This function should take in the $username and $login that were initialized
	in the db.txt file and it should use PDO to connect to the database.
	The database connection should be returned. */
function getConnection($username, $login) {
  $host = "localhost";
  $dbname = "nerdluv";

  try {
    $DB = new PDO("mysql:host=$host; dbname=$dbname", $username, $login);
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  } catch(PDOException $e) {
      echo $e->getMessage();
  }

  return $DB;
}

/* This function takes in a PDO object that should already be connected to
	the database and a variable $name that contains the user name. $name is the
	user for whom we want to find matches. This function should do a query (using
	a prepared statement) and get the row that matches the $name as a *numerically
	indexed* array. This array should be returned. */
function getUser($dbconn,$name) {

    $sql = "SELECT * FROM users WHERE name = ?;";
    $stmt = $dbconn->prepare($sql);
    if ($stmt->execute(array($name))) {
      while ($row = $stmt->fetch()) {
        return $row;
      }
    }
}

/* Given a PDO object (already connected to DB) and a numerically indexed array of data
	representing the row in the db for a user, return a result set of data that has
	1) the opposite gender from $user, 2) matching os, 3) an age between the minage of $user
	and maxage of $user. (Ignore the personality type for now). Getting these results should be
	done by a prepared statement with parameters. Return the rows in a multi-dimensional
	*associative* array (unless there are no results) */
function getBasicMatches($dbconn,$user) {

   /* Assign the appropriate value for the match's gender search parameter */
      $gender_user = $user[1];
  	  $gender_user == "F" ? $gender_match = "M" : $gender_match = "F";

    /* Assign the preferred os to the match's os search parameter */
      $os_user = $user[4];
      $os_match = $os_user;

    /* Use $minage_user and $maxage_user to do the comparison in the
        SELECT stmnt */
      $minage_user = $user[5];
      $maxage_user = $user[6];

    /* The mySQL code   */
      $gender_match = $dbconn->quote($gender_match);
      $os_match = $dbconn->quote($os_match);
      $sql = "SELECT * FROM users WHERE gender = $gender_match AND
              os = $os_match AND age >= $minage_user AND age <= $maxage_user;";
      $stmt = $dbconn->prepare($sql);
      if ($stmt->execute(array($name))) {
          while ($row = $stmt->fetch()) {
          		$arr_matches = array('name' => $row[0], 'gender' => $row[1],
                          'age' => $row[2], 'type' => $row[3], 'os' => $row[4],
                                      'minage' => $row[5], 'maxage' => $row[6]);
          		$data = array('data' => $arr_matches);
            if (getMatches($user[3], $arr_matches) > 0) {
					print json_encode($data);
              		print "\n";
            }
          }
       }
   $stmt->close();
   $dbconn->close();
}


/* Given the string representing the user's personality type and the result set from
	getting the user's basic matches (getBasicMatches), return an array containing only those
	matches that have at least one personality type letter in common with $usertype The $matches
	should be multi-dimensional associative array when passed in, and the return value should
	also be a multi-dimensional associative array (unless there are no results) */
function getMatches($usertype, $matches) {

    $brake_type_client = [];
    $brake_type_date = [];
    $compatibility = 0;

    $brake_type_date = str_split($usertype);
    $brake_type_client = str_split($matches[type]);

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


/* Given a PDO object (already connected to DB) and all of the information
necessary for a new user, this function should add the new user to the database.
Return value should be true or false */
function addUser($dbconn, $name, $gender, $age, $type, $os, $minage, $maxage) {

  $name = $dbconn->quote($name);
  $gender = $dbconn->quote($gender);
  $type = $dbconn->quote($type);
  $os = $dbconn->quote($os);

  $sql = "INSERT INTO users (name, gender, age, type, os, minage, maxage)
              VALUES ($name, $gender, $age, $type, $os, $minage, $maxage);";
  $stmt = $dbconn->prepare($sql);
  $stmt->execute();

  echo "New records created successfully";

  $stmt->close();
  $dbconn->close();

}

?>
