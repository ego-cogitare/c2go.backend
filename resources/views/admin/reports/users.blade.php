@extends('layouts.app')

@section('title') Profile Registrations @endsection

@section('content')
    <style>
        .tab-content {
            position: relative;
            height: 400px;
        }
        .tab-content > .tab-pane {
            display: block;
            height: 100%;
            width: 100%;
            position: absolute;
            left: 0;
            top: 0;
            visibility: hidden;
        }
        .tab-content > .tab-pane:first-child {
            visibility: visible;
        }
    </style>
    <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">
            <li>
                <a href="#monthly-chart" data-toggle="tab">Monthly</a>
            </li>
            <li>
                <a href="#weekly-chart" data-toggle="tab">Weekly</a>
            </li>
            <li class="active">
                <a href="#dayly-chart" data-toggle="tab">Dayly</a>
            </li>
            <li class="pull-left header"><i class="fa fa-user"></i> Registrations</li>
        </ul>
        <div class="tab-content no-padding">
            <div class="chart tab-pane active" id="dayly-chart"></div>
            <div class="chart tab-pane" id="weekly-chart"></div>
            <div class="chart tab-pane" id="monthly-chart"></div>
        </div>
    </div>
    <script type="text/javascript">
        // LINE CHART
        var line = new Morris.Bar({
            parseTime: false,
            element: 'dayly-chart',
            resize: true,
            data: 
            [{!! implode(',', array_map(function($item) { return "\n{y: '$item[label]', count: $item[count]}"; }, $data['dayly'])) !!}],
            xkey: 'y',
            ykeys: ['count'],
            labels: ['Total'],
            lineColors: ['#3c8dbc'],
            hideHover: 'auto'
        });

        var line = new Morris.Bar({
            parseTime: false,
            element: 'weekly-chart',
            resize: true,
            data: [{!! implode(',', array_map(function($item) { return "\n{y: '$item[label]', count: $item[count]}"; }, $data['weekly'])) !!}],
            xkey: 'y',
            ykeys: ['count'],
            labels: ['Total'],
            lineColors: ['#3c8dbc'],
            hideHover: 'auto'
        });

        var line = new Morris.Bar({
            parseTime: false,
            element: 'monthly-chart',
            resize: true,
            data: [{!! implode(',', array_map(function($item) { return "\n{y: '$item[label]', count: $item[count]}"; }, $data['monthly'])) !!}],
            xkey: 'y',
            ykeys: ['count'],
            labels: ['Total'],
            lineColors: ['#3c8dbc'],
            hideHover: 'auto'
        });
    </script>
@endsection