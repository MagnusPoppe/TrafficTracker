<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 24/03/2017
 * Time: 18:33
 */

function getSiteIDLog($siteID)
{
    // Testing for exsisting site id:
    $siteData = getSiteID($siteID);
    if ($siteData == null) return null;


    // Connecting to model:
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
    AND   (traffic_visits.siteID = traffic_sites.siteID) 
    AND    traffic_sites.siteID = ?;
_end;

    if ( $stmt = $connection->prepare( $query ) )
    {
        $stmt->bind_param("i", $siteID);
        $stmt->execute();
        $stmt->bind_result($ip, $date, $siteID, $desc);

        $data = Array();
        $i = 0;
        while ($stmt->fetch())
        {
            $data[$i++] = Array(
                "ip" => $ip,
                "date" => $date,
                "siteID" => $siteID,
                "description" => $desc
            );
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