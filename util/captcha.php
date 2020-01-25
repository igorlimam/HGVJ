<?php
    
      function create_captcha($num1, $num2) {
        $num1 = (int)$num1;
        $num2 = (int)$num2;
        $rand_num_1 = mt_rand($num1, $num2);
        $rand_num_2 = mt_rand($num1, $num2);
        $result = $rand_num_1 + $rand_num_2;
        return $result;
    }

?>

