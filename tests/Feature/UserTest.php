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
        
    public function test_regisztracio_sorrendje() : void {        
        $response = $this->get('/api/register-order/');
        $response->assertStatus(200);
    }
            
    public function test_ritkasagi_szint() : void {        
        $response = $this->get('/api/ritkasagi-szint/');
        $response->assertStatus(200);
    }
/*                 
    public function test_lenyek_csokkeno() : void {        
        $response = $this->get('/api/lenyek-csokkeno/');
        $response->assertStatus(200);
    } */

    // ezekbe még nincs adat: 
/*                     
    public function test_esemenyre_feliratkozasok() : void {        
        $response = $this->get('/api/esemenyre-feliratkozasok/');
        $response->assertStatus(200);
    }
                        
    public function test_kik_iratkoztak_fel() : void {        
        $response = $this->get('/api/kik-iratkoztak-fel/');
        $response->assertStatus(200);
    }
                            
    public function user_feliratkozasai() : void {        
        $response = $this->get('/api/user-feliratkozasai/');
        $response->assertStatus(200);
    } */


}
