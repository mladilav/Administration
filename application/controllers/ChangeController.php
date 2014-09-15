<?php
class ChangeController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $change = new Application_Model_DbTable_Changes();
        $this->view->change = $change->fetchAll($change->select()->order('date DESC'));
    }

}

