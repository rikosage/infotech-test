<?php if ($selection): ?>
<h1>Лидеры за <?= $year ?> год:</h1>
<table class="table">
    <thead>
        <tr>
            <th>Автор</th>
            <th>Книги</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($selection as $author): ?>
            <tr>
                <th scope="row"><?= $author->name; ?></th>
                <td>
                    <?php foreach ($author->books as $book): ?>
                        <?= $book->title ?> <br>
                    <?php endforeach; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <h1>Авторы не выпускали книг в <?= $year ?> году</h1>
<?php endif; ?>
