<?php 

require(dirname(__FILE__) . '/../controller.php');

//Permissions Check
if($_GET['bID']) {
	$c = Page::getByID($_GET['cID']);
	$a = Area::get($c, $_GET['arHandle']);
		
	//edit survey mode
	$b = Block::getByID($_GET['bID'],$c, $a);
	
	$controller = new PageListBlockController($b);
	$rssUrl = $controller->getRssUrl($b);
	
	$bp = new Permissions($b);
	if( $bp->canRead() && $controller->rss) {

		$cArray = $controller->getPages();
		$nh = Loader::helper('navigation');

		header('Content-type: text/xml');
		echo "<?php xml version=\"1.0\"?>\n";

?>
		<rss version="2.0">
		  <channel>
			<title><?php echo $controller->rssTitle?></title>
			<link><?php echo htmlspecialchars($rssUrl)?></link>
			<description><?php echo $controller->rssDescription?></description> 
<?php 
		for ($i = 0; $i < count($cArray); $i++ ) {
			$cobj = $cArray[$i]; 
			$title = $cobj->getCollectionName(); ?>
			<item>
			  <title><?php echo htmlspecialchars($title);?></title>
			  <link>
				<?php echo  BASE_URL.DIR_REL.$nh->getLinkToCollection($cobj) ?>		  
			  </link>
			  <description><?php echo htmlspecialchars(strip_tags($cobj->getCollectionDescription()))."....";?></description>
			  <pubDate><?php echo $cobj->getCollectionDateAdded()?></pubDate>
			</item>
		<?php  } ?>
     		 </channel>
		</rss>
		
<?php 	} else { 	
		$v = View::getInstance();
		$v->renderError('Permission Denied',"You don't have permission to access this RSS feed");
		exit;
	}
			
} else {
	echo "You don't have permission to access this RSS feed";
}
exit;






