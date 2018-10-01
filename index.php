<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Jeu du Taquin 3x3</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<?php

set_time_limit ( 600 );

$tabX = array();  //[[5, 7, 9],[6, 2, 4],[1, 3, 8]];
$tabX[0] = [8, 3, 1];
$tabX[1] = [7, 9, 4];
$tabX[2] = [6, 2, 5];
$move = array(100);
$best_move = array(100);
$tmp = 0;

function tri(array $tab)
{
    $compa = 0;
    $lTab = count($tab) - 1;

    for ($iv = 0; $iv <= $lTab; $iv++) {

        for ($jv = 0; $jv <= $lTab; $jv++) {

            //parcours comparaison
            for ($ic = 0; $ic <= $lTab; $ic++) {
                for ($jc = 0; $jc <= $lTab; $jc++) {


                    $compa++;
                    if ($tab[$iv][$jv] < $tab[$ic][$jc]) {
                        $tmp = $tab[$ic][$jc];
                        $tab[$ic][$jc] = $tab[$iv][$jv];
                        $tab[$iv][$jv] = $tmp;
                    }
                }
            }
        }
    }

    //parcours validation
    return $tab;
}

function tri_v2(array $tab) //bulles
{

    $swap = 1;
    $lTab = count($tab) - 1;

    while ($swap == 1) {
        $swap = 0;
        for ($i = 0; $i < $lTab; $i++) {
            if ($tab[$i] > $tab[$i + 1]) {
                $tmp = $tab[$i];
                $tab[$i] = $tab[$i + 1];
                $tab[$i + 1] = $tmp;
                $swap = 1;
            }
        }
    }
    return $tab;
}

function show_tab(array $tab)
{
    echo "<h2><br>Tri rapide</h2>";
    foreach ($tab as $val) {
        echo "<div class='col-md-1 p-4 m-1 border border-danger text-black' id='case'>" . $val . "</div>";
    }
}

function rand_shuffle(array $tab)
{
    $lTab = count($tab) - 1;
    $lim = 100;
    $compa = 0;

    for ($i = 0; $i < $lim; $i++) {
        $rd = rand(1, $lTab);

        $tmp = $tab[$rd];
        $tab[$rd] = $tab[$rd - 1];
        $tab[$rd - 1] = $tmp;

        $compa++;
    }

    return array($tab, $compa);
}

function where_void(array $tab)
{

    $lTab = count($tab) - 1;

    for ($i = 0; $i <= $lTab; $i++) {
        for ($j = 0; $j <= $lTab; $j++) {
            if ($tab[$i][$j] == 9) {

                $void_i = $i;
                $void_j = $j;

                return array($void_i, $void_j);
            }
        }
    }
}

function rand_shuffle_2d(array $tab2)
{
    $message = "Affichage du tableau 2D mélangé";
    $choixDeplacement = ['haut', 'bas', 'gauche', 'droite'];
    $profondeurTableau = count($tab2) - 1;
    $limNbSwap = 100;
    $choix = "";
    $tmp = '';
    $comparaison = 0;


    for ($i = 0; $i <= $limNbSwap; $i++) {

        //$numLigne = rand(0, $profondeurTableau);
        //$numColonne = rand(0, $profondeurTableau);
        $numLigne = where_void($tab2)[1];
        $numColonne = where_void($tab2)[0];

        if ($numLigne == 0) {
            if ($numColonne == 0) {
                while (true) {
                    $x = array_rand($choixDeplacement);

                    if ($x == 1 or $x == 3) {
                        $choix = $choixDeplacement[$x];
                        break;
                    }
                }
            } elseif ($numColonne == 2) {
                while (true) {
                    $x = array_rand($choixDeplacement);

                    if ($x == 1 or $x == 2) {
                        $choix = $choixDeplacement[$x];
                        break;
                    }
                }
            } else {
                while (true) {
                    $x = array_rand($choixDeplacement);
                    if ($x !== 0) {
                        $choix = $choixDeplacement[$x];
                        break;
                    }
                }
            }
        } elseif ($numLigne == 2) {
            if ($numColonne == 0) {
                while (true) {
                    $x = array_rand($choixDeplacement);
                    if ($x == 0 or $x == 3) {
                        $choix = $choixDeplacement[$x];
                        break;
                    }
                }
            } elseif ($numColonne == 2) {
                while (true) {
                    $x = array_rand($choixDeplacement);

                    if ($x == 0 or $x == 2) {
                        $choix = $choixDeplacement[$x];
                        break;
                    }
                }
            } else {
                while (true) {
                    $x = array_rand($choixDeplacement);
                    if ($x !== 1) {
                        $choix = $choixDeplacement[$x];
                        break;
                    }
                }
            }
        } else {
            if ($numColonne == 0) {
                while (true) {
                    $x = array_rand($choixDeplacement);
                    if ($x !== 2) {
                        $choix = $choixDeplacement[$x];
                        break;
                    }
                }
            } elseif ($numColonne == 2) {
                while (true) {
                    $x = array_rand($choixDeplacement);
                    if ($x !== 3) {
                        $choix = $choixDeplacement[$x];
                        break;
                    }
                }
            } else {
                while (true) {
                    $x = array_rand($choixDeplacement);
                    $choix = $choixDeplacement[$x];
                    break;
                }
            }
        }


        switch ($choix) {
            case "haut":
                $tmp = $tab2[$numLigne - 1][$numColonne];
                $tab2[$numLigne - 1][$numColonne] = $tab2[$numLigne][$numColonne];
                $tab2[$numLigne][$numColonne] = $tmp;
                break;

            case "bas":
                $tmp = $tab2[$numLigne + 1][$numColonne];
                $tab2[$numLigne + 1][$numColonne] = $tab2[$numLigne][$numColonne];
                $tab2[$numLigne][$numColonne] = $tmp;
                break;
            case "gauche":
                $tmp = $tab2[$numLigne][$numColonne - 1];
                $tab2[$numLigne][$numColonne - 1] = $tab2[$numLigne][$numColonne];
                $tab2[$numLigne][$numColonne] = $tmp;
                break;

            case "droite":
                $tmp = $tab2[$numLigne][$numColonne + 1];
                $tab2[$numLigne][$numColonne + 1] = $tab2[$numLigne][$numColonne];
                $tab2[$numLigne][$numColonne] = $tmp;
                break;

            default:
                echo "NULL";
                break;
        }
        $comparaison++;

    }

    return $tab2;
}

function tri_v4(array $tab) //rapide
{
    $lTab = count($tab) - 1;
    $pivot = 4;
    $minus_tab = array();
    $maxinus_tab = array();
    $pivot_tab = array();

    for ($i = 0; $i <= $lTab; $i++) {
        if($tab[$i]<$pivot){
            array_push($minus_tab,($tab[$i]));
        }
        elseif($tab[$i]>$pivot){
            array_push($maxinus_tab,($tab[$i]));
        }
        if($tab[$i]==$pivot){
            array_push($pivot_tab,($tab[$i]));
        }
    }
    $mini_tab = tri_v2($minus_tab);
    $maxi_tab = tri_v2($maxinus_tab);

    $final_tab = array_merge($mini_tab, $pivot_tab, $maxi_tab);


    //parcours validation
    return $final_tab;
}

function possible_move(array $tab, $void_x, $void_y)
{

    $lTab = count($tab);
    $move_list = array();

    //liste des mouvements
    $i_r = $void_x;
    $j_r = $void_y + 1;

    $i_l = $void_x;
    $j_l = $void_y - 1;

    $i_d = $void_x + 1;
    $j_d = $void_y;

    $i_u = $void_x - 1;
    $j_u = $void_y;

    //Si le futur mouvement est possible
    if (($i_r >= 0) && ($j_r >= 0) && ($i_r < $lTab) && ($j_r < $lTab)) {
        array_push($move_list, "R");
        //echo "R";
    }
    if (($i_l >= 0) && ($j_l >= 0) && ($i_l < $lTab) && ($j_l < $lTab)) {
        array_push($move_list, "L");
        //echo "L";
    }
    if (($i_u >= 0) && ($j_u >= 0) && ($i_u < $lTab) && ($j_u < $lTab)) {
        array_push($move_list, "U");
        //echo "U";
    }
    if (($i_d >= 0) && ($j_d >= 0) && ($i_d < $lTab) && ($j_d < $lTab)) {
        array_push($move_list, "D");
        //echo "D";
    }

    //echo "----------";

    return $move_list;

}

function searching(array $tab, array $good_tab)
{
    $count = 0;
    $newTab = array();
    $origin_tab = $tab;

    //cherche la position de la case vide (9)

    $void_position = where_void($tab);
    $void_x = $void_position[0];
    $void_y = $void_position[1];

    //regarde les possibilités pour la case vide

    $valid_move = possible_move($tab, $void_x, $void_y);

    //pour toutes les possibilité en fonction de la position de x on la stock dans un tableau

    for ($i = 0; $i < count($valid_move); $i++) {
        array_push($newTab, array($valid_move[$i]));
    }

    //compte le nombre de possibilité renvoyé

    $nb_etape = count($newTab);

    for ($t = 0; $t < 30; $t++) {
        for ($i = 0; $i < $nb_etape; $i++) {
            $etape = $newTab[$i];
            for ($j = 0; $j < count($etape); $j++) {
                $directions = $etape[$j];
                $void_position = where_void($tab);
                $void_x = $void_position[0];
                $void_y = $void_position[1];

                if ($directions == "U") {
                    $tmp = $tab[$void_x][$void_y];
                    $tab[$void_x][$void_y] = $tab[$void_x - 1][$void_y];
                    $tab[$void_x - 1][$void_y] = $tmp;
                }

                elseif ($directions == "D") {
                    $tmp = $tab[$void_x][$void_y];
                    $tab[$void_x][$void_y] = $tab[$void_x + 1][$void_y];
                    $tab[$void_x + 1][$void_y] = $tmp;
                }

                elseif ($directions == "R") {
                    $tmp = $tab[$void_x][$void_y];
                    $tab[$void_x][$void_y] = $tab[$void_x][$void_y + 1];
                    $tab[$void_x][$void_y + 1] = $tmp;
                }

                elseif ($directions == "L") {
                    $tmp = $tab[$void_x][$void_y];
                    $tab[$void_x][$void_y] = $tab[$void_x][$void_y - 1];
                    $tab[$void_x][$void_y - 1] = $tmp;
                }
            }

            $void_position = where_void($tab);
            $void_x = $void_position[0];
            $void_y = $void_position[1];

            //regarde les possibilités pour la case vide

            $valid_move = possible_move($tab, $void_x, $void_y);

            foreach ($valid_move as $possible) {
                //R-L-U-D
                $etape_actuel = $etape;
                //si le movement est un "retour", on le garde pas, sinon, push
                if ($etape_actuel[count($etape_actuel) - 2]) {
                    if ($possible !== $etape_actuel[count($etape_actuel) - 2]) {
                        array_push($etape_actuel, $possible);
                        array_push($newTab, $etape_actuel);
                    }
                }
                else {
                    array_push($etape_actuel, $possible);
                    array_push($newTab, $etape_actuel);
                }
            }
            $tabFlat = array_merge($tab[0], $tab[1], $tab[2]);

            if (good_ending($tabFlat, $good_tab)==1) {
                echo "It's good";
                var_dump($etape);
                echo "___________________________________";
                return $tab;
            }
            else {
                $count++;
                if ($count == 100) {
                    echo "KO";
                    $count = 0;
                }

                $tab = $origin_tab;
            }
        }
        for ($i = 0; $i < $nb_etape; $i++) {
            array_shift($newTab);
        }
        $nb_etape = count($newTab);
    }
}

function good_ending(array $tab1, array $tab2)
{

    $lTab = count($tab1);

    for ($i = 0; $i < $lTab; $i++) {
        //echo $tab1[$i] . "-" . $tab2[$i] . "///";

        if ($tab1[$i] != $tab2[$i]) {
            return 0;
        }

    }
    return 1;
}

function show_tab_2d(array $tab2)
{
    $longueurTab2 = count($tab2);
    for ($i = 0; $i < $longueurTab2; $i++) {
        $longueurLigne = count($tab2[$i]);
        for ($j = 0; $j < $longueurLigne; $j++) {
            if ($tab2[$i][$j] == 9) {
                echo "<div class='col-md-3 p-4 m-1 border dark text-white' id='case'><b>" . $tab2[$i][$j] . "</b></div>";
            } else {
                echo "<div class='col-md-3 p-4 m-1 border border-danger text-black' id='case'><b>" . $tab2[$i][$j] . "</b></div>";
            }
        }
    }
}


?>
<div class="container">
    <div class="container-fluid mt-4">
        <div class="text-center">
            <h2> Jeu du Taquin </h2>
            <hr>
            <div class="mt-3">
                <div class="row  justify-content-center">
                    <?php
                    $tab_test = [5, 7, 9, 6, 2, 4, 1, 3, 8];
                    $tab4 = tri_v4($tab_test);
                    show_tab($tab4);
                    $good_tab = [1, 2, 3, 4, 5, 6, 7, 8, 9];
                    $tab = array();  //[[5, 7, 9],[6, 2, 4],[1, 3, 8]];
                    $tab[0] = [9, 2, 3];
                    $tab[1] = [1, 4, 5];
                    $tab[2] = [7, 8, 6];
                    show_tab_2d($tab);                 //montre le tableau mélangé
                    $good_move = searching($tab, $good_tab); //cherche les solutions
                    show_tab_2d($good_move);

//                    for ($i=0; $i<=count($good_move); $i++) {
//                        echo $good_move[0];
//                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

<!-- Latest compiled and minified JavaScript -->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>