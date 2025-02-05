<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Crypt;
use App\Models\Basic;
use App\Models\Currency;
use Auth;
use Carbon\Carbon;
use Session;

class BasicController extends Controller
{
    public function index(){
        $currency = Currency::first();
        $basic = Basic::where('id',1)->first();
        // return $currency;
        return view('superadmin.basic.index',compact(['basic','currency']));
    }

    public function updateBasic(Request $request){
        //if file exsit file.
        $old= Basic::find(1);
        $path = public_path('uploads/basic/');

        $update = Basic::where('id',1)->update([
            'copyright' => $request['copyright'],
            'creator'=>Auth::user()->id,
            'updated_at'=>Carbon::now(),
        ]);


        if($request->hasFile('Mlogo')){
            if($old->Mlogo !='' && $old->Mlogo != null){
                $old_pic = $path.$old->Mlogo;
                unlink($old_pic);
            }

            $imageTake = $request->file('Mlogo');
            $image_name = 'Main'.uniqId().'.'.$imageTake->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageTake);
            // $image->scale(width: 300);
            $image->save('uploads/basic/'.$image_name);

            Basic::where('id',1)->update([
                'Mlogo'=>$image_name,
                'updated_at'=>Carbon::now(),
            ]);
        }

        if($request->hasFile('Flogo')){
            if($old->Flogo !='' && $old->Flogo != null){
                $old_pic = $path.$old->Flogo;
                unlink($old_pic);
            }

            $imageTake = $request->file('Flogo');
            $image_name = 'Footer'.uniqId().'.'.$imageTake->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageTake);
            // $image->scale(width: 300);
            $image->save('uploads/basic/'.$image_name);

            Basic::where('id',1)->update([
                'Flogo'=>$image_name,
                'updated_at'=>Carbon::now(),
            ]);
        }

        if($request->hasFile('favlogo')){
            if($old->favlogo !='' && $old->favlogo != null){
                $old_pic = $path.$old->favlogo;
                unlink($old_pic);
            }

            $imageTake = $request->file('favlogo');
            $image_name = 'Fav-'.uniqId().'.'.$imageTake->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageTake);
            // $image->scale(width: 300);
            $image->save('uploads/basic/'.$image_name);

            Basic::where('id',1)->update([
                'favlogo'=>$image_name,
                'updated_at'=>Carbon::now(),
            ]);
        }
        
        if($update){
            Session::flash('success','Basic Website Setting Updated|');
            return redirect()->back();
        }
    }

    // Currency Symbol Converter
    public function updateCurrency(Request $request){
       
        // return $request->all();
        $request->validate([
            'name'=>'required',
        ]);

        $update = Currency::where('id',1)->update([
            'currency_icon'=>$request['name'],
            'editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now('UTC'),
        ]);

            if($update){
                Session::flash('success','Currency Change For Website');
                return redirect()->back();
            }
    }
}