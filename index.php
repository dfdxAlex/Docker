<?php

// Подключение к базе данных PostgreSQL
$dbconn = pg_connect("host=postgres dbname=awtor user=user password=password")
    or die('Could not connect: ' . pg_last_error());

// Создание таблиц
$query_create_tables = "
    CREATE TABLE IF NOT EXISTS authors (
        author_id SERIAL PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL
    );

    CREATE TABLE IF NOT EXISTS books (
        book_id SERIAL PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        publication_year INTEGER NOT NULL,
        isbn VARCHAR(20) UNIQUE NOT NULL,
        author_id INTEGER REFERENCES authors(author_id)
    );

    CREATE TABLE IF NOT EXISTS reviews (
        review_id SERIAL PRIMARY KEY,
        book_id INTEGER REFERENCES books(book_id),
        rating INTEGER CHECK (rating BETWEEN 1 AND 10),
        content TEXT
    );

";

$result = pg_query($dbconn, $query_create_tables); // Явное указание соединения
if (!$result) {
    echo "An error occurred.\n";
    exit;
}


// Запрос 1: имена и фамилии авторов, а также количество написанных ими книг
$query_authors_books_count = "
select 
    authors.first_name,
	authors.last_name,
	count(books.author_id)
from authors
left join books
on authors.author_id = books.author_id
group by authors.first_name, authors.last_name
";

$result = pg_query($dbconn, $query_authors_books_count); // Явное указание соединения
if (!$result) {
    echo "An error occurred.\n";
    exit;
}

echo "Authors and the number of books they have written:\n";
while ($row = pg_fetch_assoc($result)) {
    echo $row['first_name'] . " " . $row['last_name'] . ": " . $row['book_count'] . " books\n";
}

// Проверка существования представления top_authors
$query_check_view = "SELECT EXISTS(SELECT 1 FROM pg_views WHERE viewname = 'top_authors')";
$result_check_view = pg_query($dbconn, $query_check_view); // Явное указание соединения
if (!$result_check_view) {
    echo "An error occurred.\n";
    exit;
}

$row_check_view = pg_fetch_assoc($result_check_view);
$top_authors_exists = $row_check_view['exists'] === 't';

// Запрос 2: представление с пятью авторами, у которых средняя оценка всех книг самая высокая (если не существует)
if (!$top_authors_exists) {
    $query_create_view = "
    create view authors_rating as
    select authors.author_id, authors.first_name, authors.last_name, avg(reviews.rating) as rating
    from authors
    join books
    on authors.author_id = books.author_id
    join reviews
    on books.book_id = reviews.book_id
    group by authors.author_id, authors.first_name, authors.last_name
    order by rating desc
    limit 5
    ";

    $result = pg_query($dbconn, $query_create_view); // Явное указание соединения
    if (!$result) {
        echo "An error occurred.\n";
        exit;
    }
    echo "View 'top_authors' has been created successfully.\n";
} else {
    echo "View 'top_authors' already exists.\n";
}

// Закрытие соединения с базой данных
pg_close($dbconn);
?>
