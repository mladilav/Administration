<?php

class Application_Model_DbTable_Errors extends Zend_Db_Table_Abstract
{

    protected $_name = 'errors';
    public function getErrors($id)
    {
        //fsdf
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if(!$row) {
            throw new Exception("Нет записи с id - $id");
        }
        return $row->toArray();
    }

    public function addErrors($data)
    {
        $this->insert($data);
    }

    public  function updateErrors($data)
    {
        $this->update($data, 'id = ' . (int)$data['id']);
    }

    public function deleteErrors($id)
    {
        $this->delete('id = ' . (int)$id);
    }
}
