<?php
namespace App\Controllers;

use App\Models\MProduk;
use CodeIgniter\RESTful\ResourceController;

class ProdukController extends ResourceController
{
    protected $modelName = MProduk::class;
    protected $format    = 'json';

    public function index()
    {
        try {
            $produk = $this->model->orderBy('id', 'DESC')->findAll();

            return $this->respond([
                'code'    => 200,
                'status'  => true,
                'message' => 'Daftar produk',
                'data'    => $produk
            ], 200);
        } catch (\Exception $e) {
            return $this->respond([
                'code'    => 500,
                'status'  => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'data'    => null
            ], 500);
        }
    }

    /**
     * POST /produk
     * Tambah produk baru
     */
    public function create()
    {
        $input = $this->request->getJSON(true); // ambil body JSON sebagai array
        if (!$input) {
            return $this->respond([
                'code'    => 400,
                'status'  => false,
                'message' => 'Request harus berformat JSON',
                'data'    => null
            ], 400);
        }

        // Validasi sederhana
        $rules = [
            'kode_produk' => 'required|max_length[50]',
            'nama_produk' => 'required|max_length[255]',
            'harga'       => 'required|numeric'
        ];

        if (!$this->validate($rules, $input)) {
            $errors = $this->validator->getErrors();
            return $this->respond([
                'code'    => 422,
                'status'  => false,
                'message' => 'Validasi gagal',
                'data'    => $errors
            ], 422);
        }

        try {
            $data = [
                'kode_produk' => $input['kode_produk'],
                'nama_produk' => $input['nama_produk'],
                'harga'       => (int) $input['harga'],
            ];

            $insertId = $this->model->insert($data);
            if ($insertId === false) {
                return $this->respond([
                    'code'    => 500,
                    'status'  => false,
                    'message' => 'Gagal menyimpan data',
                    'data'    => null
                ], 500);
            }

            $produkBaru = $this->model->find($insertId);

            return $this->respond([
                'code'    => 201,
                'status'  => true,
                'message' => 'Produk berhasil dibuat',
                'data'    => $produkBaru
            ], 201);
        } catch (\Exception $e) {
            return $this->respond([
                'code'    => 500,
                'status'  => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'data'    => null
            ], 500);
        }
    }

    /**
     * GET /produk/{id}
     * Tampilkan detail produk
     */
    public function show($id = null)
    {
        if ($id === null) {
            return $this->respond([
                'code'    => 400,
                'status'  => false,
                'message' => 'ID produk tidak diberikan',
                'data'    => null
            ], 400);
        }

        $produk = $this->model->find($id);
        if (!$produk) {
            return $this->respond([
                'code'    => 404,
                'status'  => false,
                'message' => 'Produk tidak ditemukan',
                'data'    => null
            ], 404);
        }

        return $this->respond([
            'code'    => 200,
            'status'  => true,
            'message' => 'Detail produk',
            'data'    => $produk
        ], 200);
    }

    /**
     * PUT /produk/{id}
     * Update produk
     */
    public function update($id = null)
    {
        if ($id === null) {
            return $this->respond([
                'code'    => 400,
                'status'  => false,
                'message' => 'ID produk tidak diberikan',
                'data'    => null
            ], 400);
        }

        $exists = $this->model->find($id);
        if (!$exists) {
            return $this->respond([
                'code'    => 404,
                'status'  => false,
                'message' => 'Produk tidak ditemukan',
                'data'    => null
            ], 404);
        }

        // terima JSON (PUT biasanya dikirim sebagai JSON)
        $input = $this->request->getJSON(true);
        if (!$input) {
            // juga coba ambil raw input (form-encoded)
            $input = $this->request->getRawInput();
        }

        if (!$input) {
            return $this->respond([
                'code'    => 400,
                'status'  => false,
                'message' => 'Data update tidak ditemukan',
                'data'    => null
            ], 400);
        }

        // Validasi (boleh partial but for simplicity require fields)
        $rules = [
            'kode_produk' => 'required|max_length[50]',
            'nama_produk' => 'required|max_length[255]',
            'harga'       => 'required|numeric'
        ];

        if (!$this->validate($rules, $input)) {
            $errors = $this->validator->getErrors();
            return $this->respond([
                'code'    => 422,
                'status'  => false,
                'message' => 'Validasi gagal',
                'data'    => $errors
            ], 422);
        }

        try {
            $data = [
                'kode_produk' => $input['kode_produk'],
                'nama_produk' => $input['nama_produk'],
                'harga'       => (int) $input['harga'],
            ];

            $updated = $this->model->update($id, $data);
            if ($updated === false) {
                return $this->respond([
                    'code'    => 500,
                    'status'  => false,
                    'message' => 'Gagal mengupdate data',
                    'data'    => null
                ], 500);
            }

            $produkBaru = $this->model->find($id);

            return $this->respond([
                'code'    => 200,
                'status'  => true,
                'message' => 'Produk berhasil diperbarui',
                'data'    => $produkBaru
            ], 200);
        } catch (\Exception $e) {
            return $this->respond([
                'code'    => 500,
                'status'  => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'data'    => null
            ], 500);
        }
    }

    /**
     * DELETE /produk/{id}
     * Hapus produk
     */
    public function delete($id = null)
    {
        if ($id === null) {
            return $this->respond([
                'code'    => 400,
                'status'  => false,
                'message' => 'ID produk tidak diberikan',
                'data'    => null
            ], 400);
        }

        $exists = $this->model->find($id);
        if (!$exists) {
            return $this->respond([
                'code'    => 404,
                'status'  => false,
                'message' => 'Produk tidak ditemukan',
                'data'    => null
            ], 404);
        }

        try {
            $deleted = $this->model->delete($id);
            if (!$deleted) {
                return $this->respond([
                    'code'    => 500,
                    'status'  => false,
                    'message' => 'Gagal menghapus produk',
                    'data'    => null
                ], 500);
            }

            return $this->respond([
                'code'    => 200,
                'status'  => true,
                'message' => 'Produk berhasil dihapus',
                'data'    => null
            ], 200);
        } catch (\Exception $e) {
            return $this->respond([
                'code'    => 500,
                'status'  => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'data'    => null
            ], 500);
        }
    }
}
