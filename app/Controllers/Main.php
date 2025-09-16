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

    public function article($id){

        $clanek = $this->article->find($id);

        $data["article"] = $clanek;

        echo view("clanek", $data);
    }

    public function administrace(){
        $clanek = $this->article->findAll();
        
        $data["article"] = $clanek;

        echo view("administrace", $data);
    }

    public function create(){
        echo view("create");
    }

    public function store()
    {
    // Validace vstupů
    $validace = $this->validate([
        'link'   => 'required|max_length[255]',
        'title'  => 'required|max_length[255]',
        'date'   => 'required|valid_date',
        'text'   => 'required',
        'photo'  => 'max_size[photo,2048]|is_image[photo]' // Foto nepovinné, ale musí být validní obrázek
    ]);

    if (!$validace) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    // Upload obrázku
    $photo = $this->request->getFile('photo');
    $noveJmeno = null;

    if ($photo && $photo->isValid() && !$photo->hasMoved()) {
        // Generování náhodného jména
        $noveJmeno = $photo->getRandomName();
        $photo->move(ROOTPATH . 'public/uploads/articles', $noveJmeno);

        // Kontrola, jestli se opravdu přesunulo
        if (!$photo->hasMoved()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nepodařilo se uložit obrázek.');
        }
    }

    // Uložení článku do databáze přes $this->article
    $this->article->insert([
        'link'  => $this->request->getPost('link'),
        'title' => $this->request->getPost('title'),
        'photo' => $noveJmeno ? '/uploads/articles/' . $noveJmeno : null,
        'date'  => $this->request->getPost('date'),
        'top'   => $this->request->getPost('top') ? 1 : 0,
        'text'  => $this->request->getPost('text'),
    ]);

    return redirect()->to('/administrace')->with('success', 'Článek byl úspěšně přidán.');

    }

    public function delete($id)
{
    // Najdi článek
    $clanek = $this->article->find($id);

    if (!$clanek) {
        return redirect()->back()->with('error', 'Článek nebyl nalezen.');
    }

    // Smaž článek
    $this->article->delete($id);

    // Přesměrování s hláškou
    return redirect()->to('/administrace')->with('success', 'Článek byl úspěšně smazán.');
}

}