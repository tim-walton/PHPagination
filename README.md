PHPagination
============

PHP MySQL Pagination Class

===============================

Usage:
<?
include('PHPagination.php');
$pages = new pagination(1000,1000, $p, 'some_table', "SELECT * FROM some_table WHERE column=1 AND column2 LIKE '%Email%/", 'ASC', 'id');

$page_array = $pages->execute();

$arr = mysql_fetch_array(mysql_query($page_array['query']), MYSQL_ASSOC);
?>

List Format: <br>
<ul>
<?
$x = 0;
while($x < $page_array['pages']) {
echo "<li><a href='url?page={$s}'>Page {$x}</li>";
}
?>
</ul>

Select Page: <br>
<select>
<? 
$y = 0;
while($y < $page_array['pages']) {
echo "<option>{$y}</option>";
}
?>
</select>

