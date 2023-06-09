<?php

namespace App\Models;

use CodeIgniter\Model;

class JournalModel extends Model
{
    protected $table            = 'journals';
    protected $primaryKey       = 'id_journal';
    protected $allowedFields    = ['no_journal', 'no_akun', 'no_trx', 'debit', 'keterangan', 'tanggal_jurnal', 'kredit'];
    protected $column_order     = ['id_journal', 'no_journal', 'no_akun'];
    protected $column_search    = ['no_journal', 'keterangan', 'tanggal_jurnal', 'keterangan'];
    protected $order            = ['id_journal' => 'DESC'];
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
        if ($this->request->getPost('tanggal'))
            $this->dt->where('tanggal_jurnal', $this->request->getPost('tanggal'));

        $this->dt->join('transactions', 'journals.no_trx=transactions.transaction_number');
        $this->dt->join('akun', 'akun.no_akun=journals.no_akun');
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
