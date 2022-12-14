<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserSearchController extends Controller
{
    public function index(Request $request)
    {
        $MAX_RESULTS = 15;
        $data = $request->q;
        if ($data == null) {
            $users = DB::table('info_usu')
                ->limit($MAX_RESULTS)
                ->get();
            return view(
                'search',
                [
                    'users' => $users
                ]
            );
        }
        // Get all users where name contains $data
        $users = DB::table('info_usu')
            ->where('nom_usu', 'like', '%' . $data . '%')
            ->get();

        return view(
            'search',
            [
                'users' => $users
            ]
        );
    }

    public function search(Request $request)
    {
        $data = $request->q();

        $users = DB::table('info_usu')
            ->where('num_usu', '=', $data)
            ->get();

        return view(
            'search',
            [
                'users' => $users
            ]
        );
    }
}
