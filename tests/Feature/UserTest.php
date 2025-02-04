<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_users_auth() : void {
        //$this->withoutExceptionHandling(); 
        // create rögzíti az adatbázisban a felh-t
        $admin = User::factory()->make([
            'role' => 0,
        ]);
        $response = $this->actingAs($admin)->get('/api/users/'.$admin->id);
        $response->assertStatus(200);
    }

    public function test_esemenyek() : void {
        $response = $this->get('/api/esemenyek/');
        $response->assertStatus(200);
    }
    
    public function test_cikkek() : void {
        $response = $this->get('/api/cikkek/');
        $response->assertStatus(200);
    }
    
    public function test_videok_hossza() : void {        
        $response = $this->get('/api/videok-hossza/');
        $response->assertStatus(200);
    }
    public function test_video() : void {     
        $response = $this->get('/api/videok/');
        $response->assertStatus(200);
    }
    public function test_video_delete() : void {     
        $response = $this->delete('/api/videok-torol/{video_id}');
        $response->assertStatus(200);
    }
    public function test_video_show() : void {     
        $response = $this->delete('/api/video-show/{video_id}');
        $response->assertStatus(200);
    }
    public function test_video_put() : void {     
        $response = $this->delete('/api/videok/{video_id}');
        $response->assertStatus(200);
    }
    public function test_get_vizilenyek() : void {
        $response = $this->get('/api/vizilenyek/');
       $response->assertStatus(200);
   }

public function test_update_vizilenyek() : void {
$response = $this->put('/api/vizilenyek/1', [
   'esemeny_neve' => 'Frissített Esemény'
]);
$response->assertStatus(200); // Ha sikeres frissítés, akkor 200-at várunk
}
public function test_delete_vizilenyek() : void {
$response = $this->delete('/api/vizilenyek-torol/1');
$response->assertStatus(200); // Ha sikeres törlés, akkor 200-at várunk
}

}
