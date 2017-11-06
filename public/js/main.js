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
   var elem = document.getElementById("msgs");
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
      $('#message').val("");
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
  sendmsg(curchat,message, 0);
var msgs = $("#msgs");
msgs.append('<div style="text-align:right; padding:3px;margin:3px;">'+message+'</div>');
var elem = document.getElementById("msgs");
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
    setchat( dat.from_user_id);

    msgs.append('<div style="text-align:left; padding:3px;margin:3px;">'+dat.msga+'</div>');
  var elem = document.getElementById("msgs");
  elem.scrollTop = elem.scrollHeight;

}

};
conn.onclose=function()
{
  alert("connection lost");
}
function sendmsg(rec,msg,mode)
{
  var sdata = JSON.stringify({'to':rec,'content':msg, 'mode':mode});
  console.log(sdata);
  conn.send(sdata);
  console.log("sent")
}
});
