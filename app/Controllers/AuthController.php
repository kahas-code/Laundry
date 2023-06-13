<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $db;
    public function __construct()
    {
        $this->db = new UserModel();
    }
    public function index()
    {
      
        $data = [
            'title' => 'Login'
        ];
        return view('auth/login', $data);
    }

    public function AuthCheck()
    {
        $post = $this->request->getPost();

        $chekEmail = $this->db->where('username', $post['username'])->get();


        if ($chekEmail->resultID->num_rows == 0) {
            return $this->response->setJSON(json_encode([
                'status' => 400,
                'pesan' => 'Username tidak terdaftar!'
            ]));
        } else {
            $data = $chekEmail->getRow();
            $validate = password_verify($post['password'], $data->password);
            if (!$validate)
                return $this->response->setJSON(json_encode([
                    'status' => 400,
                    'pesan' => 'Password salah!'
                ]));


            $this->db->set('isLogin', TRUE)->where('email', $data->email)->update();

            $session_data = [
                'userRole' => $data->role,
                'userName' => $data->username,
                'userEmail' => $data->email,
                'isLoggedIn' => TRUE,
            ];
            session()->set($session_data);
            return $this->response->setJSON(json_encode([
                'status' => 200,
                'pesan' => 'Data Tervalidasi'
            ]));
        }
    }
    public function CheckLogin()
    {
        $email = session('userEmail');
        if ($email !== '') {
            $data = $this->db->where('email', $email)->get();
            if ($data->resultID->num_rows == 0)
                return FALSE;

            if ($data->getRow()->isLogin !== '1')
                return FALSE;
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function Logout()
    {
        $this->db->set('isLogin', FALSE)->where('email', session('userEmail'))->update();
        session()->destroy();

        return redirect()->to('/');
    }
}
