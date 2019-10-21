<?php
$connect = mysqli_connect("localhost", "root", "", "peacefoundation");
if(isset($_POST["query"]))
{
    $output = '';
    $query = "SELECT * FROM individualmember WHERE firstname LIKE '%".$_POST["query"]."%'";
    $result = mysqli_query($connect, $query);
    $output = '<ul class="list-unstyled">';
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result))
        {
            $output .= '<li>'.$row['FirstName'].'</li>';
        }
    }
    else
    {
        $output .= '<li>FirstName Not Found</li>';
    }
    $output .= '</ul>';
    echo $output;
}
?>
