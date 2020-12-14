<?php
    include_once 'class/communication.php';
    $communication = new communication("");
    
    print $communication->getHTMLMessage("EoI Form #244 is Submitted by Maleesh Wijesekara");
?>