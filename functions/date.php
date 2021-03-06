<?
   /**
    **  date.php
    **
    **  Takes a date and parses it into a usable format.  The form that a
    **  date SHOULD arrive in is:
    **        <Tue,> 29 Jun 1999 09:52:11 -0500 (EDT)
    **  (as specified in RFC 822) -- "Tue" is optional
    **
    **/

   function getMinutes($hour) {
      $date = $hour;

      if (($hour == 0) || ($hour == "00"))
         $date = "00";
      else if (($hour == 1) || ($hour == "01"))
         $date = "01";
      else if (($hour == 2) || ($hour == "02"))
         $date = "02";
      else if (($hour == 3) || ($hour == "03"))
         $date = "03";
      else if (($hour == 4) || ($hour == "04"))
         $date = "04";
      else if (($hour == 5) || ($hour == "05"))
         $date = "05";
      else if (($hour == 6) || ($hour == "06"))
         $date = "06";
      else if (($hour == 7) || ($hour == "07"))
         $date = "07";
      else if (($hour == 8) || ($hour == "08"))
         $date = "08";
      else if (($hour == 9) || ($hour == "09"))
         $date = "09";

      return $date;
   }

   function getHour($hour) {
      $time = explode(":", $hour);
      return $time[0];
   }

   function getMinute($min) {
      $time = explode(":", $min);
      return $time[1];
   }

   function getSecond($sec) {
      $time = explode(":", $sec);
      return $time[2];
   }

   function getMonthNum($month) {
      if (eregi("jan|january", $month, $tmp))
         $date = "01";
      else if (eregi("feb|february|febuary", $month, $tmp))
         $date = "02";
      else if (eregi("mar|march", $month, $tmp))
         $date = "03";
      else if (eregi("apr|april", $month, $tmp))
         $date = "04";
      else if (eregi("may", $month, $tmp))
         $date = "05";
      else if (eregi("jun|june", $month, $tmp))
         $date = "06";
      else if (eregi("jul|july", $month, $tmp))
         $date = "07";
      else if (eregi("aug|august", $month, $tmp))
         $date = "08";
      else if (eregi("sep|sept|september", $month, $tmp))
         $date = "09";
      else if (eregi("oct|october", $month, $tmp))
         $date = "10";
      else if (eregi("nov|november", $month, $tmp))
         $date = "11";
      else if (eregi("dec|december", $month, $tmp))
         $date = "12";

      return $date;
   }

   function getDayOfWeek($day) {
      $date = "{WEEKDAY}";

      if (eregi("(mon|monday)", $day, $tmp))
         $date = "Mon";
      else if (eregi("(tue|tuesday)", $day, $tmp))
         $date = "Tue";
      else if (eregi("(wed|wednesday)", $day, $tmp))
         $date = "Wed";
      else if (eregi("(thurs|thu|thursday)", $day, $tmp))
         $date = "Thu";
      else if (eregi("(fri|friday)", $day, $tmp))
         $date = "Fri";
      else if (eregi("(sat|saturday)", $day, $tmp))
         $date = "Sat";
      else if (eregi("(sun|sunday)", $day, $tmp))
         $date = "Sun";

      return $date;
   }

   function getDayOfMonth($day) {
      return ereg_replace("^0", "", $day); /* remove a preceeding 0 */
   }

   function getMonth($month) {
      $date = "{MONTH}";
      if (eregi("jan|january", $month, $tmp))
         $date = "Jan";
      else if (eregi("feb|february|febuary", $month, $tmp))
         $date = "Feb";
      else if (eregi("mar|march", $month, $tmp))
         $date = "Mar";
      else if (eregi("apr|april", $month, $tmp))
         $date = "Apr";
      else if (eregi("may", $month, $tmp))
         $date = "May";
      else if (eregi("jun|june", $month, $tmp))
         $date = "Jun";
      else if (eregi("jul|july", $month, $tmp))
         $date = "Jul";
      else if (eregi("aug|august", $month, $tmp))
         $date = "Aug";
      else if (eregi("sep|sept|september", $month, $tmp))
         $date = "Sep";
      else if (eregi("oct|october", $month, $tmp))
         $date = "Oct";
      else if (eregi("nov|november", $month, $tmp))
         $date = "Nov";
      else if (eregi("dec|december", $month, $tmp))
         $date = "Dec";

      return $date;
   }

   function getYear($year) {
      return $year;
   }

   function getDateString($dateParts) {
      /** $dateParts[0] == <day of week>   Mon, Tue, Wed
       ** $dateParts[1] == <day of month>  23
       ** $dateParts[2] == <month>         Jan, Feb, Mar
       ** $dateParts[3] == <year>          1999
       ** $dateParts[4] == <time>          18:54:23 (HH:MM:SS)
       ** $dateParts[5] == <from GMT>      +0100
       ** $dateParts[6] == <zone>          (EDT)
       **
       ** NOTE:  In RFC 822, it states that <day of week> is optional.
       **        In that case, dateParts[0] would be the <day of month>
       **        and everything would be bumped up one.
       **/

      /* if the first part is a day */
      if (eregi("mon|tue|wed|thu|fri|sat|sun", trim($dateParts[0]), $tmp)) {
         $dateParts[0] = getDayOfWeek(trim($dateParts[0]));
         $dateParts[1] = getDayOfMonth(trim($dateParts[1]));
         $dateParts[2] = getMonth(trim($dateParts[2]));
         $dateParts[3] = getYear(trim($dateParts[3]));
         return "$dateParts[2] $dateParts[1], $dateParts[3]";
      }
      $dateParts[0] = getDayOfMonth(trim($dateParts[0]));
      $dateParts[1] = getMonth(trim($dateParts[1]));
      $dateParts[2] = getYear(trim($dateParts[2]));
      return "$dateParts[1] $dateParts[0], $dateParts[2]";
   }

   function getTimeStamp($dateParts) {
      if (eregi("mon|tue|wed|thu|fri|sat|sun", $dateParts[0], $tmp)) {
         $d[0] = getHour(trim($dateParts[4]));
         $d[1] = getMinute(trim($dateParts[4]));
         $d[2] = getSecond(trim($dateParts[4]));
         $d[3] = getMonthNum(trim($dateParts[2]));
         $d[4] = getDayOfMonth(trim($dateParts[1]));
         $d[5] = getYear(trim($dateParts[3]));
         return mktime($d[0], $d[1], $d[2], $d[3], $d[4], $d[5]);
      }
      $d[0] = getHour(trim($dateParts[3]));
      $d[1] = getMinute(trim($dateParts[3]));
      $d[2] = getSecond(trim($dateParts[3]));
      $d[3] = getMonthNum(trim($dateParts[1]));
      $d[4] = getDayOfMonth(trim($dateParts[0]));
      $d[5] = getYear(trim($dateParts[2]));
      return mktime($d[0], $d[1], $d[2], $d[3], $d[4], $d[5]);
   }

   function getLongDateString($stamp) {
      $dateArray = getDate($stamp);

      if ($dateArray["hours"] >= 12) {
         $am_pm = "p.m.";
      } else {
         $am_pm = "a.m.";
      }

      if ($dateArray["hours"] >= 13) {
         $dateArray["hours"] = $dateArray["hours"] - 12;
      }

      $dateParts[0] = getDayOfMonth($dateArray["mday"]);
      $dateParts[1] = getMonth($dateArray["month"]);
      $dateParts[2] = getYear($dateArray["year"]);
      $dateParts[3] = $dateArray["hours"]; // hour
      $dateParts[4] = getMinutes($dateArray["minutes"]); // minute

      return "$dateParts[1] $dateParts[0], $dateParts[2] at $dateParts[3]:$dateParts[4] $am_pm";
   }
?>
