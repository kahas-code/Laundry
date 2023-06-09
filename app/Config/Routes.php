<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/login', 'AuthController::index');
$routes->get('/logout', 'AuthController::Logout');
$routes->post('/auth', 'AuthController::AuthCheck');
$routes->get('/check', 'AuthController::CheckLogin');
$routes->group('', ['filter' => 'AuthCheck'], function ($routes) {
    $routes->get('/', 'Home::index');

    // routing untuk menu data user
    $routes->get('/data/user', 'DataController::ViewUser');
    $routes->post('/data/userdata', 'DataController::UserData');
    $routes->post('/data/store', 'DataController::Simpan');
    $routes->post('/data/store/(:num)', 'DataController::Simpan/$1');
    $routes->get('/data/delete/(:num)', 'DataController::Hapus/$1');
    $routes->get('/data/getdatabyid/(:num)', 'DataController::DataById/$1');

    // routing untuk menu data layanan
    $routes->get('/data/layanan', 'DataController::ViewService');
    $routes->post('/data/datalayanan', 'DataController::ServiceData');
    $routes->get('/data/findservices', 'DataController::FindAllServices');

    // routing untuk menu data pelanggan
    $routes->get('/data/pelanggan', 'DataController::ViewCustomer');
    $routes->post('/data/datapelanggan', 'DataController::CostumerData');

    // routing menu data akun
    $routes->get('/data/akun', 'DataController::ViewAkun');
    $routes->post('/data/dataakun', 'DataController::AkunData');

    // routing menu transaksi
    $routes->get('/transaksi/transaksi', 'TransactionController::ViewTransaksi');
    $routes->post('/transaksi/simpan', 'TransactionController::Simpan');
    $routes->post('/transaksi/datatransaksi', 'TransactionController::TransactionData');
    $routes->get('/transaksi/hapustransaksi/(:num)', 'TransactionController::Delete/$1');

    // routing menu pembayaran
    $routes->get('/pembayaran', 'TransactionController::ViewPembayaran');
    $routes->post('/transaksi/datapembayaran', 'TransactionController::BillingData');
    $routes->get('/transaksi/struk/(:num)', 'TransactionController::GetStruk/$1');
    $routes->get('/transaksi/getdata/(:num)', 'TransactionController::FindOne/$1');
    $routes->post('/transaksi/bayar/(:num)', 'TransactionController::Bayar/$1');

    // routing menu buat data jurnal
    $routes->get('jurnal', 'TransactionController::ViewJurnal');
    $routes->post('/transaksi/datajurnal', 'TransactionController::JournalData');
    $routes->post('/transaksi/storejurnal', 'TransactionController::SimpanJurnal');
    $routes->post('/transaksi/storejurnal/(:num)', 'TransactionController::SimpanJurnal/$1');

    
    // routing menu laporan transaksi
    $routes->get('/laporan/transaksi', 'ReportController::ViewTransactions');
    $routes->post('/laporan/datalaporantransaksi', 'ReportController::TransactionData');

    // routing menu laporan jurnal umum
    $routes->get('/laporan/jurnalumum', 'ReportController::ViewJournal');
    
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
