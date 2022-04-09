<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal-Data-Update</title>
</head>
<body>
    <div class="modal fade" id="data-edit-modal" tabindex="-1" role="dialog" aria-labelledby="data-modal" aria-hidden="true"  data-backdrop="false">
        <div class="modal-dialog modal-lg" role="">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="modal-title" id="data-modal">Update User Info</h2>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
              <div id="edit_modal" class="modal-body">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="updateData" class="btn btn-danger">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
</body>
</html>

             