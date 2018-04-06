@extends('layouts.app')


@section('content')
    <style>
        .hidden{
            display: none;
        }
    </style>
    <!-- Neues ToDo erstellen -->
    <button id="buttonNewToDO">Neue Aufgabe</button>
    <div id="newToDo" class="hidden">
        Hier könnteN deine Aufgaben erstellen feldern stehen
    </div>

    <!-- Liste aller persönlichen ToDos -->
    @foreach ($todos as $todo)
        <div id="{{$todo->id}}">
            <div class="titel">
                {{ $todo->titel }}
                    <div class="">
                        <button value="{{$todo->id}}" class="btn-dell">x</button>
                        <button value="{{$todo->id}}" class="edit" type="button" data-toggle="modal" data-target="#edit">
                            Edit
                        </button>
                    </div>
            </div>
            <div>Titel:
                <div id="{{$todo->id}}title">
                {{ $todo->title }}
                </div>
            </div>
            <div>Beschreibung:
                {{ $todo->description }}
            </div>
            <div>Priorität:
                {{ $todo->priority }}
            </div>
            <div>Aufwand:
                {{ $todo->duration }}
            </div>
            <div>Ort:
                {{ $todo->location }}
            </div>
        </div>
        </br>
    @endforeach
    <!-- Liste aller persönlichen ToDos ENDE -->

    <!-- Edit a todo -->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aufgabe bearbeiten</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="title">Titel:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title_edit" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="description">Beschreibung:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="description_edit" cols="20" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="priority">Priorität:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="priority_edit" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="duration">Aufwand:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="duration_edit" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="location">Ort:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="location_edit" autofocus>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Speichern</button>
                </div>
            </div>
        </div>
    </div>

@endsection



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".btn-dell").click(function () {
            var idElementToDelete = $(this).val();
            var divToRemove = $('#'+idElementToDelete);

            $.ajax({
                type: 'POST',
                url: "deleteAjax",
                dataType: 'text',
                data: {
                    'id': idElementToDelete
                },
                success: function (data) {
                    $(divToRemove).remove();
                }
            });
        });

        $(document).on('click', '.edit', function() {
            var idElementToEdit = $(this).val();
            console.log(idElementToEdit);

            $('#title_edit').val(document.getElementById (idElementToEdit+'title').innerHTML);
            $('#edit').modal('show');
        });
    });

</script>

