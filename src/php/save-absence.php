<?php
require('./functions.php');
require('./connection.php');
session_start();
if (isset($_POST['save'])) {
    $absence_id = $_POST['absensi_id'];
    $absenceTitle = $_POST['absencetitle'];
    $absenceDesc = (empty($_POST['absencedesc'])) ? '-' : $_POST['absencedesc'];
    $opened_at = empty($_POST['absenceopened']) ? '' : $_POST['absenceopened'];
    $closed_at = $_POST['absenceexpired'];

    $result = updateAbsence($absence_id, $absenceTitle, $absenceDesc, $opened_at, $closed_at);
    if ($result) {
        $_SESSION['modal-msg'] = buildModalMsg('Absence updated!', 'Absence Updated!', ['back', 'close'], 'bi-check-circle-fill text-success');
        header("Location: ../../user/absence/myabsence/details/?id=$absence_id");
    } else {
        $_SESSION['modal-msg'] = buildModalMsg('Something went wrong when updating your data!', 'Error', ['back', 'report']);
        header("Location: ../../user/absence/myabsence/edit/?id=$absence_id");
    }
} else {
    header('Location: ../../user/dashboard/');
    exit();
}
