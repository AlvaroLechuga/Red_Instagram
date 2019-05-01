@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @include('includes.message')
            <div class="card pub-image pub-image-detail">
                <div class="card-header">
                    @if($image->user->image)
                    <div class="container-avatar">    
                        <img src="{{ route('user.avatar', ['filename'=> $image->user->image]) }}" class="avatar">
                    </div>
                    @endif
                    <div class="data-user">
                        {{ $image->user->name.' '.$image->user->surname }}
                        <span class="nickname"> {{' | '. $image->user->nick }} </span>

                    </div>
                </div>

                <div class="card-body">
                    <div class="image-container image-detail">
                        <img src="{{ route('image.file', ['filename' => $image->image_path]) }}">
                    </div>

                    <div class="description">
                        <span class="nickname">{{ '@'.$image->user->nick }}</span>
                        <span class="nickname">{{' | '. \FormatTime::LongTimeFilter($image->created_at) }}
                        </span>
                        <p>{{ $image->description }}</p>
                    </div>

                    <div class="likes">

                        <?php $user_like = false ?>
                        @foreach($image->like as $like)
                        @if($like->user->id == Auth::user()->id)
                        <?php $user_like = true ?>
                        @endif
                        @endforeach

                        @if($user_like)
                        <img src="{{ asset('img/hearts-red.png') }}" data-id="{{$image->id}}" class="btn-dislike">
                        @else
                        <img src="{{ asset('img/hearts-black.png') }}" data-id="{{$image->id}}" class="btn-like">
                        @endif
                        <span class="number-likes">{{ count($image->like) }}</span>
                    </div>

                    @if(Auth::user() && Auth::user()->id == $image->user->id)
                    <div class="actions">
                        <a href="{{ route('image.edit', ['id' => $image->id]) }}" class="btn btn-primary btn-sm">Actualizar</a>
                        
                        <button type="button" class="btn btn-info btn-lg btn-danger btn-sm" data-toggle="modal" data-target="#myModal">Borrar</button>

                        
                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">¿Estás seguro?</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Si eliminas esta imagen no se podrá recuperar</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                                        
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="clearfix"></div>
                    <div class="comments">
                        <h2>Comentarios ({{count($image->comments)}})</h2>
                        <hr>

                        <form method="post" action="{{ route('comment.save') }}">
                            @csrf
                            <input type="hidden" name="image_id" value="{{$image->id}}">
                            <p>
                                <textarea class="form-control" name="content" required></textarea>
                                @if($errors->has('content'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$errors->first('content')}}</strong>
                                </span>
                                @endif
                            </p>
                            <input type="submit" value="Enviar" class="btn btn-success" />
                        </form>
                        <hr>
                        @foreach($image->comments as $comment)
                        <div class="comment">
                            <span class="nickname">{{ '@'.$comment->user->nick }}</span>
                            <span class="nickname">{{' | '. \FormatTime::LongTimeFilter($comment->created_at) }}
                            </span>
                            <p>{{ $comment->content }} <br>
                                @if(Auth::check() && ($comment->user_id == Auth::user()->id) || $comment->image->user_id == Auth::user()->id)
                                <a href="{{ route('comment.delete', ['id' => $comment->id]) }}" class="btn btn-danger">Eliminar comentario</a>
                                @endif</p>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
