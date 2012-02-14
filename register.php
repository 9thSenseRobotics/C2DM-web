<?php

/*
 * register.php
 *
 * This file does registration for phones.  This should never be hit by a human, but will be hit by the phone app.
 * The phone sends POST data that contains its device id, a name, and a google registration ID.
 *
 * This file writes these data into a MySQL database that is then used to access the registration ID for a user
 * later.
 *
 */

// connect to the database
require_once("db.php");
connectDatabase();

// check to see if we have got a valid phone registration attempt

// the post should look like this:
/* Array
 * (
 *     [deviceid] => 22a10000135615cb
 *     [phonename] => "danbot"
 *     [registrationid] => APA91bFpaCHAWJDU8SsbZRgd2bE9AwcW0WSPqzJNNxORC_7QiiGVQ-_pNLZ2vZBvbHjb1SLk2fx7S0qdtnFAgs_-
 * UChxYY0soVysg_QYnOT737U0WoI007C8BLKbNQyy4wv_sDSpj8TfArRK6_nvgvoH3jMe28lkHQ
 * )
 */

if (strlen($_POST["registrationid"]) > 0 && strlen($_POST["phonename"]) > 0 && strlen($_POST["deviceid"]) > 0)
{
    $phoneid = $_POST["registrationid"];
    $deviceid = $_POST["deviceid"];
    $phonename = $_POST["phonename"];
} else
{
    die("Input data error.");
}


// add this to the database

// remove any entries that contain this device id
$sql = "DELETE FROM phones WHERE deviceid = \"" . mysql_real_escape_string($deviceid) . "\"";
$result = mysql_query($sql);

// add this new entry
$sql = "INSERT INTO phones (name, deviceid, registration) VALUES (\"" . mysql_real_escape_string($phonename) . "\", \"" . mysql_real_escape_string($deviceid) . "\", \"" . mysql_real_escape_string($phoneid) . "\")";


$result = mysql_query($sql);

//echo $sql;

// The android app expects to see only "OK" here, nothing else.

echo "OK"

?>
