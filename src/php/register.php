<?php
session_start();
require('./functions.php');
require('./connection.php');

if (!$conn) {
    header('Location: ../../register/');
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];

    if (isUsernameRegistered($username)) {
        $_SESSION['modal-msg'] = buildModalMsg("$username already registered!", 'Error');
        header('Location: ../../register/');
        exit();
    }
    if (isEmailRegistered($email)) {
        $_SESSION['modal-msg'] = buildModalMsg("$email already used by someone!", 'Error');
        header('Location: ../../register/');
        exit();
    }

    if (addUser($username, $password, $email, $firstName, $lastName)) {
        $_SESSION['modal-msg'] = buildModalMsg('Registration Success', 'Registration Success', ['back', 'login'], 'bi-check-circle-fill text-success');
        header('Location: ../../register/');
        exit();
    } else {
        $_SESSION['modal-msg'] = buildModalMsg('Something went wrong!', 'Error', ['back', 'report']);
        header('Location: ../../register/');
        exit();
    }
} else {
    header('Location: ../../');
    exit();
}
