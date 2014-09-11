<?php

class ProjectController extends Zend_Controller_Action
{

    public function init()
    {

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
                $project->deleteProjects($id);
                $method = new Application_Model_DbTable_Methods();
                $method->deleteByProjectMethods($id);
            }

            $this->_helper->redirector('index','project');
        } else {

            $id = $this->_getParam('id');
            $project = new Application_Model_DbTable_Projects();
            $this->view->project = $project->getProjects($id);
        }
    }



}

