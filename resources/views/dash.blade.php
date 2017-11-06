@extends('layouts.chats')

@section('custom_defn')
<style type="text/css">@keyframes lds-ripple {
  0% {
    top: 96px;
    left: 96px;
    width: 0;
    height: 0;
    opacity: 1;
  }
  100% {
    top: 18px;
    left: 18px;
    width: 156px;
    height: 156px;
    opacity: 0;
  }
}
@-webkit-keyframes lds-ripple {
  0% {
    top: 96px;
    left: 96px;
    width: 0;
    height: 0;
    opacity: 1;
  }
  100% {
    top: 18px;
    left: 18px;
    width: 156px;
    height: 156px;
    opacity: 0;
  }
}
.lds-ripple {
  position: relative;
}
.lds-ripple div {
  box-sizing: content-box;
  position: absolute;
  border-width: 4px;
  border-style: solid;
  opacity: 1;
  border-radius: 50%;
  -webkit-animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
  animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
}
.lds-ripple div:nth-child(1) {
  border-color: #9672ff;
}
.lds-ripple div:nth-child(2) {
  border-color: #a8ff91;
  -webkit-animation-delay: -0.5s;
  animation-delay: -0.5s;
}
.lds-ripple {
  width: 200px !important;
  height: 200px !important;
  -webkit-transform: translate(-100px, -100px) scale(1) translate(100px, 100px);
  transform: translate(-100px, -100px) scale(1) translate(100px, 100px);
}
</style>

@endsection


@section('leftpane')
    <div class="panel panel-default" width="100%">
      <div class="panel-heading">Chats</div>
      <div class="panel-body">
      <?php
            $users=DB::select('select name,id from users where not id='.Auth::user()->id);
            foreach ($users as $user)
            {
                $out = "<a onclick=\"setchat('".$user->name."')\"><div class='alert alert-success'>". $user->name."</div></a>";
                echo $out;

           }
           ?>
         </div>
         <input type='hidden' id='curusr' value='<?php echo $users[0]->name; ?>'>
         <input type='hidden' id='myname' value='<?php echo Auth::user()->name; ?>'>
  </div>
@endsection

@section('mainwin')


    <div class="panel panel-default msglist" style="padding:25px">
      <div class="panel-heading" id="chatname">
        <div id="typing">
        </div>

      </div>
      <div class="panel-body" id="msgs" style="overflow-y:auto !important;min-height:200px;max-height:200px">


      </div>
      <form class='chatForm' action='/home' method='post' autocomplete="off">
        <div class='form-group'>
          <label for='message'>Message<span id="recvuser"></span></label>
          <input type='text' id="message" name="message" class="form-control" value="">
        </div>
        <div class="">
              <button type="submit" name="button" class="btn btn-primary pull-right" id="subbtn">Send</button>
            </div>
          </form>
        </div>

  </div>


@endsection
