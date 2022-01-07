<?php
session_start();
require('../php/connection.php');
require('../php/functions.php');

if (!isset($_SESSION['is_login'])) {
    header('Location: ../../');
    exit();
}

$keyword = $_GET['q'];

$query = mysqli_prepare($conn, "SELECT * FROM absensilist WHERE (absensi_owner = ?) AND (absensi_id LIKE '%$keyword%' OR absensi_title LIKE '%$keyword%'
OR absensi_desc LIKE '%$keyword%' OR absensi_status LIKE '%$keyword%' OR DATE_FORMAT(created_at, '%a, %d %b %Y %H:%i') LIKE '%$keyword%'
OR DATE_FORMAT(opened_at, '%a, %d %b %Y %H:%i') LIKE '%$keyword%' OR expired_at LIKE '%$keyword%')");
mysqli_stmt_bind_param($query, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($query);
$unfetched = mysqli_stmt_get_result($query);
var_dump($unfetched);
?>
<?php if (!$unfetched->num_rows) : ?>
    <tr class="shrink-row">
        <td colspan="8">You've not make any absence yet!</td>
    </tr>
<?php else : ?>
    <?php while ($row = mysqli_fetch_assoc($unfetched)) : ?>
        <tr class="align-middle shrink-row">
            <td><?= $row['absensi_id']; ?></td>
            <td class="shrinkable"><?= $row['absensi_title']; ?></td>
            <td class="shrink-sm shrinkable"><?= $row['absensi_desc']; ?></td>
            <td>
                <h1 class="badge bg-<?= ($row['absensi_status'] == 'Closed') ? 'danger' : ($row['absensi_status'] == 'Opened' ? 'success' : 'info'); ?>">
                    <?= $row['absensi_status']; ?>
                </h1>
            </td>
            <td class="shrink-md"><?= date_format(new DateTime($row['created_at']), 'D, d M Y<\b\r>H:i'); ?></td>
            <td class="shrink-md"><?= date_format(new DateTime($row['opened_at']), 'D, d M Y<\b\r>H:i'); ?></td>
            <td class="shrink-md"><?= date_format(new DateTime($row['expired_at']), 'D, d M Y<\b\r>H:i'); ?></td>
            <td class="shrink-md">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="absenceaction" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="absenceaction">
                        <li><a class="dropdown-item" href="./details/?id=<?= $row['absensi_id']; ?>">Details</a></li>
                        <li><a class=" dropdown-item <?= ($row['absensi_status'] == 'Closed') ? 'disabled' : ''; ?>" href="./edit/?id=<?= $row['absensi_id']; ?>">Edit</a></li>
                        <li><a class="dropdown-item" href="./records/?id=<?= $row['absensi_id']; ?>">Records</a></li>
                        <li><a class="dropdown-item" href=".">Delete</a></li>
                        <li>
                            <hr class="dropdown-devider">
                        </li>
                        <li><a class="dropdown-item <?= ($row['absensi_status'] == 'Closed') ? 'disabled' : ''; ?>" href="#">Open</a></li>
                        <li><a class="dropdown-item <?= ($row['absensi_status'] == 'Closed') ? 'disabled' : ''; ?>" href="#">Close</a></li>
                    </ul>
                </div>
            </td>
        </tr>
    <?php endwhile; ?>
<?php endif; ?>