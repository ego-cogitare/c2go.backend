@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Testimonial {{ $testimonial->id }}</div>
                <div class="panel-body">

                    <a href="{{ url('/admin/testimonials') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    <a href="{{ url('/admin/testimonials/' . $testimonial->id . '/edit') }}" title="Edit testimonial"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                    <form method="POST" action="{{ url('admin/testimonials' . '/' . $testimonial->id) }}" accept-charset="UTF-8" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-xs" title="Delete testimonial" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                    </form>
                    <br/>
                    <br/>

                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th>ID</th><td>{{ $testimonial->id }}</td>
                                </tr>
                                <tr><th> User </th><td> {{ $testimonial->user->first_name }} {{ $testimonial->user->last_name }} </td></tr><tr><th> Rate </th><td> {{ $testimonial->rate }} </td></tr><tr><th> Message </th><td> {{ $testimonial->message }} </td></tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
