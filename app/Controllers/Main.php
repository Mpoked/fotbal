<?php

namespace App\Controllers;

use App\Models\Season;
use App\Models\League;
use App\Models\LeagueSeason;
use App\Models\Article;
use App\Libraries\Grouping;
use App\Libraries\UploadImage;

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
            ->select('league.*')
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
        $articles = $this->article
            ->orderBy('date', 'DESC')
            ->where('top', 1)
            ->findAll(5);

        return view("novinky", ['articles' => $articles]);
    }

    public function article($id)
    {
        $clanek = $this->article->find($id);
        $data["article"] = $clanek;
        echo view("clanek", $data);
    }

    public function administrace()
    {
        $clanek = $this->article->findAll();
        $data["article"] = $clanek;
        echo view("administrace", $data);
    }

    public function create()
    {
        echo view("create");
    }

    public function store()
{
    $validace = $this->validate([
        'link'   => 'required|max_length[255]',
        'title'  => 'required|max_length[255]',
        'date'   => 'required|valid_date[Y-m-d]',
        'text'   => 'required',
        'photo'  => 'permit_empty|max_size[photo,2048]|is_image[photo]'
    ]);

    if (!$validace) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    // upload obrázku přes knihovnu UploadImage
    $noveJmeno = null;
    $photo = $this->request->getFile('photo');
    if ($photo && $photo->isValid() && !$photo->hasMoved()) {
        $uploader = new \App\Libraries\UploadImage();
        $result = $uploader->uploadImage($photo, 'sigma/');

        if ($result['success']) {
            $noveJmeno = basename($result['location']);
        } else {
            return redirect()->back()->with('error', $result['error']);
        }
    }

    // uložení článku
    $id = $this->article->insert([
        'title'     => $this->request->getPost('title'),
        'photo'     => $noveJmeno,
        'date'      => strtotime($this->request->getPost('date')),
        'top'       => $this->request->getPost('top') ? 1 : 0,
        'published' => $this->request->getPost('published') ? 1 : 0,
        'text'      => $this->request->getPost('text'),
    ], true);

    // vytvoření linku
    $slug = url_title($this->request->getPost('link'), '-', true);
    $link = 'article/' . $id . '-' . $slug;
    $this->article->update($id, ['link' => $link]);

    return redirect()->to('/administrace')->with('success', 'Článek byl úspěšně přidán.');
}
    

    public function edit($id)
    {
        $article = $this->article->find($id);

        if (!$article) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Článek s ID $id nebyl nalezen.");
        }

        return view('edit', ['article' => $article]);
    }

    public function update($id)
    {
        $article = $this->article->find($id);
        if (!$article) {
            return redirect()->to('/administrace')->with('error', 'Článek nebyl nalezen.');
        }
    
        $data = [
            'title' => $this->request->getPost('title'),
            'text'  => $this->request->getPost('text'),
            'top'   => $this->request->getPost('top') ? 1 : 0,
            'published' => $this->request->getPost('published') ? 1 : 0,
            'date' => strtotime($this->request->getPost('date') ?? date('Y-m-d'))
        ];
    
        // -----------------------------
        // upload nového obrázku přes knihovnu UploadImage
        // -----------------------------
        $file = $this->request->getFile('photo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploader = new UploadImage();
            $result = $uploader->uploadImage($file, 'sigma/');
    
            if ($result['success']) {
                $uploadPath = FCPATH . 'sigma/';
                // smazání starého obrázku
                if ($article->photo && file_exists($uploadPath . $article->photo)) {
                    unlink($uploadPath . $article->photo);
                }
                // uložíme jen název souboru
                $data['photo'] = basename($result['location']);
            } else {
                return redirect()->back()->with('error', $result['error']);
            }
        }
    
        // aktualizace linku
        $slug = url_title($this->request->getPost('link'), '-', true);
        $data['link'] = 'article/' . $id . '-' . $slug;
    
        $this->article->update($id, $data);
    
        return redirect()->to('/administrace')->with('success', 'Článek byl upraven.');
    }

    public function delete($id)
    {
        $article = $this->article->find($id);
        if (!$article) {
            return redirect()->back()->with('error', 'Článek nebyl nalezen.');
        }

        // smazání fotky
        $uploadPath = FCPATH . 'sigma/';
        if ($article->photo && file_exists($uploadPath . $article->photo)) {
            unlink($uploadPath . $article->photo);
        }

        $this->article->delete($id);

        return redirect()->to('/administrace')->with('success', 'Článek byl úspěšně smazán.');
    }

    public function uploadImage()
{
    $file = $this->request->getFile('file');

    if (!$file || !$file->isValid()) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON(['error' => 'Soubor nebyl nahrán nebo je neplatný.']);
    }

    $uploadLib = new UploadImage();
    $result = $uploadLib->uploadImage($file, 'sigma/');

    if (!$result['success']) {
        return $this->response
            ->setStatusCode(500)
            ->setJSON(['error' => $result['error']]);
    }

    return $this->response->setJSON(['location' => $result['location']]);
}

}
