<?php
    $key = "*********";
	$url_collections = "https://objecthub.keio.ac.jp/open_koh/v1/collection?api_key=" . $key;
	$json = file_get_contents($url_collections);
	$arr = json_decode($json,true);
?>
<html>
	<head>
		<meta charset="UTF-8">
        <link href="api_slot.css" type="text/css" rel="stylesheet">
	</head>

	<body>
		<h3>コレクションを選択</h3>
		<form action="#" method="post">
		<div class="cp_ipselect cp_sl03">
				<select  onchange="submit(this.form)" name="collection">
					<option value="" hidden>Choose</option>
					<?php
						for($i = 0 ; $i < $arr["count"] ; $i++){
							echo "<option value=" . $arr["data"][$i]["id"] . " id=". $arr["data"][$i]["id"] .">" . $arr["data"][$i]["collection_title"]["jp"] . "</option>";
						}
					?>
				</select>
				</div>
		</form>
		
		<?php
			$url = "https://objecthub.keio.ac.jp/open_koh/v1/collection?data_id=".$_POST['collection']."&api_key=" . $key;
			$json = file_get_contents($url);
    		$arr = json_decode($json,true);
			echo "<h4>選択中：".$arr["data"][0]["collection_title"]["jp"]."</h4>";
    		$rand_key = array_rand($arr["data"][0]["objects"], 5);
			$image_paths = array();
			$work_ids = $arr["data"][0]["objects"][$rand_key[0]]["id"].",".$arr["data"][0]["objects"][$rand_key[1]]["id"].",".$arr["data"][0]["objects"][$rand_key[2]]["id"].",".$arr["data"][0]["objects"][$rand_key[3]]["id"].",".$arr["data"][0]["objects"][$rand_key[4]]["id"];
			$url = "https://objecthub.keio.ac.jp/open_koh/v1/object?data_id=".$work_ids."&api_key=" . $key;
			$json = file_get_contents($url);
			$arr = json_decode($json, true);
			for($j = 0 ; $j < 5 ; $j++){
				$image_paths[$j] = $arr["data"][$j]["images"][0]["url"]["medium"];
			}
		?>
		<div class="slot">
			<div class="slot-frame">
				<ul class="reels">
					<li class="reel"><a href="#anchor0"><img src=<?php echo $image_paths[0];?>></a></li>
					<li class="reel"><a href="#anchor1"><img src=<?php echo $image_paths[1];?>></a></li>
					<li class="reel"><a href="#anchor0"><img src=<?php echo $image_paths[0];?>></a></li>
					<li class="reel"><a href="#anchor2"><img src=<?php echo $image_paths[2];?>></a></li>
					<li class="reel"><a href="#anchor4"><img src=<?php echo $image_paths[4];?>></a></li>
					<li class="reel"><a href="#anchor3"><img src=<?php echo $image_paths[3];?>></a></li>
					<li class="reel"><a href="#anchor0"><img src=<?php echo $image_paths[0];?>></a></li>
					<li class="reel"><a href="#anchor1"><img src=<?php echo $image_paths[1];?>></a></li>
				</ul>
				<ul class="reels">
					<li class="reel"><a href="#anchor3"><img src=<?php echo $image_paths[3];?>></a></li>
					<li class="reel"><a href="#anchor1"><img src=<?php echo $image_paths[1];?>></a></li>
					<li class="reel"><a href="#anchor4"><img src=<?php echo $image_paths[4];?>></a></li>
					<li class="reel"><a href="#anchor0"><img src=<?php echo $image_paths[0];?>></a></li>
					<li class="reel"><a href="#anchor2"><img src=<?php echo $image_paths[2];?>></a></li>
					<li class="reel"><a href="#anchor4"><img src=<?php echo $image_paths[4];?>></a></li>
					<li class="reel"><a href="#anchor3"><img src=<?php echo $image_paths[3];?>></a></li>
					<li class="reel"><a href="#anchor1"><img src=<?php echo $image_paths[1];?>></a></li>
				</ul>
				<ul class="reels">
					<li class="reel"><a href="#anchor2"><img src=<?php echo $image_paths[2];?>></a></li>
					<li class="reel"><a href="#anchor1"><img src=<?php echo $image_paths[1];?>></a></li>
					<li class="reel"><a href="#anchor3"><img src=<?php echo $image_paths[3];?>></a></li>
					<li class="reel"><a href="#anchor0"><img src=<?php echo $image_paths[0];?>></a></li>
					<li class="reel"><a href="#anchor4"><img src=<?php echo $image_paths[4];?>></a></li>
					<li class="reel"><a href="#anchor3"><img src=<?php echo $image_paths[3];?>></a></li>
					<li class="reel"><a href="#anchor2"><img src=<?php echo $image_paths[2];?>></a></li>
					<li class="reel"><a href="#anchor1"><img src=<?php echo $image_paths[1];?>></a></li>
				</ul>
			</div>
		</div>
		<div>
			<button type="button" class="btn-start cp_button02">Start</button>
			<button type="button" class="btn-reset cp_button02" disabled="true">Reset</button>
		</div>
		<div>
			<button type="button" class="btn-stop cp_button11" data-val="0" disabled="true">Stop 1</button>
			<button type="button" class="btn-stop cp_button11" data-val="1" disabled="true">Stop 2</button>
			<button type="button" class="btn-stop cp_button11" data-val="2" disabled="true">Stop 3</button>
		</div>
		<div class="works">
        <?php
            for($j = 0 ; $j < 5 ; $j ++){
				echo '<div class="card pic-image" id="anchor'.$j.'">';
                echo '<img class="card-image" src="'.$arr["data"][$j]["images"][0]["url"]["large"].'" alt="">';
				echo '<div class="card-box">';
                echo '<h2 class="card-title">'.$arr["data"][$j]["title"]["jp"].'</h2>';
                echo '<p class="card-description"><a href='.$arr["data"][$j]["kohurl"]["jp"].' class="cp_textlink06">KOHでもっと詳しく見る</a></p>';
                echo '</div>';
				echo '</div>';
            }
        ?>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="api_slot.js"></script>
	</body>
</html>
