<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Dealer;
use Illuminate\Support\Facades\DB;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Dealer::orderBy('id','desc')->paginate(10);
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
    public function store(Request $request)
    {
        $dealer = new Dealer;
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
    public function destroy($id)
    {
        $dealer = Dealer::find($id);
        $request = $dealer->delete();
        if($request){
            return  ['Success'];
        }
    }
    public function cleanup()
    {       
        DB::statement("SET @count = 0;");
        DB::statement("UPDATE `dealers` SET `dealers`.`id` = @count:= @count + 1;");
        DB::statement("ALTER TABLE `dealers` AUTO_INCREMENT = 1;");
    }
}
