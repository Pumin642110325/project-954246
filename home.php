<?php 
session_start();
$title = "Home"; 
include_once __DIR__ . '/partials/layout.php'; 
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

