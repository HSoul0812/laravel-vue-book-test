<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LibraryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get()
    {
        $response = $this->getJson('/api/libraries');

        $response->assertStatus(200);
    }

    public function test_post()
    {
        $response = $this->postJson('/api/libraries', [
            'name' => 'Teixi library',
            'address' => 'Tiexi street Ave 36',
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'libraries' => [
                '*' => ['name', 'address'],
            ],
        ]);
        $result = (array) $response->json();
        if ($result && count($result['libraries']) > 0) {
            return $result['libraries'][0]['id'];
        }
        return null;
    }

    public function test_update()
    {
        $library_id = $this->test_post();
        $response = $this->putJson('/api/libraries/' . $library_id, [
            'name' => 'HuangGuo library',
            'address' => 'HuangGuo street Ave 40',
        ]);
        $response->assertStatus(200)->assertJsonStructure([
            'libraries' => ['name', 'address'],
        ]);

        $response->assertSeeTextInOrder([
            'HuangGuo library',
            'HuangGuo street Ave 40',
        ]);
    }

    public function test_delete()
    {
        $response = $this->deleteJson('/api/libraries/1');
        $response->assertStatus(200);
    }
}