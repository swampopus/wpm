# wpm
This very simple library is meant to help with debugging PHP web applications.

To use, simply include it in your script like so:  
  >require_once('./wpm/wpm.php');

Then, when you need to output a variable or even a simple message to the browser, just use:  
 
  >wpm('Hello!');  
  >wpm($varname);  
 
 etc.  
 
 It will create an attractive HTML-formatted alternative to print_r or var_dump, similar to Krumo, though hopefully
 easier to use, install, etc.
 
 See this screenshot:  
 > ![wpm function in action](https://user-images.githubusercontent.com/11462492/124657253-e6328380-de67-11eb-863a-5bc37cc2167d.png)
 
 When an array or object is sent through wpm(), you get nice clickable rows which you can expand out to see more details.
 
 ## Parameters - Levels
 
 By default, the max number of "levels" that wpm() will decend into a complex array or object is 20.  You can control this with the second parameter like so:
 > wpm($var, 15); // Only go 15 levels deep.  
 > wpm ($var, 100); // Go 100 levels deep.  

Just be careful, because if you try to go too many levels deep, you might run out of memory and PHP will die.  

## Parameters - Return as String

The last parameter, if set to TRUE, will return the entire HTML out from wpm() as a String, for you to use elsewhere.  Like so:
> $output = wpm($var, 20, TRUE);  
> // do something else with $output later.  


