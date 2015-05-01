<?php

namespace Cleanify\Controller;

require_once(realpath(dirname(__FILE__) . '/..') . '/Helper/Smarty-3.1.21/libs/Smarty.class.php');

/**
 * Class Page
 * @package Cleanify\Controller
 * @todo redesign smarty stuff out to allow code reuse w interface /di
 * @todo redesign pages, to reuse code
 */
class Page
{
    protected $formFields;
    protected $smarty = null;

    public function __construct($view = 'form', $data = null)
    {
        $this->smarty = new \Smarty();
        $this->smarty->template_dir = realpath(dirname(__FILE__) . '/..') . '/View/templates/';
        $this->smarty->compile_dir = realpath(dirname(__FILE__) . '/..') . '/View/templates_c/';

        if ($view === 'form') {
            $this->formFields = (new Form())->getFormFields();
            $this->displayFormFields($this->formFields);

        }

        if ($view === 'thanks') {
            $this->displayStaticPage('thankYou.tpl', $data);
        }

        if ($view === 'error') {
            $this->displayStaticPage('error.tpl', $data);
        }

    }

    public function displayFormFields($formArray)
    {
        if (empty($formArray)) {
            (new \Cleanify\Controller\Page('error', 'Form config was empty. :( Please tell the admin!'));

        }

        (new Form)->display('form.tpl', $formArray, 'index.php');

    }

    /**
     * meant to display static pages
     * @param $tpl
     * @param null $data
     */
    public function displayStaticPage($tpl, $data = null)
    {
        $this->smarty->assign('data', $data);
        $this->smarty->display($tpl);
        die;

    }

}

