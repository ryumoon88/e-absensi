<?php
session_start();
require('../../../../src/php/connection.php');
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../../../../');
    return;
}
require('../../../../src/php/functions.php');

if (!isset($_GET['id'])) {
    header('Location: ../');
    exit();
}

if (isAbsenceOwnedBy($_GET['id'], $_SESSION['user_id'])) {
    $absence = getAbsence($_GET['id']);
    if ($absence['absensi_status'] == 'Closed') {
        header("Location: ../details?id=" . $absence['absensi_id']);
    }
} else {
    header('Location: ../');
    exit();
}

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    <link rel="stylesheet" href="../../../../src/css/user.css">
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
                            Edit Absence <span class="badge bg-secondary">ID: <?= $absence['absensi_id']; ?></span>
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
                <a href="../../../dashboard/" class="btn text-white w-100 text-start"><i class="bi bi-house-door-fill me-3"></i>Dashboard</a>
                <a href="../../active/" class="btn mt-2 text-white w-100 text-start"><i class="bi bi-activity me-3"></i>Active Absence</a>
                <a href="../../new/" class="btn mt-2 text-white w-100 text-start"><i class="bi bi-plus-lg me-3"></i>New Absence</a>
                <a href="../../myabsence/" class="btn mt-2 active text-white w-100 text-start"><i class="bi bi-menu-button-wide me-3"></i>My Absence</a>
            </div>
        </div>
        <div class="sidenav-overlay"></div>
    </div>
    <!-- Body -->
    <div class="container my-auto p-5 text-center">
        <form action="../../../../src/php/save-absence.php" method="POST">
            <div class="row">
                <div class="col-lg-6">
                    <input type="hidden" name="absensi_id" value="<?= $absence['absensi_id']; ?>">
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" value="<?= $absence['absensi_id']; ?>" disabled name="absenceid" id="absenceid" placeholder="Absence ID">
                        <label for="absenceid">Absence ID</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" value="<?= $absence['absensi_title']; ?>" required name="absencetitle" id="absencetitle" placeholder="Absence Title">
                        <label for="absencetitle">Absence Title</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" value="<?= $absence['absensi_desc']; ?>" name="absencedesc" id="absencedesc" placeholder="Absence Description">
                        <label for="absencedesc">Absence Description</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" value="<?= $absence['absensi_enroll']; ?>" disabled name="absenceenroll" id="absenceenroll" placeholder="Absence Enrollment">
                        <label for="absenceenroll">Absence Enrollment</label>
                    </div>
                    <div class="form-floating mb-4">
                        <select class="form-select" disabled id="absencestatus" aria-label="Absence Status" name="absencestatus">
                            <option value="Waiting to open" <?= ($absence['absensi_status'] == 'Waiting to open') ? 'selected' : ''; ?>>Waiting to open</option>
                            <option value="Opened" <?= ($absence['absensi_status'] == 'Opened') ? 'selected' : ''; ?>>Opened</option>
                            <option value="Closed" <?= ($absence['absensi_status'] == 'Closed') ? 'selected' : ''; ?>>Closed</option>
                        </select>
                        <label for="absencestatus">Absence Status</label>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-floating mb-4">
                        <input type="datetime-local" class="form-control" value="<?= str_replace(' ', 'T', $absence['created_at']); ?>" disabled name="absencecreated" id="absencecreated" placeholder="Created at">
                        <label for="absencecreated">Created at</label>
                    </div>
                    <div class="form-floating mb-4" id="opendatefield">
                        <input type="datetime-local" class="form-control <?= ($absence['absensi_status'] == 'Opened') ? '' : 'bg-white'; ?> flatpickred-date" <?= ($absence['absensi_status'] == 'Opened') ? 'disabled' : ''; ?> value="<?= ($absence['absensi_status'] == 'Opened') ? date_format(new DateTime($absence['opened_at']), 'Y-m-d\TH:i') : date_format(new DateTime(), 'Y-m-d\TH:i'); ?>" required name="absenceopened" id="absenceopened" placeholder="Opened at">
                        <label for="absenceopened">Opened at</label>
                    </div>
                    <div class="form-floating mb-4" id="closedatefield">
                        <input type="datetime-local" class="form-control bg-white flatpickred-date" value="<?= str_replace(' ', 'T', $absence['expired_at']); ?>" required name="absenceexpired" id="absenceexpired" placeholder="Expired at">
                        <label for="absenceexpired">Expired at</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" disabled value="<?= $absence['enrolled_user']; ?>" name="absenceenrolled" id="absenceenrolled" placeholder="Total User Enrolled">
                        <label for="absenceenrolled">Total User Enrolled</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" disabled value="<?= $absence["user_taken"]; ?>" name="absencetotaltake" id="absencetotaltake" placeholder="Total User Take Actions">
                        <label for="absencetotaltake">Total User Take Actions</label>
                    </div>
                </div>
            </div>
            <a href="../details/?<?= $absence['absensi_id']; ?>" class="btn btn-secondary mt-3">Back</a>
            <button type="submit" name="save" class="btn btn-primary mt-3">Save</button>
        </form>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="../../../../src/js/edit-date.js"></script>
    <script src="../../../../src/js/modal.js"></script>
    <?php if (!empty($_SESSION['modal-msg'])) : ?>
        <?php $msg = $_SESSION['modal-msg']; ?>
        <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><?= $msg['title']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="icon">
                            <i class="bi <?= $msg['class']; ?>" style="font-size: 100px;"></i>
                        </div>
                        <h3 class="mt-5"><?= $msg['msg']; ?></h3>
                    </div>
                    <div class="modal-footer">
                        <?php foreach ($msg['buttons'] as $btn => $value) : ?>
                            <?php if ($value == 'back') : ?>
                                <a href="" class="btn btn-secondary" data-bs-dismiss="modal">Back</a>
                            <?php elseif ($value == 'login') : ?>
                                <a href="" class="btn btn-success">Login</a>
                            <?php elseif ($value == 'view') : ?>
                                <a href="" class="btn btn-primary">View</a>
                            <?php elseif ($value == 'report') : ?>
                                <a href="" class="btn btn-danger">Report</a>
                            <?php elseif ($value == 'detail') : ?>
                                <a href="" class="btn btn-primary">Details</a>
                            <?php elseif ($value == 'close') : ?>
                                <a href="" class="btn btn-primary">Close</a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <script>
            showModal('modal');
        </script>
        <?php resetModalMsg(); ?>
    <?php endif; ?>
</body>

</html>