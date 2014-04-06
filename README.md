# Callbot

A stand-alone PHP package for testing telecom dial-in apps. Callbot provides a simple CLI interface for making batches of test calls. It is configured to use Twilio out of the box, but can be configured to use any similar service.

## Installation

1. `$ git clone git@gitlab.indatus.com:jarstingstall/callbot.git`
2. `$ cd callbot && composer install`

## Make An Outgoing Call Using Twilio and Amazon S3

### Twilio Setup

1. Signup for a free [Twilio](https://www.twilio.com/try-twilio) account.
2. Rename `config.example.php` to `config.php` and enter your Account SID and Auth Token credentials.
3. Replace the `'defaultFrom'` phone number with your Twilio phone number.

### Amazon S3 Setup

Twilio requires an XML script located at a public URL for each call it makes. The script at this URL tells Twilio what to do once the call is answered. Callbot is configured to compile your XML scripts and push them up to an Amazon S3 bucket out of the box. Signing up for Amazon S3 is free and easy:

1. Signup for a free [Amazon S3](https://console.aws.amazon.com/s3/) account.
2. Create a bucket and give Everyone "View" permissions in the S3 console.
3. Open `config.php` and enter your Access Key, Secret Key, and Bucket Name.

### Make The Call

We're now ready for Callbot to place the call for us. Run the `callbot` executable, passing in the `call` command. To place a single call, the `call` command requires two arguments:

1. The phone number to call
2. The path to the call script

```
$ ./callbot call 5551234567 call-scripts/test-script.xml
```

The default call script is located in the `call-scripts` directory and contains TwiML (Twilio Markup Language) that tells Twilio how to handle the outgoing call. Check out the Twilio docs for more info on [TwiML](https://www.twilio.com/docs/api/twiml).

