<!DOCTYPE html>
<html>
<head>
    <title>www.sagar.com</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3 class="mb-3">User Form</h3>
    <form id="myform" enctype="multipart/form-data" class="card p-3 mb-4">
        <input type="text" class="form-control mb-2" name="name" placeholder="Enter Name">
        <span class="text-danger" id="errors_name"></span>

        <input type="email" class="form-control mb-2" name="email" placeholder="Enter Email">
        <span class="text-danger" id="errors_email"></span>

        <input type="file" class="form-control mb-2" name="image">

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <table class="table table-bordered">
        <thead class="table-dark">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody id="mytable"></tbody>
    </table>
</div>
<div class="modal fade" id="editModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="myeditform" enctype="multipart/form-data">
      <div class="modal-body">

        <input type="hidden" name="user_id" id="user_id">

        <input type="text" class="form-control mb-2" name="edit_name" id="edit_name">

        <input type="email" class="form-control mb-2" name="edit_email" id="edit_email">

        <input type="file" class="form-control mb-2" name="edit_image">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Update</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
<script>
   $(document).ready(function(){
    $.ajaxSetup({
      headers:{
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
      }
    });
    display();
   });
   $('#myform').on('submit',function(e){
    e.preventDefault();
    formData = new FormData(this);
    $.ajax({
        url:'/insert',
        type:'POST',
        data:formData,
        contentType:false,
        processData:false,
        success:function(data)
        {
         display();
        },
        error:function(e)
        {
            console.log(e);
        }
    });
   });
   function display()
   {
    $.ajax({
      url:"/userdata",
      type:"get",
      success:function(data)
      {
        row ='';
        $.each(data,function(index,user){
         row +=`
        <tr>
         <td>${user.name}</td>
         <td>${user.email}</td>
         <td><img  src='storage/${user.image}' width="10%"></td>
                    <td>
                        <button class="btn btn-sm btn-warning edit" data-id="${user.id}">Edit</button>
                        <button class="btn btn-sm btn-danger delete" data-id="${user.id}">Delete</button>
                    </td>
        </tr>`;
        });
        $('#mytable').html(row);
      }
    });
   }
   $(document).on('click','.delete',function(){
    id = $(this).data('id');
    $.ajax({
     url:'/delete/' + id,
     type:'get',
     success:function(data)
     {
        display();
     }
    });
   });
    $(document).on('click','.edit',function(){
    id = $(this).data('id');
    $.ajax({
     url:'/edit/' + id,
     type:'get',
     success:function(data)
     {
      $("#user_id").val(id);
      $("#edit_name").val(data.name);
      $("#edit_email").val(data.email);
      $("#edit_image").val(data.image);
      $("#editModal").modal("show");
    }
    });
   });
   $("#myeditform").on('submit',function(e){
    e.preventDefault();
    let id = $("#user_id").val();
    let formData = new FormData(this);
    $.ajax({
        url:'/update/' + id,
        type:'POST',
        data:formData,
        contentType:false,
        processData:false,
        success:function(data)
        {
            if(data.success == '1')
            {
                alert("duplicate data");
            }
              display();
        },
        error:function()
        {

        }
    });
   });
</script>