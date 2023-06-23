<?php
include 'function.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM patientdet ORDER BY firstName LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
$num_contacts = $pdo->query('SELECT COUNT(*) FROM patientdet')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Details</h2>
	<a href="create.php" class="create-contact">Create Contact</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>FirstName</td>
                <td>LastName</td>

                <td>Gender</td>
                <td>Email</td>
                <td>Password</td>
                <td>number</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?=$contact['ID']?></td>
                <td><?=$contact['firstName']?></td>
                <td><?=$contact['lastName']?></td>
                <td><?=$contact['gender']?></td>

                <td><?=$contact['email']?></td>
                <td><?=$contact['password']?></td>
                <td><?=$contact['number']?></td>
   
                <td class="actions">
                    <a href="update.php?ID=<?=$contact['ID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?ID=<?=$contact['ID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
