<?php
/**
 * Created by PhpStorm.
 * User: MagnusPoppe
 * Date: 23/03/2017
 * Time: 12:43
 */


function displayMessage( $message )
{
    $output =  <<<_END
<!DOCTYPE html><html lang="en"><head>
    <meta charset="UTF-8">
    <title>6117 - Bachelorprosjekt</title>
    <link rel="stylesheet" href="/public/stylesheets/general.css">
    <link rel="stylesheet" href="/public/stylesheets/design.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head><body><main id="message"><h2>
_END;

    // ADDING MESSAGE WHERE APPROPRIATE
    $output .= $message;
    $output .= "</h2></main></body>";

    return $output;
}