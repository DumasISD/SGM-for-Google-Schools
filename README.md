# SGM-for-Google-Schools
# Donation Button

[![](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SSHAPEDWFJ2MS)

School GAFE Manager, for allowing District admins to better manage GAFE

* We will be updating this over time so please follow
* The code for laravel is currently up on GITHUB however we have not published documentation on how to install.  Feel free to attempt this on your own if you like
*Moving Forward
 *We will convert this  code to a laravel plugin, to make the process easier to install
 *We will provide a functioning VM distributed with every core version of the source.
 
*I would love to have  others help develope this product and make it a huge success!!



## Laravel 5.1 and Boostrap 3


##Requirements

        PHP >= 5.5.9
        OpenSSL PHP Extension
        Mbstring PHP Extension
        Tokenizer PHP Extension
        SQL server(for example MySQL)
        Composer
        Node JS

## Google Setup
In your google account, create a service account.  This app will make use of the service account to make API calls to your google account.  Download the .p12

## Setup Steps
        Create the .env file in the root dir /
        Create these directories if they do not exist
                /storage
                        /app
                        /debugbar
                        /logs
                        /framework 
                                /cache
                                /sessions
                                /views
        Make sure the apache user can write to the files in /storage
        Initialize the database with the file /sql/schema.sql
         
        Update the .env file with the information from your google account.
                Google Domain Name
                Google Admin User for the Google Domain
                Google service account name
                Path to the .p12 file


## sample .env file
	APP_ENV=dev
	APP_DEBUG=true
	APP_KEY=someuniquekey

	DB_HOST=localhost
	DB_DATABASE=db
	DB_USERNAME=user
	DB_PASSWORD=pw

	ADMIN_EMAIL=you@domain.com
	DEV_EMAIL=you@domain.com

	google_client_id=xxx.apps.googleusercontent.com
	google_domain_name=domainname.com
	google_admin_user=admin@domainname.com
	google_service_account_name=xxx@yyy.iam.gserviceaccount.com

	; the Web app uses this one
	google_service_account_key_file=/etc/domainname.p12
	; the Cron file uses this one
	google_service_account_key_file2=/share/sites/dumas/etc/domainname.p12
