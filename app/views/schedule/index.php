<h1>Schedule</h1>

<a href="<?= BASE_URI ?>dashboard">Back to Dashboard</a>
<a href="<?= BASE_URI ?>schedule/add">Add Schedule</a>

<table>
    <tr>
        <th>#</th>
        <th>Course</th>
    </tr>
    <?php foreach ( $courses as $no => $course ) : ?>
    <tr>
        <td><?= $no ?></td>
        <td><?= $course ?></td>
    </tr>
    <?php endforeach; ?>
</table>