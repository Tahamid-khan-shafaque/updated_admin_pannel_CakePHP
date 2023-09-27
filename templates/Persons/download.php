<?php
    $this->layout = 'pdf';
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="person.pdf"');
    echo $this->Pdf->output();
?>
