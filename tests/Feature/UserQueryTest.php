<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserQueryTest extends TestCase
{
    use RefreshDatabase;

    protected $id;
    protected $name;
    protected $email;
    protected $password;

    protected function setUp()
    {
        parent::setUp();

        $fields = config("default.tests.user");

        foreach ($fields as $key => $value) {
            $this->$key = $value;
        }

        User::create($fields);
    }

    public function testFetchUsers()
    {
        $response = $this->query('
            fetchUsers {
                name
                email
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'fetchUsers' => [
                    [
                        'name' => $this->name,
                        'email' => $this->email,
                    ],
                ],
            ],
        ]);
    }

    public function testFetchUser()
    {
        $response = $this->query('
            fetchUser(
                id: '.$this->id.'
            ) {
                name
                email
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'fetchUser' => [
                    'name' => $this->name,
                    'email' => $this->email,
                ],
            ],
        ]);
    }

    public function testStoreUser()
    {
        $response = $this->mutate('
            storeUser(
                name: "stored-'.$this->name.'"
                email: "stored-'.$this->email.'"
                password: "stored-'.$this->password.'"
            ) {
                name
                email
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'storeUser' => [
                    'name' => 'stored-'.$this->name,
                    'email' => 'stored-'.$this->email,
                ],
            ],
        ]);

        $this->assertEquals(2, User::count());
    }

    public function testUpdateUser()
    {
        $response = $this->mutate('
            updateUser(
                id: '.$this->id.'
                name: "updated-'.$this->name.'"
                email: "updated-'.$this->email.'"
                password: "updated-'.$this->password.'"
            ) {
                name
                email
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'updateUser' => [
                    'name' => 'updated-'.$this->name,
                    'email' => 'updated-'.$this->email,
                ],
            ],
        ]);

        $this->assertEquals(1, User::count());
    }

    public function testDestroyUser()
    {
        $response = $this->mutate('
            destroyUser(
                id: '.$this->id.'
            ) {
                name
                email
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'destroyUser' => [
                    'name' => $this->name,
                    'email' => $this->email,
                ],
            ],
        ]);

        $this->assertEquals(0, User::count());
    }
}
