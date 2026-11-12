<?php
require_once __DIR__.'/config/db.php';
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $email=trim($_POST['email']??'');$pass=$_POST['password']??'';
 $s=$pdo->prepare("SELECT id,nama,email,password,role FROM users WHERE email=? AND status='aktif'");$s->execute([$email]);$u=$s->fetch();
 if($u && password_verify($pass,$u['password'])){
  session_regenerate_id(true);unset($u['password']);$_SESSION['user']=$u;
  header('Location: '.($u['role']==='admin'?'admin/dashboard.php':'pemilih/dashboard.php'));exit;
 }else{$error='Email atau password tidak sesuai.';}
}
$pageTitle="Masuk";require __DIR__.'/includes/header.php';
?>
<section class="container py-5" style="max-width:520px"><div class="panel">
<div class="eyebrow">Selamat datang</div><h2 class="section-title mb-4">Masuk VotingKS</h2>
<?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<form method="post"><label class="form-label">Email</label><input class="form-control mb-3" type="email" name="email" required>
<label class="form-label">Password</label><input class="form-control mb-4" type="password" name="password" required>
<button class="btn btn-green w-100 py-2">Masuk</button></form>
<p class="text-secondary small mt-3 mb-0">Belum punya akun pemilih? <a href="register.php">Daftar di sini</a>.</p>
</div></section>
<?php require __DIR__.'/includes/footer.php'; ?>
