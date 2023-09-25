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
        //var_dump($file);

        $newFileName = $file->getRandomName();

        $data = [
            'musicName' => $file->getName(),
            'musicLink' => $newFileName,
        ];
        $rules = [
            'songFile' => [
                'uploaded[songFile]',
                'mime_in[songFile,audio/mpeg]',
                'max_size[songFile,10240]',
                'ext_in[songFile,mp3]',
            ]
        ];

        //var_dump($data);

        if ($this->validate($rules)) 
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
            }      
        }else{
            $data['validation'] = $this->validator;
            // Check if there are any validation errors
            if ($data['validation']->getErrors()) {
                // Get the array of error messages
                $errorMessages = $data['validation']->getErrors();
                
                // Loop through the error messages and do something with them
                foreach ($errorMessages as $field => $error) {
                    echo "Field: $field - Error: $error<br>";
                }
            } else {
                echo "No validation errors.";
            }
       }
         return redirect()->to('/')->withInput();
    }

    public function searchSong(){
        $searchLike = $this->request->getVar('search');
        if(!empty($searchLike)){
            $data = [
              'music' => $this->music->like('musicName',$searchLike)->findAll(),
              'myplaylist'=> $this->myplaylist->findAll(),
            ];
            return view('weiboooo/index', $data);
        }else{
            return redirect()->to('/');
        }
    }
    
    public function createPlaylist(){
        $data = [
            'playlistName' => $this->request->getVar('playlistName')
          ];
          $this->myplaylist->save($data);

          return redirect()->to('/');
    }  

    public function addToPlaylist(){
        $data = [
          'musicID' => $this->request->getVar('musicID'),
          'playlistID' => $this->request->getVar('playlist')
          ];

          $this->musictrack->save($data);

          return redirect()->to('/');
    }

    public function playlist($id = null){
        $db = \Config\Database::connect();
        $builder = $db->table('music');

        $builder->select(['music.id','music.musicName','music.musicLink','my_playlist.playlistID', 'my_playlist.playlistName']);
        $builder->join('music_track','music.id = music_track.musicID');
        $builder->join('my_playlist','music_track.playlistID = my_playlist.playlistID');
        
        if ($id !== null) {
            $builder->where('my_playlist.playlistID', $id);
    }
    $query = $builder->get();

    $data = [
      'music' => $this->music->findAll(),
      'myplaylist' => $this->myplaylist->findAll(),
    ];

    if($query) {
        $data['music'] = $query->getResultArray();
    }else {
        echo "Query Failed";
    }
    return view('weiboooo/index', $data);

    }
   
}
