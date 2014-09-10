<?php
class HelpControllerTest extends ControllerTestCase
{
    public function testIndexAction()
    {
        $this->dispatch('/help/index');
        $this->assertModule('default');
        $this->assertController('help');
        $this->assertAction('index');
    }

    public function testLogoutAction()
    {
        $this->dispatch('/help/logout');
        $this->assertModule('default');
        $this->assertController('help');
        $this->assertAction('logout');
    }

    public function testLoginAction()
    {
        $this->dispatch('/help/login');
        $this->assertModule('default');
        $this->assertController('help');
        $this->assertAction('login');

        $this->request->setMethod('POST')
            ->setPost(array(
                'username' => 'foobar',
                'password' => 'foobar'
            ));
        $request = $this->getRequest();
        $this->assertQueryCount('form#login', 1);

    }

    public function testTrueUserLoginAction()
    {
        // эмулируем отправку формы
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                "username" => "admin",
                "password" => "admin"));

        $this->dispatch('/help/login');

        // аутентификация должна пройти успешно, идентифицироваться мы должны как user
        $this->assertEquals(Zend_Auth::getInstance()->getIdentity()->username, 'admin');

        // мы должны быть перенаправлены на главную страницу
        $this->assertRedirectTo('/help');
    }
        public function testFalseUserLoginAction()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array("username" => "user",
                "password" => "654321"));

        $this->dispatch('/help/login');

        // ищем в доме элемент с ID="error" и контентом 'Authorization error. Please check login or/and password'
        // лучше использовать assertQueryCount
        $this->assertQueryContentContains('#error', 'Authorization error. Please check login or/and password');
    }

    public function testLogoutExitAction()
    {
        // логинимся


        // вызываем логаут
        $this->dispatch('/help/logout/');

        // теперь мы должны быть "забыты" Zend_Auth'ом
        $this->assertNull(Zend_Auth::getInstance()->getIdentity());
    }
    public function testMethodsaddAction()
    {
        $this->dispatch('/help/methodsadd');
        $this->assertModule('default');
        $this->assertController('help');
        $this->assertAction('methodsadd');
        $this->request->setMethod('POST')
            ->setPost(array(
                'name'=> 'foobar',
                'description'=> 'foobar',
                'parameters'=> 'foobar',
                'data'=> 1555512
            ));
    }

    public function testMethodAction()
    {
        $this->dispatch('/help/method');
        $this->assertModule('default');
        $this->assertController('help');
        $this->assertAction('method');
    }

    public function testMethodWithIdAction()
    {
        $this->dispatch('/help/method/id/1');
        $this->assertModule('default');
        $this->assertController('help');
        $this->assertAction('method');
    }

    public function testRequestAction()
    {
        $this->dispatch('/help/request');
        $this->assertModule('default');
        $this->assertController('help');
        $this->assertAction('request');
        $this->request->setMethod('POST')
            ->setPost(array(
                'description'=> 'foobar',
                'username' => 'foobar',
                'date'=> 15516
            ));
    }



    public function testRequestallAction()
    {
        $this->dispatch('/help/requestall');
        $this->assertModule('default');
        $this->assertController('help');
        $this->assertAction('requestall');
    }

    public function testErrorAction()
    {
        $this->dispatch('/help/error');
        $this->assertModule('default');
        $this->assertController('help');
        $this->assertAction('error');
        $this->request->setMethod('POST')
            ->setPost(array(
                'capture' => 'foobar',
                'description'=> 'foobar',
                'username' => 'foobar',
                'date'=> 1235
            ));
    }

    public function testRequeststatusAction()
    {
        $this->dispatch('/help/requeststatus');
        $this->assertModule('default');
        $this->assertController('help');
        $this->assertAction('requeststatus');
    }
    public function testRequeststatusWithIdAction()
    {
        $this->dispatch('/help/requeststatus/id/1');
        $this->assertModule('default');
        $this->assertController('help');
        $this->assertAction('requeststatus');
    }
    public function testErrorstatusAction()
    {
        $this->dispatch('/help/errorstatus');
        $this->assertModule('default');
        $this->assertController('help');
        $this->assertAction('errorstatus');
    }

    public function testErrorstatusWithIdAction()
    {
        $this->dispatch('/help/errorstatus/id/1');
        $this->assertModule('default');
        $this->assertController('help');
        $this->assertAction('errorstatus');
    }
    public function testErrorallAction()
    {
        $this->dispatch('/help/errorall');
        $this->assertModule('default');
        $this->assertController('help');
        $this->assertAction('errorall');
    }
    public function testMethodsAction()
    {
        $this->dispatch('/help/methods');
        $this->assertModule('default');
        $this->assertController('help');
        $this->assertAction('methods');
    }
}