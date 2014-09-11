<?php

class UserController extends Zend_Controller_Action
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

    public function loginAction()
    {

        if (Zend_Auth::getInstance()->hasIdentity()) {

            $this->_helper->redirector('help');
        }

        $form = new Application_Form_Login();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {

            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData)) {
                $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
                $authAdapter->setTableName('admin')
                    ->setIdentityColumn('username')
                    ->setCredentialColumn('password');

                $username = $this->getRequest()->getPost('username');
                $password = $this->getRequest()->getPost('password');
                $authAdapter->setIdentity($username)
                    ->setCredential($password);

                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);
                if ($result->isValid()) {
                    $identity = $authAdapter->getResultRowObject();
                    $authStorage = $auth->getStorage();
                    $authStorage->write($identity);
                    $this->_helper->redirector('index', 'help');
                } else {
                    $this->view->errMessage = 'Authorization error. Please check login or/and password';
                }
            }
        }
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index', 'help');
    }

    public function registrationAction()
    {
        if ($this->getRequest()->isPost()) {
            $data = array(
                'username' => $this->getRequest()->getPost('username'),
                'firstName' => $this->getRequest()->getPost('firstName'),
                'lastName' => $this->getRequest()->getPost('lastName'),
                'email' => $this->getRequest()->getPost('email'),
                'password' => $this->getRequest()->getPost('password'),
                'avatar' => $this->getRequest()->getPost('avatar'),
                'dateRegistration' => time(),
                'dateLogin' => time(),
            );
           // $user = new Application_D

        }

    }




}

