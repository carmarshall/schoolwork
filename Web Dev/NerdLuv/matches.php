<!--  Name: Carlyn Marshall
      Assignment: NerdLuv Dating Application
      File: matches.php
      Description: The matches.php file generates a form for the user to
      input 'their' name, and submit it in order to query matches.
      The text input field will use a the PHP "get" method to retain the
      name on the server, so the code within the matches-submit.php page
      can have access.
-->

<?php include("top.html"); ?>

<body>
<div>
  <form method="get" action="matches-submit.php">
    <fieldset>
      <legend>Returning User:</legend>
        <ul>
          <li> <label for="name"><strong>Name:</strong></label>
            <div class="shadow" id="size-16">
              <input type="text" size="16" name="name" />
            </div>
          </li>
          <br />
        <li>  <input type="submit" value="View My Matches" />
        </li>
    </fieldset>
  <form>
</div>
</body>


<?php include("bottom.html"); ?>
