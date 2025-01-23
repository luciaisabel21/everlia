<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Animal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">
</head>
<body>
    
@include('navbar');
    <!-- Contenido (formulario de edicion del animal) -->
     <div class="container">
    <form action={{route('animal.index', $animal)}} method="post">
        @csrf
        @method('GET')
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" name="name" value={{$animal->name}} disabled>
  </div>
  <div class="form-group">
    <label for="weight">Weight</label>
    <input type="number" class="form-control" name="weight" value={{$animal->weight}} disabled>
  </div>
  <div class="form-group">
    <label for="age">Age</label>
    <input type="number" class="form-control" name="age" value={{$animal->age}} disabled>
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <input type="text" class="form-control" name="description" value={{$animal->description}} disabled>
  </div>
  
 
  <button type="submit" class="btn btn-primary">Return</button>
</form>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
            crossorigin="anonymous"></script>
</body>
</html>
