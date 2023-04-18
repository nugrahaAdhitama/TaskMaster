<h1>Add Task</h1>

<form action="" method="post">
    <label for="task">Judul:</label>
    <input type="text" name="judul" id="judul" required autofocus><br><br>
    <label for="deadline">Deadline</label>
    <input type="text" name="deadline" id="deadline" required><br><br>
    <label for="tipe">Tipe</label>
    <input type="text" name="tipe" id="tipe" required><br><br>
    <label for="status">Status</label>
    <input type="text" name="status" id="status" value="Sedang Dikerjakan"><br><br>
    <label for="deskripsi">Deskripsi</label>
    <input type="text" name="deskripsi" id="deskripsi"><br><br>
    <button type="submit" name="submit">Add</button>
</form>

<a href="<?= BASE_URI ?>task">Back to Task</a>