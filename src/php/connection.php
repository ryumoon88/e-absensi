<?php
date_default_timezone_set('Asia/Jakarta');
$host = 'localhost';
$user = 'root';
$pass = '';
$dbName = 'e_absensi';


$conn = @mysqli_connect($host, $user, $pass, $dbName);
if (!$conn) {
    $_SESSION['modal-msg'] = buildModalMsg('Something went wrong with the server connection!', 'Error', ['back', 'report'], 'bi-wifi-off text-danger');
}
