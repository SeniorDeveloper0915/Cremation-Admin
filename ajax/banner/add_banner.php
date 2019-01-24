<?php
    session_start();
    include '../../config/config.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['username'])) {
    header('location:index.php');
}

    $output = [];

    $input = [];
    $input['bannertitle']       = post('bannertitle');
    $input['url']               = post('url');
    $input['sort']              = post('sort');
    $output                     = responseFormErrors($input);

if ($_POST) {
        // When no image is selected
        if ($_FILES['bannerimg']['name'] == '') {
            $query      = 'INSERT INTO `banner` SET Banner_Title = ?, URL=?, Sort=?';
            $parameters = array($input['bannertitle'], $input['url'], $input['sort']);

        } else {

            $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');
            $imageName = generateNewFileName($_FILES['bannerimg']);
            $ext               = end((explode('.', $_FILES['bannerimg']['name'])));
            $path              = "../../images/banner/" . $imageName;
            $tmp               = $_FILES['bannerimg']['tmp_name'];

            // Check if uploaded image of the format specified
            if (!in_array($ext, $allowedFileTypes)) {

                $output = responseError('You uploaded wrong image format');
                echo json_encode($output);
                exit();

            } else {
                $moved = move_uploaded_file($tmp, $path);
                // Resize the uploaded avatar
                // resize($path, '150px', '150px', $ext);
                
                // Insert into database
                $query      = 'INSERT INTO `banner` SET Banner_Title = ?, URL=?, Banner_Img=?, Sort=?';
                $parameters = array($input['bannertitle'], $input['url'], $imageName, $input['sort']);

            }
        }
        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $output = responseSuccess('New Banner added successfully');
}
echo json_encode($output);
?>