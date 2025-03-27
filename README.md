# <p align="center">My Pocket Library  📚</p>
  
Étant passionné de lecture en parallèle de mes études de développement, j'ai souhaité allier mes deux centres d'intérêt : les livres et le code !<br>
Ce projet a pour objectif de me familiariser avec la programmation orientée objet (POO), d'approfondir des concepts clés tels que l'abstraction, l'héritage et la surcharge, et de travailler sur une meilleure organisation du code en appliquant le modèle MVC (Modèle-Vue-Contrôleur).<br>
Avec une bibliothèque de plus en plus conséquente, j’ai ressenti le besoin de développer une application me permettant de gérer et de visualiser facilement mes ouvrages.


## 🧐 Features    
- Rechercher un livre grâce à l'API de Google
- Créer et gérer son compte utilisateur
- Ajouter un livre dans sa bibliothéque
- Visualiser et gérer sa collection de livres


## 🛠️ Tech Stack
- [React](https://reactjs.org/)
- [Tailwind CSS](https://tailwindcss.com/)
- [PHP](https://www.php.net/)




## ➤ API Reference

### Create account form
```http
POST /createAccount
```
| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name`   | `string` | **Required**. Your name    |
| `email`  | `string` | **Required**. Your email   |
| `password`| `string` | **Required**. Your password |



## ➤ API Reference

### Connection form
```http
POST /login
```
| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `email`   | `string` | **Required**. Your email    |
| `password`  | `string` | **Required**. Your password   |



## ➤ API Reference

### Add book in personal library
```http
POST /addToCollection
```
| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name`   | `string` | **Required**. book's name    |
| `author`  | `string` | **Required**. author's name   |
| `image`| `string` | **Required**. link of Google's API |
| `isbn`| `string` | **Required**. isbn number |
| `iuser_id`| `int` | **Required**. user id in db |


## ➤ API Reference

### Delete a book
```http
POST /deleteBook
```
| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `book_id`   | `int` | **Required**. book id     |
| `user_id`  | `int` | **Required**. user id   |


## ➤ API Reference 2

### Get all user informations
```http
GET /getUserInfo
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email` | `string` | **Required**. user email |

### Get count of user library
```http
GET /getCountAllBooks
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `user_id` | `int` | **Required**. Your user id |

### Get user all books
```http
GET /getAllBooks
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `user_id` | `int` | **Required**. Your user id |




       
## 🙇 Author
#### Sébastien Lotten
- Github: [@SHACRAM](https://github.com/SHACRAM)



## ➤ License
Distributed under the MIT License. See [LICENSE](LICENSE) for more information.