<html>
<head>
    <title>www.sagar.com</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
/* ===== Global ===== */
* {
    box-sizing: border-box;
}

body {
    font-family: "Segoe UI", Tahoma, Arial, sans-serif;
    background-color: #f0f2f5;
    margin: 0;
    padding: 30px;
    color: #333;
}

/* ===== Headings / Labels ===== */
label {
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 10px;
    display: block;
}

/* ===== Forms ===== */
form {
    background: #ffffff;
    width: 340px;
    padding: 20px;
    margin-bottom: 25px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

form + form {
    margin-top: 10px;
}

input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 14px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
}

input[type="text"]:focus {
    border-color: #0d6efd;
    outline: none;
    box-shadow: 0 0 0 2px rgba(13,110,253,0.15);
}

input[type="submit"] {
    background: #0d6efd;
    color: #fff;
    border: none;
    padding: 10px;
    width: 100%;
    font-size: 15px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
}

input[type="submit"]:hover {
    background: #262e3b;
}

/* ===== Table ===== */
table {
    width: 70%;
    background: #ffffff;
    border-collapse: collapse;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

table thead {
    background: #0d6efd;
}

table th {
    color: #ffffff;
    text-align: left;
    padding: 12px;
    font-size: 14px;
}

table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

table tr:last-child td {
    border-bottom: none;
}

table tr:hover {
    background: #f8f9fa;
}

/* ===== Buttons ===== */
button {
    padding: 6px 12px;
    border: none;
    border-radius: 5px;
    font-size: 13px;
    cursor: pointer;
    font-weight: 600;
}

button.edit {
    background: #198754;
    color: #fff;
}

button.edit:hover {
    background: #157347;
}

button.delete {
    background: #dc3545;
    color: #fff;
}

button.delete:hover {
    background: #bb2d3b;
}
</style>
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
    <select>
        <option>sagar</option>
        <option>het</option>
    </select>
     <input type="radio" name="sagar">
        <input type="radio" name="sagar">
         <input type="radio" name="sagar">
        <input type="checkbox">
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
$.ajaxSetup({
  headers:{
   'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
  }
});
 display();
});
$('#myform').on('click',function(e){
    e.preventDefault();
    name = $('#name').val();
    email = $('#email').val();
    data = {name:name,email:email};
    $.ajax({
        url:'/insert',
        type:'POST',
        data:data,
        success:function(data)
        {
          console.log(data);
        },
        error:function(e)
        {
        console.log(e);
        }
    });
   display();
});
function display()
{
    $.ajax({
     url:'/userdata',
     tyep:'GET',
     success:function(data){
        row = '';
        $.each(data,function(index,user){
        row +=`<tr>
        <td>${user.name}</td>
        <td>${user.email}</td>
        <td><button class='delete' data-id='${user.id}'>delete</button> 
        <button class='edit' data-id='${user.id}'>edit</button></td>   
         </tr>`;
        });
        $('#mytable').html(row);
     }
        });
}
$(document).on('click','.delete',function(){
    id = $(this).data('id');
    $.ajax({
        url:'/delete/' +id ,
        type:'get',
        success:function()
        {
         display();
        }
    });
});
$(document).on('click','.edit',function(){
    id = $(this).data('id');
    $.ajax({
     url:'/edit/' + id,
     type: 'get',
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
      data = {name:name,email:email,id:id};
      $.ajax({
        url:"/update/" + id,
        type:'POST',
        data:data,
        success:function()
        {
            display();
        } 
      });
});
</script>


