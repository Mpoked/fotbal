<?php
 
namespace App\Controllers;
 
use App\Models\Season;
use App\Models\League;
use App\Models\LeagueSeason;
use App\Libraries\Grouping;
 
class Main extends BaseController
{

    protected $season;
    protected $leagueSeason;
    protected $league;

    public function __construct()
    {
        $this->season = new Season();
        $this->leagueSeason = new LeagueSeason();
        $this->league = new League();
    }

    public function index()
    {
 
        $seasons = $this->season
            ->orderBy('start', 'ASC')
            ->findAll();
 
        $grouping = new Grouping();
        $poDekadach = $grouping->byDecade($seasons);

        $data['poDekadach'] = $poDekadach;
        
        echo view('index', $data);
    }
 
    
 
    public function sezona($id)
    {
        $souteze = $this->leagueSeason
            ->select('league.*') // chceme data z tabulky leagues
            ->join('league', 'league.id = league_season.id_league')
            ->where('league_season.id_season', $id)
            ->asObject()
            ->findAll();

        $sezona = $this->season->find($id);

        return view('sezona', [
            'sezona' => $sezona,
            'souteze' => $souteze
        ]);
    }

}