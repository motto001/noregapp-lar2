@if(!isset($param['modal']))
@extends('layouts.backend')

@section('content')

    <div class="container">
        <div class="row">
            @include('admin.sidebar')
            <div class="col-md-9">
@endif   

                <div class="panel panel-default">
                    <div class="panel-heading">{{  $param['cim'] or ''  }} </div>
                    <div class="panel-body">
                 
                  <div class="pagination-wrapper"> {!! $data['list']->appends(['search' => Request::get('search')])->render() !!} </div>  
                      
                        <a href="/{{ $param['baseroute'] }}/create/{{ $data['routeparam'] or ''}} " class="btn btn-success btn-sm" title="Add New Wroletime">
                            <i class="fa fa-plus" aria-hidden="true"></i> uj időegység
                        </a>
 @if(isset($data['backurl']))

    @php $backurl='/'.$data['backurl']; @endphp
    <a href="{{ $backurl }}" title="Cancel"><button class="btn btn-warning btn-sm">
    <i class="fa fa-arrow-left" aria-hidden="true"></i> Vissza</button></a>

 @endif

                        
                        <br />
                        <br />

                @if(isset($data['routeparam']))
                    @php $formurl='/'.$param['baseroute'].'/'.$data['routeparam']; @endphp
                @else
                    @php $formurl='/'.$param['baseroute']; @endphp
                @endif       
                        {!! Form::open(['method' => 'GET', 'url' => $formurl , 
                        'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>

                        {!! Form::close() !!}
@include ($param['baseview'].'.table')
                        <br/>
                        <br/>
 
                    </div>
                </div>
            </div>
        </div>
@if(!isset($param['modal']))        
    </div>
@endsection

@endif