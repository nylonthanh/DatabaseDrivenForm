<?php

namespace Cleanify\Controller;

class Page
{
    protected $formFields;

    public function __construct($view = 'form')
    {
        if ($view === 'form') {
            $this->formFields = (new Form())->getFormFields();
            $this->displayFormFields($this->formFields);

        }

        if ($view === 'thanks') {
            //load thanks page
        }

    }

    public function displayFormFields($formArray)
    {
        if (empty($formArray)) {
            die('empty config');
        }

        (new Form)->display('form.tpl', $formArray, 'src/Controller/Form.php');

    }

    public function displayThankYouPage()
    {
        
    }

    public function sendEmail()
    {
        
    }

    public function errorPage()
    {

    }
}

