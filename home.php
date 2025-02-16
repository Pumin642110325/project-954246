<?php
   session_start();
   require_once "header.php";
?>
<html>
   <body>
      <div class="content">
         <div class="tablefirst">
            <table>
               <tr>
                  <td>BEST SELLER</td>
               </tr>
            </table>
         </div>
      </div>
  <?php
   require_once "best.php";
   ?>
   </body>
</html>

