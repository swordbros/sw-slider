      <?php if(isset($this->items) && !empty($this->items)):?>
<title>jQuery Acarousel.js Cover Flow Style Carousel Advanced Example</title>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.0/normalize.min.css" rel="stylesheet" type="text/css">
<style>
	body { background-color: #f7f7f7; }
	#content { margin: 150px auto; max-width: 760px; text-align: center; }
#carousel_container {
	width: 95%;
	max-width: 600px;
	height: 300px;
	margin: 0 auto;
	position: relative;
	overflow: hidden;
}
#carousel {
	width: 600px;
	height: 300px;
	margin: 0;
	padding: 0;
	position: absolute;
	list-style-type: none;
}
#carousel li {
	position: absolute;
	margin: 0;
	padding: 0;
	float: left;
}
#carousel li img {
	width: 100%;
	height: 100%;
	box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
}

#c1 {
	width: 300px;
	height: 250px;
	left: 150px;
	top: 25px;
	z-index: 3;
}
#c2 {
	width: 240px;
	height: 200px;
	left: 300px;
	top: 50px;
	z-index: 2;
}
#c3 {
	width: 180px;
	height: 150px;
	left: 420px;
	top: 75px;
	z-index: 1;
}
#x1 {
	width: 120px;
	height: 100px;
	left: 600px;
	top: 100px;
}
#x2 {
	width: 120px;
	height: 100px;
	left: -120px;
	top: 100px;
}
#c4 {
	width: 180px;
	height: 150px;
	left: 0px;
	top: 75px;
	z-index: 1;
}
#c5 {
	width: 240px;
	height: 200px;
	left: 60px;
	top: 50px;
	z-index: 2;
}

.move img {
	width: 50px;
	height: 30px;
}
.move.active img {
	border: 3px solid #5a5;
}

#move_mark {
	width: 95%;
	max-width: 500px;
	margin: 5px auto;
	position: relative;
	bottom: 0;
    text-align: center;
}
#move_mark a {
	color: #666;
	font-size: 20px;
	font-weight: bold;
	text-decoration: none;
}
#move_mark a.active, #move_mark a:hover {
	color: #333;
}
#move_back {
	margin: 0 10px;
	position: absolute;
	bottom: 0;
	left: 0;
}
#move_next {
	margin: 0 10px;
	position: absolute;
	bottom: 0;
	right: 0;
}
</style>

<script>
window.addEventListener("load", function(){
    $.getScript("https://www.jqueryscript.net/demo/cover-flow-acarousel/jquery.acarousel.min.js", function(){
	var len = $("#carousel").children().length;
	var acarousel = $("#carousel").acarousel({
		moveStep: function (elem, index, pos_index, t) {
			if (pos_index >= 3 && pos_index < len - 3 || pos_index == len - 3 && t == 0) {
				//elem.hide();
			}
		}
	});

	changeActive();

	$("#carousel li a").click(function() {
		var move = acarousel.moveByElem($(this).parent());
		changeActive(move);
		return false;
	});

	$("#move_back").click(function () {
		var move = acarousel.move(1);
		changeActive(move);
		return false;
	});

	$("#move_next").click(function () {
		var move = acarousel.move(-1);
		changeActive(move);
		return false;
	});

	$(".move").click(function () {

		var pos = acarousel.getPos();
		pos = pos.index % 5 + pos.point;
		pos = parseInt($(".move").index(this)) - pos;

		var diff1 = Math.abs(pos) % 5 * (pos < 0 ? 1 : -1);
		var diff2 = (10 - (Math.abs(pos) + 5)) % 5 * (pos < 0 ? -1 : 1);

		move = acarousel.move(Math.abs(diff1) < Math.abs(diff2) ? diff1 : diff2);
		changeActive(move);
		return false;
	});

	function changeActive(move) {
		var index = acarousel.getPos(move).index % 5;
		$(".move").removeClass("active").eq(index).addClass("active");
	}

	$(window).resize(function () {
		var parent = $("#carousel_container");
		var self = $("#carousel");
		self.css({
			left: parent.width() / 2 - self.width() / 2
			, top: parent.height() / 2 - self.height() / 2
		});
	}).trigger("resize");

    });        
});
</script>
<div class="main_banner" >
		<div id="carousel_container">
			<ul id="carousel">
      <?php foreach($this->items as $key=>$item){?>
				<li id="c<?=($key+1)?>"><a href="#"><img src="<?=asset($item['image_url'])?>" alt="<?=$item['image_url']?>"></a></li>
      <?php } ?>
			</ul>
		</div>
		<div id="move_mark">
      <?php foreach($this->items as $key=>$item){?>
			<a class="move" href="#"><img src="<?=asset($item['image_url'])?>"></a>
      <?php } ?>
			<div id="move_back"><a href="#">❰</a></div>
			<div id="move_next"><a href="#">❱</a></div>
		</div>

</div>
      <?php else: ?>
<!-- Slider Image Not Found -->
      <?php endif; ?>
