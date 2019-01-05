<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersEditRequest;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return View('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Pull out roles from Role to be used in Create Form
        $roles = Role::lists('name', 'id')->all();

        return View('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        // Create new users based on the request
        //User::create($request->all());

        // If the password is not empty -- for editing
        if(trim($request->password) == ''){
            $input = $request->except('password');
        }
        else {
            
            $input = $request->all();
            
            // Encrypt the password first - reassign the encrypted password
            $input['password'] = bcrypt($request->password);
            
        }
        

        // Check if file exist or not
        if($file = $request->file('photo_id')){
            // Append name with time (unique)
            $name = time() . $file->getClientOriginalName();

            // Move the image to images folder (Created if does not exist)
            $file->move('images', $name);

            // Create a new photo inside photo table
            $photo = Photo::create(['file' => $name]);

            // Assign the Created photo photo_id to the input to be stored in Users table
            $input['photo_id'] = $photo->id;
        }

        // With all the input received, create a new user.
        User::create($input);

        return redirect('/admin/users');

        //return $request->all();
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
        // Find user
        $user = User::findOrFail($id);

        // Pull out roles from Role to be used in Create Form
        $roles = Role::lists('name', 'id')->all();

        return View('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
        //
        $user = User::findOrFail($id);
        
        // If the password is not empty -- for editing
        if(trim($request->password) == ''){
            $input = $request->except('password');
        }
        else {

            $input = $request->all();

            // Encrypt the password first - reassign the encrypted password
            $input['password'] = bcrypt($request->password);
        }
        
        if($file = $request->file('photo_id')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file'=>$name]);
            $input['photo_id'] = $photo->id;
        }

        $user->update($input);

        return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the user based on Id
        $user = User::findOrFail($id);

        // Find the photo of the user to delete the photo together
        unlink(public_path() . $user->photo->file);

        // Create Session to display Flash Message
        Session::flash('deleted_user', 'The user has been deleted');
        
        return redirect('/admin/users');
    }
}
