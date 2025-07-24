<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\UserService;

class UserController extends Controller
{
    protected $UserService;
    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }


    public function getall(){
        return $this->UserService->getall();
    }

    public function register(Request $request){
        return $this->UserService->register($request);
    }
    public function update(Request $request){
        // Assuming the update logic is implemented in UserService
        return $this->UserService->update($request);
    }
    public function delete(Request $request){
        // Assuming the delete logic is implemented in UserService
        return $this->UserService->delete($request);
    }
    public function getbyid(Request $request){
        // Assuming the getbyid logic is implemented in UserService
        return $this->UserService->getbyid($request);
    }
    public function login(Request $request){
        // Assuming the login logic is implemented in UserService
        return $this->UserService->login($request);
    }
    public function resetPassword(Request $request){
        // Assuming the reset password logic is implemented in UserService
        return $this->UserService->resetPassword($request);
    }
    public function sendMail(Request $request){
        return $this->UserService->sendMail($request);
    }

}
