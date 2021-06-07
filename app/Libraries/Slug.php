<?php

namespace App\Libraries;

class Slug
{

    public function str_slug($slug)
    {
        $slug = html_entity_decode($slug);

        $slug = preg_replace("/(å|ä|ā|à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|ä|ą)/", 'a', $slug);
        $slug = preg_replace("/(ß|ḃ)/", "b", $slug);
        $slug = preg_replace("/(ç|ć|č|ĉ|ċ|¢|©)/", 'c', $slug);
        $slug = preg_replace("/(đ|ď|ḋ|đ)/", 'd', $slug);
        $slug = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|ę|ë|ě|ė)/", 'e', $slug);
        $slug = preg_replace("/(ḟ|ƒ)/", "f", $slug);
        $slug = str_replace("ķ", "k", $slug);
        $slug = preg_replace("/(ħ|ĥ)/", "h", $slug);
        $slug = preg_replace("/(ì|í|î|ị|ỉ|ĩ|ï|î|ī|¡|į)/", 'i', $slug);
        $slug = str_replace("ĵ", "j", $slug);
        $slug = str_replace("ṁ", "m", $slug);

        $slug = preg_replace("/(ö|ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|ö|ø|ō)/", 'o', $slug);
        $slug = str_replace("ṗ", "p", $slug);
        $slug = preg_replace("/(ġ|ģ|ğ|ĝ)/", "g", $slug);
        $slug = preg_replace("/(ü|ù|ú|ū|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|ü|ų|ů)/", 'u', $slug);
        $slug = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ|ÿ)/", 'y', $slug);
        $slug = preg_replace("/(ń|ñ|ň|ņ)/", 'n', $slug);
        $slug = preg_replace("/(ŝ|š|ś|ṡ|ș|ş|³)/", 's', $slug);
        $slug = preg_replace("/(ř|ŗ|ŕ)/", "r", $slug);
        $slug = preg_replace("/(ṫ|ť|ț|ŧ|ţ)/", 't', $slug);

        $slug = preg_replace("/(ź|ż|ž)/", 'z', $slug);
        $slug = preg_replace("/(ł|ĺ|ļ|ľ)/", "l", $slug);

        $slug = preg_replace("/(ẃ|ẅ)/", "w", $slug);

        $slug = str_replace("æ", "ae", $slug);
        $slug = str_replace("þ", "th", $slug);
        $slug = str_replace("ð", "dh", $slug);
        $slug = str_replace("£", "pound", $slug);
        $slug = str_replace("¥", "yen", $slug);

        $slug = str_replace("ª", "2", $slug);
        $slug = str_replace("º", "0", $slug);
        $slug = str_replace("¿", "?", $slug);

        $slug = str_replace("µ", "mu", $slug);
        $slug = str_replace("®", "r", $slug);


        $slug = preg_replace("/(Ä|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|Ą|Å|Ā)/", 'A', $slug);
        $slug = preg_replace("/(Ḃ|B)/", 'B', $slug);
        $slug = preg_replace("/(Ç|Ć|Ċ|Ĉ|Č)/", 'C', $slug);
        $slug = preg_replace("/(Đ|Ď|Ḋ)/", 'D', $slug);
        $slug = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ|Ę|Ë|Ě|Ė|Ē)/", 'E', $slug);
        $slug = preg_replace("/(Ḟ|Ƒ)/", "F", $slug);
        $slug = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ|Ï|Į)/", 'I', $slug);
        $slug = preg_replace("/(Ĵ|J)/", "J", $slug);

        $slug = preg_replace("/(Ö|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|Ø)/", 'O', $slug);
        $slug = preg_replace("/(Ü|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|Ū|Ų|Ů)/", 'U', $slug);
        $slug = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ|Ÿ)/", 'Y', $slug);
        $slug = str_replace("Ł", "L", $slug);
        $slug = str_replace("Þ", "Th", $slug);
        $slug = str_replace("Ṁ", "M", $slug);

        $slug = preg_replace("/(Ń|Ñ|Ň|Ņ)/", "N", $slug);
        $slug = preg_replace("/(Ś|Š|Ŝ|Ṡ|Ș|Ş)/", "S", $slug);
        $slug = str_replace("Æ", "AE", $slug);
        $slug = preg_replace("/(Ź|Ż|Ž)/", 'Z', $slug);

        $slug = preg_replace("/(Ř|R|Ŗ)/", 'R', $slug);
        $slug = preg_replace("/(Ț|Ţ|T|Ť)/", 'T', $slug);
        $slug = preg_replace("/(Ķ|K)/", 'K', $slug);
        $slug = preg_replace("/(Ĺ|Ł|Ļ|Ľ)/", 'L', $slug);

        $slug = preg_replace("/(Ħ|Ĥ)/", 'H', $slug);
        $slug = preg_replace("/(Ṗ|P)/", 'P', $slug);
        $slug = preg_replace("/(Ẁ|Ŵ|Ẃ|Ẅ)/", 'W', $slug);
        $slug = preg_replace("/(Ģ|G|Ğ|Ĝ|Ġ)/", 'G', $slug);
        $slug = preg_replace("/(Ŧ|Ṫ)/", 'T', $slug);

        if (empty($slug)) return $slug;
        if (is_array($slug)) {
            foreach (array_keys($slug) as $key) {
                $slug[$key] = nv_unhtmlspecialchars($slug[$key]);
            }
        } else {
            $search = array(
                '&amp;', '&#039;', '&quot;', '&lt;', '&gt;', '&#x005C;', '&#x002F;', '&#40;', '&#41;', '&#42;', '&#91;', '&#93;', '&#33;', '&#x3D;', '&#x23;', '&#x25;', '&#x5E;', '&#x3A;', '&#x7B;', '&#x7D;', '&#x60;', '&#x7E;'
            );
            $replace = array(
                '&', '\'', '"', '<', '>', '\\', '/', '(', ')', '*', '[', ']', '!', '=', '#', '%', '^', ':', '{', '}', '`', '~'
            );
            $slug = str_replace($search, $replace, $slug);
        }


        $slug = preg_replace("/(!|\"|#|$|%|'|̣)/", '', $slug);
        $slug = preg_replace("/(̀|́|̉|$|>)/", '', $slug);
        $slug = preg_replace("'<[\/\!]*?[^<>]*?>'si", "", $slug);

        $slug = str_replace("----", " ", $slug);
        $slug = str_replace("---", " ", $slug);
        $slug = str_replace("--", " ", $slug);

        $slug = preg_replace('/(\W+)/i', '-', $slug);
        $slug = str_replace(array(
            '-8220-', '-8221-', '-7776-'
        ), '-', $slug);

        $slug = str_replace(array(
            'dAg', 'DAg', 'uA', 'iA', 'yA', 'dA', '--', '-8230'
        ), array(
            'dong', 'Dong', 'uon', 'ien', 'yen', 'don', '-', ''
        ), $slug);
        $slug = preg_replace('/(\-)$/', '', $slug);
        $slug = preg_replace('/^(\-)/', '', $slug);
        return strtolower($slug);
    }
}
