<?php
session_start();
if (!isset($_SESSION['is_login'])) {
    header('Location: ../../../');
}
require('../../../src/php/connection.php');
require('../../../src/php/functions.php');
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../../../');
    return;
}

$unfetched = getAllAbsence($_SESSION['user_id']);
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../src/css/user.css">
    <link rel="stylesheet" href="../../../src/css/jquery.table-shrinker.css">
    <title>E-Absence - Dashboard</title>
</head>

<body class="d-flex">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="d-grid w-100" id="navbar-top">
                <div class="row w-100">
                    <div class="col-4">
                        <div>
                            <button id="sidenav-btn-open"><i class="bi bi-list icon text-white"></i></button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center col-4">
                        <div class="my-auto text-center fw-bold">
                            My Absence
                        </div>
                    </div>
                    <div class="col-4 p-0">
                        <div class="d-flex dropdown justify-content-end">
                            <p class="align-items-center my-auto"><?= $_SESSION['username']; ?></p>
                            <button class=" text-white dropdown-toggle align-self-center ms-3" role="button" id="accountdropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle icon"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="accountdropdown">
                                <li><a class="dropdown-item" href="../../profile/"><i class="bi bi-person-fill me-3"></i><?= $_SESSION['username']; ?></a></li>
                                <li><a class="dropdown-item" href="?logout=true"><i class="bi bi-box-arrow-left me-3"></i>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Sidenav -->
    <div class="sidenav">
        <div class="sidenav-body">
            <div class="d-flex justify-content-between p-3 sidenav-header">
                <div class="sidenav-title">
                    Menu
                </div>
                <div class="sidenav-close">
                    <button id="sidenav-btn-close"><i class="bi bi-x-lg text-white"></i></button>
                </div>
            </div>
            <hr class="sidenav-devider">
            <div class="sidenav-links">
                <a href="../../dashboard/" class="btn text-white w-100 text-start"><i class="bi bi-house-door-fill me-3"></i>Dashboard</a>
                <a href="../active/" class="btn mt-2 text-white w-100 text-start"><i class="bi bi-activity me-3"></i>Active Absence</a>
                <a href="../new/" class="btn mt-2 text-white w-100 text-start"><i class="bi bi-plus-lg me-3"></i>New Absence</a>
                <a href="./" class="btn mt-2 active text-white w-100 text-start"><i class="bi bi-menu-button-wide me-3"></i>My Absence</a>
            </div>
        </div>
        <div class="sidenav-overlay"></div>
    </div>
    <!-- Body -->
    <div class="container p-5">
        <div class="input-group mb-3">
            <span class="input-group-text" id="search"><i class="bi bi-search"></i></span>
            <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="search" id="searchMyAbsence">
        </div>
        <table class="table table-striped shrink text-center responsive-table">
            <thead class="table-dark">
                <tr>
                    <th>Absence ID</th>
                    <th class="shrinkable">Absence Title</th>
                    <th class="shrink-sm shrinkable">Description</th>
                    <th>Status</th>
                    <th class="shrink-md">Created At</th>
                    <th class="shrink-md">Opened At</th>
                    <th class="shrink-md">Expired At</th>
                    <th class="shrink-md">Actions</th>
                </tr>
            </thead>
            <tbody id="tbodymyabsence">
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
            </tbody>
        </table>
    </div>

    <div class="footer">
        &copy; 2021 - Kelompok 7
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
    <script src="../../../src/js/sidenav.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="../../../src/js/jquery.table-shrinker.js"></script>
    <script src="../../../src/js/table.js"></script>
    <script src="../../../src/js/script.js"></script>
</body>

</html>