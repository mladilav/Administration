<?php

class Application_Model_DbTable_Category extends Zend_Db_Table_Abstract
{

    protected $_name = 'category';
    public function getCategory($id)
    {

        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if(!$row) {
            return 0;
        }
        return $row->toArray();
    }

    public function addCategory($data)
    {
        $this->insert($data);
    }

    public  function updateCategory($data)
    {
        $this->update($data, 'id = ' . (int)$data['id']);
    }

    public function deleteCategory($id)
    {
        $this->delete('id = ' . (int)$id);
    }

    public function getCategoryByProject($projectId){
        $rows = $this->fetchAll("projectId = ".(int)$projectId);
        if($rows->count()){return $rows->toArray();}
        return $rows->count();
    }

}
