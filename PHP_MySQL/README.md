# AWS IoT Button To PHP 
Rev 1.0 (April 2018)
  
## PHP / MYSQL FILES
  
### Website Files
  
- _settings.php  
- checker.php  
- db.php  
- index.php  
- iot_button_click.php  
- jquery.min.js  
  
### How to Use  
  
1. Using a text editor, open file "_settings.php" and update:  
  -- MySQL Host, Login, Password, DB Name, IoT Button S/N  
  
2. Using a text editor, open "iot_button_click.php" and uncomment the line that represents your time zone  
  -- This step is optional, but important to get accurate results     
  
3. Using a text editor, open "index.php" and update the interval:  
  -- Line 35: `setInterval(check,3000);`  
  -- Interval is milliseconds, so 3000 = 3 seconds  
  -- This step is optional  
  -- Three seconds (3000) is fast enough for testing purposes  
  -- Use a longer interval (e.g., 30000 for 30 seconds) to reduce the script's footprint in your website stats  
  -- Longer interval means you have to wait longer for click data to appear on your website
  -- Leave it at 3000 if you don't care about the impact on stats  
  
4. Copy jQuery and PHP files to your site (e.g., upload via FTP)  
  -- That's an old version of jQuery, so update it later  
  
5. Run a test by browsing index.php. The result should be: "The AWS IoT Button has not been clicked today."  
  -- If you get an error, try uncommenting the PHP error reporting code near the top of index.php:  
  -- `ini_set('display_errors', 1); error_reporting(E_ALL);`  
  
### MySQL File
  
- mysql.sql  
  
### How to Use  
  
1. Make an empty MySQL database that you can access from your PHP site, and a user with read/write access to the database. Save the following info for later:  
  -- MySQL server host  
  -- User Login  
  -- User Password  
  -- Database Name  
  
2. Open mysql.sql (using a common text editor such as WordPad)  
  
3. If you'd like, you can change the value for IS_AWSbuttonSN  
  -- Change sample value "A123BC456789DEFG" to your button S/N  
  -- The S/N can also easily be changed in the table later on  
  
3. Select all and copy, then use it to run a query on the empty database   
  -- phpMyAdmin: Select the new database, click "SQL" tab, paste code into the box and click "Go"

4. In phpMyAdmin, open table `t_iotsettings` and verify field `IS_AWSbuttonSN` has your IoT button serial number (update as needed)
 

