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
        $row = $this->fetchAll("username = '".$data['username']."'");
        if($row->count() > 0){
            return 'User with this username is already registered!';
        }
        $row = $this->fetchAll("email = '".$data['email']."'");
        if($row->count() > 0){
            return 'User with this E-mail is already registered!';
        }
        $this->insert($data);
        return 'Registration was successful!';
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
