<?php

echo "Current working directory: " . getcwd();

$returnString = "PHP -> Output OK";
$returnJson = json_encode($returnString);

if (isset($_GET['ok'])) {
    header('Content-Type: application/json');
    echo $returnJson;
} else {
    header('Content-Type: application/json');
    echo json_encode("non data");
}
