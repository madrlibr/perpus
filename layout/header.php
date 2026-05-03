<?php
session_start();
// Jika tidak ada session status login, tendang ke login.php
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location: " . BASE_URL . "index.php?pesan=belum_login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan Digital</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { display: flex; min-height: 100vh; background: #f8f9fa; }
        #sidebar { min-width: 250px; max-width: 250px; background: #343a40; color: white; transition: all 0.3s; }
        .content { width: 100%; padding: 20px; }

    <script src="https://cdn.tailwindcss.com"></script>
    </style>
</head>
<body>
<div id="sidebar" class="p-3">
    <h4 class="text-center mb-4">LIB-SMK</h4>
    <hr>