<?php
session_start();
if (isset($_SESSION['is_login'])) {
    header('Location: ./user/dashboard');
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
    <link rel="stylesheet" href="./src/css/landpage.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <title>E-Absensi</title>
</head>

<body class="h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="./">E-Absence</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse justify-content-end navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="./login/">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./register/">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="d-flex flex-column">
        <div class="d-flex flex-column container justify-content-center text-center mt-4">
            <h3 class="fw-bold">Welcome to E-Absence</h3>
            <p class="fst-italic">Make your own absence or attend an absence easily!</p>

            <div class="d-flex justify-content-center container align-middle gap-5 flex-wrap p-5">
                <a href="./login/" class="d-flex gap-5 flex-column text-center box text-dark btn btn-success">
                    <h3 class="fw-bold">Login</h3>
                    <img src="./src/images/user.png" alt="" class="align-self-center">
                    <h5>Login now!</h5>
                </a>
                <a href="./register/" class="d-flex gap-5 flex-column box btn text-dark btn-primary">
                    <h3 class="fw-bold">Register</h3>
                    <img src="./src/images/registration-form.png" class="align-self-center">
                    <h5>Register now!</h5>
                </a>
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

    <script src="./src/js/modal.js"></script>
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