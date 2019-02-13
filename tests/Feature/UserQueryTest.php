<?php

namespace Tests\Feature;

use Artisan;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserQueryTest extends TestCase
{
    use RefreshDatabase;

    protected $name;

    protected function setUp()
    {
        parent::setUp();

        $this->name = config('default.tests.user.name');
        $this->email = config('default.tests.user.email');
        $this->password = config('default.tests.user.password');

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);
    }

    /**
     * @return void
     */
    public function testUserQuery()
    {
        $response = $this->query('
            userFind(
                id: 1
            ) {
                name
                email
            }
        ');

        $response->assertJson([
            'data' => [
                'userFind' => [
                    'name' => $this->name,
                    'email' => $this->email,
                ],
            ],
        ]);
    }

    /**
     * @return void
     */
    public function testUserCreate()
    {
        Artisan::call('migrate:fresh');

        $response = $this->mutate('
            userCreate(
                name: "'.$this->name.'"
                email: "'.$this->email.'"
                password: "'.$this->password.'"
            ) {
                name
                email
            }
        ');

        $response->assertJson([
            'data' => [
                'userCreate' => [
                    'name' => $this->name,
                    'email' => $this->email,
                ],
            ],
        ]);
    }
}
