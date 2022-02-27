$(document).ready(function(){
    var dataTable = $('#dataTable').DataTable( {
        "processing":true,
        "oSearch": {
          "bSmart": false, 
          "bRegex": true,
          "sSearch": "",      
      },
        "ajax": {
          type:"POST",
          url:"../control/fetch/fetch.php",
          dataType : "json"
        },  
      "columns": [
        { "data": "id" },
        { "data": "person_id" },
        { "data": "name" },
        { "data": "age" },
        { "data": "gender" },
        { "data": "illness" },
        { "data": "date" },
        { "data": "address" },
        { "data": "status" },
        { "data": "second_status"}
        
    ],
    "columnDefs": [ {
        "targets": 10,
        "data": "illness",
        "render": function (data, type, full) {
          var drop_del = '<div  class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg></div>';
          var drop_edit = '<div class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/></svg></div>'; 
          
          var div_row = '<div class="row">'
          var dropdown_edit = div_row + '<div  class="dropdown_edit col-sm-5">'+ drop_edit +'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
          var dropdown_del = '<div class="dropdown_delete col-sm-5">'+ drop_del +'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
         
          
          var illness_key = full.illness.split('<br>');
          var date_key = full.date.split('<br>');
          var person_id = full.person_id.split(' ');
          
          
          for (var i=0; i < full.illness.split('<br>').length; i++) {
            dropdown_edit += '<button id="' + person_id[i] +"_"+full.id+ '" class="dropdown-item edit">' + illness_key[i] + " "+ date_key[i] + '</button>';
          }
          dropdown_edit += '</div></div>';
          for (var i=0; i < full.illness.split('<br>').length; i++) {
            dropdown_del += '<button id="' + person_id[i] + '" class="dropdown-item del">' + illness_key[i] + " "+ date_key[i] + '</button>';
          }
          drop_del += '</div></div></div>';
          return dropdown_edit + dropdown_del;
        }
      },
      {
        "targets": [ 1 ],
        "visible": false
    }
    ],
    lengthMenu:[
        [10,25,50,-1],
        ['10 rows', '25 rows', '50 rows', 'Show all']
    ],

    dom: 'lBfrtip',
    buttons: [
    
        {
            text:'Refresh',
            className:' btn btn-sm btn-secondary',
            id:'ref',
            action: function( e, dt, node, config ){
                $('#dataTable').DataTable().ajax.reload();
            }
        },
        {
            extend:'excel',
            className:'btn btn-sm btn-secondary',
            id:'ex',
            text:'EXCEL',
            exportOptions: {
                columns: [0,2,3,4,5,6,7,8,9]
            }
    
        },
        {
            extend:'csv',
            className:'btn btn-sm btn-secondary',
            id:'csv',
            text:'CSV',
            exportOptions: {
                columns: [0,2,3,4,5,6,7,8,9]
            }
           
        },
    ]
    } );

    /**************crud functions***********************/
    /** check if the bin is clicked */
    var checking = true;
    $('#recent').on('click',function(){
        checking = false;
    });
    $('.otherForms').on('click',function(){
        checking = true
    });
    /********************************/
    /**************Delete Function*********************/
    $('#dataTable').on('click', '.del', function(){
        var del_id = $(this).attr('id');
        var mylink = (checking) ? '../control/SQL/delete.php': '../control/SQL/permanent_delete.php'
        var warning = confirm("you are trying to Delete Patient record #" + del_id);
        if(warning == true){
            $.ajax({
                url:mylink,
                method:'POST',
                caches:false,
                data:'del_id='+del_id,
                success: function(data){
                    if(checking){
                        $('#dataTable').DataTable().ajax.reload();
                    }else{
                        alert(data);
                    }
                    
                }
            });
        } 
    });
    /***************Edit Function*******************/
    $('#dataTable').on('click', '.edit', function(){
        var edit_id = $(this).attr('id').split("_");
        var mylink = (checking) ? "../control/ajax/ajax_edit.php" : "../control/ajax/restore.php";
        $.ajax({
            url:mylink,
            method:"POST",
            caches:false,
            data:{
                details_id:edit_id[0],
                profile_id:edit_id[1]
            },
            success:function(response){
                if(checking){
                    $("#edit_modal").html(response);
                    $("#data-edit-modal").modal('show'); 
                }else{
                    alert(response);
                    $('#dataTable').DataTable().ajax.reload();
                }

            }
        }); 
    });
    $('#dataTable tbody').delegate('tr td:nth-child(2)', 'click', function(){
        var dataRow = dataTable.row(this).data();
        var fullName = dataRow['name'].split(" ");
        var fName="";
        var mName;
        var lName="";
        var j;
        for(var i = 0; i< fullName.length;i++){
            if(fullName[i].length === 1){
                j = i;
                break;
            }
            fName += " " + fullName[i];
        }
        for(var i=j;i<fullName.length;i++){
            if(fullName[i].length === 1){
                mName = fullName[i];
                j += 1;
            }
        }
        for(var i = j; i<fullName.length;i++){
            lName += " " + fullName[i];
        }

        var pAddress = dataRow['address'];
        var pAge = dataRow['age'];
        var pGender = dataRow['gender'];
        
        document.getElementById("name").value = fName;
        document.getElementById("middle").value = mName;
        document.getElementById("last").value = lName;
        document.getElementById("age").value = pAge;
        document.getElementById("gender").value = pGender;
        document.getElementById("address").value = pAddress;
        $('#data-entry-modal').modal('show');
    });
    /**************search*******************/
    $('#tableSearch').keyup(function(){
        dataTable.search($(this).val()).draw();
    });

    q1 = function(){
        dataTable.ajax.url("../control/fetch/Q1.php");
        dataTable.ajax.reload();
    }
    q2 = function(){
        dataTable.ajax.url("../control/fetch/Q2.php");
        dataTable.ajax.reload();
    }
    q3 = function(){
        dataTable.ajax.url("../control/fetch/Q3.php");
        dataTable.ajax.reload();
    }
    q4 = function(){
        dataTable.ajax.url("../control/fetch/Q4.php");
        dataTable.ajax.reload();
    }
    currentYear = function(){
        dataTable.ajax.url("../control/fetch/currentYear.php");
        dataTable.ajax.reload();
    }
    lastYear = function(){
        dataTable.ajax.url("../control/fetch/lastYear.php");
        dataTable.ajax.reload();
    }
    showAll = function(){
        dataTable.ajax.url("../control/fetch/fetch.php");
        dataTable.ajax.reload();
    }
    recent = function(){
        dataTable.ajax.url("../control/fetch/recent.php");
        dataTable.ajax.reload();
    }
    /***************************************/
    /*****************refresh state**********************/
    if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
    }
    /***************************************/
  });
