<div class="container mt-5">
    <h1>Add Book</h1>
    <form class="mb-3" method="POST">
        <fieldset>
            <label class="form-label" for="isbn">ISBN No: </label>
            <input class="form-control" type="text" name="isbn" id="isbn" required>
        </fieldset>
        <fieldset>
            <label class="form-label" for="title">Title: </label>
            <input class="form-control" type="text" name="title" id="title" required>
        </fieldset>
        <fieldset>
            <label class="form-label" for="author">Author: </label>
            <input class="form-control" type="text" name="author" id="author" required>
        </fieldset>
        <button type="submit" class="btn btn-primary">Add Book</button>
    </form>
    <a href="<?=BASE_URL?>books" class="btn btn-secondary">View All Books</a>
</div>