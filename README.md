# ResPort

[MLH 2018 Hackathon Project @ NJIT]
Performance @ HackNJIT: 3rd place finish in entire competition

ResPort (RESearch PORTal) is an idea that started out as a hackathon project. With student and faculty encouragement, we created a refined alpha version. ResPort is a portal intended to be used by the students and faculty of New Jersey Institute of Technology (NJIT) to help bring awareness to research opportunities for students. Please look at "NJIT - Research Survey (Responses) - Form Responses 1.pdf" to view the data that we gathered across campus from students about their opinions on the importance of, and difficulty of finding research. The link to the login page is: http://njitresearch.com

Alpha Functionalities
---

Login Side:
 - Login by NJIT students only (We have functionality which ensures only NJIT students have access)
 - Login by NJIT faculty only (We have functionality which ensures only NJIT faculty have access. Additionally, we created two base users for testing purposes. Their login credentials are as follows: UCID: teacher     Password: pass    &    UCID: faculty     Password: pass)
 
Faculty Side: 
 - Create and edit profile
 - Create research opportunities
 - Browse through list of students that hearted those opportunities
 - See detailed student info, along with link to their resumé
 - Contact student
 - Accept or Reject student
 
Student Side: 
 - Create and edit profile
 - Browse through different research opportunities and filter by college name within NJIT
 - Heart or Un-heart oportunity
 - Upload Resumé
 - Browse through applied opportunities and see status of application
 - See detailed faculty information
 - Contact faculty

Technologies Used
---

Here is a list of technologies we used for creating ResPort:

Front End:
 - JavaScript, JQuery, and JSON
 - AJAX
 - PHP and cURL
 - HTML
 - CSS and Bootstrap

Back End:
 - PHP and cURL
 - MySQL database

**Team Members:**
---

- Chidanand Khode   (FRONT END)
 
- Kevin Aizic       (Security and AWS Maintenance)
 
- Connor Watson     (BACK END)
 
- Matthew Anderson  (BACK END)

What's Next?
---

We plan on raising awareness of the project to NJIT academia

Other Functionalities:
 - Currently, we don't support special characters in any inputs, such as ampersands, single and double commas, etc... We will work on this for the next release
 - We need to account for SQL Injections, which will also be addressed in the next release
 
