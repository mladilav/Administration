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
            $this->_helper->redirector('login','user');
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

                $projects = new Application_Model_DbTable_Projects();
                $proj = $projects->getProjects($form->getValue('projectId'));
                $change = new Application_Model_DbTable_Changes();
                $array = array(
                    'userId' => Zend_Auth::getInstance()->getIdentity()->id,
                    'username' => Zend_Auth::getInstance()->getIdentity()->username,
                    'date' => time(),
                    'type' => 'Add',
                    'body' => 'Added method - '.$form->getValue('name').' in project '.$proj['name']
                );
                $change->addChanges($array);


                $this->_helper->redirector('add', 'method');

            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        $form = new Application_Form_Method_Add();
        $this->view->form = $form;
        $form->add->setLabel('Save');
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $data = array(
                    'id' => $form->getValue('id'),
                    'name'=> $form->getValue('name'),
                    'username'=> Zend_Auth::getInstance()->getIdentity()->username,
                    'short'=> $form->getValue('short'),
                    'description'=> $form->getValue('description'),
                    'projectId'=> $form->getValue('projectId'),
                    'success'=> $form->getValue('success'),
                    'data'=> $form->getValue('data')
                );

                $methods = new Application_Model_DbTable_Methods();
                $methods->updateMethods($data);

                $projects = new Application_Model_DbTable_Projects();
                $proj = $projects->getProjects($form->getValue('projectId'));
                $change = new Application_Model_DbTable_Changes();
                $array = array(
                    'userId' => Zend_Auth::getInstance()->getIdentity()->id,
                    'username' => Zend_Auth::getInstance()->getIdentity()->username,
                    'date' => time(),
                    'type' => 'Change',
                    'body' => 'Changed method - '.$form->getValue('name').' in project '.$proj['name']
                );
                $change->addChanges($array);

                $this->_helper->redirector('add', 'method');

            } else {
                $form->populate($formData);
            }
        } else
        {
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
            $methods = new Application_Model_DbTable_Methods();
            $form->populate($methods->getMethods($id));
            }
        }
    }


    public function detailAction()
    {
        $id = $this->_getParam('id', 0);
        if ($id > 0) {
            $methods = new Application_Model_DbTable_Methods();
            $this->view->method = $methods->getMethods($id);
            $methodsError = new Application_Model_DbTable_Methoderror();
            $this->view->methoderror = $methodsError->getByMethodId($id);
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

                    $methods = new Application_Model_DbTable_Methods();
                    $method = $methods->getMethods($methodId);

                    $change = new Application_Model_DbTable_Changes();
                    $array = array(
                        'userId' => Zend_Auth::getInstance()->getIdentity()->id,
                        'username' => Zend_Auth::getInstance()->getIdentity()->username,
                        'date' => time(),
                        'type' => 'Add',
                        'body' => 'Added description of error in method - <a href="/method/detail/id/'.$method['id'].'">'
                            .$method['name'].'</a>.'
                    );
                    $change->addChanges($array);
                    echo '<div class="alert alert-success">SUCCESS</div>';

                } else {
                    $form->populate($formData);
                }
            }
        }
    }

    public function erroreditAction()
    {

            $form = new Application_Form_Method_Error();
            $this->view->form = $form;
            if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $data = array(
                        'id'=> $form->getValue('id'),
                        'name'=> $form->getValue('name'),
                        'description'=> $form->getValue('description'),
                        'body' => $form->getValue('body'),
                    );

                    $methods = new Application_Model_DbTable_Methoderror();
                    $methods->updateMethoderror($data);

                    $error = $methods->getMethoderror($form->getValue('id'));
                    $methodss = new Application_Model_DbTable_Methods();
                    $method = $methodss->getMethods($error['methodId']);

                    $change = new Application_Model_DbTable_Changes();
                    $array = array(
                        'userId' => Zend_Auth::getInstance()->getIdentity()->id,
                        'username' => Zend_Auth::getInstance()->getIdentity()->username,
                        'date' => time(),
                        'type' => 'Change',
                        'body' => 'Changed description of error '.$form->getValue('name').
                            ' in method - <a href="/method/detail/id/'.$method['id'].'">'
                            .$method['name'].'</a>.'
                    );
                    $change->addChanges($array);

                    echo '<div class="alert alert-success">SUCCESS</div>';

                } else {
                    $form->populate($formData);
                }
            } else{
                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                    $error = new Application_Model_DbTable_Methoderror();
                    $form->populate($error->getMethoderror($id));
                }
            }
       }

    public function deleteAction(){
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Yes') {
                $id = $this->getRequest()->getPost('id');
                $methods = new Application_Model_DbTable_Methods();

                $method = $methods->getMethods($id);
                $projects = new Application_Model_DbTable_Projects();
                $proj = $projects->getProjects($method['projectId']);


                $change = new Application_Model_DbTable_Changes();
                $array = array(
                    'userId' => Zend_Auth::getInstance()->getIdentity()->id,
                    'username' => Zend_Auth::getInstance()->getIdentity()->username,
                    'date' => time(),
                    'type' => 'Delete',
                    'body' => 'Deleted method - '.$method['name'].' in project '.$proj['name']
                );
                $change->addChanges($array);

                $methods->deleteMethods($id);
            }

            $this->_helper->redirector('index','project');
        } else {

            $id = $this->_getParam('id');
            $method = new Application_Model_DbTable_Methods();
            $this->view->method = $method->getMethods($id);
            $error = new Application_Model_DbTable_Methoderror();
            $error->deleteByMethodMethoderror($id);
        }
    }

    public function errordeleteAction(){
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Yes') {
                $id = $this->getRequest()->getPost('id');
                $error = new Application_Model_DbTable_Methoderror();
                $error->deleteMethoderror($id);
            }

            $this->_helper->redirector('index','project');
        } else {

            $id = $this->_getParam('id');
            $error = new Application_Model_DbTable_Methoderror();
            $this->view->error = $error->getMethoderror($id);
        }
    }


}

