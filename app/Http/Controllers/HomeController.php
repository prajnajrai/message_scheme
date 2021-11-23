<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Campaign;
use App\ReceivedSmsLog;
use App\SentSmsLog;
use Carbon\Carbon;
use App\CampaignCodeList;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     return view('home');
    // }

    public function getReceievedSMSList(Request $request){
        $today =  Carbon::now()->format('Y/m/d');
        $title="SentSmsLog";

        if(isset($request->campaign_id)){
            $received_sms_list = ReceivedSmsLog::where('campaign_id', $request->campaign_id)->whereDate('received_time', '>=', $today)->whereDate('received_time', '<=', $today)->orderBy('received_time', 'desc')->get();
        }else{
            $received_sms_list = ReceivedSmsLog::whereDate('received_time', '>=', $today)->whereDate('received_time', '<=', $today)->orderBy('received_time', 'desc')->get();
        }
        
        $fromdate = Carbon::now()->format('d-m-Y');
        $to_date = Carbon::now()->format('d-m-Y');
        return view('sms-list', compact('received_sms_list','title', 'fromdate', 'to_date'));
    }

    public function searchReceievedSMSList(Request $request){
        // return $request->all();
        $fromdate = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y/m/d');
        $to_date = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y/m/d');
        $status = $request->status;
         $title="SentSmsLog";

        if($status=="ALL"){
            if(isset($request->campaign_id)){
                $received_sms_list = ReceivedSmsLog::where('campaign_id', $request->campaign_id)->whereDate('received_time', '>=', $fromdate)->whereDate('received_time', '<=', $to_date)->orderBy('received_time', 'desc')->get();
            }else{
                $received_sms_list = ReceivedSmsLog::whereDate('received_time', '>=', $fromdate)->whereDate('received_time', '<=', $to_date)->orderBy('received_time', 'desc')->get();
            }
        }else{
            if(isset($request->campaign_id)){
                $received_sms_list = ReceivedSmsLog::where('campaign_id', $request->campaign_id)->whereDate('received_time', '>=', $fromdate)->whereDate('received_time', '<=', $to_date)->where('status', $request->status)->orderBy('id', 'desc')->get();
            }else{
                $received_sms_list = ReceivedSmsLog::whereDate('received_time', '>=', $fromdate)->whereDate('received_time', '<=', $to_date)->where('status', $request->status)->orderBy('received_time', 'desc')->get();
            }
        }
        
        $fromdate = $request->from_date;
        $to_date = $request->to_date;

        return view('sms-list', compact('title','received_sms_list', 'fromdate', 'to_date', 'status'));
    }
}
