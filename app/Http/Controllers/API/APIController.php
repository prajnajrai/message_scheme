<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;
use App\Campaign;
use App\ReceivedSmsLog;
use App\SentSmsLog;
use Carbon\Carbon;
use App\CampaignCodeList;

class APIController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function getHello()
    {
        return 'hello world';
    }

    public function testSendSms() {
        $mobilenumber = "9964864032";
        $reply_sms_content = "Prajna Testing this";
        $sms_sender_username = "600010";

        $this->sendSMSTest();
    }

    public function receiveSms(Request $request){
        if(!isset($request->sender) || !isset($request->content) || !isset($request->rcvd)){
            // return "Please provide 'mobilenumber', 'message', 'receivedon' parameters.";
        }

        //{"sender":"919964864032","content":"Testing this","inNumber":"919293211113","submit":"Submit","network":null,"email":"none","keyword":null,"comments":"Testing this","credits":"1004","msgId":"8436607156","rcvd":"2021-11-27 08:14:49","firstname":null,"lastname":null,"custom1":null,"custom2":null,"custom3":null}
        
        // $a= json_encode($request->all());
        // $b = json_decode($a, TRUE);

        #Check for Valid Request URL.

       //return $request->all();

        // $received_time = isset($request->receivedon) ? Carbon::createFromFormat('m/d/Y g:i:s A', $request->receivedon)->format('Y-m-d H:i:s') : null;
        //   return $received_time;

        $APP_ENV = env('APP_ENV', 'DEMO');
        $code = "";
        // if($APP_ENV=="DEMO"){
        //     $split_message = explode(" ", $request->content);
        //     if(isset($split_message[1])){
        //         $code = $split_message[1];
        //     }else{
        //         $code = $request->content;
        //     }
        // }else{
            $code = $request->content;
        // }
        
        $status = "VALID";
        $today = Carbon::now()->format('Y-m-d');
        $random_code = "FALSE";

        $client = Client::where('status', 'ACTIVE')->first();
        $campaign = Campaign::where('status', 'ACTIVE')->first();

        if($random_code=="TRUE"){
            $campaign_code = CampaignCodeList::where('campaign_id', $campaign->id)->where('code', $code)->first();
            if(!is_null($campaign_code) && $campaign_code->status=='USED'){ #check whether received code already used based on the status. if used, send message saying already code has been received. (duplicate code)
                $status = "REPEAT";
            }else{#check whether received code exist in campaign code list table. If not exist send message saying Invalid Code.
                $status = "INVALID";
            }
        }else{
            $min = "0000001";
            $max = "1600000";
            $random_code = "FALSE";


            //A string containing two integer values.
            $str = $code;
            //Extract the numbers using the preg_match_all function.
            preg_match_all('!\d+!', $str, $matches);
            //Any matches will be in our $matches array
            // return $matches[0];
            if(count($matches[0])>0) {
                foreach ($matches[0] as $key => $value) {
                    // foreach ($match as $jkey => $value) {
                       $code = $value;
                        if(($min <= $value) && ($value <= $max)){
                            if(strlen($value)!=7){
                                $status = "INVALID";
                            }else{
                                $receivedSmsLog = ReceivedSmsLog::where('campaign_code', $value)->first();
                                if(!is_null($receivedSmsLog)){
                                    $status = "REPEAT";
                                }else{
                                    $status = "VALID";
                                }
                            }
                        }else{
                            $status = "INVALID";
                        }
                    // }
                }
            } else {
                $status = "INVALID";
            }

            // $value = $code;
            // if(($min <= $value) && ($value <= $max)){
            //     if(strlen($value)!=7){
            //         $status = "INVALID";
            //     }else{
            //         $receivedSmsLog = ReceivedSmsLog::where('campaign_code', $value)->first();
            //         if(!is_null($receivedSmsLog)){
            //             $status = "REPEAT";
            //         }else{
            //             $status = "VALID";
            //         }
            //     }
            // }else{
            //     $status = "INVALID";
            // }
        }
        

        if((!is_null($campaign->end_date)) && $campaign->end_date < $today){ #check whether campaign expired
            $status = "EXPIRED";
        }
        
        #Store in DB
        $receivedSmsLog = new ReceivedSmsLog();
        $receivedSmsLog->campaign_id = $campaign->id;
        $receivedSmsLog->sent_mobile = $request->sender;
        $receivedSmsLog->campaign_code = $code;
        $receivedSmsLog->sms_content = $request->content;
        $receivedSmsLog->request_parameter = json_encode($request->all());
        #08\/08\/2019 11:48:36 AM
        $received_time = $request->rcvd;
//? Carbon::createFromFormat('m/d/Y g:i:s A', $request->datetime)->format('Y-m-d H:i:s') : null;
        $receivedSmsLog->received_time = $received_time;//Carbon::now();
        $receivedSmsLog->location = $request->location;
        $receivedSmsLog->status = $status;
        $receivedSmsLog->save();

        #Send Reply to the sender
        $reply_sms_content = '';
        $send_sms = "TRUE";
        #Dear Customer, * . Regards, SriAnaghaRefineries
        if($status=='VALID'){
            
            if($random_code=="TRUE" && !is_null($campaign_code)){
                // $campaign_code = new CampaignCodeList();
                // $campaign_code->campaign_id = $campaign->id;
                // $campaign_code->code = $request->content;
                $campaign_code->status = 'USED';
                $campaign_code->save();
            }
            
            #Dear Customer, *. Thank you for using Sun Premium SunflowerOil

            //Dear Customer, this code has been already used, please try with different code. Thank you for using Sun Premium SunflowerOil


            //Dear Customer, invalid code entered, please try again. Thank you for using Sun Premium SunflowerOil

            //Dear Customer, thank you for your participation. We will draw the winners on 0ct 31st, keep the empty pouch with you until results are announced. All the best. Thank you for using Sun premium SunflowerOil

            $reply_sms_content = "Dear Customer, thank you for your participation. We will draw the winners on 0ct 31st, keep the empty pouch with you until results are announced. All the best. Thank you for using Sun Premium SunflowerOil";
        }elseif($status=='INVALID'){
            $reply_sms_content = "Dear Customer, invalid code entered, please try again. Thank you for using Sun Premium SunflowerOil";
        }elseif($status=='REPEAT'){
            $reply_sms_content = "Dear Customer, this code has been already used, please try with different code. Thank you for using Sun Premium SunflowerOil";
        }elseif($status=='EXPIRED'){
            $reply_sms_content = "Dear Customer, sorry!!! The contest has been expired. Thank you for using Sun Premium SunflowerOil";
            // $send_sms = "FALSE";
        }

        if($send_sms=="TRUE"){
            #send SMS here
           $this->sendSMSTextLocal($client->sms_sender_password,$request->sender,$client->sms_sender_username,$reply_sms_content);

            #Store in DB
            $send_sms_log = new SentSmsLog();
            $send_sms_log->received_sms_log_id = $receivedSmsLog->id;
            $send_sms_log->sms_content = $reply_sms_content;
            $send_sms_log->sent_time = Carbon::now();
            $send_sms_log->save();

            return 'success';

            // \Debugbar::disable();

            // return $reply_sms_content; 
        }



    }

    public function insertCampaignCode(Request $request){
        $begin = 1;
        for ($i=$begin; $i <= 1600000; $i++) { 
            $campaign_code = CampaignCodeList::where('code', $i)->where('campaign_id', $request->campaign_id)->first();
            if(is_null($campaign_code)){
                if(strlen($i) == 1){
                    $i = "000000".$i;
                }elseif(strlen($i) == 2){
                    $i = "00000".$i;
                }elseif(strlen($i) == 3){
                    $i = "0000".$i;
                }elseif(strlen($i) == 4){
                    $i = "000".$i;
                }elseif(strlen($i) == 5){
                    $i = "00".$i;
                }elseif(strlen($i) == 6){
                    $i = "0".$i;
                }
                $campaign_code = new CampaignCodeList();
                $campaign_code->campaign_id = $request->campaign_id;
                $campaign_code->code = $i;
                $campaign_code->status = "NOT_USED";
                $campaign_code->save();
            }
        }
        return response()->json(['message' => 'Campaign code updated successfully']); 
    }

    public function getReceievedSMSList(Request $request){
        $today =  Carbon::now()->format('Y/m/d');

        if(isset($request->campaign_id)){
            $received_sms_list = ReceivedSmsLog::where('campaign_id', $request->campaign_id)->whereDate('received_time', '>=', $today)->whereDate('received_time', '<=', $today)->orderBy('id', 'desc')->get();
        }else{
            $received_sms_list = ReceivedSmsLog::whereDate('received_time', '>=', $today)->whereDate('received_time', '<=', $today)->orderBy('id', 'desc')->get();
        }
        
        $fromdate = Carbon::now()->format('d-m-Y');
        $to_date = Carbon::now()->format('d-m-Y');
        return view('sms-list', compact('received_sms_list', 'fromdate', 'to_date'));
    }

    public function searchReceievedSMSList(Request $request){
        // return $request->all();
        $fromdate = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y/m/d');
        $to_date = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y/m/d');
        $status = $request->status;

        if($status=="ALL"){
            if(isset($request->campaign_id)){
                $received_sms_list = ReceivedSmsLog::where('campaign_id', $request->campaign_id)->whereDate('received_time', '>=', $fromdate)->whereDate('received_time', '<=', $to_date)->orderBy('id', 'desc')->get();
            }else{
                $received_sms_list = ReceivedSmsLog::whereDate('received_time', '>=', $fromdate)->whereDate('received_time', '<=', $to_date)->orderBy('id', 'desc')->get();
            }
        }else{
            if(isset($request->campaign_id)){
                $received_sms_list = ReceivedSmsLog::where('campaign_id', $request->campaign_id)->whereDate('received_time', '>=', $fromdate)->whereDate('received_time', '<=', $to_date)->where('status', $request->status)->orderBy('id', 'desc')->get();
            }else{
                $received_sms_list = ReceivedSmsLog::whereDate('received_time', '>=', $fromdate)->whereDate('received_time', '<=', $to_date)->where('status', $request->status)->orderBy('id', 'desc')->get();
            }
        }
        
        $fromdate = $request->from_date;
        $to_date = $request->to_date;

        return view('sms-list', compact('received_sms_list', 'fromdate', 'to_date', 'status'));
    }
}
