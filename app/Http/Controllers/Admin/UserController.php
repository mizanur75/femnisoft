<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\Order;
use App\Model\Chamber;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        
        $users = User::orderBy('id','DESC')->where('role_id', '>', 1)->get();
        return view('admin.user.all',compact('users'));
    }

    public function create()
    {
        $chambers = Chamber::all();
        $roles = Role::all();
        return view('admin.user.add',compact('roles','chambers'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required',
            'name' => 'required',
            'username' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
            'gender' => 'required',
            'amount' => 'required',
            'password' => 'required',
        ]);

        $image = $request->file('logo');
        $slug = str_slug($request->name);

        if (isset($image)) {
            $imagename = $slug.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!file_exists('images/userlogo')) {
                mkdir('images/userlogo', 755, true);
            }

            $image->move('images/userlogo',$imagename);
        }else{
            $imagename = '';
        }
        
        $user = new User();
        $user->role_id = $request->role_id;
        $user->name = $request->name;
        $user->slug = str_slug($request->name);
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->status = 0;
        $user->payment = 0;
        $user->amount = $request->amount;
        $user->image = $imagename;
        $user->room = "https://meet.jit.si/".str_random(20);
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('admin.user.index')->with('success','User Added Successfully!');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $roles = Role::all();
        $user = User::find($id);
        $chambers = Chamber::all();
        return view('admin.user.edit', compact('user','roles','chambers'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'role_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'password' => 'required',
        ]);
        
        $user = User::find($id);

        $image = $request->file('logo');
        $slug = str_slug($request->name);

        if (isset($image)) {
            if (file_exists('images/userlogo/'.$user->image)) {
                unlink('images/userlogo/'.$user->image);
            }
            $imagename = $slug.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!file_exists('images/userlogo')) {
                mkdir('images/userlogo', 755, true);
            }

            $image->move('images/userlogo',$imagename);
        }else{
            $imagename = $user->image;
        }

        $user->role_id = $request->role_id;
        $user->name = $request->name;
        $user->slug = str_slug($request->name);
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->status = $user->status;
        $user->payment = $user->payment;
        $user->amount = $request->amount;
        // $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('admin.user.index')->with('success','User Updated Successfully!');
    }


    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return back()->with('success','User Deleted!');
    }
    public function permission()
    {
        $roles = Role::all();
        $last_date = \Carbon\Carbon::now()->daysInMonth;
        $current_date = now()->format('d');
        $users = User::orderBy('id','DESC')->where('role_id', '>', 1)->get();
        return view('admin.user.permission',compact('users','roles','last_date','current_date'));
    }
    public function changepermission(Request $request, $id)
    {
        User::where('id',$id)->update(['role_id' => $request->permission]);
        return back()->with('success','Permission changed!');
    }
    public function status(Request $request, $id)
    {
        User::where('id',$id)->update(['status' => $request->status]);
        return back()->with('success','Status Changed!');
    }
    public function payment_set($id)
    {
        User::where('id',$id)->update(['payment' => 1]);
        return back()->with('success','Payment Set Successful!');
    }

    public function allpayment(){
        $payments = Order::orderBy('id','DESC')->get();
        // return $payments;
        return view('payment.all', compact('payments'));
    }
    public function userpayment($id){
        $payments = Order::orderBy('id','DESC')->where('user_id',$id)->get();
        // return $payments;
        return view('payment.all', compact('payments'));
    }
}
