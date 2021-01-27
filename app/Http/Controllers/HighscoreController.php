<?php

namespace App\Http\Controllers;

use App\Models\Highscore;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class HighscoreController extends Controller
{
    /**
     * Get the top ten highscore of a map.
     *
     * @param int $mapId
     * @return Response
     */
    public function index(int $mapId): Response
    {
        $scores =
            DB::table('highscores')
                ->join('users', 'highscores.user_id', '=', 'users.id')
                ->select('highscores.*', 'users.name')
                ->where('highscores.map_id', $mapId)
                ->orderBy('highscores.score', 'DESC')
                ->take(10)
                ->get();
        return response(['highscores' => $scores], 201);
    }

    /**
     * Store a new highscore.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        Highscore::create([
            'user_id' => $request->user()->id,
            'score' => $request->get('score'),
            'map_id' => $request->get('map'),
        ]);
        return response(["message"=> "success"], 201 );
    }

    /**
     * Respond with the corresponding highscores of a map.
     *
     * @param Request $request
     * @param int $mapId
     * @return Response
     */
    public function getById(Request $request, int $mapId): Response
    {
        $userId = $request->user()->id;
        $highscores = DB::table('highscores')
            ->select("score", "created_at")
            ->where('user_id', $userId)
            ->where('map_id', $mapId)
            ->orderBy('score', 'DESC')
            ->get();
        return response($highscores, 200);
    }
}
