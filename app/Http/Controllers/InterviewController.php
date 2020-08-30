<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interview;

class InterviewController extends Controller
{
    public function put(Request $request){
        
        $in = new Interview;
        $in->user_id = $request->user_id;
        $in->question = $request->question;
        $in->answer = $request->answer;
        $in->save();

        return response()->json(1);
    }
}
