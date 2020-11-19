# PHP Blog

## How to Install

### Run the application locally
If you do not have XAMP installed install if from here: https://www.apachefriends.org/index.html.

1. Clone or download this repository. 
2. Set the Apache watch folder to the relative path to the src folder in the repo as followong:
    * Press config on the apache watch and choose the first choice.
    * Change the relative path in DocumentRoot and <\Directory to the relative path to the src folder.
    * For example mine is: C:\Users\perni\1dv610\assignment-3\src
3. Save and press start on the Apache watch and it will show what port to go to in your browser.

I didn't create a database for this assignment and instead have 3 folders outside the root of the repository to save the blogposts, userCredentials and the cookieInformation.
This is of course not ideal and would be something to change if I would take this assignment further.

If you want to try the application locally you have to add these folders outside the root directory:
* data
* cookieDb
* allBlogPosts

## How to test

To test the programs log in functions you can use the automated test here: 
http://csquiz.lnu.se:25083/index.php
LNU username: pg222jx
Web url: https://1dv610assignment2.000webhostapp.com/

You can also test it with these test cases:
https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/TestCases.md

For the extra requirements for this assignment I have addes use cases and test cases below.
To test these I would suggest you do that from the public server because the users and their posts has already been added to the database from there. 

## Use Cases for the additional reguirements

### UC1 public  posts

#### PreconditionNone

Main scenario

    1. User navigates to page
    2. System shows all public posts that all users has created

Alternate Scenario: There are no public posts

    2.1. System shows no posts.
    
### UC2 private posts

#### Precondition
User has navigated to page

Main scenario

    1. The user logs in with the right credentials
    2. System shows all posts the user has created

Alternate Scenario: User has no saved posts

    2.1. System shows no posts.

### UC3 Create new private post

#### Precondition
User has logged in with the right credentials

Main scenario

    1. The user clicks on create new post button
    2. System asks for title and message
    3. User provides title and message and clicks save
    4. System saves the post and updates the list of posts

    Alternate Scenario: User does not enter title or message

    3.1. System does noting
    4.2. Step 2 in main scenario

    Alternate Scenario: Post could not be saved

    4.1. System presents an error message

### UC4 Add new public post

#### Precondition

Main scenario

    1. Starts when a logged in user clicks on create new post button.
    2. System asks for title, message and username
    3. User provides title, message, username and checks box to show post on logged out page
    4. System saves the post, presents that the shared post succeeded and shows post on logget out page

Alternate Scenario: Post could not be saved

    4.1 System presents an error message
    4.2 Step 2 in main scenario

### UC5 Delete post

#### Precondition

Main scenario

    1. Starts when user is logged in
    2. User clicks delete button next to post
    3. System deletes the post

Alternate Scenario: Post could not be deleted

    4.1 System presents an error message


## Test Cases for the additional reguirements

### Test case 1 - Successfully navigating to page

    1. Enter https://1dv610assignment2.000webhostapp.com/ in the browser
    2. System shows a login form and present this output together with potential public posts:
               "These are the public haikus:
                If you want to create your own haikus, please register as a member."

- [x] Success
- [ ] Fail

### Test case 2.1 - Sucessfully shows users private posts

    1. Enter Admin as usernamme and Password as password and log in.
    2. System shows a Create Post button, two delete buttons and this output:
               "These are your private haikus:
    
                Admin

                This is a public post

                En publik haiku
                Skriven av postens titel
                Välkommen och läs

                
                Admin

                This is a private post

                En privat haiku
                Skriven av postens titel
                Läses endast här"

- [x] Success
- [ ] Fail

### Test case 2.2 - Sucessfully shows next users private posts

    1. Log in with Admin and Password, click logout button and then login with Pernilla and Password.
    2. System shows a Create new post button, two delete buttons and this output:
               "These are your private haikus:
    
                Pernilla

                This is a private post

                En privat haiku
                Skriven av postens titel
                Läses endast här

                
                Pernilla

                This is a public post

                En publik haiku
                Skriven av postens titel
                Välkommen och läs"

- [x] Success
- [ ] Fail

### Test case 3.1 - Successfully show create post page

    1. Log in with Admin and Password, click Create new post button.
    2. System shows the rules to create a haiku, a form and Admin should show in the author input as a readonly.

- [x] Success
- [ ] Fail

### Test case 3.2 - Create post without title should fail

    1. After doing test case 3.1, write Public in the blog post input and click the save button.
    2. System says that title is required.

- [ ] Success
- [x] Fail

Comment: System does now show a message but the post is not saved 

### Test case 3.3 - Create post without Blog Post should fail

    1. After doing test case 3.1, write Test in the Title input and click the save button.
    2. System says that blog post is required.

- [ ] Success
- [x] Fail

Comment: System does now show a message but the post is not saved 

### Test case 3.4 - Successfully create a new private post

    1. Log in with Admin and Password, click Create new post button.
    2. System shows a form to create a post.
    3. Write Test inte the title input, Private in the Blog Post input and click Save.
    4. System redirects to main page and shows the new post and that the new post is private:

        "Test

        This is a private post

        Private"


- [x] Success
- [ ] Fail

### Test case 3.5 - Private post should not be shown when logged out

    1. After doing test case 3.4 click the logout button
    2. System shows log out page and the should NOT show this post:

        "Test

        Private"


- [x] Success
- [ ] Fail

### Test case 4.1 - Successfully create a new public post

    1. Log in with Admin and Password, click Create new post button.
    2. System shows a form to create a post.
    3. Write Test inte the title input, Public in the Blog Post input, check the Make post public box and click Save.
    4. System redirects to main page and shows the new post and that the new post is public:

        "Test

        This is a public post

        Public"


- [x] Success
- [ ] Fail

### Test case 4.2 - Successfully show public post when logged out

    1. After doing test case 4.1 click the logout button
    2. System shows log out page and the should show the created post:

        "Test

        Public"


- [x] Success
- [ ] Fail

### Test case 5 - Successfully delete post

    1. After doing test case 4.2, login with Admin and Password, find the created post and click delete button.
    2. System deletes the post and show the message:
        "Post was successfully deleted."

- [ ] Success
- [x] Fail

Comment: Post is deleted but system does not show message.

## Additional comments for assigment 3 1dv610
I wanted to create a full CRUD page for the posts but had to remove the "Update post" use case because of time restrictions. 
I also wanted to make the classes UserCredentialsModel, BlogPostModel and UserCookieModel as objects and using get methods instead of using them as data structures as it is now. Unfortunately when I tried to refactor this it didn't work as planned and once again the time issue became a factor.

I have a few TODO comments in the code to show that I know that some of my solutions is not optional or that I know a way to improve the code quality.
In the ShowPostModel line 27 i have a line that in taken from an outside source. This was okey according to Daniel Toll, 1DV610 course coordinator.

I also tried as far as I could to add type security. Some type security worked during development but had to be removed for the program to work on the public server.

As far as comments go I tried to only add comments when necessary. As stated i both Clean Code and in the lectures to much comments can only be missleading or confusing. I tried hard to create names for methods and variables that was self explanatory and make the flow of the code easy to follow instead of explaining in the comments what every method does. Therefor the PHP docs for every method might seem scarce. 

As a last comment I just want to say that this assignment was hard. There was a lot to think about and even after checking everything many times I just hope I haven't missed anything essentials. BUT this assignment was also fun. There was a lot of challenges but I really do believe I learned a lot by trying to find solutions for them.







