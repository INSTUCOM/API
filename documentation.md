#Documentaton for Instucom API
#Author: Abdullahi Innocent Adedayo
#Created: tuesday 4th, April 2017. 15:17


API is accessed through the use of header requests. Data to be received through the API is contained in the response received from the header requests.
Both GET and POST methods are used for receiving data in their appropriate senarios which would be explained later on.
The API deals with everything that has to do with the server-side of Instucom. connection to the database and syncing the webapp with the mobile app.

For clearity purposes, this documentation would be split into different parts based on the API common among the students, the lecturers and the mentors and the ones that differ among them.

#API COMMON TO ALL THE CATEGORIES ( STUDENTS, LECTURERS, AND MENTORS )
Note: 1.    All request made must attach a **private_token** variable to it consisting of the user's token generated at point of registration.
      2.    Options for all request must be passed through a json array called **options** through the GET method. Note: the **private_token** is not part of the json array.
      3.    


        THE REGISTRATION
The registration for all users takes a similar header request with only variation in the json array "options".
Samples for the different types of user is shown below
for student: http://aboohamzah.com/registerController?public_token=123&options={"type":"student","name":"","program":"","level":"","department":"","email":"","password":"","matric_no":""}

        THE LOGIN
The registration for all users takes a similar header request with only variation in the json array "options".
for student: http://aboohamzah.com/signinController?public_token=123&options={"email":"","password":""}


        THE NEWS
Only the news of master category inner is common to all.
The header request for for such consists of a master category called "master_cat", an optional sub category called "sub_cat" and also the user's id called "user_id".
All these options are to be contained in the json array "options".
A sample to get the list of all the news happening outside the school
header request will be of the form: "http://localhost/API/newslist?public_token=123&options={"master_cat":"inner","sub_cat":"","user_id":"2"}"
Note: The master category "inner" is common to all
if u are getting more content make sure u add the "last" json object to the array indicating the last id collected.



 
