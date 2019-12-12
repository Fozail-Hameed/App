<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\UserController;
use App\User;
use Session;
use Auth;
use Hash;
use Image;
// use App\Http\Controllers\Hash;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\file;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
       $this->middleware('auth:api');
    }
    
    public function index()
    {
         // if(Auth::attempt(['email' => request('email'), 'type' =>request('Admin') ==true)])){
        // $users = User::all()->get();
        // echo "<pre/>"; print_r($users); echo "<pre/>"; exit();
        return User::latest()->paginate(10);
    // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $name = $request->name;
        $email = $request->email;
        $password = bcrypt($request->password);
        $bio = $request->bio;
        $type = $request->type;
       // if (Input::hasFile('photo')) {
       //     $file = Input::file('photo');
       //      $file->move('uploads/User', $file->getClientOriginalName());
       //      $image = $file->getClientOriginalName();
       // }
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'type' => 'required'

        ]);
       $craete_user = array('name' => $name,'email' =>$email,'password'=>$password,'bio'=>$bio,'type'=>$type);
       // echo "<pre>"; print_r($post_data); echo "</pre>"; exit();
        User::insert($craete_user);
        Session::flash('message', "User Added Sucessfully");
        return Redirect::back();
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'required|min:8',
            'type' => 'required',
            ]);
        $user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $user = User::findOrFail($id)->delete();


        return ['message' => 'User is Deleted Sucessfully'];
    }
     
    public function Profile()
    {

        return auth('api')->user();
        // $user = Auth::user(); 
        // echo "<pre/>"; print_r($user); echo "<pre/>";
        // $user = Auth::User->get(); 
        // return response()->json(['success' => $user], $this-> successStatus);
      
    }
    public function ProfileUpdate(Request $request){
           // $user = auth('api')->user();
           // echo "<pre/>"; print_r($user); echo "<pre/>"; exit();
            $user = auth('api')->user();
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|min:6'
        ]);
        $currentPhoto = $user->photo;
        if($request->photo != $currentPhoto){
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(public_path('img/profile/').$name);
            $request->merge(['photo' => $name]);
            $userPhoto = public_path('img/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }
        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }
        $user->update($request->all());
        return ['message' => "Success"];

    }



}
