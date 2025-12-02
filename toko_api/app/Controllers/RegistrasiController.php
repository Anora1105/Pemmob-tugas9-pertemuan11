<?php
namespace App\Controllers;
use App\Models\MRegistrasi;

class RegistrasiController extends RestfulController{
    public function registrasi(){
        $data = [
            'nama' => $this->request->getvar('nama'),
            'email' =>$this->request->getvar('email'),
            'password' =>password_hash($this->request->getvar('password'), PASSWORD_DEFAULT)
        ];
        $model = new MRegistrasi();
        $model->save($data);
        return $this->responseHasil(200,true,"Registrasi Berhasil");
    }
}