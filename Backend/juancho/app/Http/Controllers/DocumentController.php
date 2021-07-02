<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;


class DocumentController extends Controller
{
    public function list(Request $request) {

        $status = 200;

        $input = $request->all();

        $validator = Validator::make($input, [
            'description' => 'required'
        ]);

        if($validator->fails()){
            $status = 500;
        }

        return response()->json([
            'status' => $status
        ]);
    }
}
