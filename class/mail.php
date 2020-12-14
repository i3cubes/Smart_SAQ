<?php
class mail {

    public function mailBody($emp_name, $shedule_array) {
        $html = "<html>"
                . "<head>"
                . "<title>ALSWH</title>"
                . "<meta charset='UTF-8'>"
                . "<meta name='viewport' content='width=device-width, initial-scale=1.0'>"
                . "<style>table {border:1px solid;border-collapse:collapse;}"
                . "table td {border:2px solid;padding:5px;margin:3px;}"
                . ".footer_email{background:#9ecfc2;}"
                . ".address_text{font-size:14px;} .footer_notice{font-size:11px;}"
                . "</style>"
                . "</head>"
                . "<body>"
                . "<table border=2>"
//                . "<tr>"
//                    . "<td><img src='' height='80'></td>"
//                . "</tr>"
                . "<tr>"
                . "<td>".$emp_name."</td>";
        foreach ($shedule_array as $obj) {
            $html .= "<td style='background:yellow;'>"
                    . "<div>Date: ".$obj['date']."</div>"
                    . "<div>Start time: ".$obj['start_time']."</div>"
                    . "<div>End time: ".$obj['end_time']."</div>"
                    . "<div>Centre: ".$obj['center']."</div>"
                    . "</td>";
        }
        $html .= "</tr>"
                . "</table>"
                . "</body>"
                . "</html>";
        
        return $html;
    }

}

?>