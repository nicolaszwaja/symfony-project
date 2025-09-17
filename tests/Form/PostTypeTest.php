<?php
/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\Tests\Form;

use App\Form\PostType;
use Symfony\Component\Form\Test\FormIntegrationTestCase;

/**
 * Unit tests for the PostType form.
 */
class PostTypeTest extends FormIntegrationTestCase
{
    /**
     * Test that PostType class can be instantiated.
     *
     * @return void
     */
    public function testPostTypeClass(): void
    {
        $formType = new PostType();
        $this->assertInstanceOf(PostType::class, $formType);
    }

    /**
     * Test that the form type class name is correct.
     *
     * @return void
     */
    public function testFormTypeName(): void
    {
        $formType = new PostType();
        $this->assertEquals('App\Form\PostType', get_class($formType));
    }
}
