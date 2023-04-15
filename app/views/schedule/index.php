<h1>Schedule</h1>

<a href="<?= BASE_URI ?>dashboard">Back to Dashboard</a>
<a href="<?= BASE_URI ?>schedule/add">Add Schedule</a>

<table>
    <tr>
        <th>Course</th>
        <th>Started At</th>
        <th>Ended At</th>
        <th>Day</th>
        <th>Room</th>
        <th>Notes</th>
        <th>Actions</th>
    </tr>
    <?php foreach ( $schedules as $schedule ) : ?>
    <tr>
        <td><?= $schedule["course"] ?></td>
        <td><?= $schedule["started_at"] ?></td>
        <td><?= $schedule["ended_at"] ?></td>
        <td><?= $schedule["day"] ?></td>
        <td><?= $schedule["room"] ?></td>
        <td><?= $schedule["notes"] ?></td>
        <td>
            <a href="<?= BASE_URI ?>schedule/edit/<?= $schedule["id"] ?>"?>edit</a>
            <a href="<?= BASE_URI ?>schedule/delete/<?= $schedule["id"] ?>">delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>