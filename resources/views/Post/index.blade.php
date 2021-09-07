@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

 
                <div class="card">
              
                    <div class="card-header"> View Post </div>
                    @if (Session::has('success'))
                        <p class="alert alert-info text-center">{{ Session::get('success') }}</p>
                    @endif
                   
                    <div class="mt-2 ml-3 mr-3  ">
                  <button  class="btn btn-danger btn-xs delete-all float-right" data-url="">Delete All <i class="fa fa-trash" aria-hidden="true"></i></button>

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> Add
                            Post <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                  <th><input type="checkbox" id="check_all"></th>
                                    <th>title</th>
                                    <th>Publisher Name</th>
                                    <th>body</th>
                                    <th>action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($posts as $item)

                                    <tr id="tr_{{$item->id}}">
                                        <td scope="row"><input type="checkbox" class="checkbox" data-id="{{ $item->id }}"></td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->body }}</td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-success" data-toggle="modal"
                                                data-target="#staticBackdrop{{ $item->id }}">
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                            </tbody>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>



            {{-- add Post Form --}}


            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Post Form</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('posts.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Title:</label>
                                    <input type="text" class="form-control" name="title" id="recipient-name">
                                    @error('title')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Description:</label>
                                    <textarea class="form-control" cols="4" rows="6" name="body" id="message-text"></textarea>
                                    @error('body')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary">Save Post</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            {{-- edit post Form --}}

            <!-- Modal -->
            @foreach ($posts as $post)

                <div class="modal fade" id="staticBackdrop{{ $post->id }}" data-backdrop="static"
                    data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Edit Post Form</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">


                                <form action="{{ route('posts.update', $post->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Title:</label>
                                        <input type="text" class="form-control" name="title" value="{{ $post->title }}"
                                            id="recipient-name">
                                        @error('title')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Description:</label>
                                        <textarea class="form-control" cols="4" rows="6" name="body"
                                            id="message-text">{{ $post->body }}</textarea>
                                        @error('body')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary">Update Post</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>










    @push('script')
        <script type="text/javascript">
            $(document).ready(function() {
                $('#check_all').on('click', function(e) {
                    if ($(this).is(':checked', true)) {
                        $(".checkbox").prop('checked', true);
                    } else {
                        $(".checkbox").prop('checked', false);
                    }
                });
                $('.checkbox').on('click', function() {
                    if ($('.checkbox:checked').length == $('.checkbox').length) {
                        $('#check_all').prop('checked', true);
                    } else {
                        $('#check_all').prop('checked', false);
                    }
                });
                $('.delete-all').on('click', function(e) {
                    var idsArr = [];
                    $(".checkbox:checked").each(function() {
                        idsArr.push($(this).attr('data-id'));
                    });
                    if (idsArr.length <= 0) {
                        alert("Please select atleast one record to delete.");
                    } else {
                        if (confirm("Are you sure, you want to delete the selected Post?")) {
                            var strIds = idsArr.join(",");
                            $.ajax({
                                url: "{{ route('post.multiple-delete') }}",
                                type: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: 'ids=' + strIds,
                                success: function(data) {
                                    if (data['status'] == true) {
                                        $(".checkbox:checked").each(function() {
                                            $(this).parents("tr").remove();
                                        });
                                        alert(data['message']);
                                    } else {
                                        alert('Whoops Something went wrong!!');
                                    }
                                },
                                error: function(data) {
                                    alert(data.responseText);
                                }
                            });
                        }
                    }
                });
                $('[data-toggle=confirmation]').confirmation({
                    rootSelector: '[data-toggle=confirmation]',
                    onConfirm: function(event, element) {
                        element.closest('form').submit();
                    }
                });
            });
        </script>
    @endpush

@endsection
