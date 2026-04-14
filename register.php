<?php
include 'database.php';

$email = $_POST['email'];
$password = $_POST['password'];

$url = SUPABASE_URL . '/auth/v1/signup';
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

if (isset($result['user'])) {
    // Insert into scores
    $token = $result['access_token'];
    $insert_url = SUPABASE_URL . '/rest/v1/scores';
    $insert_data = json_encode(['email' => $email, 'score' => 0]);
    $insert_headers = [
        'apikey: ' . SUPABASE_ANON_KEY,
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ];

    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, $insert_url);
    curl_setopt($ch2, CURLOPT_POST, true);
    curl_setopt($ch2, CURLOPT_POSTFIELDS, $insert_data);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, $insert_headers);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch2);
    curl_close($ch2);

    header("Location: x-login.html");
} else {
    echo "Registration failed: " . ($result['error_description'] ?? 'Unknown error');
}
?>




