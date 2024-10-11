<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;

use App\Models\User;

class PasswordAuth extends Controller
{
    //
    //Helper functions
    private static function generateSalt() {
        // scrapped for better implementation
        // $part1 = bin2hex(random_bytes(4));
        // $part2 = bin2hex(random_bytes(2));
        // $part3 = bin2hex(random_bytes(2));
        // $part4 = bin2hex(random_bytes(2));
        // $part5 = bin2hex(random_bytes(8));

        // $salt = $part1 . '-' . $part2 . '-' . $part3 . '-' . $part4 . '-' . $part5;
        // return $salt;
        $bytes = random_bytes(18);
        $salt = implode('-', [
            bin2hex(substr($bytes, 0, 4)),
            bin2hex(substr($bytes, 4, 2)),
            bin2hex(substr($bytes, 6, 2)),
            bin2hex(substr($bytes, 8, 2)),
            bin2hex(substr($bytes, 10, 8)),
        ]);
        return $salt;
    }
    
    public function test(Request $request){
        
        return response()->json([
            'server_message' => 'Test successful!',
            'message' => 'You have been authenticated successfully.',
            'data' => 'Test data',
        ], 200);
    }

    public function register(Request $request){

        $username = $request->username;
        $password = $request->password;

        // For example, you can return a success message
        return response()->json([
            'server_message' => 'Register successful!',
            'message' => 'Account registered: ' . $username,
            'data' => [
                'username' => $username,
                'password' => $password,
            ]
        ], 200);
    }

    public function getHash(){

        $salt = self::generateSalt();

        // For example, you can return a success message
        return response()->json([
            'server_message' => 'Salt generation successful!',
            'message' => 'Generated salt: ' . $salt,
            'data' => $salt,
        ], 200);
    }
    
    public function getSaltedPassword(Request $request){

        $newHash = $request->password . $request->salt;

        // For example, you can return a success message
        return response()->json([
            'server_message' => 'Password salt successful!',
            'message' => 'Generated password: ' . $newHash,
            'data' => $newHash,
        ], 200);
    }

    public function getHashedPassword(Request $request){

        $salted = $request->salted;
        $hashed_password = hash('sha256', $salted);

        // For example, you can return a success message
        return response()->json([
            'server_message' => 'Password hash successful!',
            'message' => 'Generated password: ' . $hashed_password,
            'data' => $hashed_password,
        ], 200);
    }

    public function generateUserID(){

        $uuID = self::generateSalt();

        // For example, you can return a success message
        return response()->json([
            'server_message' => 'UUID generate successful!',
            'message' => 'Generated username: ' . $uuID,
            'data' => $uuID,
        ], 200);
    }
    
    public function account(Request $request){

        $data = $request->all();

        $user = new User;
        $user->username = $data['username'];
        $user->uuid = $data['uuid'];
        $user->hashed = $data['hashed'];
        $user->salt = $data['salt'];
        $user->save();

        // For example, you can return a success message
        return response()->json([
            'server_message' => 'Create User successful!',
            'message' => 'Generated username: ' . $user->username,
        ], 200);
    }

    public function checkCsrf(Request $request){
        $csrfToken = Cache::get('csrf_token');

        if ($request->header('X-CSRF-TOKEN') !== $csrfToken) {
            // Request is invalid
            return response()->json(['error' => 'Invalid CSRF token'], 401);
        }
    }
}
