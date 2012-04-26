<?php

class Calendari{

	public function getMes($mes) {
		
	}
	
	/* draws a calendar */
	function pintar($month,$year){

	  /* table headings */
	  $headings = array('Dilluns','Dimarts','Dimecres','Dijous','Divendres','Dissabte','Diumenge');
	  $calendar= '<thead><tr class="calendar-row"><th class="calendar-day-head">'.implode('</th><th class="calendar-day-head">',$headings).'</th></tr></thead><tbody>';

	  /* days and weeks vars now ... */
	  $running_day = date('N',mktime(0,0,0,$month,1,$year));
	  $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	  $days_in_this_week = 1;
	  $day_counter = 0;
	  $dates_array = array();

	  /* row for week one */
	  $calendar.= '<tr class="calendar-row">';

	  /* print "blank" days until the first of the current week */
	  for($x = 1; $x < $running_day; $x++):
	    $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
	    $days_in_this_week++;
	  endfor;

	  /* keep going with days.... */
	  for($list_day = 1; $list_day <= $days_in_month; $list_day++):
	    $calendar.= '<td class="calendar-day">';
	      /* add in the day number */
	      $calendar.= '<div class="data">'.$list_day.'</div>';

	      /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
	      $calendar.= str_repeat('<p></p>',2);

	    $calendar.= '</td>';
	    if($running_day == 7):
	      $calendar.= '</tr>';
	      if(($day_counter+1) != $days_in_month):
	        $calendar.= '<tr class="calendar-row">';
	      endif;
	      $running_day = 0;
	      $days_in_this_week = 0;
	    endif;
	    $days_in_this_week++; $running_day++; $day_counter++;
	  endfor;

	  /* finish the rest of the days in the week */
	  if($days_in_this_week < 8):
	    for($x = 1; $x <= (8 - $days_in_this_week); $x++):
	      $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
	    endfor;
	  endif;

	  /* final row */
	  $calendar.= '</tr></tbody>';

	  /* all done, return result */
	  return $calendar;
	}

}

?>