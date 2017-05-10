/*
Name : Carlyn Marshall
Date : May 5th 2017
Course: CSCI 366 - Web Development
Assignment: Fifteen Puzzle

JAVASCRIPT FILE
*/

jQuery(document).ready(function() {

			// function that will set up the puzzle
			// and adds a div to take care of the blank space
			var allPieces = setUpPuzz();

			// global variable to update where the blank tile's position is
				// start at row 3 col 3
			BLANK_TILE = "\"square_3_3\"";
			BLANK_TILE_ID = BLANK_TILE;

			// function that will indicate which tiles can be moved
			checkMovableTile($(allPieces));

			// function that will shuffle all of the tiles when
			//   the player hits the "Shuffle" button
			shuffleBoard($(allPieces));

			// function that will simulate game play,
			// only valid moves will have the
			// ability to be clicked and "moved"
			playGame($(allPieces));

			// function that is enabled when the user clicks on any tile within the
			//  puzzlearea that will alert the player when they have
			//   successfully solved!
			$(allPieces).click(function() {
													// check if the player is a winner
													if(checkWinningBoard($(allPieces))){
																	alert("YOU WON!!!!\n\n   hi nicole ;)");
													}
													if(!checkWinningBoard($(allPieces))){
																	//alert("FALSE");
													}
												 }
											 );

});

//////////START OF FUNCTIONS!//////////////////////////////////////////////////

/*
shuffleBoard() : will take the index of a valid tile and
  execute the swapTiles function
This function will be performed multiple (at least 250) times in order to
  give the user a challenge!

..wish I was not using indexes, but the assignment was due *sigh*
*/
function shuffleBoard(allPieces) {

				shuffleBtn = document.getElementById("shufflebutton");

				$(shuffleBtn).click(function() {
														 for (var i = 0; i < 500; i++) {
														// grab a random number between 0 and 15
															var rand = Math.floor(Math.random() * 15) + 0;
														// check if moving this tile is a valid move
															if ($(allPieces[rand]).hasClass("movableTile")) {
															// update the blank tile's info
																BLANK_TILE_ID = ($(allPieces[rand]).attr("id"));
																BLANK_TILE = swapTiles($(allPieces[rand]),
																					document.getElementById(BLANK_TILE));
																// reset hover
																$(allPieces).removeClass("movableTile");
																// function that will indicate which
																//  tiles can be moved
																checkMovableTile($(allPieces));
															  }
												 			 }
															}
												 		);
}

/*
playGame() : will simulate game play as the user clicks on valid tiles to move
*/
function playGame(allPieces) {

	 $(allPieces).click(function() {
											BLANK_TILE_ID = ($(this).attr("id"));
											if ($(this).hasClass("movableTile")) {
												BLANK_TILE = swapTiles($(this),
																		     document.getElementById(BLANK_TILE));
												// reset hover
												$(allPieces).removeClass("movableTile");
												// function that will indicate which tiles can be moved
												checkMovableTile($(allPieces));
											}

										 }

										);
}

/*
checkWinningBoard() : will traverse the current board's state and verify whether
or not all of the tiles are in the correct spots

..wish I was not using indexes, but the assignment was due *sigh*
*/
function checkWinningBoard(allPieces) {
	var won = true;

	for (var i = 0; i < 15; i++){
		 if ($(allPieces[i]).html() != i+1){
				 won = false;
		 }
   }
	return won;
}

/*
checkMovableTile() : is a function that identifies which tiles are adjacent
to the blank space
...really cumbersome, because in an ideal world,
                    I don't want to be using idexes at all...
.....yeah, you're gunna be scrolling for a while...
IT WORKS THO
*/
function checkMovableTile(allPieces) {
	switch(BLANK_TILE_ID) {
		case("\"square_0_0\""):
							var child = document.getElementById("\"square_0_1\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_1_0\"");
								$(child).addClass("movableTile");
							break;

		case("\"square_0_1\""):
							child = document.getElementById("\"square_0_0\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_1_1\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_0_2\"");
								$(child).addClass("movableTile");
							break;

		case("\"square_0_2\""):
							child = document.getElementById("\"square_0_1\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_1_2\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_0_3\"");
								$(child).addClass("movableTile");
							break;

		case("\"square_0_3\""):
							child = document.getElementById("\"square_0_2\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_1_3\"");
								$(child).addClass("movableTile");
							break;

		case("\"square_1_0\""):
							child = document.getElementById("\"square_0_0\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_1_1\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_2_0\"");
								$(child).addClass("movableTile");
							break;

		case("\"square_1_1\""):
							child = document.getElementById("\"square_0_1\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_1_0\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_1_2\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_2_1\"");
								$(child).addClass("movableTile");
							break;

		case("\"square_1_2\""):
							child = document.getElementById("\"square_0_2\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_1_1\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_2_2\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_1_3\"");
								$(child).addClass("movableTile");
							break;

		case("\"square_1_3\""):
							child = document.getElementById("\"square_0_3\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_2_3\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_1_2\"");
								$(child).addClass("movableTile");
							break;

		case("\"square_2_0\""):
							child = document.getElementById("\"square_1_0\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_2_1\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_3_0\"");
								$(child).addClass("movableTile");
							break;

		case("\"square_2_1\""):
							child = document.getElementById("\"square_1_1\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_2_0\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_2_2\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_3_1\"");
								$(child).addClass("movableTile");
							break;

		case("\"square_2_2\""):
							child = document.getElementById("\"square_1_2\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_2_1\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_2_3\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_3_2\"");
								$(child).addClass("movableTile");
							break;

		case("\"square_2_3\""):
							child = document.getElementById("\"square_1_3\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_2_2\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_3_3\"");
								$(child).addClass("movableTile");
							break;

		case("\"square_3_0\""):
							child = document.getElementById("\"square_2_0\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_3_1\"");
								$(child).addClass("movableTile");
							break;

		case("\"square_3_1\""):
							child = document.getElementById("\"square_3_0\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_2_1\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_3_2\"");
								$(child).addClass("movableTile");
							break;

		case("\"square_3_2\""):
							child = document.getElementById("\"square_2_2\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_3_1\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_3_3\"");
								$(child).addClass("movableTile");
							break;

		case("\"square_3_3\""):
							child = document.getElementById("\"square_3_2\"");
								$(child).addClass("movableTile");
							child = document.getElementById("\"square_2_3\"");
								$(child).addClass("movableTile");
							break;
	}
}

/*
setUpPuzz() : is a function that will do all of the leg work and assign IDs,
Positioning, and image positioning (CSS)
*/
function setUpPuzz() {

	var puzz = document.getElementById("puzzlearea");
	puzz.style.position = "relative";

	// add a div for blank tile
	$("#puzzlearea").append("<div></div>");

	// allPieces : stores all of the tiles (including blank tile)
	var allPieces = $("#puzzlearea div");

 // function that will give a row and col ID to each tile piece, and set the CSS
 setIDs_setCSS($(allPieces));

 // easy access to all of the tiles within the puzzlearea
 return $(allPieces);
}

/*
setIDs_setCSS() : is a function that will give assign a row, col, ID,
	and specific CSS to each tile piece
*/
function setIDs_setCSS(allPieces) {

		// start off with what every tile will have
    $(allPieces).attr("id", "\"square_");
		$(allPieces).addClass("tile");

		var row = 0;
		var col = 0;
		var posLeft = 0;
		var posRight = 0;

		for(var tile = 0; tile < 15; tile++){
			$(allPieces[tile]).attr("id", function(i, origValue) {
																	return origValue + row + "_" + col + "\"";
																}
															);
			$(allPieces[tile]).addClass("tile");
			$(allPieces[tile]).css({"left": 100*(tile % 4) + "px",
															"top": 100*Math.floor((tile/4)) + "px",
															"background-position": posLeft + "% " +
																							       posRight + "%"});
			col++;
			posLeft += 30;
			// drop down to next row, reset variables to the
			//   appropriate values to continue for loop
			if (col % 4 === 0) {
				col = 0;
				row++;
				posLeft = 0;
				posRight += 33;
			}
		}
		// know the "tile" at index 15 is the blank one, set ID, CSS,
		//   and POS accordingly
		$(allPieces[15]).removeClass("tile");
		$(allPieces[15]).addClass("blank");
		$(allPieces[15]).css({"left": "300px", "top": "300px"});
		$(allPieces[15]).attr("id", "\"square_3_3\"");
}

/*
swapTiles() :  This function will create the illusion of the tiles
		sliding/switching into the blank space
*/
function swapTiles(firstTile, BLANK_TILE){
	// store variables to aid readability
	var firstTilePOS = $(firstTile).css("background-position");
	var firstTileID = $(firstTile).attr("id");
	var firstTileHTML = $(firstTile).html();
  var BLANK_TILE_ID = $(BLANK_TILE).attr("id");

	// Moving the tile that was clicked on into the blank space
	$(BLANK_TILE).removeClass("blank");
	$(BLANK_TILE).addClass("tile");
	//$(blankTile).addClass("movableTile");
	$(BLANK_TILE).css("background-position", firstTilePOS);
	$(BLANK_TILE).attr("id", BLANK_TILE_ID);
	$(BLANK_TILE).html(firstTileHTML);

	// Tile that was clicked on now becomes the blank space
  $(firstTile).removeClass("tile");
	//$(firstTile).removeClass("movableTile");
  $(firstTile).addClass("blank");
	$(firstTile).attr("id", firstTileID);
	$(firstTile).html(" ");


	// update the "blank space" to be the tile that was clicked on
   return firstTileID;
}
