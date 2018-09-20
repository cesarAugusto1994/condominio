<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function avatar(Request $request)
    {
        $user = \Auth::user();

        if($request->has('email')) {
          $user = User::where('email', $request->get('email'))->get()->first();
        }

        if($user->avatar_tipo == 'social') {

          $file = file_get_contents($user->social_avatar);
          return response($file, 200)->header('Content-Type', 'image/jpeg');

        } elseif($user->avatar_tipo == 'upload') {

          $file = \Storage::disk('local')->get($user->avatar);
          return response($file, 200)->header('Content-Type', 'image/jpeg');

        } elseif($user->avatar_tipo == 'words') {

          $file = file_get_contents(\Avatar::create($user->name)->setDimension(300, 300)->setFontSize(85)->setShape('square')->setBorder(0, '#aabbcc')->toBase64());
          return response($file, 200)->header('Content-Type', 'image/jpeg');

        } else {

          $file = file_get_contents(\Gravatar::get($user->email));
          return response($file, 200)->header('Content-Type', 'image/png');
        }
    }
}
