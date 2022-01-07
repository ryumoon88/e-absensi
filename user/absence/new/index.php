<?php
session_start();

require('../../../src/php/functions.php');
require('../../../src/php/connection.php');

if (!isset($_SESSION['is_login'])) {
    header('Location: ../../');
    return;
}
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../../../');
    mysqli_close($conn);
    return;
}

if (isset($_POST['createAbsence'])) {
    $absenceOwner = $_SESSION['user_id'];
    $absenceTitle = $_POST['absencetitle'];
    $absenceDesc = $_POST['absencedesc'];

    $open_at = ($_POST['opendatecheck'] == 'Custom') ? $_POST['opendateinput'] : date_format(new DateTime(), 'Y-m-d H:i:s');
    $close_at = ($_POST['closedatecheck'] == 'Custom') ? $_POST['closedateinput'] : date_format(date_add(new DateTime(), date_interval_create_from_date_string('1 day')), 'Y-m-d H:i:s');

    if (addNewAbsence($absenceOwner, $absenceTitle, $absenceDesc, $open_at, $close_at)) {
        $absence = getAbsence(getLastAbsenceId());
        $_SESSION['modal-msg'] = buildModalMsg('Absence created!', 'Absence Created', ['back', 'details'], 'bi-check-circle-fill text-success');
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    <link rel="stylesheet" href="../../../src/css/user.css">
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
                            New Absence
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
                <a href="./" class="btn mt-2 active text-white w-100 text-start"><i class="bi bi-plus-lg me-3"></i>New Absence</a>
                <a href="../myabsence/" class="btn mt-2 text-white w-100 text-start"><i class="bi bi-menu-button-wide me-3"></i>My Absence</a>
            </div>
        </div>
        <div class="sidenav-overlay"></div>
    </div>
    <!-- Body -->
    <div class="container my-auto p-5">
        <form method="POST" class="row">
            <div class="col">
                <h4 class="fw-bold mb-2">Absence Details</h4>
                <div class="form-floating mb-3">
                    <input type="text" required class="form-control" name="absencetitle" id="absencetitle" placeholder="Absence Title">
                    <label for="absencetitle">Absence Title</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="absencedesc" id="absencedesc" placeholder="Absence Desc">
                    <label for="absencedesc">Absence Desc</label>
                </div>
                <h4 class="fw-bold">Absence Option</h4>

                <div id="open-date">
                    <h6 class="fw-bold ms-3">Open Date</h6>
                    <div class="form-check">
                        <input class="form-check-input ms-2 me-2" type="radio" value="Default" name="opendatecheck" id="defaultopendate" checked>
                        <label class="form-check-label " for="defaultopendate">
                            Default (Open when absence created)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input ms-2 me-2" type="radio" value="Custom" name="opendatecheck" id="customopendate">
                        <label class="form-check-label " for="customopendate">
                            Custom
                        </label>
                        <div class="flatpickr collapse" id="datepicker-open">
                            <input type="datetime-local" class="form-control bg-white ms-2 mt-2" name="opendateinput" id="opendateinput">
                        </div>
                    </div>
                </div>
                <div id="close-date">
                    <h6 class="fw-bold ms-3">Close Date</h6>
                    <div class="form-check">
                        <input class="form-check-input ms-2 me-2" type="radio" value="Default" name="closedatecheck" id="defaultclosedate" checked>
                        <label class="form-check-label " for="defaultclosedate">
                            Default (Automatically closed in 24 hours)
                        </label>
                    </div>
                    <div class=" form-check">
                        <input class="form-check-input ms-2 me-2" type="radio" value="Custom" name="closedatecheck" id="customclosedate">
                        <label class="form-check-label " for="customclosedate">
                            Custom
                        </label>
                        <div class="flatpickr collapse" id="datepicker-close">
                            <input type="datetime-local" class="form-control bg-white ms-2 mt-2" name="closedateinput" id="closedateinput">
                        </div>
                    </div>
                </div>
                <div class="button-group mt-3 text-center">
                    <a href="" class="btn btn-secondary">Back</a>
                    <button type="submit" name="createAbsence" id="createAbsence" class="btn btn-success">Create</button>
                </div>
            </div>
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
    <script src="../../../src/js/sidenav.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="../../../src/js/new-date.js"></script>
    <script src="../../../src/js/modal.js"></script>
    <script src="../../../src/js/copyBtn.js"></script>
    <?php if (!empty($_SESSION['modal-msg'])) : ?>
        <?php $msg = $_SESSION['modal-msg']; ?>
        <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><?= $msg['title']; ?></h5>
                        <a href="./" type="button" class="btn-close" aria-label="Close"></a>
                    </div>
                    <div class="modal-body text-center">
                        <div class="icon">
                            <i class="bi <?= $msg['class']; ?>" style="font-size: 100px;"></i>
                        </div>
                        <?php if ($absence['absensi_enroll']) : ?>
                            <div class="input-group form-floating mt-5 mb-3">
                                <div class="form-floating form-floating-group flex-grow-1">
                                    <input type="text" class="form-control" value="<?= $absence['absensi_enroll']; ?>" readonly placeholder="Enrollment Key" id="copyField" aria-label="Enrollment Key" aria-describedby="copyBtn">
                                    <label for="copyField">Enrollment Key</label>
                                </div>
                                <button class="btn input-group-text btn-outline-success" type="button" id="copyBtn">Copy</button>
                            </div>
                        <?php else : ?>
                            <h3 class="mt-5"><?= $msg['msg']; ?></h3>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <?php foreach ($msg['buttons'] as $btn => $value) : ?>
                            <?php if ($value == 'back') : ?>
                                <a href="./" class="btn btn-secondary">Back</a>
                            <?php elseif ($value == 'login') : ?>
                                <a href="../login/" class="btn btn-success">Login</a>
                            <?php elseif ($value == 'view') : ?>
                                <a href="../view/" class="btn btn-primary">View</a>
                            <?php elseif ($value == 'report') : ?>
                                <a href="" class="btn btn-danger">Report</a>
                            <?php elseif ($value == 'detail') : ?>
                                <a href="../myabsence/details/?<?= $absence['id']; ?>" class="btn btn-primary">Details</a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <script>
            showModal('modal');
            copyEnrollBtn__init('copyBtn', 'copyField');
        </script>
        <?php resetModalMsg(); ?>
    <?php endif; ?>



</body>

</html>