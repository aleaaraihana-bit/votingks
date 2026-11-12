<?php
if (!isset($pageTitle)) $pageTitle = "VotingKS";
$prefix = (str_contains($_SERVER['SCRIPT_NAME'], '/admin/') || str_contains($_SERVER['SCRIPT_NAME'], '/pemilih/')) ? '../' : '';
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle) ?> | VotingKS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= $prefix ?>assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark nav-vks sticky-top">
 <div class="container">
  <a class="navbar-brand fw-bold" href="<?= $prefix ?>index.php">VOTING<span>KS</span></a>
  <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMain"><span class="navbar-toggler-icon"></span></button>
  <div class="collapse navbar-collapse" id="navMain">
   <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
    <li class="nav-item"><a class="nav-link" href="<?= $prefix ?>index.php">Beranda</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= $prefix ?>kontestan.php">Kontestan</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= $prefix ?>hasil.php">Papan Peringkat</a></li>
    <?php if (is_logged_in()): ?>
      <li class="nav-item"><a class="nav-link" href="<?= $prefix . ($_SESSION['user']['role']==='admin' ? 'admin/dashboard.php' : 'pemilih/dashboard.php') ?>">Dashboard</a></li>
      <li class="nav-item"><a class="btn btn-outline-light btn-sm px-3" href="<?= $prefix ?>logout.php">Keluar</a></li>
    <?php else: ?>
      <li class="nav-item"><a class="btn btn-gold btn-sm px-3" href="<?= $prefix ?>login.php">Masuk</a></li>
      <li class="nav-item"><a class="nav-link" href="<?= $prefix ?>register.php">Daftar</a></li>
    <?php endif; ?>
   </ul>
  </div>
 </div>
</nav>
<main>
