## SSH
  
SSH is a small and functional package that allow the commands execution over an SSH connection using phpseclib.  
  
## **Quick Installation**  
  
Begin by installing this package through Composer.  
  
You can run:
```
composer require paulvl/ssh
```
 
Or edit your project's composer.json file to require paulvl/ssh.  
```json
 "require": {
     ...
     "paulvl/ssh": "1	.*"
}
 ```
Next, update Composer from the Terminal:  
```
composer update
```

Once the package's installation completes, you can start using the library to connect to your servers and excutes comands:  
  
```php
/*
create and ssh instance passing:
- server IP
- username
- private key value
- ssh port number
*/
$ssh = new SHH\SSH(
	'your.own.server.ip',
	'username',
	'your-private-key',
	22);
```

## **SSH functions**  
  
### **canConnect** - Test the connection  
To evaluate if the host can be connected  with the given parameteres call the `canConnect` function:  
 ```php
$ssh->canConnect();
``` 
This will return `true` if the connection is successful.  

### **connect** - Open the connection to the host 
To open the connection with te given parameters call the `connect` function:  
 ```php
$ssh->connect();
``` 
Every timw you want to check the connection status
 
### **disconnect** - Close the connection to the host
To close the current open connection call the `disconnect` function:  
 ```php
$ssh->disconnect();
``` 


### **run** - Excecutes commands within the current connection
To execute commands on within the current open connection you should pass an array of commands as a parameter calling the `run` function:  
 ```php
$ssh->run(['command-1', 'command-2']);
``` 
You will get and array as result where you can see and unique execution id, the exit status of the executed command, the cli output as result and the duration in milliseconds.
```
[0] => Array
(
    [id] => 3e75a0e9-3de8-4c57-8a4b-a858af602089
    [status] => true
    [result] => command output message
    [duration] => 0.362
)
```

  
## **Contribute and share ;-)**  
If you like this little piece of code share it with you friends and feel free to contribute with any improvements.
