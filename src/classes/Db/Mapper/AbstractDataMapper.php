<?php
namespace Db\Mapper;

use Db\MySQLConnection;
use Model\ModelInterface;

abstract class AbstractDataMapper
{
    protected $dbh;
    
    public function __construct()
    {
        $dbConfig = app('db');
        $this->dbh = new MySQLConnection($dbConfig);
    }

    public function create(array $data)
    {
        $object = $this->createInstance();
        if ($data) {
            $this->populate($object, $data);
        }
        return $object;
    }

    public function save(ModelInterface $object)
    {
        if (is_null($object->getId())) {
            $this->insertIntoDb($object);
        } else {
            $this->updateDb($object);
        }
    }

    public function delete(ModelInterface $object)
    {
        $this->deleteFromDb($object);
    }

    

    abstract protected function populate(ModelInterface $object, array $data);

    abstract protected function createInstance();

    abstract protected function insertIntoDb(ModelInterface $object);

    abstract protected function deleteFromDb(ModelInterface $object);
    
    abstract protected function updateDb(ModelInterface $object);

}
