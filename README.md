# Welcome to the RMP Enterprise Developer Task - CSV Export
### Overview
What we have here is an incomplete export system based on a small set of student data.
The mission, if you choose to accept it, is to fill in the missing parts and finish the application to the *best* of your ability.

How you do this is completely down to you. We have only provided the bare bones.
There is no right or wrong, however we don't want you to rely on a third party csv package, or use the fputcsv function. For testability and maintainability, it is preferrable that your logic is writting in dedicated classes, rather than controllers.

Although this is a relatively small task we believe there is enough here for you to be able to demonstrate your ability to follow good coding practices and show your understanding of PHP and the Laravel framework.
Our products require features to be backed up by tests (unit and integration) so please provide suitable PHPUnit tests. We use Vue.js for our frontend JS so any enhancements to the UI with Vue would be great to see. The task is written using Laravel 5.4, so be sure to check the older documentation, if you are stuck.

Oh and there may be some 'deliberate' errors in our code, which require fixing... Enjoy.

### Getting Started
1) Set up PHP 7, Composer and Sqlite3 or MySQL 5.7.* on your local environment.
2) `git clone https://github.com/RMPEnterprise/php-developer-task.git`
3) `composer install`
4) The task includes a populated sqlite database, but you may prefer to use mySql, in which case you will need to change .env and run `php artisan migrate --seed`
5) `php artisan serve --port=8003`
6) Visit `http://127.0.0.1:8003`

### What we expect
- Don't rely on a third party csv package or `fputcsv` function
- Clear separation of concerns
- PHPUnit tests for the success and failure scenarios
- Explain your decisions through comments or a readme etc

### What we would like to see
- PSR-2 compilant code.
- Consideration of data security (included is only dummy data, however).
- For testability and maintainability, it is preferrable that your logic is writting in dedicated classes, rather than controllers.
- Tested code

### Scenarios
1. Render the table of students
2. Export a CSV file of selected students when clicking on the export buttons
3. Give the exported CSV file a name
4. View export history

### Well that was easy...
If time allows and you want to really impress us, please consider adding the following additional functionality.
- TDD
- handling 200K+ students to export
- Search the table
- Sort the table
- download a previous export from history

### Questions
If there are any critical issues please contact dominic.sabatini@rmpenterprise.co.uk, bruno@rmpenterprise.co.uk or ian.nisbet@rmpenterprise.co.uk.



# Applicant

### Note

I've had quite a busy weekend, and worked on the intermittently over Sunday, and some on Monday morning/afternoon.
I'd be happy to continue with the code test, but I thought I'd send it over now, as I think there's enough to show. Additionally, I can provide examples of work for Vue and PHP, including some other code tests

### Scenarios
1. Already done? Render the table of students
2. Done. Export a CSV file of selected students when clicking on the export buttons
3. Done. Give the exported CSV file a name
4. Done. View export history

### Well that was easy...
If time allows and you want to really impress us, please consider adding the following additional functionality.
- Partially done. TDD
- Not done. I am aware Excel wont read files past a particular set of bytes, though. handling 200K+ students to export
- Not done. Search the table
- Not done. Sort the table
- Done. download a previous export from history



### How it works

`abstract class App\Services\Output` is designed to build and output/save data. Perhaps naming as a `Parser` or `Generator` could be better suited.

`class CSVOutput extends Output` modifies the behaviour by creating a CSV output

`class StudentCSVOutput extends CSVOutput` modifies the behaviour by overriding the parent method `build()`, a method for processing the data provided. For CSVs, this means ensuring it's a flat file. For this class, it takes a `Collection` of `Student` models.

**I'm not entirely satisfied with this design, as it doesn't allow the loading of existing CSVs, and could prove to be quite inflexible.**

*However*, each method in the `ExportController` just needs to a couple of lines to generate a CSV for a Student, and the output for a Student is updated in one, very dry place.


### Testing

I've created some tests, although I am relatively new to testing, with some minor guidance I'm sure I could do well quite quickly, along with more time learning and researching over my Notice Period.

- I ran into an issue with 5.4.11 (nice lock file).
- Previously I've been doing tests with L5.8 and `use RefreshDatabase` I had to look at the L5.4 way of doing this. Had to create a test.sqlite db and update `phpunit.xml`? Is there a better way?
- 


### Other things I would do
- Improve Output design
- Storage::disk('local') could do with an env variable
- Multiple downloads by Zipping CSVs
- CSVs above 200k (multiple files?)
- Sort/search table
- implement remaining `ExportController` methods
- split up `ExportController` to more specific Controllers


### Anything else?
Anything I've missed? Any questions? I'd appreciate feedback! Thanks.