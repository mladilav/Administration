<?php

class Application_Model_DbTable_Changes extends Zend_Db_Table_Abstract
{

    protected $_name = 'changes';
    public function getChanges($id)
    {

        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if(!$row) {
            throw new Exception("Нет записи с id - $id");
        }
        return $row->toArray();
    }

    public function addChanges($data)
    {
        $this->insert($data);
    }

    public  function updateChanges($data)
    {
        $this->update($data, 'id = ' . (int)$data['id']);
    }

    public function deleteChanges($id)
    {
        $this->delete('id = ' . (int)$id);
    }

}
