<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 23/03/2017
 * Time: 13:56
 */


require_once __DIR__ . '/../classified/logon.php';
require_once __DIR__ . '/../common/output.php';


function logVisit($ip, $site)
{
    // Connecting to model
    $connection  = connect();
    
    $visitor = getVisitor($ip);

    if ($visitor == null) // New visitor:
    {
        postVisitor($ip);
        return;
    }

    $query = "INSERT INTO traffic_visits VALUES(?, NOW() ,?)";

    if ( $stmt = $connection->prepare( $query ) )
    {
        $stmt->bind_param("ii", $visitor["id"], $site);
        $stmt->execute();
    }
    $stmt->close();
    $connection->close();
}