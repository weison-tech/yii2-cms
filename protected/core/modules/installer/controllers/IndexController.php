<?php

/**
 * @link http://www.itweshare.com
 * @copyright Copyright (c) 2017 Itweshare
 * @author xiaomalover <xiaomalover@gmail.com>
 */

namespace core\modules\installer\controllers;

use core\components\Controller;

/**
 * Index Controller shows a simple welcome page.
 */
class IndexController extends Controller
{

    /**
     * Index View just provides a welcome page
     */
    public function actionIndex()
    {
        return $this->render('index', array());
    }

    /**
     * Checks if we need to call SetupController or ConfigController.
     */
    public function actionGo()
    {
        if ($this->module->checkDBConnection()) {
            return $this->redirect(['setup/init']);
        } else {
            return $this->redirect(['setup/pre-requisites']);
        }
    }

}
