<?php

include 'vendor/autoload.php';

/**
 * This is the client, will load up logic
 * Default page controller loads at the end
 */
ini_set('display_errors', 1);

$sanitizedData  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if (isset($sanitizedData) && sizeof($sanitizedData) > 0) {
    $sanitizeDataObject = new Cleanify\Controller\SanitizeData();

    $type = gettype($sanitizedData);
    //check sanitize data, check $sanitizedData data type is an array
    try {
        $sanitizeDataObject->checkType($sanitizedData, $type);

    } catch(\Exception $e) {
        (new Cleanify\Controller\Page('error', $e->getMessage()));

    }

    try {
        $sanitizeDataObject->checkRequiredAndNotEmpty($sanitizedData, $type);

    } catch(\Exception $e) {
        (new Cleanify\Controller\Page('error', $e->getMessage()));

    }

    try {
        Cleanify\Controller\Form::writeFieldsToDb($sanitizedData);

    } catch(\Exception $e){
        (new Cleanify\Controller\Page('error', $e->getMessage()));

    }

    try {
        (new Cleanify\Controller\Email())->sendEmail($sanitizedData);

    } catch (\Exception $e) {
        (new Cleanify\Controller\Page('error', $e->getMessage()));

    }

    (new Cleanify\Controller\Page('thanks'));

} else {
    //default page, form
    (new Cleanify\Controller\Page());

}
