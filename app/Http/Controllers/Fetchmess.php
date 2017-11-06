<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class Fetchmess extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $cont = "";
      // $mess = DB::select("select message,frm from `messages` where (`frm`='?' and `to`='?') or (`frm`='?'and `to`='?')",[$request->frm,$request->to,$request->to,$request->frm]);
      $mess = DB::select("select * from `messages` " );

      foreach ($mess as $msg)
      {

        if((($msg ->frm == $request->frm) && ($msg ->to == $request->to)))
        // else
        {
          $cont = $cont . '<tr ><td><div class=\'well well-sm\' style="background:rgb(22,105,173);color:rgb(255,255,255);min-width:40%;float:right;display:inline-block ;">'.($msg->message).'</div></td></tr>';
        }
        if ((($msg ->frm == $request->to) && ($msg ->to == $request->frm)))
        {
        $cont = $cont . '<tr ><td><div class=\'well well-sm\' style="min-width:40%;float:left;display:inline-block ;">'.($msg->message).'</div></td></tr>';
      }

      }
      return $cont;
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
