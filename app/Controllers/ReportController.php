<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Waktu;
use App\Models\TransactionsModel;
use App\Models\JournalModel;

class ReportController extends BaseController
{
    protected $db;
    public function ViewTransactions()
    {
        $data = [
            'title' => 'Laporan Transaksi'
        ];
        return view('transactionreports', $data);
    }
    public function ViewPayments()
    {
        $data = [
            'title' => 'Laporan Pembayaran'
        ];
        return view('paymentreports', $data);
    }
    public function ViewJournal()
    {
        $data = [
            'title' => 'Laporan Jurnal Umum'
        ];
        return view('journalreports', $data);
    }
    public function TransactionData()
    {
        $waktu = new Waktu();
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
            $row[] = $waktu->tgl_indo(substr($list->created_at, 0, 10)) . ' ' . substr($list->created_at, 11, 8);
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
            $row[] = $list->tanggal_jurnal;
            $row[] = $list->no_journal;
            $row[] = $list->no_trx;
            $row[] = $list->nama_akun;
            $row[] = $list->kredit;
            $row[] = $list->debit;
            $row[] = $list->keterangan;
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
}
