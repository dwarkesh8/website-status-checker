<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="website status checker, is my site up, php website checker tool">
  <meta name="description" content="PHP web application that checks website's status whether it's UP or not. Useful to track and watch multiple website status on single page. You can add URL and also delete from the list when it's not needed anymore.">
  <meta name="author" content="Dwarkesh Purohit">

  <title>Website Status Checker</title>
  <!-- CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">

  <!-- JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
  <div class="container">

    <h1 class="mt-1">Website Status Checker</h1>

    <div class="mt-5 col-md-4 mx-auto">
      <form method="POST" action="#" onsubmit="return false;">
       <div class="d-flex">
        <input class="form-control" type="text" id="url" name="url" placeholder="Enter URL" required>
        <button class="btn btn-success" style="margin-left: 0.5rem;" type="submit" id="btnSubmit">Add</button>
      </div>
    </form>
  </div>

  <div class="mt-5">
    <table class="table table-stripped">
      <thead>
        <th>URL</th>
        <th>Status</th>
        <th>Action</th>
      </thead>
      <tbody id="dynamicTbody">
        <tr class="text-center">
          <td colspan="3">Loading...</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</html>
