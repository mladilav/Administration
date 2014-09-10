<?php

class MethodController extends Zend_Controller_Action
{



    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('login','help');
        }
        $projectID = $this->_getParam('project', 0);
        if ($projectID > 0) {

        $project = new Application_Model_DbTable_Projects();
        $this->view->project = $project->getProjects($projectID);

        $methods = new Application_Model_DbTable_Methods();
        $this->view->methods = $methods->fetchAll("projectId = ".$projectID);
        }
    }


    public function addAction()
    {
        $form = new Application_Form_Method_Add();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $data = array(
                    'name'=> $form->getValue('name'),
                    'username'=> Zend_Auth::getInstance()->getIdentity()->username,
                    'short'=> $form->getValue('short'),
                    'description'=> $form->getValue('description'),
                    'projectId'=> $form->getValue('projectId'),
                    'success'=> $form->getValue('success'),
                    'data'=> $form->getValue('data')
                );

                $methods = new Application_Model_DbTable_Methods();
                $methods->addMethods($data);
                $this->_helper->redirector('add', 'method');

            } else {
                $form->populate($formData);
            }
        }
    }


    public function detailAction()
    {
        $id = $this->_getParam('id', 0);
        if ($id > 0) {
            $methods = new Application_Model_DbTable_Methods();
            $this->view->method = $methods->getMethods($id);
        }
    }

    public function errorAction()
    {
        $methodId = $this->_getParam('methodId', 0);
        if ($methodId > 0) {
            $form = new Application_Form_Method_Error();
            $this->view->form = $form;
            if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $data = array(
                        'name'=> $form->getValue('name'),
                        'description'=> $form->getValue('description'),
                        'body' => $form->getValue('body'),
                        'methodId' => $methodId
                    );

                    $methods = new Application_Model_DbTable_Methoderror();
                    $methods->addMethoderror($data);
                    echo '<div class="alert alert-success">SUCCESS</div>';

                } else {
                    $form->populate($formData);
                }
            }
        }
    }


}

