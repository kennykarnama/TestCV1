@extends('pengguna.layout.general')

@section('content')
 <div class="columns" id="mail-app">
        <aside class="column is-2 aside hero is-fullheight">
            <div>
                <div class="compose has-text-centered">
                    <a class="button is-danger is-block is-bold">
            <span class="compose">Compose</span>
          </a>
                </div>
                <div class="main">
                    <a href="#" class="item active"><span class="icon"><i class="fa fa-inbox"></i></span><span class="name">Inbox</span></a>
                    <a href="#" class="item"><span class="icon"><i class="fa fa-star"></i></span><span class="name">Starred</span></a>
                    <a href="#" class="item"><span class="icon"><i class="fa fa-envelope-o"></i></span><span class="name">Sent Mail</span></a>
                    <a href="#" class="item"><span class="icon"><i class="fa fa-folder-o"></i></span><span class="name">Folders</span></a>
                </div>
            </div>
        </aside>
        <div class="column is-4 messages hero is-fullheight" id="message-feed">
            <div class="action-buttons">
                <div class="control is-grouped">
                    <a class="button is-small"><i class="fa fa-chevron-down"></i></a>
                    <a class="button is-small"><i class="fa fa-refresh"></i></a>
                </div>
                <div class="control is-grouped">
                    <a class="button is-small"><i class="fa fa-inbox"></i></a>
                    <a class="button is-small"><i class="fa fa-exclamation-circle"></i></a>
                    <a class="button is-small"><i class="fa fa-trash-o"></i></a>
                </div>
                <div class="control is-grouped">
                    <a class="button is-small"><i class="fa fa-folder"></i></a>
                    <a class="button is-small"><i class="fa fa-tag"></i></a>
                </div>
              
            </div>

           
        </div>
        <div class="column is-6 message hero is-fullheight is-hidden" id="message-pane">
            <div class="action-buttons">
                <div class="control is-grouped">
                    <a class="button is-small"><i class="fa fa-inbox"></i></a>
                    <a class="button is-small"><i class="fa fa-exclamation-circle"></i></a>
                    <a class="button is-small"><i class="fa fa-trash-o"></i></a>
                </div>
                <div class="control is-grouped">
                    <a class="button is-small"><i class="fa fa-exclamation-circle"></i></a>
                    <a class="button is-small"><i class="fa fa-trash-o"></i></a>
                </div>
                <div class="control is-grouped">
                    <a class="button is-small"><i class="fa fa-folder"></i></a>
                    <a class="button is-small"><i class="fa fa-tag"></i></a>
                </div>
            </div>
           
        </div>
    </div>
@endsection
