<?php
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../../');
    return;
}

require('../../src/php/functions.php');
require('../../src/php/connection.php');

$msg = [];

if (isset($_GET['e-id'])) {
    $absence = getAbsenceByEnrollKey($_GET['e-id']);
    if ($absence['absensi_owner'] == $_SESSION['user_id']) {
        $_SESSION['modal-msg'] = buildModalMsg("You can't enroll to your own absence!");
    } else if (!isUserEnrolled($absence['absensi_id'], $_SESSION['user_id'])) {
        if (enrollAbsence($absence['absensi_id'], $_SESSION['user_id'])) {
            $_SESSION['modal-msg'] = buildModalMsg('Enrollment Success', 'Absence Enrolled', ['back', 'view'], 'bi-check-circle-fill text-success');
        } else {
            $_SESSION['modal-msg'] = buildModalMsg('Something went wrong!', 'Error', ['back', 'report']);
        }
    } else {
        $_SESSION['modal-msg'] = buildModalMsg("You're already enrolled in this absence!", 'Error', ['back', 'view']);
    }
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
    <link rel="stylesheet" href="../../src/css/user.css">
    <title>E-Absence - Dashboard</title>
</head>

<body class="d-flex">
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
                            Dashboard
                        </div>
                    </div>
                    <div class="col-4 p-0">
                        <div class="d-flex dropdown justify-content-end">
                            <p class="align-items-center my-auto"><?= $_SESSION['username']; ?></p>
                            <button class=" text-white dropdown-toggle align-self-center ms-3" role="button" id="accountdropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle icon"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="accountdropdown">
                                <li><a class="dropdown-item" href="../profile/"><i class="bi bi-person-fill me-3"></i><?= $_SESSION['username']; ?></a></li>
                                <li><a class="dropdown-item" href="?logout=true"><i class="bi bi-box-arrow-left me-3"></i>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
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
                <a href="./" class="btn active text-white w-100 text-start"><i class="bi bi-house-door-fill me-3"></i>Dashboard</a>
                <a href="../absence/active/" class="btn mt-2 text-white w-100 text-start"><i class="bi bi-activity me-3"></i>Active Absence</a>
                <a href="../absence/new/" class="btn mt-2 text-white w-100 text-start"><i class="bi bi-plus-lg me-3"></i>New Absence</a>
                <a href="../absence/myabsence/" class="btn mt-2 text-white w-100 text-start"><i class="bi bi-menu-button-wide me-3"></i>My Absence</a>
            </div>
        </div>
        <div class="sidenav-overlay"></div>
    </div>
    <div class="container p-5">
        <div class="d-flex flex-column mb-5">
            <h3 class="fw-bold text-center">Welcome Back, <?= strtok($_SESSION['username'], " "); ?></h3>
            <p></p>
        </div>
        <div class="d-flex flex-wrap mb-5 widget-group gap-5">
            <div class="d-flex flex-column m-auto gap-5 widget widget-box">
                <h5 class="widget-header">Active Absence</h5>
                <div class=" widget-body">
                    <i class="bi bi-activity"></i> <?= getTotalActiveAbsence($_SESSION['user_id']); ?>
                </div>
                <div class="widget-footer">
                    <a href="../absence/active/" class="btn btn-primary">View</a>
                </div>
            </div>
            <form class="d-flex flex-column m-auto gap-5 widget widget-box">
                <h5 class="widget-header">Enroll Absence</h5>
                <div class="widget-body fs-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="enrollkey" name="e-id" pattern="[A-Za-z0-9]{6}" title="Enter 6 digits key" placeholder="6 digits key" required>
                        <label for="enrollkey">6 digits key</label>
                    </div>
                </div>
                <div class="widget-footer">
                    <button class="btn btn-success">Enroll</button>
                </div>
            </form>
            <div class="d-flex flex-column m-auto gap-5 widget widget-box">
                <h5 class="widget-header">Created Absence</h5>
                <div class="widget-body">
                    <i class="bi bi-folder-plus"></i> <?= getTotalAbsenceCreated($_SESSION['user_id']); ?>
                </div>
                <div class="widget-footer">
                    <a href="../absence/myabsence/" class="btn btn-primary">View</a>
                    <a href="../absence/new/" class="btn btn-primary"><i class="bi bi-plus-square me-2"></i>Create</a>
                </div>
            </div>
        </div>
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
    <script src="../../src/js/sidenav.js"></script>
    <script src="../../src/js/modal.js"></script>
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
                                <a href="../login/" class="btn btn-success">Login</a>
                            <?php elseif ($value == 'view') : ?>
                                <a href="../absence/view/?id=<?= $absence['absensi_id']; ?>" class="btn btn-primary">View</a>
                            <?php elseif ($value == 'report') : ?>
                                <a href="" class="btn btn-danger">Report</a>
                            <?php elseif ($value == 'detail') : ?>
                                <a href="" class="btn btn-primary">Details</a>
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