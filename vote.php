<?php
require_once __DIR__.'/../config/db.php';require_role('pemilih');
$cat=$_GET['kategori']??$_POST['kategori']??'';
if(!in_array($cat,['Kakang','Senduk'],true)){header('Location: dashboard.php');exit;}
$p=$pdo->prepare("SELECT * FROM periode_voting WHERE kategori=? LIMIT 1");$p->execute([$cat]);$period=$p->fetch();
if(!$period || $period['status']!=='buka' || strtotime($period['tanggal_mulai'])>time() || strtotime($period['tanggal_selesai'])<time()){exit('Voting kategori ini sedang tidak dibuka.');}
$check=$pdo->prepare("SELECT id FROM voting WHERE user_id=? AND kategori=?");$check->execute([$_SESSION['user']['id'],$cat]);if($check->fetch()){exit('Kamu sudah memberikan suara untuk kategori ini.');}
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $kid=(int)($_POST['kontestan_id']??0);
 try{
  $valid=$pdo->prepare("SELECT id FROM kontestan WHERE id=? AND kategori=? AND status='aktif'");$valid->execute([$kid,$cat]);
  if(!$valid->fetch()){$error='Kontestan tidak valid.';}
  else{$ins=$pdo->prepare("INSERT INTO voting(user_id,kontestan_id,kategori) VALUES(?,?,?)");$ins->execute([$_SESSION['user']['id'],$kid,$cat]);header('Location: dashboard.php?vote=success');exit;}
 }catch(PDOException $e){$error='Suara tidak dapat disimpan. Kemungkinan kamu sudah memilih kategori ini.';}
}
$s=$pdo->prepare("SELECT * FROM kontestan WHERE kategori=? AND status='aktif' ORDER BY nomor_peserta");$s->execute([$cat]);$rows=$s->fetchAll();
$pageTitle="Voting $cat";require __DIR__.'/../includes/header.php';
?>
<section class="container py-5"><div class="text-center mb-4"><div class="eyebrow">Satu suara untuk pilihanmu</div><h1 class="section-title">Pilih <?= e($cat) ?></h1><p class="text-secondary">Pilih dengan teliti. Suara yang dikirim tidak dapat diubah.</p></div>
<?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<form method="post" onsubmit="return confirm('Kirim pilihan ini? Suara tidak dapat diubah.');"><input type="hidden" name="kategori" value="<?= e($cat) ?>">
<div class="row g-4"><?php foreach($rows as $c): ?><div class="col-sm-6 col-lg-4"><label class="card card-vks h-100">
<img src="<?= e($c['foto']?'../'.$c['foto']:'../assets/img/no-photo.svg') ?>" class="contestant-photo" alt="">
<div class="card-body"><div class="form-check"><input class="form-check-input" type="radio" name="kontestan_id" value="<?= (int)$c['id'] ?>" required><span class="form-check-label fw-bold"><?= e($c['nama']) ?></span></div><span class="text-secondary small"><?= e($c['asal_instansi']) ?></span></div>
</label></div><?php endforeach; ?></div>
<div class="text-center mt-4"><button class="btn btn-gold rounded-pill px-5 py-3">Kirim Suara</button></div></form></section>
<?php require __DIR__.'/../includes/footer.php'; ?>
