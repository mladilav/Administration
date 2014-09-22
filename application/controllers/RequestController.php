<?php

class RequestController extends Zend_Controller_Action
{



    public function init()
    {
        /* Initialize action controller here */
        $project = new Application_Model_Projects();
        $this->view->projectmenu = $project->getProjects();
    }

    public function indexAction()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('login','user');
        }
        $Request = new Application_Model_DbTable_Request();
        $this->view->request = $Request->fetchAll($Request->select()->order('date DESC'));
    }

    public function addAction()
    {
        $form = new Application_Form_Request();
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

                $change = new Application_Model_DbTable_Changes();
                $array = array(
                    'userId' => Zend_Auth::getInstance()->getIdentity()->id,
                    'username' => Zend_Auth::getInstance()->getIdentity()->username,
                    'date' => time(),
                    'type' => 'Add',
                    'body' => 'Added request - '.$form->getValue('description')
                );
                $change->addChanges($array);

                $this->_helper->redirector('index', 'help');

            } else {
                $form->populate($formData);
            }
        }
    }



    public function statusAction(){
        $id = $this->_getParam('id', 0);
        if ($id > 0) {
            $Request = new Application_Model_DbTable_Request();
            $data = array('id' => $id,'status' => '1');
            $Request->updateRequest($data);
            $req = $Request->getRequest($id);
            $change = new Application_Model_DbTable_Changes();
            $array = array(
                'userId' => Zend_Auth::getInstance()->getIdentity()->id,
                'username' => Zend_Auth::getInstance()->getIdentity()->username,
                'date' => time(),
                'type' => 'Change',
                'body' => 'Changed status request - '.$req['description']
            );
            $change->addChanges($array);

            $email=new Application_Model_TEmail();
            $email->from_email = 'info@vallverk.com';
            $email->from_name = 'Vallverk';
            $email->to_email = 'mladilav2014@gmail.com';
            $email->to_name = 'Users';
            $email->subject = 'Changes';
            $email->type = 'text/html';
            $email->body = '
                        <h1>Support service - Vallverk.com</h1>
                            <p>Changed status request - '.$req['description'].'</p>';
            $email->send();


            $this->_helper->redirector('index', 'request');
        }
    }

    public function sendAction(){
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

