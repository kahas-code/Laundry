<?php

namespace App\Libraries;

class Waktu
{
	public static function countdate($start, $end)
	{
		$date1 = strtotime($start);
		$date2 = strtotime($end);

		// Formulate the Difference between two dates
		$diff = abs($date2 - $date1);

		// To get the year divide the resultant date into
		// total seconds in a year (365*60*60*24)
		$years = floor($diff / (365 * 60 * 60 * 24));

		// To get the month, subtract it with years and
		// divide the resultant date into
		// total seconds in a month (30*60*60*24)
		$months = floor(($diff - $years * 365 * 60 * 60 * 24)
			/ (30 * 60 * 60 * 24));

		// To get the day, subtract it with years and
		// months and divide the resultant date into
		// total seconds in a days (60*60*24)
		$days = floor(($diff - $years * 365 * 60 * 60 * 24 -
			$months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

		// To get the hour, subtract it with years,
		// months & seconds and divide the resultant
		// date into total seconds in a hours (60*60)
		$hours = floor(($diff - $years * 365 * 60 * 60 * 24
			- $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)
			/ (60 * 60));

		// To get the minutes, subtract it with years,
		// months, seconds and hours and divide the
		// resultant date into total seconds i.e. 60
		$minutes = floor(($diff - $years * 365 * 60 * 60 * 24
			- $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
			- $hours * 60 * 60) / 60);

		// To get the minutes, subtract it with years,
		// months, seconds, hours and minutes
		$seconds = floor(($diff - $years * 365 * 60 * 60 * 24
			- $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
			- $hours * 60 * 60 - $minutes * 60));

		// Print the result
		return ($months > 0 ? $months . ' month' . ($months > 1 ? 's ' : ' ') : '') . $days . ' Day' . ($days > 1 ? 's ' : ' ') . $hours . ' hour' . ($hours > 1 ? 's ' : ' ') . $minutes . ' minute' . ($minutes > 1 ? 's ' : ' ') . $seconds . ' second' . ($seconds > 1 ? 's ' : ' ');
		// printf(
		//     "%d years, %d months, %d days, %d hours, "
		//         . "%d minutes, %d seconds",
		//     $years,
		//     $months,
		//     $days,
		//     $hours,
		//     $minutes,
		//     $seconds
		// );
		// return $date1 . ' ' . $date2;
	}

	public static function tgl_indo($waktu)
	{
		$tanggal = substr($waktu, 0, 10);
		$jam = substr($waktu, 11, 5);
		$day = date('D', strtotime($tanggal));
		$bulan = array(
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$hari = [
			'Sun' => 'Minggu',
			'Mon' => 'Senin',
			'Tue' => 'Selasa',
			'Wed' => 'Rabu',
			'Thu' => 'Kamis',
			'Fri' => 'Jumat',
			'Sat' => 'Sabut'
		];
		$pecahkan = explode('-', $tanggal);

		// variabel pecahkan 0 = tahun
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tanggal

		return  $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0] . ' ' . $jam;
	}
}
