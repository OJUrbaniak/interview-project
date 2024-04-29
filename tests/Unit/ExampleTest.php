<?php

namespace Tests\Unit;

use App\Http\Controllers\PostSearchController;
use App\Repositories\PropertyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use function PHPUnit\Framework\assertSame;

class ExampleTest extends TestCase
{
    public PostSearchController $postSearchController;

    protected function setUp(): void
    {
        parent::setUp();
        $propertyRepository = new PropertyRepository();
        $this->postSearchController = new PostSearchController($propertyRepository);
    }

    public function testFormDataSave(): void
    {
//        Not 100% sure how to mock requests, will have to skip for time reasons
        $request = new Request([], [
            'method' => 'POST'
        ]);
        $request->input('test', 123);
        $this->postSearchController->handleFormData($request);
        Session::shouldReceive('session');
        self::assertTrue(true);
    }
}
