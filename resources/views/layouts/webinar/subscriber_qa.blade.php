
@if(isset($ownQas))
<header class="top-bar">
    <div class="left">
        <h1>My Questions</h1>
    </div>
</header>
<ul class="discussion">
    @foreach($ownQas as $qa)
    <li class="other">
        <div class="avatar">
            <img src="{{ asset('assets/members/images/avatar-1.jpg') }}" />
        </div>
        <div class="messages">
            <p>{{$qa->question}}</p>
            <time datetime='{{$qa->question_datetime}}'>@ {{$qa->first_name}} {{ $qa->last_name }} • {{$qa->question_ask_before}} s before</time>
        </div>
    </li>
    <li class="self">
        <div class="avatar">
            <img src="{{ asset('assets/members/images/avatar-2.jpg') }}" />
        </div>
        <div class="messages">
            <p>{{ $qa->answer }}</p>
            <time datetime="2009-11-13T20:14">@MR 37 • mins</time>
        </div>
    </li>
    @endforeach
</ul>
@endif
<input id="asked_question_add_in_my" class="quest-control" type="text" placeholder="Ask your Questions here ???"></input>
<!-- <input class="send-btn" type="submit" name="submit" value="send"> -->
<button class="send-btn" id="question_add_in_my">Send</button>