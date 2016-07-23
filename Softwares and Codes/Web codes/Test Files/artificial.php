<?php
	$cur=1;
	$vol=2;
	$pha=3;
	$fre=4;
    $init=$fre;
	echo 'reached here';
	header('Location:action.php?cur='.urlencode($cur)."&vol=" . urlencode($vol)."&pha=" . urlencode($pha)."&fre=" . urlencode($fre));
	echo 'unable to do this';
?>