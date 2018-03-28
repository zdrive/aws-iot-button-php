# AWS IoT Button To PHP 
Rev 0.9 (March 2018)

# THIS PROJECT IS UNDER CONSTRUCTION 
# THIS DOCUMENT IS UNDER CONSTRUCTION 

## DESCRIPTION
Uses a Python script for AWS Lambda to send click data from an Amazon AWS IoT button to a PHP script via HTTP. Button click data is stored in MySQL, and displayed on a web page. Using jQuery, the display is updated without refreshing.

- IoT_Button+WiFi --> AWS_Lambda --> **_PHP/MySQL/HTML_** <-- jQuery

See [iot-button-integration-overview.jpg](iot-button-integration-overview.jpg) for an illustration.

## Quick Start  
(See detailed instructions below)  

- PHP/MySQL
1. Make an empty MySQL database and a read/write user 
2. Open mysql.sql (using a common text editor such as WordPad)
3. Select all and copy, then use it to run a query on the empty database (using a DB tool such as phpMyAdmin)
4. In phpMyAdmin, open table `t_iotsettings` and update field `IS_AWSbuttonSN` to your IoT button serial number
5. Using a text editor, open file "_settings.php" and update:  
  -- Host, Login, Password, DB Name, IoT Button Serial Number
6. Copy PHP files to your site (e.g., upload via FTP)  

- Amazon AWS
1. Set up IoT Button in AWS, and connect it to local WiFi
2. Edit the Python code so "PostingURL" points to your website
3. Zip the Python file, and all of the folders into a single file
4. Log into Amazon AWS
5. Create IAM execution role for Lambda Basic Execution (you can use an exisiting Lambda Basic Execution role, if present)
6. Create a new AWS Lambda function  
  -- Runtime: Python 3.6  
  -- Choose existing role: Lambda Basic Execution (from above)
  -- All other fields per your discretion
7. Upload the function code  
  -- Code entry type: Upload a Zip file  
  -- Use the Zip from step 3 above  
  -- (Important!) Handler: main_wwwexamplecom.handler
  -- Click the Save button
8. Configure a test event using the sample JSON:  
  -- e.g., "TestEventLiveSNsingle.json"  
  -- change "IOTbtnSerialNum" to your button's S/N 
9. Run the test event, while also watching your PHP web page
10. Check the results:  
  -- PHP Web page should report the click type and date/time  
  -- Lambda Execution Result (near bottom) should be "null"  
  -- If it fails, look for clues in the Execution Result  
  -- A fail here could be due to hosting restrictions (check web server logs for more clues)    
11. When tests are successful, add you IoT button as a trigger:  
  -- From the "Add triggers" panel on the left side  
  -- Click "AWS IoT"  
  -- Go to the "Configure triggers" section below  
  -- Custom IoT Rule... Rule... Pick an existing Rule  
  -- Choose your IoT button  
  -- Click the Save button
12. The moment of truth... Click your IoT button, while watching the PHP web page, and check the results:  
  -- PHP Web page should report the click type and date/time  
  -- View click data in database table `t_iotbuttontracker`  
  -- A fail here could be due to IoT button setup. Look at "Invocation count" in the function's Monitoring tab to verify  


## REQUIREMENTS
1. Amazon AWS Account   
The heart of this system is Amazon Web services. There you can register your IoT button, and upload the Python code that responds to a button click.  
  -- This demo can not be performed without an AWS account.  
  -- If you need to set up an AWS account, then be advised that the process includes account verification by Amazon, so it takes time to complete the set up.  
  -- URL: https://aws.amazon.com/  
2. AWS IoT Button (or simulator)  
This is the physical device that will initiate the request. Before you can do anything with it, you'll need to register it in your AWS account, set it up with your WiFi and download security keys from your AWS account, then upload the keys to your button.  
  -- If you have a button, and you've already set it up and installed the security keys, then you don't need to do it again.  
  -- If you have a button, but you have not set it up, then stop here and go do that. See "Getting Started with AWS IoT" at https://docs.aws.amazon.com/iot/latest/developerguide/iot-gs.html  
  -- If you *do not* have a button, there are ways to simulate one. But you've got a button, don't you? Otherwise you probably wouldn't be looking at this code!
3. Website that supports PHP and MySQL (any web server O/S)  
  -- NOTICE: The script polls every three seconds, so it can cause a spike in your web stats (i.e., an extra 20 pages per minute while the page is open). For testing, run this at a site where stats are not important.


## Let's Go  
How to compile and use (detailed instructions)  

### PHP / MySQL Website

1. Make an empty MySQL database that you can access from your PHP site, and a user that can read and write to the database. Save the following info for later:  
  -- MySQL server host  
  -- User Login  
  -- User Password  
  -- Database Name  

2. Open mysql.sql (using a common text editor such as WordPad)  
  -- If you'd like, you can change the value for IS_AWSbuttonSN  
  -- Change sample value "A123BC456789DEFG" to your button S/N  
  -- The S/N can also easily be changed in the table later on  

3. Select all and copy, then use it to run a query on the empty database   
  -- phpMyAdmin: Select the new database, click "SQL" tab, paste code into the box and click "Go"

4. In phpMyAdmin, open table `t_iotsettings` and verify field `IS_AWSbuttonSN` has your IoT button serial number (update as needed)

5. Using a text editor, open file "_settings.php" and update:  
  -- MySQL Host, Login, Password, DB Name, IoT Button S/N  

6. Using a text editor, open index.php and update the interval:  
  -- Line 35: `setInterval(check,3000);`  
  -- Interval is milleseconds, so 3000 = 3 seconds  
  -- Three seconds (3000) is fast enough for testing
  -- This step is optional. Use a longer interval (e.g., 30000 for 30 seconds) if you want to reduce the script's footprint in your website stats

7. Copy PHP files to your site (e.g., upload via FTP)  
-- That's an old version of jQuery, so update it later  

8. Run the test by browsing index.php. The result should be: "The AWS IoT Button has not been clicked today."  
  -- If you get an error, try uncommenting the PHP error reporting code near the top of index.php:  
  -- `ini_set('display_errors', 1); error_reporting(E_ALL);`  

### Amazon AWS

A. Prepare the Python source file and "requests" library.  

1. Update the Python file using any text editor: main_wwwexamplecom.py 
- change PostingURL, but make sure to keep the quotes intact.
- You can rename this file to reflect your own domain, or use any name you like, as long as it ends with ".py"
- The name of the file will determine the "Handler" field, later 
 
2. Obtain the Python "requests" library files
- Easy way: use the folders in the Lambda/Python folder  
- DIY: [AWS: lambda-python-how-to-create-deployment-package.html](https://docs.aws.amazon.com/lambda/latest/dg/lambda-python-how-to-create-deployment-package.html)  
-- For this project you just need to complete through Step 3 where you run this command: "pip install requests -t /path/to/project-dir"  
 
3. Place all of the source files into a folder:  
- main_wwwexamplecom.py
- all folders 
  
4. Highlight all of the files, right click and create a ZIP file containing only the Python file and two folders.  
-- Windows: Send to... Compressed (zipped) folder  
-- Mac: Compress Items  
- When you look in the resulting Zip file, you should see the Python file and folders at the top level of the Zip file. 
  
B. Prepare AWS Lambda service. (The IoT button must already be registered and set up).  

1. Log into your [AWS Console](https://aws.amazon.com/) and select a Region that supports AWS IoT and Lambda (e.g., N. Virginia, Ohio or Oregon)
- FWIW, I used N. Virginia
- For details see: [docs.aws.amazon.com/.../rande.html](https://docs.aws.amazon.com/general/latest/gr/rande.html)

2. Go to: Services... Compute... Lambda

3. AWS Lambda Dashboard
- "Create function" (orange button)

4. Choose "Author from scratch"
- Name: e.g., "iot-www-example-com" (you can't easily change this later so choose carefully)
- Runtime: Python 3.6
- Role: Choose an existing role
- Existing role: lambda_basic_execution
- "Create function" (orange button)

## Credits and Interesting Links
- Lambda code inspiration and an interesting IoT button project:  
  -- [Slack Messaging with the AWS IoT Button](https://medium.com/@cpiggott/slack-messaging-with-the-aws-iot-button-bd9978d0a98a)
- jQuery code for realtime updates. This was the basis for db.php  
  -- [Ajax Auto Refresh – Volume II](http://blog.codebusters.pl/en/entry/ajax-auto-refresh-volume-ii)
