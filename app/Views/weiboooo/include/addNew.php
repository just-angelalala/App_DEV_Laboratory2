<div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      <form action="/saveSong" method="post" enctype="multipart/form-data">
        <h1>Add Song</h1>
        <div class="input-group mb-3">
            <input type="file" class="form-control col-6" id="UploadFile" name="songFile">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>