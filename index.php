<?php

include 'vendor/autoload.php';

/**
 * This is the client
 */
ini_set('display_errors', 1);

$sanitizedData  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if (isset($sanitizedData) && sizeof($sanitizedData) > 0) {
    $type = 'array';
    //check sanitize data, check $sanitizedData data type is an array
    try {
        Cleanify\Controller\SanitizeData::checkType($sanitizedData, $type);

    } catch(\Exception $e) {
        (new Cleanify\Controller\Page('error', $e->getMessage()));
    }

    //check if it's required and not empty
    try {
        Cleanify\Controller\SanitizeData::checkRequiredAndNotEmpty($sanitizedData, $type);

    } catch(Exception $e) {
        (new Cleanify\Controller\Page('error', $e->getMessage()));
    }

    //TODO: validate fields
    //TODO: use controller to write fields
    try {
        Cleanify\Model\FormFields::writeFields($sanitizedData);

    } catch(Exception $e){
        (new Cleanify\Controller\Page('error', $e->getMessage()));

    }

    //send email of form submitted
    try {
        Cleanify\Controller\Email::sendEmail($sanitizedData);

    } catch (\Exception $e) {
        (new Cleanify\Controller\Page('error', $e->getMessage()));

    }

    (new Cleanify\Controller\Page('thanks'));

} else {
    (new Cleanify\Controller\Page());

}


