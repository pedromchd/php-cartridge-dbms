<?php
session_start();

$userID = $_SESSION['user_id'];
$uname = $_SESSION['username'];

$gameID = $_POST['id'];

$db = new mysqli('localhost', 'root', '', 'library');
$stmt = $db->prepare('SELECT * FROM game WHERE id = ?');
$stmt->bind_param('s', $gameID);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Insert new - Querty Library</title>
  <link rel="stylesheet" href="/css/styles.css">
  <link rel="icon" href="/img/joystick-32x32.png" type="image/x-icon">
  <script src="script.js" defer></script>
</head>

<body class="bg-[url(/img/zeal.png)] bg-cover bg-right-bottom">
  <main class="h-screen grid grid-cols-3 grid-rows-3 place-items-center">
    <div class="col-span-2 border-2 [border-style:outset] outline-1 [outline-style:outset]">
      <section class="p-0.5 min-w-[31rem] bg-[#ccc]">
        <header class="px-1 bg-gradient-to-r from-[#009] to-[#09f] flex items-center justify-between">
          <h1 class="font-mono text-white">Querty Library</h1>
          <button class="p-0.5 bg-[#ccc] border-2 [border-style:outset] outline-1 [outline-style:outset]">
            <svg width="10" height="10" viewBox="0 0 100 100">
              <path d="M 10 10 L 90 90" stroke="#000" stroke-width="20" stroke-linecap="round" />
              <path d="M 90 10 L 10 90" stroke="#000" stroke-width="20" stroke-linecap="round" />
            </svg>
          </button>
        </header>
        <div class="p-4 space-x-5 flex justify-between">
          <div><img src="/img/joystick-48x48.png" alt=""></div>
          <article class="flex-grow">
            <p>Welcome to Querty Library, <?= $uname ?>!</p>
            <p>Add, edit or delete your game records.</p>
          </article>
          <div class="space-y-3 font-mono">
            <a href="/auth/logout.php" class="block">
              <button class="w-20 bg-[#ccc] border-2 [border-style:outset] outline-1 [outline-style:outset]">
                Logout
              </button>
            </a>
          </div>
        </div>
      </section>
    </div>
    <div class="row-start-2 col-span-2 row-span-2 border-2 [border-style:outset] outline-1 [outline-style:outset]">
      <section class="p-0.5 min-w-[31rem] bg-[#ccc]">
        <header class="px-1 bg-gradient-to-r from-[#009] to-[#09f] flex items-center justify-between">
          <div><img src="/img/devices-16x16.png" alt=""></div>
          <h1 class="ml-1 font-mono text-white flex-grow">Add new entry</h1>
          <button class="p-0.5 bg-[#ccc] border-2 [border-style:outset] outline-1 [outline-style:outset]">
            <svg width="10" height="10" viewBox="0 0 100 100">
              <path d="M 10 10 L 90 90" stroke="#000" stroke-width="20" stroke-linecap="round" />
              <path d="M 90 10 L 10 90" stroke="#000" stroke-width="20" stroke-linecap="round" />
            </svg>
          </button>
        </header>
        <div class="p-4 space-x-5 flex justify-between">
          <article class="flex-grow">
            <p>Please fill in this form to add your game data.</p>
            <form name="editEntry" id="editEntry" action="edit_data.php" method="post" enctype="multipart/form-data" class="mt-3 space-y-3">
              <div class="flex justify-between">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="<?= $row['name'] ?>" class="w-[70%] px-1 outline-1 [outline-style:inset]" required>
              </div>
              <div class="flex justify-between">
                <label for="year">Release year:</label>
                <input type="number" name="year" id="year" value="<?= $row['year'] ?>" class="w-[70%] px-1 outline-1 [outline-style:inset]" required>
              </div>
              <div class="flex justify-between">
                <label for="system">System:</label>
                <input type="text" name="system" id="system" value="<?= $row['system'] ?>" class="w-[70%] px-1 outline-1 [outline-style:inset]" required>
              </div>
              <div class="flex justify-between">
                <label for="developer">Developer:</label>
                <input type="text" name="developer" id="developer" value="<?= $row['developer'] ?>" class="w-[70%] px-1 outline-1 [outline-style:inset]" required>
              </div>
              <div class="flex justify-between">
                <label for="cover">Cover:</label>
                <input type="file" name="cover" id="cover" class="w-[70%]">
              </div>
              <div class="hidden">
                <input type="hidden" name="game_id" value=<?= $gameID ?>>
              </div>
            </form>
          </article>
          <div class="space-y-3 font-mono flex flex-col">
            <p>Preview:</p>
            <div id="thumbnail" class="flex-grow border border-dashed border-black bg-[#fff] bg-no-repeat bg-center bg-contain" style="background-image: url(<?= $row['cover'] ?>);"></div>
            <div>
              <button form="editEntry" class="w-20 bg-[#ccc] border-2 [border-style:outset] outline-1 [outline-style:outset]">
                Submit
              </button>
              <a href="index.php" class="">
                <button class="w-20 bg-[#ccc] border-2 [border-style:outset] outline-1 [outline-style:outset]">
                  Cancel
                </button>
              </a>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>
</body>

</html>