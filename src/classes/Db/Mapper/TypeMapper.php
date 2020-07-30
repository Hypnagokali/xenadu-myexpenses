<?php

namespace Db\Mapper;

use Model\ModelInterface;
use Model\Type;

class TypeMapper extends AbstractDataMapper
{
    protected function populate(ModelInterface $object, array $data)
    {
        if (isset($data['id'])) {
            $object->setId($data['id']);
        }
        if (isset($data['name'])) {
            $object->setName($data['name']);
        }
        if (isset($data['description'])) {
            $object->setDescription($data['description']);
        }

        return $object;
    }

    protected function createInstance()
    {
        return new Type();
    }

    public function findById($id)
    {
        $data = $this->dbh->fetchFirst('SELECT * FROM types WHERE id= ? LIMIT 1', [$id]);
        $type = null;
        if ($data !== false) {
            $type = $this->create($data);
        }
        return $type;
    }

    public function findAll()
    {
        $dataArray = $this->dbh->fetchAll('SELECT * FROM types', []);
        $typeList = [];
        foreach ($dataArray as $data) {
            $typeList []= $this->create($data);
        }
        return $typeList;
    }

    public function findByName($name)
    {

    }

    protected function insertIntoDb(ModelInterface $object)
    {

    }

    protected function deleteFromDb(ModelInterface $object)
    {

    }
    
    protected function updateDb(ModelInterface $object)
    {

    }
}
