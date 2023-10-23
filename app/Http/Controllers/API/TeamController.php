<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{

    public function fetch(Request $request) {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        $teamQuery = Team::query();

         // powerhuman.com/apy/team?id=1
        if ($id) { // get single data
            $team = $teamQuery->find($id);

            if ($team) {
                return ResponseFormatter::success($team, 'Team found');
            }

            return ResponseFormatter::error('Team not found', 404);
        }
        // powerhuman.com/api/team
        //$teams = Team::with(['users']);
        $teams = $teamQuery->where('company_id', $request->company_id);// get multiple data
        

        // filtering nama perusahaan  ..... powerhuman.com/apy/team?name=Kunde
        if ($name) {
            $teams ->where ('name', 'like', '%' . $name. '%');
        }

         // Team::with(['users'])->where('name', 'like', '%Kunde%')->paginate(10);
        return ResponseFormatter::success(
            $teams->paginate($limit),
            'Teams found'
        );

       
    }

    public function create(CreateTeamRequest $request) {
        try {
            // Upload icon
            if ($request->hasfile('icon')) {
                $path = $request->file('icon')->store('public/icons');
            }
    
            $team = Team::create([
                'name' => $request->name,
                'item' => $path,
                'team_id' => $request->team_id,
            ]);

            if (!$team) {
                throw new Exception('Team not created');
            }

            return ResponseFormatter::success($team, 'Team created');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

   
    public function update(UpdateTeamRequest $request, $id) {
        
        try {
            // Get team
            $team = Team::find($id);

            if (!$team) {
                throw new Exception('Team not found');
            }

            // return $request->file('logo');

            // Upload logo
            if ($request->hasfile('icon')) {
                $path = $request->file('icon')->store('public/icons');
            }

            // Update team
            $team->updated([
                'name' => $request->name,
                'icon' => $path,
                'team_id' => $request->team_id,
            ]);

            return ResponseFormatter::success($team, 'Team Updated');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function destroy($id) { // yang jadi parameter $id
        try {
            // Get team
            $team = Team::find($id);

            // Check if team exists
            if (!$team) {
                throw new Exception('Team not found');
            }

            // Delete team
            $team->delete();

            return ResponseFormatter::success('Team Deleted');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
}
