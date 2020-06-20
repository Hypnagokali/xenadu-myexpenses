<?php
namespace Validation;

interface ValidatorInterface
{
    public function prepareData($data);
    public function validate($data, array $rules);
}