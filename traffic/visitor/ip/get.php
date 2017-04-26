<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 23/03/2017
 * Time: 14:23
 */


function getVisitor($ip)
{
    if( $ip == null)
    {
        return null;
    }

    // Connecting to model, The queries needs two connections:
    $connection  = connect();

    // Queries
    $query = "SELECT * FROM traffic_visitors WHERE ip=?";

    if ( $stmt = $connection->prepare( $query ) )
    {
        $stmt->bind_param("s", $ip);
        $stmt->execute();
        $stmt->bind_result($id, $ip, $hostname, $org, $city, $country, $lat, $long);

        if ($stmt->fetch())
        {

            $data = array(
                "id" => $id,
                "ip" => $ip,
                "hostname" => $hostname,
                "organisation" => $org,
                "city" => $city,
                "country" => $country,
                "latitude" => $lat,
                "longitude" => $long
            );
        }
        else
        {
            $data = null;
        }

        $stmt->close();
        $connection->close();

        return $data;
    }
    else
    {
        $connection->close();
        return null;
    }
}