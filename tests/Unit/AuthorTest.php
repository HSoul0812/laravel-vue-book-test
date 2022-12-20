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
            'birthday' => '2000.1.1',
            'genre' => 'Action',
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'authors' => [
                '*' => ['name', 'birthday', 'genre'],
            ],
        ]);
    }
    public function test_update()
    {
        $response = $this->putJson('/api/authors/1', [
            'name' => 'Sally123',
            'birthday' => '1999.1.1',
            'genre' => 'Horor',
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'authors' => ['name', 'birthday', 'genre'],
        ]);
    }

    public function test_delete()
    {
        $response = $this->deleteJson('/api/authors/1');
        $response->assertStatus(200);
    }
}