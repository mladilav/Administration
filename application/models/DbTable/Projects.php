<?php

class Application_Model_DbTable_Projects extends Zend_Db_Table_Abstract
{

    protected $_name = 'projects';
    public function getProjects($id)
    {

        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if(!$row) {
            throw new Exception("Нет записи с id - $id");
        }
        return $row->toArray();
    }

    public function addProjects($data)
    {
        $this->insert($data);
    }

    public  function updateProjects($data)
    {
        $this->update($data, 'id = ' . (int)$data['id']);
    }

    public function deleteProjects($id)
    {
        $this->delete('id = ' . (int)$id);
    }


    public function getSelect()
    {
        $row = $this->fetchAll();
        if(!$row) {
            throw new Exception("Projects does not exist");
        }
        foreach($row as $array)
        {
            $projectId[] = $array['id'];
            $projectName[] = $array['name'];
        }
        return array_combine($projectId,$projectName);
    }

}
