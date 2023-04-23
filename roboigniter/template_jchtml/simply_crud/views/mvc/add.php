<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <title>Titulo de Pagina</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/sho.css">
    
  </head>
  <body >
    <div class="container">
      <div class="vh-100 row justify-content-center align-items-center">  
      <div class="col-12 p-5 bg-white border border-info rounded shadow">
      <div class="p-1">
        <button class="btn btn-primary"> <a href="<?= base_url() ?>index.php/%Controller%/show" class="text-white">Show</a> </button>
      </div>
        <!-- form with inpust-->  
        <form action="<?= base_url() ?>index.php/%Controller%/add" method="post"  >
            %Inputs%
            <div class="col-12 align-items-end">
              <button type="submit" class="btn btn-success col-2">Save</button>
            </div>
        </form>
        <!-- end the form -->
        </div>
      </div>
    </div>  
  </body>
</html>