<?php

class Application_Form_Methodsadd extends Zend_Form
{
    public function init()
    {
        $this->setName('methodsAdd');
        $isEmptyMessage = 'Значение является обязательным и не может быть пустым';
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name:')
            ->setRequired(true)
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );

        $short = new Zend_Form_Element_Textarea('short');
        $short->setLabel('Short:')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );

        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Description:')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );
        $parameters	 = new Zend_Form_Element_Textarea('parameters');
        $parameters	->setLabel('Parameters:')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );

        $data	 = new Zend_Form_Element_Textarea('data');
        $data	->setLabel('Data:')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );

        $submit = new Zend_Form_Element_Submit('add');
        $submit->setLabel('Add');


        $this->addElements(array($name,$short, $description,$parameters,$data, $submit));


        $this->setMethod('post');
    }
}
