<?php
 
namespace App\Controllers;
 
use App\Models\Season;
use App\Models\League;
use App\Models\LeagueSeason;
use App\Models\Article;
use App\Libraries\Grouping;
 
class Main extends BaseController
{

    protected $season;
    protected $leagueSeason;
    protected $league;
    protected $article;

    public function __construct()
    {
        $this->season = new Season();
        $this->leagueSeason = new LeagueSeason();
        $this->league = new League();
        $this->article = new Article();
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

    public function novinky()
    {
        // načteme články
        $articles = $this->article
            ->orderBy('date', 'DESC')
            ->where('top', 1)
            ->findAll(5);
    
        // poskládáme HTML pro každý článek
        
    
        // pošleme do view
        return view("novinky", ['articles' => $articles]);
    }
}