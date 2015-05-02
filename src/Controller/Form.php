<?php

namespace Cleanify\Controller;

use Cleanify\Model as Model;

require_once(realpath(dirname(__FILE__) . '/../..') . '/vendor/autoload.php');
require_once(realpath(dirname(__FILE__) . '/..') . '/Helper/Smarty-3.1.21/libs/Smarty.class.php');

/**
 * Class Form
 * @package Cleanify\Controller
 * @todo move smarty stuff out to allow reusable code
 */
class Form
{
    protected $smarty = null;
    protected $formFieldObject;

    public function __construct()
    {
        //the formFieldObject is dependent on a db connection
        $this->formFieldObject = new Model\FormFields((new Model\DbConnection())->connect());

        $this->smarty = new \Smarty();
        $this->smarty->template_dir = realpath(dirname(__FILE__) . '/..') . '/View/templates/';
        $this->smarty->compile_dir = realpath(dirname(__FILE__) . '/..') . '/View/templates_c/';

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
        try {
            return $this->formFieldObject->get();

        } catch(\Exception $e) {
            throw $e;

        }

    }

    public function writeFieldsToDb($formData)
    {
        try {
            return $this->formFieldObject->writeFields($formData);

        } catch(\Exception $e) {
            throw $e;

        }
    }

}
