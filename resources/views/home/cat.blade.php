@extends('layouts.app')

@section('title', 'cat')

@section('content')

    @if(isset($cat))
    <div>Where are my cats?</div>
    @endif

    <div class="row">
        <div class="col-8">
            @foreach($cats as $cat)
                @if($cat->trashed())
                    <del>
                @endif
                <a class="{{$cat->trashed() ? 'text-muted' : ''}}"
                    href="{{route('cats.show', ['cat' => $cat->id])}}">{{$cat['name']}}
                </a>

                @if($cat->trashed())
                    </del>
                @endif

                <p>{{$cat['age']}}</p>

{{--                <p class="text-muted">--}}
{{--                    Added {{\Carbon\Carbon::parse($cat['created_at'])->diffForHumans() }}--}}
{{--                    by {{$cat->user->name}}--}}
{{--                </p>--}}

                @update(['date' => $cat->created_at, 'name' => $cat->user->name, 'userId' => $cat->user->id])
                @endupdate
                @tags(['tags' => $cat->tags]) @endtags

                @if($cat->comments_count)
                    <p>{{$cat->comments_count}} comments</p>
                @else
                    <p>No comments yet!</p>
                @endif

                <div class="mb-3">

                    @auth
                        @can('update', $cat)
                            <a href="{{route('cats.edit', ['cat' => $cat->id])}}" class="btn btn-primary">Edit</a>
                        @endcan
                    @endauth

                    @cannot('delete', $cat)
                        <p>You can't delete this cat!!!</p>
                    @endcannot

                    @if(!$cat->trashed())
                        @auth
                            @can('delete', $cat)
                                <form class="d-inline" action="{{route('cats.destroy', ['cat' => $cat->id])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Delete" class="btn btn-primary">
                                </form>
                            @endcan
                        @endauth
                    @endif
                </div>

{{--            <x-tags :tags="$cat->tags" />--}}

            @endforeach
        </div>
        <div class="col-4">
            @include('posts.partials.activity')
        </div>
    </div>

@endsection
