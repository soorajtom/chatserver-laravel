var msglist = $(".msglist");
var curchat="";
function getmessage()
{
  var myname=$("#myname").val();
  $.ajax({
type: "POST",
url: '/getmess',
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
data: "frm="+ myname + "&to=" + curchat,
success: function(data) {
   console.log("reqchat");
   var msgs = $("#msgs");
   clearBox("msgs");
   msgs.append(data);
   var elem = document.getElementById("msgsbox");
   elem.scrollTop = elem.scrollHeight;
}
});
}

function clearBox(elementID)
{
    document.getElementById(elementID).innerHTML = "";
}
function setchat(c)
{
  curchat=c;
  var heading = $("#chatname");
  clearBox('chatname');
  heading.append(curchat);
  var msg = getmessage();

}


$(document).ready(function (){
  $('#message').keypress(function(e){
      if(e.keyCode==13)
      {
      $('#subbtn').click();
      // $('#message').val("");
    }
  });

  $('#message').keyup(function(e){
    {
      if(e.keyCode != 13)
      {
        var chatForm = $(".chatForm");
        var msginp = chatForm.find("#message").val();
      sendmsg(curchat,msginp,1);
      }
    }
    });


  curchat=$("#curusr").val();
  setchat(curchat);
var conn = new WebSocket('ws://10.64.12.252:8090');

var chatForm = $(".chatForm"),
    msginp = chatForm.find("#message");

chatForm.on("submit",function(e){
  e.preventDefault();
  var message=msginp.val();
  if(message =="")
  return false;
  sendmsg(curchat,message, 0);
var msgs = $("#msgs");
msgs.append('<tr><td><div class=\'well well-sm\' style="background:rgb(22,105,173);color:rgb(255,255,255);min-width:40%;float:right;display:inline-block;">'+message+'</div></td></tr>');
var elem = document.getElementById("msgsbox");

$('#message').val("");
elem.scrollTop = elem.scrollHeight;
  return false;
});





console.log("almost there");
conn.onopen = function(e){
  console.log("Connection established");
  var myname=$("#myname").val();
  conn.send(myname);
};

conn.onmessage=function(e)
{
  console.log("receiving")
  console.log(e.data);
  var msgs = $("#msgs");
  var dat = JSON.parse(e.data);
  if (dat.mode==0)
  {
    clearBox('livetype');
    //setchat( dat.from_user_id);
    if(curchat == dat.from_user_id)
    {

      msgs.append('<tr ><td><div class=\'well well-sm\' style="min-width:40%;float:left;display:inline-block;">'+dat.msga+'</div></td></tr>');
      var elem = document.getElementById("msgsbox");
      elem.scrollTop = elem.scrollHeight;
    }

}
else if(dat.mode==4)
{
  if(curchat==dat.from_user_id)
  {
    var heading = $("#livetype");
    clearBox('livetype');
    if(dat.msga!="")
    heading.append('<strong> typed </strong>'+dat.msga);
  }
}

};
conn.onclose=function()
{
  alert("connection lost");
}
function sendmsg(rec,msg,mode)
{
  var sdata = JSON.stringify({'to':rec,'content':msg, 'mod':mode});
  console.log(sdata);
  conn.send(sdata);
  console.log("sent")
  if(msg=="")
  {
      clearBox('livetype');
  }
}
});
