<?php
session_start();
if (!isset($_SESSION['is_login'])) {
    header('Locattion: ../../');
    exit();
}
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../../');
    exit();
}

require('../../src/php/functions.php');
require('../../src/php/connection.php');

$user = getUserById($_SESSION['user_id']);

if (isset($_POST['editfn'])) {
    $isUpdated = updateUserData($user['user_id'], $_POST['hiddenFirstname'], null, null, null);
    $_SESSION['username'] = $_POST['hiddenFirstname'] . ' ' . explode(' ', $_SESSION['username'])[1];
    if ($isUpdated) {
        $_SESSION['modal-msg'] = buildModalMsg('Update Success!', 'Profile Update', ['back', 'oke'], 'bi-check-circle-fill text-success');
    } else {
        $_SESSION['modal-msg'] = buildModalMsg('Something went wrong with the server!', 'Error', ['back', 'report']);
    }
} else if (isset($_POST['editln'])) {
    $isUpdated = updateUserData($user['user_id'], null, $_POST['hiddenLastname'], null, null);
    $_SESSION['username'] = strtok($_SESSION['username'], ' ') . ' ' . $_POST['hiddenLastname'];
    if ($isUpdated) {
        $_SESSION['modal-msg'] = buildModalMsg('Update Success!', 'Profile Update', ['back', 'oke'], 'bi-check-circle-fill text-success');
    } else {
        $_SESSION['modal-msg'] = buildModalMsg('Something went wrong with the server!', 'Error', ['back', 'report']);
    }
} else if (isset($_POST['editpw'])) {
    $isUpdated = updateUserData($user['user_id'], null, null, $_POST['hiddenPassword'], null);
    if ($isUpdated) {
        $_SESSION['modal-msg'] = buildModalMsg('Update Success!', 'Profile Update', ['back', 'oke'], 'bi-check-circle-fill text-success');
    } else {
        $_SESSION['modal-msg'] = buildModalMsg('Something went wrong with the server!', 'Error', ['back', 'report']);
    }
} else if (isset($_POST['editemail'])) {
    $isUpdated = updateUserData($user['user_id'], null, null, null, $_POST['hiddenEmail']);
    if ($isUpdated) {
        $_SESSION['modal-msg'] = buildModalMsg('Update Success!', 'Profile Update', ['back', 'oke'], 'bi-check-circle-fill text-success');
    } else {
        $_SESSION['modal-msg'] = buildModalMsg('Something went wrong with the server!', 'Error', ['back', 'report']);
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
                            My Profile
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
                <a href="../dashboard/" class="btn text-white w-100 text-start"><i class="bi bi-house-door-fill me-3"></i>Dashboard</a>
                <a href="../absence/active/" class="btn mt-2 text-white w-100 text-start"><i class="bi bi-activity me-3"></i>Active Absence</a>
                <a href="../absence/new/" class="btn mt-2 text-white w-100 text-start"><i class="bi bi-plus-lg me-3"></i>New Absence</a>
                <a href="../absence/myabsence/" class="btn mt-2 text-white w-100 text-start"><i class="bi bi-menu-button-wide me-3"></i>My Absence</a>
            </div>
        </div>
        <div class="sidenav-overlay"></div>
    </div>
    <!-- Body -->
    <div class="container my-auto p-5 text-center">
        <div class="row">
            <div class="col-lg-6">
                <form method="POST" class="input-group mb-4">
                    <div class="form-floating form-floating-group flex-grow-1">
                        <input type="hidden" name="hiddenFirstname" value="aaa">
                        <input type="text" class="form-control" required value="<?= $user['first_name']; ?>" id="firstname" disabled name="firstname" placeholder="First Name">
                        <label for="firstname">First Name</label>
                    </div>
                    <button type="button" class="btn btn-outline-primary input-group-text" id="firstnameBtn" name="editfn" style="width: 80px;">Edit</button>
                </form>
            </div>
            <div class="col">
                <form method="POST" class="input-group mb-4">
                    <div class="form-floating form-floating-group flex-grow-1">
                        <input type="hidden" name="hiddenLastname">
                        <input type="text" class="form-control" required value="<?= $user['last_name']; ?>" id="lastname" disabled name="lastname" placeholder="Last name">
                        <label for="lastname">Last Name</label>
                    </div>
                    <button type="button" class="btn btn-outline-primary input-group-text" id="lastnameBtn" name="editln" style="width: 80px;">Edit</button>
                </form>
            </div>
        </div>
        <div class="form-floating mb-4">
            <input type="text" class="form-control" value="<?= $user['username']; ?>" disabled required name="username" id="username" placeholder="Username">
            <label for="username">Username</label>
        </div>
        <form method="POST" class="input-group mb-4">
            <div class="form-floating form-floating-group flex-grow-1">
                <input type="hidden" name="hiddenPassword">
                <input type="password" class="form-control" pattern="^(?=.{8,}$)(?!.*[\s])[\w\W]*(?<!.[\W])$" title="Must have atleast 8 character and not contain any symbols!" required value="<?= substr($user['password'], 0, 12); ?>" disabled name="password" id="password" placeholder="Password">
                <label for="password">Password</label>
            </div>
            <button type="button" name="editpw" class="btn btn-outline-primary input-group-text" data-bs-toggle="collapse" data-bs-target="#repeatpass" aria-expanded="false" id="passwordBtn" style="width: 80px;">Edit</button>
        </form>
        <div class="collapse" id="repeatpass">
            <div class="input-group mb-4" style="height: 58px;">
                <div class="form-floating form-floating-group flex-grow-1">
                    <input type="hidden" name="repeatpassVal">
                    <input type="password" class="form-control h-auto" name="repeatpass" id="repeatpass" placeholder="Repeat Password">
                    <label for="repeatpass">Repeat Password</label>
                </div>
                <button class="btn btn-danger input-group-text text-white" id="repeatpass" name="verify" id="passverify" style="width: 80px;"><i class="bi bi-x-circle text-white" style="font-size: 25px;"></i></button>
            </div>
        </div>
        <form method="POST" class="input-group mb-4">
            <input type="hidden" name="email">
            <div class="form-floating form-floating-group flex-grow-1">
                <input type="hidden" name="hiddenEmail">
                <input type="email" class="form-control" required value="<?= $user['email']; ?>" disabled name="email" id="email" placeholder="Email">
                <label for="email">Email</label>
            </div>
            <button type="button" class="btn btn-outline-primary input-group-text" id="emailBtn" name="editemail" style="width: 80px;">Edit</button>
        </form>
        <div class="form-floating mb-4">
            <input type="text" class="form-control" value="<?= date_format(new DateTime($user['joined_at']), 'D, d F Y'); ?>" disabled name="membersince" id="membersince" placeholder="Member Since">
            <label for="membersince">Member Since</label>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../src/js/profileedit.js"></script>
    <script src="../../src/js/modal.js"></script>t
    <?php if (!empty($_SESSION['modal-msg'])) : ?>
        <?php $msg = $_SESSION['modal-msg']; ?>
        <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><?= $msg['title']; ?></h5>
                        <a href="?id=<?= $absence_id; ?>" class="btn-close" aria-label="Close"></a>
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
                                <a href="./" class="btn btn-secondary">Back</a>
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
                            <?php elseif ($value == 'oke') : ?>
                                <a href="./" class="btn btn-primary">Oke</a>
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