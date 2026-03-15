<div class="container mt-5">
    <h1>Update Book</h1>
    <!-- Display the ID of the book being updated -->
    <h2>ID: <?= $book['id']; ?></h2>
    <!-- Form to update book details, using POST method -->
    <form class="mb-3" method="POST">
        <fieldset>
            <!-- Label and input field for the book ISBN -->
            <label class="form-label" for="isbn">ISBN: </label>
            <input class="form-control" type="text" name="isbn" placeholder="<?= $book['isbn']; ?>" id="isbn" required>
        </fieldset>
        <fieldset>
            <!-- Label and input field for the book title -->
            <label class="form-label" for="title">Title: </label>
            <input class="form-control" type="text" name="title" placeholder="<?= $book['title']; ?>" id="title" required>
        </fieldset>
        <fieldset>
            <!-- Label and input field for the book author -->
            <label class="form-label" for="author">Author: </label>
            <input class="form-control" type="text" name="author" placeholder="<?= $book['author']; ?>" id="author" required>
        </fieldset>
        <!-- Submit button to update the book details -->
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    <!-- Link to view all books -->
    <a href="<?=BASE_URL?>books" class="btn btn-secondary">View All Books</a>
</div>