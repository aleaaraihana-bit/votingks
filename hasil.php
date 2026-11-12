<?php
require_once __DIR__.'/../config/db.php';require_role('admin');
$pageTitle="Hasil Voting";$rows=$pdo->query("SELECT k.nama,k.kategori,k.nomor_peserta,COUNT(v.id) AS suara FROM kontestan k LEFT JOIN voting v ON v.kontestan_id=k.id GROUP BY k.id ORDER BY k.kategori,suara DESC")->fetchAll();
require __DIR__.'/../includes/header.php';
?>
<section class="container py-5"><h1 class="section-title">Rekap Hasil Voting</h1><div class="panel table-responsive"><table class="table"><thead><tr><th>No.</th><th>Nama</th><th>Kategori</th><th>Nomor</th><th>Suara</th></tr></thead><tbody><?php foreach($rows as $i=>$r): ?><tr><td><?= $i+1 ?></td><td><?= e($r['nama']) ?></td><td><?= e($r['kategori']) ?></td><td><?= e($r['nomor_peserta']) ?></td><td><?= (int)$r['suara'] ?></td></tr><?php endforeach; ?></tbody></table></div></section>
<?php require __DIR__.'/../includes/footer.php'; ?>
