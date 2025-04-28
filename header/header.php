<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link href="../style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class = "d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg bg-secondary-subtle">
    <div class="container-fluid">
        <a class="navbar-brand" href="../home/home.php">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../carrello/cart.php">Carrello</a>
                </li>
                <?php if (!isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../login_utente/login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
            <?php if (isset($_SESSION['username'])): ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
              <span class="navbar-text">
                Benvenuto, <?= htmlspecialchars($_SESSION['username']); ?>
              </span>
                    </li>

                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div class = "container mt-5 flex-grow-1">


