<?php
if (!isset($_COOKIE["userIsLoggedIn"])) {
    header("Location: ../admin.php");
}

if (isset($_GET["logout"])) {
    setcookie("userIsLoggedIn", 0, time() - 3600, "/");
    header("Location: ../admin.php");
}

require_once("../dbconfig.php");
require_once("../Product.php");
require_once("../ProductsTable.php");
$productsTable = new ProductsTable();
$selectedID = $_POST["productID"];
$result = $productsTable->getProduct($selectedID);
$row = $result->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {



    if (isset($_POST['delete'])) {
        $productsTable->deleteProduct($_POST["selectedProductID"]);
        header("Location: ./dashboard-items.php");
    }

    if (isset($_POST['update'])) {

        if (filter_var($_POST["name"], FILTER_SANITIZE_STRING) && filter_var($_POST["quantity"], FILTER_VALIDATE_INT) && filter_var($_POST["price"], FILTER_VALIDATE_INT) && filter_var($_POST["imgURL"], FILTER_VALIDATE_URL) && filter_var($_POST["imgMinURL"], FILTER_VALIDATE_URL)) {
            $updatedValues = array(
                'id' => $_POST["selectedProductID"],
                'name' => $_POST["name"],
                'quantity' => $_POST["quantity"],
                'price' => $_POST["price"],
                'imgURL' => $_POST["imgURL"],
                'imgMinURL' => $_POST["imgMinURL"],
            );
    
            $productsTable->updateProduct($updatedValues);
            header("Location: ./dashboard-items.php");
        } else {
            alert("One or more inputs are invalid");
        }
        
    }

    function alert($message)
    {
        echo "<script>alert('$message');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Čvarci.net</title>
    <link rel="stylesheet" href="../styles/dashboard-update-or-delete.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../app.js"></script>
</head>

<body>

    <nav class="navigation">
        <svg aria-label="Čvarci.net" width="195" height="43" viewBox="0 0 195 43" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect y="29.768" width="113" height="13" fill="#FFE600" />
            <path d="M12.76 37.248C10.488 37.248 8.456 36.784 6.664 35.856C4.904 34.928 3.512 33.488 2.488 31.536C1.496 29.584 1 27.088 1 24.048C1 20.88 1.528 18.304 2.584 16.32C3.64 14.336 5.064 12.88 6.856 11.952C8.68 11.024 10.744 10.56 13.048 10.56C14.36 10.56 15.624 10.704 16.84 10.992C18.056 11.248 19.048 11.568 19.816 11.952L18.52 15.456C17.752 15.168 16.856 14.896 15.832 14.64C14.808 14.384 13.848 14.256 12.952 14.256C7.896 14.256 5.368 17.504 5.368 24C5.368 27.104 5.976 29.488 7.192 31.152C8.44 32.784 10.28 33.6 12.712 33.6C14.12 33.6 15.352 33.456 16.408 33.168C17.496 32.88 18.488 32.528 19.384 32.112V35.856C18.52 36.304 17.56 36.64 16.504 36.864C15.48 37.12 14.232 37.248 12.76 37.248ZM9.784 7.68C9.368 6.944 8.808 6.16 8.104 5.328C7.4 4.464 6.664 3.616 5.896 2.784C5.128 1.952 4.456 1.232 3.88 0.624001V0H6.76C7.592 0.544001 8.456 1.2 9.352 1.968C10.248 2.736 11.096 3.552 11.896 4.416C12.76 3.552 13.64 2.736 14.536 1.968C15.432 1.2 16.296 0.544001 17.128 0H20.104V0.624001C19.496 1.232 18.792 1.952 17.992 2.784C17.224 3.616 16.472 4.464 15.736 5.328C15.032 6.16 14.488 6.944 14.104 7.68H9.784Z" fill="black" />
            <path d="M38.7663 14.1039L39.2584 11.8071H48.4225V13.2368L44.9772 14.6899L36.1881 36.768H33.3522L24.5631 14.5961L21.1178 13.9633L21.5866 11.8071H32.6256V13.2368L29.1803 14.4555L35.6491 30.9555L42.1881 14.5961L38.7663 14.1039Z" fill="black" />
            <path d="M64.5241 36.768V32.8774C64.0397 33.4555 63.4538 34.0024 62.7663 34.518C62.0788 35.0336 61.3522 35.4946 60.5866 35.9008C59.8209 36.2914 59.0475 36.5961 58.2663 36.8149C57.485 37.0336 56.7428 37.143 56.0397 37.143C55.1647 37.143 54.3444 37.0102 53.5788 36.7446C52.8131 36.4789 52.1413 36.0727 51.5631 35.5258C50.985 34.9789 50.5163 34.3227 50.1569 33.5571C49.8131 32.7914 49.6413 31.893 49.6413 30.8618C49.6413 29.268 50.0475 27.9711 50.86 26.9711C51.6881 25.9555 53.1413 25.1743 55.2194 24.6274C56.7819 24.2055 58.2897 23.8618 59.7428 23.5961C61.1959 23.3149 62.7897 23.0805 64.5241 22.893V18.9555C64.5241 18.0649 64.3913 17.3071 64.1256 16.6821C63.8756 16.0571 63.5241 15.5493 63.0709 15.1586C62.6334 14.7524 62.1178 14.4633 61.5241 14.2914C60.9303 14.1039 60.2975 14.0102 59.6256 14.0102C58.8913 14.0102 58.1413 14.0649 57.3756 14.1743C56.61 14.268 55.86 14.4399 55.1256 14.6899L53.7663 20.1508L51.2819 19.7289V13.4946C52.5319 12.9477 53.8678 12.4633 55.2897 12.0414C56.7116 11.6039 58.235 11.3852 59.86 11.3852C61.11 11.3852 62.2819 11.5102 63.3756 11.7602C64.4694 12.0102 65.4225 12.4321 66.235 13.0258C67.0475 13.6196 67.6803 14.4086 68.1334 15.393C68.6022 16.3618 68.8366 17.5649 68.8366 19.0024V33.7446L72.3053 34.5649L71.8131 36.768H64.5241ZM54.4459 30.4868C54.4459 31.2524 54.5397 31.8696 54.7272 32.3383C54.9303 32.7914 55.1959 33.1586 55.5241 33.4399C55.8678 33.7055 56.2506 33.8852 56.6725 33.9789C57.11 34.0727 57.5709 34.1196 58.0553 34.1196C58.6178 34.1196 59.2194 34.0024 59.86 33.768C60.5006 33.5336 61.1178 33.2446 61.7116 32.9008C62.3053 32.5414 62.8522 32.1352 63.3522 31.6821C63.8522 31.2289 64.2428 30.7993 64.5241 30.393V24.9086C63.5084 25.0336 62.485 25.1743 61.4538 25.3305C60.4225 25.4711 59.3991 25.6821 58.3834 25.9633C56.8834 26.3852 55.8522 26.9946 55.2897 27.7914C54.7272 28.5883 54.4459 29.4868 54.4459 30.4868Z" fill="black" />
            <path d="M93.7272 18.5805L91.2194 19.0024L89.9303 15.3696C89.8053 15.3383 89.6413 15.3227 89.4381 15.3227C89.2506 15.3227 89.0944 15.3227 88.9694 15.3227C87.9381 15.3227 86.86 15.5493 85.735 16.0024C84.6256 16.4399 83.7506 17.0258 83.11 17.7602V33.7914L87.5397 34.4711L87.0475 36.768H74.6725V35.3383L78.8444 33.8852V15.5102L74.86 14.7368L74.6256 12.6274L83.11 11.4789V15.4164C84.2038 14.2602 85.3678 13.3149 86.6022 12.5805C87.8366 11.8461 89.1569 11.4789 90.5631 11.4789C91.6413 11.4789 92.6959 11.6977 93.7272 12.1352V18.5805Z" fill="black" />
            <path d="M113.321 14.8305C111.946 14.2836 110.696 14.0102 109.571 14.0102C108.352 14.0102 107.243 14.268 106.243 14.7836C105.258 15.2993 104.415 15.9946 103.712 16.8696C103.008 17.7446 102.454 18.7914 102.048 20.0102C101.657 21.2289 101.462 22.5414 101.462 23.9477C101.462 25.2289 101.618 26.4789 101.93 27.6977C102.258 28.9164 102.758 30.0102 103.43 30.9789C104.102 31.9321 104.946 32.6977 105.962 33.2758C106.993 33.8383 108.212 34.1196 109.618 34.1196C110.712 34.1196 111.899 33.9164 113.18 33.5102C114.477 33.0883 115.626 32.5102 116.626 31.7758L117.68 33.6039C116.399 34.8227 114.985 35.7446 113.438 36.3696C111.907 36.9946 110.329 37.3071 108.704 37.3071C107.079 37.3071 105.532 37.018 104.063 36.4399C102.61 35.8618 101.329 35.018 100.219 33.9086C99.1256 32.7993 98.2584 31.4399 97.6178 29.8305C96.9772 28.2211 96.6569 26.3774 96.6569 24.2993C96.6569 22.2368 97.0163 20.4086 97.735 18.8149C98.4538 17.2211 99.4069 15.8696 100.594 14.7602C101.782 13.6508 103.141 12.8149 104.673 12.2524C106.204 11.6743 107.79 11.3852 109.43 11.3852C110.743 11.3852 112.032 11.5727 113.298 11.9477C114.579 12.3071 115.829 12.8696 117.048 13.6352V20.0102L114.657 20.5024L113.321 14.8305Z" fill="black" />
            <path d="M129.423 33.7914L133.032 34.4711L132.54 36.768H120.891V35.3383L125.11 33.8852V15.3227L121.219 14.5961L120.985 12.6274L129.423 11.4789V33.7914ZM123.516 4.47113C124.329 3.06488 125.454 1.9555 126.891 1.143C128.298 1.87738 129.368 2.9555 130.102 4.37738C129.274 5.78363 128.157 6.88519 126.751 7.68206C126.079 7.32269 125.462 6.86956 124.899 6.32269C124.337 5.76019 123.876 5.143 123.516 4.47113Z" fill="black" />
            <path d="M136.102 34.1196C136.946 32.6196 138.133 31.4555 139.665 30.6274C141.133 31.4243 142.266 32.5571 143.063 34.0258C142.204 35.5414 141.024 36.7133 139.524 37.5414C138.024 36.7758 136.883 35.6352 136.102 34.1196Z" fill="black" />
            <path d="M149.614 19.9633L159.434 32.9946V21.4985L157.173 21.0532L157.407 19.9633H163.149V20.8071L160.864 21.4985V36.768H159.434L149.614 23.7133V35.2328L151.887 35.6899L151.653 36.768H145.887V35.9243L148.173 35.2328V21.4985L145.887 21.0532L146.133 19.9633H149.614Z" fill="black" />
            <path d="M176.426 32.6664L177.68 32.9243V36.768H164.673V35.9243L166.946 35.2328V21.4985L164.673 21.0532L164.907 19.9633H177.176V23.9008L175.969 24.1469L175.208 21.2875H169.348V27.3813L173.403 27.2875L174.048 25.6821L174.891 25.9164V30.1703L174.223 30.4047L173.403 28.8227L169.348 28.7055V35.4438H175.665L176.426 32.6664Z" fill="black" />
            <path d="M180.153 24.7446L178.958 24.4985V19.9633H193.044V24.4985L191.848 24.7446L191.051 21.2875H187.243V35.2328L189.516 35.6899L189.282 36.768H182.555V35.9243L184.84 35.2328V21.2875H180.95L180.153 24.7446Z" fill="black" />
        </svg>

        <a href="../index.php">Početna</a>
        <a href="./dashboard-items.php">Proizvodi</a>
        <a href="#">Narudžbe</a>
        <a href="?logout=true">Odjava</a>
    </nav>

    <section class="update-item-container">
        <h1>Ažuriranje proizvoda</h1>

        <form class="update-item-form" method="POST">
            <p>Naziv:</p>
            <input type="text" name="name" placeholder="Unesite naziv" value="<?= htmlspecialchars($row["name"]) ?>" aria-label="Enter product name" required>

            <p>Količina:</p>
            <input type="number" min="1" name="quantity" placeholder="Unesite dostupnu količinu" value=<?= htmlspecialchars($row["quantity"] ?? 1) ?> aria-label="Enter available quantity of product" required>

            <p>Cijena [kn/kg]:</p>
            <input type="number" min="1" name="price" placeholder="Unesite cijenu" value=<?= htmlspecialchars($row["price"] ?? 50) ?> aria-label="Enter price of product (HRK per kg)" required>

            <p>URL slike:</p>
            <input type="url" name="imgURL" placeholder="Unesite url slike" value=<?= htmlspecialchars($row["imgURL"] ?? "https://i.ibb.co/QHvwgRj/cvarci-pileci.jpg") ?> aria-label="Enter image url" required>

            <p>URL slike(min):</p>
            <input type="url" name="imgMinURL" placeholder="Unesite url slike(min)" value=<?= htmlspecialchars($row["imgMinURL"] ?? "https://i.ibb.co/R9wbfQz/cvarci-pileci-min.jpg") ?> aria-label="Enter compressed image url" required>

            <input type="hidden" name="selectedProductID" value=<?= htmlspecialchars($selectedID) ?>>

            <div class="btn-container">
                <input class="btn btn-primary" name="delete" type="submit" value="Izbriši" aria-label="Click to delete the item">
                <input class="btn btn-primary" name="update" type="submit" value="Ažuriraj" aria-label="Click to update the item">
            </div>
        </form>


    </section>

</body>

</html>