<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 27/03/2017
 * Time: 09:07
 */

function getStatistics()
{
    return array(
        "TotalVisits" => getVisitsCount(),
        "MonthlyVisits" => getVisitsCount(true)
    );

}

function getVisitsCount( $lastMonth = false )
{

    // Connecting to model:
    $connection  = connect();

    $query = "SELECT COUNT(date) AS 'count' FROM traffic_visits";

    if ($lastMonth)
    {
       $query .= "WHERE (MONTH(date) = MONTH(NOW())) AND (YEAR(date) = YEAR(NOW()))" ;
    }

    if ( $result = $connection->query( $query ) )
    {

        $data = null;
        $i = 0;
        if ($row = $result->fetch_assoc())
        {
            $data = Array(
                "count" => $row["count"],
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