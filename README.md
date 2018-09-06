incloud

Time spent:
-20 minutes to design the database table as per the requirements, and generate 
its entity
-30 minutes to build the controller
-30 minutes to build the repository
-Roughly an hour to create the form page using the Form generator, it took some 
documentation digging to find how to make the form with the fields I wanted.
-45 minutes to get the custom JavaScript communicate properly with the 
StoryController's add function.
-4 hours building the list page, most of which was taken by attempting to get the
datepicker working, got it down after getting the webpack-jquery-ui repository and
the proper import statements.
-2 and a half hours building and debugging the fetch() method in the controller,
at one point considered redoing part of the job using a custom function in the 
StoryRepository class

What I liked:
-This exercise was a learning experience, in which I could test my previous experience
with CakePHP and adapt them to Symfony
-The Twig templates are very friendly, and similar to those of the Django framework
-The ability to determine routes by defining them on top of the controller functions 
as comments is a great upgrade from having to define them in a single separate file

What I didn't like:
-The long search so I could get the proper repo and import instructions to get 
the datepickers work.
-When building the DQL query for the fetch() method, at first I wanted to set parameters
to determine which field and whether it would be ascending or descending would 
order the results, but Doctrine wouldn't allow that.

What I would have done differently if I had more time:
-I would have created a custom method in the StoryRepository class which would have taken
some lines of code off the controller
-I would have gotten Font Awesome to work properly in the installation so the 
filter buttons could have intuitive icons instead of UTF error characters
-I would have made the form more visually appealing, making use of Bootstrap as I managed
with the list page.
-I would have added a JavaScript global boolean variable to determine if the filters 
were changed by the user, and have that affect how the numerator and denominator values 
and the controller fetch() method handle the pagination.

I'm satisfied mostly with the form and how the list builds queries based on filters. 
What can definitely could use an improvement is how the pagination is handled, specially when
filter data is changed.

When running the project, these are the URLs to check:
-http://127.0.0.1:8000/form for the form
-http://127.0.0.1:8000 for the list