What this project is:
A streaming website for movies and tv series.

What it contains (so far):
An admin page to perform CRUD operations, a search page, user authentication, simple links to popular and new movies/series/videos and a page where users can comment on a video. 

Highly probable changes that will be finished until exam:
Changing all queries to prepared statements on pages with input. - done

Generaly what each file has:
index.php - shows 3 by 3 videos from table and contain links to all other pages except admin
          - has a functional mobile menu 

movies.php - shows 3 by 3 movie thumbnails that redirect to player.php
           - contain links to all other pages except admin
           - has a functional mobile menu
           - has more more columns than tv_series in the database but its otherwise similar to it
           
tv_series.php - shows 3 by 3 series thumbnails that redirect to player.php
              - contain links to all other pages except admin
              - has a functional mobile menu 

login.php - contains loging in page and a link to signup to create new accounts
          - everytime you logout it redirects here
          - only requires username and password
          - uses cookies to store user credentials if user selects remember me option

logout.php - simple logout
           - redirects to login.php  

signup.php - create new acount
           - redirects to index.php upon successful account creation

admin.php - contains 3 content administration table for featured_videos, movies and tv_series
          - can modify or delete content (check modify_featured_videos.php, modify_movie.php, modify_tv_series.php and delete.php)
          - contains a button to add new content (redirects to add.php)
          - can only be accessed by manually inputting the url

add.php - depending on the type of content you want to add it shows different input fields 
        - uses javascript to hide what isnt used (check last function in script.js)
        - contains a button that redirects to admin.php

modify_featured_videos.php - modify_movie.php - modify_tv_series.php --- modify content from each table separately
                                                                     --- contain a button to admin.php

delete.php - takes item id from admin.php and checks if its a video,movie or tv series and deletes it

search.php - searches from movies and tv series and finds the closest match
           - displays title,description and genre
           - if search input is empty it displays everything from the tables 
           - has a functional mobile menu

player.php - this is where thumbnails from movies and tv series redirect to (they all redirect to the same video)
           - can comment on the video if you are logged in,displaying the username of who commented and the time it happened as well
           - has a functional mobile menu
           - if a user account is deleted so are his comments

script.js - mostly hides mobile menu if the user is on desktop and vice versa
          - last function is used by add.php to hide certain inputs depending on what table input is used

css - all css files should be pretty self explanatory 

Github link in case files are corrupted somehow:
https://github.com/Paul-A-V/videos4free

tldr:
streaming website 