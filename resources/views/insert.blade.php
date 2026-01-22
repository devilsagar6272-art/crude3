<html>
<head>
    <title>www.sagar.com</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <label>insert Form<label>
    <form id="myform">
    <input type="text" id="name" name="name"/><br>
    <input type="text" id="email" name="email"/><br>
    <input type="submit"/><br>
</form>
<form id="myeditform">
    <label>edit form<label>
    <input type="hidden" id="user_id" name="user_id"/><br>
    <input type="text" id="edit_name" name="edit_name"/><br>
    <input type="text" id="edit_email" name="edit_email"/><br>
    <input type="submit"/><br>
</form>
<table border="1">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
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
    display();
    $.ajaxSetup({
            headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
});
$('#myform').on('submit', function(e){
    e.preventDefault();
        name = $('#name').val();
        email = $('#email').val();
        data = {name:name,email:email};
        $.ajax({
         url:'/insert',
         type:'POST',
         data:data,
        success:function(data){
            display();          
         },
         error:function(e)
         {
           console.log(e);
         }
        });
    }
);
function display()
{
$.ajax({
         url:'/userdata',
         type:'GET',
         success:function(data)
         {
            row =''; 
            edit ='/edit/:id';
            $.each(data,function(index,user){
            url = edit.replace(':id',user.id); 
            row +=`<tr id="row_${user.id}">
            <td>${user.name}</td>
            <td>${user.email}</td>
            <td><a class="edit" data-id="${user.id}">edit</td>
            <td><a class="delete" data-id="${user.id}">delete</td>
            </tr>`;
            $('#mytable').html(row);
         });
         }
        });
        }
$(document).on('click','.delete',function(){
   $.ajax({
    url:'/delete/' +id,
    type:'get',
    success:function()
    {
        $('#row_' +id).remove();
    }
   });
});
$(document).on('click','.edit',function()
{
    id = $(this).data('id');
    $.ajax({
     url:'/edit/' + id,
     type:'get',
     success:function(user)
     {
        $('#user_id').val(user.id);
        $('#edit_name').val(user.name);
        $('#edit_email').val(user.email);
     }
    });
});
$('#myeditform').on('submit',function(e){
    e.preventDefault();
 name = $('#edit_name').val();
 email = $('#edit_email').val();
 id = $('#user_id').val();
 data = {name:name,email:email};
 url = '/update/' +id;  
 $.ajax({
  url:url,
  type:'POST',
  data :data,
  success:function(data)
  {
     display();
  }
 });   
});
</script>


