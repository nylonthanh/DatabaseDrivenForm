<?php

namespace Cleanify\Controller;

use Cleanify\Model as Model;

require_once(realpath(dirname(__FILE__) . '/../..') . '/vendor/autoload.php');
require_once(realpath(dirname(__FILE__) . '/..') . '/Helper/Smarty-3.1.21/libs/Smarty.class.php');

class Form
{
    protected $smarty = null;

    public function __construct()
    {
        $this->smarty = new \Smarty();
        $this->smarty->template_dir = realpath(dirname(__FILE__) . '/..') . '/View/templates/';
        $this->smarty->compile_dir = realpath(dirname(__FILE__) . '/..') . '../View/templates_c/';
    }

    public function display($tpl, $data = null, $url = 'src/Controller/Form.php')
    {
        $this->smarty->assign('formData', $data);
        $this->smarty->assign('formUrl', $url);
        $this->smarty->display($tpl);
    }

    /**
     * get form fields by calling Model to get from DB to build form
     */
    public function getFormFields()
    {
        return Model\FormFields::get();
    }

    public function submitForm(){
        
    }
}
ini_set('display_errors', -1);

if (isset($_POST) && sizeof($_POST) > 0) {
    try {
        SanitizeData::checkType($_POST, $type = 'array');
        //TODO: sanitize POST
        //TODO: validate fields
        $sanitizedData = $_POST;
        Model\FormFields::writeFields($sanitizedData);

    } catch(\Exception $e) {
        throw $e;
    }




    try {
        Email::sendEmail($sanitizedData);
    } catch (\Exception $e) {
        throw $e;
    }

    //thank you page
}
