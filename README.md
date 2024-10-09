**AManagement**

still on login phase still buggy

i thought i finished the authentication on my Norvin-dev branch that i just realized it doesnt go iddle timeout when going other page that how I realized that I fucked up that project in order to not fuck up more I just made another branch with the globalized iddletimeout and session timeout hehe

**10/08/24**
i just added my first phase of mobile application for tenants though its still skeleton eheee

**10/09/24**
finally ive completed the qrcode page design wise although its still lacking function for print and i want to encapsulate the url i want to put that url logic in backend

**AManagement set up guide**

1. split a bash terminal in vscode
2. cd to path of AManagement-backend while in the other bash terminal cd to path of AManagement-frontend
3. in terminal of AManagement-backend run "composer update"
4. in terminal of AManagement-frontend run "npm install --legacy-peer-deps"
5. then "ng serve" for AManagement-frontend and "php artisan serve" for AManagement-backend

**Amanagement mobile set up guide**

1. open project in another visual studio
2. check pubspec.yaml for updating independencies
3. make sure you path is align with the amanagement_mobile project 
4. Upgrade Dependencies: If you want to upgrade all your dependencies to their latest compatible versions, use: flutter pub upgrade
5. type command "flutter pub get"
6. for running the mobile app : "flutter run"
7. choose web for now if dili kaya sa imo pc ang mobile simulator hahaha
