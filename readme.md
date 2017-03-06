# About Negarin
Coming soon...

## Database structure

| users | | |
| ------------- |:-------------:| -----:|
| id      | primary key |  |
| email      | string, unique      |   |
| password | string      |    |
| role | enum(admin, author, publisher, subscriber) | default: subscriber   |
| created_at | timestamps | |
| updated_at | timestamps | |

> Authentication is applied to email and password with each roles.

| occupations | categorize authors occupations | |
| ------------- |:-------------:| -----:|
| id      | primary key |  |
| name      | string |   |
| created_at | timestamps | |
| updated_at | timestamps | |

| movements | categorize authors movements | |
| ------------- |:-------------:| -----:|
| id      | primary key |  |
| name      | string |   |
| created_at | timestamps | |
| updated_at | timestamps | |

| authors | | |
| ------------- |:-------------:| -----:|
| id      | primary key |  |
| name      | string |   |
| born      | dateTime |   |
| user_id      | FK to users |   |
| occupation_id      | FK to occupations |   |
| movement_id      | FK to movements |   |
| extra      | text | store extra serialized information of author |
| approved      | boolean | publishers can add authors, before their author appear, he/she shall be approved |
| created_at | timestamps | |
| updated_at | timestamps | |