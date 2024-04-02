<?php

            $ex = 0;
            $gd = 0;
            $neu = 0;
            $poor = 0;

            $p1 = $p2 = $p3 = $p4 = "";
            $a = $ex;
            $b = $gd;
            $c = $neu;
            $d = $poor;

            $num_rate = [$a, $b, $c, $d];
            $numberCounts = array_count_values($num_rate);
            $similarNumbers = array_filter($numberCounts, function($count){
                return $count > 1;
            });

            if(!empty($similarNumbers)){
                if($a == $c && $a == $b && $c == $d){
                $p1 = "30px";
                $p2 = "30px";
                $p3 = "30px";
                $p4 = "30px";
                }
                if($a == $b){
                $p1 = "30px";
                $p2 = "30px";
                }
                if($a == $c){
                $p1 = "30px";
                $p3 = "30px";
                }
                if($a == $d){
                $p1 = "30px";
                $p4 = "30px";
                }

                if($b == $c){
                $p2 = "30px";
                $p3 = "30px";
                }
                if($b == $d){
                $p2 = "30px";
                $p4 = "30px";
                }
                if($c == $d){
                $p3 = "30px";
                $p4 = "30px";
                }

                if($a == $b && $b == $c){
                $p1 = "30px";
                $p2 = "30px";
                $p3 = "30px";
                }


                if($a == $b && $a > $c && $a > $d){
                $p1 = "30px";
                $p2 = "30px";
                if($c > $d){
                    $p3 = "25px";
                    $p4 = "15px";
                }
                else{
                    $p3 = "15px";
                    $p4 = "25px";
                }
                }
                if($a == $c && $a > $b && $a > $d){
                $p1 = "30px";
                $p3 = "30px";
                if($b > $d){
                    $p2 = "25px";
                    $p4 = "15px";
                }
                else{
                    $p2 = "15px";
                    $p4 = "25px";
                }
                }
                if($a == $d && $a > $b && $a > $c){
                $p1 = "30px";
                $p4 = "30px";
                if($c > $b){
                    $p3 = "25px";
                    $p2 = "15px";
                }
                else{
                    $p3 = "15px";
                    $p2 = "25px";
                }
                }
            //---------------------------------------------------
                if($b == $c && $b > $a && $b > $d){
                $p2 = "30px";
                $p3 = "30px";
                }
                if($b == $d && $b > $a && $b > $c){
                $p2 = "30px";
                $p4 = "30px";
                }
            //---------------------------------------------------
                if($c == $b && $c > $a && $c > $d){
                $p3 = "30px";
                $p2 = "30px";
                }
                if($c == $d && $c > $a && $c > $b){
                $p3 = "30px";
                $p4 = "30px";
                }
                
            }

            if($a > $b && $a > $c && $a > $d){
                $p1 = "35px";
                if($b > $c && $b > $d){
                $p2 = "30px";
                if($c > $d){
                    $p3 = "25px";
                    $p4 = "15px";
                }
                else{
                    $p3 = "15px";
                    $p4 = "25px";
                }
                }
                else{
                $p2 = "15px";
                if($c > $d){
                    $p3 = "25px";
                    $p4 = "15px";
                }
                else{
                    $p3 = "15px";
                    $p4 = "25px";
                }
                }
            }
            else if($b > $a && $b > $c && $b > $d){
                $p2 = "35px";
                if($a > $c && $a > $d){
                $p1 = "30px";
                if($c > $d){
                    $p3 = "25px";
                    $p4 = "15px";
                }
                else{
                    $p3 = "15px";
                    $p4 = "25px";
                }
                }
                else{
                $p1 = "15px";
                if($c > $d){
                    $p3 = "25px";
                    $p4 = "15px";
                }
                else{
                    $p3 = "15px";
                    $p4 = "25px";
                }
                }
            }
            else if($c > $a && $c > $b && $c > $d){
                $p3 = "35px";
                if($a > $b && $a > $d){
                $p1 = "30px";
                if($b > $d){
                    $p2 = "25px";
                    $p4 = "15px";
                }
                else{
                    $p2 = "15px";
                    $p4 = "25px";
                }
                }
                else{
                $p1 = "15px";
                if($b > $d){
                    $p2 = "25px";
                    $p4 = "15px";
                }
                else{
                    $p2 = "15px";
                    $p4 = "25px";
                }
                }
            }
            else if($d> $a && $d > $b && $d > $c){
                $p4 = "35px";
                if($a > $b && $a > $c){
                $p1 = "30px";
                if($b > $c){
                    $p2 = "25px";
                    $p3 = "15px";
                }
                else{
                    $p2 = "15px";
                    $p3 = "25px";
                }
                }
                else{
                $p1 = "15px";
                if($b > $c){
                    $p2 = "25px";
                    $p3 = "15px";
                }
                else{
                    $p2 = "15px";
                    $p3 = "25px";
                }
                }

            }

            if($a == 0){
                $p1 = "0px";
            }
            if($b == 0){
                $p2 = "0px";
            }
            if($c == 0){
                $p3 = "0px";
            }
            if($d == 0){
                $p4 = "0px";
            }
        ?>