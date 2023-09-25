<?php include('include/top.php'); ?>
 
<body>
    <?php include('include/addNew.php');?>
    <?php include('include/addToPlaylist.php');?>
    <?php include('include/playlistModal.php');?>

    <form action="/searchSong" method="get">
        <input type="search" name="search" placeholder="search song">
        <button type="submit" class="btn btn-primary">search</button>
    </form>
        <h1>Music Player</h1>
        <a class="btn btn-primary" href="/">All Songs</a>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">My Playlist</button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewModal">Add Song</button>

    <audio id="audio" controls autoplay></audio>
    <ul id="playlist">
        
    <div class="modal-body">
              <?php foreach ($music as $musics):?>
              <li data-src="<?="base_url"('/uploads/music/'.$musics['musicLink']);?>">
                <?= $musics['musicName'];?>
                <button type="button" class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#myModal" onclick="setMusicID('<?=$musics['id']?>')"> + </button>
              </li>
              <?php endforeach;?>
    </ul>
        <?php include 'include/bottom.php'?>
</body>
