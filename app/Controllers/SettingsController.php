<?php

namespace App\Controllers;

use App\Classes\Validator;
use Core\Admin\ControllerAbstract;
use Core\Response;

class SettingsController extends ControllerAbstract
{
    public static function setUp($router, $lang)
    {
        $router->addRoute('settings', 'settings', 'get', 'index');
        $router->addRoute('settings.update', 'settings/update', 'post', 'update');
        $router->addMenu($lang->_('settings.title'), 'settings', 'fa-wrench', -1);
    }

    public function index()
    {
        $settings = require(ABS_PATH.'config.php');

        $this->view->set(['settings' => $settings]);

        return new Response($this->view->render('settings.index'));
    }

    public function update()
    {
        $validator = new Validator($this->postParams, [
            'DEBUG' => 'required',
            'SITE_NAME' => 'required',
            'THEME' => 'required'
        ]);

        if (!$validator->validate()) {
            return (new Response())->redirect()->with(['errors' => $validator->getErrors()]);
        } else {
            $settings = require(ABS_PATH.'config.php');

            foreach ($this->postParams as $key => $value)
                $settings[$key] = $value;

            //TODO Make SettingsManagerClass
            //TODO Change config file format to json

            return (new Response())->redirect()->with(['success' => $this->lang->_('settings.updateSuccess')]);
        }
    }
}