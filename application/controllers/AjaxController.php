<?php
class AjaxController extends Zend_Controller_Action
{

    public function init()
    {
        $project = new Application_Model_Projects();
        $this->view->projectmenu = $project->getProjects();
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

    }

    public function bugsAction(){

        if ($this->getRequest()->isPost()) {
            $bugs = new Application_Model_DbTable_Bugs();
            $array = array(
                'id' =>  $this->getRequest()->getPost('id'),
                'status' =>  $this->getRequest()->getPost('status'),
            );
            $bugs->updateBugs($array);
        }

    }

    public function addbugsAction(){

        if ($this->getRequest()->isPost()) {
            $bugs = new Application_Model_DbTable_Bugs();
            $projectId = $_POST['projectId'];
            $categoryId = $_POST['categoryId'];
            $number = $bugs->getNumber($projectId,$categoryId);

            if(!$number){$i = 0;} else{
            $i = $number['number']+1;}

            $data = array(
                'text'=> $_POST['text'],
                'userId'=> Zend_Auth::getInstance()->getIdentity()->id,
                'date'=> time(),
                'number'=> $i,
                'status'=> '0',
                'projectId'=> $projectId,
                'categoryId' => $categoryId
            );

            $id = $bugs->insert($data);
            $bugsArray = $bugs->getBugsByProjectAndCategory($projectId,$categoryId);

            echo json_encode($bugsArray);

        }

    }


    public function addcategoryAction(){

        if ($this->getRequest()->isPost()) {

            $category = new Application_Model_DbTable_Category();
            $projectId = $_POST['projectId'];

            $data = array(
                'name'=> $_POST['name'],
                'projectId'=> $projectId,
            );

            $category->insert($data);
            $categoryArray = $category->getCategoryByProject($projectId);

            echo json_encode($categoryArray);

        }

    }
    public function sortAction(){

        if ($this->getRequest()->isPost()) {

            $bugs = new Application_Model_DbTable_Bugs();

            $projectId = $this->getRequest()->getPost('projectId');
            $categoryId = $this->getRequest()->getPost('categoryId');
            $number = $bugs->getNumber($projectId,$categoryId);
            $i = $number['number']+1;

            foreach($_POST['number'] as &$element){
                $arrays = array(
                'projectId' =>  $projectId,
                'categoryId' => $categoryId,
                'number' => $element,
                );

                $id = $bugs->getBugsId($arrays);
                $array = array(
                    'id' => $id,
                    'number' => $i,
                );
                $bugs->updateBugs($array);
                $i++;

            }

            $number = $number['number']+1;
            $i = 1;
            foreach($_POST['number'] as &$element){
                $arrays = array(
                    'projectId' =>  $projectId,
                    'categoryId' => $categoryId,
                    'number' => $number,
                );

                $id = $bugs->getBugsId($arrays);
                $array = array(
                    'id' => $id,
                    'number' => $i,
                );
                $bugs->updateBugs($array);
                $number++;
                $i++;

            }

            $bugsArray = $bugs->getBugsByProjectAndCategory($projectId,$categoryId);

            echo json_encode($bugsArray);


        }

    }


}

