<?php

session_start();
include "database.php";

$email = $_POST['user'];
$password = $_POST['pass'];

$url = SUPABASE_URL . '/auth/v1/token?grant_type=password';
$data = json_encode(['email' => $email, 'password' => $password]);
$headers = [
    'apikey: ' . SUPABASE_ANON_KEY,
    'Content-Type: application/json'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if (isset($result['access_token'])) {
    $_SESSION['user'] = $email;
    $_SESSION['token'] = $result['access_token'];
    header("Location: x-dashboard.php");
    exit();
} else {
    echo "Login unsuccessful: " . ($result['error_description'] ?? 'Unknown error');
}

