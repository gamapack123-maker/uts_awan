<?php
require 'config.php';
require 'header.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM bookings WHERE id=?');
$stmt->execute([$id]);
$b = $stmt->fetch();
if(!$b){ echo '<p>Not found</p>'; require 'footer.php'; exit; }
?>
<h2>Detail Booking #<?= $b['id'] ?></h2>
<ul>
<li><strong>Nama:</strong> <?= htmlspecialchars($b['name']) ?></li>
<li><strong>Phone:</strong> <?= htmlspecialchars($b['phone']) ?></li>
<li><strong>Email:</strong> <?= htmlspecialchars($b['email']) ?></li>
<li><strong>Tanggal:</strong> <?= htmlspecialchars($b['booking_date']) ?></li>
<li><strong>Waktu:</strong> <?= htmlspecialchars($b['booking_time']) ?></li>
<li><strong>Durasi:</strong> <?= htmlspecialchars($b['duration_minutes']) ?> menit</li>
<li><strong>Package:</strong> <?= htmlspecialchars($b['package']) ?></li>
<li><strong>Notes:</strong> <?= nl2br(htmlspecialchars($b['notes'])) ?></li>
</ul>
<a href="edit.php?id=<?= $b['id'] ?>">Edit</a> | <a href="index.php">Back</a>
<?php require 'footer.php'; ?>
```


---


## File: delete.php
```php
<?php
require 'config.php';
$id = (int)($_GET['id'] ?? 0);
if($id){
$stmt = $pdo->prepare('DELETE FROM bookings WHERE id=?');
$stmt->execute([$id]);
}
header('Location: index.php'); exit;