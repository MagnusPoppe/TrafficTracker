<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 11/04/2017
 * Time: 12:53
 */

function deleteVisitor($ip)
{

    $visitor = getVisitor($ip);

    if ($visitor == null)
    {
        return null;
    }

    // Deleting all visits for given visitor because of foreign key constraints.
    deleteVisits($visitor["id"]);


    // Connecting to model
    $connection = connect();
    $query = "DELETE FROM traffic_visitors WHERE id=?";
    if ( $stmt = $connection->prepare( $query ) )
    {
        $stmt->bind_param("i", $visitor["id"]);
        $stmt->execute();
        $stmt->close();
    }

    $connection->close();
}

function deleteVisits($id)
{
    $connection = connect();

    $query = "DELETE FROM traffic_visits WHERE VisitorID=?";

    if ( $stmt = $connection->prepare( $query ) )
    {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    $connection->close();
}