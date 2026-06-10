<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "FILES:\n";
    print_r($_FILES);
    echo "POST:\n";
    print_r($_POST);
    exit;
}
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="image">
    <button type="submit">Upload</button>
</form>
