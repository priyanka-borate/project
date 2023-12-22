<?php
require(__DIR__ . "/partials/nav.php");
//If user isn't logged in, they cannot access cart features
if (!is_logged_in(false)) {
    flash("Please log in to or register account to access cart features", "warning");
    die(header("Location: $BASE_PATH" . "/login.php"));
}
//if no query parameter redirect to home page
if (!isset($_GET["name"])) {
    die(header("Location: $BASE_PATH" . "/home.php"));
} //Adds to cart
else {
    $name = $_GET["name"];
    $db = getDB();
    //get product details using name
    $stmt1 = $db->prepare("SELECT id, unit_price FROM Products WHERE name=:name");
    try {
        $stmt1->execute([":name" => $name]);
        $product_info = $stmt1->fetch(PDO::FETCH_ASSOC);
        $product_id = $product_info["id"];
        $unit_price = $product_info["unit_price"];
        $user_id = get_user_id();
        //insert product into cart
        $stmt2 = $db->prepare("INSERT INTO Cart (product_id, user_id, unit_price) VALUES (:prod_id, :user_id, :price)");
        try {
            $stmt2->execute([":prod_id"=>$product_id, "user_id"=>$user_id, ":price"=>$unit_price]);
            flash("Successfully added $name to cart");
        } catch (PDOException $e) {
            flash("An unknown error occurred, please try again later", "warning");
            error_log(var_export($e->errorInfo, true));
        }
    } catch (PDOException $e) {
        flash("An unknown error occurred, please try again later", "warning");
        error_log(var_export($e->errorInfo, true));
    }
}
</script>
<table class="table table-striped">
    <thead>
    </thead>
    <tbody>
        <?php if (empty($results)) : ?>
            <tr>
                <td colspan="100%">Cart is empty</td>
            </tr>
        <?php else : ?>
            <?php foreach ($results as $result) : ?>
                <?php $subtotal = se($result, "unit_price", "", false) * se($result, "desired_quantity", "", false); ?>
                <?php $total += $subtotal ?>
                <tr>
                    <th><a class="text-decoration-none text-dark" href="more_details.php?name=<?php se($result, "name"); ?>"><?php se($result, "name"); ?></a></th>
                    <?php if (has_role("Admin") || has_role("Shop Owner")) : ?>
                        <td><a href="edit_item.php?name=<?php se($result, "name"); ?>">
                                <div class="btn btn-secondary">Edit</div>
                            </a></td>
                    <?php endif; ?>
                    <th>$<?php se($result, "unit_price"); ?></th>
                        <th>
                            <form method="post" onsubmit="return validate(this)">
                                <input class="" name="quantity" type="number" min="0" value="<?php se($result, "desired_quantity"); ?>">
                                <input type="hidden" name="id" value="<?php se($result, "id"); ?>">
                                <input class="btn btn-primary" type="Submit" value="Update">
                            </form>
                        </th>
                    <th>
                        <form method="post">
                            <input type="hidden" name="remove-id" value="<?php se($result, "id"); ?>">
                            <input class="btn btn-danger" type="Submit" value="Remove">
                        </form>
                    </th>
                    <th>Subtotal: $<?php echo (se($subtotal)); ?></th>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<div id="total-label">Total: $<?php se($total); ?></div>
<form method="post">
    <input type="hidden" name="remove-all" value="true">
    <input id="cart-remove-all" class="btn btn-danger" type="Submit" value="Delete All Cart Items">
</form>
<?php
require(__DIR__ . "/partials/footer.php");
?>
