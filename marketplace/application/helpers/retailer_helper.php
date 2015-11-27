<?php
function total_avrage_rating($rating_1=0,$rating_2=0,$rating_3=0,$rating_4=0,$rating_5=0)
{	
	$totalDiv = total_rating($rating_1,$rating_2,$rating_3,$rating_4,$rating_5);
	$rating_1 = rating1($rating_1);
	$rating_2 = rating2($rating_2);
	$rating_3 = rating3($rating_3);
	$rating_4 = rating4($rating_4);
	$rating_5 = rating5($rating_5);
	
	$total    = total_rating($rating_1,$rating_2,$rating_3,$rating_4,$rating_5);
	$avrage   = $total/$totalDiv;
	
	return $avrage;
}

function total_rating($rating_1=0,$rating_2=0,$rating_3=0,$rating_4=0,$rating_5=0)
{
	$total = $rating_1+$rating_2+$rating_3+$rating_4+$rating_5;
	return $total;
}

function rating1($rating_1=0)
{
	return $rating_1*1;
}

function rating2($rating_2=0)
{
	return $rating_2*2;
}

function rating3($rating_3=0)
{
	return $rating_3*3;
}

function rating4($rating_4=0)
{
	return $rating_4*4;
}

function rating5($rating_5=0)
{
	return $rating_5*5;
}

function assoc_array_sort($a, $b, $key, $sequence = 'ASC')
{
	if (strtoupper($sequence) == 'DESC') 
	{
		$lower = 1;
	  	$higher = -1;
	}
	else 
	{
		$lower = -1;
  		$higher = 1;
	}

	if ($a[$key] == $b[$key]) 
	{
		return 0;
  	} 
	else if ($a[$key] < $b[$key]) 
	{
    	return $lower;
    } 
	else 
	{
      	return $higher;
    }
}

function price_sorting($x, $y)
{
	$ret_var = assoc_array_sort($x, $y, 'currentPrice','DESC');
    return $ret_var;
}

function seller_sorting($x, $y)
{
	$ret_var = assoc_array_sort($x, $y, 'retailer_name','ASC');
    return $ret_var;
}

function rating_sorting($x, $y)
{
	$ret_var = assoc_array_sort($x, $y, 'rating','ASC');
    return $ret_var;
}
?>