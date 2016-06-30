<?php

namespace BB\WPHealthCheck\Validation;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Annotations\AnnotationRegistry;

class ValidatorFactory
{

    public static function createValidator()
    {
        $autoloader = require dirname(dirname(__DIR__)).'/vendor/autoload.php';
        AnnotationRegistry::registerLoader([$autoloader, 'loadClass']);
        $validator = Validation::createValidatorBuilder()
                               ->enableAnnotationMapping()
                               ->getValidator();

        return $validator;
    }
}
