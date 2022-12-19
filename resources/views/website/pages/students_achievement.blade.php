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
                            <h2> لوحة انجاز الطالبات</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- .wpo-breadcumb-area end -->
        <!-- wpo-event-details-area start -->
        <div class="section-padding">
            <div class="container">
              <div>
                <div class="form-group">
                    <label for="sel1">اختر الحلقة</label>
                    <select class="form-control" id="readingcycle_id" name="readingcycle_id" onChange="changeReading(this.value)">
                        <option>اختر</option>
                    @foreach($readingcycles as $readingcycle)
                      <option value="{{ $readingcycle->id }}" >{{ $readingcycle->name }}</option>
                    @endforeach         
                    </select>
                  </div>
              </div>
             <div class="table-contanier">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="min-width: 200px;">اسم الطالبة</th>
                            <th>الجزء (1)</th>
                            <th>الجزء (2)</th>
                            <th>الجزء (3)</th>
                            <th>الجزء (4)</th>
                            <th>الجزء (5)</th>
                            <th>الجزء (6)</th>
                            <th>الجزء (7)</th>
                            <th>الجزء (8)</th>
                            <th>الجزء (9)</th>
                            <th>الجزء (10)</th>
                            <th>الجزء (11)</th>
                            <th>الجزء (12)</th>
                            <th>الجزء (13)</th>
                            <th>الجزء (14)</th>
                            <th>الجزء (15)</th>
                            <th>الجزء (16)</th>
                            <th>الجزء (17)</th>
                            <th>الجزء (18)</th>
                            <th>الجزء (19)</th>
                            <th>الجزء (20)</th>
                            <th>الجزء (21)</th>
                            <th>الجزء (22)</th>
                            <th>الجزء (23)</th>
                            <th>الجزء (24)</th>
                            <th>الجزء (25)</th>
                            <th>الجزء (26)</th>
                            <th>الجزء (27)</th>
                            <th>الجزء (28)</th>
                            <th>الجزء (29)</th>
                            <th>الجزء (30)</th>
                        </tr>
                    </thead>
                    <tbody id="student_list">
                         <tr >
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
               </table>
             </div>
            </div>
        </div>
        <!-- wpo-event-details-area end -->
    <div class="wpo-ne-footer">
        <!-- start wpo-site-footer -->
                @include('website.layouts.footer')

        <!-- end wpo-site-footer -->
    </div>
@stop

    @push('scripts')
        <script>
            $('body').on('click', '.saved_part', function() {
                var readingcycle_id = $(this).attr('data-reading_cycle');
                var part = $(this).attr('data-part');
                $.ajax({
                    url: '{{ route('partStore') }}',
                    type: 'GET',
                    data:{readingcycle_id:readingcycle_id,part:part},
                    success: function(response) {
                    $("#student_"+readingcycle_id+"_"+part).replaceWith('<button class="btn btn-success unsaved_part"  id="student_'+readingcycle_id +'_'+part +'" data-part="'+ part+'" data-reading_cycle="'+readingcycle_id+'" ><i class="ti-check"></i></button>');
                    },
                    error: function() {
        
                    }
                });
            });
            $('body').on('click', '.unsaved_part', function() {
                var readingcycle_id = $(this).attr('data-reading_cycle');
                var part = $(this).attr('data-part');
                $.ajax({
                    url: '{{ route('partStore') }}',
                    type: 'GET',
                    data:{readingcycle_id:readingcycle_id,part:part},
                    success: function(response) {
                    $("#student_"+readingcycle_id+"_"+part).replaceWith('<button class="btn btn- saved_part"  id="student_'+readingcycle_id +'_'+part +'" data-part="'+ part+'" data-reading_cycle="'+readingcycle_id+'" >X</button>');    
                    },
                    error: function() {
        
                    }
                });
            });
            function changeReading(readingcycle_id){
                $.ajax({
                    url: '{{ route('getStudents') }}?readingcycle_id='+readingcycle_id,
                    type: 'GET',
                    success: function(response) {
                        $("#student_list").replaceWith(response)

                    },
                    error: function() {

                    }
                });
            }
        </script>
    @endpush


