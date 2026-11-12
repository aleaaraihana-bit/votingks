<?php
require_once __DIR__.'/config/db.php';
$id=(int)($_GET['id']??0);$s=$pdo->prepare("SELECT * FROM kontestan WHERE id=? AND status='aktif'");$s->execute([$id]);$c=$s->fetch();
if(!$c){http_response_code(404);exit('Kontestan tidak ditemukan.');}
$pageTitle=$c['nama'];require __DIR__.'/includes/header.php';
?>
<section class="container py-5"><div class="row g-4 align-items-start">
<div class="col-md-5"><img src="<?= e($c['foto']?:'assets/img/no-photo.svg') ?>" class="w-100 rounded-4 shadow" alt="<?= e($c['nama']) ?>"></div>
<div class="col-md-7"><span class="tag"><?= e($c['kategori']) ?> · Nomor <?= e($c['nomor_peserta']) ?></span>
<h1 class="section-title mt-3"><?= e($c['nama']) ?></h1><p class="text-secondary"><?= e($c['asal_instansi']) ?></p>
<div class="panel mb-3"><h5 class="fw-bold">Tentang Kontestan</h5><?= nl2br(e($c['deskripsi'])) ?></div>
<div class="panel mb-3"><h5 class="fw-bold">Visi</h5><?= nl2br(e($c['visi'])) ?></div>
<div class="panel mb-3"><h5 class="fw-bold">Misi</h5><?= nl2br(e($c['misi'])) ?></div>
<a class="btn btn-green rounded-pill px-4" href="<?= is_logged_in()?'pemilih/dashboard.php':'login.php' ?>">Masuk untuk Voting</a>
</div></div></section>
<?php require __DIR__.'/includes/footer.php'; ?>
