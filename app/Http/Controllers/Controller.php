<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
 * sendSMS - to send otp SMS to parent
 * @param  number $mobile_number Parent Mobile Number
 * @param  number $otp           OTP
 * @return string                OTP
 */
    public function sendSMS($mobile_number,$otp,$sms_sender_username,$sms_sender_password)
    {
        //$request_url = 'http://www.smscountry.com/SMSCwebservice_Bulk.aspx';

        $request_url = 'https://api.textlocal.in/send/';

        $request_data = [
            'user' => $sms_sender_username, //kumbashree
            'passwd' => $sms_sender_password, //kuMb@sh06/17
            'mobilenumber'=>$mobile_number,
            'message'=>$otp,
            'SMS_Job_NO'=>'123',
            'mtype'=>null,
            'DR'=>'Y'
        ];

        // $curl = curl_init();
        // // $key = env('2FACTOR_API_KEY');
        // curl_setopt_array($curl, array(
        // CURLOPT_URL => $url,
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => "",
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 30,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // CURLOPT_CUSTOMREQUEST => "GET",
        // CURLOPT_POSTFIELDS => "{}",
        // ));

        // $response = curl_exec($curl);
        // $err = curl_error($curl);

        // curl_close($curl);

        // return $err;
        //diaplay final message response

        $this->curlSMSRequest($request_data,$request_url);
    }

    public function sendSMSTextLocal($apiKeys, $numbers, $sender, $message) {
        // Account details
    $apiKey = urlencode($apiKeys); //'NmI0ZDc3Nzc3MzRmNDI1MDUyNjE3ODMyNGI1NzQ2NTQ='
    
    // Message details
    // $numbers = explode(delimiter, string);
    $sender = urlencode($sender);
   // $message = rawurlencode('Hi there, thank you for sending your first test message from Textlocal. See how you can send effective SMS campaigns here: https://tx.gl/r/2nGVj/');
 // 
    // $numbers = implode(',', $numbers);
 
    // Prepare data for POST request
    $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
    // Send the POST request with cURL
    $ch = curl_init('https://api.textlocal.in/send/');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    // Process your response here
    return $response;

          // $apiKey = urlencode('NmI0ZDc3Nzc3MzRmNDI1MDUyNjE3ODMyNGI1NzQ2NTQ=');
  
          // // text Message details
          // $phone_numbers = urlencode('919964864032,919844573780');
          // $sender = urlencode('600010');
          // $msg = rawurlencode('Test message sent from textlocal');
         
          // $data = 'apikey=' . $apiKey . '&numbers=' . $phone_numbers . "&sender=" . $sender . "&msg=" . $msg;
         
          // // Send the GET request with cURL to send SMS
          // $ch = curl_init('https://api.textlocal.in/send/?' . $data);
          // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          // $response = curl_exec($ch);
          // curl_close($ch);
          
          // // Get the response here
          // echo $response;
    }

    function curlSMSRequest($request_data,$request_url){
        // if(!empty($request_url)){

        //     $ch = curl_init();

        //     if (!$ch){die("Couldn't initialize a cURL handle");}
        //     $ret = curl_setopt($ch, CURLOPT_URL,$request_url);
        //     curl_setopt ($ch, CURLOPT_POST, 1);
        //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        //     curl_setopt ($ch, CURLOPT_POSTFIELDS,$request_data);
        //     $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //     $curlresponse = curl_exec($ch); // execute

        //     if(curl_errno($ch))
        //     echo 'curl error : '. curl_error($ch);
        //     if (empty($ret)) {
        //     // some kind of an error happened
        //     die(curl_error($ch));
        //     curl_close($ch); // close cURL handler
        //     } else {
        //         $info = curl_getinfo($ch);

        //         curl_close($ch); // close cURL handler

        //       return $curlresponse;

        //     }
        // }

        // Account details TEXTLOCAL
    $apiKey = urlencode('NmI0ZDc3Nzc3MzRmNDI1MDUyNjE3ODMyNGI1NzQ2NTQ=');
    
    // Message details
    $numbers = '9964864032';
    $sender = urlencode('600010');
    $message = rawurlencode('Prajna is Testing');
 
    //$numbers = implode(',', $numbers);
 
    // Prepare data for POST request
    $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
    // Send the POST request with cURL
    $ch = curl_init($request_url);
    $ret = curl_setopt($ch, CURLOPT_URL,$request_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);



    if(curl_errno($ch))
        echo 'curl error : '. curl_error($ch);
    if (empty($ret)) {
    // some kind of an error happened
        die(curl_error($ch));
        curl_close($ch); // close cURL handler
    } else {
        $info = curl_getinfo($ch);
        curl_close($ch); // close cURL handler
        return $response;
    }

    //curl_close($ch);
    
    // Process your response here
    //echo $response;

    }
}
