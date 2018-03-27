@extends('layouts.app')

@section('title') Event view @endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">event {{ $event->id }}</div>
                <div class="panel-body">

                    <a href="{{ url('/admin/events') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    <a href="{{ url('/admin/events/' . $event->id . '/edit') }}" title="Edit event"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                    <form method="POST" action="{{ url('admin/events' . '/' . $event->id) }}" accept-charset="UTF-8" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-xs" title="Delete event" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                    </form>
                    <br/>
                    <br/>

                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $event->id }}</td>
                                </tr>
                                <tr>
                                    <th> Category Id </th>
                                    <td> {{ $event->category->name }} </td>
                                </tr>
                                <tr>
                                    <th> User Id </th>
                                    <td> {{ $event->user->getFullName() }} </td>
                                </tr>
                                <tr>
                                    <th> Name </th>
                                    <td> {{ $event->name }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
