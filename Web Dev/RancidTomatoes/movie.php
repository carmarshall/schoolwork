<!--
Name: Carlyn Marshall
Assignment: PHP and HTML
Date: April 3rd, 2017
The HTML/PHP file, movie.php
-->

<!DOCTYPE html>
<html>

<head>
	<title>Rancid Tomatoes</title>

	<meta charset="utf-8" />
	<link href="movie.css" type="text/css" rel="stylesheet" />
</head>

<body>

  <div id="bannerbg">
  		<img id="banner" src="http://cs.millersville.edu/~sschwartz/366/HTML_CSS_Lab/Images/banner.png" alt="Rancid Tomatoes" />
  	</div>

  <?php
  	$movie = $_GET["film"];
		list($title, $year, $rating) = file("$movie/info.txt");
	?>

	<h1 id="title">
		<?= $title ?> (<?= trim($year) ?>)
	</h1>

<div class="box">

	<div class="overview">

			<div>
				<img id="poster" src="<?= strtolower($movie) ?>/overview.png" alt="general overview" />
			</div>

			<div id="overviewText">
				<d1>
				<?php
					/* $overview_file = the entire overview.txt file stored in an array, line by line
						$overview_file[0] = is the entire first line of the file*/
						$overview_file = file("$movie/overview.txt");
				?>

 				<!-- loop will store the values to be displayed as dt and dd -->
				<?php for ($k = 0; $k < count($overview_file); $k++): ?>
					<?php
						/* $overview_content = an array that has each end of the current line (separated by colon) */
						$overview_content = explode(":", $overview_file[$k]);
					?>
					<dt><?= $overview_content[0] ?></dt>
					<dd><?= $overview_content[1] ?><dd>
					<?php endfor; ?>
				</d1>

			</div>

		</div>
<!--*******************************************************************************************************************************************-->

	<div class="review">

			<div class="scorebanner">
				<!-- Determine which image to display -->
				<?php
					$rating_image = "";
					if ($rating > 60){
						$rating_image = "freshbig";
					} else {
						$rating_image = "rottenbig";
					}
				?>

				<img id="rottenbig"src="http://cs.millersville.edu/~sschwartz/366/HTML_CSS_Lab/Images/<?= $rating_image ?>.png" alt="Rotten" />
				<?= $rating ?>%
			</div>

			<?php
				$reviews = glob("$movie/review*.txt");
				/* $reviews - an array of the review.txt files*/
				$i = 0;
				$text = [];
				/* $text - an array of contents within each review.txt files*/
				$contents = [];
				/* $contents - an array of the contents within each review file in order*/
				/* $contents -  index 0 - the review
												index 1 - the image tag needed
												index 2 - the critic/reviewer
												index 3 - the company*/

				while ($i < count($reviews)) {
				  $text[$i] = file($reviews[$i]);
					$contents[$i] = $text[$i];
					$i++;
				}

				/* Variables assigned to determine the number of reviews to be displayed in each column */
				$num_reviews_total = count($contents);
				$num_reviews_col_2 = $num_reviews_total - $num_reviews_col_1;

				if ($num_reviews_total == 1) {
					$num_reviews_col_1 = 1;
					} else {
						$num_reviews_col_1 = round($num_reviews_total / 2);
					}
			?>

			<div class="commentcolumn">

				<div class="leftColumn">

			 	<?php for ($j = 0; $j < $num_reviews_col_1; $j++): ?>

					<?php list($r_review, $r_image, $r_critic, $r_company) = $contents[$j]; ?>
							<p class="comments">
									<img class="like" src="http://cs.millersville.edu/~sschwartz/366/HTML_CSS_Lab/Images/<?= strtolower($r_image) ?>.gif" alt= <?= $r_image ?> />
									<q><?= $r_review ?></q>
							</p>
							<p class="critic">
									<img src="http://cs.millersville.edu/~sschwartz/366/HTML_CSS_Lab/Images/critic.gif" alt="Critic" />
									<?= $r_critic ?><br />
									<span class="publication"><?= $r_company ?></span>
							</p>
					<?php endfor; ?>

				</div>

				<div class="rightColumn">
				<?php for ($j = $num_reviews_col_1; $j < $num_reviews_total; $j++): ?>

					 <? list($r_review, $r_image, $r_critic, $r_company) = $contents[$j]; ?>
							 <p class="comments">
									 <img class="like" src="http://cs.millersville.edu/~sschwartz/366/HTML_CSS_Lab/Images//<?= strtolower($r_image) ?>.gif" alt= <?= $r_image ?> />
									 <q><?= $r_review ?></q>
							 </p>
							 <p class="critic">
									 <img src="http://cs.millersville.edu/~sschwartz/366/HTML_CSS_Lab/Images/critic.gif" alt="Critic" />
									 <?= $r_critic ?><br />
									 <span class="publication"><?= $r_company ?></span>
							 </p>
				<?php endfor; ?>

			</div>
		</div>
	</div>

<p id="bottombar">(1-<?= $num_reviews_total ?>) of <?= $num_reviews_total ?></p>

</div>

<div id="validators">
		<a href="http://validator.w3.org/check/referer">
		<img src="http://cs.millersville.edu/~sschwartz/366/Images/w3c-html.png" alt="Valid HTML5" />
		</a>

		<br />

		<a href="http://jigsaw.w3.org/css-validator/check/referer">
		<img src="http://cs.millersville.edu/~sschwartz/366/Images/w3c-css.png" alt="Valid CSS" />
		</a>
</div>

</body>
</html>
