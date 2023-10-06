<?php

date_default_timezone_set('Asia/Bangkok');

include_once dirname(__FILE__) . '/database.php';


$sql = "SELECT * FROM iotlog ORDER BY timestamp DESC LIMIT 1";

$query = $db->prepare($sql);

try {
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($results);
    echo $json;
} catch (PDOException $e) {
    echo json_encode($e->getMessage());
}
