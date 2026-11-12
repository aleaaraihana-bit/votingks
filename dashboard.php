<?php
require_once __DIR__.'/../config/db.php';require_role('pemilih');
$pageTitle="Dashboard Pemilih";
$s=$pdo->prepare("SELECT kategori FROM voting WHERE user_id=?");$s->execute([$_SESSION['user']['id']]);$voted=$s->fetchAll(PDO::FETCH_COLUMN);
$periods=$pdo->query("SELECT kategori,status,tanggal_mulai,tanggal_selesai FROM periode_voting")->fetchAll();
require __DIR__.'/../includes/header.php';
?>
<section class="container py-5"><div class="eyebrow">Area pemilih</div><h1 class="section-title">Halo, <?= e($_SESSION['user']['nama']) ?>!</h1><p class="text-secondary">Pilih satu kontestan pada setiap kategori selama periode voting dibuka.</p>
<div class="row g-3"><?php foreach(['Kakang','Senduk'] as $cat):$done=in_array($cat,$voted,true);$p=array_values(array_filter($periods,fn($x)=>$x['kategori']===$cat));$open=$p && $p[0]['status']==='buka' && strtotime($p[0]['tanggal_mulai'])<=time() && strtotime($p[0]['tanggal_selesai'])>=time(); ?>
<div class="col-md-6"><div class="panel h-100"><span class="tag"><?= e($cat) ?></span><h3 class="mt-3"><?= $done?'Suara sudah tercatat':($open?'Voting dibuka':'Voting belum tersedia') ?></h3>
<p class="text-secondary"><?= $done?'Terima kasih telah berpartisipasi.':($open?'Silakan pilih kontestan favoritmu.':'Periode voting belum dibuka atau sudah berakhir.') ?></p>
<?php if(!$done && $open): ?><a class="btn btn-green rounded-pill" href="vote.php?kategori=<?= e($cat) ?>">Pilih <?= e($cat) ?></a><?php endif; ?>
</div></div><?php endforeach; ?></div></section>
<?php require __DIR__.'/../includes/footer.php'; ?>
