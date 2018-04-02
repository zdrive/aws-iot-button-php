# AWS IoT Button To PHP 
Rev 1.0 (March 2018)
  
## AMAZON AWS LAMBDA FILES

### Test Event JSON files
 
- TestEventLiveSNsingle.json
- TestEventLiveSNdouble.json
- TestEventLiveSNlong.json  
 
Use these files to create test events that simulate AWS IoT button clicks, so you can try your Lambda function before the button is linked to it.  
 
### How to Use  

1. Using a text editor, open a file such as "TestEventLiveSNsingle.json"  
  -- Change "IoTbtnSerialNum" to your button's S/N  
  -- Select all text in the JSON file, and copy it  
  
2. Back in AWS Lambda function configuration page, create a test event:  
  -- Use the dropdown menu near the "Test" button (top right)  
  -- Choose "Configure test events"  
  -- Select "Create a new test event"  
  -- In the box, delete any JSON that might already be there  
  -- In the box, paste the JSON you copied in the previous step (delete and replace any JSON that might already be there)  
  -- Event name (above the box): same as file name, e.g., "TestEventLiveSNsingle"  
 -- Click the "Create" button near the bottom  
  
3. Run the test event:  
  -- Use the dropdown menu to select the test you just created  
  -- Click the "Test" button  
  -- Meanwhile, also watch your PHP web page in another window  
  
4. Check the results:  
  -- PHP Web page should report the click type and date/time  
  -- Lambda Execution Result (near bottom) should be "null"  
  
5. If it fails, look for clues:  
  -- After you run a test, the Execution Result pane will appear below the code. If there are errors, you might find messages here    
  -- A fail at this point also could be due to hosting restrictions (check your web server logs for more clues)  

