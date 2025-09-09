<?php
function html_square($data, $type) {
 
    if($type == 1){
        $fontSize = 2;
       
    } else {
        $fontSize = 5;
    }
    $fontSizeSm = $fontSize + 2;
 
    $result = "\n";
    $result .= "<div class=\"col-6\">\n";
    $result .= "\t<div class=\"ratio ratio-1x1 position-relative overflow-hidden rounded\">\n";
    $result .= "\t\t<div class=\"position-absolute top-0 start-0 w-100 h-100\" style=\"background-size: cover;background-position:center;background-image: url('".base_url("sigma/".$data->photo)."'\">";
    $result .= "</div>\n";
    $result .= "\t\t<div class=\"position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex flex-column justify-content-center align-items-start text-white text-left p-3\">\n";
    $result .= "\t\t\t<a class=\"mt-auto fw-bold fs-".$fontSize." text-white text-decoration-none\" href=\"".$data->link."\">".$data->title."</a>\n";
    $result .= "\t\t\t<div class=\" mt-3 fs-".$fontSizeSm." text-white\">".date("j.n.Y", $data->date)."</div>\n";
    $result .= "\t\t</div>\n";
    $result .= "\t</div>\n";
    $result .= "</div>\n";
 
    return $result;
}

?>