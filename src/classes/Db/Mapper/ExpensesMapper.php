<?php

namespace Db\Mapper;

use Model\ModelInterface;
use Model\Expenses;
use Db\Mapper\TypeMapper;
use Db\MySQLConnection;
use DateTime;
use DateTimeImmutable;

class ExpensesMapper extends AbstractDataMapper
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function populate(ModelInterface $object, array $data)
    {
        // Ich mache es so, weil keine Konvertierung ModelInterface -> Expenses möglich
        // Vielleicht finde ich eine andere Lösung
        $this->populateExpenses($object, $data);
    }

    private function populateExpenses(Expenses $object, array $data)
    {
        if (isset($data['id'])) {
            $object->setId($data['id']);
        }
        if (isset($data['sum'])) {
            $object->setSum($data['sum']);
        }
        if (isset($data['user_id'])) {
            $object->setUserId($data['user_id']);
        }
        if (isset($data['location'])) {
            $object->setLocation($data['location']);
        }
        if (isset($data['type_id'])) {
            $typeMapper = new TypeMapper();
            $type = $typeMapper->findById($data['type_id']);
            $object->setType($type);
        }
        if (isset($data['occurred_at'])) {
            $object->setOccurredAt($data['occurred_at']);
        }
        return $object;

    }

    protected function createInstance()
    {
        return new Expenses();
    }

    public function findById($id)
    {
        $data = $this->dbh->fetchFirst('SELECT * FROM expenses WHERE id= ? LIMIT 1', [$id]);
        $expenses = null;
        if ($data !== null) {
            $expenses = $this->create($data);
        }
        return $expenses;
    }

    public function findAllByUserId(int $user_id) : array
    {
        $expensesObjects = [];
        $usersExpenses = $this->dbh->fetchAll('SELECT * FROM expenses WHERE user_id = ?', [$user_id]);
        if ($usersExpenses !== null) {
            foreach ($usersExpenses as $exp) {
                $expensesObjects []= $this->create($exp);
            }
        }
        return $expensesObjects;
    }

    public function findAllByDateIntervall(DateTimeImmutable $start, DateTimeImmutable $end, int $user_id) : array
    {
        $startString = $start->format('Y-m-d H:i:s');
        $endString = $end->format('Y-m-d H:i:s');
        $data = [
            $endString,
            $startString,
            $user_id
        ];
        $expensesList = [];
        $expensesData = $this->dbh->fetchAll(
            "SELECT * FROM expenses
                WHERE occurred_at < ?
                AND occurred_at >= ?
                AND user_id = ?
                ORDER BY
                occurred_at
                DESC",
            $data
        );
        foreach ($expensesData as $expenses) {
            $expensesList []= $this->create($expenses);
        }
        return $expensesList;
    }

    protected function insertIntoDb(ModelInterface $object)
    {
        // Ich mache es so, weil keine Konvertierung ModelInterface -> Expenses möglich
        // Vielleicht finde ich eine andere Lösung
        $this->insertExpenses($object);
    }

    private function insertExpenses(Expenses $object)
    {
        $query = "INSERT INTO expenses (user_id, sum, type_id, location, occurred_at) VALUES (?, ?, ?, ?, ?)";
        $values = [
            $object->getUserId(),
            $object->getSum(),
            $object->getType()->getId(),
            $object->getLocation(),
            $object->getOccurredAt(),
        ];
        $result = $this->dbh->query($query, $values);
        echo $object->setId($this->dbh->getLastInsertedId());
    }
    
    protected function updateDb(ModelInterface $object)
    {
        $this->updateExpenses($object);
    }

    private function updateExpenses(Expenses $object)
    {
        $query = "UPDATE expenses SET (user_id, sum, type_id, location, occurred_at) VALUES (?, ?, ?, ?, ?)";
        $values = [
            $object->getUserId(),
            $object->getSum(),
            $object->getType()->getId(),
            $object->getLocation(),
            $object->getOccurredAt()
        ];
        $this->dbh->query($query, $values);
    }

    protected function deleteFromDb(ModelInterface $object)
    {

    }
}
