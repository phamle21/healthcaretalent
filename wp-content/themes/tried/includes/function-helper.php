<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function validate_string_to_email($str) {
    $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';

    if (preg_match($pattern, $str) === 1) {
        return true;
    }
    return false;
}

function convert_slug($str, $delimiter = '-') {
    $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
    return $slug;
}

function convertStrLatin($str = ''){
    $unicode = array(
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd'=>'đ',
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i'=>'í|ì|ỉ|ĩ|ị',
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D'=>'Đ',
        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );
    
    foreach($unicode as $nonUnicode=>$uni){
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    return $str;
}

if( !function_exists( 'data_provinces' ) ) {
    include_once get_template_directory() . '/assets/data/provinces.php';
}
if( !function_exists( 'data_districts' ) ) {
    include_once get_template_directory() . '/assets/data/districts.php';
}
function get_position_data( $type = 'provinces' ) {
    $result = array();
    if ( $type == 'districts' ) {
        if ( !empty( data_districts() ) ) {
            $result = json_decode( data_districts(), true );
        }
    } else {
        if ( !empty( data_provinces() ) ) {
            $result = json_decode( data_provinces(), true );
        }
    }
    return $result;
}

function get_province_by_id( $province_id = null ) {
    $result = array();
    if ( $province_id ) {
        if ( !empty( data_districts() ) ) {
            $provinces = json_decode( data_provinces(), true );
            $result = $provinces[$province_id];
        }
    }
    return $result;
}

function get_districts_by_province( $province ) {
    $data_districts = get_position_data( 'districts' );
    $districts = array();
    foreach ( $data_districts as $rkey => $district ) {
        if ( $district['province_service_key'] == $province ){
            $districts[] = $district;
        }
    }
    return $districts;
}

function get_district_by_id( $district_id = null ) {
    $result = array();
    if ( $district_id ) {
        if ( !empty( data_districts() ) ) {
            $districts = json_decode( data_districts(), true );
            $result = $districts[$district_id];
        }
    }
    return $result;
}

function convert_number_to_words($number) {
    if (strpos($number, '.')) {//có phần lẻ thập phân
        list($integer, $fraction) = explode(".", (string)$number);
    } else { //không có phần lẻ
        $integer = $number;
        $fraction = NULL;
    }

    $output = "";

    if ($integer[0] == "-") {
        $output = "âm ";
        $integer = ltrim($integer, "-");
    } else if ($integer[0] == "+") {
        $output = "dương ";
        $integer = ltrim($integer, "+");
    }

    if ($integer[0] == 0 || $integer[0] == "0") {
        $output .= "không";
    } else {
        $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
        $group = rtrim(chunk_split($integer, 3, " "), " ");
        $groups = explode(" ", $group);

        $groups2 = array();
        foreach ($groups as $g) {
            $groups2[] = convertThreeDigit($g[0], $g[1], $g[2]);
        }

        for ($z = 0; $z < count($groups2); $z++) {
            if ($groups2[$z] != "") {
                $output .= $groups2[$z] . convertGroup(11 - $z) . (
                    $z < 11
                    && !array_search('', array_slice($groups2, $z + 1, -1))
                    && $groups2[11] != ''
                    && $groups[11][0] == '0'
                        ? " "
                        : ", "
                    );
            }
        }

        $output = rtrim($output, ", ");
    }

    if ($fraction > 0) {
        $output .= " phẩy";
        for ($i = 0; $i < strlen($fraction); $i++) {
            $output .= " " . convertDigit($fraction[$i]);
        }
    }

    return $output;
}

function convertGroup($index) {
    switch ($index) {
        case 11:
            return " decillion";
        case 10:
            return " nonillion";
        case 9:
            return " octillion";
        case 8:
            return " septillion";
        case 7:
            return " sextillion";
        case 6:
            return " quintrillion";
        case 5:
            return " nghìn triệu triệu";
        case 4:
            return " nghìn tỷ";
        case 3:
            return " tỷ";
        case 2:
            return " triệu";
        case 1:
            return " nghìn";
        case 0:
            return "";
    }
}
function convertThreeDigit($digit1, $digit2, $digit3) {
    $buffer = "";

    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0") {
        return "";
    }

    if ($digit1 != "0") {
        $buffer .= convertDigit($digit1) . " trăm";
        if ($digit2 != "0" || $digit3 != "0") {
            $buffer .= " ";
        }
    }

    if ($digit2 != "0") {
        $buffer .= convertTwoDigit($digit2, $digit3);
    } else if ($digit3 != "0") {
        $buffer .= convertDigit($digit3);
    }

    return $buffer;
}
function convertTwoDigit($digit1, $digit2) {
    if ($digit2 == "0") {
        switch ($digit1) {
            case "1":
                return "mười";
            case "2":
                return "hai mươi";
            case "3":
                return "ba mươi";
            case "4":
                return "bốn mươi";
            case "5":
                return "năm mươi";
            case "6":
                return "sáu mươi";
            case "7":
                return "bảy mươi";
            case "8":
                return "tám mươi";
            case "9":
                return "chín mươi";
        }
    } else if ($digit1 == "1") {
        switch ($digit2) {
            case "1":
                return "mười một";
            case "2":
                return "mười hai";
            case "3":
                return "mười ba";
            case "4":
                return "mười bốn";
            case "5":
                return "mười lăm";
            case "6":
                return "mười sáu";
            case "7":
                return "mười bảy";
            case "8":
                return "mười tám";
            case "9":
                return "mười chín";
        }
    } else {
        $temp = convertDigit($digit2);
        if ($temp == 'năm') $temp = 'lăm';
        if ($temp == 'một') $temp = 'mốt';
        switch ($digit1) {
            case "2":
                return "hai mươi $temp";
            case "3":
                return "ba mươi $temp";
            case "4":
                return "bốn mươi $temp";
            case "5":
                return "năm mươi $temp";
            case "6":
                return "sáu mươi $temp";
            case "7":
                return "bảy mươi $temp";
            case "8":
                return "tám mươi $temp";
            case "9":
                return "chín mươi $temp";
        }
    }
}
function convertDigit($digit) {
    switch ($digit) {
        case "0":
            return "không";
        case "1":
            return "một";
        case "2":
            return "hai";
        case "3":
            return "ba";
        case "4":
            return "bốn";
        case "5":
            return "năm";
        case "6":
            return "sáu";
        case "7":
            return "bảy";
        case "8":
            return "tám";
        case "9":
            return "chín";
    }
}


function numInWords($num)
{
    $nwords = array(
        0                   => 'không',
        1                   => 'một',
        2                   => 'hai',
        3                   => 'ba',
        4                   => 'bốn',
        5                   => 'năm',
        6                   => 'sáu',
        7                   => 'bảy',
        8                   => 'tám',
        9                   => 'chín',
        10                  => 'mười',
        11                  => 'mười một',
        12                  => 'mười hai',
        13                  => 'mười ba',
        14                  => 'mười bốn',
        15                  => 'mười lăm',
        16                  => 'mười sáu',
        17                  => 'mười bảy',
        18                  => 'mười tám',
        19                  => 'mười chín',
        20                  => 'hai mươi',
        30                  => 'ba mươi',
        40                  => 'bốn mươi',
        50                  => 'năm mươi',
        60                  => 'sáu mươi',
        70                  => 'bảy mươi',
        80                  => 'tám mươi',
        90                  => 'chín mươi',
        100                 => 'trăm',
        1000                => 'nghìn',
        1000000             => 'triệu',
        1000000000          => 'tỷ',
        1000000000000       => 'nghìn tỷ',
        1000000000000000    => 'ngàn triệu triệu',
        1000000000000000000 => 'tỷ tỷ',
    );
    $separate = ' ';
    $negative = ' âm ';
    $rltTen   = ' linh ';
    $decimal  = ' phẩy ';
    if (!is_numeric($num)) {
        $w = '#';
    } else if ($num < 0) {
        $w = $negative . numInWords(abs($num));
    } else {
        if (fmod($num, 1) != 0) {
            $numInstr    = strval($num);
            $numInstrArr = explode(".", $numInstr);
            $w           = numInWords(intval($numInstrArr[0])) . $decimal . numInWords(intval($numInstrArr[1]));
        } else {
            $w = '';
            if ($num < 21) // 0 to 20
            {
                $w .= $nwords[$num];
            } else if ($num < 100) {
                // 21 to 99
                $w .= $nwords[10 * floor($num / 10)];
                $r = fmod($num, 10);
                if ($r > 0) {
                    $w .= $separate . $nwords[$r];
                }

            } else if ($num < 1000) {
                // 100 to 999
                $w .= $nwords[floor($num / 100)] . $separate . $nwords[100];
                $r = fmod($num, 100);
                if ($r > 0) {
                    if ($r < 10) {
                        $w .= $rltTen . $separate . numInWords($r);
                    } else {
                        $w .= $separate . numInWords($r);
                    }
                }
            } else {
                $baseUnit     = pow(1000, floor(log($num, 1000)));
                $numBaseUnits = (int) ($num / $baseUnit);
                $r            = fmod($num, $baseUnit);
                if ($r == 0) {
                    $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit];
                } else {
                    if ($r < 100) {
                        if ($r >= 10) {
                            $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . ' không trăm ' . numInWords($r);
                        }
                        else{
                        	$w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . ' không trăm linh ' . numInWords($r);
                        }
                    } else {
                        $baseUnitInstr      = strval($baseUnit);
                        $rInstr             = strval($r);
                        $lenOfBaseUnitInstr = strlen($baseUnitInstr);
                        $lenOfRInstr        = strlen($rInstr);
                        if (($lenOfBaseUnitInstr - 1) != $lenOfRInstr) {
                            $numberOfZero = $lenOfBaseUnitInstr - $lenOfRInstr - 1;
                            if ($numberOfZero == 2) {
                                $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . ' không trăm linh ' . numInWords($r);
                            } else if ($numberOfZero == 1) {
                                $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . ' không trăm ' . numInWords($r);
                            } else {
                                $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . $separate . numInWords($r);
                            }
                        } else {
                            $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . $separate . numInWords($r);
                        }
                    }
                }
            }
        }
    }
    return $w;
}

function numberInVietnameseWords($num)
{
    return str_replace("mươi năm", "mươi lăm", str_replace("mươi một", "mươi mốt", numInWords($num)));
}

function numberInVietnameseCurrency($num)
{
    $rs    = numberInVietnameseWords($num);
    $rs[0] = strtoupper($rs[0]);
    return $rs . ' đồng';
}


function stringToBool( $value ) {
	return ( is_bool( $value ) && $value ) || in_array( $value, [ 1, '1', 'true', 'yes' ], true );
}