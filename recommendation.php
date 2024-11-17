<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Recommendations</title>
    <!-- style -->
    <style>
        body {
            background-color: darkgray;
            font-family: Arial, sans-serif;
        }
        .book-list {
            margin: 20px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
        }
        .book {
            margin-bottom: 15px;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .book:last-child {
            border-bottom: none;
        }
        .pagination {
            margin: 20px;
            text-align: center;
        }
        .pagination button {
            margin: 5px;
            padding: 10px 20px;
            font-size: 16px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        let currentPage = 1;
        const itemsPerPage = 10;
        let books = [];

        $(document).ready(function() {
            $.ajax({
                url: "https://openlibrary.org/people/mekBot/books/want-to-read.json",
                method: "GET",
                dataType: "json",
                success: function(data) {
                    books = data.reading_log_entries;
                    displayPage(currentPage);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                    $("#book-list").append("<p>An error occurred while loading the book data.</p>");
                }
            });

            $("#prev-page").click(function() {
                if (currentPage > 1) {
                    currentPage--;
                    displayPage(currentPage);
                }
            });

            $("#next-page").click(function() {
                if (currentPage * itemsPerPage < books.length) {
                    currentPage++;
                    displayPage(currentPage);
                }
            });
        });

        function displayPage(page) {
            const startIndex = (page - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageBooks = books.slice(startIndex, endIndex);

            const bookList = $("#book-list");
            bookList.empty();

            if (pageBooks.length === 0) {
                bookList.append("<p>No books found.</p>");
                return;
            }

            $.each(pageBooks, function(index, book) {
                const title = book.work.title || "No title available";
                const authors = book.work.authors ? book.work.authors.map(author => author.name).join(", ") : "Unknown";
                const publishDate = book.work.first_publish_date || "Unknown";

                const bookItem = `<div class="book">
                    <h2>${title}</h2>
                    <p><strong>Author:</strong> ${authors}</p>
                    <p><strong>Publish Date:</strong> ${publishDate}</p>
                </div>`;
                bookList.append(bookItem);
            });

            updatePaginationButtons();
        }

        function updatePaginationButtons() {
            $("#prev-page").prop("disabled", currentPage === 1);
            $("#next-page").prop("disabled", currentPage * itemsPerPage >= books.length);
        }
    </script>
</head>
<body>
    <div class="book-list" id="book-list">
        <h1 style="text-align:center">Recommended Books</h1>
    </div>
    <div class="pagination">
        <button id="prev-page" disabled>Previous</button>
        <button id="next-page" disabled>Next</button>
    </div>
</body>
</html>
