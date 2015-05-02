<?php

namespace Cleanify\Controller;

require_once(realpath(dirname(__FILE__) . '/../..') . '/config/config.php');

/**
 * Class Email
 * @package Cleanify\Controlle
 * @todo refactor to use interface to allow mailgun or other services
 */
class Email implements EmailInterface
{
    public $subject;
    public $emailTo;

    public function __construct($subject = 'Form has been submitted',
                                $emailTo = EMAIL_FORM)
    {
        $this->subject = $subject;
        $this->emailTo =  $emailTo;

    }

    /**
     * @param $formData
     * @throws \Exception
     */
    public function sendEmail($formData)
    {
        try {
            $formString = $this->arrayToEmailFormatter($formData);

        } catch(\Exception $e) {
            error_log("Email failed: " . $e->getMessage(), 3, realpath(dirname(__FILE__) . '/..') . '/config/errorLog.txt');
            throw new \Exception("Email Error: array to string conversion failure; $e->getMessage()");

        }

        try {
            mail($this->emailTo, $this->subject, $formString);

        } catch(\Exception $e) {
            error_log("Email failed: " . $e->getMessage(), 3, realpath(dirname(__FILE__) . '/..') . '/config/errorLog.txt');
            throw new \Exception("Email Error: $e->getMessage()");

        }

    }

    /**
     * @param $array
     * @return string
     * @throws \Exception
     */
    protected function arrayToEmailFormatter($array)
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