<div class="container mt-5">
    <h1>All Books</h1>
    <!-- Table to display all books -->
    <table class="table table-bordered  ">
        <thead>
            <!-- Table headers -->
            <th>ID</th>
            <th>ISBN</th>
            <th>Title</th>
            <th>Author</th>
            <th>Date Added</th>
            <?php if ($isAuthenticated): ?>
                <th colspan="3">Actions</th>
            <?php else: ?>
                <th>Action</th>
            <?php endif; ?>
        </thead>
        <!-- Loop through each book in the data array -->
        <?php foreach ($data['books'] as $book) : ?>
            <tr>
                <!-- Display book details -->
                <td><?= $book['id'] ?></td>
                <td><?= $book['isbn'] ?></td>
                <td><?= $book['title'] ?></td>
                <td><?= $book['author'] ?></td>
                <td><?= $book['date_added'] ?></td>
                <!-- Action links for each book -->
                <?php if ($isAuthenticated): ?>
                    <td><a href="<?= BASE_URL ?>book/delete/<?= $book['id']; ?>">Delete</a></td>
                    <td><a href="<?= BASE_URL ?>book/update/<?= $book['id']; ?>">Update</a></td>
                <?php endif; ?>
                <td><a href="<?=BASE_URL?>book/id/<?= $book['id']; ?>">View</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <!-- Link to add a new book -->
    <?php if ($isAuthenticated): ?>
        <a href="<?= BASE_URL ?>book/add" class="btn btn-primary">Add new book</a>
    <?php endif; ?>
</div>