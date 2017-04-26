<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 27/03/2017
 * Time: 16:17
 */


function putVisitorPrivate($hostname, $org, $city, $country, $lat, $lng, $id = null, $ip = null)
{
    // Connecting to model
    $connection = connect();

    $query = "";
    
    if ($id == null) 
    {
        $query = "UPDATE traffic_visitors SET 
                    hostname = ?,
                    organisation = ?,
                    city = ?, 
                    country = ?, 
                    latitude = ?, 
                    longitude = ?
                WHERE
                  ip = ?";
    }
    else 
    {
        $query = "UPDATE traffic_visitors SET 
                    hostname = ?,
                    organisation = ?,
                    city = ?, 
                    country = ?, 
                    latitude = ?, 
                    longitude = ?
                WHERE
                  id = ?";
    }


    if ( $stmt = $connection->prepare( $query ) )
    {
        if ($id == null)
            $stmt->bind_param("ssssdds", $hostname, $org, $city, $country, $lat, $lng, $ip);
        else
            $stmt->bind_param("ssssddi", $hostname, $org, $city, $country, $lat, $lng, $id);

        $stmt->execute();
        $stmt->close();
    }

    $connection->close();
}

function putVisitor($JSON)
{
    $visitor = json_decode($JSON, true);

    putVisitorPrivate(
        $visitor['hostname'],
        $visitor['organisation'],
        $visitor['city'],
        $visitor['country'],
        $visitor['latitude'],
        $visitor['longitude'],
        null,
        $visitor['ip']
    );
}