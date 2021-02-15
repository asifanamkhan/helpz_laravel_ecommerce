<?php

namespace App\Http\Controllers\User;

use App\Otp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\User;
use App\Models\Notification;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;

class RegisterController extends Controller
{

    public function register(Request $request)
    {


//    	$gs = Generalsetting::findOrFail(1);
//
//    	if($gs->is_capcha == 1)
//    	{
//	        $value = session('captcha_string');
//	        if ($request->codes != $value){
//	            return response()->json(array('errors' => [ 0 => 'Please enter Correct Capcha Code.' ]));
//	        }
//    	}

        //--- Validation Section

        $rules = [
            'phone'   => 'required|unique:users',
            'password' => 'required|confirmed'
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- OTP Section
        $otp = mt_rand(1000, 9999);
        $phone = $request->phone;
        try{
            $smsUrl = "http://gosms.xyz/api/v1/sendSms?username=medylife&password=Vu3wq8e7j7KqqQN&number=(".$phone.")&sms_content=Your%20OTP%20is:%20".$otp."&sms_type=1&masking=non-masking";

            //otp table

            $otp_code = new Otp();
            $otp_code->name = $request->name;
            $otp_code->password = $request->password;
            $otp_code->email = $request->email;
            $otp_code->phone = $request->phone;
            $otp_code->otp = $otp;
            $otp_code->save();

            //--- Send api sms request

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $smsUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST,false);
            curl_exec($curl); //response output
            curl_close($curl);

            return response()->json('success');
        }
        catch (ClientException $exception){
            //otp table

            $otp_code = new Otp();
            $otp_code->name = $request->name;
            $otp_code->password = $request->password;
            $otp_code->email = $request->email;
            $otp_code->phone = $request->phone;
            $otp_code->otp = $otp;
            $otp_code->save();

            //--- Send api sms request

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $smsUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST,false);
            curl_exec($curl); //response output
            curl_close($curl);

            return response()->json('success');

        }

        //--- end OTP section

//	        $user = new User;
//	        $input = $request->all();
//	        $input['password'] = bcrypt($request['password']);
//	        $token = md5(time().$request->name.$request->email);
//	        $input['verification_link'] = $token;
//	        $input['affilate_code'] = md5($request->name.$request->email);
//			$user->fill($input)->save();

//	          if(!empty($request->vendor))
//	          {
//	            $user->is_vendor = 1;
//	            $user->update();
//	          }
//
//	        if($gs->is_verification_email == 1)
//	        {
//	        $to = $request->email;
//	        $subject = 'Verify your email address.';
//	        $msg = "Dear Customer,<br> We noticed that you need to verify your email address. <a href=".url('user/register/verify/'.$token).">Simply click here to verify. </a>";
//	        //Sending Email To Customer
//	        if($gs->is_smtp == 1)
//	        {
//	        $data = [
//	            'to' => $to,
//	            'subject' => $subject,
//	            'body' => $msg,
//	        ];
//
//	        $mailer = new GeniusMailer();
//	        $mailer->sendCustomMail($data);
//	        }
//	        else
//	        {
//	        $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
//	        mail($to,$subject,$msg,$headers);
//	        }
//          	return response()->json('We need to verify your email address. We have sent an email to '.$to.' to verify your email address. Please click link in that email to continue.');
//	        }
//	        else {
//
//            $user->email_verified = 'Yes';
//            $user->update();
//	        $notification = new Notification;
//	        $notification->user_id = $user->id;
//	        $notification->save();
//            Auth::guard('web')->login($user);
//          	return response()->json(1);
//	        }

    }

    public function resendOtp(Request $request){

        $registration_info = Otp::where('phone',$request->phone)->latest()->first();

        if($registration_info){
           //--- OTP Section
           $otp = mt_rand(1000, 9999);

           $phone = $request->phone;
           $smsUrl = "http://gosms.xyz/api/v1/sendSms?username=medylife&password=Vu3wq8e7j7KqqQN&number=(".$phone.")&sms_content=Your%20OTP%20is:%20".$otp."&sms_type=1&masking=non-masking";

           //--- Send api sms request

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $smsUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST,false);
            curl_exec($curl); //response output
            curl_close($curl);

           //otp table update

            $registration_info->update([
                'otp'=> $otp,
            ]);
           return response()->json('success');
       }
       else{
           return response('failed');
       }

    }

    public function registerOtp(Request $request){
        $registration_info = Otp::where('phone',$request->phone)
                                ->where('otp',$request->otp)->latest()->first();
        if($registration_info){
            $password = $registration_info->password;
            $user = new User;
            $user -> name = $registration_info->name;
            $user -> email = $registration_info->email;
            $user -> phone = $registration_info->phone;
            $user -> password = bcrypt($password);
            $token = md5(time().$registration_info->name.$registration_info->email);
            $user -> verification_link = $token;
            $user -> affilate_code = md5($registration_info->name.$registration_info->email);;
            $user->save();


            //delete unregistered data
            $delete_datas = Otp::where('phone',$registration_info->phone)->get();
            foreach($delete_datas as $delete_data){
                $delete_data->delete();
            }

            if(!empty($request->vendor))
            {
                $user->is_vendor = 1;
                $user->update();
            }

            $notification = new Notification;
            $notification->user_id = $user->id;
            $notification->save();
            Auth::guard('web')->login($user);
            return response()->json($registration_info);
        }
        else{
            return response()->json('failed');
        }

    }

    public function token($token)
    {
        $gs = Generalsetting::findOrFail(1);

        if($gs->is_verification_email == 1)
        {
            $user = User::where('verification_link','=',$token)->first();
            if(isset($user))
            {
                $user->email_verified = 'Yes';
                $user->update();
                $notification = new Notification;
                $notification->user_id = $user->id;
                $notification->save();
                Auth::guard('web')->login($user);
                return redirect()->route('user-dashboard')->with('success','Email Verified Successfully');
            }
        }
        else {
            return redirect()->back();
        }
    }
}
