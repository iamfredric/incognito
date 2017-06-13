<?php

namespace Tests\Request;

use Incognito\Requests\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    protected $validator;

    public function __construct()
    {
        parent::__construct();
        $this->validator = new Validator();
    }

    /** @test */
    function it_validates_an_email_address()
    {
        $this->assertFalse($this->validator->validateEmail('test'));
        $this->assertTrue($this->validator->validateEmail('test@example.com'));
    }

    /** @test */
    function it_validates_a_required_field()
    {
        $this->assertFalse($this->validator->validateRequired(''));
        $this->assertTrue($this->validator->validateRequired('exists'));
    }

    /** @test */
    function it_validates_an_array()
    {
        $this->assertFalse($this->validator->validateArray('string'));
        $this->assertTrue($this->validator->validateArray(['array']));
    }

    /** @test */
    function it_resolves_validation_rules_base_on_string()
    {
        $localeFile = get_stylesheet_directory() . 'config/locale.php';

        file_put_contents($localeFile, '<?php return ["validations" => ["email" => "This is not an email"]]; ');

        $this->validator->validate('key', 'stringtest.com', 'required|email');

        $this->assertEquals(['key' => 'This is not an email'], $this->validator->errors());
        $this->assertEquals('This is not an email', $this->validator->error('key'));
        unlink($localeFile);
    }
}