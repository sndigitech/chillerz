<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\UserCreated;
use Twilio\Rest\Client;
use App\Models\User;
use App\Models\VerifyUser;
use App\Models\Vendor;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Str;
use App\Mail\EmailVerification;
use App\Mail\OtpVerification;
use App\Models\UserProfile;

class UserController extends Controller
{
    public function __construct()
    {
       $this->userModel = new User();
       $this->vendorModel = new Vendor();
    }

    // complete profile details
    /**
     * email or mobile no
     * user_type
     * Bearer token
     * Method POST
     */
    public function profileDetail(Request $request){

        $validator = Validator::make($request->all(), [
            'user_type' => 'required',
            'email' => 'required'                                 
        ]);
        if ($validator->fails()) {           
            return response()->json(['success' => false, 'message' =>$validator->errors(), 'status' => 404]);
        }
        try{
            $userEmail = $request->email;
            $userType = $request->user_type;          
            if(!empty($userType == 1)){
                // create user profile                
                $id = User::where('email', $userEmail)->first(['id'])->id; // get specific value 
                $userProfileArray = ['user_id' => $id, 'email' => $userEmail, 'user_type' => $userType];
                $uprofile = UserProfile::create($userProfileArray);
                if($uprofile){
                    $updateType = User::where('email', $userEmail)->update(['user_type' => $userType]); 
                    if($updateType){
                        return response()->json(['success' => true, 'message' =>'user profile updated.', 'status' => 200]);  
                    }                   
                }                              
                return response()->json(['success' => true, 'message' =>'user profile', 'status' => 200]);
            }

            // cheking for vendor type
            if(!empty($userType == 2)){
                return response()->json(['success' => true, 'message' =>' vendor profile', 'status' => 200]);                
            }

        }catch (\Throwable $e) {
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);                     
        }
    }

    // verify otp API/OK/2  
    public function otpVerify(Request $request){                      
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
            'emailormobile' => 'required'                                 
        ]);
        if ($validator->fails()) {           
            return response()->json(['success' => false, 'message' =>$validator->errors(), 'status' => 404]);
        }
        try{
            $emailData = null;
            $mobileData = null;
            $checkVerify = null;
            $user_otp = $request->otp; // get otp from user
            $emailOrMobile = $request->emailormobile; // getting email or mobile no.

            // verify OTP that on send at email
            if(filter_var($emailOrMobile, FILTER_VALIDATE_EMAIL)){                
                $emailData = User::where('email', $emailOrMobile)->first();
                $dbOtp = $emailData->otp;
                $checkVerify = $emailData->isVerified;
                $verify = null;

                if (!empty($dbOtp == $user_otp)) {
                    $data = array();
                    if (!empty($checkVerify)) {
                        return response()->json(['success' => true, 'message' => 'OTP already verified.', 'status' => 409]);                    
                    } else {
                        // Generate Bearer token 
                        $tokenResult = $emailData->createToken('chillerz');
                        //$token = $tokenResult->token;
                        $data['access_token']   =   $tokenResult->accessToken;
                        $data['token_type']     =   'Bearer';
                        $data['expires_at']     =   $tokenResult->token->expires_at->toDateTimeString();
                        $data['email']          =   $emailData->email;                            
                        $data['msg']  = 'OTP verified'; 
                        
                        if(is_array($data) != null){
                            $emailData->isVerified = 1;
                            $verify = $emailData->save();
                            if(!empty($verify)){                                
                                return response()->json(['success' => true, 'message' => $data, 'status' => 200]);
                            }else{
                                return response()->json(['success' => false, 'message' => 'OTP not verified.', 'status' => 409]); 
                            }
                        }                  
                   }                   
                } else {
                    return response()->json(['success' => false, 'message' => 'OTP is not valid', 'status' => 404]);                   
                }                
            }

            // for mobile
            if(preg_match('/^[0-9]{10}+$/', $emailOrMobile)){
                $mobile = $emailOrMobile;
                $mobileData = User::where('mobile', $mobile)->first();
                //$mobileNo = $mobileData->mobile; 
                $checkVerify = $mobileData->isVerified;
                $dbOtp = $mobileData->otp;
                if (!empty($dbOtp == $user_otp)) {
                    $data = array();
                    if (!empty($checkVerify)) {
                        return response()->json(['success' => true, 'message' => 'OTP already verified.', 'status' => 409]);                    
                    }
                    else {
                        // Generate Bearer token 
                        $tokenResult = $mobileData->createToken('chillerz');
                        //$token = $tokenResult->token;
                        $data['access_token']   =   $tokenResult->accessToken;
                        $data['token_type']     =   'Bearer';
                        $data['expires_at']     =   $tokenResult->token->expires_at->toDateTimeString();
                        $data['mobile']          =   $mobileData->mobile;                            
                        $data['msg']  = 'OTP verified'; 
                        
                        if(is_array($data) != null){
                            $mobileData->isVerified = 1;
                            $verify = $mobileData->save();
                            if(!empty($verify)){                                
                                return response()->json(['success' => true, 'message' => $data, 'status' => 200]);
                            }else{
                                return response()->json(['success' => false, 'message' => 'OTP not verified', 'status' => 409]); 
                            }
                        }                  
                   }                   
                }
                else{
                    return response()->json(["status" => false, "message" => 'Invalid input.', "status" => 400]);
                }          
            }
        }catch (\Throwable $e) {
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);                     
        }   
    } //otpVerify

    // login and registration api/OK/1
    public function loginRegister(Request $request){       
        try{           
            $source = $request->source;            
            $emailormobile = $request->emailormobile;

            // for manual
            if($source == 'manual'){
                // for email
                if(filter_var($emailormobile, FILTER_VALIDATE_EMAIL)){
                    $newUser = null;                                            
                    $uEmail = $emailormobile;  
                    $emailData = User::where('email', $uEmail)->first();                    
                    // if email is already exist and otp verified then send token to user                                      
                    if(!empty($emailData)){                        
                        $otpVerify = $emailData->isVerified;                        
                            if(!empty($otpVerify)){
                                $data = array();
                                // Generate Bearer token 
                                $tokenResult = $emailData->createToken('chillerz');
                                //$token = $tokenResult->token;
                                $data['access_token']   =   $tokenResult->accessToken;
                                $data['token_type']     =   'Bearer';
                                $data['expires_at']     =   $tokenResult->token->expires_at->toDateTimeString();
                                $data['email']          =   $emailData->email;                            
                                $data['msg']  = 'User exist and verified'; 
                                return response()->json(['success' => true, 'message' => $data, 'status' => 200]);
                            }                                                  
                            else{
                                return response()->json(['success' => true, 'message' => 'Email exist. Please verify OTP', 'status' => 200]);
                            }                                   
                    }else{                       
                            $otp = $this->generateNumericOTP(4);
                            $newUser = User::create(['email' => $uEmail, 'otp' => $otp, 'source' => $source]);                                                       
                            if(!empty($newUser)){
                                Mail::to($uEmail)->send(new OtpVerification($otp));
                                return response()->json(['success' => true, 'message' => 'OTP has been sent at '.$emailormobile.'. Please verify.', 'status' => 200]);                        
                            }else{
                                return response()->json(['success' => false, 'message' => 'User not created.', 'status' => 404]);                        
                            }                         
                        } 
                } 
                    // for mobile
                if(preg_match('/^[0-9]{10}+$/', $emailormobile)){                                                     
                        $mobileNo = $emailormobile; 
                        $newUser = null;                        
                        $mobileData = User::where('mobile', $mobileNo)->first(); 
                        $otp = $this->generateNumericOTP(4);  

                        //if mobile no. already exist
                        if(!empty($mobileData)){
                            //$userEmail = $userData->email;
                            $otpVerify = $mobileData->isVerified;                        
                            if(!empty($otpVerify)){
                                $data = array();
                                // Generate Bearer token 
                                $tokenResult = $mobileData->createToken('chillerz');
                                //$token = $tokenResult->token;
                                $data['access_token']   =   $tokenResult->accessToken;
                                $data['token_type']     =   'Bearer';
                                $data['expires_at']     =   $tokenResult->token->expires_at->toDateTimeString();
                                $data['email']          =   $mobileData->mobile;                            
                                $data['msg']  = 'User exist and verified'; 
                                return response()->json(['success' => true, 'message' => $data, 'status' => 200]);
                            }                                                  
                            else{
                                return response()->json(['success' => true, 'message' => 'Mobile exist. Please verify OTP', 'status' => 200]);
                            }                         
                        }else{                       
                            $newUser = User::create(['mobile' => $mobileNo, 'otp' => $otp, 'source' => $source]);
                            if (!empty($newUser)) {
                                $message = 'Please use OTP '.$otp;
                                $account_sid = env('TWILIO_SID');            
                                $auth_token = env('TWILIO_TOKEN');                       
                                $twilio_number = env('TWILIO_FROM');           
                                $client = new Client($account_sid, $auth_token);            
                                $receiverNumber = '+91'.$mobileNo;                        
                                $successMsg = $client->messages->create(
                                $receiverNumber,
                                array(
                                    'from' => $twilio_number,				
                                    'body' => $message
                                    )
                                );        
                                if(!empty($successMsg)){               
                                    return response()->json(['success' => true, 'message' => 'OTP has been sent at mobile '.$mobileNo." , Please verify", 'status' => 200]);
                                }        
                            } else {
                                return response()->json(['success' => false, 'message' => 'User not created.', 'status' => 404]);
                            }                                          
                        }                                                                                        
                    } // for mobile               
                    else{
                        return response()->json(['success' => false, 'message' => 'invalid input ', 'status' => 400]);
                    }                
                } // manual            

            // whenever request comes from social
            if($source == 'social'){ 
                // add logic for social
                return response()->json(['success' => true, 'message' => 'user from social platform', 'status' => 200]);              
            } // social
            else{
                return response()->json(['success' => false, 'message' => 'invalid input', 'status' => 400]);
            }
        }catch (\Exception $e) {          
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);           
        }
    } // loginRegister   
    
    
    /**
     * user profile API
     * 
     * API endpoint register
     * user_type as 1 => user, 2 => vendor /owner, 3 => organizer, 4 => artist /performer
     * @params name, email, password and mobile no.
     * 
     */
    public function register(Request $request)
    {                       
        $validator = Validator::make($request->all(), [          
            'emailormobile' => 'required',
            'user_type' => 'user_type',                                   
        ]);
        if ($validator->fails()) {           
            return response()->json(['success' => false, 'message' => $validator->errors(), 'status' => 422]);
        }

        try{           
            $userType = $request->user_type;
            $emailOrMobile = $request->emailormobile;
            if(filter_var($emailOrMobile, FILTER_VALIDATE_EMAIL)){
                // check for user type
                if($userType == 1){ // update user_type at users table for email or mobile                                             
                    $updatedUserType = User::where('email', $emailOrMobile)->update(['user_type' => $userType]);
                    if(!empty($updatedUserType)){
                        // check user profile if not completed then send to profile complete
                        $profile_Status = '?';
                        if($profile_Status == 'completed')
                        {
                            // go to dashboard
                            return response()->json(["status" => true, "message" =>'Welcome to user dashboard', "status" => 200]);
                        }else{
                            return response()->json(["status" => false, "message" =>'Please complete profile', "status" => 400]);
                        }
                    }else{
                        return response()->json(["status" => false, "message" =>'invalid input', "status" => 400]); 
                    }                
                }
                if($userType == 2){
                    $updatedUserType = User::where('email', $emailOrMobile)->update(['user_type' => $userType]);
                    if(!empty($updatedUserType)){
                        // check user profile if not completed then send to profile complete
                        $profile_Status = '?';
                        if($profile_Status == 'completed')
                        {
                            // go to dashboard
                            return response()->json(["status" => true, "message" =>'Welcome to owner dashboard', "status" => 200]);
                        }else{
                            return response()->json(["status" => false, "message" =>'Please complete profile', "status" => 404]);
                        }                       
                    }else{
                        return response()->json(["status" => false, "message" =>'invalid input', "status" => 400]); 
                    }   
                }
                if($userType == 3){
                    // update user_type at users table for email or mobile
                }
                if($userType == 4){
                    // update user_type at users table for email or mobile
                }
                else{
                    return response()->json(['success' => false, 'message' => 'Plaese enter correct user type.', 'status' => 404]);
                }
            }
           
        }catch (\Throwable $e) {
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);                     
        }         

        $lastInsertedId = NULL;           
            try{
                
                //dd($request->all());      
                          
                if($request->user_type == 2){
                    $InsertedId = json_decode( json_encode($this->userModel->getLastInsertedUserId()), true);
                    $lastInsertedId = $InsertedId['id'];               
                    if($request->vendor_type == 2 || $request->vendor_type == 3 || $request->vendor_type == 4){
                        return response()->json(['success' => false, 'message' => 'Enter valid vendor type.', 'status' => 422]);
                    }
                    Vendor::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'mobile' => $request->mobile,                            
                        'vendor_type' => $request->vendor_type,
                        'vendor_id' =>  $lastInsertedId,                
                    ]);              
                }

                /*VerifyUser::create([
                    'user_id' => $user->id,               
                    'token' => Str::random(40) 
                ]);*/ 

                Mail::to($user->email)->send(new EmailVerification($user)); // Send Email for account verification            
                $msg = "We have sent a confirmation mail to your email. Please check your inbox.";            
                if(!empty($user)){               
                    return response()->json(['success' => true, 'data' => array('user' => $user, 'message' => $msg, 'status' => 201)]);
                }else{              
                    return response()->json(['success' => false, 'message' => 'User not registered.', 'status' => 401]);
                }
            }catch (\Exception $e) {            
                return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400,]);        
            }
    }


    /*
    * API to verify user by sending token to the mail /OK
    * @param custom token
    *
    */
    public function verifyUser(Request $request)
    {       
        $validator = Validator::make($request->all(), [
            'token' => 'required'           
        ]);
        if ($validator->fails()) {           
            return response()->json(['success' => false, 'message' =>$validator->errors(), 'status' => 422]);
        }
        try{
         // getting custom token 
         $token = $request->token;       
         $verifyUser = VerifyUser::where('token', $token)->first();
         //dd($verifyUser);
         if (isset($verifyUser)) {
             $user = $verifyUser->user;           
             if (!$user->isVerified) {
                 $verifyUser->user->isVerified = 1;
                 $verifyUser->user->save();
                 $status = "Your e-mail is verified. You can now login.";
             } else {
                 $status = "Your e-mail is already verified. You can now login.";
             }
         } else {           
            return response()->json(['success' => false, 'message' => 'Sorry your email cannot be identified.', 'status' => 404]);
         }       
         return response()->json(['success' => true, 'message' => $status, 'status' => 200]); 
        }catch (\Exception $e){           
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    /**
     *  User Login API / OK
     * 
     * API endpoint login  
     * @param emailormobile    
     * 
     */
    public function getEmailOrMobile(Request $request) 
    {                        
        $validator = Validator::make($request->all(), [                   
            'emailormobile' => 'required',
            //'user_type' => 'required|numeric',           
        ]);        
        if ($validator->fails()) {            
            return response()->json(['success' => false, 'message' => $validator->errors(), 'status' => 422]);
        }        
        try{
            $emailormobile = $request->emailormobile;
            $otp = $this->generateNumericOTP(4); 
            
            if(filter_var($emailormobile, FILTER_VALIDATE_EMAIL)){ // validation for email format and update otp                            
                $userData = User::where('email', $emailormobile)->first();                                                         
                if ($emailormobile) {
                    $userId = $userData->id; //getting user id                                     
                    VerifyUser::where('user_id', $userId)->update(['otp' => $otp]);                 
                    Mail::to($emailormobile)->send(new OtpVerification($otp)); // Send Email for account verification
                    $msg = "OTP has been send successfully at your email-id ".$emailormobile;
                    return response()->json(['success' => true, 'message' => $msg, 'status' => 200]);                           
                } else {
                    return response()->json(['success' => false, 'message' => 'OTP is not generated, Something is wrong.', 'status' => 404]);                    
                    
                }
            }
            
            if(preg_match('/^[0-9]{10}+$/', $emailormobile)) { // validation for mobile format and update otp             
                $userData = User::where('mobile', $emailormobile)->first();                
                if($emailormobile){                          
                    $mobileNo = $emailormobile;            
                    $message = 'Please use OTP '.$otp;
                    $account_sid = env('TWILIO_SID');            
                    $auth_token = env('TWILIO_TOKEN');                       
                    $twilio_number = env('TWILIO_FROM');           
                    $client = new Client($account_sid, $auth_token);            
                    $receiverNumber = '+91'.$mobileNo;
                    $successMsg = $client->messages->create(
                        $receiverNumber,
                        array(
                            'from' => $twilio_number,				
                            'body' => $message)
                    );        
                    if(!empty($successMsg)){               
                        return response()->json(['success' => true, 'message' => 'OTP has been sent at '.$mobileNo, 'status' => 200]);
                    }
                }else{              
                    //return response()->json(['success' => false, 'message' => 'OTP not generated successfully.', 'status' => 404]);
                    return redirect()->route('register.api');//->with('message', 'Please register !!');
                }                             
            }
        }catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);                     
        }          
    }
    

    /**
     * VerifyOTP API / OK
     * 
     * 
     */
    public function verifyOtp(Request $request){        
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric|min:4'                                 
        ]);
        if ($validator->fails()) {           
            return response()->json(['success' => false, 'message' =>$validator->errors()]);
        }
        try{
            $user_otp = $request->otp; // get otp from user
            if (!empty($user_otp)) {          
                $otpData = VerifyUser::where('otp', $user_otp)->first();
                $db_otp = $otpData->otp; 
                if($db_otp == $db_otp){
                    $userId = $otpData->user_id;                
                    $user = User::find($userId);               
                    if(!empty($user)){    
                        $tokenResult = $user->createToken('newchillerz');
                        //$token = $tokenResult->token;
                        $data['access_token']   =   $tokenResult->accessToken;
                        $data['token_type']     =   'Bearer';
                        $data['expires_at']     =   $tokenResult->token->expires_at->toDateTimeString();
                        $data['email']          =   $user->email;               
                        $data['name']           =   $user->name; 
                        $data['message']  = 'OTP verified, User login successfully';              
                    }
                    return response()->json(['success' => true, 'data' =>$data, 'status' => 200]);
                }           
            } else {
                return response()->json(['success' => false, 'message' =>'OTP not verified.', 'status' => 404]);
            }    
        }catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);                     
        }   
    }


    /**
    * Update password API /OK
    */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',           
            'newpassword' => 'required|string|min:5'
        ]);
        if ($validator->fails()) {           
            return response()->json(['success' => true, 'message' =>$validator->errors()]);
        }
        if(strcmp($request->password, $request->newpassword) == 0){           
            return response()->json(['success' => true, 'message' =>'Password cannot be same as your current password.']);
        }      
        try{                
            $res = User::find(auth()->user()->id)->update(['password' => Hash::make($request->newpassword)]);
            if(!empty($res)){               
                return response()->json(['success' => true, 'message' =>'Password updaded.']);
            }else{            
                return response()->json(['success' => true, 'message' =>'Password not updaded.']);
            }
        }catch (\Exception $e){
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    /**
     * forgot password generate link api 
     */
    public function forgot(Request $request)
    {       
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'           
        ]);
        if ($validator->fails()) {           
            return response()->json(['success' => false, 'message' => $validator->errors()]);
        }
        try
        {
            $email = $request->email;
            $chars = "0123456789";
            $password = substr(str_shuffle($chars), 0, 8); 
            $str_to_hashed = $email.$password;
            $hashed = Hash::make($str_to_hashed);         
            $emailDetail = User::where('email', $email)->first();
            $mailDetails = array();
            if(isset($emailDetail)){               
                $date = DATE('Y-m-d H:i:s');
                $tokenData = array('token'=> $hashed);               
                $updateToken = User::where('email', $email)->update($tokenData);                
                if(isset($updateToken)){
                    $forgotLink = config('app.url').'/forgotpassword/'.$hashed;               
                    $mailDetails = array('resetLink' => $forgotLink, 'to_mail' => $email);                                     
                    Mail::to($email)->send(new ForgotPasswordMail($mailDetails));                   
                    return response()->json(['success' => true, 'message' => 'Email Sent.']);                
                }else{                    
                    return response()->json(['success' => false, 'message' => 'Token not updated.']);
                }               
            }else{               
                return response()->json(['success' => false, 'message' => 'Please enter valid email address.']);
            }           
        } catch (\Exception $e){            
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }        
    }


    /**
     * forgot password reset api  
     */
    public function forgotPasswordValidate(Request $request)
    {       
        $token = $request->token;        
        $userDetail = User::where('token', $token)->first();                     
        $db_token = $userDetail['token'];
        if ($db_token == $token) {           
            $emailBasedOnToken = $userDetail['email'];          
            $validator = Validator::make($request->all(), [                        
                'newpassword' => 'required|string|min:8|confirmed'
            ]);
            if ($validator->fails()) {              
                return response()->json(['success' => false, 'message' => $validator->errors()]);
            }
            $confirmPassword = $request->newpassword;           
            if($confirmPassword == ''){                
                return response()->json(['success' => false, 'message' => 'Password cannot be blank.']);
            }
            try{           
                $hasedPassword = Hash::make($confirmPassword);
                $data = array('password' => $hasedPassword, 'token' => '');               
                $res = User::where('email', $emailBasedOnToken)->update($data);
                if(!empty($res)){                  
                    return response()->json(['success' => true, 'message' =>'Password Changed Successfully.']);
                }else{                    
                    return response()->json(['success' => true, 'message' =>'Password not updated.']);
                }
            }catch (\Exception $e){               
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }            
        } else {            
            return response()->json(['success' => false, 'message' => 'Token is not correct']);
        }
    }
    
    
    /**
     * otp verify API
     * 
     * @param $otp
     */
    public function verifyOtp_x(Request $request)
    {
        //echo $request->verify_otp;
        $validator = Validator::make($request->all(), [
            'verify_otp' => 'required|numeric|min:4'           
        ]);
        if ($validator->fails()) {           
            return response()->json(['success' => false, 'message' =>$validator->errors()]);
        }

        if (!empty($request->verify_otp)) {            
            return response()->json(['success' => true, 'message' =>'Verified Successfully']);
        } else {
            return response()->json(['success' => false, 'message' =>'Please verify otp']);
        }        

    }

    public function getUser($id) {
        try{
            $user = User::find($id);
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User does not exist']);
            }
    
            return response()->json(['success' => true, 'user' => new UserResource($user)]);    

        }catch (\Exception $e){               
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }       
    }

    public function getUsers () {
        try{
            $users = User::get();
            return response()->json(['success' => true, 'users' => new UserCollection($users)]);

        }catch (\Exception $e){               
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }       
    }
    

    /**
     * logout api
     */
    public function logOut(Request $request)
    {        
        $token = $request->user()->token();  
        //echo $token;
        $revSuccess = $token->revoke(); 
        if (isset($revSuccess)) {            
            return response()->json(['success' => true, 'message' =>'User logged out successfully.']);
        } else {            
            return response()->json(['success' => false, 'message' =>'Password not updated.']);
        }        
    } 

        // generate unique OTP
    public function generateNumericOTP($n) {       
        $generator = "1357902468";   
        $result = "";  
        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        }      
        return $result;
    }

     /**
     * API to sent OTP at e-mail
     * 
     * @endpoint emailotp
     * method POST  
     * @param $emailormobile     
     * 
     */
    public function emailOtp(Request $request){
        try {
            $otpMessage = $this->generateNumericOTP(4);           
            $emailID = $request->emailormobile;            
            $message = 'Please use OTP '.$otpMessage;
            //$user = array('email' => $emailID, 'otp' => $message);
            $user = new User([                
                'email' => $emailID,               
                'otp'=>$message,                
            ]);
            if (!empty($emailID)) {
                 // now, fire events
                event(new UserCreated($user));
                return response()->json(['success' => true, 'message' => 'OTP has been sent at '.$emailID]);
            } else {
                return response()->json(['success' => false, 'message' => 'Please enter valid email.']);               
            }
           
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);                     
        }
    }


    /**
     * API to sent OTP at mobile
     * 
     * @endpoint mobileotp
     * method POST  
     * @param emailormobile    
     * 
     */
    public function mobileOtp(Request $request)
    {                
        try{ 
            $otpMessage = $this->generateNumericOTP(4);           
            $mobileNo = $request->emailormobile;            
            $message = 'Please use OTP '.$otpMessage;
            $account_sid = env('TWILIO_SID');            
		    $auth_token = env('TWILIO_TOKEN');                       
            $twilio_number = env('TWILIO_FROM');           
		    $client = new Client($account_sid, $auth_token);            
            $receiverNumber = '+91'.$mobileNo;
            $successMsg = $client->messages->create(
                $receiverNumber,
                array(
                    'from' => $twilio_number,				
                    'body' => $message
                )
            );

            if(!empty($successMsg)){               
                return response()->json(['success' => true, 'message' => 'OTP has been sent.']);
            }else{              
                return response()->json(['success' => false, 'message' => 'OTP has not been sent.']);
            }
        }catch (\Exception $e){            
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        } 
	}
    
    
    /**
     * Login Api 
     * 
     * @param email or mobile no.
     */    
    public function genOtp(){
        echo 'generate otp';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
