Final project for the Web Technologies subject at FMI, Sofia University

##Документация:

TaskManagement, ProjectEstimation(Васил Василев), ExportProject, ProjectManagement(Владислав Стефанов),
UserManagement(Живко Георгиев)

Файлът, в който могат да се зададат параметрите на базата от данни се намира в project/configs/db.iml.
Файлът project/database/ProjectEstimation.sql трябва да бъде импортиран през phpMyAdmin. След това,
ако проектът се намира някъде в директорията htdocs, той може да бъде достъпен на
http://localhost/<projectDir>/project/frontend

###project/frontend

В project/frontend се намират файловете свързани с frontend частта на приложението.
В различните директории(login, projects, register, tasks, users) се намират html, css и javascript файлове,
свързани със съответните функционалности.

Началната страница на приложението е в index.html, index.css и index.js. В project/frontend директорията също така
се намира и export.js файла, чрез който базата данни се експортира в mm формат.

В assets се намира логото на приложението, а в common.css са изнесени части от css-а които ги имаме на всяка страница.

###project/backend

Директорията е разбита на три поддиректории. 

В директорията classes се намират класовете на системата - User, Project, Task, UsersProject. Те се явяват 
като data layer и във всеки има функции, които извличат, записват или трият информация от базата данни.

Директорията api е разбита на няколко поддиректории - positions, projects, tasks и users. Всеки един от файловете 
в тях се явява като някакъв endpoint и служи за обработка на данните, получени от фронтенда. Чрез Fetch API-то
на JavaScript изпращаме заявки именно към тези файлове. Те обработват заявката, някои си създават обекти, 
описани в директорията classes, чрез които извлчат/добавят/трият информация от базата данни.








