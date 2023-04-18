<h1>View Task</h1>

<a href="<?= BASE_URI ?>task">Back to Task List</a>

<table>
    <tr>
        <th>Title</th>
        <td><?= $task["judul"] ?></td>
    </tr>
    <tr>
        <th>Deadline</th>
        <td><?= $task["deadline"] ?></td>
    </tr>
    <tr>
        <th>Status</th>
        <td><?= $task["status"] ?></td>
    </tr>
    <tr>
        <th>Type</th>
        <td><?= $task["tipe"] ?></td>
    </tr>
    <tr>
        <th>Description</th>
        <td><?= $task["deskripsi"] ?></td>
    </tr>
</table>