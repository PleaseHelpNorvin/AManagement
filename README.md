**AManagement**

still on login phase still buggy

i thought i finished the authentication on my Norvin-dev branch that i just realized it doesnt go iddle timeout when going other page that how I realized that I fucked up that project in order to not fuck up more I just made another branch with the globalized iddletimeout and session timeout hehe

**AManagement set up guide**

1. split a bash terminal in vscode
2. cd to path of AManagement-backend while in the other bash terminal cd to path of AManagement-frontend
3. in terminal of AManagement-backend run "composer update"
4. in terminal of AManagement-frontend run "npm install --legacy-peer-deps"
5. then "ng serve" for AManagement-frontend and "php artisan serve" for AManagement-backend
