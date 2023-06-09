<?php

namespace App\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class Validator
{
    public function __construct(protected ValidatorInterface $validator)
    {
        $this->validate();
    }

    public function validate()
    {
        $errors = $this->validator->validate($this);

        $messages = ['message' => 'validation_failed', 'errors' => []];

        /* @var \Symfony\Component\Validator\ConstraintViolation */
        foreach ($errors as $message) {
            $messages['errors'][] = [
                'property' => $message->getPropertyPath(),
                'value' => $message->getInvalidValue(),
                'message' => $message->getMessage(),
            ];
        }

        return $messages['errors'];
    }

    public function populate(array $source): void
    {
        foreach ($source as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }
}
