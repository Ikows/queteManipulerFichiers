<?php include('inc/head.php'); ?>

<?php
//Editing files
if (isset($_POST['content']))
{
    $iko = $_GET['f'];
    $open = fopen($iko, "w");
    fwrite($open, $_POST['content']);
    fclose($open);
}

//Delete files
if (isset($_GET['d']))
{
    unlink($_GET['d']);
}


//function to access to the file recursively
function getDirContents($dir, &$results = array()){
    $files = scandir($dir);

    foreach($files as $key => $value){
        $path = $dir.DIRECTORY_SEPARATOR.$value;
        if(!is_dir($path)) {
            $results[] = $path;
        } else if($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }
    return $results;
}

//Displaying files
$files = getDirContents("files");
foreach ($files as $value)
{
    if (strpos($value, ".jpg"))
    {
        echo '<p style="display: inline">' . $value . '</p>-------------------- <a href="?d='.$value.'" style="color: red;">DELETE THIS FILE</a><br>';
    } elseif (strpos($value, "."))
    {
        echo '<a href="?f='.$value.'">' . $value . '</a>-------------------- <a href="?d='.$value.'" style="color: red;">DELETE THIS FILE</a><br>';
    }
}

echo '<br><hr><br>';
?>

<?php
//Displaying content of file in textarea
if (isset($_GET['f']))
{
    $file = $_GET['f'];
    $content = file_get_contents($file);
}



?>

<!--Form for editing and deleting files -->
<form method="POST" action="">
    <textarea style="width: 100%; height: 300px;" name="content"><?php if (isset($_GET['f'])) echo $content?></textarea>
    <input style="color: #181818; float: left" type="submit" value="Edit file">
</form>



<?php include('inc/foot.php'); ?>