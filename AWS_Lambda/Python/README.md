# AWS IoT Button To PHP 
Rev 1.0 (March 2018)
  
## AMAZON AWS LAMBDA FILES

### Python Files
 
- main_wwwexamplecom.py
- Python folders (10 total):  
  --  certifi & dist-info  
  --  chardet & dist-info  
  --  idna & dist-info  
  --  requests & dist-info  
  --  urlib3 & dist-info  
 
### How to Use  

1. Update the Python file using a text editor:  
  -- AWS_Lambda/Python/main_wwwexamplecom.py  
  -- Change PostingURL, but make sure to keep the quotes intact  
  -- You can rename this file to reflect your own domain, or use any name you like, as long as it ends with ".py"  
  -- [Side note about the User-Agent field: Your web server might reject an HTTP request that does not include a User Agent. For this code I just copied the first one from a list I found, and it works. But you can change it to a different User Agent if desired]
  
2. Obtain the Python "requests" library files  
  -- Easy way: use the folders in AWS_Lambda/Python  
  -- DIY: [AWS: lambda-python-how-to-create-deployment-package.html](https://docs.aws.amazon.com/lambda/latest/dg/lambda-python-how-to-create-deployment-package.html)  
  ---- For this project you just need to complete through Step 3 where you run this command:  
  ---- `pip install requests -t /path/to/project-dir`  
  ---- Requires Python and pip:  
  ---- https://www.python.org/downloads/  
  
3. Place all of the source files into a folder:  
  -- main_wwwexamplecom.py  
  -- all ten Python folders  
  
4. Highlight all of the files, right click and create a ZIP file containing only the Python file and ten folders  
  -- Windows: Send to... Compressed (zipped) folder  
  -- Mac: Compress Items  
  -- When you look in the resulting Zip file, you should see the Python file and folders at the top level of the Zip file. 
  
5. Save the ZIP file for use in the AWS Lambda Function Configuration page  
  
