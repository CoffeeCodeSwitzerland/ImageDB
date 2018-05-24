# XAMPP mail setup
To make the email function working apply following chagnes to your xampp-server.
After you adopted the changes please restart the server

## php.ini
Go to the php.ini file, uncommit the property "send_mail" and set the path which points to Xampp\sendmail\sendmail.exe
```
[mail function]
sendmail_paht="D:\Xampp\sendmail\sendmail.exe -t -i"
```

## sendmail.ini
Apply the followin changes in the sendmail.ini file
```
smtp_server=smtp.gmail.com
smtp_port=465
smtp_ssl=auto
default_domain=gmail.com
auth_username=imagedb.coffeecode@gmail.com
auth_password={{here woule be the account password}}
hostname=gmail.com
```
