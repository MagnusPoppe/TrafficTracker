<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 23/03/2017
 * Time: 13:08
 */

require_once __DIR__ . "/../classified/logon.php";
require_once __DIR__ . "/../common/output.php";

function getTraffic()
{
    // Connecting to model, The queries needs two connections:

    $connection  = connect();
    $connection2 = connect();

    // Queries
    $queryVisior = "SELECT * FROM  traffic_visitors";
    $queryVisits = "SELECT date, siteID FROM traffic_visits WHERE VisitorID = ?";

    $payload = array();

    if ( $result = $connection->query( $queryVisior ) )
    {
        $i = 0; // INDEX FOR

        // Getting visitor data:
        while ($row = $result->fetch_assoc())
        {
            $payload[$i] = array(
                "id"        => $row['id'],
                "ip"        => $row["ip"],
                "hostname"  => $row["hostname"],
                "city"      => $row["city"],
                "country"   => $row["country"],
                "org"       => $row["organisation"],
                "latitude"  => $row["latitude"],
                "longitude" => $row["longitude"],
                "visits"    => Array()
            );

            // Getting all visits for the given visitor:
            if ($stmt = $connection2->prepare($queryVisits))
            {
                $j = 0;
                $stmt->bind_param("i", $row['id']);
                $stmt->execute();
                $stmt->bind_result($date, $site);

                while( $stmt->fetch() )
                {
                    $payload[$i]["visits"][$j++] = array(
                        "datetime"  => $date,
                        "site"      => $site
                    );
                }
            }

            // Preparing for next visitor:
            $stmt->close();
            $i++;
        }

        // Closing/finishing result:
        $result->close();
        $connection->close();
        $connection2->close();

        // Formatting data to json:
        return $payload;
    }
    else
        die(displayMessage("No posts found."));
}

