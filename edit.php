<?php
require 'config.php';
require 'header.php';


$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM bookings WHERE id = ?');
$stmt->execute([$id]);
$booking = $stmt->fetch();
if(!$booking){ echo '<p>Booking tidak ditemukan.</p>'; require 'footer.php'; exit; }


$errors = [];
if($_SERVER['REQUEST_METHOD']==='POST'){
$name = trim($_POST['name']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);
$booking_date = $_POST['booking_date'];
$booking_time = $_POST['booking_time'];
$duration_minutes = (int)$_POST['duration_minutes'];
$package = trim($_POST['package']);
$notes = trim($_POST['notes']);


if($name==='') $errors[]='Nama wajib diisi.';
if(empty($errors)){
$stmt = $pdo->prepare('UPDATE bookings SET name=?,phone=?,email=?,booking_date=?,booking_time=?,duration_minutes=?,package=?,notes=? WHERE id=?');
$stmt->execute([$name,$phone,$email,$booking_date,$booking_time,$duration_minutes,$package,$notes,$id]);
header('Location: index.php'); exit;
}
}
?>


<h2>Edit Booking #<?= $booking['id'] ?></h2>
<?php if($errors): ?><div class="errors"><?= implode('<br>',array_map('htmlspecialchars',$errors)) ?></div><?php endif; ?>


<form method="post">
<label>Nama<br><input name="name" value="<?= htmlspecialchars($booking['name']) ?>" required></label>
<label>Phone<br><input name="phone" value="<?= htmlspecialchars($booking['phone']) ?>"></label>
<label>Email<br><input name="email" type="email" value="<?= htmlspecialchars($booking['email']) ?>"></label>
<label>Tanggal<br><input name="booking_date" type="date" value="<?= htmlspecialchars($booking['booking_date']) ?>" required></label>
<label>Waktu<br><input name="booking_time" type="time" value="<?= htmlspecialchars($booking['booking_time']) ?>" required></label>
<label>Durasi (menit)<br><input name="duration_minutes" type="number" value="<?= htmlspecialchars($booking['duration_minutes']) ?>"></label>
<label>Package<br><input name="package" value="<?= htmlspecialchars($booking['package']) ?>"></label>
<label>Notes<br><textarea name="notes"><?= htmlspecialchars($booking['notes']) ?></textarea></label>
<button type="submit">Update</button>
</form>


<?php require 'footer.php'; ?>