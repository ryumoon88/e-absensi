<?php

// User function
function getUserById(int $user_id)
{
    global $conn;
    $query = mysqli_prepare($conn, "SELECT * FROM user WHERE user_id = ?");
    mysqli_stmt_bind_param($query, 'i', $user_id);
    mysqli_stmt_execute($query);
    $result = mysqli_fetch_assoc(mysqli_stmt_get_result($query));
    return $result;
}

function getUserByUsername(string $username)
{
    global $conn;
    $query = mysqli_prepare($conn, "SELECT * FROM user WHERE username = ?");
    mysqli_stmt_bind_param($query, 's', $username);
    mysqli_stmt_execute($query);
    $result = mysqli_fetch_assoc(mysqli_stmt_get_result($query));
    return $result;
}

function getUserByEmail(string $email)
{
    global $conn;
    $query = mysqli_prepare($conn, "SELECT * FROM user WHERE email = ?");
    mysqli_stmt_bind_param($query, 's', $email);
    mysqli_stmt_execute($query);
    $result = mysqli_fetch_assoc(mysqli_stmt_get_result($query));
    return $result;
}

function isUserPasswordMatch(int $user_id, string $password)
{
    $user = getUserById($user_id);
    return password_verify($password, $user['password']);
}

function isEmailRegistered(string $email)
{
    return !!(getUserByEmail($email));
}

function isUsernameRegistered(string $username)
{
    return !!(getUserByUsername($username));
}

function addUser(string $username, string $password, string $email, string $firstName, string $lastName)
{
    global $conn;
    $query = mysqli_prepare($conn, "INSERT INTO user(username, password, email, first_name, last_name) VALUES (?, ?, ?, ?, ?);");
    mysqli_stmt_bind_param($query, 'sssss', $username, $password, $email, $firstName, $lastName);
    $result = mysqli_stmt_execute($query);
    return $result;
}

function updateUserData($user_id, $first_name, $last_name, $password, $email)
{
    global $conn;
    $user = getUserById($user_id);
    $fnNewVal = empty($first_name) ? $user['first_name'] : $first_name;
    $lnNewVal = empty($last_name) ? $user['last_name'] : $last_name;
    $passNewVal = empty($password) ? $user['password'] : password_hash($password, PASSWORD_DEFAULT);
    $newEmail = empty($email) ? $user['email'] : $email;

    $query = mysqli_prepare($conn, "UPDATE user SET first_name = ?, last_name = ?, password = ?, email = ? WHERE user_id = ?");
    mysqli_stmt_bind_param($query, 'ssssi', $fnNewVal, $lnNewVal, $passNewVal, $newEmail, $user_id);
    $result = mysqli_stmt_execute($query);
    return $result;
}

// Absence Needs
function getAbsence(int $absence_id)
{
    global $conn;
    $query = mysqli_prepare($conn, "SELECT * FROM absensilist WHERE absensi_id = ?");
    mysqli_stmt_bind_param($query, 'i', $absence_id);
    mysqli_stmt_execute($query);
    $result = mysqli_fetch_assoc(mysqli_stmt_get_result($query));
    return $result;
}

function isAbsenceOwnedBy(int $absenceId, int $user_id)
{
    $absence = getAbsence($absenceId);
    return $absence['absensi_owner'] == $user_id;
}

function getUniqueEnrollKey()
{
    global $conn;
    $key = '';
    while (empty($key)) {
        $key = generateRandomString();
        $absence = getAbsenceByEnrollKey($key);
        if ($absence) {
            $key = '';
        }
    }
    return $key;
}

function addNewAbsence(int $absenceOwner, string $absenceTitle, string $absenceDesc, string $open_at, string $close_at)
{
    global $conn;
    $absenceDesc = empty($absenceDesc) ? '-' : $absenceDesc;
    $absenceStatus = date_diff(new DateTime($open_at), new DateTime())->invert ? 'Waiting to open' : 'Opened';
    $absenceEnroll = getUniqueEnrollKey();
    $query = mysqli_prepare($conn, 'INSERT INTO absensilist(absensi_title, absensi_desc, absensi_owner, absensi_enroll, absensi_status, opened_at, expired_at) VALUES(?,?,?,?,?,?,?);');
    mysqli_stmt_bind_param($query, 'ssissss', $absenceTitle, $absenceDesc, $absenceOwner, $absenceEnroll, $absenceStatus, $open_at, $close_at);
    $result = mysqli_stmt_execute($query);
    return $result;
}

function getAbsenceByEnrollKey(string $enrollKey)
{
    global $conn;
    $query = mysqli_prepare($conn, "SELECT * FROM absensilist WHERE absensi_enroll = ?");
    mysqli_stmt_bind_param($query, 's', $enrollKey);
    mysqli_stmt_execute($query);
    $result = mysqli_fetch_assoc(mysqli_stmt_get_result($query));
    return $result;
}

function getAllAbsence(int $user_id)
{
    global $conn;
    $query = mysqli_prepare($conn, "SELECT * FROM absensilist WHERE absensi_owner = ?");
    mysqli_stmt_bind_param($query, 'i', $user_id);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);
    return $result;
}

function getTotalUserTaken(int $absence_id)
{
    global $conn;
    $query = mysqli_prepare($conn, "SELECT COUNT(*) total FROM absensienroll WHERE absensi_id = ? AND status = 'Taken';");
    mysqli_stmt_bind_param($query, 'i', $absence_id);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);
    return $result;
}

function getLastAbsenceId()
{
    global $conn;
    $query = mysqli_prepare($conn, "SELECT MAX(absensi_id) id FROM absensilist;");
    mysqli_stmt_execute($query);
    $result = mysqli_fetch_assoc(mysqli_stmt_get_result($query));
    return $result['id'];
}

function getTotalAbsenceCreated(int $user_id)
{
    global $conn;
    $query = mysqli_prepare($conn, "SELECT COUNT(*) total FROM absensilist WHERE absensi_owner = ?;");
    mysqli_stmt_bind_param($query, 'i', $user_id);
    mysqli_stmt_execute($query);
    $result = mysqli_fetch_assoc(mysqli_stmt_get_result($query));
    return $result['total'];
}

function getTotalActiveAbsence(int $user_id)
{
    global $conn;
    $query = mysqli_prepare($conn, "SELECT getTotalActiveAbsence(?) total");
    mysqli_stmt_bind_param($query, 'i', $user_id);
    mysqli_stmt_execute($query);
    $result = mysqli_fetch_assoc(mysqli_stmt_get_result($query));
    return $result['total'];
}


function getAllActiveAbsence(int $user_id)
{
    global $conn;
    $query = mysqli_prepare($conn, "SELECT absensi_id, absensi_title, absensi_desc, getFullName(absensi_owner) absensi_owner, absensi_status, expired_at FROM absensienroll ae JOIN absensilist
    USING(absensi_id) WHERE ae.user_id = ? AND absensi_status = 'Opened' AND absensi_owner != ?;");
    mysqli_stmt_bind_param($query, 'ii', $user_id, $user_id);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);
    return $result;
}

function updateAbsence(int $absence_id, string $absence_title, string $absence_desc, string $opened_at, string $expired_at)
{
    global $conn;
    $absence = getAbsence($absence_id);
    $newOpenAt = empty($opened_at) ? $absence['opened_at'] : $opened_at;
    $query = mysqli_prepare($conn, "UPDATE absensilist SET absensi_title = ?, absensi_desc = ?, opened_at = ?, expired_at = ? WHERE absensi_id = ?");
    mysqli_stmt_bind_param($query, 'ssssi', $absence_title, $absence_desc, $newOpenAt, $expired_at, $absence_id);
    $result = mysqli_stmt_execute($query);
    return $result;
}

function getEnrolledUserOn(int $absence_id)
{
    global $conn;
    $query = mysqli_prepare($conn, "SELECT getFullName(user_id) username, enrolled_at, status, taken_at FROM absensienroll WHERE absensi_id = ?");
    mysqli_stmt_bind_param($query, 'i', $absence_id);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);
    return $result;
}

function getTotalAbsenceTaken(int $absence_id)
{
    global $conn;
    $query = mysqli_prepare($conn, "SELECT COUNT(*) total FROM absensienroll WHERE status = 'Taken' AND absensi_id = ?");
    mysqli_stmt_bind_param($query, 'i', $absence_id);
    mysqli_stmt_execute($query);
    $result = mysqli_fetch_assoc(mysqli_stmt_get_result($query));
    return $result['total'];
}

function getTotalUnknownAbsence(int $absence_id)
{
    global $conn;
    $query = mysqli_prepare($conn, "SELECT COUNT(*) total FROM absensienroll WHERE status = 'Unknown' AND absensi_id = ?");
    mysqli_stmt_bind_param($query, 'i', $absence_id);
    mysqli_stmt_execute($query);
    $result = mysqli_fetch_assoc(mysqli_stmt_get_result($query));
    return $result['total'];
}

// Enroll needs
function enrollAbsence($absence_id, $user_id)
{
    global $conn;
    $query = mysqli_prepare($conn, "INSERT INTO absensienroll(absensi_id, user_id) VALUES(?, ?)");
    mysqli_stmt_bind_param($query, 'ii', $absence_id, $user_id);
    $result = mysqli_stmt_execute($query);
    return $result;
}

function isUserEnrolled($absence_id, $user_id)
{
    global $conn;
    $query = mysqli_prepare($conn, "SELECT * FROM absensienroll WHERE absensi_id = ? AND user_id = ?");
    mysqli_stmt_bind_param($query, 'ii', $absence_id, $user_id);
    mysqli_stmt_execute($query);
    $result = mysqli_fetch_assoc(mysqli_stmt_get_result($query));
    return ($result) ? $result : false;
}

function takeAbsence($absence_id, $user_id)
{
    global $conn;
    $query = mysqli_prepare($conn, "UPDATE absensienroll SET taken_at = NOW(), status = 'Taken' WHERE absensi_id = ? AND user_id = ?;");
    mysqli_stmt_bind_param($query, 'ii', $absence_id, $user_id);
    $result = mysqli_stmt_execute($query);
    return $result;
}

// Misc
function buildModalMsg(string $msg, string $title = 'Error', array $buttons = ['back'], string $class = 'bi-exclamation-circle-fill text-danger')
{
    $msg = [
        "title" => $title,
        "msg" => $msg,
        "class" => $class,
        "buttons" => $buttons
    ];
    return $msg;
}

function resetModalMsg()
{
    $_SESSION['modal-msg'] = '';
}

function buildSession($user_id, $email, $user_name, $is_admin)
{
    $_SESSION['is_login'] = true;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $user_name;
    $_SESSION['is_admin'] = $is_admin;
}

function destroySession()
{
    $_SESSION = [];
    session_unset();
    session_reset();
    session_destroy();
}

function generateRandomString($length = 6)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
