<?php

namespace Knuckles\Camel\Extraction;


use Knuckles\Camel\BaseDTO;

class Parameter extends BaseDTO
{
    public string $name;
    public ?string $description = null;
    public bool $required = false;
    public mixed $example = null;
    public string $type = 'string';
    public array $enumValues = [];
<<<<<<< HEAD
=======
    public bool $exampleWasSpecified = false;
>>>>>>> 06408f47f14cbeb88ea760bb11bed2d42158fc64

    public function __construct(array $parameters = [])
    {
        unset($parameters['setter']);
        parent::__construct($parameters);
    }
}
