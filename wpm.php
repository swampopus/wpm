<?php

/**
 * This will print out a pretty, clickable HTML-friendly display of a variable, array, etc.
 * 
 * Styled to look and function very similar to Krumo, though hopefully easier to use/install/etc.
 * 
 * Use:   wpm($my_variable);
 * 
 * This code is provided here with permission from Peacock Software, LLC (peacocksoftware.com) and with NO WARRANTY provided.
 * This function (and ws_html_print_r()) are provided AS-IS and "open source" under the 
 * terms of the GNU GPL Version 3.0 or greater.  For complete license information, see: https://www.gnu.org/licenses/gpl-3.0.en.html
 * 
 * 
 * @param mixed $var                This is the variable you wish to output to the screen.
 * @param int $max_levels           This is how many nested levels we will enter.  If you get memory errors, reduce this.
 * @param bool $return_as_string    If set to TRUE, the HTML will be returned as a string.  If left as FALSE, it will be printed to the screen immediately.
 * 
 */
function wpm($var, $max_levels = 20, $return_as_string = FALSE) {
  
  // Complex variable?  Change it to print_r.
  $str = $var;
  if (is_array($str) || is_object($str)) {
    $str = "<div class='ws-html-print-r-wrapper'>" . ws_html_print_r($str, "", 0, $max_levels) . "</div>";
  }    

  $arr = debug_backtrace();
  //pretty_print($arr);
  $file = $arr[0]["file"];
  if (strlen($file) > 70) {
    $file = "..." . substr($file, strlen($file) - 70);
  }
  $str .= "<div class='ws-message-backtrace'>line {$arr[0]["line"]}: $file</div>";

  
  $rtn = "";
  
  if (@$GLOBALS["ws_already_wspm_styles"] != TRUE) {
    
    // We haven't put in our styles yet, so let's add them now.
    $rtn .= "<style>
    
              .ws-html-print-r-wrapper {
                font-size: 0.9em;
                font-family: Arial, Verdana, sans serif;                
              }
              
              .ws-html-print-r-multi-row {
                background-color: lightcyan;
                border: 1px solid #bbb;
                padding: 5px;                  
              }
              
              .ws-html-print-r-multi-row .ws-html-print-r-selector {
                cursor: pointer;  
              }
              
              .ws-html-print-r-multi-row > .ws-html-print-r-var-value {
                padding-left: 30px;
              }
              
              .ws-html-print-r-single-row {
                border-top: 1px solid #bbb;
              }
              
              .ws-html-print-r-var-name {
                color: #404000;
                font-weight: bold;
              }
              
              .ws-html-print-r-var-type {
                font-style: italic;
              }
              
              .ws-html-print-r-single-row .ws-html-print-r-var-value {
                font-weight: bold;
              }
    
           </style>
    
           <script type='text/javascript'>
            
           
            // Similar to jquery toggle.
            function ws_toggle_element(id) {
              
              var e = document.getElementById(id);
              if (e.style.display != 'none') {
                e.style.display = 'none';
              }
              else {
                e.style.display = 'block';
              }
              
            }
            
            
           </script>
           
           
           ";
    
    $GLOBALS["ws_already_wspm_styles"] = TRUE;
  }
   
  
  $rtn .= "<div class='wspm-message'>&bull; $str</div>";

  
  if ($return_as_string) return $rtn;
  
  print $rtn;
  
    
}


/**
 * Similar to print_r, this will return an HTML-friendly
 * click-to-open system similar in design to Krumo.
 * 
 * You should not call this function directly, but instead use wpm()
 * 
 * This function is provided here with permission from Peacock Software, LLC (peacocksoftware.com) and with NO WARRANTY provided.
 * This function (and wpm()) are provided AS-IS and "open source" under the 
 * terms of the GNU GPL Version 3.0 or greater.  For complete license information, see: https://www.gnu.org/licenses/gpl-3.0.en.html
 *  
 */
function ws_html_print_r($var, $name = "", $cnt = 0, $max_levels = 20) {  
  $rtn = "";

  
  if ($cnt > $max_levels) {
    // Max levels deep.  Deeper, and PHP might run
    // out of memory or complain.
    $rtn .= "<div class='ws-html-print-r-too-deep'>
              " . t("Depth too great. To view deeper,
                     rephrase your wspm() call, extending past this depth ($max_levels).") . "
             </div>";
    return $rtn;
  }
  
  $type = gettype($var);
  $rnd = md5(mt_rand(0, 999999) . microtime() . $type . $name);
  
  if ($type == "boolean") {
    $var = ($var == TRUE) ? "TRUE" : "FALSE";
  }  
  
  $count = "";
  if ($type == "string") {
    $count = " - " . strlen($var) . " " . "chars";
  }
  
  if ($type == "array" || $type == "object") {
      
    
    if ($type == "array") {
      $count = " - " .  count($var) . " " . "elements";
    }
    
    if ($type == "object") {
      $count = " - " . get_class($var);
    }
    
    $rtn .= "<div class='ws-html-print-r-multi-row'>
               <div class='ws-html-print-r-selector'
                  onClick='ws_toggle_element(\"ws-html-print-r-var-value-$rnd\");'
                  >
                  <span class='ws-html-print-r-var-name'>$name</span>
                  <span class='ws-html-print-r-var-type'>($type$count)</span>
                  </div>
               <div class='ws-html-print-r-var-value' id='ws-html-print-r-var-value-$rnd' style='display: none;'>";
    foreach ($var as $key => $value) {
      $rtn .= ws_html_print_r($value, $key, ($cnt + 1), $max_levels);
    }
    
    $rtn .= "</div>
             </div>";
  }
  else if ($type == "string" && strlen($var) > 50) {
    // If the variable is fairly long, we want to also make it a hide-to-show type field.
    $rtn .= "<div class='ws-html-print-r-multi-row'>
               <div
                  onClick='ws_toggle_element(\"ws-html-print-r-var-value-$rnd\");'
                  >
                    <span class='ws-html-print-r-var-name'>$name</span>
                    <span class='ws-html-print-r-var-type'>($type$count)</span>
                    <span class='ws-html-print-r-var-value-abbr'>" . htmlentities(substr($var, 0, 50)) . "...</span>
                  </div>
               <div class='ws-html-print-r-var-value' id='ws-html-print-r-var-value-$rnd' style='display: none;'>
               ";
    $rtn .= htmlentities($var);
    $rtn .= "</div></div>";    
  }
  else { 
    
    $html_val = $var;
    if ($type != "resource") {
      $html_val = htmlentities("" . $var);
    }
    
    $rtn .= "<div class='ws-html-print-r-single-row'>                
                <span class='ws-html-print-r-var-name'>$name</span>
                <span class='ws-html-print-r-var-type'>($type$count)</span>
                <span class='ws-html-print-r-var-value'>$html_val</span>
           </div>";
  }  
  
  return $rtn;
}
