PHPagination
============
PHP MySQL Pagination Class
===============================

Usage:

<?
include('PHPagination.php');

	if(isset($_GET['p'])) {
		$page_num = addslashes($_GET['p']);
	} else {
		$page_num = 1;
	}

$pages = new pagination(1000,1000, $page_num, 'some_table', "SELECT * FROM some_table WHERE column=1 AND column2
LIKE '%Email%' ", 'ASC', 'id');

$page_array = $pages->execute();
$arr = mysql_fetch_array(mysql_query($page_array['query']), MYSQL_ASSOC);

	if(!is_array($arr) || !is_array($page_array)) {
		exit("There was an error, please check your queries");
	}
?>

Showing results for page <?=$page_num;?>:<br>
<div>
<? 
	foreach($arr as $val) {
		echo "Result: {$val['id']}&emsp{$val['name']}&emsp{$val['email']}";
	}

?>
</div>

List Format: <br>
<ul>
<?
$x = 0;
	while($x < $page_array['pages']) {
		echo "<li><a href='url?page={$x}'>Page {$x}</a></li>";
		$x++;
	}
?>
</ul>

Select Page: <br>
<select>
<? 
$y = 0;
	while($y < $page_array['pages']) {
		echo "<option>{$y}</option>";
		$y++;
	}
?>
</select> 

of <?=$page_array['pages'];?> pages

<? 
	if(isset($pages->link)) {
		@mysql_close($pages->link);
	}
?>
