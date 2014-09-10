<?php

class Application_Model_DbTable_Request extends Zend_Db_Table_Abstract
{

    protected $_name = 'request';
    public function getRequest($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if(!$row) {
            throw new Exception("Нет записи с id - $id");
        }
        return $row->toArray();
    }

    public function addRequest($data)
    {
        $this->insert($data);
    }

    public  function updateRequest($data)
    {
        $this->update($data, 'id = ' . (int)$data['id']);
    }

    public function deleteRequest($id)
    {
        $this->delete('id = ' . (int)$id);
    }
}
