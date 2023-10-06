<?php

http_response_code(200);

date_default_timezone_set('Asia/Bangkok');

include_once dirname(__FILE__) . '/database.php';

$now = new DateTime();

if (
    empty($_REQUEST['temp']) ||
    empty($_REQUEST['humidity'])
) {
    print "Request is Not Working.";
    exit();
}

$temp = $_REQUEST['temp'];
$humidity = $_REQUEST['humidity'];

$datenow = $now->format("Y-m-d H:i:s");

$sql = "INSERT INTO iotlog (temp, humidity, timestamp) VALUES (:temp, :humidity, :datestamp)";

$query = $db->prepare($sql);
$results = [];
try {
    $db->beginTransaction();

    $query->bindParam(":temp", $temp, PDO::PARAM_STR);
    $query->bindParam(":humidity", $humidity, PDO::PARAM_STR);
    $query->bindParam(":datestamp", $datenow, PDO::PARAM_STR);
    $query->execute();

    $db->commit();

    $results['status'] = 'success';
    $results['message'] = 'Insert Data Complete';
    $json = json_encode($results);
    echo $json;
} catch (PDOException $e) {
    $db->rollback();
    $results['status'] = 'error';
    $results['message'] = $e->getMessage();
    $json = json_encode($results);
    echo $json;
}
