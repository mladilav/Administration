<?php

class Application_Model_DbTable_Methoderror extends Zend_Db_Table_Abstract
{

    protected $_name = 'methoderrors';
    public function getMethoderror($id)
    {

        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if(!$row) {
            throw new Exception("Нет записи с id - $id");
        }
        return $row->toArray();
    }

    public function addMethoderror($data)
    {
        $this->insert($data);
    }

    public  function updateMethoderror($data)
    {
        $this->update($data, 'id = ' . (int)$data['id']);
    }

    public function deleteMethoderror($id)
    {
        $this->delete('id = ' . (int)$id);
    }
}
