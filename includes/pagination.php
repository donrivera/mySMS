<?php

/**
 * @author Jooria Refresh Your Website <www.jooria.com>
 * @copyright 2010
 */
include_once 'class.Main.php';

function Pages($tbl_name,$limit,$path,$condition="")
{
	//Object initialization
	$dbf = new User();
	
	//Total rows count
	if($condition == ''){	
		$total_pages = $dbf->countRows($tbl_name);
	}else{
		$total_pages = $dbf->countRows($tbl_name,$condition);
	}
	$adjacents = "2";

	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$page = ($page == 0 ? 1 : $page);

	if($page)
	$start = ($page - 1) * $limit;
	else
	$start = 0;

	//$sql = "SELECT id FROM $tbl_name LIMIT $start, $limit";
	$result=$dbf->strRecordID($tbl_name, 'id',"");
	
	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = ceil($total_pages/$limit);
	$lpm1 = $lastpage - 1;

	$pagination = "";
	if($lastpage > 1)
	{   
		$pagination .= "<div class='pagination'>";
		if ($page > 1)
			$pagination.= "<a href='".$path."page=$prev'>« Prev</a>";
		else
			$pagination.= "<span class='disabled'>« Prev</span>";   
	
		if ($lastpage < 7 + ($adjacents * 2))
		{   
		for ($counter = 1; $counter <= $lastpage; $counter++)
		{
		if ($counter == $page)
			$pagination.= "<span class='current'>$counter</span>";
		else
			if($formname=="productpage")
			{
				$pagination.= "<a href='".$path."page=$counter&country=$cateid'>$counter</a>";
			}
			else
			{
				$pagination.= "<a href='".$path."page=$counter'>$counter</a>";
			}			
		}
	}
	elseif($lastpage > 5 + ($adjacents * 2))
	{
	if($page < 1 + ($adjacents * 2))       
	{
	for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
	{
		if ($counter == $page)
			$pagination.= "<span class='current'>$counter</span>";
		else
			if($formname=="productpage")
			{
				$pagination.= "<a href='".$path."page=$counter&country=$cateid'>$counter</a>";
			}
			else
			{
				$pagination.= "<a href='".$path."page=$counter'>$counter</a>";
			}
			//$pagination.= "<a href='".$path."page=$counter'>$counter</a>";                   
		}
		$pagination.= "...";
		$pagination.= "<a href='".$path."page=$lpm1'>$lpm1</a>";
		$pagination.= "<a href='".$path."page=$lastpage'>$lastpage</a>";       
	}
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
	$pagination.= "<a href='".$path."page=1'>1</a>";
	$pagination.= "<a href='".$path."page=2'>2</a>";
	$pagination.= "...";
	for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
	{
		if ($counter == $page)
			$pagination.= "<span class='current'>$counter</span>";
		else
			if($formname=="productpage")
			{
				$pagination.= "<a href='".$path."page=$counter&country=$cateid'>$counter</a>";
			}
			else
			{
				$pagination.= "<a href='".$path."page=$counter'>$counter</a>";
			}
			//$pagination.= "<a href='".$path."page=$counter'>$counter</a>";                   
		}
		$pagination.= "..";
		$pagination.= "<a href='".$path."page=$lpm1'>$lpm1</a>";
		$pagination.= "<a href='".$path."page=$lastpage'>$lastpage</a>";       
	}
	else
	{
		$pagination.= "<a href='".$path."page=1'>1</a>";
		$pagination.= "<a href='".$path."page=2'>2</a>";
		$pagination.= "..";
		for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
		{
			if ($counter == $page)
				$pagination.= "<span class='current'>$counter</span>";
			else
				if($formname=="productpage")
				{
					$pagination.= "<a href='".$path."page=$counter&country=$cateid'>$counter</a>";
				}
				else
				{
					$pagination.= "<a href='".$path."page=$counter'>$counter</a>";
				}
				//$pagination.= "<a href='".$path."page=$counter'>$counter</a>";                   
			}
		}
	}

	if ($page < $counter - 1)
		$pagination.= "<a href='".$path."page=$next'>Next »</a>";
	else
		$pagination.= "<span class='disabled'>Next »</span>";
		$pagination.= "</div>\n";       
	}
	return $pagination;
}
?>