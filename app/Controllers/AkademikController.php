<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;

class AkademikController extends BaseController
{
    protected $mahasiswa;
    public function __construct()
    {
        $this->mahasiswa = new MahasiswaModel();
        require_once APPPATH . 'ThirdParty/ssp.php';
        $this->db = db_connect();
    }
    public function index()
    {
        $data = [
            "title" => "Data Akademik"
        ];
        return view('index', $data);
    }

    public function addMahasiswa()
    {
        $validation = \Config\Services::validation();
        $this->validate([
            'Nama' => [
                'rules' => 'required|is_unique[mahasiswa.Nama]',
                'errors' => [
                    'required' => 'kolom Nama wajib diisi',
                    'is_unique' => 'Nama sudah digunakan'
                ]
            ],
            'JenisKelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kolom Jenis Kelamin wajib diisi'
                ]
            ],
            'Alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Alamat wajib diisi'
                ]
            ],
            'Agama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kolom Agama wajib diisi'
                ]
            ],
            'NoHp' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'kolom No Hape wajib diisi',
                    'numeric' => 'Karakter wajib angka'
                ]
            ],
            'Email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'kolom Email wajib diisi',
                    'valid_email' => 'Email tidak valid'
                ]
            ],
            'Foto' => [
                'rules' => 'uploaded[Foto]',
                'errors' => [
                    'required' => 'kolom Foto wajib diisi',
                ]
            ],
        ]);

        if ($validation->run() == false) {
            $errors = $validation->getErrors();
            echo json_encode(['code' => 0, 'error' => $errors]);
        } else {

            return dd($this->request->getFile('Foto')->getName());
            //insert data into db
            $data = [
                'Nama' => $this->request->getPost('Nama'),
                'JenisKelamin' => $this->request->getPost('JenisKelamin'),
                'Alamat' => $this->request->getPost('Alamat'),
                'Agama' => $this->request->getPost('Agama'),
                'NoHp' => $this->request->getPost('NoHp'),
                'Email' => $this->request->getPost('Email')
            ];
            $insert = $this->mahasiswa->insert($data);
            if ($insert) {
                echo json_encode(['code' => 1, 'msg' => 'Data mahasiswa telah disimpan']);
            } else {
                echo json_encode(['code' => 0, 'msg' => 'Gagal']);
            }
        }
    }

    public function getAllMahasiswa()
    {
        // DB Details
        $dbDetails = array(
            'host' => $this->db->hostname,
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
        );

        $table = 'mahasiswa';
        $primarykey = 'id';


        $kolom = array(
            array(
                'db' => 'id',
                'dt' => 0,
            ),
            array(
                'db' => 'Nama',
                'dt' => 1
            ),
            array(
                'db' => 'JenisKelamin',
                'dt' => 2,
            ),
            array(
                'db' => 'Alamat',
                'dt' => 3,
            ),
            array(
                'db' => 'Agama',
                'dt' => 4,
            ),
            array(
                'db' => 'NoHp',
                'dt' => 5,
            ),
            array(
                'db' => 'Email',
                'dt' => 6,
            ),
            array(
                'db' => 'Foto',
                'dt' => 7,
            ),
            array(
                'db' => 'id',
                'dt' => 8,
                'formatter' => function ($d, $row) {
                    return "<div class='btn-group'>
                                <button class='btn btn-sm btn-primary' data-id='" . $row['id'] . "' id='updateMahasiswaBtn'>Update</button>
                                <button class='btn btn-sm btn-danger' data-id='" . $row['id'] . "' id='deleteMahasiswaBtn'>delete</button>
                            </div>";
                }
            ),
        );

        echo json_encode(
            \SSP::simple($_GET, $dbDetails, $table, $primarykey, $kolom)
        );
    }

    public function getMahasiswaInfo()
    {
        $id = $this->request->getPost('mahasiswa_id');
        $info = $this->mahasiswa->find($id);

        if ($info) {
            echo json_encode(['code' => 1, 'msg' => '', 'results' => $info]);
        } else {
            echo json_encode(['code' => 0, 'msg' => 'Hasil tidak ditemukan', 'results' => null]);
        }
    }

    public function updateMahasiswa()
    {
        $validation = \Config\Services::validation();
        $cid = $this->request->getPost('cid');

        $this->validate([
            'Nama' => [
                'rules' => 'required|is_unique[mahasiswa.Nama,id,' . $cid . ']',
                'errors' => [
                    'requred' => 'kolom Nama wajib diisi',
                    'is_unique' => 'Nama sudah digunakan'
                ]
            ],
            'JenisKelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kolom Jenis Kelamin wajib diisi'
                ]
            ],
            'Alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Alamat wajib diisi'
                ]
            ],
            'Agama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kolom Agama wajib diisi'
                ]
            ],
            'NoHp' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'kolom No Hape wajib diisi',
                    'numeric' => 'Karakter wajib angka'
                ]
            ],
            'Email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'kolom wajib diisi',
                    'valid_email' => 'Email tidak valid'
                ]
            ]
        ]);

        if ($validation->run() == false) {
            $errors = $validation->getErrors();
            echo json_encode(['code' => 0, 'error' => $errors]);
            exit();
        } else {
            //update country
            $data = [
                'Nama' => $this->request->getPost('Nama'),
                'JenisKelamin' => $this->request->getPost('JenisKelamin'),
                'Alamat' => $this->request->getPost('Alamat'),
                'Agama' => $this->request->getPost('Agama'),
                'NoHp' => $this->request->getPost('NoHp'),
                'Email' => $this->request->getPost('Email')
            ];
            $update = $this->mahasiswa->update($cid, $data);

            if ($update) {
                echo json_encode(['code' => 1, 'msg' => 'Data success di update']);
            } else {
                echo json_encode(['code' => 0, 'msg' => 'Gagal di update']);
            }
        }
    }

    public function deleteMahasiswa()
    {
        $id = $this->request->getPost('mahasiswa_id');
        $delete = $this->mahasiswa->delete($id);

        if ($delete) {
            echo json_encode(['code' => 1, 'msg' => 'Data Selesai Dihapus']);
        } else {
            echo json_encode(['code' => 0, 'msg' => 'gagal hapus data']);
        }
    }
}
