<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data=User::all();
        // dd(print_r(["user"=>$data]));
        return response()->view('cms.users.index',["users"=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return response()-> view('cms.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd( $request->_token);
        // dd( $request->all());
        # validate
        $request->validate([
            'user_name'=>'required|string|min:3|max:20',
            'user_email'=>'required|email|unique:users,email',
            'user_address'=>'nullable|string|max:100',
            'user_password'=>[
                'required','string',
                Password::min(8)
                ->letters()
                ->numbers()
                ->symbols()
                ->mixedCase()
                ->uncompromised()
            ],
        ]);
       // store in database(insert):
       # 1_Eloquent:
       $user=new User();
       $user->name=$request->input('user_name');
       $user->email=$request->input('user_email');
       $user->address=$request->input('user_address');
       $user->password=Hash::make($request->input('user_password'));
       $user->remember_token=Str::random(10);
       $user->created_at=now();
       $user->updated_at=now();
       $saved=$user->save();
       return redirect()->route('users.index');
    //    return response()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        // dd('edit');
        $user=User::findOrFail($id);
        return response()->view('cms.users.edit',['users'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // dd('update');
        # validation:
        $request->validate([
            'user_name'=> 'string|required|min:5|max:20',
            'user_email'=>'required|email|unique:users,email,'.$id,
            'user_address'=>'nullable|string|max:100',
            'user_password'=>[
                'string','nullable',
                Password::min(8)
                ->mixedCase()
                ->symbols()
                ->uncompromised()
                ->letters()
                ->numbers()
            ]
        ]);
        # SQL_alter operation: Eloquent
        $user=User::findOrFail($id);
        $user->name=$request->input('user_name');
        $user->email=$request->input('user_email');
        $user->address=$request->input('user_address');
        if($request->has('user_password')){
            $user->password=Hash::make($request->input('user_password'));
        }
        $user->updated_at=now('Asia/Gaza');
        $saved=$user->save();
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'delete done!');
    }

    public function search(Request $request)
{
    $searchTerm = $request->input('search');

    $users = User::where('name', 'like', '%' . $searchTerm . '%')
                 ->orWhere('email', 'like', '%' . $searchTerm . '%')
                 ->get();

    return view('cms.users.index', ['users' => $users]);
}

}
