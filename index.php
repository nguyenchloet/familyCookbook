<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Lorang Cookbook</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header>
            <nav class="nav-menu">
                <ul class="nav-ul">
                  <li><a href="#">Claude's Recipes</a></li>
                  <li><a href="#">CIA Recipes</a></li>
                  <li><a href="#">BU Recipes</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <h1>Claude's Recipes</h1>
            <div class="recipe-output">
                <?php 
                    include 'recipes.php';
                    #output recipes if found
                    $recipes = new Recipes();
                    echo $recipes->show();
                ?>
            </div>
        </main>
        <script src="index.js"></script>
    </body>
</html>