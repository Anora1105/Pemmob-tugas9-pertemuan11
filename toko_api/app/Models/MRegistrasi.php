<?php
namespace App\Models;
use CodeIgniter\model;

class MRegistrasi extends Model{
    protected $table = 'member';
    protected $allowedFields = ['nama', 'email', 'password'];
}