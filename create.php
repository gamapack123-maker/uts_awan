<?php
require 'config.php';
require 'header.php';


$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
$name = trim($_POST['name']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);
$booking_date = $_POST['booking_date'];
$booking_time = $_POST['booking_time'];
$duration_minutes = (int)$_POST['duration_minutes'];
$package = trim($_POST['package']);
$notes = trim($_POST['notes']);


if($name === '') $errors[] = 'Nama wajib diisi.';
if($booking_date === '' || $booking_time === '') $errors[] = 'Tanggal dan waktu wajib diisi.';


if(empty($errors)){
$stmt = $pdo->prepare('INSERT INTO bookings (name, phone, email, booking_date, booking_time, duration_minutes, package, notes) VALUES (?,?,?,?,?,?,?,?)');
$stmt->execute([$name,$phone,$email,$booking_date,$booking_time,$duration_minutes,$package,$notes]);
header('Location: index.php'); exit;
}
}
?>


<h2>Buat Booking Baru</h2>
<?php if($errors): ?>
<div class="errors"><?= implode('<br>', array_map('htmlspecialchars',$errors)) ?></div>
<?php endif; ?>


<form method="post">
<label>Nama<br><input name="name" required></label>
<label>Phone<br><input name="phone"></label>
<label>Email<br><input name="email" type="email"></label>
<label>Tanggal<br><input name="booking_date" type="date" required></label>
<label>Waktu<br><input name="booking_time" type="time" required></label>
<label>Durasi (menit)<br><input name="duration_minutes" type="number" value="60"></label>
<label>Package<br><input name="package"></label>
<label>Notes<br><textarea name="notes"></textarea></label>
<button type="submit">Simpan</button>
</form>


<?php require 'footer.php'; ?>