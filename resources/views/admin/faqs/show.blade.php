@extends('layouts.app')

@section('title') FAQ @endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">FAQ {{ $faq->id }}</div>
                <div class="panel-body">

                    <a href="{{ url('/admin/faqs') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    <a href="{{ url('/admin/faqs/' . $faq->id . '/edit') }}" title="Edit FAQ"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                    <form method="POST" action="{{ url('admin/faqs' . '/' . $faq->id) }}" accept-charset="UTF-8" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-xs" title="Delete FAQ" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                    </form>
                    <br/>
                    <br/>

                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th>ID</th><td>{{ $faq->id }}</td>
                                </tr>
                                <tr><th> Question </th><td> {{ $faq->question }} </td></tr><tr><th> Answer </th><td> {{ $faq->answer }} </td></tr><tr><th> Category </th><td> {{ $faq->category }} </td></tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
