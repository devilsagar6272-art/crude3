<html>
<head>
<title>
    www.sagar.com
</title>   
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<form id="myform" enctype="multipart/form-data">
    <input type="text" id="name" name="name" value="{{ old('name') }}"/>
    <span id="errors_name" style="color:red" disable></span>
    <input type="text" id="email" name="email"/>
    <span id="errors_email" style="color:red"></span>
    <input type="file" id="image" name="image"/>
    <input type="submit" id="submit" name="submit"/>
</form>
<form id="myeditform" enctype="multipart/form-data">
    <input type="hidden" id="user_id" name="user_id"/>
    <input type="text" id="edit_name" name="edit_name" value="{{ old('name') }}"/>
    <span id="errors_name" style="color:red" disable></span>
    <input type="text" id="edit_email" name="edit_email" value=""/>
    <span id="errors_email" style="color:red"></span>
    <input type="file" id="edit_image" name="edit_image" value=""/>
    <input type="submit" id="submit" name="submit"/>
</form>
<table border="1">
<thead>
<tr>
    <th>name</th>
    <th>email</th>
    <th>image</th>
    <th>Action</th>
</tr>
</thead>
<tbody id="mytable">
</tbody>
</table>
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
         <td><a data-id='${user.id}' class="delete">delete</td>
         <td><a data-id='${user.id}' class="edit">edit</td>
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