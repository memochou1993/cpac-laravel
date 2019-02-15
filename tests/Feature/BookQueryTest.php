<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookQueryTest extends TestCase
{
    use RefreshDatabase;

    protected $id;
    protected $title;
    protected $creator;
    protected $description;
    protected $contributor;
    protected $date;
    protected $language;

    protected function setUp()
    {
        parent::setUp();

        $fields = config("default.tests.book");

        foreach ($fields as $key => $value) {
            $this->$key = $value;
        }

        Book::create($fields);
    }

    public function testFetchBooks()
    {
        $response = $this->query('
            fetchBooks {
                title
                creator
                description
                contributor
                date
                language
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'fetchBooks' => [
                    [
                        'title' => $this->title,
                        'creator' => $this->creator,
                        'description' => $this->description,
                        'contributor' => $this->contributor,
                        'date' => $this->date,
                        'language' => $this->language,
                    ],
                ],
            ],
        ]);
    }

    public function testFetchBook()
    {
        $response = $this->query('
            fetchBook(
                id: '.$this->id.'
            ) {
                title
                creator
                description
                contributor
                date
                language
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'fetchBook' => [
                    'title' => $this->title,
                    'creator' => $this->creator,
                    'description' => $this->description,
                    'contributor' => $this->contributor,
                    'date' => $this->date,
                    'language' => $this->language,
                ],
            ],
        ]);
    }

    public function testStoreBook()
    {
        $response = $this->mutate('
            storeBook(
                title: "stored-'.$this->title.'"
                creator: "stored-'.$this->creator.'"
                description: "stored-'.$this->description.'"
                contributor: "stored-'.$this->contributor.'"
                date: '.($this->date + 1).'
                language: "stored-'.$this->language.'"
            ) {
                title
                creator
                description
                contributor
                date
                language
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'storeBook' => [
                    'title' => 'stored-'.$this->title,
                    'creator' => 'stored-'.$this->creator,
                    'description' => 'stored-'.$this->description,
                    'contributor' => 'stored-'.$this->contributor,
                    'date' => ($this->date + 1),
                    'language' => 'stored-'.$this->language,
                ],
            ],
        ]);

        $this->assertEquals(2, Book::count());
    }

    public function testUpdateBook()
    {
        $response = $this->mutate('
            updateBook(
                id: '.$this->id.'
                title: "updated-'.$this->title.'"
                creator: "updated-'.$this->creator.'"
                description: "updated-'.$this->description.'"
                contributor: "updated-'.$this->contributor.'"
                date: '.($this->date + 1).'
                language: "updated-'.$this->language.'"
            ) {
                title
                creator
                description
                contributor
                date
                language
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'updateBook' => [
                    'title' => 'updated-'.$this->title,
                    'creator' => 'updated-'.$this->creator,
                    'description' => 'updated-'.$this->description,
                    'contributor' => 'updated-'.$this->contributor,
                    'date' => ($this->date + 1),
                    'language' => 'updated-'.$this->language,
                ],
            ],
        ]);

        $this->assertEquals(1, Book::count());
    }

    public function testDestroyBook()
    {
        $response = $this->mutate('
            destroyBook(
                id: '.$this->id.'
            ) {
                title
                creator
                description
                contributor
                date
                language
            }
        ');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'destroyBook' => [
                    'title' => $this->title,
                    'creator' => $this->creator,
                    'description' => $this->description,
                    'contributor' => $this->contributor,
                    'date' => $this->date,
                    'language' => $this->language,
                ],
            ],
        ]);

        $this->assertEquals(0, Book::count());
    }
}
