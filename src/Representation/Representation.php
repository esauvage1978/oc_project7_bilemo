<?php

namespace App\Representation;

use Pagerfanta\Pagerfanta;
use JMS\Serializer\Annotation\Type;


class Representation
{

    public $meta;


    public function addMeta($name, $value)
    {
        $this->setMeta($name, $value);
    }

    public function setMeta($name, $value)
    {
        $this->meta[$name] = $value;
    }
}
