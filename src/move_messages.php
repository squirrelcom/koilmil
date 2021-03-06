<HTML><BODY TEXT="#000000" BGCOLOR="#FFFFFF" LINK="#0000EE" VLINK="#0000EE" ALINK="#0000EE">
<?
   include("../config/config.php");
   include("../functions/mailbox.php");
   include("../functions/strings.php");
   include("../functions/page_header.php");
   include("../functions/display_messages.php");
   include("../functions/imap.php");


   function putSelectedMessagesIntoString($msg) {
      $j = 0;
      $i = 0;
      $firstLoop = true;
      
      // If they have selected nothing msg is size one still, but will be an infinite
      //    loop because we never increment j.  so check to see if msg[0] is set or not to fix this.
      while (($j < count($msg)) && ($msg[0])) {
         if ($msg[$i]) {
            if ($firstLoop != true)
               $selectedMessages .= "&";
            else
               $firstLoop = false;

            $selectedMessages .= "selMsg[$j]=$msg[$i]";
            
            $j++;
         }
         $i++;
      }
   }

   $imapConnection = loginToImapServer($username, $key, $imapServerAddress);

   // switch to the mailbox, and get the number of messages in it.
   selectMailbox($imapConnection, $mailbox, $numMessages, $imapServerAddress);

   // If the delete button was pressed, the moveButton variable will not be set.
   if (!$moveButton) {
      displayPageHeader($mailbox);
      if (is_array($msg) == 1) {
         // Marks the selected messages ad 'Deleted'
         $j = 0;
         $i = 0;
      
         // If they have selected nothing msg is size one still, but will be an infinite
         //    loop because we never increment j.  so check to see if msg[0] is set or not to fix this.
         while ($j < count($msg)) {
            if ($msg[$i]) {
               echo "MSG: $msg[$i]<BR>";
               deleteMessages($imapConnection, $msg[$i], $msg[$i], $numMessages, $trash_folder, $move_to_trash, $auto_expunge, $mailbox);
               $j++;
            }
            $i++;
         }
         messages_deleted_message($mailbox, $sort, $startMessage);
      } else {
         echo "<BR><BR><CENTER>No messages selected.</CENTER>";
      }
   } else {    // Move messages
      displayPageHeader($mailbox);
      // lets check to see if they selected any messages
      if (is_array($msg) == 1) {
         $j = 0;
         $i = 0;
 
         // If they have selected nothing msg is size one still, but will be an infinite
         //    loop because we never increment j.  so check to see if msg[0] is set or not to fix this.
         while ($j < count($msg)) {
            if ($msg[$i]) {
               /** check if they would like to move it to the trash folder or not */
               $success = copyMessages($imapConnection, $msg[$i], $msg[$i], $targetMailbox);
               if ($success == true)
                  setMessageFlag($imapConnection, $msg[$i], $msg[$i], "Deleted");
               $j++;
            }
            $i++;
         }
         if ($auto_expunge == true)
            expungeBox($imapConnection, $mailbox, $numMessages);

         messages_moved_message($mailbox, $sort, $startMessage);
      } else {
         error_message("No messages were selected.", $mailbox, $sort, $startMessage);
      }
   }

   // Log out this session
   fputs($imapConnection, "1 logout");

?>
</BODY></HTML>
