<?php

include 'vendor/autoload.php';

/**
 * This is the client
 */
//ini_set('display_errors', 1);

if (isset($_POST) && sizeof($_POST) > 0) {
    //sanitize data, check $_POST data type is correct
    try {
        Cleanify\Controller\SanitizeData::checkType($_POST, $type = 'array');
        //TODO: sanitize POST
        //TODO: validate fields
        $sanitizedData = $_POST; //<<<<<update me
        Cleanify\Model\FormFields::writeFields($sanitizedData);

    } catch(\Exception $e) {
        throw $e;
    }

    //send email of form submitted
    try {
        Cleanify\Controller\Email::sendEmail($sanitizedData);
    } catch (\Exception $e) {
        throw $e;
    }

    (new Cleanify\Controller\Page('thanks'));

} else {
    (new Cleanify\Controller\Page());
}


