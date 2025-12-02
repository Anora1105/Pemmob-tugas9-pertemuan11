<?php
namespace App\Models;
use CodeIgniter\model;

class MRegistrasi extends Model{
    protected $table = 'member_token';
    protected $allowedFields = ['member_id', 'auth_key'];
}