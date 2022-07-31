Project Goal:
The goal of this project is that biologists can upload their model and the corresponding simulation. Then, other people can look through the uploaded models and find a model that fits their needs. They should also be able to record video material and attach the video to the model data so it can be displayed on one specific model.

Project Structure:
Each of the following folders is separated by Section of the Front-end page topic: Admin, Edit, Contribute, Find and Misc. The PHP Router classes, the CSS files, the Twig Pages and the folders for images present on each site are named the same to improve structure.
Following are important informations about every folder.
The assets folder contains all the front-end assets and JS code, each in a separate folder. The images are placed in another folder because sometimes multiple pictures are needed on one Page and so this could increase structure of the project. 
The firewall is configured to have 3 new Roles: ROLE_Admin, ROLE_Contributer and ROLE_Member. Every user gets at least Member besides the ROLE_User that Symfony is giving. People that are referenced in at least one model get the ROLE_Contributer to get access to the editing models section. There is no way planed to upgrade a role to ROLE_Admin, other than via SQL directly or tools that handle direct SQL access. 
Inside the src folder are beside the structure by section also a sorting whether a class is responsible for Backend or Frontend. Because the only PHP Classes that is responsible for frontend functionality are the Controllers, the two folders are called Backend and Controller.
There is also a Misc folder responsible for everything that cannot be sorted to one specific section.
In the templates folder is also a Misc folder containing various templates that are needed by other Twig Pages, e.x. the general template all pages are extending from.

The Code classes have some specific method names, that appear in many of the Controller files. Methods containing Image in the name provide a route to allow browsers to access pictures inside the images folder. This will almost outsource to the BaseController Class because every image is loaded the same, just the Image path is needed. The route is always the standard route with /images and the image name added.
Then there is also the method getCSSForPage. This method is pretty similar to the Image methods except that CSS files can be access through this method and route. The route is always the standard route with a /CSS added. 


Project Progress:
Completed:
- all Frontend websites except JavaScript things.
- a working Logging in and registering system
- an Access Diened Handler
- Security and page hiding for unauthorized user s
- Imprint, About and Contact pages.

Implemented but not tested:
- Entites für Modelle und für Keywörter (still need migration)
- Getting models from the database
- Joining keywords, models and pivot table
-All classes that require implementation or testing are marked with it in a To-do.
- Filter models by name and by keywords 
- loading the next X models

To be implemented:
- All classes that exist but are not filled with functionality are marked so in a To-do
- Displaying loaded models
- Converting model data into JSON or CSV and let users download the file for further usage
- Contribution of a model incl. upgrading a Member to a Contributor for better discriminability and further security checks
- Listing of all contributed models
- for admins: list all models in the database
- deactivate own models
- for admins: deactivate all models
- Editing of models already contributed
- Editing of one's own profile and password
- for admins: Banning of profiles maybe based on IP-Adress
- for admins: Listing of all profiles in the database
- Video Upload with focus on Copyright based on Upload URL

For any further questions you can write me an E-mail either in German or in English to Joelkuehle@web.de