<?php


namespace Tests\Unit;


use Tests\TestCase;

class HighScoreTest extends TestCase
{

    private $token = null;
    private $registered = false;
    private $loggedIn = false;

    public function testHighScoreApi_index_status()
    {
        $response = $this->get('/api/highscores/1');
        $response->assertStatus(201);
    }



    public function testHighScoreApi_getById_status_notLoggedIn()
    {
        if ($this->loggedIn) $this->logout();

        $response = $this->get('/api/highscore/1');
        $response->assertStatus(500);
    }

    public function testHighScore_store_status_notLoggedIn()
    {
        if ($this->loggedIn) $this->logout();
        $testToken = $this->token;
        $response = $this->withHeader('Authorization', 'Bearer ' . $testToken)
            ->json('post', 'api/highscores', [
                'score' => '1',
                'map' => '1',
            ]);
        $response->assertStatus(401);
    }

    public function testHighScore_getById_status_loggedIn()
    {
        if (!$this->registered) $this->registerTestUser();

        $testToken = ($this->token) ? $this->token : $this->logInGetTokenForTestCase();
        $response = $this->withHeader('Authorization', 'Bearer ' . $testToken)
            ->json('get', 'api/highscore/1', [
                'email' => 'sandybeach294@yahoo.com',
            ]);
        $response->assertStatus(200);
    }

    public function testHighScore_store_status_loggedIn()
    {
        if (!$this->registered) $this->registerTestUser();
        $testToken = ($this->token) ? $this->token : $this->logInGetTokenForTestCase();
        $response = $this->withHeader('Authorization', 'Bearer ' . $testToken)
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

        $this->registered = true;

    }

    private function logInGetTokenForTestCase(){
        $loggedIn = $this->json('post', 'api/login', [
            'email' => 'HighScoreTestUser@email.com',
            'password'=>'HighScoreTestUser'
        ]);

        return $loggedIn["token"];
    }

    private function logout(){
        $this->withHeader('Authorization', 'Bearer ' . $this->token);
        $this->json('delete', 'api/logout', [
            'email' => 'HighScoreTestUser@email.com',
            'password'=>'HighScoreTestUser'
        ]);
        $this->token = null;
    }

}
