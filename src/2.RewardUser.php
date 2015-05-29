<?php
include_once 'Request.php';
use Guzzle\Http\Exception\ClientErrorResponseException;
use \Upd8r\Request;


/**
 * This demonstrates ->
 *
 * * Setting up a user.
 * * Creating a game for tracking of scores.
 * * Adding scores to be tracked for the game and user.
 * * Adding tokens.
 *
 *
 * This complete example shows a user being rewarded for participating in a game.
 *
 */

try
{

$request = new Request('YOUR-API-KEY');


    /**
     * Create user
     */
    $userDetails = [
        'first_name' => 'John',
        'last_name'  => 'Smith',
        'email'      => 'john.smith@example.com',
        'rfid'       => 'RFID4JohnSmith'
    ];

    $user = $request->post('/users', $userDetails);


    /**
     * Setup game
     */

    $gameData = [
        'name' => 'Super Racing Game'
    ];

    $game = $request->post('/games/add', $gameData);


    /**
     * Add score
     */

    $scoreData = [
        'rfid'    => 'RFID4JohnSmith', // we will use the rfid as an identifier instead of a user_id
        'game_id' => $game['id'],
        'score'   => 35
    ];

    $result = $request->post('/scores/add', $scoreData);

    /**
     * Add tokens
     */

    $tokens = [
        'user_id'  => $user['id'], //we can swap back to using the user_id just to demonstrate the ability to change
        'quantity' => 2
    ];

    $tokens = $request->post('/redemption/tokens/add', $tokens);

}
catch(ClientErrorResponseException $e)
{

    print_r($e->getResponse()->getMessage());
}