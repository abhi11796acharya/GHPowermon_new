<?php
	$cur=1;
	$vol=23;
	$pha=3;
	$fre=4;
    $init=$fre;
	
 for ($x = 0;$x <= 250;$x++)
{
	header('Location:action.php?cur='.urlencode($cur)."&vol=" . urlencode($vol)."&pha=" . urlencode($pha)."&fre=" . urlencode($fre));
	$cur++;
	header('Location:action.php?cur='.urlencode($cur)."&vol=" . urlencode($vol)."&pha=" . urlencode($pha)."&fre=" . urlencode($fre));
	$vol++;
	header('Location:action.php?cur='.urlencode($cur)."&vol=" . urlencode($vol)."&pha=" . urlencode($pha)."&fre=" . urlencode($fre));
	$pha++;
	header('Location:action.php?cur='.urlencode($cur)."&vol=" . urlencode($vol)."&pha=" . urlencode($pha)."&fre=" . urlencode($fre));
	$fre++;
	header('Location:action.php?cur='.urlencode($cur)."&vol=" . urlencode($vol)."&pha=" . urlencode($pha)."&fre=" . urlencode($fre));
}
?>