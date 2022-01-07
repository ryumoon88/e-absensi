<?php
session_start();
if (!isset($_SESSION['is_login'])) {
    header('../../');
    exit();
}

require('../php/functions.php');
require('../php/connection.php');

$keyword = $_GET['q'];
$id = $_GET['id'];
var_dump($id);

$query = mysqli_prepare($conn, "SELECT getFullName(user_id) username, enrolled_at, status, taken_at FROM absensienroll WHERE absensi_id = $id AND (getFullName(user_id) LIKE '%$keyword%' OR enrolled_at LIKE '%$keyword%' OR status LIKE '%$keyword%')");
mysqli_stmt_execute($query);
$unfetched = mysqli_stmt_get_result($query);
?>

<?php if (!$unfetched->num_rows) : ?>
    <tr>
        <td colspan="4">No data available with the key you searched</td>
    </tr>
<?php else : ?>
    <?php $id = 1; ?>
    <?php while ($row = mysqli_fetch_assoc($unfetched)) : ?>
        <tr class="align-middle shrink-row">
            <td><?= $id++; ?></td>
            <td><?= $row['username']; ?></td>
            <td><span class="badge <?= ($row['status'] == 'Unknown') ? 'bg-danger' : 'bg-success'; ?>"><?= $row['status']; ?></span></td>
            <td class="shrink-sm"><?= date_format(new DateTime($row['taken_at']), 'D, d M Y H:i'); ?></td>
        </tr>
    <?php endwhile; ?>
<?php endif; ?>