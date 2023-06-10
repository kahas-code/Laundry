<?php

namespace App\Controllers;

use App\Models\TransactionsModel;

class Home extends BaseController
{
    public function index()
    {
        $db = new TransactionsModel();
        $trxtoday = $db->where('SUBSTRING(created_at,9,2)', date('d'))->get();
        $trxmonth = $db->where('SUBSTRING(created_at,6,2)', date('m'))->get();
        $total = $db->where('SUBSTRING(created_at,6,2)', date('m'))->selectSum('total')->get()->getRow();
        $data = [
            'title' => 'Dashboard',
            'harian' => $trxtoday->resultID->num_rows,
            'bulanan' => $trxmonth->resultID->num_rows,
            'jumlah' => $total,
        ];
        return view('home', $data);
    }
}
