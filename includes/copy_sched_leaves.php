<?php
function getschedLeaves($range,$start,$end,$group_id,$s_days)
	{		
		if(in_array($start,$range))
		{
			$s_week_day=date('D',strtotime($start.'+ '.$s_days.'  day'));
			switch($s_week_day)
			{
				case 'Fri':	{$s_new_days=$s_days+2;}break;
				case 'Sat':	{$s_new_days=$s_days+1;}break;
				default:	{$s_new_days=$s_days;}break;
			}
			$new_start_date=date('Y-m-d',strtotime($start.'+ '.$s_new_days.'  day'));
			$e_week_day=date('D',strtotime($end.'+ '.$s_new_days.'  day'));
			switch($e_week_day)
			{
				case 'Fri':	{$e_days=$s_new_days+2;}break;
				case 'Sat':	{$e_days=$s_new_days+1;}break;
				default:	{$e_days=$s_new_days;}break;
			}
			$new_end_date=date('Y-m-d',strtotime($end.'+ '.$e_days.'  day'));
			#$this->updateTable("student_group","start_date='$new_start_date',end_date='$new_end_date'","id='$group_id'");
			#UPDATE CALL DISABLED MARCH 02 2014
			#$this->updateTable("student_group","end_date='$new_end_date'","id='$group_id'");
			#UPDATE CALL DISABLED MARCH 02 2014
			#echo $group_id."-".$new_start_date.$new_end_date."<BR/>";
			
		}
		else
		{
			$days=date('D',strtotime($end.'+ '.$s_days.'  day'));
			switch($days)
			{	case 'Fri':	{$days=$s_days+2;}break;
				case 'Sat':	{$days=$s_days+1;}break;
				default:	{$days=$s_days;}break;
			}
			$new_end_date=date('Y-m-d',strtotime($end.'+ '.$days.'  day'));
			#$this->updateTable("student_group","end_date='$new_end_date'","id='$group_id'");
			//echo $new_start_date.$new_end_date."<BR/>";
			
		}
		return array('date_end'=>$new_end_date);
	}
	function schedLeaves($type,$id="",$start,$end,$center="")
	{
		switch($type)
		{
			case 'Center':	{
								$days=$this->dateDiff($start, $end)+1;
								$groups= $this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center' AND ('$start' BETWEEN start_date AND end_date) OR ('$end' BETWEEN start_date AND end_date) ORDER BY end_date ASC");
								foreach($groups as $g):
									$group_id=$g['id'];
									$first_end_date=$this->printClassEndDate(date('Y-m-d', strtotime($g['end_date'].' +'.$days.' day'))); 
									$this->updateTable("student_group","end_date='$first_end_date'","id='$group_id'");
									#echo $group_id.$first_end_date."<BR/>";
									$groups2=$this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center' AND (id != '$group_id[id]') AND ('$first_end_date' BETWEEN start_date AND end_date) ORDER BY end_date ASC");
									foreach($groups2 as $g2):
										$group2_id=$g2['id'];
										$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
										$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day']);
										$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
										$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
										#echo $group2_id.$second_start_date.$second_end_date."<BR/>";
									endforeach;
									$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
									$groups3=$this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center' AND ('$compare_third_date' BETWEEN start_date AND end_date) ");
									foreach($groups3 as $g3):
										$group3_id=$g3['id'];
										$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
										$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day']);
										$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
										$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
										#echo $group3_id.$third_start_date.$third_end_date."<BR/>";
									endforeach;
								endforeach;
								
							}break;	
			case 'Teacher':	{	
								$days=$this->dateDiff($start, $end)+1;
								#echo "<BR/>";
								$groups= $this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$id' AND (start_date BETWEEN '$start' AND '$end' OR end_date BETWEEN '$start' AND '$end') AND status !='Completed' ORDER BY end_date ASC");
								foreach($groups as $g):
									$group_id=$g['id'];
									$g1_keys[]=$group_id;
									$status=$g['status'];
									switch($status)
									{
										case 'Not Started':	{
																$first_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($g['start_date'].' +'.$days.' day'))); 
																$first_total_days=$this->printUnitToDays($g['units'],$g['unit_per_day']);
																$first_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($first_start_date.' +'.$first_total_days.' day')));
																#$this->updateTable("student_group","start_date='$first_start_date',end_date='$first_end_date'","id='$group_id'");
															}break;
										case 'Continue':	{
																$first_start_date=$g['start_date'];
																$first_end_date=$this->printClassEndDate(date('Y-m-d', strtotime($g['end_date'].' +'.$days.' day'))); 
																#$this->updateTable("student_group","end_date='$first_end_date'","id='$group_id'");
															}break;
									}
									echo "Loop 1:".$group_id.$first_start_date.$first_end_date."<BR/>";
								endforeach;
								$groups2=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$id' AND ('$first_end_date' BETWEEN start_date AND end_date) AND id NOT IN (".implode(',',array_map('intval',$g1_keys)).") AND status !='Completed' ORDER BY end_date ASC");
								foreach($groups2 as $g2):
									$group2_id=$g2['id'];
									$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
									$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day']);
									$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
									#$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
									echo "Loop 2:".$group2_id.$second_start_date.$second_end_date."<BR/>";
									$g2_keys[]=$group2_id;
								endforeach;
								$merge=array_merge($g1_keys,$g2_keys);
								$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
								$groups3=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$id' AND ('$compare_third_date' BETWEEN start_date AND end_date) AND id NOT IN (".implode(',',array_map('intval',$merge)).") AND status !='Completed' ");
								foreach($groups3 as $g3):
									$group3_id=$g3['id'];
									$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
									$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day']);
									$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
									#$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
									echo "Loop 3:".$group3_id.$third_start_date.$third_end_date."<BR/>";
								endforeach;
							}break;
			case 'Exam':	{	
								#echo $start.$end;
								$groups = $this->genericQuery(" SELECT * FROM student_group WHERE group_name='$id'");
								$days=$this->dateDiff($start, $end)+1;
								#echo "<BR/>";
								foreach($groups as $g):
									$group_id=$g['id'];
									$teacher_id=$g['teacher_id'];
									$start_time=$g['group_time'];
									$end_time=$g['group_time_end'];
									$first_end_date=$this->printClassEndDate(date('Y-m-d', strtotime($g['end_date'].' +'.$days.' day'))); 
									$this->updateTable("student_group","end_date='$first_end_date'","id='$group_id'");
									#echo "Loop 1:".$group_id.$first_end_date."<BR/>";
									$groups2= $this->genericQuery("
																SELECT * FROM student_group 
																WHERE (id !='$g[id]' AND teacher_id='$teacher_id') 
																AND ((start_date BETWEEN '$start' AND '$end' OR end_date BETWEEN '$start' AND '$end'))
																AND (('$start_time' BETWEEN group_time AND group_time_end)OR ('$end_time' BETWEEN group_time AND group_time_end))
															");
									foreach($groups2 as $g2):
										$group2_id=$g2['id'];
										$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
										$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day']);
										$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
										$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
										#echo "Loop 2:".$group2_id.$second_start_date.$second_end_date."<BR/>";
									endforeach;
									$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
									$groups3=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$id' AND ('$compare_third_date' BETWEEN start_date AND end_date) AND (('$start_time' BETWEEN group_time AND group_time_end)OR ('$end_time' BETWEEN group_time AND group_time_end)) ");
									foreach($groups3 as $g3):
										$group3_id=$g3['id'];
										$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
										$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day']);
										$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
										$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
										#echo "Loop 3:".$group3_id.$third_start_date.$third_end_date."<BR/>";
									endforeach;
								endforeach;
							}break;
			default:		{}break;		
		}
	}
	function updategetschedLeaves($end_date,$days,$count_days)
	{
		if($days>$count_days)
		{	
			
			$update_days = $days - $count_days;
			$new_end_date=$this->printClassEndDate(date('Y-m-d',strtotime($end_date.'- '.$update_days.'  day')));
			#echo $new_end_date;
		}
		elseif($days==$count_days)
		{
			$update_days = $days;
			$new_end_date=$this->printClassEndDate(date('Y-m-d',strtotime($end_date.'+ 0  day')));
			
		}
		else
		{	
			$update_days = $count_days - $days ;
			$new_end_date=$this->printClassEndDate(date('Y-m-d',strtotime($end_date.'+ '.$update_days.'  day')));
		}
		/*
			$day=date('D',strtotime($end_date.'+'.$updatedays.'  day'));
			switch($day)
			{	case 'Fri':	{$days=$days+2;}break;
				case 'Sat':	{$days=$days+1;}break;
				default:	{$days=$days;}break;
			}
		*/
		return array('date_end'=>$new_end_date);
	}
	function updateSchedLeaves($type,$id="",$start,$end,$center_id="")
	{
		switch($type)
		{
			case 'Center':	{
								$center=$this->strRecordID("centre_vacation","centre_id,no_days","id='$id'");
								$days=$center[no_days];
								$count_days = $this->dateDiff($start,$end)+1;
								$groups= $this->genericQuery("SELECT * FROM student_group WHERE id='$center_id' AND ('$start' BETWEEN start_date AND end_date) OR ('$end' BETWEEN start_date AND end_date)");
								foreach($groups as $g):
									$g_result=$this->updategetschedLeaves($g[end_date],$days,$count_days);
									#echo $g[end_date]."<BR/>".$g_result[date_end]."<BR/>".$g[id];
									$this->updateTable("centre_vacation","frm='$start',tto='$end',no_days='$count_days'","id='$id'");
									$this->updateTable("student_group","end_date='$g_result[date_end]'","id='$g[id]'");
									$first_end_date=$g_result[date_end];#date('Y-m-d', strtotime($g_result[date_end].' +1 day'));
									$parameter_end_date=date('Y-m-d', strtotime($g_result[date_end].' +2 week'));
									$groups2=$this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center_id' AND (id != '$g[id]') AND ('$parameter_end_date' BETWEEN start_date AND end_date) ORDER BY end_date ASC");
									foreach($groups2 as $g2):
										$group2_id=$g2['id'];
										$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
										$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day']);
										$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
										$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
										#echo $group2_id.$second_start_date.$second_end_date."<BR/>";
									endforeach;
									$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +2 week'))); 
									$groups3=$this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center_id' AND ('$compare_third_date' BETWEEN start_date AND end_date) ");
									foreach($groups3 as $g3):
										$group3_id=$g3['id'];
										$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
										$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day']);
										$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
										$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
										#echo $group3_id.$third_start_date.$third_end_date."<BR/>";
									endforeach;
									
								endforeach;
									
							}break;
			case 'Teacher':	{
								$teacher_id=$center_id;
								$teacher=$this->strRecordID("teacher_vacation","no_days","id='$id'");
								$days=$teacher[no_days];
								$count_days = $this->dateDiff($start,$end)+1;
								$groups= $this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$teacher_id' AND ('$start' BETWEEN start_date AND end_date) OR ('$end' BETWEEN start_date AND end_date)");
								foreach($groups as $g):
									$g_result=$this->updategetschedLeaves($g[end_date],$days,$count_days);
									#echo "Loop 1:".$g[id].$g[end_date].$g_result[date_end]."<BR/>";
									$this->updateTable("teacher_vacation","frm='$start',tto='$end',no_days='$count_days'","id='$id'");
									$this->updateTable("student_group","end_date='$g_result[date_end]'","id='$g[id]'");
									$first_end_date=$g_result[date_end];
									$parameter_end_date=date('Y-m-d', strtotime($g_result[date_end].' +2 week'));
									$groups2=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$teacher_id' AND (id != '$g[id]') AND ('$parameter_end_date' BETWEEN start_date AND end_date) ORDER BY end_date ASC");
									foreach($groups2 as $g2):
										$group2_id=$g2['id'];
										$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
										$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day']);
										$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
										$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
										#echo "Loop 2:".$group2_id.$second_start_date.$second_end_date."<BR/>";
									endforeach;
									$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +2 week'))); 
									$groups3=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$teacher_id' AND ('$compare_third_date' BETWEEN start_date AND end_date) ");
									foreach($groups3 as $g3):
										$group3_id=$g3['id'];
										$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
										$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day']);
										$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
										$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
										#echo "Loop 3:".$group3_id.$third_start_date.$third_end_date."<BR/>";
									endforeach;
								endforeach;
								}break;
			case 'Exam':		{
									$exam=$this->strRecordID("exam_vacation","name,no_days","id='$id'");
									$group_name=$exam[name];
									$days=$exam[no_days];
									$count_days = $this->dateDiff($start,$end)+1;
									$groups= $this->genericQuery("SELECT * FROM student_group WHERE group_name='$group_name'");
									foreach($groups as $g):
									$teacher_id=$g['teacher_id'];
									$start_time=$g['group_time'];
									$end_time=$g['group_time_end'];
									$g_result=$this->updategetschedLeaves($g[end_date],$days,$count_days);
									#echo "Loop 1:".$g[id].$g[end_date].$g_result[date_end]."<BR/>";
									$this->updateTable("exam_vacation","frm='$start',tto='$end',no_days='$count_days'","id='$id'");
									$this->updateTable("student_group","end_date='$g_result[date_end]'","id='$g[id]'");
									$first_end_date=$g_result[date_end];
									$parameter_end_date=date('Y-m-d', strtotime($g_result[date_end].' +2 week'));
									$groups2= $this->genericQuery("
																SELECT * FROM student_group 
																WHERE (id !='$g[id]' AND teacher_id='$teacher_id') 
																AND ((start_date BETWEEN '$start' AND '$parameter_end_date' OR end_date BETWEEN '$start' AND '$parameter_end_date'))
																AND (('$start_time' BETWEEN group_time AND group_time_end)OR ('$end_time' BETWEEN group_time AND group_time_end))
															");
										foreach($groups2 as $g2):
											$group2_id=$g2['id'];
											$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
											$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day']);
											$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
											$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
											#echo "Loop 2:".$group2_id.$second_start_date.$second_end_date."<BR/>";
										endforeach;
										$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +2 week'))); 
										$groups3=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$id' AND ('$compare_third_date' BETWEEN start_date AND end_date) AND (('$start_time' BETWEEN group_time AND group_time_end)OR ('$end_time' BETWEEN group_time AND group_time_end)) ");
										foreach($groups3 as $g3):
											$group3_id=$g3['id'];
											$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
											$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day']);
											$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
											$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
											#echo "Loop 3:".$group3_id.$third_start_date.$third_end_date."<BR/>";
										endforeach;
									endforeach;
								}break;
		}
	}
	function deleteSchedLeaves($type,$id="")
	{
		switch($type)
		{
			case 'Center':		{	
									$center=$this->strRecordID("centre_vacation","centre_id,no_days,frm,tto","id='$id'");
									$groups= $this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center[centre_id]' AND ('$center[frm]' BETWEEN start_date AND end_date) OR ('$center[tto]' BETWEEN start_date AND end_date)");
									$days=$center[no_days];
									#echo var_dump($groups);
									foreach($groups as $g):
										$new_end_date=$this->reverseEndDate(date('Y-m-d',strtotime($g[end_date] .'- '.$days.'  day')));
										#echo "<BR/>";
										$this->updateTable("student_group","end_date='$new_end_date'","id='$g[id]'");
										$first_end_date=date('Y-m-d', strtotime($new_end_date.' +1 day'));
										$parameter_end_date=date('Y-m-d', strtotime($new_end_date.' +2 week'));
										$groups2=$this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center[centre_id]' AND (id != '$g[id]') AND ('$parameter_end_date' BETWEEN start_date AND end_date) ORDER BY end_date ASC");
										foreach($groups2 as $g2):
											$group2_id=$g2['id'];
											$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
											$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day']);
											$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
											$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
											#echo $group2_id.$second_start_date.$second_end_date."<BR/>";
										endforeach;
										$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +2 week'))); 
										$groups3=$this->genericQuery("SELECT * FROM student_group WHERE centre_id='$center[centre_id]' AND ('$compare_third_date' BETWEEN start_date AND end_date) ");
										foreach($groups3 as $g3):
											$group3_id=$g3['id'];
											$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
											$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day']);
											$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
											$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
											#echo $group3_id.$third_start_date.$third_end_date."<BR/>";
										endforeach;
									endforeach;
								}break;
			case 'Teacher':		{
									$teacher=$this->strRecordID("teacher_vacation","teacher_id,no_days,frm,tto","id='$id'");
									$groups= $this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$teacher[teacher_id]' AND ('$teacher[frm]' BETWEEN start_date AND end_date) OR ('$teacher[tto]' BETWEEN start_date AND end_date)");
									$days=$teacher[no_days];
									foreach($groups as $g):
										$new_end_date=$this->reverseEndDate(date('Y-m-d',strtotime($g[end_date] .'- '.$days.'  day')));
										#echo "<BR/>";
										$this->updateTable("student_group","end_date='$new_end_date'","id='$g[id]'");
										$first_end_date=date('Y-m-d', strtotime($new_end_date.' +1 day'));
										$parameter_end_date=date('Y-m-d', strtotime($new_end_date.' +2 week'));
										$groups2=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$teacher[teacher_id]' AND (id != '$g[id]') AND ('$parameter_end_date' BETWEEN start_date AND end_date) ORDER BY end_date ASC");
										foreach($groups2 as $g2):
											$group2_id=$g2['id'];
											$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
											$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day']);
											$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
											$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
											#echo $group2_id.$second_start_date.$second_end_date."<BR/>";
										endforeach;
										$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +2 week'))); 
										$groups3=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$teacher[teacher_id]' AND ('$compare_third_date' BETWEEN start_date AND end_date) ");
										foreach($groups3 as $g3):
											$group3_id=$g3['id'];
											$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
											$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day']);
											$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
											$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
											#echo $group3_id.$third_start_date.$third_end_date."<BR/>";
										endforeach;
									endforeach;
								}break;
			case 'Exam':		{
									$exam=$this->strRecordID("exam_vacation","name,no_days","id='$id'");
									$group_name=$exam[name];
									$days=$exam[no_days];
									$groups= $this->genericQuery("SELECT * FROM student_group WHERE group_name='$group_name'");
									foreach($groups as $g):
										$teacher_id=$g['teacher_id'];
										$start_time=$g['group_time'];
										$end_time=$g['group_time_end'];
										$new_end_date=$this->reverseEndDate(date('Y-m-d',strtotime($g[end_date] .'- '.$days.'  day')));
										#echo "<BR/>";
										$this->updateTable("student_group","end_date='$new_end_date'","id='$g[id]'");
										$first_end_date=date('Y-m-d', strtotime($new_end_date.' +1 day'));
										$parameter_end_date=date('Y-m-d', strtotime($new_end_date.' +2 week'));
										$groups2= $this->genericQuery("
																		SELECT * FROM student_group 
																		WHERE (id !='$g[id]' AND teacher_id='$teacher_id') 
																		AND ((start_date BETWEEN '$start' AND '$parameter_end_date' OR end_date BETWEEN '$start' AND '$parameter_end_date'))
																		AND (('$start_time' BETWEEN group_time AND group_time_end)OR ('$end_time' BETWEEN group_time AND group_time_end))
																	");
										foreach($groups2 as $g2):
											$group2_id=$g2['id'];
											$second_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($first_end_date.' +1 day'))); 
											$total_days=$this->printUnitToDays($g2['units'],$g2['unit_per_day']);
											$second_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($second_start_date.' +'.$total_days.' day')));
											$this->updateTable("student_group","start_date='$second_start_date',end_date='$second_end_date'","id='$group2_id'");
											#echo "Loop 2:".$group2_id.$second_start_date.$second_end_date."<BR/>";
										endforeach;
										$compare_third_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +2 week'))); 
										$groups3=$this->genericQuery("SELECT * FROM student_group WHERE teacher_id='$id' AND ('$compare_third_date' BETWEEN start_date AND end_date) AND (('$start_time' BETWEEN group_time AND group_time_end)OR ('$end_time' BETWEEN group_time AND group_time_end)) ");
										foreach($groups3 as $g3):
											$group3_id=$g3['id'];
											$third_start_date=$this->printClassEndDate(date('Y-m-d', strtotime($second_end_date.' +1 day'))); 
											$third_total_days=$this->printUnitToDays($g3['units'],$g3['unit_per_day']);
											$third_end_date=$this->printClassChangedEndDate(date('Y-m-d', strtotime($third_start_date.' +'.$third_total_days.' day')));
											$this->updateTable("student_group","start_date='$third_start_date',end_date='$third_end_date'","id='$group3_id'");								
											#echo "Loop 3:".$group3_id.$third_start_date.$third_end_date."<BR/>";
										endforeach;
									endforeach;
								}break;
			default:			{}break;
		}
	}
	?>