<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Todo List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /><link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&amp;display=swap'>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css'>
    <link rel="stylesheet" href="{{asset('assets\css\main.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<!-- partial:index.partial.html -->
<div class="container m-5 p-2 rounded mx-auto bg-light shadow">
    <!-- App title section -->
    <div class="row m-1 p-4">
        <div class="col">
            <div class="p-1 h1 text-primary text-center mx-auto display-inline-block">
                <i class="fa fa-check bg-primary text-white rounded p-2"></i>
                <u>Todo List</u>
            </div>
        </div>
    </div>
    <!-- Create todo section -->
    <form id="todoForm">
        @csrf
        <div class="row m-1 p-3">
            <div class="col col-11 mx-auto">
                <div class="row bg-white rounded shadow-sm p-2 add-todo-wrapper align-items-center justify-content-center">
                    <div class="col">
                        <input class="form-control form-control-lg border-0 add-todo-input bg-transparent rounded" name="task" id="newTask" type="text" placeholder="Add new .." required>
                    </div>
                    <div class="col-auto m-0 px-2 d-flex align-items-center">
                        <label class="text-secondary my-2 p-0 px-1 view-opt-label due-date-label d-none">Due date not set</label>
                        <i class="fa fa-calendar my-2 px-1 text-primary btn due-date-button" data-toggle="tooltip" data-placement="bottom" title="Set a Due date"></i>
                        <i class="fa fa-calendar-times-o my-2 px-1 text-danger btn clear-due-date-button d-none" data-toggle="tooltip" data-placement="bottom" title="Clear Due date"></i>
                    </div>
                    <div class="col-auto m-0 px-2 d-flex align-items-center">
                        <input type="time" name="task_time" id="time" data-toggle="tooltip" data-placement="bottom" title="Set Time">
                    </div>
                    <div class="col-auto px-0 mx-0 mr-2">
                        <button type="button" class="btn btn-primary" id="addNew">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="p-2 mx-4 border-black-25 border-bottom"></div>
    <!-- View options section -->
    <div class="row m-1 p-3 px-5 justify-content-end">
        <div class="col-auto d-flex align-items-center">
            <label class="text-secondary my-2 pr-2 view-opt-label">Filter</label>
            <select class="custom-select custom-select-sm btn my-2" name="filter_type" id="filterType">
                <option value="0" selected>All</option>
                <option value="1">Completed</option>
                <option value="2">Active</option>
                <option value="3">Has due date</option>
            </select>
        </div>
    </div>
    <!-- Todo list section -->
    <div class="row mx-1 px-5 pb-3 w-80">
        <div class="col mx-auto todoListSection">
            <!-- Todo Item 1 -->
            @foreach ($todolists as $item)
            <div class="row px-3 align-items-center todo-item rounded">
                <div class="col-auto m-1 p-0 d-flex align-items-center">
                    <h2 class="m-0 p-0">
                        @if ($item->status==1)
                            <i class="fa fa-check-square-o text-primary btn m-0 p-0 statusCheckbox" data-todo="{{$item->id}}" data-toggle="tooltip" data-placement="bottom" title="Mark as todo"></i>
                        @elseif($item->status==3)
                            <i class="fa fa-times bg-primary text-white btn m-0 p-0 statusCheckbox"  data-todo="{{$item->id}}" data-toggle="tooltip" data-placement="bottom" title="Todo Has Over Due"></i>
                        @else
                            <i class="fa fa-square-o text-primary btn m-0 p-0 statusCheckbox" data-todo="{{$item->id}}" data-toggle="tooltip" data-placement="bottom" title="Mark as complete"></i>
                        @endif
                    </h2>
                </div>
                <div class="col px-1 m-1 d-flex align-items-center">
                    @if ($item->status==3)
                        <input type="text" class="form-control form-control-lg border-0 edit-todo-input bg-transparent rounded px-3" id="edit-todo-input{{$item->id}}" readonly value="{{$item->task}}" title="{{$item->task}}" />
                    @else
                        <input type="text" class="form-control form-control-lg border-0 edit-todo-input rounded px-3" id="edit-todo-input{{$item->id}}" value="{{$item->task}}" title="{{$item->task}}"/>
                    @endif
                </div>
                <div class="col-auto m-1 p-0 px-3">
                    <div class="row">
                        <div class="col-auto d-flex align-items-center rounded bg-white border border-warning">
                            <i class="fa fa-hourglass-2 my-2 px-2 text-warning btn" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Due on date"></i>
                            <h6 class="text my-2 pr-2">{{\Carbon\Carbon::parse($item->due_date)->format('jS M Y')}}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-auto m-1 p-0 px-3">
                    <div class="row">
                        <div class="col-auto d-flex align-items-center rounded bg-white border border-warning">
                            <i class="fa fa-hourglass-2 my-2 px-2 text-warning btn" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Due on Time"></i>
                            <h6 class="text my-2 pr-2">{{\Carbon\Carbon::parse($item->time)->format('h:i a')}}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-auto m-1 p-0 px-3">
                    <div class="row">
                        <div class="col-auto d-flex align-items-center rounded bg-white border border-warning">
                            @php
                                $status='';
                                if ($item->status==1) {
                                    $status='Completed';
                                } elseif ($item->status==2) {
                                    $status='Active';
                                }elseif ($item->status==3) {
                                    $status='Has Due Date';
                                }
                                
                            @endphp
                            <i class="fa fa-hourglass-2 my-2 px-2 text-info btn" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Status (has due date mean task due date is passed)"></i>
                            <h6 class="text my-2 pr-2">{{$status}}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-auto m-1 p-0 todo-actions">
                    <div class="row d-flex align-items-center justify-content-end">
                        @if ($item->status!=3)
                        <h5 class="m-0 p-0 px-2">
                            <i class="fa fa-pencil text-info btn m-0 p-0 editBtn" data-toggle="tooltip" data-edittodo="{{$item->id}}" data-placement="bottom" title="Edit todo"></i>
                        </h5>
                        @endif
                        <h5 class="m-0 p-0 px-2">
                            <i class="fa fa-trash-o text-danger btn m-0 p-0 deleteBtn" data-toggle="tooltip" data-deletetodo="{{$item->id}}" data-placement="bottom" title="Delete todo"></i>
                        </h5>
                    </div>
                    <div class="row todo-created-info">
                        <div class="col-auto d-flex align-items-center pr-2">
                            <i class="fa fa-info-circle my-2 px-2 text-black-50 btn" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Created date"></i>
                            <label class="date-label my-2 text-black-50">{{$item->due_date}}</label>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- partial -->
{{-- <script src='https://code.jquery.com/jquery-3.3.1.slim.min.js'></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js'></script>
<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js'></script>
<script src='https://stackpath.bootstrapcdn.com/bootlint/1.1.0/bootlint.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script  src="{{asset('assets\js\main.js')}}"></script>
<script>
    $(document).ready(function () {
        $(document).on('click','#addNew',function (e) {
            e.preventDefault();
            // var date= $(".due-date-button").datepicker("getDate");
            var newDate=$('.due-date-button').datepicker('getFormattedDate', 'yyyy-mm-dd');
            var taskDetail=$('#newTask').val();
            var taskTime=$('#time').val();
            // console.log(newDate);
            if (taskDetail==''||newDate==''||taskTime=='') {
                if (taskDetail==''&& newDate!=''&&taskTime!='') {
                    toastr.error('Task Description is required');
                }else if(newDate==''&&taskDetail!=''&&taskTime!=''){
                    toastr.error('Task Due Date is required');
                }else if(newDate!=''&&taskDetail!=''&&taskTime==''){
                    toastr.error('Task Time is required');
                }else{
                    toastr.error('Task Description & Due Date and time is required');
                }
            } else {
                $.ajax({
                    url: "{{ route("todoList.store") }}",
                    method:'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:{date:newDate,task:taskDetail,time:taskTime},
                    success:function(response){
                        console.log(response);
                        // if (response!=null) {
                        //     toastr.success('Task Added Successfully');
                        //     $( ".due-date-button" ).datepicker('setDate','');
                        //     $('#time').val('');
                        //     $('#newTask').val('');
                        //     loadTasks(response);
                        // }else{
                        //     toastr.error('Task Not Added Successfully');
                        // }
                    }
                });
            }
        });

        $(document).on('click','.editBtn',function (e) {
            e.preventDefault();
            var toDoid=$(this).data('edittodo');
            var editTaskDetail=$('#edit-todo-input'+toDoid).val();
             console.log(editTaskDetail);
            if (editTaskDetail=='') {
                toastr.error('Task Description is required');
            } else {
                $.ajax({
                    url: "{{ route("todoList.update") }}",
                    method:'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:{id:toDoid,task:editTaskDetail},
                    success:function(response){
                        console.log(response);
                        if (response!=null) {
                            toastr.success('Task Updated Successfully');
                            loadTasks(response);
                        }else{
                            toastr.error('Task Not Updated Successfully');
                        }
                    }
                });
            }
        });


        // delete TodoList Tasks
        $(document).on('click','.deleteBtn',function (e) {
            e.preventDefault();
            var toDoid=$(this).data('deletetodo');
            $.ajax({
                url: '{{ route("todoDelete") }}',
                method:'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{id:toDoid},
                success:function(response){
                    console.log(response);
                    if (response!=null||response!='') {
                        toastr.success('Task Deleted Successfully');
                        loadTasks(response);
                    }else{
                        toastr.error('Task Not Deleted Successfully');
                    }
                }
            });
        });


        // For Change Task Status
        $(document).on('click','.statusCheckbox',function (e) {
            e.preventDefault();
            var id=$(this).data('todo');
            $.ajax({
                url: '{{ route("changeStatus") }}',
                method:'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{id:id},
                success:function(response){
                    console.log(response);
                    if (response.status!='') {
                        toastr.success('Status Changed Successfully');
                        loadTasks(response.data);
                    }else{
                        toastr.error('Status Not Changed Successfully');
                    }
                }
            });
        });

        // For Filter base on Status
        $(document).on('change','#filterType',function (e) {
            e.preventDefault();
            var filterValue=$(this).val();
            // alert(filterValue);
            $.ajax({
                url: '{{ route("todolistFilter") }}',
                method:'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{status:filterValue},
                success:function(response){
                    console.log(response);
                    if (response!=null||response!='') {
                        loadTasks(response);
                    }else{
                        toastr.error('Record Not Found');
                    }
                }
            });
        });

        setInterval(()=>{
            $.ajax({
                url:"{{route('checkHasDue')}}",
                type:'get',
                success:function(response)
                {
                    // console.log(response);
                    loadTasks(response);     
                }
            });
        },300000);
    });

function loadTasks(Lists) {
    if (Lists!=null||Lists!='') {
        $('.todoListSection').empty();
        $.each(Lists, function( index, value ) {
            var statusCheckBox='';
            var taskInput=``;
            var editBtn=``;
            if (value.status==1) {
                statusCheckBox+=`<i class="fa fa-check-square-o text-primary btn m-0 p-0 statusCheckbox" data-todo="`+value.id+`" data-toggle="tooltip" data-placement="bottom" title="Mark as todo"></i>`;
            }else if(value.status==3){
                statusCheckBox+=`<i class="fa fa-times bg-primary text-white btn m-0 p-0 statusCheckbox"  data-todo="`+value.id+`" data-toggle="tooltip" data-placement="bottom" title="Todo Has Over Due"></i>`;
            }else{
                statusCheckBox+=`<i class="fa fa-square-o text-primary btn m-0 p-0 statusCheckbox" data-todo="`+value.id+`" data-toggle="tooltip" data-placement="bottom" title="Mark as complete"></i>`;
            }

            if (value.status==3) {
                taskInput+=`<input type="text" class="form-control form-control-lg border-0 edit-todo-input bg-transparent rounded px-3" id="edit-todo-input`+value.id+`" readonly value="`+value.task+`" title="`+value.task+`" />`;                                
            } else {
                taskInput+=`<input type="text" class="form-control form-control-lg border-0 edit-todo-input rounded px-3" id="edit-todo-input`+value.id+`" value="`+value.task+`" title="`+value.task+`"/>`;
            }

            if (value.status!=3) {
                editBtn=`<h5 class="m-0 p-0 px-2"><i class="fa fa-pencil text-info btn m-0 p-0 editBtn" data-toggle="tooltip" data-edittodo="`+value.id+`" data-placement="bottom" title="Edit todo"></i></h5>`;
            }
            var status='';
            if (value.status==1) {
                status='Completed';
            }else if(value.status==2) {
                status='Active';
            }else if(value.status==3) {
                status='Has Due Date';
            }
            var row=`<div class="row px-3 align-items-center todo-item rounded">
                <div class="col-auto m-1 p-0 d-flex align-items-center">
                    <h2 class="m-0 p-0">`+statusCheckBox+`
                    </h2>
                </div>
                <div class="col px-1 m-1 d-flex align-items-center">`+taskInput+`
                </div>
                <div class="col-auto m-1 p-0 px-3">
                    <div class="row">
                        <div class="col-auto d-flex align-items-center rounded bg-white border border-warning">
                            <i class="fa fa-hourglass-2 my-2 px-2 text-warning btn" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Due on date"></i>
                            <h6 class="text my-2 pr-2">{{\Carbon\Carbon::parse(`+value.due_date+`)->format('jS M Y')}}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-auto m-1 p-0 px-3">
                    <div class="row">
                        <div class="col-auto d-flex align-items-center rounded bg-white border border-warning">
                            <i class="fa fa-hourglass-2 my-2 px-2 text-warning btn" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Due on Time"></i>
                            <h6 class="text my-2 pr-2">{{\Carbon\Carbon::parse(`+value.time+`)->format('h:i a')}}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-auto m-1 p-0 px-3">
                    <div class="row">
                        <div class="col-auto d-flex align-items-center rounded bg-white border border-warning">
                            
                            <i class="fa fa-hourglass-2 my-2 px-2 text-info btn" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Status (has due date mean task due date is passed)"></i>
                            <h6 class="text my-2 pr-2">`+status+`</h6>
                        </div>
                    </div>
                </div>
                <div class="col-auto m-1 p-0 todo-actions">
                    <div class="row d-flex align-items-center justify-content-end">
                        `+editBtn+`
                        <h5 class="m-0 p-0 px-2">
                            <i class="fa fa-trash-o text-danger btn m-0 p-0 deleteBtn" data-toggle="tooltip" data-deletetodo="`+value.id+`" data-placement="bottom" title="Delete todo"></i>
                        </h5>
                    </div>
                    <div class="row todo-created-info">
                        <div class="col-auto d-flex align-items-center pr-2">
                            <i class="fa fa-info-circle my-2 px-2 text-black-50 btn" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Created date"></i>
                            <label class="date-label my-2 text-black-50">`+value.due_date+`</label>
                        </div>
                    </div>
                </div>
            </div>`;
            $('.todoListSection').append(row);
        });
    }
}
</script>
</body>
</html>
