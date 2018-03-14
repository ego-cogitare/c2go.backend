@extends('layouts.app')

@section('title') Questionnaire @endsection

@section('content')
    <script>
        window.questionnaire = {
            categoryType: {{$type}},
            storagePath: '/storage/',
            fileUpload: '/admin/file/upload',
            podcastsFetch: '/admin/podcast',
            podcastFetch: '/admin/podcast/{id}?type={{$type}}',
            podcastSync: '/admin/podcast/{id}',
            categorySync: '/admin/category/{id}',
            questionsFetch: '/admin/question',
            customTypes: {
                children: {
                  id: 16,
                  name: 'My Kids',
                  questions: [
                    {
                      id: 12,
                      name: 'Number of children',
                      type: 1
                    },
                    {
                      id: 13,
                      name: 'Age category of children',
                      type: 2
                    },
                    {
                      id: 14,
                      name: 'Special needs',
                      type: 2
                    },
                  ]
                },
                location: {
                  id: 15,
                  name: 'Location',
                  questions: [
                    {
                      id: 9,
                      name: 'City',
                      type: 0
                    },
                    {
                      id: 10,
                      name: 'State',
                      type: 0
                    },
                    {
                      id: 11,
                      name: 'Zip Code',
                      type: 0
                    },
                  ]
                }
            }
        };
    </script>
    <script src="{{ asset('js/questionnaire.min.js') }}" defer="defer"></script>
@endsection