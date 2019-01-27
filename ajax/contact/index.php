<?php
    session_start();
    include '../../config/index.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['admin'])) {
    header('location:../../index.php');
}

    $output = [];

    $input = [];
    $contactId                          = post('id');
    $input['information']               = post('information');
    $output                             = responseFormErrors($input);

if ($_POST) {

    if ($contactId == '') 
    {
        if ($_FILES['contactimg']['name'] == '') {
            $query      = 'INSERT INTO `contact` SET Information = ?';
            $parameters = array($input['information']);

        } else {
            $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');
            $imageName = generateNewFileName($_FILES['contactimg']);
            $ext               = end((explode('.', $_FILES['contactimg']['name'])));
            $path              = "../../images/contact/" . $imageName;
            $tmp               = $_FILES['contactimg']['tmp_name'];

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
                $query      = 'INSERT INTO `contact` SET Information = ?, Contact_Img = ?';
                $parameters = array($input['information'], $imageName);
            }
        }
        $statement = $db->prepare($query);
        $statement->execute($parameters);
        $output = responseSuccess('New Contact Us added successfully');
    }
    else 
    {
        if ($_FILES['contactimg']['name'] == '') {
            $query      = 'UPDATE `contact` SET Information = ? where id = ?' ;
            $parameters = array($input['information'], $contactId);

        } else {

            $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');

            $imageName = generateNewFileName($_FILES['contactimg']);

            $ext               = end((explode('.', $_FILES['contactimg']['name'])));
            $path              = "../../images/contact/" . $imageName;
            $tmp               = $_FILES['contactimg']['tmp_name'];

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
                $query      = 'UPDATE `contact` SET Information = ?, Contact_Img=? where id = ?';
                $parameters = array($input['information'], $imageName, $contactId);
            }
        }
        $statement = $db->prepare($query);
        $statement->execute($parameters);
        $output = responseSuccess('New Contact Us added successfully');
    }
}
echo json_encode($output);
?>