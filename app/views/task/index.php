<h1>Task</h1>

<a href="<?= BASE_URI ?>dashboard">Back to Dashboard</a>
<a href="<?= BASE_URI ?>task/add">Add Task</a>

<table>
    <tr>
        <th>Title</th>
        <th>Deadline</th>
        <th>Status</th>
        <th>Type</th>
        <th>Description</th>
        <th>Aksi</th>
    </tr>
    <!-- <?php foreach ( $tasks as $task ) : ?> -->
    <tr>
        <td><?= $task["judul"] ?></td>
        <td><?= $task["deadline"] ?></td>
        <td><?= $task["status"] ?></td>
        <td><?= $task["tipe"] ?></td>
        <td><?= $task["deskripsi"] ?></td>
        <td>
            <a href="<?= BASE_URI ?>task/view/<?= $task["id"] ?>">view</a>
            <a href="<?= BASE_URI ?>task/invite/<?= $task["id"] ?>">Invite</a>
            <a href="<?= BASE_URI ?>task/edit/<?= $task["id"] ?>"?>edit</a>
            <a href="<?= BASE_URI ?>task/delete/<?= $task["id"] ?>">delete</a>
        </td>
    </tr>
    <!-- <?php endforeach; ?>-->
</table>