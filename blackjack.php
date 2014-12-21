<?php

$NUM_PLAYERS = 2;
$NUM_CARDS = 2;

$GAME_STATE = array();

function new_game() {
	global $GAME_STATE, $NUM_PLAYERS, $NUM_CARDS;

	$deck = glob('cards/*.png');
	shuffle($deck);

	//deal cards
	$hands = array();
	$score = array();
	for ($p = 0; $p < $NUM_PLAYERS; $p++) {
		//create a new player (list/hand of cards)
		$hand = array();
		$score = 0;
		//give player cards from the deck
		for ($i = 0; $i < $NUM_CARDS; $i++) {
			$card = array_pop($deck);// remove card from deck
			array_push($hand, $card);// add that card to the players hand
		}
		//add player to the list of players
		array_push($hands, $hand);
	}

	$GAME_STATE['hands'] = $hands;
}

function render_hand($hand) {
	echo "<div class='hand'>";

	foreach ($hand as $card) {
		echo "
			<a href='select_card.php?card=$card'>
				<img src='$card'>
			</a>
";
	}
	echo "</div>";
}

function render_game() {
	global $NUM_PLAYERS, $GAME_STATE;
	//generate HTML to show cards
	for ($i = 0; $i < $NUM_PLAYERS; $i++) {
		$player_id = $i + 1;
		echo "<div class='player-section' data-playerid='$i'>";
		echo "<h2> Player $player_id </h2>";
		render_hand($GAME_STATE['hands'][$i]);
		echo "</div>";
	}
}

function card_rank($card) {
	return explode("_", $card)[0];
}

function get_cards_from($requested_rank, $opponent) {
	global $GAME_STATE;

	$opponent_hand = $GAME_STATE['hands'][$opponent];

	$matches = array();
	foreach ($opponent_hand as $card) {
		if (card_rank($card) == $requested_rank) {
			array_push($matches, $card);
		}
	}

	$player_id = $GAME_STATE['current_player'];
	$player_hand = $GAME_STATE['hands'][$player_id];

	$GAME_STATE['hands'][$opponent] = array_diff($opponent_hand, $matches);
	$GAME_STATE['hands'][$player_id] = array_merge($player_hand, $matches);

	return count($matches);
}

function go_fish() {
	global $GAME_STATE, $NUM_PLAYERS;

	$player_id = $GAME_STATE['current_player'];

	$card = array_pop($GAME_STATE['deck']);
	array_push($GAME_STATE['hands'][$player_id], $card);

	$GAME_STATE['current_player'] = ($player_id + 1) % $NUM_PLAYERS;

}

function book_cards($rank) {
	global $GAME_STATE;

	$player_id = $GAME_STATE['current_player'];
	$player_hand = $GAME_STATE['hands'][$player_id];

	$matches = array();
	foreach ($player_hand as $card) {
		if (card_rank($card) == 'cards/' . $rank) {
			array_push($matches, $card);
		}
	}

	if (count($matches) == 4) {
		$GAME_STATE['hands'][$player_id] = array_diff($player_hand, $matches);
		$GAME_STATE['score'][$player_id] += 1;
	}

}

function check_for_books() {
	global $GAME_STATE;

	$ranks = array('2', '3', '4', '5', '6', '7', '8', '9', '10', 'jack', 'queen', 'king', 'ace');
	foreach ($ranks as $r) {
		book_cards($r);
	}

}

function get_player_score($player_id) {
	global $GAME_STATE;
	return $GAME_STATE['score'][$player_id];
}

?>
