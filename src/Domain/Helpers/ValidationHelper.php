<?php

namespace PhpLab\Core\Domain\Helpers;

use Illuminate\Support\Collection;
use PhpLab\Core\Domain\Entities\ValidateErrorEntity;
use PhpLab\Core\Domain\Exceptions\UnprocessibleEntityException;
use PhpLab\Core\Domain\Interfaces\Entity\ValidateEntityInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;

class ValidationHelper
{

    public static function validateEntity(ValidateEntityInterface $entity): void
    {
        $rules = $entity->validationRules();
        $errorCollection = self::validate($rules, $entity);
        if ($errorCollection->count() > 0) {
            $exception = new UnprocessibleEntityException;
            $exception->setErrorCollection($errorCollection);
            throw $exception;
        }
    }

    /**
     * @return array | Collection | ValidateErrorEntity[]
     */
    public static function validate($rules, $data): Collection
    {
        $violations = [];
        if ( ! empty($rules)) {
            $validator = Validation::createValidator();
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
            foreach ($rules as $name => $rule) {
                $value = $propertyAccessor->getValue($data, $name);
                $vol = $validator->validate($value, $rules[$name]);
                if ($vol->count()) {
                    $violations[$name] = $vol;
                }
            }
        }
        return self::prepareUnprocessible($violations);
    }

    /**
     * @param   array | ConstraintViolationList[] $violations
     * @return  array | Collection | ValidateErrorEntity[]
     */
    private static function prepareUnprocessible(array $violations): Collection
    {
        $collection = new Collection;
        foreach ($violations as $name => $violationList) {
            foreach ($violationList as $violation) {
                $violation->getCode();
                $entity = new ValidateErrorEntity;
                $entity->setField($name);
                $entity->setMessage($violation->getMessage());
                $entity->setViolation($violation);
                $collection->add($entity);
            }
        }
        return $collection;
    }

}