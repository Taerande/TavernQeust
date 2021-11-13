<html>
<head>
  <meta charset="utf-8">
  <title>Callback</title>
  <script>
    window.opener.postMessage({ token: "{{ $token }}", data: "{{ $data }}" }, "http://localhost:8080");
    window.close();
  </script>
</head>
<body>
  <h1>{{$data}}</h1>
  <h1>{{$token}}</h1>
</body>
</html>