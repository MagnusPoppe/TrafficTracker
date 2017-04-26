<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 24/03/2017
 * Time: 19:08
 */


function getSiteID($id = null)
{

    // Connecting to model:
    $connection  = connect();

    $query = "SELECT * FROM traffic_sites";

    if ($id != null)
    {
        $query .= " WHERE siteID=$id";
    }

    if ( $result = $connection->query( $query ) )
    {

        $data = null;
        $i = 0;
        while ($row = $result->fetch_assoc())
        {
            $data[$i++] = Array(
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