<?php
//region CSRF Check
function csrf_validation_ajax($csrf_code)
{
    if (!isset($_SESSION[$csrf_code]) || $_SESSION[$csrf_code] != $csrf_code) {
        $error = 'CSRF Error';
        echo json_encode(
            array(
                "status" => '0',
                "message" => $error,
            )
        );
        http_response_code(201);
        exit;
    }
}

function csrf_validation($csrf_code,$redirect_address)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($csrf_code) || !isset($_SESSION[$_POST['_csrf']])) {
            redirect_to($redirect_address);
        } else {
            return  $csrf_code ;
        }
    }
}

//endregion CSRF Check
