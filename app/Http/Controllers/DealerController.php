<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Dealer;
use Illuminate\Support\Facades\DB;
use Mail;
// use App\Exception;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $dealers = Dealer::orderBy('id','desc')->paginate(10);
            if(!$dealers){
                return response()->json(['message'=>'Data is not available'],status:404);
            }else{
                
                return response()->json(['message'=>'Success delete dealer','data'=>$dealers],status:200);
            }
        }catch(\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()],status:406);
        }
    }
    public function search($search)
    {
        return Dealer::where('title', 'like', '%' . $search . '%')
                     ->orWhere('address', 'like', '%' . $search . '%')
                     ->get();
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
    public function store(Request $request){
        $request->validate([
            'title'=>'required|min:5|max:255',
            'address'=>'required|min:5|max:255',
            'lat'=>'required|min:5|max:255',
            'lng'=>'required|min:5|max:255',
        ]);

        try{
            $dealer = new Dealer;
            $dealer->title = $request->title;
            $dealer->address = $request->address;
            $dealer->lat = $request->lat;
            $dealer->lng = $request->lng;
            if(!$dealer){
                return response()->json(['message'=>'Error'],status:404);
            }else{
                $request = $dealer->save();
                return response()->json(['message'=>'Success add dealer'],status:200);
            }
        }catch(\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()],status:406);
        }

        // try{
        //     $dealer = new Dealer;
        //     $dealer->title = $request->title;
        //     $dealer->address = $request->address;
        //     $dealer->lat = $request->lat;
        //     $dealer->lng = $request->lng;
        //     $request = $dealer->save();
        //     if($request){
        //         return  ['Success'];
        //     }
        // }catch(\Exception $exception){
        //     return response()->json(['message'=>$exception->getMessage()]);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $dealer = Dealer::all()->where('id', $id);
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
    public function update(Request $request)
    {
        $dealer = Dealer::find($request->id);
        $dealer->title = $request->title;
        $dealer->address = $request->address;
        $dealer->lat = $request->lat;
        $dealer->lng = $request->lng;
        $request = $dealer->save();
        if($request){
            return  ['Success'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        try{
            $dealer = Dealer::find($id);
            if(!$dealer){
                return response()->json(['message'=>'Data is not available'],status:404);
            }else{
                $request = $dealer->delete();
                return response()->json(['message'=>'Success delete dealer'],status:200);
            }
        }catch(\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()],status:406);
        }
    }
    public function init(Request $request){
        $data = ['name'=>'','email'=>$request->email,'data'=> $request->message];
        $user['to'] = 'learnlaravel1@gmail.com';

        $mail = Mail::send('mail',$data, function($messages) use ($user){
            $messages->to($user['to']);
            $messages->subject('Hello');
        });

        if($mail){
            $this->sendEmail($request->email);
            return ['Success'];
        }
    }
    public function sendEmail($email){
        $data = ['name'=>'','email'=> $email, 'data'=> 'Hvala Vam na poruci koju ste nam poslali'];
        $user['to'] = $email;
        
        Mail::send('mailSend', $data, function($messages) use ($user){
            $messages->to($user['to']);
            $messages->subject('Uspesno primljena poruka');
        });;
    }
}