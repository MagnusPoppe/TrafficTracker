<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 23/03/2017
 * Time: 12:38
 */


require_once 'common/getCorrectedData.php';
require_once 'common/log.php';
require_once 'common/updateAllVisitors.php';

require_once 'traffic/get.php';
require_once 'traffic/visitor/ip/get.php';
require_once 'traffic/visitor/ip/post.php';
require_once 'traffic/visitor/ip/put.php';
require_once 'traffic/visitor/ip/delete.php';

require_once 'traffic/site/get.php';
require_once 'traffic/site/get.php';
require_once 'traffic/site/id/get.php';

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

$OK             = 200;
$NO_CONTENT     = 204;
$BAD_REQUEST    = 400;
$FORBIDDEN      = 403;
$NOT_FOUND      = 404;
$BAD_GATEWAY    = 502;

if ($request[0] == "traffic")
{
    if ( $request[1] == "site")
    {
        if ($request[2] != "")
        {
            switch ($method)
            {
                case 'GET':
                    $result = getSiteIDLog($request[1]);
                    if ($result != null)
                    {
                        echo json_encode($result);
                        http_response_code($OK);
                    }
                    else {
                        http_response_code($BAD_REQUEST);
                    }
                    break;

                default:        http_response_code($BAD_GATEWAY); break;
            }
        }
        else
        {
            switch ($method)
            {
                case 'GET':
                    echo json_encode( getSiteLog() );
                    http_response_code($OK);
                    break;

                default:        http_response_code($BAD_GATEWAY); break;
            }
        }
    }
    else if ( isset($request[1]) && $request[1] != "")
    {
        switch ($method)
        {
            case 'GET':
                $visitor = getVisitor($request[1]);
                if ($visitor != null)
                {
                    echo json_encode($visitor);
                    http_response_code($OK);
                }
                else
                    http_response_code($NOT_FOUND); // NOT FOUND
                break;

            default:        http_response_code($BAD_GATEWAY); break;
        }
    }
    else
    {
        switch ($method)
        {
            case 'GET':
                http_response_code($OK);
                echo json_encode(getTraffic());
                break;

            default:        http_response_code($BAD_GATEWAY); break;
        }
    }
}
if ($request[0] == "visitor")
{
    if ( $request[1] != null && $request[1] != "")
    {
        switch ($method)
        {
            case 'GET':
                $visitor = getVisitor($request[1]);
                if ($visitor != null)
                {
                    echo json_encode($visitor);
                    http_response_code($OK);
                }
                else
                    http_response_code($NOT_FOUND); // NOT FOUND
                break;

            case 'POST':
                echo postVisitor($request[1]);
                http_response_code($OK);
                break;

            case 'PUT':
                $data = file_get_contents("php://input");
                if (strlen($data) == 0)
                {
                    http_response_code($NO_CONTENT);
                }
                else
                {
                    putVisitor($data);
                    http_response_code($OK);
                }
                break;

            case 'DELETE':
                $data = file_get_contents("php://input");
                $assoc = json_decode($data, true);

                if ($assoc["ip"] == $request[1])
                {
                    deleteVisitor($assoc['ip']);
                    http_response_code($OK);
                }
                else http_response_code($NOT_FOUND);

                break;

            default:        http_response_code($BAD_GATEWAY); break;
        }
    }
    else
    {
        switch ($method)
        {
            default:        http_response_code($BAD_GATEWAY); break;
        }
    }
}
else if ($request[0] == "update" && $request[1] == "all")
{
    http_response_code(updateAllVisitors());
}
else
{
    switch ($method)
    {
        default:        http_response_code($BAD_GATEWAY); break;
    }
}


// LOGGING VISIT:
logVisit($_SERVER['REMOTE_ADDR'], 3);

function printpath()
{
    $request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
    $i = 0;
    $output = "";
    foreach ($request as $entry)
    {
        $output .= ("[".$i++."]=".$entry."\n");
    }
    return $output;
}