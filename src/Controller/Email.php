<?php

namespace Cleanify\Controller;

CONST EMAIL_FORM = 'thanh.pham@yahoo.com';

class Email
{
    public $subject = 'Form has been submitted';

    public function sendEmail($formData)
    {
        try {
            mail(EMAIL_FORM, $this->subject, $formData);
        } catch(\Exception $e) {
            error_log("Email failed: " . $e->getMessage(), 3, realpath(dirname(__FILE__) . '/..') . '/config/errorLog.txt'); // "../errorLog.txt");
            throw new Exception("Email Error: $e->getMessage()");
        }

    }

}