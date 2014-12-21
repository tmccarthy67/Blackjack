<?
session_start();
session_destroy();
session_start();

$NUM_CARDS  = 2;
$num_player = "";

function set_player_number($num_player) {
	global $GAME_STATE, $NUM_PLAYERS, $NUM_CARDS;
	$NUM_PLAYERS = $num_player;
	new_game();
}

function new_game() {

	global $GAME_STATE, $NUM_PLAYERS, $NUM_CARDS;
	$player_counter = 0;

	$deck = glob('cards/*.png');
	shuffle($deck);

	//deal cards
	$hands = array();
	for ($p = 0; $p < $NUM_PLAYERS; $p++) {
		//create a new player (list/hand of cards)
		$hand = array();
		//give player cards from the deck
		for ($i = 0; $i < $NUM_CARDS; $i++) {
			$card = array_pop($deck);// remove card from deck
			array_push($hand, $card);// add that card to the players hand
		}
		//add player to the list of players
		array_push($hands, $hand);
	}
	$GAME_STATE['hands']             = $hands;
	$GAME_STATE['deck']              = $deck;
	$GAME_STATE['number_of_players'] = $NUM_PLAYERS;
	$GAME_STATE['counter']           = $player_counter;
	redirect();
}

function redirect() {
	// load index
	global $GAME_STATE, $NUM_PLAYERS, $NUM_CARDS;
	$_SESSION['state'] = $GAME_STATE;
	header("Location: ./index.php");
}

// get player number
echo "<form method='get'>
		Number of players: <input type='number' name='num_player'>
		<input type='submit'>
		</form>";

$num_player = ($_GET['num_player']);

if ($num_player) {
	$num_player = intval($num_player);
	set_player_number($num_player+1);
}

?>
