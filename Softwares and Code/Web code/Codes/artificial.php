<?php
	$cur=1;
	$vol=23;
	$pha=3;
	$fre=4;
    $init=$fre;
	
 for ($x = 0; $x <= 6540; $x++) 
{
	
	$cur++;
	$vol++;
	$pha++;
	$fre++;
	header('Location:action.php?cur='.urlencode($cur)."&vol=" . urlencode($vol)."&pha=" . urlencode($pha)."&fre=" . urlencode($fre));
	

}
?>