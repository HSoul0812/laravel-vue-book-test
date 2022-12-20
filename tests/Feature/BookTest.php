<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function getExistingData()
    {
        $authorsData = $this->postJson('/api/authors', [
            'name' => 'Sally',
            'birthday' => '2000.1.1',
            'genre' => 'Action',
        ]);

        $author_id = $authorsData->json()['authors'][0]['id'];

        $librariesData = $this->postJson('/api/libraries', [
            'name' => 'Teixi library',
            'address' => 'Tiexi street Ave 36',
        ]);

        $library_id = $librariesData->json()['libraries'][0]['id'];
        return [$author_id, $library_id];
    }
    public function test_get()
    {
        $response = $this->getJson('/api/books');
        $response->assertStatus(200);
    }
    public function test_post()
    {
        $existData = $this->getExistingData();

        $response = $this->postJson('/api/books', [
            'name' => 'Sally',
            'year' => 2000,
            'author_id' => $existData[0],
            'libraries' => [$existData[1]],
        ]);
        $response->assertStatus(200)->assertJsonStructure([
            'books' => [
                '*' => ['name', 'year', 'author_id', 'libraries'],
            ],
        ]);
        return $response->json()['books'][0]['id'];
    }

    public function test_update()
    {
        $existData = $this->getExistingData();
        $book_id = $this->test_post();

        $response = $this->putJson('/api/books/' . $book_id, [
            'name' => 'Kelly Life',
            'year' => 2002,
            'author_id' => $existData[0],
            'libraries' => [$existData[1]],
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'books' => ['*' => ['name', 'year', 'author_id', 'libraries']],
        ]);
    }

    public function test_delete()
    {
        $response = $this->deleteJson('/api/books/1');
        $response->assertStatus(200);
    }
}