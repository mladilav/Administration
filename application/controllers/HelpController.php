<?php

class HelpController extends Zend_Controller_Action
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
    }

    public function errorAction()
    {
        $form = new Application_Form_Error();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $data = array(
                    'capture' => $form->getValue('capture'),
                    'description'=> $form->getValue('description'),
                    'username' => Zend_Auth::getInstance()->getIdentity()->username,
                    'date'=>time()
                );
                $Errors = new Application_Model_DbTable_Errors();
                $Errors->addErrors($data);

                $change = new Application_Model_DbTable_Changes();
                $array = array(
                    'userId' => Zend_Auth::getInstance()->getIdentity()->id,
                    'username' => Zend_Auth::getInstance()->getIdentity()->username,
                    'date' => time(),
                    'type' => 'Add',
                    'body' => 'Added reports of error.'
                );
                $change->addChanges($array);

                $this->_helper->redirector('index', 'help');

            } else {
                $form->populate($formData);//
            }
        }
    }


    public function errorstatusAction(){
        $id = $this->_getParam('id', 0);
        if ($id > 0) {
            $Errors = new Application_Model_DbTable_Errors();
            $data = array('id' => $id,'status' => '1');
            $Errors->updateErrors($data);
            $err = $Errors->getErrors($id);

            $change = new Application_Model_DbTable_Changes();
            $array = array(
                'userId' => Zend_Auth::getInstance()->getIdentity()->id,
                'username' => Zend_Auth::getInstance()->getIdentity()->username,
                'date' => time(),
                'type' => 'Change',
                'body' => 'Changed status error. '.$err['description']
            );
            $change->addChanges($array);

            $this->_helper->redirector('errorall', 'help');
        }
    }


    public function errorallAction()
    {
        $error = new Application_Model_DbTable_Errors();
        $this->view->error = $error->fetchAll($error->select()->order('date DESC'));
    }





}

