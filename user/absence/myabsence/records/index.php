<?php
session_start();
require('../../../../src/php/functions.php');
require('../../../../src/php/connection.php');
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../../../../');
    return;
}

if (!isAbsenceOwnedBy($_GET['id'], $_SESSION['user_id'])) {
    header('Location: ../');
}

$unfetched = getEnrolledUserOn($_GET['id']);
$absence = getAbsence($_GET['id']);
$totalTaken = getTotalAbsenceTaken($_GET['id']);
$totalUnknown = getTotalUnknownAbsence($_GET['id']);
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
    <link rel="stylesheet" href="../../../../src/css/user.css">
    <link rel="stylesheet" href="../../../../src/css/jquery.table-shrinker.css">
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
                            My Absence <span id="absid" class="badge bg-<?= ($absence['absensi_status'] == 'Closed') ? 'danger' : (($absence['absensi_status'] == 'Opened') ? 'success' : 'warning'); ?>">ID: <?= $_GET['id']; ?></span>
                        </div>
                    </div>
                    <div class="col-4 p-0">
                        <div class="d-flex dropdown justify-content-end">
                            <p class="align-items-center my-auto"><?= $_SESSION['username']; ?></p>
                            <button class=" text-white dropdown-toggle align-self-center ms-3" role="button" id="accountdropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle icon"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="accountdropdown">
                                <li><a class="dropdown-item" href="../../../profile/"><i class="bi bi-person-fill me-3"></i><?= $_SESSION['username']; ?></a></li>
                                <li><a class="dropdown-item" href="?logout"><i class="bi bi-box-arrow-left me-3"></i>Logout</a></li>
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
                <a href="../../../dashboard/" class="btn text-white w-100 text-start"><i class="bi bi-house-door-fill me-3"></i>Dashboard</a>
                <a href="../../active/" class="btn mt-2 text-white w-100 text-start"><i class="bi bi-activity me-3"></i>Active Absence</a>
                <a href="../../new/" class="btn mt-2 text-white w-100 text-start"><i class="bi bi-plus-lg me-3"></i>New Absence</a>
                <a href="../" class="btn mt-2 active text-white w-100 text-start"><i class="bi bi-menu-button-wide me-3"></i>My Absence</a>
            </div>
        </div>
        <div class="sidenav-overlay"></div>
    </div>
    <!-- Body -->
    <div class="container p-5">
        <div class="input-group mb-3">
            <span class="input-group-text" id="search"><i class="bi bi-search"></i></span>
            <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="search" id="searchrecord">
        </div>
        <div class="row justify-content-center text-center">
            <div class="col-lg-4">
                <p class="fw-bold"><span class="badge bg-success">Taken: <?= $totalTaken; ?></span></p>
            </div>
            <div class="col-lg-4">
                <p class="fw-bold"><span class="badge bg-danger">Unknown: <?= $totalUnknown; ?></span></p>
            </div>
        </div>
        <table class="table table-striped shrink text-center responsive-table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Status</th>
                    <th class="shrink-sm shrinkable">Taken at</th>
                </tr>
            </thead>
            <tbody id="tbodyrecord">
                <?php if (!$unfetched->num_rows) : ?>
                    <tr>
                        <td colspan="4">There is no one enrolled in this absence yet!</td>
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
    <script src="../../../../src/js/sidenav.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="../../../../src/js/jquery.table-shrinker.js"></script>
    <script src="../../../../src/js/table.js"></script>
    <script src="../../../../src/js/script.js"></script>
</body>

</html>