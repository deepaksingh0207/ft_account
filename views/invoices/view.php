<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body id="the_body" style="background-color: white; padding: .5rem;">

  <script>
    var resp = $.ajax({ type: "GET", url: baseUrl + "invoices/geninv/<?php echo $invoice['id'] ?>", async: false }).responseText;
    document.getElementById('the_body').innerHTML = resp;
    window.print();
  </script>
</body>
</html> 
   