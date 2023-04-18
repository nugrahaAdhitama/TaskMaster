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

<h2>Members</h2>
<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
    </tr>
    <?php foreach ($members as $member): ?>
    <tr>
        <td><?= $member["nama"] ?></td>
        <td><?= $member["email"] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
