<?php
require 'config.php';
require 'header.php';


// Pagination simple
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 10;
$offset = ($page - 1) * $perPage;


$stmt = $pdo->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM bookings ORDER BY booking_date, booking_time LIMIT :limit OFFSET :offset');
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$bookings = $stmt->fetchAll();
$total = (int)$pdo->query('SELECT FOUND_ROWS()')->fetchColumn();
$pages = (int)ceil($total / $perPage);
?>


<h2>Bookings</h2>
<table class="table">
<thead><tr><th>#</th><th>Nama</th><th>Tanggal</th><th>Waktu</th><th>Durasi</th><th>Package</th><th>Aksi</th></tr></thead>
<tbody>
<?php foreach($bookings as $b): ?>
<tr>
<td><?= htmlspecialchars($b['id']) ?></td>
<td><?= htmlspecialchars($b['name']) ?></td>
<td><?= htmlspecialchars($b['booking_date']) ?></td>
<td><?= htmlspecialchars(substr($b['booking_time'],0,5)) ?></td>
<td><?= htmlspecialchars($b['duration_minutes']) ?> min</td>
<td><?= htmlspecialchars($b['package']) ?></td>
<td>
<a href="view.php?id=<?= $b['id'] ?>">View</a> |
<a href="edit.php?id=<?= $b['id'] ?>">Edit</a> |
<a href="delete.php?id=<?= $b['id'] ?>" onclick="return confirm('Hapus booking?')">Delete</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>


<?php if($pages > 1): ?>
<nav class="pagination">
<?php for($i=1;$i<=$pages;$i++): ?>
<a href="?page=<?= $i ?>" class="<?= $i== $page ? 'active' : '' ?>"><?= $i ?></a>
<?php endfor; ?>
</nav>
<?php endif; ?>


<?php require 'footer.php'; ?>