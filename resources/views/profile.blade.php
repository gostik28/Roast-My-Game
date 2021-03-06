@extends('app')

@section('page-title'){{$user->username}}'s Profile - {{Config::get('app.name')}}@endsection

@section('page-description')View {{$user->username}}'s Profile on Roast My Game.@endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">

                    @include('partials.display-input-error')

                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-sm-2 col-xs-2">
                            <div class="embed-responsive embed-responsive-1by1">
                                <div class="embed-responsive-item">
                                    {!! $user->getProfileImage('100%', 'user-profile-default-font-responsive') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-5 col-sm-8 col-xs-10">
                            <h4>{{$user->username}}'s Profile</h4>
                            <p class="bold-uppercase subheading-color">Ranked #{{$user->getRank()}}</p>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-2 col-xs-12">
                            <div class="trophy-box" style="background-image: url('/images/{{$user->getTrophyImage()}}');">
                                <h5 class="text-center" style="margin-bottom: 0px" id="level">{{$user->getLevel()}}</h5>
                            </div>
                            <b><p class="text-center" style="margin-bottom: 0px">{{$user->points}} Points{!! $user->getBadge() !!}</p></b>
                        </div>
                    </div>



                    <h6 class="subheading subheading-color">Games</h6>
                    @if(count($games) > 0)
                        @foreach($games as $game)

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <a href="{{ secure_url('/game/'.$game->slug) }}">
                                            <div class="embed-responsive-item card-image-cover" style="background-image: url('{{Utils::get_image_url($game->slug.'/'.$game->thumbnail)}}');"> </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="@if($isTheLoggedInUser) col-sm-6 @else col-sm-9 @endif">
                                    <a href="{{ secure_url('/game/'.$game->slug) }}"><h6 class="list-group-item-heading card-title">{{$game->title}}</h6></a>

                                    <div class="label label-default" style="margin-right: 5px;"><span class="icon-eye"></span> {{$game->views}} </div>
                                    <div class="label label-default" style="margin-right: 5px;"><span class="icon-heart"></span> {{$game->likes}} </div>
                                    @if($isTheLoggedInUser)
                                        <a class="label label-warning" href="{{ secure_url('/promote/'.$game->slug) }}" id="promote-{{$game->slug}}"><span class="icon-star"></span> Promote</a>
                                    @endif
                                    <p class="list-group-item-text card-description">{{clean($game->description, 'noneAllowed')}}</p>
                                </div>

                                @if($isTheLoggedInUser)
                                    <div class="col-sm-3">
                                        <a class="btn btn-success-outline pull-right btn-block" href="{{ secure_url('/add-version/'.$game->slug) }}"><span class="icon-plus"></span> Add Progress</a>
                                        <a class="btn btn-info-outline pull-right btn-block" href="{{ secure_url('/edit-game/'.$game->slug.'/'.$game->versions->first()->slug) }}" id="edit-{{$game->slug}}"><span class="icon-pencil"></span> Edit Game</a>
                                        <a class="btn btn-info-outline pull-right btn-block" href="{{ secure_url('/add-downloads/'.$game->slug) }}" id="edit-downloads-{{$game->slug}}"><span class="icon-pencil"></span> Edit Downloads</a>
                                    </div>
                                @endif
                                
                            </div>
                            <hr>
                        @endforeach
                    @else
                        <h4 class="text-center"><div class="font-light-gray">No games here</div></h4>
                        <br>
                    @endif

                    <h6 class="subheading subheading-color">Roasts</h6>
                    @if(count($comments) > 0)
                        @foreach($comments as $comment)
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    @if(isset($comment->positive))
                                        <i class="icon-thumbs-up-alt font-light-gray"></i> {{ App\Feedback::$feedbackCategories[$comment->positive] }}  @endif

                                    @if(isset($comment->negative)) <b><i class="icon-thumbs-down-alt font-light-gray"></i></b> {{ App\Feedback::$feedbackCategories[$comment->negative] }}  @endif

                                    <p>{!! str_replace( "\n", '<br />', clean($comment->body)) !!}</p>
                                    <small><span class="icon-clock"></span> {{ $comment->created_at->diffForHumans() }}
                                        @if($comment->my_commentable_type == 'Game')
                                            <a href="{{ secure_url('/game/'.App\Game::where('id', $comment->commentable_id)->first()->slug) }}"><span class="icon-link-ext-alt small"></span></a>
                                        @elseif($comment->my_commentable_type == 'Discussion')
                                            <a href="{{ secure_url('/forum/'. App\Discussion::where('id', $comment->commentable_id)->first()->slug) }}"><span class="icon-link-ext-alt small"></span></a>
                                        @endif
                                    </small>

                                </div>
                            </div>
                        @endforeach
                    @else
                        <h4 class="text-center"><div class="font-light-gray">No comments here</div></h4>
                        <br>
                    @endif

                    <h6 class="subheading subheading-color">Liked</h6>
                    @if(count($likes) > 0)
                        @foreach($likes as $like)
                            <p><a href="{{ secure_url('/game/'.$like->game->slug) }}">{{ $like->game->title }}</a></p>
                        @endforeach
                    @else
                        <h4 class="text-center"><div class="font-light-gray">No likes here</div></h4>
                    @endif

                    <br>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <div class="col-md-8 col-md-offset-2">
        @include('partials/footer')
    </div>
@endsection