<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSearchController extends Controller
{
    public function index(Request $request)
    {
        $MAX_RESULTS = 15;
        // data = null | username
        $data = $request->q; // .../search?q={query=nombre} -> $data = ... (string)
        if ($data == null) {
            $users = DB::table('info_usu')
                ->join('usuario', 'usuario.id_usu', '=', 'info_usu.id_usu')
                ->join('persona', 'persona.dni', '=', 'usuario.id_usu')
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
            ->join('usuario', 'usuario.id_usu', '=', 'info_usu.id_usu')
            ->join('persona', 'persona.dni', '=', 'usuario.id_usu')
            ->get();

        return view(
            'search',
            [
                'users' => $users
            ]
        );
    }
}
