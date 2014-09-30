<?php
class BugsController extends Zend_Controller_Action
{

    public function init()
    {
        $project = new Application_Model_Projects();
        $this->view->projectmenu = $project->getProjects();
    }

    public function indexAction()
    {
        $projectId = $this->_getParam('projectId', 0);
        $categoryId = $this->_getParam('categoryId', 0);

        if ($projectId) {
            $category = new Application_Model_DbTable_Category();
            $categoryArray = $category->getCategory($categoryId);
            if($categoryArray == 0){
                $categoryArray = array('name' => 'None', 'id' => 0);
            }
            $this->view->category = $categoryArray;

            $bugs = new Application_Model_DbTable_Bugs();

            $bugsAll = $bugs->getBugsByProjectAndCategory($projectId,$categoryId);

            $this->view->bugs = $bugsAll;

            $project = new Application_Model_DbTable_Projects();

            $this->view->project = $project->getProjects($projectId);

            $form = new Application_Form_Bugs();
            $this->view->form = $form;

            if ($this->getRequest()->isPost()) {

                $formData = $this->getRequest()->getPost();

                $number = $bugs->getNumber($projectId,$categoryId);

                $i = $number['number']+1;

                if ($form->isValid($formData)) {
                    $data = array(
                        'text'=> $form->getValue('text'),
                        'userId'=> Zend_Auth::getInstance()->getIdentity()->id,
                        'date'=> time(),
                        'number'=> $i,
                        'status'=> '0',
                        'projectId'=> $projectId,
                        'categoryId' => $categoryId
                    );

                    $bugs->insert($data);
                    $request = $this->getRequest();
                    $request->getHeader('referer');
                }
            }

        }
    }
    public function categoryAction(){
        $project = new Application_Model_DbTable_Projects();
        $projectId = $this->_getParam('projectId', 0);
        if($projectId){
            $this->view->project = $project->getProjects($projectId);
            $category = new Application_Model_DbTable_Category();
            $categoryAll = $category->getCategoryByProject($projectId);

            $this->view->category = $categoryAll;


        }
    }

}

