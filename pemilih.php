<?php
require_once __DIR__.'/../config/db.php';require_role('admin');
$pageTitle="Data Pemilih";$rows=$pdo->query("SELECT u.id,u.nama,u.email,u.created_at,COUNT(v.id) AS jumlah_vote FROM users u LEFT JOIN voting v ON v.user_id=u.id WHERE u.role='pemilih' GROUP BY u.id ORDER BY u.created_at DESC")->fetchAll();
require __DIR__.'/../includes/header.php';
?>
<section class="container py-5"><h1 class="section-title">Data Pemilih</h1><div class="panel table-responsive"><table class="table"><thead><tr><th>Nama</th><th>Email</th><th>Jumlah suara</th><th>Terdaftar</th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><?= e($r['nama']) ?></td><td><?= e($r['email']) ?></td><td><?= (int)$r['jumlah_vote'] ?></td><td><?= e($r['created_at']) ?></td></tr><?php endforeach; ?></tbody></table></div></section>
<?php require __DIR__.'/../includes/footer.php'; ?>
