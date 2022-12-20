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
    public function test_get()
    {
        $response = $this->getJson('/api/books');
        $response->assertStatus(200);
    }
    public function test_post()
    {
        $response = $this->postJson('/api/books', [
            'name' => 'Sally',
            'year' => 2000,
            'author_id' => '1',
            'libraries' => ['1'],
        ]);
        $response->assertStatus(200)->assertJsonStructure([
            'books' => [
                '*' => ['name', 'year', 'author_id', 'libraries'],
            ],
        ]);
    }

    public function test_update()
    {
        $response = $this->putJson('/api/books/1', [
            'name' => 'Kelly Life',
            'year' => 2002,
            'author_id' => '1',
            'libraries' => ['1'],
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