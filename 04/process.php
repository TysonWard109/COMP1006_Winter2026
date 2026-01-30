<?php
require "includes/header.php";
//How to access form data
// We used $_POST to grab information but it is not very secure as you can access the html from the inspect element and alter it to submit the form without validation
// $firstName = $_POST['first_name'];
// $lastName = $_POST['last_name'];
// $adress = $_POST['adress'];
// $email = $_POST['email'];
// $items = $_POST['items'];


$firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
$lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);

$items = $_POST['items'] ?? [];

//validation time- server side

$errors = [];
// required text fields
if($firstName === null || $firstName ===''){
    $errors[] ="First Name is required";
}
if($lastName === null || $lastName ===''){
    $errors[] ="Last Name is required";
}

//email validation 

if ($email === null ||$email === ''){
    $errors[] = "Email is Required";
} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors[] = "Email must be a valid email";
}

// Address validation
if($address === null || $address ===''){
    $errors[] ="Address is required";
}
$itemsOrdered = [];
//Check that the order quantity if a number

foreach($items as $items => $quantity){
    if(filter_var($quantity, FILTER_VALIDATE_INT)!==false && $quantity > 0){
        $itemsOrdered[$item] = $quantity;
    }
}
if(count($itemsOrdered) === 0){
    $errors[] = "Please order at least one item";
}

//Loop through the error messages

if(!empty($errors))



foreach ($errors as $error):?>
<?php endforeach;
//Stop the script from executing 
exit;
?>

<main>
    <?php echo "<h2> Thanks for your order " . $firstName. "</h2>" ?>

    <h3> Items Ordered </h3>
    <ul>
    <!-- //Create a for each loop -->
    <?php foreach($items as $item => $quantity): ?>
        <li><?php echo $item ?> -<?php echo $quantity ?> </li>
    <?php endforeach; ?>
    </ul>
</main>

<!-- // send email using mail function 
mail($to, $subject, $message); -->
<?php
require "includes/footer.php";
?>