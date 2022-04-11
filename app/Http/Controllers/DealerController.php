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
        // return response()->json(Dealer::orderBy('id','desc')->get(), status:200);
        // return response()->json(Dealer::all()->where('id',2113), status:200);
        // return Dealer::orderBy('id','desc')->get();
        try{
            return response()->json(Dealer::orderBy('id','desc')->get());

        }catch(\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()]);
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
            $request = $dealer->save();
            if($request){
                return  ['Success'];
            }
        }catch(Exception $exception){
            return response()->json(['message'=>$exception->getMessage()]);
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
        $dealer = Dealer::find($id);
        $request = $dealer->delete();
        if($request){
            return  ['Success'];
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