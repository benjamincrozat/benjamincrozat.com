<?php

namespace Tests\Feature\App\Support;

use Tests\TestCase;
use App\Support\TreeGenerator;

class TreeGeneratorTest extends TestCase
{
    public function test_it_works() : void
    {
        $tree = TreeGenerator::generate(<<<HTML
<h1 id="foo"><a href="#"><strong>Foo</strong></a></h1>
<h2>Bar</h2>
<p>Lorem ipsum dolor sit amet.</p>
<h3 id="baz"><code>Baz</code></h3>
HTML);

        $this->assertEquals([
            [
                'id' => 'foo',
                'title' => 'Foo',
                'level' => 1,
            ],
            [
                'id' => '',
                'title' => 'Bar',
                'level' => 2,
            ],
            [
                'id' => 'baz',
                'title' => 'Baz',
                'level' => 3,
            ],
        ], $tree);
    }
}