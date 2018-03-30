# AWS IoT Button To PHP 
Rev 1.0 (March 2018)
  
## AMAZON AWS LAMBDA FILES

### Test Event JSON files
 
- TestEventLiveSNsingle.json
- TestEventLiveSNdouble.json
- TestEventLiveSNlong.json  
 
Use these files to create test events that simulate AWS IoT button clicks, so you can try your Lambda function before the button is linked to it.  
 
1. Using any text editor, open a JSON file  
  -- (e.g., "TestEventLiveSNsingle.JSON") 
  
2. Replace "IoTbtnSerialNum" with your AWS IoT button serial number  
  
3. Select All... then Copy the JSON text  
  
4. In the AWS Lambda function configuration page, create a test event:  
  -- Use the dropdown menu near the "Test" button (top right portion of page)  
  -- Choose "Configure test events"  
  -- Select "Create a new test event"  
  -- Event name: same as file name (e.g., "TestEventLiveSNsingle")  
  -- In the box, paste the JSON you copied in the previous step (delete and replace any JSON that might already be there)  
  -- Click the "Create" button near the bottom  
  
5. Run the test event:  
  -- Use the dropdown menu to select the test you just created  
  -- Click the "Test" button  
  -- Meanwhile, also watch your PHP web page in another window  
  
6. Check the results:  
  -- PHP Web page should report the click type and date/time  
  -- Lambda Execution Result (near bottom) should be "null"  
  
7. If it fails, look for clues:  
  -- After you run a test, the Execution Result pane will appear below the code. If there are errors, you might find messages here

