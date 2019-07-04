# Docker LAMP

An example of a modular LAMP stack using Docker.

---

## Usage

- Clone the repo
- In the repo, run `docker-compose up`
- In your browser, go to http://localhost
  - You should see a message stating that you connected to the database, and
  data should be displayed below that message.
    - On the first run, you'll also see a message stating a table with data
    was added to the database.
  - There will also be a link to `phpMyAdmin` at the bottom of the page. That
  link will take you directly to the database specified in `.env`. Log in with
  credentials `root` & `pass`.

---

## Configuration

The `.env` file contains:
- Docker image versions for Apache, MySQL, PHP, & phpMyAdmin.
- MySQL credentials.
- The folder path to what will be served by the server.

The `docker-compose.yml` file auto-loads the sibling `.env` file. It will:
- Build a custom Apache img.
- Build a custom PHP img.
- Start up MySQL & PHP, then Apache & phpMyAdmin.

MySQL data is stored in `./.docker/mysql/data` for easy access. That folder
won't exist until you run the example for the first time.
