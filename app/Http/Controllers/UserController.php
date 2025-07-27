<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\UserService;
use PhpParser\Node\Stmt\Return_;

class UserController extends Controller
{
    protected $UserService;
    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }


    public function getall(Request $request){
        $page = $request->input('page', 1);
        $limit = 2;
        $offset = ($page - 1) * $limit;
        return $this->UserService->getall($offset, $limit);
    }

    public function register(Request $request){
        return $this->UserService->register($request);
    }
    public function update(Request $request){
        return $this->UserService->update($request);
    }
    public function delete(Request $request){
        return $this->UserService->delete($request);
    }
    public function getbyid(Request $request){
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

}
