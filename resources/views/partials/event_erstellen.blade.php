@push('styles')
<link rel="stylesheet" href="{{ asset('assets/jquery-datetimepicker/build/jquery.datetimepicker.min.css') }}">
@endpush


@include('partials.alert')
    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aufgabe erstellen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        <p>
                            <label for="title">Titel</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" autofill="off" autocomplete="off">
                        </p>
                        <p>
                            <label for="title">Beschreibung</label>
                            <input type="text" name="description" id="description" value="{{ old('description') }}">
                        </p>
                        <p>
                            <label for="title">Ort</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}">
                        </p>
                        <p>
                            <label for="calendar_id">Kalender</label>
                            <select name="calendar_id" id="calendar_id">
                                @foreach($calendars as $cal)
                                <option value="{{ $cal->calendar_id }}">{{ $cal->title }}</option>
                                @endforeach
                            </select>
                        </p>
                        <p>
                            <label for="datetime_start">Beginn</label>
                            <input type="text" name="datetime_start" id="datetime_start" class="datetimepicker" value="{{ old('datetime_start') }}">
                        </p>
                        <p>
                            <label for="datetime_end">Ende</label>
                            <input type="text" name="datetime_end" id="datetime_end" class="datetimepicker" value="{{ old('datetime_end') }}">
                        </p>
                        <p>
                            <label for="title">Priorität</label>
                            <input type="text" name="priority" id="priority" value="{{ old('priority') }}">
                        </p>
                        <div id="attendees">
                            Teilnehmer
                            <div class="attendee-row">
                                <input type="text" name="attendee_name[]" class="half-input name" placeholder="Name" autocomplete="name">
                                <input type="email" name="attendee_email[]" class="half-input email" placeholder="E-Mail" autocomplete="email">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success createsubmit" data-dismiss="modal">Speichern</button>
                </div>
            </div>
        </div>
    </div>


<!-- @section('attendee_template')
<script id="attendee-template" type="text/x-handlebars-template">
    <div class="attendee-row">
        <input type="text" name="attendee_name[]" class="half-input name" placeholder="Name" autocomplete="name">
        <input type="email" name="attendee_email[]" class="half-input email" placeholder="Email" autocomplete="email">
    </div>
</script>
@endsection-->

    @push('scripts')
<!--<script src="https://code.jquery.com/jquery-3.3.1.min.js "></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.11/handlebars.min.js"></script>-->
<script src="{{ asset('assets/jquery-datetimepicker/build/jquery.datetimepicker.full.min.js') }}"></script>
<script src="{{ asset('assets/create_event.js') }}"></script>
@endpush