function callCrudAction(action,id) {
  $(".btnAddAction").hide();
  var queryString;
  switch(action) {
   case "add":
    //get closest comment list box
    var selector = $(id).closest(".comment-list-box")
     //get text area and post id values
    var txtmessage = selector.find(".txtmessage").val()
    var postid = selector.find(".postid").val()
    var uname= selector.find(".uname").val()
    var uemail= selector.find(".uemail").val()
    console.log(txtmessage + " --" + postid + " --" + uname + " --" + uemail)
    queryString = 'action=' + action+ '&txtmessage=' + txtmessage+'&postid='+ postid+'&uname='+uname+'&uemail='+uemail;
   break; 
  } 

  jQuery.ajax({
  url: "comment_action.php",
  data:queryString,
  type: "POST",
  success:function(data){
    switch(action) {
      case "add":
          $(data).insertAfter(".message-wrap:first");
      break;
    }
    $(".txtmessage").val('');
    $(".uname").val('');
    $(".uemail").val('');
    $(".btnAddAction").show();
    $(".new_comment_area").hide();
  },

    error:function (){}
  });
}
// $(document).ready(function(){
//   $(".add_new_comment").click(function(){ 
//     $(".new_comment_area").show();
//     $('#alert').remove();  
//   });
// });