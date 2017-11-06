var msglist = $(".msglist");

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
  clearBox("msgs");
}
var curchat=setchat($("#curusr").val());

$(document).ready(function (){
var conn = new WebSocket('ws://10.64.12.252:8090');

var chatForm = $(".chatForm"),
    msginp = chatForm.find("#message");

chatForm.on("submit",function(e){
  e.preventDefault();
  var message=msginp.val();
  sendmsg(curchat,message);
var msgs = $("#msgs");
msgs.append('<li>'+message+'</li>');
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
};
conn.onclose=function()
{
  alert("connection lost");
}
function sendmsg(to,msg)
{
  conn.send(JSON.stringify({'to':to,'content':msg}));
  console.log("sent")
}
});
