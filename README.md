# AWS IoT Button To PHP 
Rev 0.9 (March 2018)
  
## DESCRIPTION
Uses a Python script for AWS Lambda to send click data from an Amazon AWS IoT button to a PHP script via HTTP. Button click data is stored in MySQL, and displayed on a web page. Using jQuery, the display is updated without refreshing.

- IoT_Button+WiFi --> AWS_Lambda --> **_PHP/MySQL/HTML_** <-- jQuery

See [iot-button-integration-overview.jpg](iot-button-integration-overview.jpg) for an illustration.
  
## QUICK START  
(See requirements and detailed instructions below)  

### PHP/MySQL
1. Make an empty MySQL database and a read/write user 
2. Open mysql.sql (using a common text editor such as WordPad)
3. Select all and copy, then use it to run a query on the empty database (using a DB tool such as phpMyAdmin)
4. Open MySQL table `t_iotsettings` and update field `IS_AWSbuttonSN` to your IoT button serial number
5. Using a text editor, open file "_settings.php" and update:  
  -- Host, Login, Password, DB Name, IoT Button Serial Number
6. Copy PHP files to your site (e.g., upload via FTP)
7. Browse index.php to test - should be no errors, with message:  
  -- "The AWS IoT Button has not been clicked today."

### Amazon AWS
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
  -- change "IoTbtnSerialNum" to your button's S/N 
9. Run the test event, while also watching your PHP web page
10. Check the results:  
  -- PHP Web page should report the click type and date/time  
  -- Lambda Execution Result (near bottom) should be "null"  
  -- If it fails, look for clues in the Execution Result  
  -- A fail here could be due to hosting restrictions (check web server logs for more clues)    
11. When tests are successful, add your IoT button as a trigger:  
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
The heart of this system is Amazon Web services. There you can register your IoT button, and upload the Python code that responds to a button click  
  -- This demo can not be performed without an AWS account  
  -- If you need to set up an AWS account, then be advised that the process includes account verification by Amazon, so it takes time to complete the set up  
  -- URL: https://aws.amazon.com/  
  
2. AWS IoT Button (or simulator)  
This is the physical device that will initiate the request. Before you can do anything with it, you'll need to register it in your AWS account, set it up with your WiFi and download security keys from your AWS account, then upload the keys to your button  
  -- If you have a button, and you've already set it up and installed the security keys, then you don't need to do it again  
  -- If you have a button, but you have not set it up, then stop here and go do that. See "Getting Started with AWS IoT" at https://docs.aws.amazon.com/iot/latest/developerguide/iot-gs.html  
  -- If you *do not* have a button, there are ways to simulate one. But you've got a button, don't you? Otherwise you probably wouldn't be looking at this code!  
  
3. Website that supports PHP and MySQL (any web server O/S)  
  -- NOTICE: The script polls every three seconds, so it can cause a spike in your web stats (i.e., an extra 20 pages per minute while the page is open). For testing, run this at a site where stats are not important.
  
## DETAILED INSTRUCTIONS  
How to compile and use    

### Setup PHP / MySQL Website

1. Make an empty MySQL database that you can access from your PHP site, and a user with read/write access to the database. Save the following info for later:  
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

6. Using a text editor, open "iot_button_click.php" and uncomment the line that respresents your time zone  
  -- This step is optional, but important to get accurate results     

7. Using a text editor, open "index.php" and update the interval:  
  -- Line 35: `setInterval(check,3000);`  
  -- Interval is milleseconds, so 3000 = 3 seconds  
  -- This step is optional  
  -- Three seconds (3000) is fast enough for testing purposes  
  -- Use a longer interval (e.g., 30000 for 30 seconds) to reduce the script's footprint in your website stats  
  -- Longer interval means you have to wait longer for click data to appear on your website
  -- Leave it at 3000 if you don't care about the impact on stats  

8. Copy PHP files to your site (e.g., upload via FTP)  
-- That's an old version of jQuery, so update it later  

9. Run a test by browsing index.php. The result should be: "The AWS IoT Button has not been clicked today."  
  -- If you get an error, try uncommenting the PHP error reporting code near the top of index.php:  
  -- `ini_set('display_errors', 1); error_reporting(E_ALL);`  

### Python File Preparation 

1. Update the Python file using a text editor: main_wwwexamplecom.py  
  -- change PostingURL, but make sure to keep the quotes intact  
  -- You can rename this file to reflect your own domain, or use any name you like, as long as it ends with ".py"  
  -- [Side note about the User-Agent field: Your web server might reject an HTTP request that does not include a User Agent. For this code I just copied the first one from a list I found, and it works. But you can change it another User Agent if desired]
  
2. Obtain the Python "requests" library files  
  -- Easy way: use the folders in AWS_Lambda/Python  
  -- DIY: [AWS: lambda-python-how-to-create-deployment-package.html](https://docs.aws.amazon.com/lambda/latest/dg/lambda-python-how-to-create-deployment-package.html)  
  ---- For this project you just need to complete through Step 3 where you run this command: "pip install requests -t /path/to/project-dir"  
  ---- Requires Python and pip: https://www.python.org/downloads/  
  
3. Place all of the source files into a folder:  
  -- main_wwwexamplecom.py  
  -- all folders  
  
4. Highlight all of the files, right click and create a ZIP file containing only the Python file and two folders  
  -- Windows: Send to... Compressed (zipped) folder  
  -- Mac: Compress Items  
  -- When you look in the resulting Zip file, you should see the Python file and folders at the top level of the Zip file. 

5. Save the ZIP file for use in the next step  
  
### Amazon AWS Console  
Log into your [AWS Console](https://aws.amazon.com/) and select a Region that supports AWS IoT and Lambda (e.g., N. Virginia, Ohio or Oregon)  
  -- FWIW, I used N. Virginia  
  -- For details see: [docs.aws.amazon.com/.../rande.html](https://docs.aws.amazon.com/general/latest/gr/rande.html)  

A. Create an IAM execution role for Lambda Basic Execution 
(you can use an exisiting Lambda Basic Execution role, if present)  
  
1. Go to: Services... Security, Identity & Compliance... IAM  
  
2. Select "Roles" from the left menu  
  
3. Click the "Create role" button  
  
4. Leave the "AWS service" highlighted
  
5. Click on the word "Lambda" so that the "Next: Permissions" button is highlighted, then click the "Next: Permissions" button  
  
6. Type "lambda" in the search box, then click on "AWSLambdaBasicExecutionRole" when it appears  
  
7. Click the "Next: Review" button  
  
8. Review  
  -- Give it a name, such as "lambda_basic_execution"  
  -- Change the description if desired  
  -- Click the "Create role" button  
  
9. Voila! You now have a Lambda Basic Execution role that you can also use in other projects. You'll need this in the next step  
  
B. Prepare AWS Lambda function. 
  
1. In the AWS Console, go to Lambda:  
  -- Services... Compute... Lambda  
  
2. AWS Lambda Dashboard  
  -- "Create function" (orange button)  
  
3. Choose "Author from scratch"  
  -- Name: e.g., "iot-www-example-com" (you can't easily change this later so choose carefully)  
  -- Runtime: Python 3.6  
  -- Role: Choose an existing role  
  -- Existing role: lambda_basic_execution (created above)  
  -- "Create function" (orange button)  
  
4. Go to section: "Function code" which is directly below the function Designer  
  -- Code entry type: Upload a Zip file  
  -- Use the Zip from step 3 above  
  -- Runtime: Python 3.6
  -- Handler: main_wwwexamplecom.handler  
  ---- If you changed the Python file name, the first part of the handler needs to match. So if your file is "sample.py" then the handler will be "sample.handler"  
  -- Click the Save button  

5. Using a text editor, open a file such as "TestEventLiveSNsingle.json"  
  -- Change "IoTbtnSerialNum" to your button's S/N  
  -- Select all text in the JSON file, and copy it  
  
6. Back in AWS Lambda function configuration page, create a test event:  
  -- Use the dropdown menu near the "Test" button (top right portion of page)  
  -- Choose "Configure test events"  
  -- Select "Create a new test event"  
  -- Event name: same as file name, e.g., "TestEventLiveSNsingle"  
  -- In the box, paste the JSON you copied in the previous step  
  -- Click the "Create" button near the bottom  
  
7. Run the test event:  
  -- Use the dropdown menu to select the test you just created  
  -- Click the "Test" button  
  -- Meanwhile, also watch your PHP web page in another window  
  
8. Check the results:  
  -- PHP Web page should report the click type and date/time  
  -- Lambda Execution Result (near bottom) should be "null"  
  
9. If it fails, look for clues:  
  -- After you run a test, the Execution Result pane will appear below the code. If there are errors, you might find messages here    
  -- A fail at this point also could be due to hosting restrictions (check your web server logs for more clues)  
  
10. When tests are successful, continue...
  
C. Attach and test the AWS IoT button  
  
0. NOTE: The IoT button must already be registered and set up on your WiFi to proceed with the following steps. Instructions to set up your button can be found here:  
  -- https://docs.aws.amazon.com/iot/latest/developerguide/iot-gs.html  
  -- You only have to do this once. If your button is already set up on WiFi and connected to AWS, then simply continue.  
  
1. Add your IoT button as a trigger:  
  -- From the "Add triggers" panel on the left side  
  -- Click "AWS IoT"  
  -- Scroll down to the "Configure triggers" section  
  -- Custom IoT Rule... Rule... Pick an existing Rule  
  -- Choose your IoT button  
  -- Click the Save button  
  
2. The moment of truth... Click your IoT button, while watching the PHP web page, and check the results:  
  -- PHP Web page should report the click type and date/time  
  -- View click data in database table `t_iotbuttontracker`  
  
3. A fail here could be due to IoT button setup  
  -- Click for the Lambda function's "Monitoring" tab (near the top, left side, next to "Configuration")  
  -- Look at Invocations count in the first box  
  -- This report is in local time; aggregated by the hour
  -- Click "Jump to Logs" in the upper right portion of the box  
  -- Sort order is oldest at top, so scroll down for the most recent clicks  
  -- This report is in UTC time  
  -- The logs are not instantly updated    
  -- Click the Refresh icon (top right) after 30-60 seconds  
  -- Also keep an eye on the time filter in the upper right, to make sure it covers the current time frame  
  
### That's All Folks!
  
Please report problems, and feel free to make suggestions  
  
  
  
## Credits and Interesting Links
- Lambda code inspiration and an interesting IoT button project:  
  -- [Slack Messaging with the AWS IoT Button](https://medium.com/@cpiggott/slack-messaging-with-the-aws-iot-button-bd9978d0a98a)

- jQuery code for realtime updates. This was the basis for db.php  
  -- [Ajax Auto Refresh - Volume II](http://blog.codebusters.pl/en/entry/ajax-auto-refresh-volume-ii)
 