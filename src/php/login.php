<?php
session_start();

require('./functions.php');
require('./connection.php');

if (!$conn) {
    header('Location: ../../login');
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = getUserByUsername($username);
    if (!$user) {
        $_SESSION['modal-msg'] = buildModalMsg("$username is not registered!", 'Error', ['back', 'login']);
        header('Location: ../../login/');
        exit();
    }

    if (isUserPasswordMatch($user['user_id'], $password)) {
        buildSession($user['user_id'], $user['email'], $user['first_name'] . ' ' . $user['last_name'], $user['is_admin']);
        header('Location: ../../user/dashboard/');
        exit();
    } else {
        $_SESSION['modal-msg'] = buildModalMsg("You entered the wrong password!", 'Error');
        header('Location: ../../login/');
        exit();
    }
} else {
    header("Location: ../");
    exit();
}
