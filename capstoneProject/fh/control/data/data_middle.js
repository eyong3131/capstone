$(document).ready(function(){
    dataTable = $('#dataTable').DataTable( {
        "processing":true,
        "oSearch": {
          "bSmart": false, 
          "bRegex": true,
          "sSearch": ""                
      },
        "ajax": {
          type:"POST",
          url:"../control/fetch/fetch.php",
          dataType : "json"
        },  
      "columns": [
        { "data": "user_id" },
        { "data": "name" },
        { "data": "middle" },
        { "data": "last" },
        { "data": "age" },
        { "data": "gender" },
        { "data": "address" },
        { "data": "email" },
        { "data": "time_joined" },
        { "data": "date_joined"},
        { "data": "user_status"}
        
    ],    
      "columnDefs": [ {
        "targets": 11,
        "data": "email",
        "render": function (data, type, full) {
          /*
          var drop_del = '<div class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg></div>';
          var drop_edit = '<div class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/></svg></div>'; 
          
          var div_row = '<div class="row">'
          var dropdown_edit = div_row + '<div class="dropdown_edit col-sm-5">'+ drop_edit +'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
          var dropdown_del = '<div class="dropdown_delete col-sm-1">'+ drop_del +'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
         
          
          var email = full.email.split('<br>');
          var person_id = full.user_id.split(' ');
          
          
          for (var i=0; i < full.email.split('<br>').length; i++) {
            dropdown_edit += '<button id="' + person_id[i] + '" class="dropdown-item edit">' + email[i] + '</button>';
          }
          dropdown_edit += '</div></div>';
          for (var i=0; i < full.email.split('<br>').length; i++) {
            dropdown_del += '<button id="' + person_id[i] + '" class="dropdown-item del">' + email[i] +'</button>';
          }
          drop_del += '</div></div></div>';
          
          return dropdown_edit + dropdown_del;
          */
         var iconsDel = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>'
         var iconEdit = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/></svg>'
         return "<pre><button id=\""+full.user_id+"\" data-detail=\""+full.illness+"\"\" class=\"edit crud btn btn-sm btn-outline-primary\" data-toggle=\"modal\" data-target=\"#edit-data-modal\">"+iconEdit+"</button><button id=\""+full.user_id+"\" data-detail=\""+full.date+"\"\" class=\"del crud btn btn-sm btn-outline-danger\">"+iconsDel+"</button></pre>" ;
        }
      }
    ], dom: 'lBfrtip',
    buttons: [
        {
            text:'Refresh',
            className:' btn btn-sm btn-info',
            id:'ref',
            action: function( e, dt, node, config ){
                $('#dataTable').DataTable().ajax.reload();
            }
        },
        {
          text:'Add User',
          className:' btn btn-sm btn-info',
          action: function(){
              $("#data-entry-modal").modal('show'); 
          }
        }
      ]
    } );
    /**************crud functions***********************/
    
    $('#dataTable').on('click', '.del', function(){
        var del_id = $(this).attr('id');
        var warning = confirm("your trying to Delete User  #" + del_id +" this action cannot be reversed");
        if(warning == true){
            $.ajax({
                type:'POST',
                url:'../control/SQL/delete.php',
                data:{
                  delete_id:del_id
                },
                success: function(data){
                    $('#dataTable').DataTable().ajax.reload();
                }
            });
        } 
    });
    
    /***************Edit Function*******************/
    
    $('#dataTable').on('click', '.edit', function(){
        var edit_id = $(this).attr('id');
        $.ajax({
            url:"../control/ajax/ajax_edit.php",
            method:"post",
            caches:false,
            data:{
                details_id:edit_id
            },
            success:function(response){
                $("#edit_modal").html(response);
                $("#data-edit-modal").modal('show'); 
            }
        }); 
    });
    
    /**************search*******************/
    $('#tableSearch').keyup(function(){
        dataTable.search($(this).val()).draw();
    });
    /***************************************/
    $(".fullName").keypress(function(event) {
      var character = String.fromCharCode(event.keyCode);
      return isValid(character);     
      });
      function isValid(str) {
          return !/[~`!@#$%\^&*()+=\-\[\]\\';,/{}|\\":<>\?1234678905]/g.test(str);
      }
    /*****************refresh state**********************/
    if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
    }
    $(window).load(function(){
      $('.wrapper').delay(500).fadeOut();
    });
    /***************************************/
  });
