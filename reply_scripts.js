function callCrudActionr(action,id) {
    var queryString;
    switch(action) {
      case "addr":
      //get closest comment list box
        var selector = $(id).closest(".comment-list-boxr")
        //get text area and post id values
        var txtmessager = selector.find(".txtmessager").val()
        var postidr = selector.find(".postidr").val()
         var postm = selector.find(".postm").val()
          var unamer= selector.find(".unamer").val()
           var uemailr= selector.find(".uemailr").val()
        queryString = 'action=' + action+ '&txtmessager=' + txtmessager+'&postidr='+ postidr+'&postm='+ postm+'&unamer='+ unamer+'&uemailr='+ uemailr;
      break;
      
    }  
    jQuery.ajax({
    url: "reply_action.php",
    data:queryString,
    type: "POST",
    success:function(data){
      switch(action) {
        case "addr":
          //selector.append(data);
           $(data).insertAfter(".message-wrapcm-"+ postidr +":first");
        selector.find(".txtmessager").hide()
         selector.find(".unamer").hide()
          selector.find(".uemailr").hide()
         selector.find(".btnAddActionr").hide() 
              selector.find(".btnAddActionclose").hide()
              selector.find(".add_comment").show();
              selector.find(".ap").remove();
        break;
      }
      $(".txtmessager").val('');
    },
    error:function (){}
    });
  }
            function reply_form(id,postid)
            {
              $('#reply_area_'+ id ).append('<div class="ap" id="ap_'+id+'"><br><textarea name="txtmessager" class="txtmessager form-control" placeholder="Type reply" id="textarear" cols="auto" rows="2"></textarea><br><div class="row"><div class="col-sm-6"><input type="text" id="unamer" placeholder="Full Name" class="unamer form-control" required></div><div class="col-sm-6"><input type="email" id="uemailr" class="uemailr form-control"placeholder="Your Email "  required></div></div><input type="hidden" value="'+id+'" name="postidr" class="postidr"><input type="hidden" value="'+postid+'" name="postm" class="postm"><br><div class="row"><div class="col-sm-12"><button class="btnAddActionr btn btn-success" name="submit" onClick="callCrudActionr(\'addr\',this))">Add Reply</button> <button class="btnAddActionclose btn btn-warning" name="submit" onClick="closeArea('+id+')">Close </button></div></div><br></div>');
              $('#reply_'+ id ).hide(); 
              $('#alert').remove();  
  
            }
      
          function closeArea(id)
          {
          $('#ap_'+ id ).remove(); 
            $('#reply_'+ id ).show();   
          }
  
   