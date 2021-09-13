<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Gate::allows('isAdmin')){
            return User::latest()->paginate(5);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Gate::allows('isAdmin')){
            $this->validate($request,[
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:users',
                'password' => 'required|string|min:8',
            ]);

            return User::create([
                'name'=>$request['name'],
                'email'=>$request['email'],
                'type'=>$request['type'],          
                'bio'=>$request['bio'],          
                'photo'=>$request['photo'],
                'password'=>Hash::make($request['password'])
            ]);
        }
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

    public function updateProfile(Request $request){
        if(\Gate::allows('isAdmin') || \Gate::allows('isRestaurant')){
            $user = auth('api')->user();

            $this->validate($request,[
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
                'password' => 'sometimes|required|min:8',
            ]);


            $currentPhoto = $user->photo;
            if($request->photo != $currentPhoto){
                $name = time().'.'.explode('/',explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
                //Image intervation model class
                \Image::make($request->photo)->save(public_path('imgs/profile/').$name);
                
                $request->merge(['photo' => $name]);

                $userPhoto = public_path('imgs/profile/').$currentPhoto;
                if(file_exists($userPhoto)){
                    @unlink($userPhoto);
                }
            }

            if(!empty($request->password)){
                $request->merge(['password'=>Hash::make($request['password'])]);
            }

            $user->update($request->all());
        }
    }

    public function profile()
    {        
        return auth('api')->user();
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
        if(\Gate::allows('isAdmin') || \Gate::allows('isRestaurant')){
            $user = User::findOrFail($id);

            $this->validate($request,[
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
                'password' => 'sometimes|min:8',
            ]);

            $user->update($request->all());
            return $id;
        }   
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
        $user = User::findOrFail($id);
        $user->delete();
        return ['message'=>'User Deleted'];
    }

    public function search(){
        if(\Gate::allows('isAdmin')){
            if($search = \Request::get('q')){
                $users = User::where(function($query) use ($search){
                    $query->where('name','LIKE',"%$search%")
                    ->orWhere('email','LIKE',"%$search%")
                    ->orWhere('type','LIKE',"%$search%");
                })->latest()->paginate(20);
            }else{
                $users = User::latest()->paginate(5);
            }
            return $users;
        }
    }

    public function getSetupIntent()
    {
        return auth()->user()->createSetupIntent();
    }

    public function getPaymentMethods()
    {
        $user = auth()->user();
        $paymentMethods = [];

        if ($user->hasPaymentMethod()) {
            foreach ($user->paymentMethods() as $method) {
                array_push($paymentMethods, [
                    'id' => $method->id,
                    'brand' => $method->card->brand,
                    'last_four' => $method->card->last4,
                    'exp_month' => $method->card->exp_month,
                    'exp_year' => $method->card->exp_year,
                ]);
            }
        }

        return response()->json([
            "methods" => $paymentMethods,
            "default_payment_method" => $user->defaultPaymentMethod()
        ]);
    }

    public function postPaymentMethod(Request $request) {
        $user = auth()->user();
        $paymentMethodID = $request->get("payment_method_id");

        if($user->stripe_id == null) {
            $user->createAsStripeCustomer();
        }

        $user->addPaymentMethod($paymentMethodID);
        $user->updateDefaultPaymentMethod($paymentMethodID);

        return response()->json('', 200);
    }
}
