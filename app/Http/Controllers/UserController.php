<?php

namespace App\Http\Controllers;

use App\Department;
use App\Duplicatesale;
use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\Users\UsersResource;
use App\Http\Resources\Users\UserResource;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use App\Sale;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // Redis::flushall();
        // if(Redis::exists('users')){
            // return json_decode(Redis::get('users'));
        // }
        // else {
            $users = User::latest()->get();
            // Redis::set('users', $users);
            // return $users;
            return UsersResource::collection($users);
        // }

    }

    public function switch_user_status(Request $request, $id)
    {
        $user = User::find($id);
        $user->status = $request->status;
        $user->save();
        return $user;
    }

    public function user_schedule(Request $request, $id)
    {
        $user = User::find($id);
        $user->schedule = $request->schedule;
        $user->save();
        return $user;
    }

    public function user_days()
    {
        $users = User::where('id', '!=', 1)
                    ->where('schedule', '!=', null)
                    ->where('status', 1)
                    ->get();

        return UsersResource::collection($users);
    }

    public function user_sales(){
        $today = Carbon::now()->toDateString();
        $users = User::where('status', 1)
                    ->where('department_id', 3)
                    ->get();

        $sales = array();

        foreach($users as $user) {
            $s1 = Sale::whereDate('created_at', $today)->where('user_order', $user->name)->sum('amount');
            $s2 = Duplicatesale::whereDate('created_at', $today)->where('user_order', $user->name)->sum('amount');
            $s3 = Sale::whereDate('created_at', $today)->where('user_order', $user->name)->count();
            $s4 = Duplicatesale::whereDate('created_at', $today)->where('user_order', $user->name)->count();
            $s5 = Sale::whereDate('created_at', $today)->where('user_order', $user->name)->sum('score');
            $s6 = Duplicatesale::whereDate('created_at', $today)->where('user_order', $user->name)->sum('score');
            $s7 = Sale::whereDate('created_at', $today)->where('user_order', $user->name)->get();
            $s8 = Duplicatesale::whereDate('created_at', $today)->where('user_order', $user->name)->get();

            $sold_items = $s7->concat($s8);
            
            $sales_user = Array('name' => $user->name, 
                                'daily_sales' => $s1 + $s2, 
                                'sales_count' => $s3 + $s4,
                                'score' => $s5 + $s6,
                                'products' => $sold_items);
            array_push($sales, $sales_user);
        }

        return $sales;       
    }

    public function logged_user_sales($id){
        $user = User::findOrFail($id);
        $today = Carbon::now()->toDateString();

        $s1 = Sale::whereDate('created_at', $today)->where('user_order', $user->name)->sum('amount');
        $s2 = Duplicatesale::whereDate('created_at', $today)->where('user_order', $user->name)->sum('amount');
        $s3 = Sale::whereDate('created_at', $today)->where('user_order', $user->name)->count();
        $s4 = Duplicatesale::whereDate('created_at', $today)->where('user_order', $user->name)->count();
        $s5 = Sale::whereDate('created_at', $today)->where('user_order', $user->name)->sum('score');
        $s6 = Duplicatesale::whereDate('created_at', $today)->where('user_order', $user->name)->sum('score');
        $s7 = Sale::whereDate('created_at', $today)->where('user_order', $user->name)->get();
        $s8 = Duplicatesale::whereDate('created_at', $today)->where('user_order', $user->name)->get();

        $sold_items = $s7->concat($s8);   
        $sales = Array('name' => $user->name, 
                                'daily_sales' => $s1 + $s2, 
                                'sales_count' => $s3 + $s4,
                                'score' => $s5 + $s6,
                                'products' => $sold_items);

        return $sales;       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'department_id' => $request->department_id,
            'pin' => $request->pin,
            'password' => bcrypt($request->password),
            'pwd_clr' => $request->password
        ]);

        return new UsersResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return new UserResource($user);
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
        $user = User::find($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'department_id' => $request->department_id,
            'pin' => $request->pin,
            'password' => bcrypt($request->password),
            'pwd_clr' => $request->password
        ]);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    public function user_sales_report(Request $request)
    {
        $users = User::where('status', 1)
                    ->where('department_id', 3)
                    ->get();
                    
        $sales = array();

        foreach($users as $user) {
            $s1 = Sale::whereDate('created_at', $request->date)->where('user_order', $user->name)->sum('amount');
            $s2 = Duplicatesale::whereDate('created_at', $request->date)->where('user_order', $user->name)->sum('amount');
            $s3 = Sale::whereDate('created_at', $request->date)->where('user_order', $user->name)->count();
            $s4 = Duplicatesale::whereDate('created_at', $request->date)->where('user_order', $user->name)->count();
            $s5 = Sale::whereDate('created_at', $request->date)->where('user_order', $user->name)->sum('score');
            $s6 = Duplicatesale::whereDate('created_at', $request->date)->where('user_order', $user->name)->sum('score');
            $s7 = Sale::whereDate('created_at', $request->date)->where('user_order', $user->name)->get();
            $s8 = Duplicatesale::whereDate('created_at', $request->date)->where('user_order', $user->name)->get();

            $sold_items = $s7->concat($s8);

            $sales_user = Array('name' => $user->name, 
                                'daily_sales' => $s1 + $s2, 
                                'sales_count' => $s3 + $s4,
                                'score' => $s5 + $s6,
                                'products' => $sold_items);

            array_push($sales, $sales_user);
        }

        return $sales; 
    }
}
