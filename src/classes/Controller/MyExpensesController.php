<?php

namespace Controller;

use Auth\Auth;
use DateTime;
use Db\Mapper\ExpensesMapper;
use Db\Mapper\TypeMapper;
use Model\Expenses;

class MyExpensesController
{
    private static $instance = null;

    protected function __construct() {}
    protected function __clone() {}

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new MyExpensesController();
        }
        return self::$instance;
    }

    public function testMapper()
    {
        $user = Auth::getUser();
        $uid = $user->getId();
        $now = new DateTime('now');
        $nowString = $now->format('Y-m-d H:i:s');
        $typeMapper = new TypeMapper();
        $type = $typeMapper->findById(1);

        $exp = new Expenses();
        $exp->setUserId($uid);
        $exp->setSum(856.77);
        $exp->setLocation('Amazon');
        $exp->setOccuredAt($nowString);
        $exp->setType($type);

        $myExMapper = new ExpensesMapper();

        $myExMapper->save($exp);

        echo "<pre>";
        print_r($exp);

        exit();
    }
}