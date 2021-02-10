<?php


namespace Tests\Unit;

use App\Http\Controllers\HighscoreController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Tests\TestCase;

class HighScoreTest extends TestCase
{

    public function testHighScoreApi_Index_Status()
    {
        $response = $this->get('/api/highscores/1');
        $response->assertStatus(201);
    }

    public function testHighScoreApi_getById_Status_notLoggedIn()
    {
        $response = $this->get('/api/highscore/1');
        $response->assertStatus(500);
    }

    public function testHighScore_getById_Status_loggedIn()
    {
        $this->registerTestUser();
        $token = $this->logInGetTokenForTestCase();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('get', 'api/highscore/1', [
                'email' => 'sandybeach294@yahoo.com',
            ]);

        $response->assertStatus(200);
    }

    public function testHighScore_store_status_loggedIn()
    {
        $this->registerTestUser();
        $token = $this->logInGetTokenForTestCase();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('post', 'api/highscores', [
                'score' => '1',
                'map' => '1',
            ]);
        $response->assertStatus(201);
    }



    private function registerTestUser(){
        $this->json('post', 'api/registration', [
            'name' => 'HighScoreTestUser',
            'email' => 'HighScoreTestUser@email.com',
            'password' => 'HighScoreTestUser',
            'confirm_password' => 'HighScoreTestUser'
        ]);

    }

    private function logInGetTokenForTestCase(){
        $loggedIn = $this->json('post', 'api/login', [
            'email' => 'HighScoreTestUser@email.com',
            'password'=>'HighScoreTestUser'
        ]);

        return $loggedIn["token"];
    }

}
