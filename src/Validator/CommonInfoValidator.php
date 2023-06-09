<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;

class CommonInfoValidator extends Validator
{
    #[Type('string')]
    #[Regex('/^(\d{14})|([A-Z]{2}\d{9}[A-Z]{2}|(420\d{9}(9[2345])?)?\d{20}|(420\d{5})?(9[12345])?(\d{24}|\d{20})|82\d{8})$/')]
    protected $mailId;

    #[Type('integer')]
    #[Choice([0, 4, 8])]
    protected $mailRank;

    #[Type('string')]
    #[Choice(['REGULAR', 'REGISTERED'])]
    #[NotBlank()]
    #[NotNull()]
    protected $type;

    #[Type('string')]
    protected $templateId;

    #[Type('string')]
    protected $orderFormNumber;

    #[Type('integer')]
    #[Choice([0, 1024, 16384, 17408])]
    protected $postMark;
}
