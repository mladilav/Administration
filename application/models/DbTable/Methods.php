<?php

class Application_Model_DbTable_Methods extends Zend_Db_Table_Abstract
{

    protected $_name = 'methods';
    public function getMethods($id)
    {

        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if(!$row) {
            throw new Exception("Нет записи с id - $id");
        }
        return $row->toArray();
    }

    public function addMethods($data)
    {
        $this->insert($data);
    }

    public  function updateMethods($data)
    {
        $this->update($data, 'id = ' . (int)$data['id']);
    }

    public function deleteMethods($id)
    {
        $this->delete('id = ' . (int)$id);
    }
}
