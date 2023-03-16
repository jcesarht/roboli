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
            <button class="btn btn-primary"> <a href="add.php" class="text-white">Add</a> </button>
          </div>
          
          <table class="table table-hover">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
                <th scope="col">Address</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>Av. Saint Peter</td>
                <td>
                  <div class="col-*">
                    <button class="btn btn-warning cols-6">Edit</button>
                    <button class="btn btn-danger cols-6">Remove</button>
                  </div>
                </td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
                <td>Av. Saint Jhon</td>
                <td>
                  <div class="col-*">
                    <button class="btn btn-warning cols-6">Edit</button>
                    <button class="btn btn-danger cols-6">Remove</button>
                  </div>
                </td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
                <td>Av. Saint Mathew</td>
                <td>
                  <div class="col-*">
                    <button class="btn btn-warning cols-6">Edit</button>
                    <button class="btn btn-danger cols-6" data-toggle="modal" data-target="#bd-example-modal-sm">Remove</button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="p-1">
            <button class="btn btn-primary"> <a href="add.php" class="text-white">Add</a> </button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="remove">
      <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            ...
          </div>
        </div>
      </div>
    </div>
      
  </body>
</html>