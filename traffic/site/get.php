<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 24/03/2017
 * Time: 18:33
 */

function getSiteLog()
{

    // Connecting to model, The queries needs two connections:
    $connection  = connect();

    // Queries
    $query = <<<_end
    SELECT 
        traffic_visitors.ip AS 'IP', 
        traffic_visits.date AS 'date', 
        traffic_sites.siteID AS 'siteID', 
        traffic_sites.description AS 'description'
    
    FROM  
        traffic_visitors, 
        traffic_visits, 
        traffic_sites
        
    WHERE (traffic_visitors.id = traffic_visits.VisitorID)
    AND   (traffic_visits.siteID = traffic_sites.siteID);
_end;


    if ( $result = $connection->query( $query ) )
    {
        $data = Array();
        $i = 0;
        while ($row = $result->fetch_assoc())
        {
            $data[$i++] = Array(
                "ip" => $row["IP"],
                "date" => $row["date"],
                "siteID" => $row["siteID"],
                "description" => $row["description"]
            );
        }

        $result->close();
        $connection->close();

        return $data;
    }
    else
    {
        $connection->close();
        return null;
    }
}