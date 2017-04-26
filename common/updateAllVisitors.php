<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 27/03/2017
 * Time: 16:12
 */

function updateAllVisitors()
{
    // Connecting to model, The queries needs two connections:
    $connection  = connect();

    // Queries
    $query = "SELECT id, ip FROM traffic_visitors";

    if ( $result = $connection->query( $query ) )
    {
        while($row = $result->fetch_assoc())
        {
            // Getting more data about the address:
            $ipinfo = getCorrectedData($row["ip"]);
            $latlng = explode(",", $ipinfo["loc"]);
            putVisitorPrivate(
                $ipinfo["hostname"],
                $ipinfo["org"],
                $ipinfo["city"],
                $ipinfo["country"],
                $latlng[0],
                $latlng[1],
                $row["id"]
            );
        }
    }
    else return 400;

    $result->close();
    $connection->close();

    return 200;
}