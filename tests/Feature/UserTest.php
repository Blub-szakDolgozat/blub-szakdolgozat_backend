<?php

namespace Tests\Feature;

use App\Models\Esemeny;
use App\Models\Feliratkozas;
use App\Models\User;
use App\Models\Video;
use App\Models\Vizilenyek;
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

    public function test_users_auth(): void
    {
        //$this->withoutExceptionHandling(); 
        // create rögzíti az adatbázisban a felh-t
        $admin = User::factory()->make([
            'role' => 0,
        ]);
        $response = $this->actingAs($admin)->get('/api/users/' . $admin->id);
        $response->assertStatus(200);
    }


    // ----------------------------------------------------------------------------------------------------------------
    // Cikkek:
    // index:
    public function test_cikkek(): void
    {
        $response = $this->get('/api/cikkek/');
        $response->assertStatus(200);
    }


    // ----------------------------------------------------------------------------------------------------------------
    // Események:
    //index: 
    public function test_esemenyek(): void
    {
        $response = $this->get('/api/esemenyek/');
        $response->assertStatus(200);
    }

    // Adott eseményre való feliratkozások számának lekérdezése
    public function test_esemenyre_feliratkozasok(): void {
        $user = User::factory()->create([
            'jogosultsagi_szint' => 'admin' // ✅ helyes mezőnév
        ]);
        
        $this->actingAs($user, 'sanctum');
    
        $esemeny = Esemeny::factory()->create();
        $response = $this->get('/api/esemenyre-feliratkozasok/'.$esemeny->esemeny_id);
        $response->assertStatus(200);
    }
    
    
        
    // Adott eseményre kik iratkoztak fel
    public function test_kik_iratkoztak_fel() : void {
        $user = User::factory()->create([
            'jogosultsagi_szint' => 'admin'
        ]);
        $this->actingAs($user, 'sanctum');
    
        $esemeny = Esemeny::factory()->create();
        $response = $this->get('/api/kik-iratkoztak-fel/'.$esemeny->esemeny_id);
        $response->assertStatus(200);
    }
    

    // ----------------------------------------------------------------------------------------------------------------
    //Videók
    //index:
    public function test_video(): void
    {
        $response = $this->get('/api/videok/');
        $response->assertStatus(200);
    }

    // Videók hossza
    public function test_videok_hossza(): void
    {
        $user = User::factory()->create([
            'jogosultsagi_szint' => 'admin', // admin jogosultság hozzáadása
        ]);
    
        $this->actingAs($user, 'sanctum'); // autentikáció
        $response = $this->get('/api/videok-hossza/');
        $response->assertStatus(200);
    }
    
    public function test_video_torol(): void
    {
        $video = Video::factory()->create();
        $user = User::factory()->create([
            'jogosultsagi_szint' => 'admin', // admin jogosultság hozzáadása
        ]);
    
        $this->actingAs($user, 'sanctum'); // autentikáció
        $response = $this->delete('/api/video-torol/'.$video->video_id);
        $response->assertStatus(200);
    }
    

    // ----------------------------------------------------------------------------------------------------------------
    //User
    //index:
    public function test_users(): void
    {
        $response = $this->get('/api/users/');
        $response->assertStatus(200);
    }


    //Felhasználók regisztrálási sorrendje:
    public function test_regisztracio_sorrendje(): void
{
    $user = User::factory()->create([
        'jogosultsagi_szint' => 'admin', // vagy a megfelelő jogosultság
    ]);

    // Autentikálás, hogy a kérés működjön
    $this->actingAs($user, 'sanctum'); // 'sanctum' az alapértelmezett autentikáció, ha ezt használod

    $response = $this->get('/api/register-order/');
    $response->assertStatus(200);
}


    // Adott felhasználó akváriumába bekerülő vízi lények időrendi sorrendben
    public function test_lenyek_csokkeno(): void
    {
        $user = User::factory()->create([
            'jogosultsagi_szint' => 'admin', // admin jogosultság hozzáadása
        ]);
    
        $this->actingAs($user, 'sanctum'); // autentikáció
        $emberke = User::factory()->create(); // az adott felhasználó
        $response = $this->get('/api/lenyek-csokkeno/'.$emberke->azonosito);
        $response->assertStatus(200);
    }
    

    //Adott felhasználó milyen eseményekre iratkozott fel
    public function user_feliratkozasai() : void { 
        $emberke=User::factory()->create();
        //$esemeny=Esemeny::factory()->create();
        //$feliratkozas=new Feliratkozas();
        //$feliratkozas->felhasznalo=$emberke->azonosito;
        //$feliratkozas->esemeny=$esemeny->esemeny_id;
        //$feliratkozas->save();
        $response = $this->get('/api/user-feliratkozasai/'.$emberke->azonosito);
        $response->assertStatus(200);
    } 

    // ----------------------------------------------------------------------------------------------------------------
    // Vízi lények
    // index:
    
    public function test_get_vizilenyek(): void
    {
        $response = $this->get('/api/vizilenyek/');
        $response->assertStatus(200);
    }


    //Vízi lények ritkasági sorrendben:
    public function test_ritkasagi_szint(): void
    {
        $user = User::factory()->create([
            'jogosultsagi_szint' => 'admin', // admin jogosultság hozzáadása
        ]);
    
        $this->actingAs($user, 'sanctum'); // autentikáció
        $response = $this->get('/api/ritkasagi-szint/');
        $response->assertStatus(200);
    }
    

    // Vízi lény törlése id alapján:
    public function test_delete_vizilenyek(): void
    {
        $user = User::factory()->create([
            'jogosultsagi_szint' => 'admin', // admin jogosultság hozzáadása
        ]);
    
        $this->actingAs($user, 'sanctum'); // autentikáció
        $vizi_leny = Vizilenyek::factory()->create(); // teszt adat
        $response = $this->delete('/api/vizilenyek-torol/'.$vizi_leny->vizi_leny_id);
        $response->assertStatus(200);
    }
    

}
