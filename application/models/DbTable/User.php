<?php

class Application_Model_DbTable_User extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';
    public function getUser($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if(!$row) {
            throw new Exception("Нет записи с id - $id");
        }
        return $row->toArray();
    }

    public function addUser($data)
    {

        $this->insert($data);
    }

    public  function updateUser($data)
    {
        $this->update($data, 'id = ' . (int)$data['id']);
    }

    public function deleteUser($id)
    {
        $this->delete('id = ' . (int)$id);
    }
}
