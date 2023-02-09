<?php 
    // Recipe retrieval from SQL database with PHP mysqli 
    class Recipes {
        // Constructor
        public function __construct(){     
            $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
        }
        // Output exercises
        public function show() {
            /* pagination from https://technosmarter.com/php/next-and-previous-buttons-with-mysql-database */
            include 'connect.php';

            if(isset($_GET['page']))
            {
                $page = $_GET['page'];
            }
            else
            {
                $page = 1;
            }

            $num_per_page = 1;
            $start_from = ($page-1)*$num_per_page;
            
            $query = "SELECT * FROM recipe limit $start_from,$num_per_page";
            $result = mysqli_query($con,$query);

            $pr_query = "SELECT * FROM recipe";
            $pr_result = mysqli_query($con,$pr_query);
            $total_record = mysqli_num_rows($pr_result );
                        
            $total_page = ceil($total_record/$num_per_page);

            if($page>1) {
                echo "<div><a href='index.php?page=".($page-1)."' class='btn btn-danger'>Previous</a></div>";
            }
            for($i=1;$i<$total_page;$i++) {
                echo "<div><a href='index.php?page=".$i."' class='btn btn-primary'></a></div>";
            }

            if($i>$page) {
                echo "<div><a href='index.php?page=".($page+1)."' class='btn btn-danger'>Next</a></div>";
            }
    
            while($row=mysqli_fetch_assoc($result)) {
                $name = $row['name'];
                $name = strtoupper($name);
                $ogyield = $row['yield'];
                $ingredients = $row['ingredients'];
                $directions = $row['directions'];

                ?>
                <div> <?php echo $name ?> </div>
                <div><strong>Yield:</strong><input class="yield-input" type="number" value="<?php echo $ogyield ?>"></input></div> 
                <div><strong>Ingredients</strong><?php echo $this->_showIngredientsList($ingredients, $ogyield) ?> </div>
                <div><strong>Directions</strong><?php echo $this->_showDirectionsList($directions) ?> </div>
                
            <?php   
            }
            ?>
        <?php 
        }

        // print ingredients as checkbox list items at double dash
        // allow ingredient amount to be adjusted when yield is changed
        private function _showIngredientsList($ingredients, $yield) {
            // $pieces = explode("--", $ingredients); // split string into strings
            $pieces = preg_split('#--\s#', $ingredients, -1, PREG_SPLIT_NO_EMPTY);            
            $lines = null;
            
            foreach ($pieces as &$ingredient) {
                if (!empty($ingredient)) {
                    $amount = strtok($ingredient, " ");
                    // remove excess space at end of 'salt' and 'pepper'
                    $nonyieldingredient = strtok("");
                    //convert string to int unless value is 'a', 'some', 'salt ', or 'pepper '
                    if ($amount == 'a') {
                        $amountvalue = 1;
                    } else if ($amount == 'some' || str_contains($amount, 'salt') || str_contains($amount, 'pepper')) {
                        // keep values the same (e.g. 'some MSG')
                        $amountvalue = $amount;
                    } else {
                        $amountvalue = (float) $amount;
                    }

                    $lines.= "<li class='ingredients-list-item'><input type='checkbox'></input>".$amountvalue.' '.$nonyieldingredient."</li>";
                    //echo " $ingredient <br>";
                }
            }

            return $lines;
        }
        // print directions as numbered list items at double dash
        private function _showDirectionsList($directions) {
            $pieces = explode("--", $directions);
            $lines = null;
            $index = 1;
            foreach ($pieces as &$directions) {
                if (!empty($directions)) {
                    $lines.= "<li class='directions-list-item'>".$index.'.'.$directions."</li>";
                    $index++;
                }
            }
            return $lines;
        }
    }        
?>