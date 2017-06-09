<?php

namespace Tests\Views;

use Incognito\Views\ViewComposerResolver;

class ViewComposerTest
{
    /** @test */
    function it_resolves_a_view_composer_class_method()
    {
        $composer = new ViewComposerResolver('TestComposer@test');
    }
}