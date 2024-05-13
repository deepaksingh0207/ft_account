<?php

class Utils {
    
    function __construct() {
    
    }
 
    function getRandomNumber() {
        return time();
    }
    
    function getMailer() {
        require_once HOME . DS. 'vendor/autoload.php';
        // Create the Transport
        //$transport = (new Swift_SmtpTransport(MAIL_TRANSPORT, 587))
        $transport = (new Swift_SmtpTransport(MAIL_TRANSPORT, 587, 'tls'))
        ->setUsername(HD_MAIL_ID)
        ->setPassword(HD_MAIL_PWD);
        
        $mailer = new Swift_Mailer($transport);
        
        return $mailer;
    }
    
    
    function getOrderType($id = null, $val = null) {
        if($id) {
            return ORDER_TYPE[$id];
        }
        if($val) {
            return array_search($val, ORDER_TYPE);
        }
        return ORDER_TYPE;
        
    }
    function getUOM($id = null, $val = null) {
        if($id) {
            return UOM[$id];
        }
        if($val) {
            return array_search($val, UOM);
        }
        return UOM;
    }
    function getSystem($id = null, $val = null) {
        if($id) {
            return INSTANCE[$id];
        }
        if($val) {
            return array_search($val, INSTANCE);
        }
        return INSTANCE;
    }
    
    function AmountInWords(float $amount, $currency)
    {
        $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
        // Check if there is any number after decimal
        $amt_hundred = null;
        $count_length = strlen($num);
        $x = 0;
        $string = array();
        $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
        $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
        while( $x < $count_length ) {
            $get_divider = ($x == 2) ? 10 : 100;
            $amount = floor($num % $get_divider);
            $num = floor($num / $get_divider);
            $x += $get_divider == 10 ? 1 : 2;
            if ($amount) {
                $add_plural = (($counter = count($string)) && $amount > 9) ? '' : null;
                $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
                $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.'
       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. '
       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
            }
            else $string[] = null;
        }
        $implode_to_Rupees = implode('', array_reverse($string));

        $get_paise = ($amount_after_decimal > 0) ? "and " . ($change_words[$amount_after_decimal / 10] . "
   " . $change_words[$amount_after_decimal % 10]) . CURRENCY_FRAC[$currency]['fraction'] : '';
        return ($implode_to_Rupees ? $implode_to_Rupees . CURRENCY_FRAC[$currency]['main'] : '') . $get_paise;
    }
    
    
}