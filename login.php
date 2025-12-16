<?php
session_start();

function callApi($url, $data = []) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $apiBaseUrl = "http://36.88.35.205:2025/api";
    $loginResponse = callApi($apiBaseUrl . '/login', [
        'username' => $username,
        'password' => $password
    ]);

    if(isset($loginResponse['response']['token'])) {
        $_SESSION['api_token'] = $loginResponse['response']['token'];
        $_SESSION['api_username'] = $username;
        // redirect ke dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = "Login gagal. Username atau password salah.";
        header("Location: index.html");
        exit;
    }
}
?>
