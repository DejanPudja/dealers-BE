<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Dealer;
use Illuminate\Support\Facades\DB;
use Mail;
// use App\Exception;

class DealerController extends Controller
{
    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

/**
 * @OA\Get(
 *     path="/api/dealers",
 *     @OA\Response(response="200", description="Display a listing of projects.")
 * )
 * 
 * @OA\Get(
 *     path="/api/dealer/show/689",
 *     @OA\Response(response="200", description="Display a listing of projects.")
 * )
 * 
 * @OA\Get(
 *     path="/api/dealers/search/DONNELLY",
 *     @OA\Response(response="200", description="Display a listing of projects.")
 * )
 * @OA\Post(
 *     path="/api/dealer/add",
 *     @OA\Response(response="200", description="OK")
 * )
 * 
 */

    public function index()
    {
        try{
            $dealers = Dealer::orderBy('id','desc')->paginate(10);
            if(!$dealers){
                return response()->json(['message'=>'Data is not available'],status:404);
            }else{
                
                return response()->json(['data'=>$dealers],status:200);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $dealer = Dealer::find($id);
            if(!$dealer){
                return response()->json(['message'=>'Data is not available'],status:404);
            }else{
                return $dealer;
                return response()->json(['data'=>$dealer],status:200);
            }
        }catch(\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()],status:406);
        }
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
        $request->validate([
            'title'=>'required|min:5|max:255',
            'address'=>'required|min:5|max:255',
            'lat'=>'required|min:5|max:255',
            'lng'=>'required|min:5|max:255',
        ]);
        try{
            $dealer = Dealer::find($request->id);
            $dealer->title = $request->title;
            $dealer->address = $request->address;
            $dealer->lat = $request->lat;
            $dealer->lng = $request->lng;
            if(!$dealer){
                return response()->json(['message'=>'Error'],status:404);
            }else{
                $request = $dealer->save();
                return response()->json(['message'=>'Success edit dealer'],status:200);
            }
        }catch(\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()],status:406);
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
        try{
            $data = ['name'=>'','email'=>$request->email,'data'=> $request->message];
            $user['to'] = 'learnlaravel1@gmail.com';
        
            if(!$request->email && $request->message){
                return response()->json(['message'=>'Not found'],status:404);
            }else{
                $mail = Mail::send('mail',$data, function($messages) use ($user){
                    $messages->to($user['to']);
                    $messages->subject('Hello');
                });    
                $this->sendEmail($request->email);
                return response()->json(['message'=>'Success send email'],status:200);
            }
        }catch(\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()],status:406);
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