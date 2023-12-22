<?php
require(__DIR__ . "/partials/nav.php");

$results = [];
$db = getDB();
$stmt = $db->prepare("SELECT id, name, description, cost, stock, image FROM Products WHERE stock > 0 LIMIT 50");
try {
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $results = $r;
    }
} catch (PDOException $e) {
    error_log(var_export($e, true));
    flash("Error fetching items", "danger");
}
?>
<script>
    function purchase(item) {
        console.log("TODO purchase item", product);
        //TODO create JS helper to update all show-balance elements
    }
</script>

<div class="container-fluid">
    <h1>Shop</h1>
    <div class="row row-cols-1 row-cols-md-5 g-4">
        <?php foreach ($results as $product) : ?>
            <div class="col">
                <div class="card bg-light">
                    <div class="card-header">
                        [Maybe Seller Name]
                    </div>
                    <?php if (se($product, "image", "", false)) : ?>
                        <img src="<?php se($product, "image"); ?>" class="card-img-top" alt="...">
                    <?php endif; ?>

                    <div class="card-body">
                        <h5 class="card-title">Name: <?php se($product, "name"); ?></h5>
                        <p class="card-text">Description: <?php se($product, "description"); ?></p>
                    </div>
                    <div class="card-footer">
                        Price: <?php se($product, "cost"); ?> | <?php se($product, "stock");?> in stock
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php se($product, "id");?>"/>
                            <input type="hidden" name="action" value="add"/>
                            <input type="number" name="desired_quantity" value="1" min="1" max="<?php se($product, "stock");?>"/>
                            <input type="submit" class="btn btn-primary" value="Add to Cart"/>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    /* Add your CSS styles here */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container-fluid {
        margin-top: 20px;
    }

    h1 {
        color: #333;
        margin-bottom: 20px;
    }

    .row-cols-1,
    .row-cols-md-5 {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .col {
        margin-bottom: 20px;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .card-header {
        background-color: #3498db;
        color: #fff;
        font-weight: bold;
        text-align: center;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        border-radius: 8px 8px 0 0;
    }

    .card-img-top {
        max-height: 200px;
        object-fit: cover;
        border-bottom: 1px solid #ddd;
    }

    .card-body {
        padding: 15px;
    }

    .card-title {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .card-text {
        color: #555;
    }

    .card-footer {
        background-color: #f9f9f9;
        padding: 15px;
        border-top: 1px solid #ddd;
        border-radius: 0 0 8px 8px;
        text-align: center;
    }

    form {
        margin-top: 10px;
    }

    input[type="number"] {
        width: 60px;
        margin-right: 10px;
    }

    .btn-primary {
        background-color: #3498db;
        color: #fff;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #2980b9;
    }
</style>
<?php
require(__DIR__ . "/partials/footer.php");
?>