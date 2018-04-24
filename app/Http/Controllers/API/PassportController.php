<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Response;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\API\ConsoleOutput;



class PassportController extends Controller
{

    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){


        if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){
            $user = Auth::user();
            $token =  $user->createToken('MyApp')->accessToken;
            return Response::json(array('status'=>'success','token'=>$token),200);
          //  return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|min:7|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        $validationMessage =  $this->validationErrorsToString($validator->errors());

        if ($validator->fails()) {

            return Response::json(array('status'=>'error','message'=>$validator->errors()),200);

        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $token=  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;

        return Response::json(array('status'=>'success','token'=>$token),200);

    }

    public function validationErrorsToString($errArray) {
        $valArr = array();
        foreach ($errArray->toArray() as $key => $value) {
            $errStr = $value[0];
            array_push($valArr, $errStr);
        }
        if(!empty($valArr)){
            $errStrFinal = implode(' ', $valArr);
        }
        return $errStrFinal;
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetails()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }


}