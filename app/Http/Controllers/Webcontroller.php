<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Models\Vehicle;
use App\Http\Resources\VehicleResource;
use App\Models\Pservices;
use App\Http\Resources\PservicesResource;
use App\Models\Companyreview;
use App\Http\Resources\CompanyreviewResource;
use App\Models\Sprovider;
use App\Models\Requestform;
use App\Http\Resources\RequestformResource;

use App\Http\Resources\SproviderResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use DB;


class Webcontroller extends Controller
{
    
    public function login(Request $request)
    {
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::firstWhere('username', $request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {

            return response([
                'error' => true,
                'message' => 'These credentials do not match our records.'
            ]);
        }

        $response = [
            'error' => false,
            'user' => $user
        ];

        return response($response, 200);
    }

    public function register(Request $request)
    {
        $this->validate($request,[
            'username' => 'required',
            'name' => 'required',
            'role' => 'required',
            'contact' => 'required'
        ]);

        $data = [
            'username' => $request->post('username'),
            'password' => Hash::make($request->post('password')),
            'name' => $request->post('name'),
            'role' => $request->post('role'),
            'contact' => $request->post('contact'),
            'avatar' => $request->has('avatar') ? $request->file('avatar')
            ->store('profile','admin') : '',
            'uniqueid' => uniqid()
        ];

        $new = new User($data);

        $new->save();

        return new UserResource($new);
    }


    public function updateuser(Request $request,$id)
    {
        $this->validate($request,[
            'username' => 'required',
            'name' => 'required',
            'role' => 'required',
            'contact' => 'required'
        ]);

        $check = User::where('id',$id)->first();

        if (!$check) {
            
            response()->json(['error' => 'Authourise action'],401);
        }

        $data = [
            'username' => $request->post('username'),
            'name' => $request->post('name'),
            'role' => $request->post('role'),
            'contact' => $request->post('contact'),
            'avatar' => $request->has('avatar') ? $request->file('avatar')
            ->store('profile','admin') : $check->avatar,
        ];

        User::where('id',$id)->update($data);

        $check = User::where('id',$id)->first();

        $response = [
            'error' => false,
            'user' => $check
        ];

        return response($response, 200);
    }



   public function alluser()
{
    $user = User::latest()->get();
    return UserResource::collection($user);
}
 
   public function userinfo($id)
{
    $user = User::where('id',$id)->first();

    return new UserResource($user);
}

 public function addvehicle(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'model' => 'required',
            'numberplate' => 'required',
            'color' => 'required'
        ]);

        $data = [
            'user_id' => $request->post('user_id'),
            'name' => $request->post('name'),
            'model' => $request->post('model'),
            'color' => $request->post('color'),
            'numberplate' => $request->post('numberplate'),
            'avatar' => $request->has('avatar') ? $request->file('avatar')
            ->store('vehicle','admin') : ''
        ];

        $new = new Vehicle($data);

        $new->save();

        return new VehicleResource($new);
}


public function editvehicle(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'model' => 'required',
            'numberplate' => 'required',
            'color' => 'required'
        ]);

        $data = Vehicle::where('id',$id)->first();

        if (!$data) {
            
            response()->json(['error' => 'Authourise action'],401);
        }


        $mdata = [
            'user_id' => $request->post('user_id'),
            'name' => $request->post('name'),
            'model' => $request->post('model'),
            'color' => $request->post('color'),
            'numberplate' => $request->post('numberplate'),
            'avatar' => $request->has('avatar') ? $request->file('avatar')
            ->store('vehicle','admin') : $data->avatar
        ];

        Vehicle::where('id',$id)->update($mdata);

        return new VehicleResource($data);
}


    public function showvehicle($id)
{
    $vehicle = Vehicle::where('id',$id)
    ->first();

    return new VehicleResource($vehicle);
}

public function deletevehicle($id)
{
    $vehicle = Vehicle::where('id',$id)
    ->delete();

    return "deleted";
}




   public function allvehicle($user_id)
{
    $vehicle = Vehicle::where('user_id',$user_id)
    ->latest()->get();

    //logger($vehicle);

    return VehicleResource::collection($vehicle);
}


  public function companysinfo($id)
{

    $sprovider = Sprovider::where('user_id',$id)
    ->first();

    if (!$sprovider) {

         $response = [
            'data' => ''
        ];

        return response($response, 200);
    }

    return new SproviderResource($sprovider);
}


  public function companysreportinfo($id)
{

    $sprovider = Sprovider::where('id',$id)
    ->first();

    return new SproviderResource($sprovider);
}

  public function companyreportinfo($id)
{

    $sprovider = Sprovider::where('user_id',$id)
    ->first();

    return new SproviderResource($sprovider);
}


 public function companyservices($id)
{

    $sprov = Sprovider::where('id',$id)
    ->first();

    $sprovider = Pservices::where('uniqueid',$sprov->user_id)
    ->get();

    //logger($sprovider);

    return PservicesResource::collection($sprovider);
}


public function addcompany(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'location' => 'required',
            'contact' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $sprovider = Sprovider::where('user_id',$request->post('user_id'))
        ->first();

        $data = [
            'user_id' => $request->post('user_id'),
            'name' => $request->post('name'),
            'loc' => $request->post('location'),
            'contact' => $request->post('contact'),
            'lat' => $request->post('latitude'),
            'lng' => $request->post('longitude'),
            'logo' => $request->has('avatar') ? $request->file('avatar')
            ->store('vehicle','admin') : ($sprovider->logo ?? "")
        ];

        if ($sprovider) {

            Sprovider::where('user_id',$request->post('user_id'))
            ->update($data);

            return new SproviderResource($sprovider);

        }else{

            $new = new Sprovider($data);
            $new->save();
            return new SproviderResource($new);

        }


        
}


public function allcompany()
{
    $all = Sprovider::latest()->get();

    return SproviderResource::collection($all);
}



   public function history($id)
{
    $data = Requestform::where('user_id',$id)
    ->latest()->get();

    return RequestformResource::collection($data);
}



public function reportbreakdown(Request $request)
{
        $data = [
            'user_id' => $request->post('user_id'),
            'prvider_id' => $request->post('prvider_id'),
            'service' => $request->post('service'),
            'note' => $request->post('note'),
            'status' => $request->post('status'),
            'vehicle_id' => $request->post('vehicle_id'),
            'lat' => $request->post('lat'),
            'lng' => $request->post('lng')
        ];

        $new = new Requestform($data);
        $new->save();

        return new RequestformResource($new);     
}

public function companyreview($id)
{
    $data = Companyreview::where('prvider_id',$id)
    ->latest()->get();

    return CompanyreviewResource::collection($data);
}

public function review($id)
{
    $all = Sprovider::where('id',$id)->first();

    //logger($all);

    $data = Companyreview::where('prvider_id',$all->user_id)
    ->latest()->get();

    //logger($data);

    return CompanyreviewResource::collection($data);
}



public function ratecompany(Request $request)
{
        $data = [
            'user_id' => $request->post('user_id'),
            'prvider_id' => $request->post('prvider_id'),
            'rate' => $request->post('rate'),
            'note' => $request->post('note'),
            'note' => $request->post('note')
        ];

       // logger($data);

        $new = new Companyreview($data);
        $new->save();

        return new CompanyreviewResource($new);     
}


 public function services($id)
{

    $sprovider = Pservices::where('uniqueid',$id)
    ->latest()
    ->get();

    return PservicesResource::collection($sprovider);
}

 public function serviceinfo($id)
{

    $sprovider = Pservices::where('id',$id)
    ->first();

    return new PservicesResource($sprovider);

}

public function deleteservices($id)
{
    $vehicle = Pservices::where('id',$id)
    ->delete();

    return "deleted";
}


public function addservices(Request $request)
{
        $data = [
            'prov_id' => $request->post('prov_id'),
            'uniqueid' => $request->post('uniqueid'),
            'name' => $request->post('name'),
        ];

        $new = new Pservices($data);
        $new->save();

        return new PservicesResource($new);     
}

public function updateservices(Request $request,$id)
{
        
    $data = [
        'prov_id' => $request->post('prov_id'),
        'uniqueid' => $request->post('uniqueid'),
        'name' => $request->post('name'),
    ];

    $all = Pservices::where('id',$id)->first();

    Pservices::where('id',$id)
        ->update($data);

    return new PservicesResource($all);     
}

public function providers($id)
{
    $data = Requestform::with('user')
    ->with('provider')
    ->with('vehicle')
    ->select('user_id','prvider_id')
    ->where('user_id',$id)
    ->distinct()
    ->get();

    //logger($data);

    return RequestformResource::collection($data);
}

public function users($id)
{
    $data = Requestform::where('prvider_id',$id)
    ->select('prvider_id','user_id')
    ->distinct()->latest()->get();

    return RequestformResource::collection($data);
}

public function requests($id)
{
    $data = Requestform::where('prvider_id',$id)->latest()->get();

    return RequestformResource::collection($data);
}




}





