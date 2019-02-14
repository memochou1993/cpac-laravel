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

        $fields = config("default.tests.user");

        foreach ($fields as $key => $value) {
            $this->$key = $value;
        }

        User::create($fields);
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
        $flag = __FUNCTION__;

        $response = $this->mutate('
            userStore(
                name: "'.$flag.$this->name.'"
                email: "'.$flag.$this->email.'"
                password: "'.$flag.$this->password.'"
            ) {
                name
                email
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'userStore' => [
                    'name' => $flag.$this->name,
                    'email' => $flag.$this->email,
                ],
            ],
        ]);

        $this->assertEquals(2, User::count());
    }

    public function testUserUpdate()
    {
        $flag = __FUNCTION__;

        $response = $this->mutate('
            userUpdate(
                id: '.$this->id.'
                name: "'.$flag.$this->name.'"
                email: "'.$flag.$this->email.'"
                password: "'.$flag.$this->password.'"
            ) {
                name
                email
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'userUpdate' => [
                    'name' => $flag.$this->name,
                    'email' => $flag.$this->email,
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
