<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal-Data-Update</title>
</head>
<body>
    <div class="modal fade" id="illness-entry-modal" tabindex="-1" role="dialog" aria-labelledby="data-modal" aria-hidden="true"  data-backdrop="false">
        <div class="modal-dialog modal-md" role="">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="modal-title" id="data-modal">Illness Info</h2>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="./modal_query/illness_script.php" method="POST">
              <div id="illness-entry" class="modal-body">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="updateData" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
</body>
</html>

             