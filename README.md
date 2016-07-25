# captcha-validation-core-php

#There are two Basic Function in Captcha File Display and create_image function. The Display Function show Image and Create_image Function all the setting are

1. Set the lenght of no. of Chracter that show in captcha
2. color of text and size of box adjust
3. Create a table of captcha to store information that validate is valid captcha
4. set expiration time of captcha

#Table name is captcha

#Stucture of Captcha table are
  Field 	          Type 	              Null 	  Key 	Default 	Extra 	
  captcha_id 	      int(10)unsigned	NO 	    PRI 	NULL	    auto_increment
  captcha_time 	    int(10)unsigned	    NO 		        NULL	
  ip_address 	      varchar(16)	        NO 		          0	
  word 	            varchar(20)	        NO 	    MUL 	NULL	


