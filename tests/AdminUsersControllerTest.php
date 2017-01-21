<?php

use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;

class AdminUsersControllerTest extends TestCase
{
    protected $admin = [
        'email' => 'admin@gmail.com',
        'password' => 'admin',
    ];

    protected $user = [
        'first_name' => 'Luis',
        'last_name' => 'Guette',
        'email' => 'luis@gmail.com',
        'password' => '1234',
        'role' => 'user'
    ];

    protected $id;

    /**
     * Admin create user.
     *
     * @return void
     */
    public function testCreateUser(){
        $token = JWTAuth::attempt($this->admin);

        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $this->post('/admin/users',$this->user, $header)
            ->seeJsonContains(['created' => true]);
    }

    /**
     * Admin show user.
     *
     * @return void
     */
    public function testShowUser(){
        $token = JWTAuth::attempt($this->admin);

        $user = new User();

        $testUser = $user->where('email','luis@gmail.com')->first();

        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $this->get('/admin/users/'.$testUser->id, $header)
            ->seeJsonContains(['id' => $testUser->id]);
    }

    /**
     * Admin update user.
     *
     * @return void
     */
    public function testUpdateUser(){
        $token = JWTAuth::attempt($this->admin);

        $user = new User();

        $testUser = $user->where('email','luis@gmail.com')->first();

        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $this->put('/admin/users/'.$testUser->id, ['first_name' => 'lalala'], $header)
            ->seeJsonContains([
                'first_name' => 'lalala',
                'updated' => true
            ]);
    }

    /**
     * Admin delete user.
     *
     * @return void
     */
    public function testDeleteUser(){
        $token = JWTAuth::attempt($this->admin);

        $user = new User();

        $testUser = $user->where('email','luis@gmail.com')->first();

        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $this->delete('/admin/users/'.$testUser->id, [], $header)
            ->seeJsonContains([
                'deleted' => true
            ]);
    }
}