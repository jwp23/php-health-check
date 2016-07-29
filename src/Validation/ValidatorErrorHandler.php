<?php

namespace BB\WPHealthCheck\Validation;

use InvalidArgumentException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidatorErrorHandler
{
    public static function handleErrors(ConstraintViolationListInterface $violationList)
    {
        foreach ($violationList as $error) {
            throw new InvalidArgumentException(
                get_class($error->getRoot()) . '.' . $error->getPropertyPath() . ': ' . $error->getMessage()
            );
        }
    }
}
