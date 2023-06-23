<?php
include 'function.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['ID'])) {
    if (!empty($_POST)) {
            // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['ID']) && !empty($_POST['ID']) && $_POST['ID'] != 'auto' ? $_POST['ID'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $lastName = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $number = isset($_POST['number']) ? $_POST['number'] : '';
 
    // Insert new record into the contacts table
    
    $stmt = $pdo->prepare('UPDATE patientdet SET ID = ?, firstName = ?, lastName=?,gender=?, email = ?, password = ?, number = ?  WHERE id = ?');
    $stmt->execute([$id, $firstName,$lastName, $gender, $email, $password, $number]);
    // Output message
    $msg = 'Created Successfully!';


        
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM patientdet WHERE ID = ?');
    $stmt->execute([$_GET['ID']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<<h2>Update Contact #<?=$contact['ID']?></h2>
    <form action="update.php?ID=<?=$contact['ID']?>" method="post">

        <label for="ID">ID</label>
        <input type="text" name="ID" placeholder="26" value="auto" id="ID">
        <label for="firstname">firstname</label>
        <input type="text" name="firstname" placeholder="John" id="firstName">
        <label for="lastname">lastname</label>
        <input type="text" name="lastname" placeholder="Doe" id="lastName">
        <label for="gender">gender</label>
        <input type="text" name="gender" placeholder="Male" id="gender">
        <label for="phone">email</label>
        <input type="text" name="phone" placeholder="2025550143" id="email">
        <label for="password">Password</label>
        <input type="text" name="password" placeholder="1234" id="password">
        <label for="number">Number</label>
        <input type="text" name="number" placeholder="0722000000" id="number">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>