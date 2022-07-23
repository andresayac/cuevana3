
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


## 🚩 getMovies(type)
Returns a list with the movies according to the indicated `type`.

| Description | value |
| -----|----- |
| Latest movies added | cuev_mov_lastest |
| Premiere movies | cuev_mov_release |
| Most viewed movies | cuev_mov_more_views |
| Top rated movies | cuev_mov_most_valued |
| Latin dub movies | cuev_mov_latin |
| Spanish dub movies | cuev_mov_spanish |
| Subtitled movies | cuev_mov_subtitled |

Example:
``` php
<?php
# Dependencies
require 'vendor/autoload.php';

# Config
require 'config/config.php';

# Movies Class
require 'inc/movies.class.php';

$cuevana_movies = new Movies($_config);
echo json_encode($cuevana_movies->getMovies($_config['path']['movies']['cuev_mov_lastest']), JSON_PRETTY_PRINT);
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

