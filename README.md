# task_manager_in_symfony
A simple symfony 4.4 project to manage task

# How to Install
1) cd into the project root
2) composer install
3) bin/console doctrine:migrations:migrate
4) symfony server:start (open the browser and type the ip e.g. http://127.0.0.1:8000)

# Available modules
1) Create task
2) Archive task
3) Delete task
4) View upcoming task
5) View archived task

# Future Update
1) Edit task
2) Check Task starting date is greater than now and task finishing date is not older than task starting date
3) Sending email reminder for any upcoming task (need to modify FE to ask user user when he/she wants the reminder to be sent)
4) Write unit test and API test

