@extends('layouts.app')

@section('content')
    @if(Session::has('fms-messages'))
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @while(! is_null( $messages = Session::pull('fms-messages', null) ) )
                    @if( count($messages) > 0 )
                        @foreach($messages as $message)
                            <div class="alert alert-{{$message['type']}}">
                                {{ $message['message'] }}
                            </div>
                        @endforeach
                    @endif
                @endwhile
            </div>
        </div>
    </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Update FMS</div>

                    <div class="panel-body">
                        @if($hasUpdate)
                            There's a newer version. click the button below to start downloading.
                            <form action="{{ route('fms-updater.update') }}" method="POST">
                                {!! csrf_field() !!}
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        @else
                            Your application is already up to date.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection