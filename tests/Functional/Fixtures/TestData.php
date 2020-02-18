<?php


namespace Tests\Functional\Fixtures;
use Symfony\Component\Validator\Constraints as Assert;

class TestData
{
    /**
     * @Assert\NotBlank()
     */
    public $test;
}