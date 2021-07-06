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
