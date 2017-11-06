@extends('layouts.chats')

@section('leftpane')
    <div class="panel panel-default" width="100%">
      <div class="panel-heading">Chats</div>
      <div class="panel-body" style="overflow-y:auto !important;min-height:430px;max-height:430px">
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
      <div class="panel-heading" >
        <span id ="chatname" style="font-size:1.2em"></span> <span id="livetype"></span>
      </div>
      <div class="panel-body" id="msgsbox"  style="overflow-y:auto !important;min-height:300px;max-height:300px">
        <table width=100% id="msgs">
        </table>


      </div>
      <form class='chatForm' action='/home' method='post' autocomplete="off">
        <div class='form-group'>
          <label for='message'>Enter Message<span id="recvuser"></span></label>
          <input type='text' id="message" name="message" class="form-control" value="">
        </div>
        <div class="">
              <button type="submit" name="button" class="btn btn-primary pull-right" id="subbtn">Send Message</button>
            </div>
          </form>
        </div>

  </div>


@endsection
