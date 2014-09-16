<?php
class ChangeController extends Zend_Controller_Action
{

    public function init()
    {
        $project = new Application_Model_Projects();
        $this->view->projectmenu = $project->getProjects();
    }

    public function indexAction()
    {
        $change = new Application_Model_DbTable_Changes();
        $this->view->change = $change->fetchAll($change->select()->order('date DESC'));
    }

}

