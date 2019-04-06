<?php

namespace App\Http\Controllers;

use App\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        Application::create([
            'applicant_id' => Auth::id(),
            'job_owner_id' => $request->owner_id,
            'job_id' => $request->job_id,
            'cover_letter' => $request->cover_letter,
        ]);
        return response()->json(['message' => 'application saved']);
    }
}
