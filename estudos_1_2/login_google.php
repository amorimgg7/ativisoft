<?php

session_start();

$data = json_decode(file_get_contents("php://input"),true);

$_SESSION['google_id'] = $data['id'];
$_SESSION['email'] = $data['email'];
$_SESSION['name'] = $data['name'];
$_SESSION['picture'] = $data['picture'];

echo json_encode(["success"=>true]);