<?php

namespace App\Http\Controllers;

use App\Education;
use App\Experience;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = User::where('id', '!=', Auth::id())->with('review')->with('education')->with('experience')->get();
        return response()->json(['data' => $profiles]);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return response()->json(User::where('id', Auth::id())->with('review')->with('education')->with('experience')->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function experience(Request $request)
    {
        Experience::create([
            'user_id' => Auth::id(),
            'company' => $request->company,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year
        ]);
        return response()->json(User::where('id', Auth::id())->with('review')->with('education')->with('experience')->first());
    }

    public function education(Request $request)
    {
        Education::create([
            'user_id' => Auth::id(),
            'institution' => $request->institution,
            'course' => $request->course
        ]);
        return response()->json(User::where('id', Auth::id())->with('review')->with('education')->with('experience')->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->with('review')->with('education')->with('experience')->first();
        if ($request->photo_url) {
            $extension = $request["photo_url"]->getClientOriginalExtension();
            $fileName = md5(uniqid()) . '.' . $extension;
            $request["photo_url"]->move(public_path() . '/profile/', $fileName);
            $url = URL::to("/") . '/profile/' . $fileName;
            $user->update([
                'photo_url' => $url,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'id_no' => $request->id_no,
                'email' => $request->email,
            ]);

            return response()->json(['message' => 'user updated', 'user' => $user], 200);

        } else {
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'id_no' => $request->id_no,
                'email' => $request->email,
            ]);
            return response()->json(['message' => 'user updated', 'user' => $user], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
