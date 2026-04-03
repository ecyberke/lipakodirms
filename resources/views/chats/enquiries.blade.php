@extends('layouts.home')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Complaints and Replies</h4>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title mb-4">Latest Trasaction</h4>

                    </div>
                </div>
                <div class="card">
                    <ul class="message-list">
                        <li>
                            <div class="col-mail col-mail-1">
                                <div class="checkbox-wrapper-mail">
                                    <input type="checkbox" id="chk9">
                                    <label for="chk9" class="toggle"></label>
                                </div>
                                <a href="#" class="title">Death to Stock</a><span
                                    class="star-toggle fa fa-star-o"></span>
                            </div>
                            <div class="col-mail col-mail-2">
                                <a href="#" class="subject">Montly High-Res Photos –
                                    <span class="teaser">To create this month's pack, we hosted a party with
                                        local musician Jared Mahone here in Columbus, Ohio.</span>
                                </a>
                                <div class="date">Feb 28</div>
                            </div>
                        </li>
                        <li class="unread">
                            <div class="col-mail col-mail-1">
                                <div class="checkbox-wrapper-mail">
                                    <input type="checkbox" id="chk3">
                                    <label for="chk3" class="toggle"></label>
                                </div>
                                <a href="#" class="title">Randy, me (5)</a><span
                                    class="star-toggle fa fa-star-o"></span>
                            </div>
                            <div class="col-mail col-mail-2">
                                <a href="#" class="subject"><span
                                        class="badge-success badge mr-2">Family</span>Last pic over my
                                    village –
                                    <span class="teaser">Yeah i'd like that! Do you remember the video you
                                        showed me of your train ride between Colombo and Kandy? The one with
                                        the mountain view? I would love to see that one again!</span>
                                </a>
                                <div class="date">5:01 am</div>
                            </div>
                        </li>
                        <li>
                            <div class="col-mail col-mail-1">
                                <div class="checkbox-wrapper-mail">
                                    <input type="checkbox" id="chk13">
                                    <label for="chk13" class="toggle"></label>
                                </div>
                                <a href="#" class="title">Tobias Berggren</a><span
                                    class="star-toggle fa fa-star-o"></span>
                            </div>
                            <div class="col-mail col-mail-2">
                                <a href="#" class="subject">Let's go fishing! –
                                    <span class="teaser">Hey, You wanna join me and Fred at the lake
                                        tomorrow? It'll be awesome.</span>
                                </a>
                                <div class="date">Feb 23</div>
                            </div>
                        </li>
                        <li>
                            <div class="col-mail col-mail-1">
                                <div class="checkbox-wrapper-mail">
                                    <input type="checkbox" id="chk14">
                                    <label for="chk14" class="toggle"></label>
                                </div>
                                <a href="#" class="title">Charukaw, me (7)</a><span
                                    class="star-toggle fa fa-star-o"></span>
                            </div>
                            <div class="col-mail col-mail-2">
                                <a href="#" class="subject">Hey man – <span class="teaser">Nah man sorry i
                                        don't. Should i get it?</span>
                                </a>
                                <div class="date">Feb 23</div>
                            </div>
                        </li>
                        <li class="unread">
                            <div class="col-mail col-mail-1">
                                <div class="checkbox-wrapper-mail">
                                    <input type="checkbox" id="chk15">
                                    <label for="chk15" class="toggle"></label>
                                </div>
                                <a href="#" class="title">me, Peter (5)</a><span
                                    class="star-toggle fa fa-star-o"></span>
                            </div>
                            <div class="col-mail col-mail-2">
                                <a href="#" class="subject"><span
                                        class="badge-info badge mr-2">Support</span>Home again! – <span
                                        class="teaser">That's just perfect! See you tomorrow.</span>
                                </a>
                                <div class="date">Feb 21</div>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title mb-4">Chat</h4>
                        <div class="chat-conversation">
                            <ul class="conversation-list slimscroll" style="max-height: 400px;">
                                <li class="clearfix">
                                    <div class="chat-avatar">
                                        <img src="assets/images/users/user-2.jpg" alt="male">
                                        <span class="time">10:00</span>
                                    </div>
                                    <div class="conversation-text">
                                        <div class="ctext-wrap">
                                            <span class="user-name">John Deo</span>
                                            <p>
                                                Hello!
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="clearfix odd">
                                    <div class="chat-avatar">
                                        <img src="assets/images/users/user-3.jpg" alt="Female">
                                        <span class="time">10:01</span>
                                    </div>
                                    <div class="conversation-text">
                                        <div class="ctext-wrap">
                                            <span class="user-name">Smith</span>
                                            <p>
                                                Hi, How are you? What about our next meeting?
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <div class="chat-avatar">
                                        <img src="assets/images/users/user-2.jpg" alt="male">
                                        <span class="time">10:04</span>
                                    </div>
                                    <div class="conversation-text">
                                        <div class="ctext-wrap">
                                            <span class="user-name">John Deo</span>
                                            <p>
                                                Yeah everything is fine
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="clearfix odd">
                                    <div class="chat-avatar">
                                        <img src="assets/images/users/user-3.jpg" alt="male">
                                        <span class="time">10:05</span>
                                    </div>
                                    <div class="conversation-text">
                                        <div class="ctext-wrap">
                                            <span class="user-name">Smith</span>
                                            <p>
                                                Wow that's great
                                            </p>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                            <div class="row">
                                <div class="col-sm-9 col-8 chat-inputbar">
                                    <textarea class="form-control chat-input"
                                        placeholder="Enter your text"></textarea>
                                </div>
                                <div class="col-sm-3 col-4 chat-send">
                                    <button type="submit" class="btn btn-success btn-block">Send
                                        Reply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
