<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get()
    {
        $response = $this->getJson('/api/authors');

        $response->assertStatus(200);
    }

    public function test_post()
    {
        $response = $this->postJson('/api/authors', [
            'name' => 'Sally',
            'birthday' => '2000-01-01',
            'genre' => 'Action',
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'authors' => [
                '*' => ['name', 'birthday', 'genre'],
            ],
        ]);
        $result = (array) $response->json();
        if ($result && count($result['authors']) > 0) {
            return $result['authors'][0]['id'];
        }
    }

    public function test_update()
    {
        $author_id = $this->test_post();
        $response = $this->putJson('/api/authors/' . $author_id, [
            'name' => 'Sally123',
            'birthday' => '1999-01-01',
            'genre' => 'Horor',
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'authors' => ['name', 'birthday', 'genre'],
        ]);

        $response->assertSeeTextInOrder(['Sally123', '1999-01-01', 'Horor']);
    }

    public function test_delete()
    {
        $response = $this->deleteJson('/api/authors/1');
        $response->assertStatus(200);
    }
}