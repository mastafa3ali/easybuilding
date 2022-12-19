@extends('website.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('assignments.plural') }}</title>
@endsection
@section('content')
       <!-- .wpo-breadcumb-area start -->
        <div class="wpo-breadcumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="wpo-breadcumb-wrap">
                            <h2> لوحة انجاز الخاتمات</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- .wpo-breadcumb-area end -->
        <!-- wpo-event-details-area start -->
        <div class="section-padding">
            <div class="container">
             <div class="table-contanier">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="min-width: 200px;">اسم الطالبة</th>
                            @foreach ($tracks as $track)
                            <th>({{ $loop->iteration }})</th>
                            @endforeach
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            
                        <tr>
                            <td>{{ $student->name }}</td>
                            @foreach ($tracks as $track)
                            <td>
                                  @if (in_array($student->id,$track->studentsTrack()->pluck('student_id')->toArray()))    
                                    <button class="btn btn-success unsaved_track" id="student_{{ $student->id }}_{{ $track->id }}" data-track="{{ $track->id }}" data-student_id="{{ $student->id }}" >
                                        <i class="ti-check"></i>
                                    </button>
                                    @else
                                    <button class="btn btn- saved_track"  id="student_{{ $student->id }}_{{ $track->id }}" data-track="{{ $track->id }}" data-student_id="{{ $student->id }}">X</button>
                                    @endif
                            </td>
                            @endforeach
                        
                        </tr>
                        @endforeach
                        @if (count($tracks)==0)
                            
                        <tr>
                            <td colspan="{{  count($tracks)+1 }}">
                                <div class="alert alert-danger  text-center">لا تــوجـد بـيـانـــات</div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
               </table>
             </div>
            </div>
        </div>
    <div class="wpo-ne-footer">
        <!-- start wpo-site-footer -->
                @include('website.layouts.footer')

        <!-- end wpo-site-footer -->
    </div>
@stop
  @push('scripts')
        <script>
            $('body').on('click', '.saved_track', function() {
                var student_id = $(this).attr('data-student_id');
                var track_id = $(this).attr('data-track');
                $.ajax({
                    url: '{{ route('trackStore') }}',
                    type: 'GET',
                    data:{student_id:student_id,track_id:track_id},
                    success: function(response) {
                    $("#student_"+student_id+"_"+track_id).replaceWith('<button class="btn btn-success unsaved_track"  id="student_'+student_id +'_'+track_id +'" data-track="'+ track_id+'" data-student_id="'+student_id+'" ><i class="ti-check"></i></button>');
                    },
                    error: function() {
        
                    }
                });
            });
            $('body').on('click', '.unsaved_track', function() {
                var student_id = $(this).attr('data-student_id');
                var track_id = $(this).attr('data-track');
                $.ajax({
                    url: '{{ route('trackStore') }}',
                    type: 'GET',
                    data:{student_id:student_id,track_id:track_id},
                    success: function(response) {
                    $("#student_"+student_id+"_"+track_id).replaceWith('<button class="btn btn- saved_track"  id="student_'+student_id +'_'+track_id +'" data-track="'+ track_id+'" data-student_id="'+student_id+'" >X</button>');    
                    },
                    error: function() {
        
                    }
                });
            });
        </script>
    @endpush



