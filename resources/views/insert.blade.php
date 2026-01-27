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
<table>
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
    let formData = new FormData(this); 
 $.ajax({
    url:'/insert',
    type:'POST',
    data:formData,
    dataType:'json',
    processData:false,
    contentType:false,
    success:function(data)
    {
        display();
    },
   error:function(e)
   {
      let es = e.responseJSON.errors;
      $('#errors_name').text(es.name[0]);
      $('#errors_email').text(es.email[0]);
   }
 });
});
function display()
{
    $.ajax({
    url:'/userdata',
    type:'get',
    success:function(data)
    {
       row = '';
       $.each(data,function(index,user){
        row += `
        <tr>
        <td>${user.name}</td>
        <td>${user.email}</td>
        <td><img src="/storage/${user.image}" width='10%'></td>
        <td><button class='edit' data-id="${user.id}">edit</button>
        <button class='delete' data-id="${user.id}">delete</button></td>
        </tr>
        `;
       });
       $('#mytable').html(row);
    }
    });
}

</script>