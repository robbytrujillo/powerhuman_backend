<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeamRequest;
use App\Models\Team;
use Exception;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function create(CreateTeamRequest $request) {
        try {
            // Upload icon
            if ($request->hasfile('icon')) {
                $path = $request->file('icon')->store('public/icons');
            }
    
            $team = Team::create([
                'name' => $request->name,
                'item' => $path,
                'company_id' => $request->company_id,
            ]);

            if (!$team) {
                throw new Exception('Team not created');
            }


           
    
            return ResponseFormatter::success($team, 'Team created');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }

        
    }
}
