<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionsModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id_transaction';
    protected $allowedFields    = ['nama', 'service_code', 'costumer_code', 'berat_pakaian', 'total', 'status', 'updated_at', 'transaction_number', 'jumlah_bayar', 'kembalian'];
    protected $column_order     = ['id_transaction', 'service_code', 'costumer_code'];
    protected $column_search    = ['service_code', 'costumer_code', 'nama_costumer'];
    protected $order            = ['id_transaction' => 'DESC'];
    protected $db;
    protected $dt;
    protected $request;
    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
        $this->dt = $this->db->table($this->table);
        $this->request = \Config\Services::request();
    }

    private function getDatatablesQuery()
    {
        $this->dt->join('services', 'services.kode_service=transactions.service_code');
        $this->dt->join('costumers', 'costumers.kode_costumer=transactions.costumer_code', 'left');

        if ($this->request->getPost('status'))
            $this->dt->where('status', $this->request->getPost('status'));
        if ($this->request->getPost('tanggal'))
            $this->dt->where('SUBSTRING(created_at,1,10)', $this->request->getPost('tanggal'));
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function getDatatables()
    {
        $this->getDatatablesQuery();

        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function countFiltered()
    {
        $this->getDatatablesQuery();
        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }
}
