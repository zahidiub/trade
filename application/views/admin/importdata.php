      
        <div class="content-wrapper">
          <div class="row">
            
            <div class="col-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Import data in CSV Format only</h4>
                  <p class="card-description">
                    Basic form elements
                  </p>
                  <form class="forms-sample" method="post" enctype="multipart/form-data">
                    
                    <div class="form-group">
                      <label for="exampleSelectGender">Pair Name</label>
                        <select class="form-control" id="pair_name" name="pair_name">
                          <?=$pairs_string?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                      <label>File upload</label>
                      <input type="file" name="file_name" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- partial -->