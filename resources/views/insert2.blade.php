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
    <input type="text" id="name" name="name"/>
    <input type="text" id="email" name="email"/>
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


</script>