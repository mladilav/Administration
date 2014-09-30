<?php

class Application_Model_DbTable_Bugs extends Zend_Db_Table_Abstract
{

    protected $_name = 'bugs';
    public function getBugs($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if(!$row) {
            throw new Exception("Нет записи с id - $id");
        }
        return $row->toArray();
    }

    public function addBugs($data)
    {
        $this->insert($data);
    }

    public  function updateBugs($data)
    {
        $this->update($data, 'id = ' . (int)$data['id']);
    }
    public  function getBugsId($data)
    {
        $rows = $this->fetchRow(
            'projectId = '
            .(int)$data['projectId']
            . ' AND categoryId = '
            .(int)$data['categoryId']
            . ' AND number = '
            .(int)$data['number']);

        $array = $rows->toArray();
        return $array['id'];
    }

    public function deleteBugs($id)
    {
        $this->delete('id = ' . (int)$id);
    }

    public function getBugsByProjectAndCategory($projectId, $categoryId){
        $rows = $this->fetchAll($this->select()->where("projectId =".(int)$projectId)->where("categoryId =".(int)$categoryId)
        ->order('number'));
        if($rows->count()){return $rows->toArray();}
        return $rows->count();
    }

    public function getNumber($projectId,$categoryId){
       $rows = $this->fetchAll($this->select()->where("projectId =".(int)$projectId)->where("categoryId =".(int)$categoryId)
           ->order('number DESC'));
        if(!$rows->count()){
            return 0;
        }
        $array = $rows->toArray();
        return $array[0];
    }

}
