
sudo find /etc/apache2/sites-enabled -name "*.conf" -exec sed -i 's/<VirtualHost *:443>/<VirtualHost *:443>\n\rProtocols h2 http\/1.1/g' {} \;


# An analytic website for golf at the moment

Use these links, previous links were for view only

Design Doc:
https://docs.google.com/document/d/1ofW1cjBhymq0cPrWwI54o_-AeUkVXqFdmBtghaqxjKQ/edit?usp=sharing

## Tests 
https://github.com/php-webdriver/php-webdriver

Ensure you are using the latest version of chromedriver outlined above 

At the end of Sprint 1, a user must be able to:
    
    3.1  The athletes component must be logged into by entering a username and password.
    
    3.1.8  Athletes will be able to instant message other athletes and coaches based on Privacy Settings.
    3.1.9  Athletes will be able to create a new team.
    3.1.11  The athletes component of the system will allow users to view their statistics.
    3.1.12  The athletes component will allow new courses to be added.
    3.2     Coaches must be logged into by entering a username and password.
    3.2.2   Coaches will be able to alert managed athletes.
    3.2.21   A notification can be sent for schedule changes
    3.2.22   A notification can be sent for new messages
    3.2.23   A notification can be sent for new tournament updates
    
    
    At the end of Sprint 2, a user must be able to:
    3.1.1  Athletes can select, edit, and post a score card.
    3.1.2  Athletes can give comments about a round played and a forum style submission.
    3.1.3  Athletes can view and register for a  tournament scheduled in a particular area.
    3.1.4  Athletes can search and follow other teams and users for a personalized search experience.
    3.1.5  Athletes may comment on others rounds based on Privacy Settings.
    3.1.6  Athletes may register new events in any callander view.
    3.1.7  The athlete component will have the ability to create a calendar.
    3.1.10  Athletes will be able to remove themselves from already joined teams.
    3.2.1  Coaches will be able to see the online status of team members. 
    3.2.3  Coaches can edit athletes sore information.
    3.2.4  Coaches can register sub-teams for tournaments.
    3.2.3  Coaches can search for team, users, and courses.
    
    
    At the end of Sprint 3, a user must be able to:
    3.3  Recruiters component must be logged into by entering a username and password.
    3.3.1  Recruiters are required to pay a service fee for entry 
    3.4  The administration component must be logged into through a username and password.
    3.4.1  The administration component can display a sales reports and a report of the number of users online at a given time.
    3.4.2  During beta 1 the administration can impersonate all users to gain insights on application performance.
    3.4.3  The administration can edit client information for data  integrity.
    3.4.4  The administration will be able to perform all actions without premium limitations. 
    4.1  The system will run online through Chrome, Safari, and Firefox
    



Requirements doc:
https://docs.google.com/document/d/1u0QLjAoveMcrR1C0fKOROKieLMmQ6dUGz0z_ehXplyo/edit?usp=sharing


Sprint 0 doc (bs):
https://docs.google.com/document/d/1AQ5V_wPshdIJoDRaZUQzg3OgnfeOexFQzvv7eAzwFjA/edit?usp=sharing
 

Admin X3


 
 carbonphp.com
 
 
php -S localhost:80 index.php
"C:\xampp\php\php.exe" -S localhost:80 index.php


 php index.php rest -s StatsCoach -p 'Huskies!99' -json 
 
    static $count;
 
         null === $count and $count = 0;
 
         if (++$count > 1 ){
             sortDump('started app twice');
         };
         
         
         
  
http://chromedriver.chromium.org/downloads

downloaded the driver for chrome. that downloaded it to the desktop, and then we had to move it into the path 

    brew cask install chromedriver