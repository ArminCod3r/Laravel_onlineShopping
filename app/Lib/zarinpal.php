<?php

namespace App\Lib;
use SoapClient;
use DB;
use Auth;

class zarinpal
{

	public static function pay($amount)
	{
		$MerchantID  = self::get_MerchantID();                 // Required
		$Amount      = $amount;               				   // Toman - Required
		$Description = 'خرید محصولات';        				   // Required
		$Email       = Auth::user()->username; 				   // Optional
		$Mobile      = ' ';         				           // Optional
		$CallbackURL = url('').'/verify'.'?amount='.$amount;   // Required


		$client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

		$result = $client->PaymentRequest(
		[
			'MerchantID'  => $MerchantID,
			'Amount'      => $Amount,
			'Description' => $Description,
			'Email'       => $Email,
			'Mobile'      => $Mobile,
			'CallbackURL' => $CallbackURL,
		]
		);

		if ($result->Status == 100)
			return $result->Authority;
		
		else
			return false;;
	
	}

	public static function get_MerchantID()
	{
		$MerchantID = DB::table('zarinpal_id')->select('MerchantID')->get()->pluck('MerchantID');
		return $MerchantID[0];
	}

}

?>