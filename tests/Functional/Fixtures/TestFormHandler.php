<?php


namespace Tests\Functional\Fixtures;


use Ardenexal\FormHandler\AbstractFormHandler;

class TestFormHandler extends AbstractFormHandler
{
    public function getFormType(): string
    {
        return TestType::class;
    }
}