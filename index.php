<?php
require_once __DIR__.'/config/db.php';
$pageTitle="Beranda";
$total=(int)$pdo->query("SELECT COUNT(*) FROM kontestan WHERE status='aktif'")->fetchColumn();
$kakang=(int)$pdo->query("SELECT COUNT(*) FROM kontestan WHERE kategori='Kakang' AND status='aktif'")->fetchColumn();
$senduk=(int)$pdo->query("SELECT COUNT(*) FROM kontestan WHERE kategori='Senduk' AND status='aktif'")->fetchColumn();
require __DIR__.'/includes/header.php';
?>
<section class="hero"><div class="container py-5">
 <div class="eyebrow text-warning mb-3">Pemilihan Duta Wisata Ponorogo</div>
 <h1>Suara untuk Budaya, Pilihan untuk Masa Depan.</h1>
 <p>Dukung Kakang dan Senduk terbaik yang akan membawa semangat, kreativitas, dan budaya Ponorogo lebih dikenal luas.</p>
 <a href="kontestan.php" class="btn btn-gold rounded-pill px-4 py-2 me-2">Lihat Kontestan</a>
 <a href="hasil.php" class="btn btn-outline-light rounded-pill px-4 py-2">Papan Peringkat</a>
</div></section>
<section class="container py-5">
 <div class="text-center mb-4"><div class="eyebrow">VotingKS</div><h2 class="section-title">Kenali Para Kontestan</h2><p class="text-secondary">Dua kategori, satu semangat untuk Ponorogo.</p></div>
 <div class="row g-3 text-center">
  <div class="col-md-4"><div class="panel"><h3 class="section-title"><?= $total ?></h3><span class="text-secondary">Kontestan aktif</span></div></div>
  <div class="col-md-4"><div class="panel"><h3 class="section-title"><?= $kakang ?></h3><span class="text-secondary">Kakang</span></div></div>
  <div class="col-md-4"><div class="panel"><h3 class="section-title"><?= $senduk ?></h3><span class="text-secondary">Senduk</span></div></div>
 </div>
 <div class="text-center mt-4"><a href="kontestan.php" class="btn btn-green rounded-pill px-4">Jelajahi Semua Kontestan</a></div>
</section>
<?php require __DIR__.'/includes/footer.php'; ?>
