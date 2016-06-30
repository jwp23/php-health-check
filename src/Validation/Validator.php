<?php

namespace BB\WPHealthCheck\Validation;

class Validator
{
    public static function validate($object)
    {
        $validator = ValidatorFactory::createValidator();
        $errors = $validator->validate($object);
        ValidatorErrorHandler::handleErrors($errors);
    }
}
