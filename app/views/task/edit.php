<h1>Edit Task</h1>

<form action="" method="post">
    <label for="judul">Judul:</label>
    <input type="text" name="judul" id="judul" value="<?= $task["judul"] ?>" required autofocus><br><br>
    <label for="deadline">Deadline:</label>
    <input type="text" name="deadline" id="deadline" value="<?= $task["deadline"] ?>" required><br><br>
    <label for="status">Status:</label>
    <input type="text" name="status" id="status" value="<?= $task["status"] ?>" required><br><br>
    <label for="tipe">Tipe:</label>
    <input type="text" name="tipe" id="tipe" value="<?= $task["tipe"] ?>" required><br><br>
    <label for="deskripsi">Deskripsi:</label>
    <input type="text" name="deskripsi" id="deskripsi" value="<?= $task["deskripsi"] ?>"><br><br>
    <button type="submit" name="submit">Save</button>
</form>

<a href="<?= BASE_URI ?>schedule">Back to Schedule</a>