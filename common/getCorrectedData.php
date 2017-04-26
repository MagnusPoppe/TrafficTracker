<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 27/03/2017
 * Time: 13:25
 */

function getCorrectedData( $ip )
{
    // creating url using the ip address variable
    $url = "http://ipinfo.io/$ip/json";

    // create curl resource
    $ch = curl_init();

    // set url
    curl_setopt($ch, CURLOPT_URL, $url);

    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // $output contains the output string
    $output = curl_exec($ch);

    // close curl resource to free up system resources
    curl_close($ch);

    return json_decode($output, true);
}