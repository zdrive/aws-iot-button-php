import requests

def handler(event, context):
    PostingURL = 'http://www.example.com/iot_button_click.php'
    headerJSON = {'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36'}

    r = requests.post(PostingURL,headers=headerJSON,data={"clickType": event['clickType'],"serialNumber": event['serialNumber'],"batteryVoltage" : event['batteryVoltage'] })
    print (r.text)
    
