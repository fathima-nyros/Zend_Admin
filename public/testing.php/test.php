<?php

$output = '<?xml version="1.0" encoding="UTF-8"?><root>';
/*if(pg_num_rows($rs)>0)
{
while($myrow = pg_fetch_assoc($rs))
{*/
$output .= sprintf('<row><latitude>%s</latitude><longitude>%s</longitude><altitude>%s</altitude><date>%s</date></row>',
"hjjh", "nmj ,njmc", "jkkcjzck", "nmnmn");
$output .= "\n";
/*}
}*/
$output .= '</root>';
file_put_contents('file.xml', $output);

?>