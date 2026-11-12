<?php
require_once __DIR__.'/../config/db.php';require_role('admin');
$pageTitle="Kelola Kontestan";$error='';$edit=null;
$uploadDir=__DIR__.'/../uploads/';
if(isset($_GET['hapus'])){
 $id=(int)$_GET['hapus'];
 try{$pdo->prepare("DELETE FROM kontestan WHERE id=?")->execute([$id]);header('Location: kontestan.php?msg=deleted');exit;}
 catch(PDOException $e){$error='Kontestan tidak dapat dihapus karena sudah memiliki suara. Ubah status menjadi nonaktif saja.';}
}
if(isset($_GET['edit'])){$s=$pdo->prepare("SELECT * FROM kontestan WHERE id=?");$s->execute([(int)$_GET['edit']]);$edit=$s->fetch();}
if($_SERVER['REQUEST_METHOD']==='POST'){
 $id=(int)($_POST['id']??0);$nomor=trim($_POST['nomor_peserta']??'');$nama=trim($_POST['nama']??'');$cat=$_POST['kategori']??'';$asal=trim($_POST['asal_instansi']??'');$visi=trim($_POST['visi']??'');$misi=trim($_POST['misi']??'');$desc=trim($_POST['deskripsi']??'');$status=$_POST['status']??'aktif';$foto=$_POST['foto_lama']??'';
 if(!in_array($cat,['Kakang','Senduk'],true)){$error='Kategori tidak valid.';}
 if(!$error && !empty($_FILES['foto']['name'])){
  $ext=strtolower(pathinfo($_FILES['foto']['name'],PATHINFO_EXTENSION));$allowed=['jpg','jpeg','png','webp'];
  if(!in_array($ext,$allowed,true) || $_FILES['foto']['size']>4*1024*1024){$error='Foto harus JPG, PNG, atau WEBP dan maksimal 4 MB.';}
  else{$new='kontestan_'.bin2hex(random_bytes(8)).'.'.$ext;if(move_uploaded_file($_FILES['foto']['tmp_name'],$uploadDir.$new))$foto='uploads/'.$new;else $error='Upload foto gagal.';}
 }
 if(!$error){
  if($id){$q=$pdo->prepare("UPDATE kontestan SET nomor_peserta=?,nama=?,kategori=?,asal_instansi=?,foto=?,visi=?,misi=?,deskripsi=?,status=? WHERE id=?");$q->execute([$nomor,$nama,$cat,$asal,$foto,$visi,$misi,$desc,$status,$id]);}
  else{$q=$pdo->prepare("INSERT INTO kontestan(nomor_peserta,nama,kategori,asal_instansi,foto,visi,misi,deskripsi,status) VALUES(?,?,?,?,?,?,?,?,?)");$q->execute([$nomor,$nama,$cat,$asal,$foto,$visi,$misi,$desc,$status]);}
  header('Location: kontestan.php?msg=saved');exit;
 }
}
$rows=$pdo->query("SELECT k.*,(SELECT COUNT(*) FROM voting v WHERE v.kontestan_id=k.id) AS suara FROM kontestan k ORDER BY kategori,nomor_peserta")->fetchAll();
require __DIR__.'/../includes/header.php';
?>
<section class="container py-5"><div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3"><div><div class="eyebrow">Admin</div><h1 class="section-title">Kelola Kontestan</h1></div><a href="dashboard.php" class="btn btn-outline-secondary">Dashboard</a></div>
<?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<div class="panel mb-4"><h4><?= $edit?'Edit Kontestan':'Tambah Kontestan' ?></h4>
<form method="post" enctype="multipart/form-data"><input type="hidden" name="id" value="<?= (int)($edit['id']??0) ?>"><input type="hidden" name="foto_lama" value="<?= e($edit['foto']??'') ?>">
<div class="row g-3"><div class="col-md-3"><label class="form-label">Nomor peserta</label><input name="nomor_peserta" class="form-control" required value="<?= e($edit['nomor_peserta']??'') ?>"></div>
<div class="col-md-5"><label class="form-label">Nama lengkap</label><input name="nama" class="form-control" required value="<?= e($edit['nama']??'') ?>"></div>
<div class="col-md-4"><label class="form-label">Kategori</label><select name="kategori" class="form-select" required><option value="">Pilih</option><?php foreach(['Kakang','Senduk'] as $v): ?><option <?= ($edit['kategori']??'')===$v?'selected':'' ?>><?= $v ?></option><?php endforeach; ?></select></div>
<div class="col-md-6"><label class="form-label">Asal sekolah/instansi</label><input name="asal_instansi" class="form-control" required value="<?= e($edit['asal_instansi']??'') ?>"></div>
<div class="col-md-6"><label class="form-label">Foto (JPG/PNG/WEBP, maks. 4 MB)</label><input type="file" name="foto" accept=".jpg,.jpeg,.png,.webp" class="form-control"></div>
<div class="col-12"><label class="form-label">Visi</label><textarea name="visi" class="form-control" rows="2"><?= e($edit['visi']??'') ?></textarea></div>
<div class="col-12"><label class="form-label">Misi</label><textarea name="misi" class="form-control" rows="3"><?= e($edit['misi']??'') ?></textarea></div>
<div class="col-12"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="2"><?= e($edit['deskripsi']??'') ?></textarea></div>
<div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select"><option value="aktif" <?= ($edit['status']??'aktif')==='aktif'?'selected':'' ?>>Aktif</option><option value="nonaktif" <?= ($edit['status']??'')==='nonaktif'?'selected':'' ?>>Nonaktif</option></select></div>
<div class="col-12"><button class="btn btn-green">Simpan Kontestan</button> <a href="kontestan.php" class="btn btn-outline-secondary">Reset</a></div></div></form></div>
<div class="panel"><h4>Daftar Kontestan</h4><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Foto</th><th>Nama</th><th>Kategori</th><th>Suara</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><img src="<?= e($r['foto']?'../'.$r['foto']:'../assets/img/no-photo.svg') ?>" width="48" height="58" style="object-fit:cover;border-radius:8px"></td><td><?= e($r['nama']) ?></td><td><?= e($r['kategori']) ?></td><td><?= (int)$r['suara'] ?></td><td><?= e($r['status']) ?></td><td><a href="?edit=<?= (int)$r['id'] ?>">Edit</a> · <a class="text-danger" onclick="return confirm('Hapus kontestan ini?')" href="?hapus=<?= (int)$r['id'] ?>">Hapus</a></td></tr><?php endforeach; ?>
<?php if(!$rows): ?><tr><td colspan="6" class="text-center text-secondary">Belum ada data.</td></tr><?php endif; ?></tbody></table></div></div></section>
<?php require __DIR__.'/../includes/footer.php'; ?>
