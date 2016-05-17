<?php

class SerializerTest extends Illuminate\Foundation\Testing\TestCase
{
    public function setUp()
    {
        parent::setUp();

        // Register some fake auth policies and objects?
        // I have no idea how to write tests for this.
    }

    public function createApplication()
    {
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';

        //$app->register('Path\To\Your\PackageServiceProvider');

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        return $app;
    }


}
