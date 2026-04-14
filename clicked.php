<?php
session_start();
include "database.php";

$email = $_SESSION['user'];
$token = $_SESSION['token'];

// Get current score
$url = SUPABASE_URL . '/rest/v1/scores?email=eq.' . urlencode($email);
$headers = [
    'apikey: ' . SUPABASE_ANON_KEY,
    'Authorization: Bearer ' . $token
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$current_score = $data[0]['score'] ?? 0;
$new_score = $current_score + 1;

// Update score
$update_url = SUPABASE_URL . '/rest/v1/scores?email=eq.' . urlencode($email);
$update_data = json_encode(['score' => $new_score]);
$update_headers = [
    'apikey: ' . SUPABASE_ANON_KEY,
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json'
];

$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, $update_url);
curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'PATCH');
curl_setopt($ch2, CURLOPT_POSTFIELDS, $update_data);
curl_setopt($ch2, CURLOPT_HTTPHEADER, $update_headers);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch2);
curl_close($ch2);

header("Location: x-dashboard.php");
?>