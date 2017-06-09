<?php

namespace Tests\Views;

use Incognito\ViewServiceContainer;

class ViewServiceContainerTest
{
    /** @test */
    function it_does_something()
    {
        $views = new ViewServiceContainer(
            theme_path('resources/views'),
            uploads_path('.cache')
        );
    }
}