<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Libraries\Waktu;
use App\Models\AkunModel;
use App\Models\CostumerModel;
use App\Models\JournalModel;
use App\Models\ServicesModel;

class DataController extends BaseController
{
    protected $db;
    public function __construct()
    {
        $this->db = new UserModel();
    }
    public function index()
    {
    }
    public function ViewUser()
    {
        $this->db = new ServicesModel();
        $data = [
            'title' => 'Data User'
        ];
        return view('user', $data);
    }
    public function ViewService()
    {
        $data = [
            'title' => 'Data Layanan Laundry'
        ];
        return view('services', $data);
    }
    public function ViewCustomer()
    {
        $data = [
            'title' => 'Data Pelanggan'
        ];
        return view('costumers', $data);
    }
    public function ViewAkun()
    {
        $data = [
            'title' => 'Data Akun'
        ];
        return view('akun', $data);
    }
    public function UserData()
    {
        $waktu = new Waktu();
        $lists = $this->db->getDatatables();
        $data = [];
        $no = $this->request->getPost('start');
        foreach ($lists as $list) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $list->nama;
            $row[] = $list->username;
            $row[] = $list->email;
            $row[] = $list->no_telp;
            $row[] = $list->alamat;
            $row[] = ($list->tempat_lahir == null ? '' : $list->tempat_lahir . ', ' . $waktu->tgl_indo($list->tanggal_lahir));
            $row[] = '<a class="edit" style="margin-right:5px"  data-id="' . $list->id_user . '"><i class="fa fa-pencil text-primary table-icon "></i></a> <a style="margin-right:5px" class=" delete" data-id="' . $list->id_user . '"><i class="fa fa-trash text-danger table-icon"></i></a> <a class="change" data-id="' . $list->id_user . '"><i class="fa fa-shield table-icon text-warning "></i></a>';
            $data[] = $row;
        }

        $output = [
            'draw' => $this->request->getPost('draw'),
            'recordsTotal' => $this->db->countAll(),
            'recordsFiltered' => $this->db->countFiltered(),
            'data' => $data
        ];

        return $this->response->setJSON($output);
    }

    public function Simpan($id = null)
    {
        $post = $this->request->getPost();
        foreach ($post as $key => $value) {
            if ($post[$key] == '') {
                unset($post[$key]);
            }
        }
        if ($post['type'] == "user") {
            $this->db = new UserModel();
            unset($post['confpass']);
            $post['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
        }
        if ($post['type'] == 'layanan') {
            $this->db = new ServicesModel();
            if ($id == null)
                $post['kode_service'] = 'L' . str_pad($this->db->selectMax('id_service')->get()->getRow()->id_service + 1, 5, '0', STR_PAD_LEFT);
        }
        if ($post['type'] == 'pelanggan') {
            $this->db = new CostumerModel();
            if ($id == null)
                $post['kode_costumer'] = 'P' . str_pad($this->db->selectMax('id_costumer')->get()->getRow()->id_costumer + 1, 5, '0', STR_PAD_LEFT);
        }
        if ($post['type'] == 'akun')
            $this->db = new AkunModel();

        if ($id == null) {
            try {
                $proses = $this->db->insert($post);
            } catch (\Exception $e) {
                $result = [
                    'status' => 400,
                    'pesan' => $e->getMessage()
                ];
            }
        } else {
            try {
                $proses = $this->db->update($id, $post);
            } catch (\Exception $e) {
                $result = [
                    'status' => 400,
                    'pesan' => $e->getMessage()
                ];
            }
        }

        if ($proses)
            $result = [
                'status' => 200,
                'pesan' => "Berhasil menambahkan data"
            ];
        return $this->response->setJSON(json_encode($result));
    }
    public function Hapus($id)
    {
        $type = $this->request->getGet('type');
        if ($type == 'user') {
            $this->db = new UserModel();
            $field = 'id_user';
        }else if ($type == 'layanan') {
            $this->db = new ServicesModel();
            $field = 'id_layanan';
        }else if ($type == 'pelanggan') {
            $this->db = new CostumerModel();
            $field = 'id_customer';
        }else if ($type == 'akun') {
            $this->db = new AkunModel();
            $field = 'id_akun';
        }else if ($type = 'jurnal') {
            $this->db = new JournalModel();
            $field = 'id_journal';
        }
        try {
            $proses = $this->db->delete([$field => $id]);
        } catch (\Exception $err) {
            return $this->response->setJSON(json_encode([
                'status' => 400,
                'pesan' => $err->getMessage()
            ]));
        }

        return $this->response->setJSON(json_encode([
            'status' => 200,
            'pesan' => 'Berhasil Menghapus Data'
        ]));
    }
    public function DataById($id)
    {
        $type = $this->request->getGet('type');
        if ($type == 'user') {
            $this->db = new UserModel();
            $field = 'id_user';
        }else if ($type == 'layanan') {
            $this->db = new ServicesModel();
            $field = 'id_service';
        }else if ($type == 'pelanggan') {
            $this->db = new CostumerModel();
            $field = 'id_costumer';
        }else if ($type == 'akun') {
            $this->db = new AkunModel();
            $field = 'id_akun';
        }else if ($type = 'jurnal') {
            $this->db = new JournalModel();
            $field = 'id_journal';
        }
        try {
           
            $data = $this->db->where($field, $id)->get()->getRow();
        } catch (\Exception $err) {
            return $err->getMessage();
        }

        return $this->response->setJSON(json_encode($data));
    }

    public function ServiceData()
    {
        $this->db = new ServicesModel();
        $lists = $this->db->getDatatables();
        $data = [];
        $no = $this->request->getPost('start');
        foreach ($lists as $list) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $list->kode_service;
            $row[] = $list->nama_service;
            $row[] = 'Rp. ' . number_format($list->harga_service, 2, ',', '.');
            $row[] = '<a class="edit" style="margin-right:5px"  data-id="' . $list->id_service . '"><i class="fa fa-pencil text-primary table-icon "></i></a> <a style="margin-right:5px" class=" delete" data-id="' . $list->id_service . '"><i class="fa fa-trash text-danger table-icon"></i></a>';
            $data[] = $row;
        }

        $output = [
            'draw' => $this->request->getPost('draw'),
            'recordsTotal' => $this->db->countAll(),
            'recordsFiltered' => $this->db->countFiltered(),
            'data' => $data
        ];

        return $this->response->setJSON($output);
    }
    public function CostumerData()
    {
        $this->db = new CostumerModel();
        $lists = $this->db->getDatatables();
        $data = [];
        $no = $this->request->getPost('start');
        foreach ($lists as $list) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $list->nama_costumer;
            $row[] = $list->kode_costumer;
            $row[] = $list->alamat;
            $row[] = $list->no_telp;
            $row[] = '<a class="edit" style="margin-right:5px"  data-id="' . $list->id_costumer . '"><i class="fa fa-pencil text-primary table-icon "></i></a> <a style="margin-right:5px" class=" delete" data-id="' . $list->id_costumer . '"><i class="fa fa-trash text-danger table-icon"></i></a>';
            $data[] = $row;
        }

        $output = [
            'draw' => $this->request->getPost('draw'),
            'recordsTotal' => $this->db->countAll(),
            'recordsFiltered' => $this->db->countFiltered(),
            'data' => $data
        ];

        return $this->response->setJSON($output);
    }
    public function AkunData()
    {
        $this->db = new AkunModel();
        $lists = $this->db->getDatatables();
        $data = [];
        $no = $this->request->getPost('start');
        foreach ($lists as $list) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $list->no_akun;
            $row[] = $list->nama_akun;
            $row[] = '<a class="edit" style="margin-right:5px"  data-id="' . $list->id_akun . '"><i class="fa fa-pencil text-primary table-icon "></i></a> <a style="margin-right:5px" class=" delete" data-id="' . $list->id_akun . '"><i class="fa fa-trash text-danger table-icon"></i></a>';
            $data[] = $row;
        }

        $output = [
            'draw' => $this->request->getPost('draw'),
            'recordsTotal' => $this->db->countAll(),
            'recordsFiltered' => $this->db->countFiltered(),
            'data' => $data
        ];

        return $this->response->setJSON($output);
    }
    public function FindAllServices()
    {
        $this->db = new ServicesModel();
        return $this->response->setJSON(json_encode($this->db->where('kode_service', $this->request->getGet('kode_layanan'))->get()->getRow()));
    }
}
