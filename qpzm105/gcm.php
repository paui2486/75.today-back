<?php 
// Replace with real GCM browser / server API key from Google APIs
$apiKey = 'AIzaSyDz9Uq1VoaQVB_4KQNovwkQsN7IUHNayxg';

// Replace with real client registration IDs, most likely stored in your database
// $registrationIDs = array( 'abc', 'def' );
$registrationIDs = array( '00000000-42b9-6390-ffff-ffffad942db8' );

// Payload data to be sent
$data = array( 'message' => 'draq gcm test!' );

// Set request URL to GCM endpoint
$url = 'https://android.googleapis.com/gcm/send';

// Set POST variables (device IDs and payload)
$fields = array(
                'registration_ids'  => $registrationIDs,
                'data'              => $data,
                );

// Set request headers (authentication and payload type)
$headers = array( 
                    'Authorization: key=' . $apiKey,
                    'Content-Type: application/json'
                );

// Open connection
$ch = curl_init();

// Set the url
curl_setopt( $ch, CURLOPT_URL, $url );

// Set request method to POST
curl_setopt( $ch, CURLOPT_POST, true );

// Set custom headers
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);

// Get response back as string
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

// Set post data
curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );

// Send the request
$result = curl_exec($ch);

// Close connection
curl_close($ch);

// Debug GCM response
echo $result;

?>