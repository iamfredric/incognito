<?php

namespace Tests\Request;

use Incognito\Exceptions\ValidationException;
use Incognito\Requests\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /** @test */
    function it_fetches_a_post_request()
    {
        $_POST['test'] = 'testvalue';

        $request = new Request();

        $this->assertEquals('testvalue', $request->get('test'));
    }

    /** @test */
    function it_fetches_a_get_request()
    {
        $_GET['gettest'] = 'gettestvalue';

        $request = new Request();

        $this->assertEquals('gettestvalue', $request->get('gettest'));
    }

    /** @test */
    function it_fetches_custom_values()
    {
        $request = new Request();

        $request->setBody([
            'custom' => 'customvalue'
        ]);

        $this->assertEquals('customvalue', $request->get('custom'));
    }

    /** @test */
    function it_validates_a_request()
    {
        $localeFile = get_stylesheet_directory() . 'config/locale.php';

        file_put_contents($localeFile, '<?php return ["validations" => ["required" => "This is required"]]; ');

        $request = new \TestRequest();

        $response = $request->validate()->response();
        $this->assertEquals([
            'status' => 422,
            'message' => 'Validation failed',
            'body' => [
                'test' => 'This is required'
            ]
        ], $response);

        unlink($localeFile);
    }

    /** @test */
    function it_validates_a_request_with_a_happy_outcome()
    {
        $localeFile = get_stylesheet_directory() . 'config/locale.php';

        file_put_contents($localeFile, '<?php return ["validations" => ["required" => "This is required"]]; ');

        $request = new Request();

        $response = $request->validate()->response();
        $this->assertEquals([
            'status' => 200,
            'message' => 'ok',
            'body' => null
        ], $response);

        unlink($localeFile);
    }
}