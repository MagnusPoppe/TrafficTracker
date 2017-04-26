<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 27/03/2017
 * Time: 13:36
 */

function checkForIP( $input )
{

    // CONTROLLING THE INPUT DATA:
    if ( ! isset($input) )
        die(displayMessage("No input set."));

    $control = explode(".", $input);
    if (count($control) != 4)
        die(displayMessage("Input format error."));

    foreach( $control as $byte)
    {
        if( strlen($byte) <= 0 || 3 < strlen($byte) )
            die(displayMessage("Input format error."));
    }

    // TODO: Legg til regex sanitering.
}

function postVisitor($ip)
{
    // Connecting to model
    $connection  = connect();

    // Controlling input data:
    checkForIP($ip);

    // Getting more data about the address:
    $ipinfo = getCorrectedData($ip);
    $latlng = explode(",", $ipinfo["loc"]);
    $visitor = getVisitor($ip);

    if ($visitor == null) // New visitor:
    {
        $query = "INSERT INTO traffic_visitors(ip, hostname, organisation, city, country, latitude, longitude) VALUES(?,?,?,?,?,?,?);";


        if ( $stmt = $connection->prepare( $query ) )
        {
            $stmt->bind_param("sssssdd",
                $ip,
                $ipinfo["hostname"],
                $ipinfo["org"],
                $ipinfo["city"],
                $ipinfo["country"],
                $latlng[0],
                $latlng[1]
            );
            $stmt->execute();
            $stmt->close();
        }
    }
    else putVisitorPrivate($ipinfo["hostname"], $ipinfo["org"], $ipinfo["city"], $ipinfo["country"], $latlng[0], $latlng[1], $visitor["id"]);
    $connection->close();

    logVisit($ip, 1);
}