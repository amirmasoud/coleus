# About Negarin
Coming soon...

## Database structure

`users` table:
| users | | |
| ------------- |:-------------:| -----:|
| id      | primary key |  |
| email      | string, unique      |   |
| password | string      |    |
| role | enum(admin, author, publisher, subscriber) | default: subscriber   |

Authentication is applied to email and password with each roles.
