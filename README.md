Configure app locally

1.Download cirestapi project folder and place into your server directory like in www or htdocs or /var/www/html
2.Download .sql file and import into databse with batabase name restapi.
3.run application as localhost/cirestapi to start the application.


Process :
1.user will get registered
2.ques will be served randomly (ques will not repeat)
3.after all questions result wll be shown to user



To get the all users data with quiz details
'http://localhost/cirestapi/api/example/userdetails/'

To register user details 
'http://localhost/cirestapi/api/example/user/'

To get ques from quiz
'http://localhost/cirestapi/api/example/mcq/'

To get ques details like answers
http://localhost/cirestapi/api/example/mcq/id{quesid}