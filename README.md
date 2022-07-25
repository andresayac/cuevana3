
<p align="center">
 Cuevana3 PHP scraper is a content provider of the latest in the world of movies and tv show in Latin Spanish dub or subtitled.
</p>

## 📌 Installation
```
$ git clone https://github.com/andresayac/cuevana3.git
$ cd cuevana3
$ composer install
```

## 📖 Documentation
Available methods:

- [getMovies](#-getMoviestype): Returns a list with the movies according to the indicated type.
- [getMoviesPag](#-getMoviesPag): Returns a list with the movies and information of the pagination.
- [getSeries](#-getSeriestype): Returns a list with the series according to the indicated type.
- [getSeriesPag](#-getSeriesPag): Returns a list with the series and information of the pagination.
- [getGenres](#-getGenres): Return the complete list of genres.
- [getDetail](#-getDetailid): Returns the detail of the selected movie/series.
- [getByGenre](#-getByGenreid-page): Returns a list with movies according to the indicated genre and page.
- [getByActor](#-getByActorid-page): Returns a list with movies according to the indicated actor.
- [getSearch](#-getSearchquery-page): Returns a list with movies/series according to query.
- [getLinks](#-getLinksid): Returns a list of links of selected movie or episode of serie.
- [getDownload](#-getDownloadid): Returns a list of download links of selected movie or episode of serie.

## 🚩 getMovies(type)
Returns a list with the movies according to the indicated `type`.

| Description | value |
| -----|----- |
| Latest movies added | 0 |
| Premiere movies | 1 |
| Most viewed movies | 2 |
| Top rated movies | 3 |
| Latin dub movies | 4 |
| Spanish dub movies | 5 |
| Subtitled movies | 6 |

Example:
``` php
<?php
# Dependencies
require 'vendor/autoload.php';

# Config
require 'config/config.php';

# Utils Class
require 'inc/utils.class.php';
# Movies Class
require 'inc/cuevana.class.php';


$cuevana_movies = new Cuevana();
echo json_encode($cuevana_movies->getMovies(0); // Latest movies added
echo json_encode($cuevana_movies->getMovies(1); // Premiere movies
echo json_encode($cuevana_movies->getMovies(2); // Most viewed movies
echo json_encode($cuevana_movies->getMovies(3); // Top rated movies
echo json_encode($cuevana_movies->getMovies(4); // Latin dub movies
echo json_encode($cuevana_movies->getMovies(5); // Spanish dub movies
echo json_encode($cuevana_movies->getMovies(6); // Subtitled movies
```

## 🚩 getMoviesPag(Page)
Returns a list with the movies according to the indicated `page`.

Example:
``` php
<?php
# Dependencies
require 'vendor/autoload.php';

# Config
require 'config/config.php';

# Utils Class
require 'inc/utils.class.php';
# Movies Class
require 'inc/cuevana.class.php';


$cuevana_movies = new Cuevana();
echo json_encode($cuevana_movies->getMoviesPag(1); // Movies from the respective page
```

### **:busts_in_silhouette: Credits**

- [Carlos Fernández](https://github.com/carlosfdezb/cuevana3) (idea owner)

---

### **:anger: Troubleshootings**

This is just a personal project created for study / demonstration purpose and to simplify my working life, it may or may
not be a good fit for your project(s).

---

### **:heart: Show your support**

Please :star: this repository if you like it or this project helped you!\
Feel free to open issues or submit pull-requests to help me improving my work.


---



Copyright © 2022 [Cuevana3 Scraper PHP](https://github.com/andresaya/cuevana3).

