<?
session_start();
// load game from session

$GAME_STATE = $_SESSION['state'];

$NUM_PLAYERS = $GAME_STATE['number_of_players'];

$player_counter = $GAME_STATE['counter'];

echo $player_counter;
echo $NUM_PLAYERS;

function ante_up() {
	global $GAME_STATE;
	echo "<br>";
	$GAME_STATE     = $_SESSION['state'];
	$NUM_PLAYERS    = $GAME_STATE['number_of_players'];
	$player_counter = $GAME_STATE['counter'];
	$player_counter++;

	if ($player_counter < $NUM_PLAYERS-1) {
		$GAME_STATE['counter'] = $player_counter;
		$_SESSION['state']     = $GAME_STATE;
		header("Location: ./index.php");
	}
	if ($player_counter == $NUM_PLAYERS-1) {
		$GAME_STATE['counter'] = $player_counter;
		$_SESSION['state']     = $GAME_STATE;
		header("Location: ./dealer.php");
	}
}

ante_up();

?>