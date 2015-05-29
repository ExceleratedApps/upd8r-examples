<?php
//include_once '../vendor/autoload.php';
include_once 'Request.php';

use Guzzle\Http\Exception\ClientErrorResponseException;
use \Upd8r\Request;

/**
 * This demonstrates ->
 *
 * * Setting up a user.
 * * Creating a photo station.
 * * Uploading an image to the server.
 * * Triggering an image post for a user .
 *
 *
 * This complete example shows a user being created, a photo being uploaded and a post being created with that photo
 *
 */


$request = new Request('YOUR-API-KEY');



try{

    //
    // Create a New user
    //
    // Update these values to represent your test account

    $user = $request->post('/users', [
        'first_name' => 'John',
        'last_name'  => 'Smith',
        'email'      => 'john.smith@example.com'
    ]);


    /*
     * The next step of this process is for the user to register their social network, which means they could share their
     * photo to their social network.  We will ski[p this step as it requires a fb or twitter app to be setup which is
     * outside the scope of this tutorial. We can still setup a station with email and have the photo emailed to the user
     *
     * You still need mail settings setup in your account
     *
     */

    $station = $request->post('/stations/add', [
        'station_name'  => "This was a good idea",
        'use_email'     => true,
        'email_subject' => "your photo",
        'email_message' => "This is your photo %url%", //using the %url% shortcode will include it in the email
        'photo_station' => true, // this will trigger the photos to be processed
    ]);


    //
    // Upload the sample picture
    $image = $request->post('/images/add', [
            'file' => '@sample.png'
    ]);

    // Now to create a post

    $postRequest = [
        'station_id' => $station['id'],
        'user_id'    => $user['id'],
        'media_id'   => $image['id']
    ];


    $post = $request->post('/posts/add',$postRequest);

}
catch(ClientErrorResponseException $e)
{
    print_r($e->getResponse()->json());
}




