<?php
 
namespace App\Controllers;
 
use App\Models\Season;
use App\Models\League;
use App\Models\LeagueSeason;
use App\Libraries\Grouping;
 
class Main extends BaseController
{
    /**
     * Přehled sezón seskupených po dekádách
     */
    public function index()
    {
        $seasonModel = new Season();
 
        $seasons = $seasonModel
            ->orderBy('start', 'ASC')
            ->findAll();
 
        $grouping = new Grouping();
        $poDekadach = $grouping->byDecade($seasons);

        $data['poDekadach'] = $poDekadach;
        
        echo view('index', $data);
    }
 
    /**
     * Detail sezóny – soutěže (ligy) v dané sezóně
     */
    public function sezona($id)
    {
        $leagueSeasonModel = new LeagueSeason();
        $leagueModel       = new League();
 
        // najdeme všechny propojené ligy
        $leagueSeasons = $leagueSeasonModel
            ->asObject()
            ->where('season_id', $id)
            ->findAll();
 
        $souteze = [];
        foreach ($leagueSeasons as $ls) {
            $liga = $leagueModel->find($ls->league_id);
            if ($liga) {
                $souteze[] = $liga;
            }
        }
 
        return view('sezony/sezona', [
            'souteze' => $souteze
        ]);
    }
}