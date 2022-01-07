<?php
session_start();

require('../src/php/functions.php');
require('../src/php/connection.php');

if (isset($_SESSION['is_login'])) {
    header('Location: ../user/dashboard');
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
    <link rel="stylesheet" href="../src/css/landpage.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <title>E-Absence - Register</title>
</head>

<body class="h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../">E-Absence</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse justify-content-end navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="./">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="d-flex flex-column">
        <div class="d-flex flex-column container justify-content-center text-center  pb-5">
            <div class="d-flex flex-column gap-2 form-lg m-auto mt-5">
                <h3 class="fw-bold">Registration</h3>
                <p class="fst-italic">Join us now and make your journey here!</p>
                <img src="../src/images/registration-form.png" class="w-25 align-self-center" alt="">
                <form method="POST" action="../src/php/register.php" class="mt-4">
                    <div class="form-floating mb-3">
                        <input type="username" class="form-control" pattern="^(?=.{8,30}$)(?![._])(?!.*[._]{2})(?![\s])[a-zA-Z0-9._]+(?<!.[_.])$" title="Must have atleast 6 characters and not contain any symbols!" required name="username" id="username" placeholder="Username">
                        <label for="username">Username</label>
                    </div>
                    <div class="d-grid">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-floating  mb-3">
                                    <input type="firstname" class="form-control" required name="firstname" id="firstname" placeholder="First Name">
                                    <label for="firstname">First Name</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="lastname" class="form-control" required name="lastname" id="lastname" placeholder="Last Name">
                                    <label for="lastname">Last Name</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" required name="email" id="email" placeholder="Email Address">
                        <label for="email">Email Address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" required name="password" id="password" pattern="^(?=.{8,}$)(?!.*[\s])[\w\W]*(?<!.[\W])$" title="Must have atleast 8 character and not contain any symbols!" placeholder="Password">
                        <label for="password">Password</label>
                    </div>
                    <div class="button-group">
                        <button type="submit" name="register" class="mt-3 btn btn-success">Register</button>
                        <a href="../login/" class="btn text-primary w-100 mt-2">Already have an account? Login now!</a>
                    </div>
                </form>
            </div>
        </div>
        <footer class="text-center pt-2 bg-dark text-secondary">
            &copy; 2021 - Kelompok 7
        </footer>
    </section>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
    <script src="../src/js/modal.js"></script>
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
                                <a href="" class="btn btn-primary">View</a>
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