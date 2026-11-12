<?php
require_once __DIR__.'/../config/db.php';require_role('admin');
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 foreach(['Kakang','Senduk'] as $cat){
  $mulai=$_POST['mulai'][$cat]??'';$selesai=$_POST['selesai'][$cat]??'';$status=$_POST['status'][$cat]??'tutup';
  if($mulai && $selesai && strtotime($selesai)>strtotime($mulai) && in_array($status,['buka','tutup'],true)){
   $s=$pdo->prepare("INSERT INTO periode_voting(kategori,tanggal_mulai,tanggal_selesai,status) VALUES(?,?,?,?) ON DUPLICATE KEY UPDATE tanggal_mulai=VALUES(tanggal_mulai),tanggal_selesai=VALUES(tanggal_selesai),status=VALUES(status)");
   $s->execute([$cat,str_replace('T',' ',$mulai).':00',str_replace('T',' ',$selesai).':00',$status]);
  }
 }
 $msg='Pengaturan periode disimpan.';
}
$periods=[];foreach($pdo->query("SELECT * FROM periode_voting") as $p)$periods[$p['kategori']]=$p;
$pageTitle="Periode Voting";require __DIR__.'/../includes/header.php';
?>
<section class="container py-5"><h1 class="section-title">Pengaturan Periode Voting</h1><?php if($msg): ?><div class="alert alert-success"><?= e($msg) ?></div><?php endif; ?>
<form method="post"><?php foreach(['Kakang','Senduk'] as $cat):$p=$periods[$cat]??[]; ?>
<div class="panel mb-3"><h4><?= $cat ?></h4><div class="row g-3"><div class="col-md-4"><label class="form-label">Mulai</label><input type="datetime-local" name="mulai[<?= $cat ?>]" class="form-control" required value="<?= isset($p['tanggal_mulai'])?date('Y-m-d\TH:i',strtotime($p['tanggal_mulai'])):'' ?>"></div>
<div class="col-md-4"><label class="form-label">Selesai</label><input type="datetime-local" name="selesai[<?= $cat ?>]" class="form-control" required value="<?= isset($p['tanggal_selesai'])?date('Y-m-d\TH:i',strtotime($p['tanggal_selesai'])):'' ?>"></div>
<div class="col-md-4"><label class="form-label">Status</label><select name="status[<?= $cat ?>]" class="form-select"><option value="tutup" <?= ($p['status']??'tutup')==='tutup'?'selected':'' ?>>Tutup</option><option value="buka" <?= ($p['status']??'')==='buka'?'selected':'' ?>>Buka</option></select></div></div></div><?php endforeach; ?>
<button class="btn btn-green">Simpan Pengaturan</button></form></section>
<?php require __DIR__.'/../includes/footer.php'; ?>
