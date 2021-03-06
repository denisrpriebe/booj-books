# Booj Books

This repository is my personal submission for the [Booj Books](https://github.com/ActiveWebsite/boojbooks) code test. It should meet and/or exceed the following requirements:

* Connect to a publically available API
* Create Postman collection and Vue app OR Laravel App 
* Add or remove items from the list
* Change the order of the items in the list
* Sort the list of items
* Display a detail page with at least 3 points of data to display
* Include unit tests
* Deploy it on the cloud - be prepared to describe your process on deployment

### Overview

This application allows users to keep track of books they would like to read. Users can create a personal account, search for books, sort their list of books via drag and drop and much more.

This application has been built with Laravel 6.x, Vue.js and Bootstrap 4.

### CI and Deployment

<p>
<a href="https://app.codeship.com/projects/374302"><img src="https://app.codeship.com/projects/4a59fa30-ea1d-0137-b80b-22ee8611456c/status?branch=dev" alt="Build Status"></a>
<a href="https://codecov.io/gh/denisrpriebe/booj-books">
  <img src="https://codecov.io/gh/denisrpriebe/booj-books/branch/dev/graph/badge.svg" />
</a>
</p>

Continous integration has been setup with Codeship and CodeCov to insure we have a passing build with good code coverage.

This project has been deployed in the cloud using Forge and Digital Ocean. You can access it by going to: [http://159.89.237.232](http://159.89.237.232)

### Open Library API

Behind the scenes, this application is powered by [Open Library's API](https://openlibrary.org/developers/api). *Unfortunately, it appears that a vast majority of the books this API provides data for are missing images and descriptions among other things.*

On a side note, after working with this API, I am not happy with it. Data returned from the Open Library API is inconsistent, confusing and sometimes doesn't return any results at all. If I where to do this project again I would definitely look into consuming a different third party API. However, I think it will suffice for this simple code test.
