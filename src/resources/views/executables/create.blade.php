@extends('pandoapps::layouts.app')

@section('content_pandoapps')
    <section class="content-header">
        <h1 class="pull-left"> {{ $questionnaire->name }} </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        @include('pandoapps::flash-message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div id="start_block" class="container text-center" style="padding: 100px 50px">
                    <button type="button" id="start_button" class="btn btn-success btn-lg" style="padding: 20px 40px">INICIAR <i class="fa fa-play"></i></button>
                </div>
                <div id="questionnaire_form">
                    <p id="timer" style="text-align: center; font-size: 60px; margin-top: 0px;"></p>
                    {!! Form::open(['route' => ['executables.store', request()->parent_id, $questionnaire->id, request()->model_id], 'class' => 'w-100']) !!}
                        <div class="row p-md-5">
                            @foreach($questionnaire->questions as $key => $question)
                                <div class="form-group col-sm-12 col-md-6">
                                    <h4> <span class="font-weight-bold">{!! $key + 1 !!}.</span> {!! $question->description !!} {!! $question->is_required ? '<span class="text-danger"> * </span>' : '' !!}</h4>
                                    @if($question->question_type_id == config('quiz.question_types.OPEN.id'))
                                        <textarea class="form-control" name="{!! $question->id !!}" id="{!! $question->id !!}" rows="2" {!! $question->is_required ? 'required' : '' !!}></textarea>
                                    @else
                                        <div class="form-group">
                                            @foreach($question->alternatives as $alternative)
                                                <div class="radio">
                                                    <label><input type="radio" name="{!! $question->id !!}" {!! $question->is_required ? 'required' : '' !!} value="{!! $alternative->id !!}"> {!! $alternative->description !!}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach    
                            <!-- Submit Field -->
                            <div class="form-group col-sm-12 pt-5">
                                {!! Form::submit('Responder', ['class' => 'btn btn-primary']) !!}
                                <a href="{!! route('executables.index', ['parent_id' => request()->parent_id, 'questionnaire_id' => $questionnaire->id]) !!}" class="btn btn-default">Cancelar</a>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>            
            </div>
        </div>
    </div>
@endsection

@push('scripts_quiz')
    <script src="{{ asset('vendor/pandoapps/js/jquery.min.js') }}" type="text/javascript"></script> 
    <script type="text/javascript">
        $('input[required]').on('invalid', function() {
            this.setCustomValidity('Campo de preenchimento obrigatório.');
        });
        $('textarea[required]').on('invalid', function() {
            this.setCustomValidity('Campo de preenchimento obrigatório.');
        });
        
        $('#questionnaire_form').hide();
    
        $(document).on("click", "#start_button", function() {
            $('#start_block').hide();
            $('#questionnaire_form').show();
            @if(isset($executionTime))
                var time = '{!! $executionTime !!}';
                timer(time);
            @endif
        });
        
        function timer(time) {
            // Set the date we're counting down to
            var countDownDate = new Date(time).getTime();
            
            // Update the count down every 1 second
            setInterval(function () {
            
                // Get today's date and time
                var now = new Date().getTime();
                    
                // Find the distance between now and the count down date
                var distance = countDownDate - now;
                    
                // Time calculations for days, hours, minutes and seconds
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                // Output the result in an element with id="timer"
                document.getElementById("timer").innerHTML = hours + "h "
                    + minutes + "m " + seconds + "s ";
                    
                // If the count down is over, write some text 
                if (distance < 0) {
                    $('form').submit();
                }
            }, 1000);
        }
    </script>
@endpush
