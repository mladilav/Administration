<?php

class ProjectController extends Zend_Controller_Action
{

    public function init()
    {
        $project = new Application_Model_Projects();
        $this->view->projectmenu = $project->getProjects();
    }

    public function indexAction()
    {
        $project = new Application_Model_DbTable_Projects();
        $this->view->project = $project->fetchAll();
    }

    public function addAction()
    {
        $form = new Application_Form_Project();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $data = array(
                    'name'=> $form->getValue('name'),
                    'description'=> $form->getValue('description')
                );
                $project = new Application_Model_DbTable_Projects();
                $project->addProjects($data);

                $change = new Application_Model_DbTable_Changes();
                $array = array(
                    'userId' => Zend_Auth::getInstance()->getIdentity()->id,
                    'username' => Zend_Auth::getInstance()->getIdentity()->username,
                    'date' => time(),
                    'type' => 'Add',
                    'body' => 'Added project - '.$form->getValue('name')
                );
                $change->addChanges($array);

                $this->_helper->redirector('add', 'project');

            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        $form = new Application_Form_Project();

        $this->view->form = $form;
        $form->add->setLabel('Save');
        if ($this->getRequest()->isPost()) {

            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $data = array(
                    'id'=> $form->getValue('id'),
                    'name'=> $form->getValue('name'),
                    'description'=> $form->getValue('description')
                );
                $project = new Application_Model_DbTable_Projects();
                $project->updateProjects($data);

                $change = new Application_Model_DbTable_Changes();
                $array = array(
                    'userId' => Zend_Auth::getInstance()->getIdentity()->id,
                    'username' => Zend_Auth::getInstance()->getIdentity()->username,
                    'date' => time(),
                    'type' => 'Change',
                    'body' => 'Changed project - '.$form->getValue('name')
                );
                $change->addChanges($array);

                $this->_helper->redirector('index','project');

            } else {
                $form->populate($formData); }

            } else {
                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                    $project = new Application_Model_DbTable_Projects();
                    $form->populate($project->getProjects($id));
            }
        }
    }

    public function deleteAction(){
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Yes') {
                $id = $this->getRequest()->getPost('id');
                $project = new Application_Model_DbTable_Projects();
                $proj = $project->getProjects($id);
                $project->deleteProjects($id);
                $method = new Application_Model_DbTable_Methods();
                $method->deleteByProjectMethods($id);

                $change = new Application_Model_DbTable_Changes();
                $array = array(
                    'userId' => Zend_Auth::getInstance()->getIdentity()->id,
                    'username' => Zend_Auth::getInstance()->getIdentity()->username,
                    'date' => time(),
                    'type' => 'Delete',
                    'body' => 'Deleted project - '.$proj['name']
                );
                $change->addChanges($array);
            }

            $this->_helper->redirector('index','project');
        } else {

            $id = $this->_getParam('id');
            $project = new Application_Model_DbTable_Projects();
            $this->view->project = $project->getProjects($id);
        }
    }


    public function detailAction(){

        $project = new Application_Model_DbTable_Projects();
        $id = $this->_getParam('id', 0);
        if($id){
        $this->view->project = $project->getProjects($id);}
    }


}

