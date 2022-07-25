
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
- [getMoviesPag](#-getMoviesPagpage): Returns a list with the movies and information of the pagination.
- [getSeries](#-getSeriestype): Returns a list with the series according to the indicated type.
- [getSeriesPag](#-getSeriesPagpage): Returns a list with the series and information of the pagination.
- [getDetail](#-getDetailid): Returns the detail of the selected movie/series.
- [getGenres](#-getGenres): Return the complete list of genres.
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
# Cuevana Class
require 'inc/cuevana.class.php';


$cuevana_class = new Cuevana();

echo json_encode($cuevana_class->getMovies(0)); // Latest movies added
echo json_encode($cuevana_class->getMovies(1)); // Premiere movies
echo json_encode($cuevana_class->getMovies(2)); // Most viewed movies
echo json_encode($cuevana_class->getMovies(3)); // Top rated movies
echo json_encode($cuevana_class->getMovies(4)); // Latin dub movies
echo json_encode($cuevana_class->getMovies(5)); // Spanish dub movies
echo json_encode($cuevana_class->getMovies(6)); // Subtitled movies
```

Results:
``` json
{
  "success": true,
  "data": [
    {
      "id": "58XX/XXXX",
      "title": "XXXXXXX XXX",
      "url": "https://ww1.cuevana3.me/586XX/XXX",
      "poster": "https://ww1.cuevana3.me/wp-content/uploads/20XX/XX/XXXXXX-200x300.jpg",
      "year": "2021",
      "sypnosis": "XXXXXXX […]",
      "rating": "4.29",
      "duration": "1h 54m",
      "director": "XXXX",
      "genres": [
        "Acción",
        "Aventura",
        "Drama"
      ],
      "cast": [
        "XXXXX",
        "XXX XXX"
      ]
    }
  ],
  "message": "Information obtained from: "
}
```

## 🚩 getMoviesPag(page)
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
# Cuevana Class
require 'inc/cuevana.class.php';


$cuevana_class = new Cuevana();

echo json_encode($cuevana_class->getMoviesPag(1)); // Movies from the respective page
```

Results:
``` json
{
  "success": true,
  "data": [
    {
      "id": "586XX/XX-XX",
      "title": "XXXX XXX",
      "url": "https://ww1.cuevana3.me/58XXX/XXX-XX",
      "poster": "https://ww1.cuevana3.me/wp-content/uploads/20XX/XX/XXX-XXX-XXX-poster-200x300.jpg",
      "year": "2021",
      "sypnosis": "XXXXXXX […]",
      "rating": "4.29",
      "duration": "1h 54m",
      "director": "Director: XXXX",
      "genres": [
        "Acción",
        "Aventura",
        "Drama"
      ],
      "cast": [
        "XXX XXX",
        "XXXXXXX"
      ]
    }
  ],
  "message": "information obtained for the page: 1",
  "information": {
    "page": 1,
    "total_pages": 168,
    "in_page": 45
  }
}
```


## 🚩 getSeries(type)
Returns a list with the Series according to the indicated `type`.

| VALUE | TYPE |
| -----|----- |
| Latest series added | 0 |
| Premiere series | 1 |
| Top rated series | 2 |
| Most viewed series | 3 |

Example:
``` php
<?php
# Dependencies
require 'vendor/autoload.php';

# Config
require 'config/config.php';

# Utils Class
require 'inc/utils.class.php';
# Cuevana Class
require 'inc/cuevana.class.php';


$cuevana_class = new Cuevana();

echo json_encode($cuevana_class->getSeries(0)); // Latest series added
echo json_encode($cuevana_class->getSeries(1)); // Premiere series
echo json_encode($cuevana_class->getSeries(2)); // Top rated series
echo json_encode($cuevana_class->getSeries(3)); // Most viewed series
```

## 🚩 getSeriesPag(page)
Returns a list with the series according to the indicated `page`.

Example:
``` php
<?php
# Dependencies
require 'vendor/autoload.php';

# Config
require 'config/config.php';

# Utils Class
require 'inc/utils.class.php';
# Cuevana Class
require 'inc/cuevana.class.php';


$cuevana_class = new Cuevana();

echo json_encode($cuevana_class->getSeriesPag(1)); // Series from the respective page
```

Results:
``` json
{
  "success": true,
  "data": [
    {
      "id": "XXXX",
      "title": "XXXX XXX",
      "url": "https://ww1.cuevana3.me/58XXX/XXX-XX",
      "poster": "https://ww1.cuevana3.me/wp-content/uploads/20XX/XX/XXX-XXX-XXX-poster-200x300.jpg",
      "year": "2021",
      "sypnosis": "XXXXXXX […]",
      "rating": "4.29",
      "duration": "1h 54m",
      "director": "Director: XXXX",
      "genres": [
        "Acción"
      ],
      "cast": [
        "XXX XXX",
        "XXXXXXX"
      ]
    }
  ],
  "message": "information obtained for the page: 1",
  "information": {
    "page": 1,
    "total_pages": 168,
    "in_page": 45
  }
}
```
## 🚩 getDetail(id)
Returns a list with the episode or movie according to the indicated `id`.

Example:
``` php
<?php
# Dependencies
require 'vendor/autoload.php';

# Config
require 'config/config.php';

# Utils Class
require 'inc/utils.class.php';
# Cuevana Class
require 'inc/cuevana.class.php';


$cuevana_class = new Cuevana();

echo json_encode($cuevana_class->getDetail('86xx/xx-xx')); // Movie or  Episode from the respective page
echo json_encode($cuevana_class->getDetail('episodio/xxxxx-1x10')); // Movie or  Episode from the respective page
```

## 🚩 getGenres()
Returns a list with the Genres with information pagination.

Example:
``` php
<?php
# Dependencies
require 'vendor/autoload.php';

# Config
require 'config/config.php';

# Utils Class
require 'inc/utils.class.php';
# Cuevana Class
require 'inc/cuevana.class.php';


$cuevana_class = new Cuevana();

echo json_encode($cuevana_class->getGenres(); // list the Genres
```

## 🚩 getByGenre(genre,page)
Returns a list with the  according to the indicated `genre` and `page`.

Example:
``` php
<?php
# Dependencies
require 'vendor/autoload.php';

# Config
require 'config/config.php';

# Utils Class
require 'inc/utils.class.php';
# Cuevana Class
require 'inc/cuevana.class.php';


$cuevana_class = new Cuevana();

echo json_encode($cuevana_class->getByGenre('ciencia-ficcion',1)); // Movies or Series from the respective genre and page
```


## 🚩 getByActor(actor,page)
Returns a list with the series according to the indicated `actor` and `page`.

Example:
``` php
<?php
# Dependencies
require 'vendor/autoload.php';

# Config
require 'config/config.php';

# Utils Class
require 'inc/utils.class.php';
# Cuevana Class
require 'inc/cuevana.class.php';


$cuevana_class = new Cuevana();

echo json_encode($cuevana_class->getByActor('adam-kiani',1)); // Movies from the respective actor and page
```

## 🚩 getSearch(query,page)
Returns a list with the series and movies according to the indicated `query` and `page`.

Example:
``` php
<?php
# Dependencies
require 'vendor/autoload.php';

# Config
require 'config/config.php';

# Utils Class
require 'inc/utils.class.php';
# Cuevana Class
require 'inc/cuevana.class.php';


$cuevana_class = new Cuevana();

echo json_encode($cuevana_class->getSearch('casa')); // Movies and series from the respective query and page
```

## 🚩 getLinks(id)
Returns a list of links  the movies and series according to the indicated `id`.

Example:
``` php
<?php
# Dependencies
require 'vendor/autoload.php';

# Config
require 'config/config.php';

# Utils Class
require 'inc/utils.class.php';
# Cuevana Class
require 'inc/cuevana.class.php';


$cuevana_class = new Cuevana();

echo json_encode($cuevana_class->getLinks('86xx/xx-xx')); // Movies from the respective page
echo json_encode($cuevana_class->getLinks('episodio/xxxxx-1x10')); // Series from the respective page
```


## 🚩 getDownload(id)
Returns a list of links  the movies and series according to the indicated `id`.

Example:
``` php
<?php
# Dependencies
require 'vendor/autoload.php';

# Config
require 'config/config.php';

# Utils Class
require 'inc/utils.class.php';
# Cuevana Class
require 'inc/cuevana.class.php';


$cuevana_class = new Cuevana();

echo json_encode($cuevana_class->getLinks('86xx/xx-xx')); // Movies from the respective page
echo json_encode($cuevana_class->getLinks('episodio/xxxxx-1x10')); // Series from the respective page
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

