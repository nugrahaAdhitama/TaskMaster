<h1>Task</h1>

<a href="<?= BASE_URI ?>dashboard">Back to Dashboard</a>
<a href="<?= BASE_URI ?>task/add">Add Task</a>

<table>
    <tr>
        <th>COLUMNS</th>
    </tr>
    <!-- <?php foreach ( $tasks as $task ) : ?> -->
    <tr>
        <td><?= $task["column"] ?></td>
        <td>
            <a href="<?= BASE_URI ?>task/view/<?= $task["id"] ?>"?>view</a>
            <a href="<?= BASE_URI ?>task/invite/<?= $task["id"] ?>"?>invite</a>
            <a href="<?= BASE_URI ?>task/edit/<?= $task["id"] ?>"?>edit</a>
            <a href="<?= BASE_URI ?>task/delete/<?= $task["id"] ?>">delete</a>
        </td>
    </tr>
    <!-- <?php endforeach; ?>-->
</table>