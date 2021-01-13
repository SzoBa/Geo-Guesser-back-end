<?php

namespace App\Http\Controllers;

use App\Models\Highscore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HighscoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get top ten

        $scores =
            DB::table('highscores')
                ->join('users', 'highscores.user_id', '=', 'users.id')
                ->select('highscores.*', 'users.name')
                ->orderBy('highscores.score', 'DESC')
                ->take(10)
                ->get();


        return response(['highscores' => $scores], 201);
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
     * @param  \App\Models\Highscore  $highscore
     * @return \Illuminate\Http\Response
     */
    public function show(Highscore $highscore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Highscore  $highscore
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Highscore $highscore)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Highscore  $highscore
     * @return \Illuminate\Http\Response
     */
    public function destroy(Highscore $highscore)
    {
        //
    }
}
