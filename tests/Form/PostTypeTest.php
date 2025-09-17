<?php

namespace App\Tests\Form;

use App\Form\PostType;
use Symfony\Component\Form\Test\FormIntegrationTestCase;

class PostTypeTest extends FormIntegrationTestCase
{
    public function testPostTypeClass(): void
    {
        $formType = new PostType();
        $this->assertInstanceOf(PostType::class, $formType);
    }

    public function testFormTypeName(): void
    {
        $formType = new PostType();
        $this->assertEquals('App\Form\PostType', get_class($formType));
    }
}
