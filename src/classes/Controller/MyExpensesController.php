<?php

namespace Controller;

use Auth\Auth;
use DateTime;
use DateTimeImmutable;
use Db\Mapper\ExpensesMapper;
use Db\Mapper\TypeMapper;
use Http\Redirect;
use Model\Expenses;
use Model\SpecialTypes\ExpensesStrings;
use Validation\ExpensesValidator;
use View\View;

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


    public function displayExpenses()
    {
        if (!Auth::auth()) {
            $_SESSION['flash']['login'] = 'Erst einloggen, dann weiter';
            Redirect::to('/login');
        }

        return View::display('my_expenses');
    }

    public function myExpensesData()
    {
        $currentDateTime = new DateTimeImmutable('first day of this month');
        $nexMonth = new DateTimeImmutable('first day of +1 month');
        $user = Auth::getUser();
        $userId = (int) $user->getId();

        if (!$user) {
            $_SESSION['flash']['login'] = 'Bitte einloggen';
            Redirect::to('/login');
        }

        $expensesMapper = new ExpensesMapper();
        $expensesList = $expensesMapper->findAllByDateIntervall($currentDateTime, $nexMonth, $userId);
        return $expensesList;
    }

    public function addExpensesPost()
    {
        $validator = new ExpensesValidator();

        $sumFloat = $validator->prepareData($_POST['sum']);
        $sum_cents = round($sumFloat * 100);
        $location = $validator->prepareData($_POST['location']);
        $typeData = $validator->prepareData($_POST['type']);
        $date = $validator->prepareData($_POST['occurred']);

        
        
        /* Validation */
        $sumErrors = $validator->validate($sum_cents, [
            'notEmpty' => true,
            'min' => 1,
        ]);

        if ($sumErrors->hasErrorMessages()) {
            $_SESSION['flash']['sum'] = 'Der Betrag ist zu klein. Nur Einkäufe über 1€';
            Redirect::to('/expenses');
        }

        $locationErrors = $validator->validate($location, [
            'notEmpty' => true,
            'max' => 30,
        ]);

        if ($locationErrors->hasErrorMessages()) {
            $_SESSION['flash']['location'] = 'Angabe darf nicht leer oder länger als 30 Zeichen sein';
            Redirect::to('/expenses');
        }
        
        $typeErrors = $validator->validate($typeData, [
            'notEmpty' => true,
        ]);
        if ($typeErrors->hasErrorMessages()) {
            $_SESSION['flash']['type'] = 'Der Typ des Einkaufs wurde nicht richtig angegeben';
            Redirect::to('/expenses');
        }

        $dateErrors = $validator->validate($date, [
            'notEmpty' => true,
            'dateformat' => true,
        ]);
        if ($dateErrors->hasErrorMessages()) {
            $_SESSION['flash']['date'] = 'Bitte ein gültiges Datum angeben';
            Redirect::to('/expenses');
        }

        $user = Auth::getUser();
        $userId = $user->getId();
        $expenses = new Expenses();
    
        $expensesMapper = new ExpensesMapper();
        $typeMapper = new TypeMapper();

        // validate Typedata
        $type = $typeMapper->findById($typeData);
        if ($type === null) {
            $_SESSION['flash']['type'] = 'Der Einkaufstyp wurde nicht gefunden';
            Redirect::to('/expenses');
        }

        $expenses->setUserId($userId);
        $expenses->setSum($sum_cents);
        $expenses->setLocation($location);
        $expenses->setOccurredAt($date);
        $expenses->setType($type);

        $expensesMapper->save($expenses);
        
        $_SESSION['flash']['success'] = 'Gespeichert &#x1F642;';
        Redirect::to('/expenses');
    }

    public function getAllExpenses()
    {
        $user = Auth::getUser();
        $uid = $user->getId();
        $expMapper = new ExpensesMapper();
        $allExpenses = $expMapper->findAllByUserId($uid);
        echo "<pre>";
        print_r($allExpenses);
        exit();
    }

    public function testMapper()
    {
        $user = Auth::getUser();
        $uid = $user->getId();
        $now = new DateTime('now');
        $nowString = $now->format('Y-m-d H:i:s');
        $typeMapper = new TypeMapper();
        $type = $typeMapper->findById(2);

        $exp = new Expenses();
        $exp->setUserId($uid);
        $exp->setSum(4899);
        $exp->setLocation('Amazon');
        $exp->setOccurredAt($nowString);
        $exp->setType($type);

        $myExMapper = new ExpensesMapper();

        $myExMapper->save($exp);

        echo "<pre>";
        print_r($exp);

        exit();
    }
}