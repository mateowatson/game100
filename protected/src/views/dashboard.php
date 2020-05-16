<?php require_once('partials/header.php'); ?>
<h1>Dashboard</h1>
<p>Logged in as <?php echo $SESSION['username']; ?></p>
<form action="/logout" method="POST">
    <input type="text" name="csrf" id="csrf" value="<?php echo $SESSION['csrf']; ?>" hidden>
    <input type="submit" name="submit" value="Log Out">
</form><br>

<h2>Create Game</h2>
<form action="/create-game" method="POST">
    <input type="text" name="csrf" id="csrf" value="<?php echo $SESSION['csrf']; ?>" hidden>
    <label>Game Type:<br>
        <select name="game-type">
            <option value="hangman">Hangman</option>
        </select>
    </label><br><br>
    <input type="submit" name="submit" value="Create Game">
</form>

<h2>Pending Invites</h2>

<h2>Games in progress</h2>
<?php require_once('partials/footer.php');