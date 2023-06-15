<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CostumerModel;
use App\Models\JournalModel;
use App\Models\ServicesModel;
use App\Models\TransactionsModel;

class TransactionController extends BaseController
{
    protected $db;
    public function __construct()
    {
        $this->db = new TransactionsModel();
    }
    public function index()
    {
    }
    public function ViewTransaksi()
    {
        $db = new ServicesModel();
        $services = $db->get()->getResult();
        $dt = new CostumerModel();
        $costumers = $dt->get()->getResult();
        $data = [
            'title' => 'Transaksi',
            'services' => $services,
            'costumers' => $costumers
        ];
        return view('transactions', $data);
    }
    public function ViewPembayaran()
    {
        $data = [
            'title' => 'Pembayaran'
        ];
        return view('billings', $data);
    }
    public function ViewJurnal()
    {
        $akuns = db_connect()->table('akun')->get()->getResult();
        $transactions = db_connect()->table('transactions')->where('status', 1)->get()->getResult();
        $data = [
            'title' => 'Data Jurnal Umum',
            'akuns' => $akuns,
            'transactions' => $transactions
        ];
        return view('journals', $data);
    }
    public function Simpan($id = null)
    {
        $post = $this->request->getPost();
        $post['total'] = str_replace(['Rp. ', '.'], '', $post['total']);
        try {
            if ($id == null) {
                $post['transaction_number'] = 'TRX' . date('-d-m-Y-') . str_pad($this->db->selectMax('id_transaction')->get()->getRow()->id_transaction + 1, 4, '0', STR_PAD_LEFT);
                $this->db->insert($post);
            } else {
                $this->db->update($id, $post);
            }
            return $this->response->setJSON(json_encode([
                'status' => 200,
                'pesan' => 'Berhasil menambahkan transaksi'
            ]));
        } catch (\Exception $err) {
            return $this->response->setJSON(json_encode([
                'status' => 400,
                'pesan' => $err->getMessage()
            ]));
        }
    }
    public function TransactionData()
    {
        $this->db = new TransactionsModel();
        $lists = $this->db->getDatatables();
        $data = [];
        $no = $this->request->getPost('start');
        foreach ($lists as $list) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $list->transaction_number;
            $row[] = ($list->id_costumer == 0 ? "Umum" : $list->nama_costumer);
            $row[] = $list->service_code;
            $row[] = 'Rp. ' . number_format($list->harga_service, 2, ',', '.');
            $row[] = $list->berat_pakaian . ' Kg';
            $row[] = 'Rp. ' . number_format($list->harga_service * $list->berat_pakaian, 2, ',', '.');
            $row[] = ($list->status == 0 ? "Belum Bayar" : "Sudah Bayar");
            $row[] = ($list->status == 0 ? '<a class="edit" data-id="' . $list->id_transaction . '"><i class="text-warning table-icon fa fa-pencil"></i></a> <a class="delete" data-id="' . $list->id_transaction . '"><i class="text-danger table-icon fa fa-trash"></i></a> ' : '');
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
    public function JournalData()
    {
        $this->db = new JournalModel();
        $lists = $this->db->getDatatables();
        $data = [];
        $no = $this->request->getPost('start');
        foreach ($lists as $list) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $list->no_journal;
            $row[] = $list->nama_akun;
            $row[] = $list->no_trx;
            $row[] = $list->keterangan;
            $row[] = $list->tanggal_jurnal;
            $row[] = $list->debit;
            $row[] = $list->kredit;
            if (!$this->request->getPost('type'))
                $row[] = '<a class="edit" style="margin-right:5px"  data-id="' . $list->id_journal . '"><i class="fa fa-pencil text-primary table-icon "></i></a> ';
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
    public function BillingData()
    {
        $this->db = new TransactionsModel();
        $lists = $this->db->getDatatables();
        $data = [];
        $no = $this->request->getPost('start');
        foreach ($lists as $list) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $list->transaction_number;
            $row[] = ($list->id_costumer == 0 ? "Umum" : $list->nama_costumer);
            $row[] = 'Rp. ' . number_format($list->harga_service * $list->berat_pakaian, 2, ',', '.');
            $row[] = ($list->status == 0 ? "Belum Bayar" : "Sudah Bayar");
            $row[] = ($list->status == 0 ? '<button class="btn btn-success bayar" data-id="' . $list->id_transaction . '">Bayar</button>' : '<button class="btn btn-warning lihat" data-id="' . $list->id_transaction . '">Lihat</button>');
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
    public function Delete($id)
    {
        try {
            $this->db->delete(['id_transactions' => $id]);
            return $this->response->setJSON(json_encode([
                'status' => 200,
                'pesan' => 'Data Berhasil dihapus'
            ]));
        } catch (\Exception $err) {
            return $this->response->setJSON(json_encode([
                'status' => 400,
                'pesan' => $err->getMessage()
            ]));
        }
    }
    public function GetStruk($id)
    {
        $this->db = new TransactionsModel();
        $this->db->where('id_transaction', $id);
        $data = $this->db->join('services', 'services.kode_service=transactions.service_code')->get()->getRow();
        $output = '<div class="row  border shadow-lg pt-5 pb-5">
        <div class="justify-content-center text-center">
            <h4>Laundry</h4>
            <h6>Jl. Kenanga No.12 Kota Pekanbaru</h6>
            <p class="fw-bold">082887897123</p>
        </div>
        <hr>
        <div class="p-3 mt-0">
            <ul>
                <li><b>No</b>: <span>' . $data->transaction_number . '</span></li>
                <li><b>Tangal Bayar</b>:<span>' . $data->updated_at . '</span></li>
            </ul>
        </div>
        <hr>
        <div class="p-5 pt-0 fw-bold">
            <p class="m-0">' . $data->nama_service . '</p>
            <p>' . $data->harga_service . ' x ' . $data->berat_pakaian . ' Kg</p>
            <p class="text-end fw-bold">Rp. ' . number_format($data->harga_service * $data->berat_pakaian, 2, ',', '.') . '</p>
        </div>
        <hr>
        <div class="row text-end justify-content-end fw-bold mb-2">
            <ul>
                <li><b>Total</b>: <span>Rp. ' . number_format($data->harga_service * $data->berat_pakaian, 2, ',', '.') . '</span></li>
                <li><b>Bayar</b>: <span>Rp. ' . number_format($data->jumlah_bayar, 2, ',', '.') . '</span></li>
                <li><b>Kembalian</b>: <span>Rp. ' . number_format($data->kembalian, 2, ',', '.') . '</span></li>
            </ul>
        </div>

        <hr>
        <h6 class="text-center">Terimakasih</h6>
    </div>';
        return $this->response->setJSON(json_encode($output));
    }
    public function FindOne($id)
    {
        // $this->db = new TransactionsModel();

        try {
            $this->db->join('services', 'services.kode_service=transactions.service_code');
            $this->db->join('costumers', 'costumers.kode_costumer=transactions.costumer_code', 'left');
            $this->db->where('id_transaction', $id);
            $data = $this->db->get()->getRow();
            $data->harga_service = 'Rp. ' . number_format($data->harga_service, 2, ',', '.');
            $data->total = 'Rp. ' . number_format($data->total, 2, ',', '.');
            return $this->response->setJSON(json_encode($data));
        } catch (\Exception $err) {
            return $this->response->setJSON(json_encode($err->getMessage()));
        }
    }
    public function Bayar($id)
    {
        $post = $this->request->getPost();
        $post['kembalian'] = str_replace(['Rp. ', '.'], '', $post['kembalian']);
        $post['updated_at'] = date('Y-m-d H:i:s');
        $post['status'] = 1;

        try {
            $this->db->update($id, $post);
            return $this->response->setJSON(json_encode([
                'status' => 200,
                'pesan' => 'Berhasil melakukan pembayaran'
            ]));
        } catch (\Exception $err) {
            return $this->response->setJSON(json_encode([
                'status' => 400,
                'pesan' => $err->getMessage()
            ]));
        }
    }
    public function SimpanJurnal($id = null)
    {
        $this->db = new JournalModel();
        $post = $this->request->getPost();
        if ($id == null) {
            try {
                $post['no_journal'] = 'J-' . date('d-m-Y') . '-' . str_pad($this->db->selectMax('id_journal')->get()->getRow()->id_journal + 1, 5, '0', STR_PAD_LEFT);
                $this->db->insert($post);
                return $this->response->setJSON(json_encode([
                    'status' => 200,
                    'pesan' => 'Berhasil menambahkan data'
                ]));
            } catch (\Exception $err) {
                return $this->response->setJSON(json_encode([
                    'status' => 400,
                    'pesan' => $err->getMessage()
                ]));
            }
        } else {
            try {
                $this->db->update($id, $post);
                return $this->response->setJSON(json_encode([
                    'status' => 200,
                    'pesan' => 'Berhasil menyimpan data'
                ]));
            } catch (\Exception $err) {
                return $this->response->setJSON(json_encode([
                    'status' => 400,
                    'pesan' => $err->getMessage()
                ]));
            }
        }
    }
    public function getTRX($id)
    {
        try {
            $data = $this->db->where('id_transaction', $id)->get()->getRow();
            return $this->response->setJSON(json_encode($data));
        } catch (\Exception $err) {
            return $err->getMessage();
        }
    }
}
