<?php
require_once __DIR__.'/config/db.php';$error='';$success='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $nama=trim($_POST['nama']??'');$email=trim($_POST['email']??'');$pass=$_POST['password']??'';
 if(strlen($pass)<8){$error='Password minimal 8 karakter.';}
 else{
  try{$s=$pdo->prepare("INSERT INTO users(nama,email,password,role,status) VALUES(?,?,?,'pemilih','aktif')");$s->execute([$nama,$email,password_hash($pass,PASSWORD_DEFAULT)]);$success='Pendaftaran berhasil. Silakan login.';}
  catch(PDOException $e){$error='Email sudah digunakan atau data tidak valid.';}
 }
}
$pageTitle="Daftar Pemilih";require __DIR__.'/includes/header.php';
?>
<section class="container py-5" style="max-width:540px"><div class="panel"><h2 class="section-title mb-3">Daftar Pemilih</h2>
<?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<?php if($success): ?><div class="alert alert-success"><?= e($success) ?> <a href="login.php">Login</a></div><?php endif; ?>
<form method="post"><label class="form-label">Nama lengkap</label><input name="nama" class="form-control mb-3" required>
<label class="form-label">Email aktif</label><input name="email" type="email" class="form-control mb-3" required>
<label class="form-label">Password (minimal 8 karakter)</label><input name="password" type="password" minlength="8" class="form-control mb-4" required>
<button class="btn btn-green w-100">Buat Akun</button></form></div></section>
<?php require __DIR__.'/includes/footer.php'; ?>
