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
            $this->_helper->redirector('login','help');
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
    public function methodsAction()
    {
        $methods = new Application_Model_DbTable_Methods();
        $this->view->methods = $methods->fetchAll();
    }
    public function methodsaddAction()
    {
        $form = new Application_Form_Methodsadd();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $data = array(
                    'name'=> $form->getValue('name'),
                    'short'=> $form->getValue('short'),
                    'description'=> $form->getValue('description'),
                    'parameters'=> $form->getValue('parameters'),
                    'data'=> $form->getValue('data')
                );
                $methods = new Application_Model_DbTable_Methods();
                $methods->addMethods($data);
                $this->_helper->redirector('methodsadd', 'help');

            } else {
                $form->populate($formData);
            }
        }
    }

    public function methodAction()
    {
        $id = $this->_getParam('id', 0);
        if ($id > 0) {
        $methods = new Application_Model_DbTable_Methods();
        $this->view->method = $methods->getMethods($id);
    }
    }
    public function requestAction()
    {
        $form = new Application_Form_Requestmethods();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $data = array( 'description'=> $form->getValue('description'),
                               'username' => Zend_Auth::getInstance()->getIdentity()->username,
                               'date'=>time()
            );
                $Request = new Application_Model_DbTable_Request();
                $Request->addRequest($data);
                $this->_helper->redirector('index', 'help');

            } else {
                $form->populate($formData);
            }
        }
    }

    public function requestallAction()
    {
        $Request = new Application_Model_DbTable_Request();
        $this->view->request = $Request->fetchAll($Request->select()->order('date DESC'));
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
                $this->_helper->redirector('index', 'help');

            } else {
                $form->populate($formData);//
            }
        }
    }

    public function requeststatusAction(){
        $id = $this->_getParam('id', 0);
        if ($id > 0) {
            $Request = new Application_Model_DbTable_Request();
            $data = array('id' => $id,'status' => '1');
            $Request->updateRequest($data);
            $this->_helper->redirector('requestall', 'help');
        }
    }

    public function errorstatusAction(){
        $id = $this->_getParam('id', 0);
        if ($id > 0) {
            $Errors = new Application_Model_DbTable_Errors();
            $data = array('id' => $id,'status' => '1');
            $Errors->updateErrors($data);
            $this->_helper->redirector('errorall', 'help');
        }
    }


    public function errorallAction()
    {
        $error = new Application_Model_DbTable_Errors();
        $this->view->error = $error->fetchAll($error->select()->order('date DESC'));
    }

    public function sendrequestAction(){
        if ($this->getRequest()->isPost()) {

            $url = "http://" . $_POST['url'];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // указываем, что у нас POST запрос
            curl_setopt($ch, CURLOPT_POST, 1);
            // добавляем переменные
            curl_setopt($ch, CURLOPT_POSTFIELDS,  'data='.$_POST['body']);

            $output = curl_exec($ch);

            curl_close($ch);
            $this->view->data = $output;

        }

    }



}

