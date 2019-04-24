<?php

namespace App\Http\Controllers;

use App\Application;
use App\Job;
use App\Jobs\JobTranscation;
use App\Transcation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::check()) {
            $jobs = array();
            foreach (Job::where('active',1)->where('owner_id','!=',Auth::id())->with('user')->with('forecast')->get() as $job) {
                if (Application::where('job_id', $job->id)->where('applicant_id', Auth::id())->exists()) {

                }else{
                    array_push($jobs, $job);
                }

            }

            return response()->json(['data' => collect($jobs)->map(function ($job){
               return [  'job'=>$job,
                       'forecast'=>$job->forecast->filter(function ($forecast){
                    return str_contains($forecast->time,now()->toDateString());
                })->values()];
            })]);
        } else {
            return response()->json(['data' => collect(Job::with('forecast')->get())->map(function ($job){
                return[
                    collect($job)->filter(function ($job){
                        return !$job->forecast;
                    }),
                    $job->forecast->filter(function ($forecast){

                })];
            })]);

        }
    }

    public function job(Request $request, $id)
    {
        return Job::where('id', $id)->first();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'start_time' => 'required',
            'rules' => 'required',
            'duration' => 'required|integer',
            'pay_amount' => 'required',
            'job_location_address' => 'required'
        ]);
        if (Auth::check()) {
            dd($this->lipa_na_mpesa());
            $job = Job::create([
                'title' => $request->input('title'),
                'owner_id' => Auth::id(),
                'description' => $request->input('description'),
                'start_time' => $request->input('start_time'),
                'rules' => $request->input('rules'),
                'duration' => $request->input('duration'),
                'pay_amount' => $request->input('pay_amount'),
                'job_location_address' => serialize($request->input('job_location_address')),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
            return response()->json(['data'=>$job]);

        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }


    }

    public function generateToken(){
        $consumer_key=env('MPESA_CONSUMER_KEY');
        $consumer_secret=env('MPESA_CONSUMER_SECRET');
        $mpesa_env=env('MPESA_ENV');

        //check if both keys are set
        if(!$consumer_key || !$consumer_secret){
            echo 'No consumer key or consumer secret is defined in the .env file';
        }
        else{

            //else perform token generation
            if ($mpesa_env=='sandbox'){
                $url='https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
            }
            elseif ($mpesa_env=='live'){
                $url='https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
            }
            else{
                echo 'Mpesa environment is undefined in .env file. Set your environment as either sandbox or live';
            }
            $curl=curl_init();
            curl_setopt($curl,CURLOPT_URL,$url);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            $credentials = base64_encode($consumer_key.':'.$consumer_secret);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $curl_response = curl_exec($curl);

            return json_decode($curl_response)->access_token;


        }




    }

    public function lipa_na_mpesa(){
        $BusinessShortCode=174379;
        $Passkey='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $TransactionType='CustomerPayBillOnline';
        $Amount=400;
        $PartyA=Auth::user()->phone;
        $PartyB=174379;
        $PhoneNumber=Auth::user()->phone;
        $CallBackURL='http://daraja-api.herokuapp.com/c2b/validation';
        $AccountReference='One Day Jobs Kenya';
        $TransactionDesc='Testing';


        $mpesa_env=env('MPESA_ENV');
        if($mpesa_env=='sandbox'){
            $url='https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        }
        elseif ($mpesa_env=='live'){
            $url='https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        }
        else{
            return json_encode(['error message'=>'invalid mpesa environment']);
        }
        $access_token=self::generateToken();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values

            'BusinessShortCode' => $BusinessShortCode,
            'Password' => base64_encode($BusinessShortCode.$Passkey.date("YmdHis")),
            'Timestamp' =>date("YmdHis"),
            'TransactionType' => $TransactionType,
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => $PartyB,
            'PhoneNumber' => $PhoneNumber,
            'CallBackURL' => $CallBackURL,
            'AccountReference' => $AccountReference,
            'TransactionDesc' => $TransactionDesc,
        );
        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);

        return $curl_response;




    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
