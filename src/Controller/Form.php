<?php

namespace Cleanify\Controller;

use Cleanify\Model as Model;

require_once '../Helper/Smarty-3.1.21/libs/Smarty.class.php';

class Form
{
    protected $smarty = null;

    public function __construct()
    {
        $this->smarty = new \Smarty();
        $this->smarty->template_dir = "../View/templates/";
        $this->smarty->compile_dir = "../View/templates_c/";

    }

    public function display($tpl)
    {
        $this->smarty->display($tpl);
    }

    /**
     * get form fields by calling Model to get from DB to build form
     */
    public function getFormFields()
    {
        return Model\FormFields::get();
    }
}
