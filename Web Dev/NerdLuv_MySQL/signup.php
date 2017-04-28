<!--  Name: Carlyn Marshall
      Assignment: NerdLuv Dating Application
      File: signup.php
      Description: The signup.php file generates the form
      the user fills out in order to sign up for NerdLuv.
      The data provided by the user will be passed to the
      server using the form's "post" method.
-->

<?php include("top.html"); ?>

<?php
// define variable and set to empty values
$name = $gender = $age = $personality_type =
$operating_system = $seeking_min_age = $seeking_max_age = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["name"]);
  $gender = test_input($_POST["gender"]);
  $age = test_input($_POST["age"]);
  $personality_type = test_input($_POST["type"]);
  $operating_system = test_input($_POST["os"]);
  $seeking_min_age = test_input($_POST["minage"]);
  $seeking_max_age = test_input($_POST["maxage"]);
}

/* test_input() : gathers the server information and reformats it so that
    all of the attributes are stored as clear data that can be used to query */
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);

  return $data;
}
?>

<body>
  <div>
    <form method="post" action="signup-submit.php">
      <fieldset>
        <legend>New User Signup:</legend>
          <ul>
            <li> <label for="name"><strong>Name:</strong></label>
                    <div class="shadow" id="size-16">
                        <input type="text" size="16" name="name" />
                    </div>
            </li>
          <br />

            <li> <label for="gender"><strong>Gender:</strong></label>
                    <input type="radio" name="gender" value="M" /> Male
                    <input type="radio" name="gender" value="F"
                                              checked="checked" /> Female
            </li>
            <br />

            <li> <label for="age"><strong>Age:</strong></label>
                    <div class="shadow" id="size-6">
                      <input type="text" size="6" maxlength="2" name="age" />
                    </div>
            </li>
            <br />

            <li> <label for="type"><strong>Personality Type:</strong></label>
                    <input type="text" size="6" maxlength="4" name="type" />
                    (<a href="http://www.humanmetrics.com/cgi-win/JTypes2.asp">
                            Don't know your type?</a>)
            </li>
            <br />

            <li> <label for="os"><strong>Favorite OS:</strong></label>
                    <div class="shadow" id="size-drop-down">
                      <select name="os">
                        <option selected="selected">Windows</option>
                        <option>Mac OS X</option>
                        <option>Linux</option>
                      </select>
                    </div>
            </li>
            <br />

            <li> <label for="seeking-age"><strong>Seeking age:</strong></label>
                    <input type="text" size="6" maxlength="2"
                                            name="minage" placeholder="min" />
                    to
                    <input type="text" size="6" maxlength="2"
                                            name="maxage" placeholder="max" />
            </li>
            <br />
        </ul>
        <input type="submit" value="Sign Up" />

        </fieldset>
      </form>
    </div>
</body>

<?php include("bottom.html"); ?>
