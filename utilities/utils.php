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
    
//     function AmountInWords(float $amount, $nri, $currencyCode)
//     {
//         $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
//         // Check if there is any number after decimal
//         $amt_hundred = null;
//         $count_length = strlen($num);
//         $x = 0;
//         $string = array();
//         $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
//             3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
//             7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
//             10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
//             13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
//             16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
//             19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
//             40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
//             70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
//         $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
//         while( $x < $count_length ) {
//             $get_divider = ($x == 2) ? 10 : 100;
//             $amount = floor($num % $get_divider);
//             $num = floor($num / $get_divider);
//             $x += $get_divider == 10 ? 1 : 2;
//             if ($amount) {
//                 $add_plural = (($counter = count($string)) && $amount > 9) ? '' : null;
//                 $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
//                 $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.'
//        '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. '
//        '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
//             }
//             else $string[] = null;
//         }
//         $implode_to_Rupees = implode('', array_reverse($string));
//         $paise = ' Paise';
//         $rupees = 'Rupees ';
//         if ($nri){
//             $paise = ' Cent';
//             // $rupees = 'USD ';
//             $rupees = $currencyCode;
//         }
//         $get_paise = ($amount_after_decimal > 0) ? "and " . ($change_words[$amount_after_decimal / 10] . "
//    " . $change_words[$amount_after_decimal % 10]) . $paise : '';
//         return ($implode_to_Rupees ? $implode_to_Rupees . $rupees : '') . $get_paise;
//     }
    
function AmountInWords(float $amount, $nri, $currencyCode)
{
    $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
    $amt_hundred = null;
    $count_length = strlen($num);
    $x = 0;
    $string = array();
    $change_words = array(
        0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen',
        18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty',
        50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
    );

    $here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    $currency_fractions = array(
        'USD' => 'Cents', 'CAD' => 'Cents', 'AUD' => 'Cents', 'NZD' => 'Cents',
        'EUR' => 'Cents', 'GBP' => 'Pence', 'INR' => 'Paise', 'JPY' => 'Sen',
        'CNY' => 'Fen', 'SAR' => 'Halala', 'RUB' => 'Kopecks', 'AED' => 'Fils',
        'AFN' => 'Pul', 'ALL' => 'Qindarka', 'AMD' => 'Luma', 'ANG' => 'Cents',
        'AOA' => 'Cêntimos', 'ARS' => 'Centavos', 'AZN' => 'Qapik', 'BAM' => 'Fening',
        'BDT' => 'Poisha', 'BGN' => 'Stotinki', 'BHD' => 'Fils', 'BIF' => 'Centimes',
        'BMD' => 'Cents', 'BND' => 'Sen', 'BOB' => 'Centavos', 'BRL' => 'Centavos',
        'BTN' => 'Chetrum', 'BWP' => 'Thebe', 'BYN' => 'Kopecks', 'BZD' => 'Cents',
        'CDF' => 'Centimes', 'CHF' => 'Rappen', 'CLP' => 'Centavos', 'COP' => 'Centavos',
        'CRC' => 'Centimos', 'CUP' => 'Centavos', 'CVE' => 'Centavos', 'DJF' => 'Centimes',
        'DOP' => 'Centavos', 'DZD' => 'Centimes', 'EGP' => 'Piastre', 'ERN' => 'Cents',
        'ETB' => 'Santim', 'FJD' => 'Cents', 'FKP' => 'Pence', 'GEL' => 'Tetri',
        'GHS' => 'Pesewas', 'GMD' => 'Bututs', 'GNF' => 'Centimes', 'GTQ' => 'Centavos',
        'GYD' => 'Cents', 'HKD' => 'Cents', 'HNL' => 'Centavos', 'HRK' => 'Lipa',
        'HTG' => 'Centimes', 'HUF' => 'Filler', 'IDR' => 'Sen', 'ILS' => 'Agora',
        'IQD' => 'Fils', 'IRR' => 'Dinars', 'ISK' => 'Eyrir', 'JMD' => 'Cents',
        'JOD' => 'Piastre', 'KES' => 'Cents', 'KGS' => 'Tyiyn', 'KHR' => 'Sen',
        'KMF' => 'Centimes', 'KPW' => 'Chon', 'KRW' => 'Jeon', 'KWD' => 'Fils',
        'KZT' => 'Tyiyn', 'LAK' => 'Att', 'LBP' => 'Piastre', 'LKR' => 'Cents',
        'LRD' => 'Cents', 'LSL' => 'Lisente', 'LYD' => 'Dirham', 'MAD' => 'Centimes',
        'MDL' => 'Bani', 'MGA' => 'Iraimbilanja', 'MKD' => 'Deni', 'MMK' => 'Pya',
        'MNT' => 'Mongo', 'MOP' => 'Avo', 'MRO' => 'Khoums', 'MUR' => 'Cents',
        'MVR' => 'Laari', 'MWK' => 'Tambala', 'MXN' => 'Centavos', 'MYR' => 'Sen',
        'MZN' => 'Centavos', 'NAD' => 'Cents', 'NGN' => 'Kobo', 'NIO' => 'Centavos',
        'NOK' => 'Ore', 'NPR' => 'Paise', 'OMR' => 'Baisa', 'PAB' => 'Centésimos',
        'PEN' => 'Centimos', 'PGK' => 'Toea', 'PHP' => 'Centavos', 'PKR' => 'Paisa',
        'PLN' => 'Grosz', 'PYG' => 'Céntimos', 'QAR' => 'Dirhams', 'RON' => 'Bani',
        'RSD' => 'Para', 'RWF' => 'Centimes', 'SBD' => 'Cents', 'SCR' => 'Cents',
        'SDG' => 'Piastre', 'SEK' => 'Ore', 'SGD' => 'Cents', 'SHP' => 'Pence',
        'SLL' => 'Cents', 'SOS' => 'Cents', 'SRD' => 'Cents', 'SSP' => 'Piaster',
        'STN' => 'Cêntimos', 'SYP' => 'Piastre', 'SZL' => 'Cents', 'THB' => 'Satang',
        'TJS' => 'Diram', 'TMT' => 'Tennesi', 'TND' => 'Millimes', 'TOP' => 'Seniti',
        'TRY' => 'Kurus', 'TTD' => 'Cents', 'TWD' => 'Cents', 'TZS' => 'Senti',
        'UAH' => 'Kopecks', 'UGX' => 'Cents', 'UYU' => 'Centésimos', 'UZS' => 'Tiyin',
        'VES' => 'Céntimos', 'VND' => 'Hao', 'VUV' => 'Centimes', 'WST' => 'Sene',
        'XAF' => 'Centimes', 'XCD' => 'Cents', 'XOF' => 'Centimes', 'XPF' => 'Centimes',
        'YER' => 'Fils', 'ZAR' => 'Cents', 'ZMW' => 'Ngwee', 'ZWL' => 'Cents'
    );

    while ($x < $count_length) {
        $get_divider = ($x == 2) ? 10 : 100;
        $amount = floor($num % $get_divider);
        $num = floor($num / $get_divider);
        $x += $get_divider == 10 ? 1 : 2;

        if ($amount) {
            $add_plural = (($counter = count($string)) && $amount > 9) ? '' : null;
            $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
            $string[] = ($amount < 21)
                ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred
                : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
        } else {
            $string[] = null;
        }
    }

    $implode_to_Rupees = implode('', array_reverse($string));

    if ($nri) {
        $rupees = $currencyCode . ' '; 
        $paise = isset($currency_fractions[$currencyCode]) ? $currency_fractions[$currencyCode] : ' '; 
    } else {
        $rupees = 'Rupees '; 
        $paise = ' Paise';
    }
    $get_paise = ($amount_after_decimal > 0) ? "and " . ($change_words[$amount_after_decimal / 10] . "
    " . $change_words[$amount_after_decimal % 10]) . $paise : '';
         return ($implode_to_Rupees ? $implode_to_Rupees . $rupees : '') . $get_paise;
}

}