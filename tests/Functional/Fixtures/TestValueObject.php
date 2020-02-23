<?php


namespace Tests\Functional\Fixtures;
use Symfony\Component\Validator\Constraints as Assert;

class TestValueObject
{
    /**
     * @Assert\NotBlank()
     */
    public $test;
}