<?php

namespace Cleanify\Controller;

CONST EMAIL_FORM = 'thanh.pham@yahoo.com';

class Email
{
    public static $subject = 'Form has been submitted';

    /**
     * @param $formData
     * @throws Exception
     * @todo refactor to use interface to allow mailgun or other services
     */
    public static function sendEmail($formData)
    {
        try {
            $formString = Email::arrayToEmailFormatter($formData);

        } catch(\Exception $e) {
            error_log("Email failed: " . $e->getMessage(), 3, realpath(dirname(__FILE__) . '/..') . '/config/errorLog.txt');
            throw new \Exception("Email Error: array to string conversion failure; $e->getMessage()");
        }

        try {
            mail(EMAIL_FORM, self::$subject, $formString);
        } catch(\Exception $e) {
            error_log("Email failed: " . $e->getMessage(), 3, realpath(dirname(__FILE__) . '/..') . '/config/errorLog.txt');
            throw new Exception("Email Error: $e->getMessage()");
        }

    }

    public static function arrayToEmailFormatter($array)
    {
        if (empty($array)) {
            throw new \Exception("Cannot convert data to email because it's empty. Line: " . __LINE__);
        }

        $length = count($array);
        $string = '';
        foreach ($array as $index => $value) {
            $string .= "$index = $value \n";

        }

        return $string;

    }

}