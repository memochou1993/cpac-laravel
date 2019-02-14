<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserQueryTest extends TestCase
{
    use RefreshDatabase;

    private $id;

    private $name;

    private $email;
    
    private $password;

    protected function setUp()
    {
        parent::setUp();

        $this->id = 1;
        $this->name = config('default.tests.user.name');
        $this->email = config('default.tests.user.email');
        $this->password = config('default.tests.user.password');

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);
    }

    public function testUserFind()
    {
        $response = $this->query('
            userFind(
                id: '.$this->id.'
            ) {
                name
                email
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'userFind' => [
                    'name' => $this->name,
                    'email' => $this->email,
                ],
            ],
        ]);
    }

    public function testUserQuery()
    {
        $response = $this->query('
            userFind(
                id: '.$this->id.'
            ) {
                name
                email
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'userFind' => [
                    'name' => $this->name,
                    'email' => $this->email,
                ],
            ],
        ]);
    }

    public function testUserStore()
    {
        $response = $this->mutate('
            userStore(
                name: "stored'.$this->name.'"
                email: "stored'.$this->email.'"
                password: "stored'.$this->password.'"
            ) {
                name
                email
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'userStore' => [
                    'name' => 'stored'.$this->name,
                    'email' => 'stored'.$this->email,
                ],
            ],
        ]);

        $this->assertEquals(2, User::count());
    }

    public function testUserUpdate()
    {
        $response = $this->mutate('
            userUpdate(
                id: '.$this->id.'
                name: "updated'.$this->name.'"
                email: "updated'.$this->email.'"
                password: "updated'.$this->password.'"
            ) {
                name
                email
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'userUpdate' => [
                    'name' => 'updated'.$this->name,
                    'email' => 'updated'.$this->email,
                ],
            ],
        ]);

        $this->assertEquals(1, User::count());
    }

    public function testUserDestroy()
    {
        $response = $this->mutate('
            userDestroy(
                id: '.$this->id.'
            ) {
                name
                email
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'userDestroy' => [
                    'name' => $this->name,
                    'email' => $this->email,
                ],
            ],
        ]);

        $this->assertEquals(0, User::count());
    }
}
