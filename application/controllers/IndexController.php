<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('login','user');
        }

        $project = new Application_Model_DbTable_Projects();
        $this->view->project = $project->fetchAll();
    }

}

