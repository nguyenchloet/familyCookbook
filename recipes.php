<?php
    class Recipes {
            /**
        * Constructor
        */
        public function __construct(){     
            $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
        }
         /**
        * Output exercises
        */
        public function show() {
            // connect to mysql database
            include 'connect.php';
            $content = '';
            // check if there are recipes in db
            $getRecipes = "SELECT COUNT(*) FROM recipe";

            // create new element to hold recipe output
            $output = '';

            if ($result = $pdo->query($getRecipes)) {
                if($result->fetchColumn() > 0) {
                    $getRecipe = "SELECT name, yield, ingredients, directions FROM recipe";
                    foreach ($pdo->query($getRecipe) as $row) {
                        $name = $row['name'];
                        $name = strtoupper($name);
                        $yield = $row['yield'];
                        $ingredients = $row['ingredients'];
                        $directions = $row['directions'];
                        
                        $content=
                        '<div class="column">'.
                            '<div class="column-header"><strong>'.$name.'</strong></div>'.
                            '<div class="column-header"><strong>Yield:</strong><input type="number" value="'.$yield.'"></input></div><br>'.
                            '<div class="column-header ingredients-list"><strong>Ingredients</strong>'.$this->_showIngredientsList($ingredients).'</div><br>'.
                            '<div class="column-header"><strong>Directions</strong>'.$directions.'</div>'.
                        '</div>'.
                        $content.='</div>';

                        return $content;
                    }
                }

            }
        }
        private function _showIngredientsList($ingredients) {
            // print ingredients and directions as list items at dash
            $pieces = explode("--", $ingredients);
            //print_r($pieces);
            $lines = null;
            foreach ($pieces as &$ingredient) {
                if (!empty($ingredient)) {
                    //echo " $ingredient <br>";
                    $lines.= "<li class='ingredients-list-item'><input type='checkbox'></input>".$ingredient."</li>";
                }
            }
            return 
               $lines;
        }
    }
?>