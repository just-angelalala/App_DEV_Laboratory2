<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Music;
use App\Models\Myplaylist;
use App\Models\Musictrack;

class MainController extends BaseController
{
    
    private $music;
    private $myplaylist;
    private $musictrack;

    function __construct() {
        $this->music = new Music();
        $this->myplaylist = new Myplaylist();
        $this->musictrack = new Musictrack();
    }
    
    public function index()
    {
        $data = [
          'music' => $this->music->findAll(),
          'myplaylist' => $this->myplaylist->findAll(),
        ];
        return view('weiboooo/index', $data); 
    }

    public function upload(){
        $file = $this->request->getFile('songFile');
        var_dump($file);

        $newFileName = $file ->getRandomName();

        $data = [
            'musicName' => $file->getName(),
            'musicLink' => $newFileName,
        ];
        $rules = [
            'songFile' => [
                'uploaded[songFile]',
                'mime_in[songFile,audio/mpeg,audio/mp3,audio/wav]',
                'max_size[songFile,10240]',
                'ext_in[songFile,mp3]',
            ]
        ];

        if (!$this->validate($rules)) 
        {
            if($file->isValid() && !$file->hasMoved())
            {
                if($file->move(FCPATH . 'uploads\songs', $newFileName))
                {
                    echo "File uploaded successfully";
                    $this->music->save($data);
                }
                else
                {
                    echo $file->getErrorString().''.$file->getError();
                }
            }else{
                 $data['validation'] = $this->validator;
            }
            return redirect()->to('/')->withInput();
        }
    }
}
