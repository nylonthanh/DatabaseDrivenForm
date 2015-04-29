<?php

namespace Cleanify\Controller;

require_once(realpath(dirname(__FILE__) . '/..') . '/Helper/Smarty-3.1.21/libs/Smarty.class.php');

/**
 * Class Page
 * @package Cleanify\Controller
 * @todo redesign smarty stuff out to allow code reuse
 * @todo redesign pages, to reuse code
 */
class Page
{
    protected $formFields;
    protected $smarty = null;

    public function __construct($view = 'form')
    {
        $this->smarty = new \Smarty();
        $this->smarty->template_dir = realpath(dirname(__FILE__) . '/..') . '/View/templates/';
        $this->smarty->compile_dir = realpath(dirname(__FILE__) . '/..') . '/View/templates_c/';

        if ($view === 'form') {
            $this->formFields = (new Form())->getFormFields();
            $this->displayFormFields($this->formFields);

        }

        if ($view === 'thanks') {
            //load thanks page
            $this->displayStaticPage('thankYou.tpl');
        }

    }

    public function displayFormFields($formArray)
    {
        if (empty($formArray)) {
            die('empty config');
        }

        (new Form)->display('form.tpl', $formArray, 'src/Controller/Form.php');

    }

    /**
     * meant to display static pages
     * @param $tpl
     * @param null $data
     */
    public function displayStaticPage($tpl)
    {
        $this->smarty->display($tpl);
        
    }

}

