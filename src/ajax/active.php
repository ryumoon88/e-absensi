<?php
require('../php/functions.php');
require('../php/connection.php');
session_start();

if (!isset($_SESSION['is_login'])) {
    header('Location: ../../');
}

$keyword = $_GET['q'];

$query = mysqli_prepare($conn, "SELECT absensi_id, absensi_title, absensi_desc, absensi_status, getFullName(absensi_owner) absensi_owner, expired_at FROM absensienroll ae JOIN absensilist al
USING(absensi_id) WHERE (al.absensi_owner != ? AND al.absensi_status = 'Opened' AND ae.user_id = ?)
AND (al.absensi_title LIKE '%$keyword%' OR al.absensi_desc LIKE '%$keyword%' OR al.absensi_owner LIKE '%$keyword%' OR DATE_FORMAT(al.expired_at, '%a, %d %b %Y %H:%i') LIKE '%$keyword%')");
mysqli_stmt_bind_param($query, 'ii', $_SESSION['user_id'], $_SESSION['user_id']);
mysqli_stmt_execute($query);
$unfetched = mysqli_stmt_get_result($query);
var_dump($unfetched);
?>
<?php if (!$unfetched->num_rows) : ?>
    <tr class="text-center">
        <td colspan="6">Records not found!</td>
    <tr>
    <?php else : ?>
        <?php while ($row = mysqli_fetch_assoc($unfetched)) : ?>
    <tr class="align-middle shrink-row">
        <td><?= $row['absensi_title']; ?></td>
        <td class="shrink-md shrinkable"><?= $row['absensi_desc']; ?></td>
        <td>
            <h1 class="badge bg-success"><?= $row['absensi_status']; ?></h1>
        </td>
        <td class="shrink-sm"><?= $row['absensi_owner']; ?></td>
        <td class="shrink-md"><?= date_format(new DateTime($row['expired_at']), 'D, d M Y H:i') ?></td>
        <td class="shrink-md">
            <a href="../view/?id=<?= $row['absensi_id']; ?>" class="btn btn-primary">View</a>
        </td>
    </tr>
<?php endwhile; ?>
<?php endif; ?>